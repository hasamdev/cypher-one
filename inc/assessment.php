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
	$post = get_post( $pid );
	wp_update_post(
		array(
			'ID'         => $pid,
			'post_title' => $email . ' — ' . preg_replace( '/^.*? — /', '', $post->post_title ),
		)
	);

	$to = c1_opt( 'assess_notify' );
	if ( is_email( $to ) ) {
		$results = get_post_meta( $pid, '_c1_results', true );
		$summary = $results ? c1_assessment_summary( (array) json_decode( $results, true ) ) : '';
		$message = sprintf(
			/* translators: 1: email address, 2: summary, 3: admin link. */
			__( "%1\$s asked for a full review after taking the AI Readiness Assessment.\n\n%2\$s\n\nView in the dashboard: %3\$s", 'cypher-one' ),
			$email,
			$summary,
			admin_url( 'post.php?post=' . $pid . '&action=edit' )
		);
		wp_mail( $to, __( 'New AI Readiness Assessment report request', 'cypher-one' ), $message, array( 'Reply-To: ' . $email ) );
	}
	return rest_ensure_response( array( 'ok' => true ) );
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
	}
}
add_action( 'manage_c1_assessment_posts_custom_column', 'c1_assessment_column', 10, 2 );

/**
 * POST /assessment/request — the "Let's dive deeper" form at the end of the snapshot.
 * Saves the request with the visitor's full results and emails it to the team.
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
	if ( $data_json && strlen( $data_json ) < 150000 && null !== json_decode( $data_json ) ) {
		update_post_meta( $pid, '_c1_state', wp_slash( $data_json ) );
	}

	$to = c1_opt( 'assess_notify' );
	if ( is_email( $to ) ) {
		$subject = sprintf(
			/* translators: 1: organisation or name, 2: score. */
			__( 'AI Readiness request — %1$s — %2$s', 'cypher-one' ),
			$f['organisation'] ? $f['organisation'] : $f['name'],
			$f['overall_score']
		);
		$message = $report . "\n\n" . __( 'View in the dashboard:', 'cypher-one' ) . ' ' . admin_url( 'post.php?post=' . $pid . '&action=edit' );
		wp_mail( $to, $subject, $message, array( 'Reply-To: ' . $f['name'] . ' <' . $f['email'] . '>' ) );
	}

	/**
	 * Fires after an assessment request is saved.
	 *
	 * @param int   $pid  Assessment post ID.
	 * @param array $f    Sanitised fields.
	 * @param array $body Raw payload.
	 */
	do_action( 'c1_assessment_request', $pid, $f, $body );

	return rest_ensure_response( array( 'ok' => true, 'success' => true ) );
}
