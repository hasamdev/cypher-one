<?php
/**
 * Home: the readiness gap.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="t-grey" id="gap" aria-labelledby="gap-title">
  <div class="wrap">
    <div class="head-row">
      <div class="stack"><?php c1_section_head( 'gap_eyebrow', 'gap_title', 'gap-title' ); ?></div>
      <p class="lede"><?php c1_e( 'gap_lede' ); ?></p>
    </div>
    <div class="gap-layout">
      <figure class="gap-chart">
        <?php get_template_part( 'template-parts/charts/gap-chart' ); ?>
        <?php if ( c1_f( 'gap_caption' ) ) : ?><figcaption class="caption"><?php c1_e( 'gap_caption' ); ?></figcaption><?php endif; ?>
      </figure>
      <div class="gap-side"><p class="subhead" style="margin:0 0 10px"><?php c1_e( 'gap_side_title' ); ?></p>
      <ol class="gap-points">
        <?php foreach ( (array) c1_f( 'gap_points' ) as $c1_row ) : ?>
        <li><h3><?php echo esc_html( $c1_row['title'] ); ?></h3><p><?php echo esc_html( $c1_row['text'] ); ?></p></li>
        <?php endforeach; ?>
      </ol></div>
    </div>
    <?php c1_ask( 'gap_ask' ); ?>
  </div>
</section>
