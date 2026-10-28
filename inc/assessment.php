<?php
/**
 * AI Readiness Assessment: REST endpoints that receive results and report
 * requests from assets/js/assessment.js, stored as private "Assessments".
 *
 * Routes (POST, JSON):
 *   /wp-json/cypher-one/v1/assessment/request  — "Let's dive deeper" form on the snapshot screen
 *   /wp-json/cypher-one/v1/assessment/results  — full results (only if the full report screen is used)
 *   /wp-json/cypher-one/v1/assessment/leads    — "Book a full review" email (full report screen)
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

require_once C1_DIR . '/inc/assessment-files.php';

/**
 * Register the private Assessment post type.
 */
function c1_register_assessments() {
	register_post_type(
		'c1_assessment',
		array(
			'labels'          => array(
				'name'          => __( 'Assessments', 'cypher-one' ),
				'singular_name' => __( 'Assessment', 'cypher-one' ),
				'menu_name'     => __( 'Assessments', 'cypher-one' ),
				'all_items'     => __( 'All assessments', 'cypher-one' ),
				'edit_item'     => __( 'Assessment', 'cypher-one' ),
				'search_items'  => __( 'Search assessments', 'cypher-one' ),
				'not_found'     => __( 'No assessments yet.', 'cypher-one' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-chart-bar',
			'menu_position'   => 27,
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'c1_register_assessments' );

/**
 * Register the REST routes.
 */
function c1_register_assessment_routes() {
	$common = array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
	);
	register_rest_route( 'cypher-one/v1', '/assessment/results', array_merge( $common, array( 'callback' => 'c1_rest_results' ) ) );
	register_rest_route( 'cypher-one/v1', '/assessment/leads', array_merge( $common, array( 'callback' => 'c1_rest_leads' ) ) );
	register_rest_route( 'cypher-one/v1', '/assessment/request', array_merge( $common, array( 'callback' => 'c1_rest_request' ) ) );
}
add_action( 'rest_api_init', 'c1_register_assessment_routes' );

/**
 * Shared guards: feature switch, payload size, rate limit, assessment id.
 *
 * @param WP_REST_Request $request Request.
 * @return array|WP_Error Decoded body.
 */
function c1_assessment_guard( $request ) {
	if ( ! c1_opt( 'assess_store' ) ) {
		return new WP_Error( 'c1_disabled', __( 'Saving is turned off.', 'cypher-one' ), array( 'status' => 403 ) );
	}
	if ( strlen( (string) $request->get_body() ) > 200000 ) {
		return new WP_Error( 'c1_too_large', __( 'Payload too large.', 'cypher-one' ), array( 'status' => 413 ) );
	}
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rkey  = 'c1_arl_' . md5( $ip );
	$count = (int) get_transient( $rkey );
	if ( $count >= 30 ) {
		return new WP_Error( 'c1_rate', __( 'Too many requests.', 'cypher-one' ), array( 'status' => 429 ) );
	}
	set_transient( $rkey, $count + 1, HOUR_IN_SECONDS );

	$body = $request->get_json_params();
	if ( ! is_array( $body ) ) {
		return new WP_Error( 'c1_bad', __( 'Invalid request.', 'cypher-one' ), array( 'status' => 400 ) );
	}
	$aid = isset( $body['assessment_id'] ) ? preg_replace( '/[^a-zA-Z0-9\-]/', '', (string) $body['assessment_id'] ) : '';
	if ( '' === $aid || strlen( $aid ) > 64 ) {
		return new WP_Error( 'c1_bad', __( 'Invalid request.', 'cypher-one' ), array( 'status' => 400 ) );
	}
	$body['assessment_id'] = $aid;
	return $body;
}

/**
 * Find the assessment post for an assessment id.
 *
 * @param string $aid Assessment id.
 * @return int
 */
function c1_assessment_post( $aid ) {
	$ids = get_posts(
		array(
			'post_type'      => 'c1_assessment',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_c1_aid', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => $aid, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);
	return $ids ? (int) $ids[0] : 0;
}

/**
 * Recursively sanitise a JSON payload.
 *
 * @param mixed $value Value.
 * @return mixed
 */
function c1_clean_payload( $value ) {
	if ( is_array( $value ) ) {
		$out = array();
		foreach ( $value as $k => $v ) {
			$out[ is_int( $k ) ? $k : sanitize_key( $k ) ] = c1_clean_payload( $v );
		}
		return $out;
	}
	if ( is_bool( $value ) || is_int( $value ) || is_float( $value ) || null === $value ) {
		return $value;
	}
	return sanitize_text_field( (string) $value );
}

/**
 * Extract the respondent state array for an assessment post.
 *
 * @param int   $pid      Assessment post ID.
 * @param array $fallback Fallback state array.
 * @return array
 */
function c1_get_assessment_state( $pid, $fallback = array() ) {
	if ( ! empty( $fallback ) && is_array( $fallback ) ) {
		return $fallback;
	}
	$raw_state = get_post_meta( $pid, '_c1_state', true );
	if ( $raw_state ) {
		$decoded = json_decode( $raw_state, true );
		if ( is_array( $decoded ) ) {
			return isset( $decoded['state'] ) && is_array( $decoded['state'] ) ? $decoded['state'] : $decoded;
		}
	}
	$raw_res = get_post_meta( $pid, '_c1_results', true );
	if ( $raw_res ) {
		$res = json_decode( $raw_res, true );
		if ( is_array( $res ) ) {
			if ( isset( $res['state'] ) && is_array( $res['state'] ) ) {
				return $res['state'];
			}
			return array(
				'country'     => isset( $res['country'] ) ? $res['country'] : '',
				'size'        => isset( $res['size_band'] ) ? $res['size_band'] : '',
				'role'        => isset( $res['role'] ) ? $res['role'] : '',
				'sectors'     => isset( $res['sectors'] ) ? (array) $res['sectors'] : array(),
				'usage'       => isset( $res['ai_usage'] ) ? $res['ai_usage'] : '',
				'aiTypes'     => isset( $res['ai_types'] ) ? (array) $res['ai_types'] : array(),
				'riskClass'   => isset( $res['risk_class'] ) ? $res['risk_class'] : '',
				'riskProcess' => isset( $res['risk_process'] ) ? $res['risk_process'] : '',
				'blockers'    => isset( $res['blockers'] ) ? (array) $res['blockers'] : array(),
				'answers'     => isset( $res['answers'] ) && is_array( $res['answers'] ) ? $res['answers'] : array(),
				'unsure'      => isset( $res['unsure'] ) && is_array( $res['unsure'] ) ? $res['unsure'] : array(),
			);
		}
	}
	return array();
}

/**
 * Generate the Excel (.xlsx) and PDF (.pdf) files and send:
 *   1. Admin email with the Excel (.xlsx) file attached containing all submitted answers.
 *   2. User email with the generated AI Readiness Report (.pdf) attached.
 *
 * @param int    $pid     Assessment post ID.
 * @param array  $contact Contact/request details (name, email, organisation, role, sector, wants, message, assessment_id).
 * @param array  $state   Assessment state array (answers, profile, blockers, etc.).
 * @param string $report  Plain-text summary report.
 * @return array Status flags array( 'admin_sent' => bool, 'user_sent' => bool ).
 */
function c1_send_assessment_emails( $pid, $contact, $state, $report = '' ) {
	$state    = c1_get_assessment_state( $pid, $state );
	$computed = c1_assessment_compute( $state );

	// Create temporary directory for attachments so PHPMailer sees clean filenames.
	$tmp_base = trailingslashit( get_temp_dir() ) . 'c1-assess-' . wp_generate_password( 12, false );
	wp_mkdir_p( $tmp_base );

	$org_or_name = ! empty( $contact['organisation'] ) && 'Not given' !== $contact['organisation']
		? $contact['organisation']
		: ( ! empty( $contact['name'] ) ? $contact['name'] : 'Respondent' );
	$slug        = sanitize_file_name( $org_or_name );
	if ( '' === $slug ) {
		$slug = 'Respondent';
	}
	$date_part = wp_date( 'Y-m-d' );

	$xlsx_path = trailingslashit( $tmp_base ) . 'Cypher-One-AI-Readiness-Answers-' . $slug . '-' . $date_part . '.xlsx';
	$pdf_path  = trailingslashit( $tmp_base ) . 'Cypher-One-AI-Readiness-Report-' . $slug . '-' . $date_part . '.pdf';

	$has_xlsx = c1_generate_assessment_xlsx( $state, $contact, $computed, $xlsx_path );
	$has_pdf  = c1_generate_assessment_pdf( $state, $contact, $computed, $pdf_path );

	$admin_sent = false;
	$user_sent  = false;

	// 1. Send Admin Email with Excel (.xlsx) attachment containing all submitted answers.
	$admin_to = c1_opt( 'assess_notify' );
	if ( ! is_email( $admin_to ) ) {
		$admin_to = c1_opt( 'form_recipient' );
	}
	if ( ! is_email( $admin_to ) ) {
		$admin_to = get_option( 'admin_email' );
	}

	if ( is_email( $admin_to ) ) {
		$admin_subject = sprintf(
			/* translators: 1: organisation or name, 2: score, 3: band label. */
			__( 'AI Readiness Assessment — %1$s — %2$s/100 (%3$s)', 'cypher-one' ),
			$org_or_name,
			$computed['composite'],
			$computed['band']['label']
		);

		$admin_lines   = array();
		$admin_lines[] = __( 'A new AI Readiness Assessment has been submitted.', 'cypher-one' );
		$admin_lines[] = __( 'The Excel (.xlsx) file containing all submitted answers against each question is attached to this email.', 'cypher-one' );
		$admin_lines[] = '';
		if ( '' !== $report ) {
			$admin_lines[] = $report;
		} else {
			$admin_lines[] = __( 'Name', 'cypher-one' ) . ': ' . ( ! empty( $contact['name'] ) ? $contact['name'] : '—' );
			$admin_lines[] = __( 'Email', 'cypher-one' ) . ': ' . ( ! empty( $contact['email'] ) ? $contact['email'] : '—' );
			$admin_lines[] = __( 'Organisation', 'cypher-one' ) . ': ' . ( ! empty( $contact['organisation'] ) ? $contact['organisation'] : '—' );
			$admin_lines[] = __( 'Overall score', 'cypher-one' ) . ': ' . $computed['composite'] . '/100 (' . $computed['band']['label'] . ')';
		}
		$admin_lines[] = '';
		$admin_lines[] = __( 'View in the dashboard:', 'cypher-one' ) . ' ' . admin_url( 'post.php?post=' . $pid . '&action=edit' );

		$admin_headers = array();
		if ( ! empty( $contact['email'] ) && is_email( $contact['email'] ) ) {
			$reply_name      = ! empty( $contact['name'] ) ? $contact['name'] : $contact['email'];
			$admin_headers[] = 'Reply-To: ' . $reply_name . ' <' . $contact['email'] . '>';
		}
		$admin_attachments = ( $has_xlsx && file_exists( $xlsx_path ) ) ? array( $xlsx_path ) : array();
		$admin_sent        = wp_mail( $admin_to, $admin_subject, implode( "\n", $admin_lines ), $admin_headers, $admin_attachments );
	}

	// 2. Send User Email with the generated AI Readiness Report (.pdf) attached.
	$user_email = ! empty( $contact['email'] ) ? sanitize_email( $contact['email'] ) : '';
	if ( is_email( $user_email ) ) {
		$user_subject = sprintf(
			/* translators: 1: score, 2: band label. */
			__( 'Your Cypher-One AI Readiness Report — %1$s/100 (%2$s)', 'cypher-one' ),
			$computed['composite'],
			$computed['band']['label']
		);

		$first_name = ! empty( $contact['name'] ) ? trim( explode( ' ', trim( $contact['name'] ) )[0] ) : '';
		$greeting   = $first_name ? sprintf( __( 'Dear %s,', 'cypher-one' ), $first_name ) : __( 'Hello,', 'cypher-one' );

		$top_gaps = array();
		foreach ( array_slice( $computed['gaps'], 0, 3 ) as $gdim ) {
			$top_gaps[] = $gdim['label'] . ' (' . $computed['d'][ $gdim['key'] ] . '/100)';
		}

		$reply_to_email = c1_opt( 'contact_email' );
		if ( ! is_email( $reply_to_email ) ) {
			$reply_to_email = 'contact@cypher-one.ai';
		}
		$web_label = c1_opt( 'website_label' ) ? c1_opt( 'website_label' ) : 'www.cypher-one.ai';
		$loc_label = c1_opt( 'contact_location' ) ? c1_opt( 'contact_location' ) : 'Doha, Qatar';

		$user_lines   = array();
		$user_lines[] = $greeting;
		$user_lines[] = '';
		$user_lines[] = __( 'Thank you for completing the Cypher-One AI Readiness Assessment.', 'cypher-one' );
		$user_lines[] = __( 'Your personalised AI Readiness Report is attached to this email as a PDF document.', 'cypher-one' );
		$user_lines[] = '';
		$user_lines[] = __( 'SUMMARY OF YOUR RESULTS', 'cypher-one' );
		$user_lines[] = '• ' . __( 'Overall Readiness Score:', 'cypher-one' ) . ' ' . $computed['composite'] . '/100 (' . $computed['band']['label'] . ')';
		$user_lines[] = '• ' . __( 'Weakest Pillar:', 'cypher-one' ) . ' ' . $computed['weak_pillar']['name'] . ' (' . $computed['weak_pillar']['value'] . '/100)';
		$user_lines[] = '• ' . __( 'Priority Areas to Address First:', 'cypher-one' ) . ' ' . implode( ', ', $top_gaps );
		$user_lines[] = '';
		$user_lines[] = $computed['plain'];
		$user_lines[] = '';
		$user_lines[] = __( 'Recommended starting point:', 'cypher-one' ) . ' ' . $computed['weak_pillar']['cta'];
		if ( ! empty( $contact['wants'] ) && 'Not chosen' !== $contact['wants'] ) {
			$user_lines[] = '';
			$user_lines[] = sprintf(
				/* translators: %s: requested follow-up option. */
				__( 'We have also noted your request ("%s") and a member of the Cypher-One team will be in touch shortly.', 'cypher-one' ),
				$contact['wants']
			);
		}
		$user_lines[] = '';
		$user_lines[] = sprintf(
			/* translators: %s: contact email. */
			__( 'If you have any questions or would like to walk through your report with our team, simply reply to this email or contact us at %s.', 'cypher-one' ),
			$reply_to_email
		);
		$user_lines[] = '';
		$user_lines[] = __( 'Best regards,', 'cypher-one' );
		$user_lines[] = 'Cypher-One';
		$user_lines[] = $loc_label . ' · ' . $web_label;

		$user_headers     = array( 'Reply-To: Cypher-One <' . $reply_to_email . '>' );
		$user_attachments = ( $has_pdf && file_exists( $pdf_path ) ) ? array( $pdf_path ) : array();
		$user_sent        = wp_mail( $user_email, $user_subject, implode( "\n", $user_lines ), $user_headers, $user_attachments );
	}

	// Clean up temporary files and directory.
	if ( file_exists( $xlsx_path ) ) {
		wp_delete_file( $xlsx_path );
	}
	if ( file_exists( $pdf_path ) ) {
		wp_delete_file( $pdf_path );
	}
	if ( is_dir( $tmp_base ) ) {
		@rmdir( $tmp_base ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged,WordPress.WP.AlternativeFunctions.file_system_operations_rmdir
	}

	return array(
		'admin_sent' => (bool) $admin_sent,
		'user_sent'  => (bool) $user_sent,
	);
}

/**
 * Human-readable summary of a results payload.
 *
 * @param array $r Results.
 * @return string
 */
function c1_assessment_summary( $r ) {
	$lines   = array();
	$lines[] = __( 'Composite score', 'cypher-one' ) . ': ' . ( isset( $r['composite'] ) ? $r['composite'] : '—' ) . ( isset( $r['band'] ) ? ' (' . $r['band'] . ')' : '' );
	$lines[] = __( 'Country', 'cypher-one' ) . ': ' . ( ! empty( $r['country'] ) ? $r['country'] : '—' );
	$lines[] = __( 'Organisation size', 'cypher-one' ) . ': ' . ( ! empty( $r['size_band'] ) ? $r['size_band'] : '—' );
	$lines[] = __( 'Role', 'cypher-one' ) . ': ' . ( ! empty( $r['role'] ) ? $r['role'] : '—' );
	$lines[] = __( 'Sectors', 'cypher-one' ) . ': ' . ( ! empty( $r['sectors'] ) ? implode( ', ', (array) $r['sectors'] ) : '—' );
	$lines[] = __( 'AI usage', 'cypher-one' ) . ': ' . ( ! empty( $r['ai_usage'] ) ? $r['ai_usage'] : '—' );
	if ( ! empty( $r['domains'] ) && is_array( $r['domains'] ) ) {
		$lines[] = '';
		$lines[] = __( 'Scores by area', 'cypher-one' ) . ':';
		foreach ( $r['domains'] as $k => $v ) {
			$lines[] = '  ' . ucfirst( $k ) . ': ' . ( is_scalar( $v ) ? $v : wp_json_encode( $v ) );
		}
	}
	if ( ! empty( $r['blockers'] ) ) {
		$lines[] = '';
		$lines[] = __( 'Named blockers', 'cypher-one' ) . ': ' . implode( '; ', (array) $r['blockers'] );
	}
	return implode( "\n", $lines );
}

/**
 * POST /assessment/results
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function c1_rest_results( $request ) {
	$body = c1_assessment_guard( $request );
	if ( is_wp_error( $body ) ) {
		return $body;
	}
	$data = c1_clean_payload( $body );
	$pid  = c1_assessment_post( $data['assessment_id'] );
	$post = array(
		'post_type'    => 'c1_assessment',
		'post_status'  => 'private',
		/* translators: 1: score, 2: band, 3: country. */
		'post_title'   => sprintf( __( 'Score %1$s · %2$s · %3$s', 'cypher-one' ), isset( $data['composite'] ) ? $data['composite'] : '—', isset( $data['band'] ) ? $data['band'] : '—', ! empty( $data['country'] ) ? $data['country'] : '—' ),
		'post_content' => c1_assessment_summary( $data ),
	);
	if ( $pid ) {
		$post['ID'] = $pid;
		wp_update_post( $post );
	} else {
		$pid = wp_insert_post( $post );
	}
	if ( ! $pid || is_wp_error( $pid ) ) {
		return new WP_Error( 'c1_save', __( 'Could not save.', 'cypher-one' ), array( 'status' => 500 ) );
	}
	update_post_meta( $pid, '_c1_aid', $data['assessment_id'] );
	update_post_meta( $pid, '_c1_results', wp_slash( wp_json_encode( $data ) ) );
	if ( ! empty( $body['data_json'] ) && is_string( $body['data_json'] ) && strlen( $body['data_json'] ) < 150000 && null !== json_decode( $body['data_json'] ) ) {
		update_post_meta( $pid, '_c1_state', wp_slash( $body['data_json'] ) );
	}
	return rest_ensure_response( array( 'ok' => true ) );
}

/**
 * POST /assessment/leads — a visitor asked for a full review / the report.
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function c1_rest_leads( $request ) {
	$body = c1_assessment_guard( $request );
	if ( is_wp_error( $body ) ) {
		return $body;
	}
	$email = isset( $body['email'] ) ? sanitize_email( $body['email'] ) : '';
	if ( ! is_email( $email ) ) {
		return new WP_Error( 'c1_email', __( 'Invalid email.', 'cypher-one' ), array( 'status' => 400 ) );
	}
	$aid = $body['assessment_id'];
	$pid = c1_assessment_post( $aid );
	if ( ! $pid ) {
		$pid = wp_insert_post(
			array(
				'post_type'   => 'c1_assessment',
				'post_status' => 'private',
				'post_title'  => __( 'Report request', 'cypher-one' ),
			)
		);
		if ( $pid && ! is_wp_error( $pid ) ) {
			update_post_meta( $pid, '_c1_aid', $aid );
		}
	}
	if ( ! $pid || is_wp_error( $pid ) ) {
		return new WP_Error( 'c1_save', __( 'Could not save.', 'cypher-one' ), array( 'status' => 500 ) );
	}
	update_post_meta( $pid, '_c1_email', $email );

	$state = array();
	if ( ! empty( $body['data_json'] ) && is_string( $body['data_json'] ) && strlen( $body['data_json'] ) < 150000 ) {
		$decoded = json_decode( $body['data_json'], true );
		if ( is_array( $decoded ) ) {
			update_post_meta( $pid, '_c1_state', wp_slash( $body['data_json'] ) );
			$state = isset( $decoded['state'] ) && is_array( $decoded['state'] ) ? $decoded['state'] : $decoded;
		}
	}

	$post = get_post( $pid );
	wp_update_post(
		array(
			'ID'         => $pid,
			'post_title' => $email . ' — ' . preg_replace( '/^.*? — /', '', $post->post_title ),
		)
	);

	$results = get_post_meta( $pid, '_c1_results', true );
	$summary = $results ? c1_assessment_summary( (array) json_decode( $results, true ) ) : '';
	$contact = array(
		'assessment_id' => $aid,
		'name'          => isset( $body['name'] ) ? sanitize_text_field( (string) $body['name'] ) : '',
		'email'         => $email,
		'organisation'  => isset( $body['organisation'] ) ? sanitize_text_field( (string) $body['organisation'] ) : '',
		'role'          => isset( $body['role'] ) ? sanitize_text_field( (string) $body['role'] ) : '',
		'sector'        => isset( $body['sector'] ) ? sanitize_text_field( (string) $body['sector'] ) : '',
		'wants'         => __( 'Full AI Readiness Report & Review', 'cypher-one' ),
		'message'       => '',
	);

	c1_send_assessment_emails( $pid, $contact, $state, $summary );

	return rest_ensure_response( array( 'ok' => true, 'success' => true ) );
}

/**
 * Admin list columns for assessments.
 *
 * @param array $cols Columns.
 * @return array
 */
function c1_assessment_columns( $cols ) {
	$new = array();
	foreach ( $cols as $k => $v ) {
		$new[ $k ] = $v;
		if ( 'title' === $k ) {
			$new['c1_email'] = __( 'Report requested by', 'cypher-one' );
			$new['c1_files'] = __( 'Downloads', 'cypher-one' );
		}
	}
	return $new;
}
add_filter( 'manage_c1_assessment_posts_columns', 'c1_assessment_columns' );

/**
 * Admin column content.
 *
 * @param string $col     Column.
 * @param int    $post_id Post ID.
 */
function c1_assessment_column( $col, $post_id ) {
	if ( 'c1_email' === $col ) {
		$email = get_post_meta( $post_id, '_c1_email', true );
		echo $email ? '<a href="' . esc_url( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a>' : '—';
	} elseif ( 'c1_files' === $col ) {
		$xlsx_url = wp_nonce_url( admin_url( 'admin-post.php?action=c1_assessment_download&post=' . (int) $post_id . '&type=xlsx' ), 'c1_dl_' . (int) $post_id );
		$pdf_url  = wp_nonce_url( admin_url( 'admin-post.php?action=c1_assessment_download&post=' . (int) $post_id . '&type=pdf' ), 'c1_dl_' . (int) $post_id );
		echo '<a class="button button-small" href="' . esc_url( $xlsx_url ) . '">' . esc_html__( 'Excel (.xlsx)', 'cypher-one' ) . '</a> ';
		echo '<a class="button button-small" href="' . esc_url( $pdf_url ) . '">' . esc_html__( 'Report (.pdf)', 'cypher-one' ) . '</a>';
	}
}
add_action( 'manage_c1_assessment_posts_custom_column', 'c1_assessment_column', 10, 2 );

/**
 * Handle admin download of Excel (.xlsx) or Report (.pdf) for a saved assessment.
 */
function c1_handle_assessment_download() {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	$type    = isset( $_GET['type'] ) ? sanitize_key( wp_unslash( $_GET['type'] ) ) : 'xlsx';
	if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( esc_html__( 'You do not have permission to download this file.', 'cypher-one' ), 403 );
	}
	check_admin_referer( 'c1_dl_' . $post_id );

	$post = get_post( $post_id );
	if ( ! $post || 'c1_assessment' !== $post->post_type ) {
		wp_die( esc_html__( 'Assessment not found.', 'cypher-one' ), 404 );
	}

	$state    = c1_get_assessment_state( $post_id );
	$computed = c1_assessment_compute( $state );
	$contact  = array(
		'assessment_id' => (string) get_post_meta( $post_id, '_c1_aid', true ),
		'name'          => (string) get_post_meta( $post_id, '_c1_name', true ),
		'email'         => (string) get_post_meta( $post_id, '_c1_email', true ),
		'organisation'  => (string) get_post_meta( $post_id, '_c1_organisation', true ),
		'role'          => (string) get_post_meta( $post_id, '_c1_role', true ),
		'sector'        => (string) get_post_meta( $post_id, '_c1_sector', true ),
		'wants'         => (string) get_post_meta( $post_id, '_c1_wants', true ),
		'message'       => (string) get_post_meta( $post_id, '_c1_message', true ),
	);

	$slug = sanitize_file_name( $contact['organisation'] ? $contact['organisation'] : ( $contact['name'] ? $contact['name'] : 'assessment-' . $post_id ) );
	$tmp  = wp_tempnam( 'c1-dl-' );

	if ( 'pdf' === $type ) {
		c1_generate_assessment_pdf( $state, $contact, $computed, $tmp );
		$filename = 'Cypher-One-AI-Readiness-Report-' . $slug . '.pdf';
		$mime     = 'application/pdf';
	} else {
		c1_generate_assessment_xlsx( $state, $contact, $computed, $tmp );
		$filename = 'Cypher-One-AI-Readiness-Answers-' . $slug . '.xlsx';
		$mime     = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	}

	if ( file_exists( $tmp ) ) {
		nocache_headers();
		header( 'Content-Type: ' . $mime );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'Content-Length: ' . filesize( $tmp ) );
		readfile( $tmp ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_readfile
		wp_delete_file( $tmp );
		exit;
	}
	wp_die( esc_html__( 'Could not generate file.', 'cypher-one' ), 500 );
}
add_action( 'admin_post_c1_assessment_download', 'c1_handle_assessment_download' );

/**
 * POST /assessment/request — the "Let's dive deeper" form at the end of the snapshot.
 * Saves the request with the visitor's full results, emails the Excel (.xlsx) answers
 * sheet to the admin, and emails the generated PDF report to the user.
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function c1_rest_request( $request ) {
	$body = c1_assessment_guard( $request );
	if ( is_wp_error( $body ) ) {
		return $body;
	}
	if ( ! empty( $body['website'] ) ) { // Honeypot.
		return rest_ensure_response( array( 'ok' => true, 'success' => true ) );
	}
	$f = array();
	foreach ( array( 'name', 'organisation', 'role', 'sector', 'wants', 'overall_score' ) as $k ) {
		$f[ $k ] = isset( $body[ $k ] ) ? sanitize_text_field( (string) $body[ $k ] ) : '';
	}
	$f['email']   = isset( $body['email'] ) ? sanitize_email( (string) $body['email'] ) : '';
	$f['message'] = isset( $body['message'] ) ? sanitize_textarea_field( (string) $body['message'] ) : '';
	$report       = isset( $body['full_report'] ) ? sanitize_textarea_field( (string) $body['full_report'] ) : '';
	$data_json    = isset( $body['data_json'] ) ? (string) $body['data_json'] : '';

	if ( '' === $f['name'] || ! is_email( $f['email'] ) ) {
		return new WP_Error( 'c1_invalid', __( 'Please add your name and a valid work email.', 'cypher-one' ), array( 'status' => 400 ) );
	}

	$aid   = $body['assessment_id'];
	$pid   = c1_assessment_post( $aid );
	$title = sprintf(
		/* translators: 1: name, 2: organisation, 3: score. */
		__( '%1$s — %2$s — %3$s', 'cypher-one' ),
		$f['name'],
		$f['organisation'] ? $f['organisation'] : $f['email'],
		$f['overall_score'] ? $f['overall_score'] : '—'
	);
	$post  = array(
		'post_type'    => 'c1_assessment',
		'post_status'  => 'private',
		'post_title'   => $title,
		'post_content' => $report,
	);
	if ( $pid ) {
		$post['ID'] = $pid;
		$pid        = wp_update_post( $post );
	} else {
		$pid = wp_insert_post( $post );
	}
	if ( ! $pid || is_wp_error( $pid ) ) {
		return new WP_Error( 'c1_save', __( 'Could not save.', 'cypher-one' ), array( 'status' => 500 ) );
	}
	update_post_meta( $pid, '_c1_aid', $aid );
	update_post_meta( $pid, '_c1_email', $f['email'] );
	foreach ( $f as $k => $v ) {
		update_post_meta( $pid, '_c1_' . $k, $v );
	}

	$state = array();
	if ( $data_json && strlen( $data_json ) < 150000 ) {
		$decoded = json_decode( $data_json, true );
		if ( is_array( $decoded ) ) {
			update_post_meta( $pid, '_c1_state', wp_slash( $data_json ) );
			$state = isset( $decoded['state'] ) && is_array( $decoded['state'] ) ? $decoded['state'] : $decoded;
		}
	}

	$contact_payload                  = $f;
	$contact_payload['assessment_id'] = $aid;
	$mail_status                      = c1_send_assessment_emails( $pid, $contact_payload, $state, $report );

	/**
	 * Fires after an assessment request is saved and emails are dispatched.
	 *
	 * @param int   $pid         Assessment post ID.
	 * @param array $f           Sanitised fields.
	 * @param array $body        Raw payload.
	 * @param array $mail_status Email status flags.
	 */
	do_action( 'c1_assessment_request', $pid, $f, $body, $mail_status );

	return rest_ensure_response(
		array(
			'ok'         => true,
			'success'    => true,
			'admin_sent' => $mail_status['admin_sent'],
			'user_sent'  => $mail_status['user_sent'],
		)
	);
}
