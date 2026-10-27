<?php
/**
 * Home: cost of waiting calculator.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_cur       = c1_f( 'calc_currency' );
$c1_team_max  = max( 1, (int) c1_f( 'calc_team_max' ) );
$c1_hours_max = max( 1, (int) c1_f( 'calc_hours_max' ) );
$c1_rate_max  = max( 1, (int) c1_f( 'calc_rate_max' ) );
$c1_rate_step = max( 1, (int) c1_f( 'calc_rate_step' ) );
$c1_team_val  = min( $c1_team_max, max( 0, (int) c1_f( 'calc_team_value' ) ) );
$c1_hours_val = min( $c1_hours_max, max( 0, (int) c1_f( 'calc_hours_value' ) ) );
$c1_rate_val  = min( $c1_rate_max, max( 0, (int) c1_f( 'calc_rate_value' ) ) );
?>
<section class="<?php echo esc_attr( isset( $args['class'] ) ? $args['class'] : 't-grey' ); ?>" id="calculator" aria-labelledby="calc-title">
  <div class="wrap">
    <div class="head-row">
      <div class="stack"><?php c1_section_head( 'calc_eyebrow', 'calc_title', 'calc-title' ); ?></div>
      <p class="lede"><?php c1_e( 'calc_lede' ); ?></p>
    </div>
    <form class="calc" id="calc" onsubmit="return false" aria-describedby="calc-note"
      data-currency="<?php echo esc_attr( $c1_cur ); ?>"
      data-reclaim="<?php echo esc_attr( (float) c1_f( 'calc_reclaim_pct' ) / 100 ); ?>"
      data-month-hours="<?php echo esc_attr( max( 1, (float) c1_f( 'calc_month_hours' ) ) ); ?>"
      data-weeks="<?php echo esc_attr( max( 1, (float) c1_f( 'calc_weeks' ) ) ); ?>">
      <fieldset class="calc-controls" aria-label="<?php echo esc_attr( c1_f( 'calc_legend' ) ); ?>">
        <div class="calc-legend"><?php c1_e( 'calc_legend' ); ?></div>
        <div class="range-field">
          <div class="range-head"><label for="team"><?php c1_e( 'calc_team_label' ); ?></label><output id="team-out" for="team"><?php echo esc_html( $c1_team_val ); ?></output></div>
          <input type="range" id="team" name="team" min="0" max="<?php echo esc_attr( $c1_team_max ); ?>" step="1" value="<?php echo esc_attr( $c1_team_val ); ?>">
          <div class="range-scale" aria-hidden="true">
          <?php
			/* translators: %s: maximum team size. */
			echo esc_html( sprintf( __( '0 to %s people', 'cypher-one' ), number_format_i18n( $c1_team_max ) ) );
			?>
          </div>
        </div>
        <div class="range-field">
          <div class="range-head"><label for="hours"><?php c1_e( 'calc_hours_label' ); ?></label><output id="hours-out" for="hours"><?php echo esc_html( $c1_hours_val ); ?></output></div>
          <p class="range-hint" id="hours-hint"><?php c1_e( 'calc_hours_hint' ); ?></p>
          <input type="range" id="hours" name="hours" min="0" max="<?php echo esc_attr( $c1_hours_max ); ?>" step="1" value="<?php echo esc_attr( $c1_hours_val ); ?>" aria-describedby="hours-hint">
          <div class="range-scale" aria-hidden="true">
          <?php
			/* translators: %s: maximum hours per week. */
			echo esc_html( sprintf( __( '0 to %s hours a week', 'cypher-one' ), number_format_i18n( $c1_hours_max ) ) );
			?>
          </div>
        </div>
        <div class="range-field">
          <div class="range-head"><label for="rate"><?php c1_e( 'calc_rate_label' ); ?></label><output id="rate-out" for="rate"><?php echo esc_html( $c1_cur . ' ' . number_format_i18n( $c1_rate_val ) ); ?></output></div>
          <input type="range" id="rate" name="rate" min="0" max="<?php echo esc_attr( $c1_rate_max ); ?>" step="<?php echo esc_attr( $c1_rate_step ); ?>" value="<?php echo esc_attr( $c1_rate_val ); ?>">
          <div class="range-scale" aria-hidden="true">
          <?php
			/* translators: 1: currency code, 2: maximum monthly cost. */
			echo esc_html( sprintf( __( '%1$s 0 to %2$s a month', 'cypher-one' ), $c1_cur, number_format_i18n( $c1_rate_max ) ) );
			?>
          </div>
        </div>
        <p class="range-hint" id="calc-note" style="margin-top:14px"><?php c1_h( 'calc_note' ); ?></p>
      </fieldset>
      <div class="calc-viz" aria-live="polite" aria-atomic="false">
        <div><p class="viz-label"><?php c1_e( 'calc_lost_label' ); ?></p><p class="viz-big"><span data-r="lost">&nbsp;</span><small><?php c1_e( 'calc_per_month' ); ?></small></p></div>
        <div class="hbars" aria-hidden="true">
          <div class="hbar"><div class="hbar-top"><span><?php c1_e( 'calc_today_label' ); ?></span><strong data-r="lost">&nbsp;</strong></div><div class="hbar-track"><div class="hbar-fill" style="width:100%"></div></div></div>
          <div class="hbar"><div class="hbar-top"><span><?php c1_e( 'calc_after_label' ); ?></span><strong data-r="left">&nbsp;</strong></div><div class="hbar-track"><div class="hbar-fill red" style="width:<?php echo esc_attr( max( 0, 100 - (float) c1_f( 'calc_reclaim_pct' ) ) ); ?>%"></div></div></div>
        </div>
        <div class="viz-pair">
          <div class="hot"><p class="viz-label"><?php c1_e( 'calc_month_label' ); ?></p><strong data-r="save">&nbsp;</strong></div>
          <div><p class="viz-label"><?php c1_e( 'calc_year_label' ); ?></p><strong data-r="year">&nbsp;</strong></div>
        </div>
        <div><p class="viz-label"><?php echo str_replace( '<strong data-r="fte">', '<strong style="color:var(--band-fg)" data-r="fte">', c1_calc_tokens( c1_f( 'calc_fte_text' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p><ul class="fte-grid" id="fte-grid" aria-hidden="true"></ul></div>
        <div class="calc-summary">
          <p><?php echo c1_calc_tokens( c1_f( 'calc_summary_1' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
          <?php if ( c1_f( 'calc_summary_2' ) ) : ?><p><?php echo c1_calc_tokens( c1_f( 'calc_summary_2' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p><?php endif; ?>
        </div>
        <div class="calc-next">
          <p><?php echo c1_calc_tokens( c1_f( 'calc_next' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
          <div><?php c1_button( 'calc_btn_label', 'calc_btn_link' ); ?></div>
        </div>
      </div>
    </form>
    <?php c1_ask( 'calc_ask' ); ?>
  </div>
</section>
