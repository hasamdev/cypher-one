<?php
/**
 * Home: short readiness-gap section with the chart.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="t-grey" id="gap" aria-labelledby="gap-title">
  <div class="wrap">
    <div class="ln-split ln-split--chart">
      <div>
        <p class="eyebrow"><?php c1_e( 'gap_eyebrow' ); ?></p>
        <h2 id="gap-title" style="margin-top:12px"><?php c1_h( 'gap_title' ); ?></h2>
        <p class="lede" style="margin-top:14px"><?php c1_e( 'gap_lede' ); ?></p>
        <div class="ln-actions"><?php c1_button( 'gap_btn_label', 'gap_btn_link' ); ?><?php c1_button( 'gap_more_label', 'gap_more_link', 'ln-more' ); ?></div>
      </div>
      <div><figure class="gap-chart">
        <?php get_template_part( 'template-parts/charts/gap-chart' ); ?>
        <?php if ( c1_f( 'gap_caption' ) ) : ?><figcaption class="caption"><?php c1_e( 'gap_caption' ); ?></figcaption><?php endif; ?>
      </figure></div>
    </div>
  </div>
</section>
