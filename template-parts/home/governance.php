<?php
/**
 * Home: "Governance, simply" — four-column new-hire analogy.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="t-grey" id="governance" aria-labelledby="gov-title">
  <div class="wrap">
    <div class="ln-head">
      <p class="eyebrow"><?php c1_e( 'gov_eyebrow' ); ?></p>
      <h2 id="gov-title"><?php c1_h( 'gov_title' ); ?></h2>
      <?php if ( c1_f( 'gov_lede' ) ) : ?><p class="lede"><?php c1_e( 'gov_lede' ); ?></p><?php endif; ?>
    </div>
    <div class="hire">
      <?php foreach ( (array) c1_f( 'gov_items' ) as $c1_row ) : ?>
        <?php if ( ! is_array( $c1_row ) ) { continue; } ?>
      <div><small><?php echo esc_html( $c1_row['kicker'] ); ?></small><h3><?php echo esc_html( $c1_row['title'] ); ?></h3><p><?php echo esc_html( $c1_row['text'] ); ?></p></div>
      <?php endforeach; ?>
    </div>
    <?php if ( c1_f( 'gov_more_label' ) ) : ?>
    <div class="ln-actions" style="margin-top:22px"><?php c1_button( 'gov_more_label', 'gov_more_link', 'ln-more' ); ?></div>
    <?php endif; ?>
  </div>
</section>
