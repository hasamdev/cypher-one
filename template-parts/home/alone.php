<?php
/**
 * Home: "You're not alone" — the seven-step programme timeline.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_n = 0;
?>
<section class="band t-dark" id="alone" aria-labelledby="alone-title">
  <div class="wrap">
    <div class="ln-head" style="max-width:70ch">
      <p class="eyebrow"><?php c1_e( 'alone_eyebrow' ); ?></p>
      <h2 id="alone-title"><?php c1_h( 'alone_title' ); ?></h2>
      <?php if ( c1_f( 'alone_lede' ) ) : ?><p class="lede"><?php c1_e( 'alone_lede' ); ?></p><?php endif; ?>
    </div>
    <div class="tl" aria-label="<?php echo esc_attr( c1_f( 'alone_tl_aria' ) ); ?>">
      <?php foreach ( (array) c1_f( 'alone_steps' ) as $c1_row ) : ?>
        <?php ++$c1_n; ?>
      <a href="<?php echo esc_url( c1_url( $c1_row['link'] ) ); ?>"><i><?php echo esc_html( number_format_i18n( $c1_n ) ); ?></i><b><?php echo esc_html( $c1_row['title'] ); ?></b><span><?php echo esc_html( $c1_row['text'] ); ?></span></a>
      <?php endforeach; ?>
    </div>
    <div class="ln-actions"><?php c1_button( 'alone_btn_label', 'alone_btn_link' ); ?><?php c1_button( 'alone_more_label', 'alone_more_link', 'ln-more' ); ?></div>
  </div>
</section>
