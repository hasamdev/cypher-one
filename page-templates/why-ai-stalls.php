<?php
/**
 * Template Name: Why AI fails
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'why' );
get_header();

$c1_stages = array_values( (array) c1_f( 'rt_stages' ) );
$c1_total  = count( $c1_stages );

/**
 * Source badge: name + year, linking to the research.
 *
 * @param string $name Source.
 * @param string $year Year.
 * @param string $url  URL.
 * @return string
 */
$c1_badge = function ( $name, $year, $url ) {
	if ( '' === trim( (string) $name ) ) {
		return '';
	}
	return '<a class="sb" href="' . esc_url( $url ) . '" rel="noopener"><b>' . esc_html( $name ) . '</b>' . ( $year ? '<span>' . esc_html( $year ) . '</span>' : '' ) . '</a>';
};

/**
 * Small chart for a root cause: a ring (one figure) or two bars (compare).
 *
 * @param array $row Cause row.
 * @return string
 */
$c1_ring = function ( $row ) {
	$v = max( 0, min( 100, (float) $row['value'] ) );
	if ( 'compare' === $row['chart'] ) {
		$v2 = max( 0, min( 100, (float) $row['value2'] ) );
		$h1 = round( $v * 68 / 75 );
		$h2 = round( $v2 * 68 / 75 );
		/* translators: %s: percentage figure. */
		$l1 = sprintf( __( '~%s%%', 'cypher-one' ), number_format_i18n( $v ) );
		/* translators: %s: percentage figure. */
		$l2 = sprintf( __( '~%s%%', 'cypher-one' ), number_format_i18n( $v2 ) );
		return '<svg class="ring" viewBox="0 0 110 110" aria-hidden="true"><rect x="18" y="' . ( 92 - $h1 ) . '" width="30" height="' . $h1 . '" fill="var(--accent)"/><rect x="62" y="' . ( 92 - $h2 ) . '" width="30" height="' . $h2 . '" fill="var(--divider-soft)"/><text x="33" y="' . ( 86 - $h1 ) . '" text-anchor="middle" font-size="13" font-weight="800" fill="var(--ink)">' . esc_html( $l1 ) . '</text><text x="77" y="' . ( 86 - $h2 ) . '" text-anchor="middle" font-size="13" font-weight="800" fill="var(--ink)">' . esc_html( $l2 ) . '</text><text x="33" y="106" text-anchor="middle" font-size="10" fill="var(--muted)">' . esc_html( $row['label1'] ) . '</text><text x="77" y="106" text-anchor="middle" font-size="10" fill="var(--muted)">' . esc_html( $row['label2'] ) . '</text></svg>';
	}
	$dash = number_format( 263.9 * $v / 100, 1, '.', '' );
	/* translators: %s: percentage figure. */
	$label = sprintf( __( '%s%%', 'cypher-one' ), number_format_i18n( $v ) );
	return '<svg class="ring" viewBox="0 0 110 110" aria-hidden="true"><circle cx="55" cy="55" r="42" fill="none" stroke="var(--divider-soft)" stroke-width="12"/><circle cx="55" cy="55" r="42" fill="none" stroke="var(--accent)" stroke-width="12" stroke-dasharray="' . $dash . ' 263.9" transform="rotate(-90 55 55)"/><text x="55" y="63" text-anchor="middle" font-size="24" font-weight="800" fill="var(--ink)">' . esc_html( $label ) . '</text></svg>';
};

$c1_red = max( 0, min( 100, (int) c1_f( 'wf_red' ) ) );
?>
<div class="page is-active" id="page-why">

<section class="band t-dark" id="causes" aria-labelledby="causes-title">
  <div class="wrap">
    <div class="wf-grid">
      <div>
        <p class="eyebrow"><?php c1_e( 'wf_eyebrow' ); ?></p>
        <h1 id="causes-title" class="wf-h"><?php c1_h( 'wf_title' ); ?></h1>
        <p class="lede" style="margin-top:18px"><?php c1_e( 'wf_lede' ); ?></p>
        <?php $c1_sources = (array) c1_f( 'wf_sources' ); ?>
        <?php if ( $c1_sources ) : ?>
        <div class="sb-row" style="margin-top:20px"><?php foreach ( $c1_sources as $c1_src ) { echo $c1_badge( $c1_src['name'], $c1_src['year'], $c1_src['url'] ); } // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <?php endif; ?>
      </div>
      <figure class="wf-fig"><svg viewBox="0 0 236 236" role="img" aria-label="<?php echo esc_attr( c1_f( 'wf_aria' ) ); ?>">
		<?php
		for ( $c1_i = 0; $c1_i < 100; $c1_i++ ) {
			printf( '<rect x="%1$d" y="%2$d" width="20" height="20" fill="%3$s"/>', ( $c1_i % 10 ) * 24, (int) floor( $c1_i / 10 ) * 24, $c1_i >= 100 - $c1_red ? '#ec3013' : '#4a4747' );
		}
		?>
		</svg>
        <figcaption><span class="k1"></span><?php c1_e( 'wf_key1' ); ?> <span class="k2"></span><?php c1_e( 'wf_key2' ); ?><?php if ( c1_f( 'wf_key_note' ) ) : ?> &middot; <?php c1_e( 'wf_key_note' ); ?><?php endif; ?></figcaption></figure>
    </div>
  </div>
</section>

<section class="t-light" id="root-causes" aria-labelledby="rc-title">
  <div class="wrap">
    <div class="ln-head" style="margin-bottom:32px"><p class="eyebrow"><?php c1_e( 'rc_eyebrow' ); ?></p><h2 id="rc-title" style="margin-top:8px"><?php c1_h( 'rc_title' ); ?></h2></div>
    <div class="rc-list">
      <?php foreach ( (array) c1_f( 'rc_causes' ) as $c1_row ) : ?>
      <article class="rc"<?php echo $c1_row['anchor'] ? ' id="' . esc_attr( sanitize_title( $c1_row['anchor'] ) ) . '"' : ''; ?>>
        <div class="rc-vis"><?php echo $c1_ring( $c1_row ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <div class="rc-main"><p class="rc-k"><?php echo esc_html( $c1_row['area'] ); ?></p><h3><?php echo esc_html( $c1_row['title'] ); ?></h3><p><?php echo esc_html( $c1_row['text'] ); ?></p><?php if ( $c1_row['stat'] ) : ?><p class="rc-stat"><?php echo esc_html( $c1_row['stat'] ); ?></p><?php endif; ?><?php echo $c1_badge( $c1_row['src_name'], $c1_row['src_year'], $c1_row['src_url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <div class="rc-fix"><p class="rc-fk"><?php echo esc_html( $c1_row['fix_label'] ); ?></p><p><?php echo esc_html( $c1_row['fix'] ); ?></p><?php if ( $c1_row['more'] ) : ?><a class="ln-more" href="<?php echo esc_url( c1_url( $c1_row['link'] ) ); ?>"><?php echo esc_html( $c1_row['more'] ); ?></a><?php endif; ?></div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if ( $c1_total ) : ?>
<section class="t-grey" id="timeline" aria-labelledby="rt-title">
  <div class="wrap">
    <div class="head-row">
      <div class="stack"><?php c1_section_head( 'rt_eyebrow', 'rt_title', 'rt-title' ); ?></div>
      <p class="lede"><?php c1_e( 'rt_lede' ); ?></p>
    </div>
    <div class="rt-tabs" role="tablist" aria-label="<?php esc_attr_e( 'AI risk timeline stages', 'cypher-one' ); ?>">
      <?php foreach ( $c1_stages as $c1_i => $c1_s ) : ?>
      <button class="rt-tab" role="tab" id="rt-tab-<?php echo esc_attr( $c1_i ); ?>" aria-controls="rt-panel-<?php echo esc_attr( $c1_i ); ?>" aria-selected="<?php echo 0 === $c1_i ? 'true' : 'false'; ?>" tabindex="<?php echo 0 === $c1_i ? '0' : '-1'; ?>" type="button"><span><?php echo esc_html( sprintf( '%02d', $c1_i + 1 ) ); ?></span><strong><?php echo esc_html( $c1_s['title'] ); ?></strong><i aria-hidden="true"></i></button>
      <?php endforeach; ?>
    </div>
    <div class="rt-panels">
      <?php foreach ( $c1_stages as $c1_i => $c1_s ) : ?>
      <div class="rt-panel" role="tabpanel" id="rt-panel-<?php echo esc_attr( $c1_i ); ?>" aria-labelledby="rt-tab-<?php echo esc_attr( $c1_i ); ?>" tabindex="0"<?php echo $c1_i ? ' hidden' : ''; ?>>
        <div><p class="label">
        <?php
			/* translators: 1: stage number, 2: number of stages. */
			echo esc_html( sprintf( __( 'Stage %1$s of %2$s', 'cypher-one' ), sprintf( '%02d', $c1_i + 1 ), sprintf( '%02d', $c1_total ) ) );
		?>
        </p><h3><?php echo esc_html( $c1_s['title'] ); ?></h3><p class="lede"><?php echo esc_html( $c1_s['lede'] ); ?></p></div>
        <div<?php echo 0 === $c1_i ? ' class="has-did"' : ''; ?>><p class="label"><?php esc_html_e( 'Risk surface', 'cypher-one' ); ?></p><div class="risk-surface-bars" aria-hidden="true"><?php for ( $c1_b = 0; $c1_b < $c1_total; $c1_b++ ) { echo $c1_b < $c1_i ? '<i class="on"></i>' : ( $c1_b === $c1_i ? '<i class="now"></i>' : '<i></i>' ); } ?></div><span class="visually-hidden">
        <?php
			/* translators: 1: level, 2: number of levels. */
			echo esc_html( sprintf( __( 'Risk surface at level %1$d of %2$d.', 'cypher-one' ), $c1_i + 1, $c1_total ) );
		?>
        </span>
          <div class="rt-facts"><div><p class="label"><?php esc_html_e( 'What changes', 'cypher-one' ); ?></p><p><?php echo esc_html( $c1_s['changes'] ); ?></p></div><div class="risk"><p class="label"><?php esc_html_e( 'New exposure', 'cypher-one' ); ?></p><p><?php echo esc_html( $c1_s['exposure'] ); ?></p></div></div></div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php c1_ask( 'rt_ask' ); ?>
  </div>
</section>
<?php endif; ?>

<section class="band t-dark" id="control-gap" aria-labelledby="cg-title">
  <div class="wrap">
    <div class="ln-head"><p class="eyebrow"><?php c1_e( 'cg_eyebrow' ); ?></p><h2 id="cg-title"><?php c1_h( 'cg_title' ); ?></h2><?php if ( c1_f( 'cg_lede' ) ) : ?><p class="lede"><?php c1_e( 'cg_lede' ); ?></p><?php endif; ?></div>
    <div class="cg">
      <?php foreach ( (array) c1_f( 'cg_stats' ) as $c1_row ) : ?>
        <?php $c1_v = max( 0, min( 100, (float) $c1_row['value'] ) ); ?>
      <div><div class="cg-bar"><i style="width:<?php echo esc_attr( $c1_v ); ?>%"></i></div><p class="cg-n">
      <?php
		/* translators: %s: percentage figure. */
		echo esc_html( sprintf( __( '%s%%', 'cypher-one' ), number_format_i18n( $c1_v ) ) );
		?>
      </p><p><?php echo esc_html( $c1_row['text'] ); ?></p><?php echo $c1_badge( $c1_row['src_name'], $c1_row['src_year'], $c1_row['src_url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="t-light" id="readiness" aria-labelledby="ready-title">
  <div class="wrap">
    <div class="ready">
      <div class="stack">
        <?php c1_section_head( 'rd_eyebrow', 'rd_title', 'ready-title' ); ?>
        <?php foreach ( (array) c1_f( 'rd_paragraphs' ) as $c1_row ) : ?>
        <p class="lede"><?php echo esc_html( $c1_row['text'] ); ?></p>
        <?php endforeach; ?>
        <?php c1_ask( 'rd_ask', '' ); ?>
        <div class="row"><?php c1_button( 'rd_btn_label', 'rd_btn_link' ); ?></div>
      </div>
      <figure class="system-fig">
        <div class="system-fig-head" aria-hidden="true"><span><?php c1_e( 'rd_fig_title' ); ?></span><span><?php c1_e( 'rd_fig_tag' ); ?></span></div>
        <figcaption>
          <ul class="legend"><li><i class="sw"></i><?php c1_e( 'rd_legend_1' ); ?></li><li><i class="sw sw-red"></i><?php c1_e( 'rd_legend_2' ); ?></li></ul>
          <span><?php c1_e( 'rd_caption' ); ?></span>
        </figcaption>
        <?php get_template_part( 'template-parts/charts/readiness-chart' ); ?>
      </figure>
    </div>
  </div>
</section>
</div>
<?php
get_footer();
