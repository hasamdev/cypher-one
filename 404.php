<?php
/**
 * 404 page.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="page is-active" id="page-404">
<section class="band pageintro t-dark c1-message" aria-labelledby="nf-title">
  <div class="wrap">
    <p class="eyebrow">404</p>
    <h1 id="nf-title" style="margin-top:12px;font-size:clamp(2.2rem,5vw,3.8rem)"><?php echo esc_html( c1_opt( 'notfound_title' ) ); ?></h1>
    <p class="lede" style="margin-top:16px"><?php echo esc_html( c1_opt( 'notfound_text' ) ); ?></p>
    <p style="margin-top:24px"><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( c1_opt( 'notfound_link' ) ); ?></a></p>
  </div>
</section>
</div>
<?php
get_footer();
