<?php
/**
 * Home: score your own idea (guided scorer). Scoring weights come from the
 * fields and are read by assets/js/main.js from data attributes.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_questions = (array) c1_f( 'ga_questions' );
$c1_lean      = isset( $args['variant'] ) && 'lean' === $args['variant'];
?>
<section class="<?php echo esc_attr( isset( $args['class'] ) ? $args['class'] : 't-light' ); ?>" id="assess" aria-labelledby="ga-title">
  <div class="wrap">
    <div class="head-row">
    <?php if ( $c1_lean ) : ?>
      <div class="stack" style="max-width:none"><?php c1_section_head( 'ga_eyebrow', 'ga_title', 'ga-title' ); ?><?php if ( c1_f( 'ga_sub' ) ) : ?><p class="sc-sub"><?php c1_e( 'ga_sub' ); ?></p><?php endif; ?></div>
    <?php else : ?>
      <div class="stack"><?php c1_section_head( 'ga_eyebrow', 'ga_title', 'ga-title' ); ?></div>
      <p class="lede"><?php c1_e( 'ga_lede' ); ?></p>
    <?php endif; ?>
    </div>
    <div class="ga">
      <form class="ga-card" id="gaForm" onsubmit="return false" data-base="<?php echo esc_attr( (int) c1_f( 'ga_base' ) ); ?>" data-min="<?php echo esc_attr( (int) c1_f( 'ga_min' ) ); ?>" data-max="<?php echo esc_attr( (int) c1_f( 'ga_max' ) ); ?>">
        <?php if ( ! $c1_lean && c1_f( 'ga_usecase_label' ) ) : ?>
        <label class="lbl" for="useCase"><?php c1_e( 'ga_usecase_label' ); ?></label>
        <textarea id="useCase" placeholder="<?php echo esc_attr( c1_f( 'ga_usecase_placeholder' ) ); ?>"></textarea>
        <?php endif; ?>
        <?php
		$c1_n = 0;
		foreach ( $c1_questions as $c1_q ) :
			if ( empty( $c1_q['options'] ) ) {
				continue;
			}
			++$c1_n;
			?>
        <div class="q"><fieldset data-q="<?php echo esc_attr( $c1_n ); ?>"><legend><?php echo esc_html( $c1_n . '. ' . $c1_q['question'] ); ?></legend><div class="opts"><?php foreach ( array_values( $c1_q['options'] ) as $c1_i => $c1_o ) : ?><button type="button" class="opt" data-v="<?php echo esc_attr( $c1_i ); ?>" data-w="<?php echo esc_attr( (int) $c1_o['weight'] ); ?>" data-back="<?php echo esc_attr( $c1_o['against'] ); ?>" data-for="<?php echo esc_attr( $c1_o['favour'] ); ?>" aria-pressed="false"><?php echo esc_html( $c1_o['label'] ); ?></button><?php endforeach; ?></div></fieldset></div>
        <?php endforeach; ?>
      </form>
      <aside class="result" aria-live="polite">
        <p class="route" style="color:var(--band-muted)"><?php c1_e( 'ga_result_label' ); ?></p>
        <p class="pct" id="gaPct">0%</p>
        <div class="meter"><i id="gaMeter" style="width:0%"></i></div>
        <p class="route" id="gaHint" style="color:var(--band-muted);margin-top:8px"><?php
			/* translators: %s: number of questions. */
			echo esc_html( sprintf( _n( 'Answer the %s question to see your score.', 'Answer the %s questions to see your score.', $c1_n, 'cypher-one' ), c1_number_word( $c1_n ) ) );
		?></p>
        <div><h4><?php c1_e( 'ga_back_title' ); ?></h4><ul id="gaBack"></ul></div>
        <div><h4><?php c1_e( 'ga_for_title' ); ?></h4><ul id="gaFor"></ul></div>
        <?php if ( c1_f( 'ga_caveat' ) ) : ?><p class="caveat"><?php c1_e( 'ga_caveat' ); ?></p><?php endif; ?>
        <p style="margin-top:16px"><?php c1_button( 'ga_btn_label', 'ga_btn_link' ); ?></p>
      </aside>
    </div>
    <?php c1_ask( 'ga_ask' ); ?>
  </div>
</section>
