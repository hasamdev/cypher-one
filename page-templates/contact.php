<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * The form posts to admin-post.php (see inc/contact-form.php).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'contact' );
get_header();

$c1_wants   = array_values( (array) c1_f( 'cf_wants' ) );
$c1_sectors = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) c1_f( 'cf_sectors' ) ) ) );
$c1_email   = c1_opt( 'contact_email' );
$c1_status  = isset( $_GET['c1_sent'] ) ? sanitize_key( wp_unslash( $_GET['c1_sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$c1_old     = c1_contact_old_input();
?>
<div class="page is-active" id="page-contact">
<?php c1_page_intro( 'contact', __( 'Page introduction', 'cypher-one' ), 'contact-title' ); ?>
<section class="t-light" id="contact" aria-label="<?php esc_attr_e( 'Contact form', 'cypher-one' ); ?>">
  <div class="wrap">
    <?php if ( 'error' === $c1_status ) : ?>
    <p class="cf-notice is-error" role="alert"><?php echo esc_html( c1_opt( 'form_error' ) ); ?></p>
    <?php elseif ( 'ok' === $c1_status ) : ?>
    <p class="cf-notice" role="status"><?php esc_html_e( 'Thank you. We have it, and will reply within one business day.', 'cypher-one' ); ?></p>
    <?php elseif ( 'fail' === $c1_status ) : ?>
    <p class="cf-notice is-error" role="alert">
      <?php
		/* translators: %s: email address. */
		echo wp_kses( sprintf( __( 'Sorry, your message could not be sent. Please email us at %s.', 'cypher-one' ), '<a href="mailto:' . esc_attr( antispambot( $c1_email ) ) . '">' . esc_html( antispambot( $c1_email ) ) . '</a>' ), array( 'a' => array( 'href' => true ) ) );
		?>
    </p>
    <?php endif; ?>

    <form class="contact-form" name="contact" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
      <input type="hidden" name="action" value="c1_contact">
      <input type="hidden" name="c1_page" value="<?php echo esc_attr( get_queried_object_id() ); ?>">
      <?php wp_nonce_field( 'c1_contact', 'c1_nonce' ); ?>
      <p class="hp"><label><?php esc_html_e( 'Leave this empty:', 'cypher-one' ); ?> <input name="bot-field" tabindex="-1" autocomplete="off"></label></p>
      <fieldset class="cf-want">
        <div class="calc-legend"><?php c1_e( 'cf_legend' ); ?></div>
        <div class="cf-opts">
          <?php foreach ( $c1_wants as $c1_i => $c1_w ) : ?>
            <?php
			$c1_val     = $c1_w['value'] ? $c1_w['value'] : $c1_w['label'];
			$c1_checked = $c1_old ? ( isset( $c1_old['want'] ) && $c1_old['want'] === $c1_val ) : ( 0 === $c1_i );
			?>
          <label><input type="radio" name="want" value="<?php echo esc_attr( $c1_val ); ?>"<?php checked( $c1_checked ); ?>><span><?php echo esc_html( $c1_w['label'] ); ?></span><?php if ( ! empty( $c1_w['other'] ) ) : ?><input type="text" name="want_other" class="cf-other" placeholder="<?php echo esc_attr( c1_f( 'cf_other_placeholder' ) ); ?>" aria-label="<?php echo esc_attr( $c1_w['label'] ); ?>" value="<?php echo esc_attr( isset( $c1_old['want_other'] ) ? $c1_old['want_other'] : '' ); ?>"><?php endif; ?></label>
          <?php endforeach; ?>
        </div>
      </fieldset>
      <div class="cf-fields">
        <label><span><?php c1_e( 'cf_name' ); ?></span><input type="text" name="name" autocomplete="name" required value="<?php echo esc_attr( isset( $c1_old['name'] ) ? $c1_old['name'] : '' ); ?>"></label>
        <label><span><?php c1_e( 'cf_org' ); ?></span><input type="text" name="organisation" autocomplete="organization" value="<?php echo esc_attr( isset( $c1_old['organisation'] ) ? $c1_old['organisation'] : '' ); ?>"></label>
        <label><span><?php c1_e( 'cf_email' ); ?></span><input type="email" name="email" autocomplete="email" required value="<?php echo esc_attr( isset( $c1_old['email'] ) ? $c1_old['email'] : '' ); ?>"></label>
        <label><span><?php c1_e( 'cf_role' ); ?></span><input type="text" name="role" autocomplete="organization-title" value="<?php echo esc_attr( isset( $c1_old['role'] ) ? $c1_old['role'] : '' ); ?>"></label>
        <label class="cf-full"><span><?php c1_e( 'cf_sector' ); ?></span><select name="sector" required><option value=""<?php selected( empty( $c1_old['sector'] ) ); ?> disabled><?php echo esc_html( c1_f( 'cf_sector_placeholder' ) ); ?></option><?php foreach ( $c1_sectors as $c1_sector ) : ?><option<?php selected( isset( $c1_old['sector'] ) && $c1_old['sector'] === $c1_sector ); ?>><?php echo esc_html( $c1_sector ); ?></option><?php endforeach; ?></select></label>
        <label class="cf-full"><span><?php c1_e( 'cf_message' ); ?></span><textarea name="message" rows="4" placeholder="<?php echo esc_attr( c1_f( 'cf_message_placeholder' ) ); ?>"><?php echo esc_textarea( isset( $c1_old['message'] ) ? $c1_old['message'] : '' ); ?></textarea></label>
        <div class="cf-full row"><button type="submit" class="btn btn-primary"><?php c1_e( 'cf_submit' ); ?></button><?php if ( $c1_email ) : ?><span class="cf-alt"><?php c1_e( 'cf_alt' ); ?> <a href="<?php echo esc_url( 'mailto:' . antispambot( $c1_email ) ); ?>"><?php echo esc_html( antispambot( $c1_email ) ); ?></a></span><?php endif; ?></div>
      </div>
    </form>
  </div>
</section>
</div>
<?php
get_footer();
