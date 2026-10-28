<?php
/**
 * Home: hero with tagline, subtitle, lede and the readiness-check illustration.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_thoughts = (array) c1_f( 'hero_thoughts' );
?>
<section class="band hero t-dark wire-mast" id="hero" aria-labelledby="hero-title">
  <?php
	if ( c1_f( 'hero_show_wire' ) ) {
		echo c1_svg( 'hero-wire' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static theme SVG.
	}
	?>
  <div class="wrap">
    <div class="mrow"><span class="mwordmark"><?php echo esc_html( c1_opt( 'logo_word_1' ) ); ?><i><?php echo esc_html( c1_opt( 'logo_separator' ) ); ?></i><?php echo esc_html( c1_opt( 'logo_word_2' ) ); ?></span><?php if ( c1_f( 'hero_pill' ) ) : ?><span class="mpill"><?php c1_e( 'hero_pill' ); ?></span><?php endif; ?></div>
    <div class="h3-grid">
      <div class="h3-copy">
        <h1 class="mh1 h3-h1" id="hero-title"><?php c1_h( 'hero_title' ); ?></h1>
        <?php if ( c1_f( 'hero_intel' ) ) : ?><p class="mintel"><?php c1_e( 'hero_intel' ); ?></p><?php endif; ?>
        <?php if ( c1_f( 'hero_sub' ) ) : ?><p class="h3-sub"><?php c1_e( 'hero_sub' ); ?></p><?php endif; ?>
        <?php if ( c1_f( 'hero_lede' ) ) : ?><p class="msub"><?php c1_e( 'hero_lede' ); ?></p><?php endif; ?>
        <?php if ( $c1_thoughts ) : ?>
        <ul class="h3-thoughts" aria-label="<?php echo esc_attr( c1_f( 'hero_thoughts_label' ) ); ?>">
          <?php foreach ( $c1_thoughts as $c1_row ) : ?>
          <li><?php echo esc_html( $c1_row['text'] ); ?></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <div class="row" style="margin-top:22px">
          <?php c1_button( 'hero_btn_label', 'hero_btn_link' ); ?>
        </div>
      </div>
      <figure class="h3-fig">
        <?php get_template_part( 'template-parts/charts/hero-org' ); ?>
        <?php if ( c1_f( 'hero_fig_caption' ) ) : ?><figcaption><?php c1_e( 'hero_fig_caption' ); ?></figcaption><?php endif; ?>
      </figure>
    </div>
  </div>
</section>

