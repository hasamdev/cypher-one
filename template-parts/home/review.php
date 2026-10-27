<?php
/**
 * Home: AI Adoption Review summary.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_n = 0;
?>
<section class="t-light" id="discovery" aria-labelledby="disc-title">
  <div class="wrap">
    <div class="h3-fam">
      <div>
        <p class="eyebrow"><?php c1_e( 'rev_eyebrow' ); ?></p>
        <h2 id="disc-title" style="margin-top:12px"><?php c1_h( 'rev_title' ); ?></h2>
        <p class="lede" style="margin-top:14px"><?php c1_e( 'rev_lede' ); ?></p>
        <div class="paper" aria-hidden="true" style="margin-top:28px;max-width:260px">
          <div></div><div></div>
          <div class="front"><p class="t"><?php c1_e( 'rev_paper_title' ); ?></p><span class="l"></span><span class="l"></span><span class="l s"></span><span class="l" style="margin-top:8px"></span><span class="l"></span><span class="l s"></span></div>
        </div>
      </div>
      <div>
        <?php if ( c1_f( 'rev_get' ) ) : ?><p class="h3-get"><?php c1_e( 'rev_get' ); ?></p><?php endif; ?>
        <div class="h3-deliv">
          <?php foreach ( (array) c1_f( 'rev_items' ) as $c1_row ) : ?>
            <?php ++$c1_n; ?>
          <div><span class="h3-n"><?php echo esc_html( number_format_i18n( $c1_n ) ); ?></span><p><b><?php echo esc_html( $c1_row['bold'] ); ?></b> <?php echo esc_html( $c1_row['text'] ); ?></p></div>
          <?php endforeach; ?>
        </div>
        <div class="ln-actions"><?php c1_button( 'rev_btn_label', 'rev_btn_link' ); ?><?php c1_button( 'rev_more_label', 'rev_more_link', 'ln-more' ); ?></div>
      </div>
    </div>
  </div>
</section>
