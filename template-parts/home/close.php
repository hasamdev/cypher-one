<?php
/**
 * Home: talk to us.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="band t-dark" id="close" aria-labelledby="close-title">
  <div class="wrap">
    <div class="close-grid" style="grid-template-columns:1fr">
      <div class="stack">
        <?php c1_section_head( 'close_eyebrow', 'close_title', 'close-title' ); ?>
        <p class="lede"><?php c1_e( 'close_lede' ); ?></p>
        <?php c1_ask( 'close_ask', '' ); ?>
        <div class="row"><?php c1_button( 'close_btn1_label', 'close_btn1_link' ); ?><?php c1_button( 'close_btn2_label', 'close_btn2_link', 'btn btn-ghost' ); ?></div>
      </div>
    </div>
  </div>
</section>
