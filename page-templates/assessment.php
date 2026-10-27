<?php
/**
 * Template Name: AI Readiness Assessment
 * Template Post Type: page
 *
 * A standalone app page (no site header/footer), as in the original build.
 * Styles and script: assets/css/assessment.css, assets/js/assessment.js.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'assessment' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="c1-back" aria-label="<?php esc_attr_e( 'Back to the Cypher-One website', 'cypher-one' ); ?>"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg><?php c1_e( 'as_back_label' ); ?></a>

<div id="root">
  <div class="bg" id="bg"></div>
  <?php echo c1_svg( 'assessment-cipher' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static theme SVG. ?>
  <div class="layer">
    <header class="bar no-print">
      <div class="wrap bar-in">
        <div>
          <span class="logo"><?php echo esc_html( c1_opt( 'logo_word_1' ) ); ?><i><?php echo esc_html( c1_opt( 'logo_separator' ) ); ?></i><?php echo esc_html( c1_opt( 'logo_word_2' ) ); ?></span>
          <span class="logo-sub"><?php c1_e( 'as_logo_sub' ); ?></span>
        </div>
        <button class="btn-ghost" style="padding:8px 14px;color:var(--ink)" onclick="toggleLang()" id="langBtn" type="button"><?php c1_e( 'as_lang_label' ); ?></button>
      </div>
    </header>
    <main id="app"></main>
    <footer class="bar no-print">
      <div class="wrap foot-in">
        <span class="foot-l"><?php c1_e( 'as_footer_left' ); ?></span>
        <span class="foot-r"><?php c1_e( 'as_footer_right' ); ?></span>
      </div>
    </footer>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
