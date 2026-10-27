<?php
/**
 * Home: how we work.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="t-light" id="integrated" aria-labelledby="int-title">
  <div class="wrap">
    <div class="head-row">
      <div class="stack"><?php c1_section_head( 'int_eyebrow', 'int_title', 'int-title' ); ?></div>
      <p class="lede"><?php c1_e( 'int_lede' ); ?></p>
    </div>
    <div class="grid3" style="margin-bottom:28px">
      <?php foreach ( (array) c1_f( 'int_steps' ) as $c1_row ) : ?>
      <div><?php if ( $c1_row['label'] ) : ?><p class="subhead" style="margin:0 0 8px"><?php echo esc_html( $c1_row['label'] ); ?></p><?php endif; ?><h3><?php echo esc_html( $c1_row['title'] ); ?></h3><p><?php echo esc_html( $c1_row['text'] ); ?></p><?php if ( $c1_row['result'] ) : ?><p class="eg"><b><?php echo esc_html( $c1_row['result_label'] ); ?></b> <?php echo esc_html( $c1_row['result'] ); ?></p><?php endif; ?></div>
      <?php endforeach; ?>
    </div>
    <?php c1_ask( 'int_ask' ); ?>
  </div>
</section>
