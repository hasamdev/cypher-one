<?php
/**
 * Home: what a discovery delivers.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="t-light" id="report" aria-labelledby="rep-title">
  <div class="wrap">
    <div class="head-row">
      <div class="stack"><?php c1_section_head( 'rep_eyebrow', 'rep_title', 'rep-title' ); ?></div>
      <p class="lede"><?php c1_e( 'rep_lede' ); ?></p>
    </div>
    <div class="report" style="align-items:start">
      <div class="paper" aria-hidden="true">
        <div></div><div></div>
        <div class="front"><p class="t"><?php c1_e( 'rep_paper_title' ); ?></p><span class="l"></span><span class="l"></span><span class="l s"></span><span class="l" style="margin-top:8px"></span><span class="l"></span><span class="l s"></span><span class="l" style="margin-top:8px"></span><span class="l s"></span></div>
      </div>
      <div class="stack">
        <div class="rsec" style="margin-top:0">
          <?php foreach ( (array) c1_f( 'rep_items' ) as $c1_row ) : ?>
          <div><h3><?php echo esc_html( $c1_row['title'] ); ?></h3><p><?php echo esc_html( $c1_row['text'] ); ?></p></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php c1_ask( 'rep_ask', 'margin-top:24px' ); ?>
  </div>
</section>
