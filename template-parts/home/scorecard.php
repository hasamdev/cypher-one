<?php
/**
 * Home: how we find value (scorecard).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="t-grey" id="scorecard" aria-labelledby="sc-title">
  <div class="wrap">
    <div class="head-row">
      <div class="stack"><?php c1_section_head( 'sc_eyebrow', 'sc_title', 'sc-title' ); ?></div>
      <p class="lede"><?php c1_e( 'sc_lede' ); ?></p>
    </div>
    <div class="score-grid">
      <div class="stack">
        <div class="dims">
          <?php foreach ( (array) c1_f( 'sc_dims' ) as $c1_row ) : ?>
          <div class="dim"><b><?php echo esc_html( $c1_row['title'] ); ?></b><small><?php echo esc_html( $c1_row['text'] ); ?></small></div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="example">
        <div class="example-top"><div><p class="route"><?php c1_e( 'sc_ex_label' ); ?></p><h3><?php c1_e( 'sc_ex_title' ); ?></h3></div><?php if ( c1_f( 'sc_ex_verdict' ) ) : ?><span class="verdict"><?php c1_e( 'sc_ex_verdict' ); ?></span><?php endif; ?></div>
        <div class="bars">
          <?php foreach ( (array) c1_f( 'sc_bars' ) as $c1_row ) : ?>
          <div class="bar"><span><?php echo esc_html( $c1_row['label'] ); ?></span><div class="track"><div class="fill" style="width:<?php echo esc_attr( max( 0, min( 100, (int) $c1_row['value'] ) ) ); ?>%"></div></div><span class="v">&nbsp;</span></div>
          <?php endforeach; ?>
        </div>
        <p class="route" style="margin-top:14px"><?php c1_e( 'sc_ex_note' ); ?></p>
      </div>
    </div>
    <?php c1_ask( 'sc_ask', 'margin-top:24px' ); ?>
  </div>
</section>
