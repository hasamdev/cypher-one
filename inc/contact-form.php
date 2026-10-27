<?php
/**
 * Contact form: validation, email notification, and an "Enquiries" record in the dashboard.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the private Enquiry post type.
 */
function c1_register_enquiries() {
	register_post_type(
		'c1_enquiry',
		array(
			'labels'          => array(
				'name'          => __( 'Enquiries', 'cypher-one' ),
				'singular_name' => __( 'Enquiry', 'cypher-one' ),
				'menu_name'     => __( 'Enquiries', 'cypher-one' ),
				'all_items'     => __( 'All enquiries', 'cypher-one' ),
				'edit_item'     => __( 'Enquiry', 'cypher-one' ),
				'search_items'  => __( 'Search enquiries', 'cypher-one' ),
				'not_found'     => __( 'No enquiries yet.', 'cypher-one' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 26,
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'c1_register_enquiries' );

/**
 * Previously submitted values after a validation error (kept for 10 minutes).
 *
 * @return array
 */
function c1_contact_old_input() {
	$token = isset( $_GET['c1_t'] ) ? sanitize_key( wp_unslash( $_GET['c1_t'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $token ) {
		return array();
	}
	$data = get_transient( 'c1_form_' . $token );
	return is_array( $data ) ? $data : array();
}

/**
 * Handle a submission (logged-in and anonymous).
 */
function c1_handle_contact() {
	$page_id  = isset( $_POST['c1_page'] ) ? absint( $_POST['c1_page'] ) : 0;
	$back     = $page_id ? get_permalink( $page_id ) : c1_page_url( 'contact' );
	$back     = $back ? $back : home_url( '/' );
	$redirect = function ( $status, $extra = array() ) use ( $back ) {
		wp_safe_redirect( add_query_arg( array_merge( array( 'c1_sent' => $status ), $extra ), $back ) . '#contact' );
		exit;
	};

	if ( ! isset( $_POST['c1_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['c1_nonce'] ) ), 'c1_contact' ) ) {
		$redirect( 'error' );
	}

	// Honeypot: bots fill every field. Pretend it worked.
	if ( ! empty( $_POST['bot-field'] ) ) {
		$thanks = c1_page_url( 'thanks' );
		wp_safe_redirect( $thanks ? $thanks : $back );
		exit;
	}

	$data = array(
		'want'         => isset( $_POST['want'] ) ? sanitize_text_field( wp_unslash( $_POST['want'] ) ) : '',
		'want_other'   => isset( $_POST['want_other'] ) ? sanitize_text_field( wp_unslash( $_POST['want_other'] ) ) : '',
		'name'         => isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '',
		'organisation' => isset( $_POST['organisation'] ) ? sanitize_text_field( wp_unslash( $_POST['organisation'] ) ) : '',
		'email'        => isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '',
		'role'         => isset( $_POST['role'] ) ? sanitize_text_field( wp_unslash( $_POST['role'] ) ) : '',
		'sector'       => isset( $_POST['sector'] ) ? sanitize_text_field( wp_unslash( $_POST['sector'] ) ) : '',
		'message'      => isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '',
	);

	// Simple rate limit: 5 submissions per IP per 10 minutes.
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rkey  = 'c1_rl_' . md5( $ip );
	$count = (int) get_transient( $rkey );

	if ( '' === $data['name'] || ! is_email( $data['email'] ) || '' === $data['sector'] || $count >= 5 ) {
		$token = wp_generate_password( 12, false );
		set_transient( 'c1_form_' . strtolower( $token ), $data, 10 * MINUTE_IN_SECONDS );
		$redirect( 'error', array( 'c1_t' => strtolower( $token ) ) );
	}
	set_transient( $rkey, $count + 1, 10 * MINUTE_IN_SECONDS );

	$want = $data['want'];
	if ( $data['want_other'] ) {
		$want .= ': ' . $data['want_other'];
	}

	$labels = array(
		__( 'Request', 'cypher-one' )      => $want,
		__( 'Name', 'cypher-one' )         => $data['name'],
		__( 'Organisation', 'cypher-one' ) => $data['organisation'],
		__( 'Email', 'cypher-one' )        => $data['email'],
		__( 'Role', 'cypher-one' )         => $data['role'],
		__( 'Sector', 'cypher-one' )       => $data['sector'],
		__( 'Message', 'cypher-one' )      => $data['message'],
	);
	$body = '';
	foreach ( $labels as $label => $value ) {
		$body .= $label . ': ' . ( '' !== $value ? $value : '—' ) . "\n";
	}

	// Record in the dashboard.
	$post_id = wp_insert_post(
		array(
			'post_type'    => 'c1_enquiry',
			'post_status'  => 'private',
			/* translators: 1: name, 2: organisation or email. */
			'post_title'   => sprintf( __( '%1$s — %2$s', 'cypher-one' ), $data['name'], $data['organisation'] ? $data['organisation'] : $data['email'] ),
			'post_content' => $body,
		)
	);
	if ( $post_id && ! is_wp_error( $post_id ) ) {
		foreach ( $data as $k => $v ) {
			update_post_meta( $post_id, '_c1_' . $k, $v );
		}
	}

	$to      = c1_opt( 'form_recipient' );
	$to      = is_email( $to ) ? $to : get_option( 'admin_email' );
	$headers = array( 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>' );
	$sent    = wp_mail( $to, c1_opt( 'form_subject' ), $body, $headers );

	/**
	 * Fires after a contact enquiry is handled.
	 *
	 * @param array $data    Sanitised submission.
	 * @param int   $post_id Enquiry post ID.
	 * @param bool  $sent    Whether the email was accepted for delivery.
	 */
	do_action( 'c1_contact_submitted', $data, $post_id, $sent );

	if ( ! $sent && ! $post_id ) {
		$redirect( 'fail' );
	}

	$thanks = c1_page_url( 'thanks' );
	wp_safe_redirect( $thanks ? $thanks : add_query_arg( 'c1_sent', 'ok', $back ) );
	exit;
}
add_action( 'admin_post_c1_contact', 'c1_handle_contact' );
add_action( 'admin_post_nopriv_c1_contact', 'c1_handle_contact' );
