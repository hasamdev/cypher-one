<?php
/**
 * Template Name: Thank you
 * Template Post Type: page
 *
 * Shown after the contact form is sent.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'thanks' );
get_header();

$c1_email = c1_opt( 'contact_email' );
$c1_text  = c1_kses( c1_f( 'th_text' ) );
$c1_text  = str_replace( '{email}', '<a href="' . esc_url( 'mailto:' . antispambot( $c1_email ) ) . '">' . esc_html( antispambot( $c1_email ) ) . '</a>', $c1_text );
?>
<div class="page is-active" id="page-thanks">
<section class="band pageintro t-dark c1-message" aria-labelledby="thanks-title">
  <div class="wrap">
    <h1 id="thanks-title" style="font-size:clamp(2.2rem,5vw,3.8rem)"><?php c1_e( 'th_title' ); ?></h1>
    <p class="lede" style="margin-top:16px"><?php echo $c1_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
    <p style="margin-top:24px"><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php c1_e( 'th_link' ); ?></a></p>
  </div>
</section>
</div>
<?php
get_footer();
