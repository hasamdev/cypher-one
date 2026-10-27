<?php
/**
 * Home hero illustration: AI tools across departments, few of them checked.
 * Labels come from the Home page "Hero illustration" fields.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_pad    = function ( $rows, $n, $blank ) {
	$rows = array_values( (array) $rows );
	for ( $i = count( $rows ); $i < $n; $i++ ) {
		$rows[] = $blank;
	}
	return $rows;
};
$c1_checks = array_column( $c1_pad( c1_f( 'hero_fig_checks' ), 4, array( 'label' => '' ) ), 'label' );
$c1_depts  = array_column( $c1_pad( c1_f( 'hero_fig_depts' ), 6, array( 'label' => '' ) ), 'label' );
$c1_stats  = $c1_pad( c1_f( 'hero_fig_stats' ), 4, array( 'value' => '', 'label' => '', 'red' => false ) );
?>
<svg class="hero-org" viewBox="0 0 800 500" role="img" aria-label="<?php echo esc_attr( c1_f( 'hero_fig_aria' ) ); ?>">
<g font-size="13" font-weight="800" text-anchor="middle">
<rect x="20" y="30" width="160" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="100" y="57" fill="#f3f2f2"><?php echo esc_html( $c1_checks[0] ); ?></text>
<rect x="215" y="30" width="160" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="295" y="57" fill="#f3f2f2"><?php echo esc_html( $c1_checks[1] ); ?></text>
<rect x="410" y="30" width="160" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="490" y="57" fill="#f3f2f2"><?php echo esc_html( $c1_checks[2] ); ?></text>
<rect x="605" y="30" width="160" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="685" y="57" fill="#f3f2f2"><?php echo esc_html( $c1_checks[3] ); ?></text>
</g><g fill="none" stroke-width="1.7">
<path class="hflow" d="M77 249 C77 202 92 158 92 118" stroke="#ec3013"/>
<path class="hflow" d="M118 204 C118 157 233 172 233 132" stroke="#ec3013"/>
<path class="hflow-s" d="M205 234 C205 157 100 140 100 74" stroke="#f3f2f2"/>
<path class="hflow" d="M250 199 C250 152 406 158 406 118" stroke="#ec3013"/>
<path class="hflow" d="M340 244 C340 197 564 172 564 132" stroke="#ec3013"/>
<path class="hflow-s" d="M380 204 C380 127 295 140 295 74" stroke="#f3f2f2"/>
<path class="hflow" d="M470 224 C470 177 483 158 483 118" stroke="#ec3013"/>
<path class="hflow" d="M520 249 C520 202 627 172 627 132" stroke="#ec3013"/>
<path class="hflow" d="M610 209 C610 162 405 158 405 118" stroke="#ec3013"/>
<path class="hflow-s" d="M680 239 C680 162 685 140 685 74" stroke="#f3f2f2"/>
<path class="hflow" d="M730 204 C730 157 701 172 701 132" stroke="#ec3013"/>
</g><g stroke="#ec3013" stroke-width="2.6" stroke-linecap="square">
<path d="M87 106 l10 10 M97 106 l-10 10"/>
<path d="M228 120 l10 10 M238 120 l-10 10"/>
<path d="M401 106 l10 10 M411 106 l-10 10"/>
<path d="M559 120 l10 10 M569 120 l-10 10"/>
<path d="M478 106 l10 10 M488 106 l-10 10"/>
<path d="M622 120 l10 10 M632 120 l-10 10"/>
<path d="M400 106 l10 10 M410 106 l-10 10"/>
<path d="M696 120 l10 10 M706 120 l-10 10"/>
</g><g font-size="10" font-weight="800" text-anchor="middle">
<circle cx="77" cy="262" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="77" y="266" fill="#ff9783">AI</text>
<circle cx="118" cy="217" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="118" y="221" fill="#ff9783">AI</text>
<circle cx="205" cy="247" r="13" fill="#201e1d" stroke="#f3f2f2" stroke-width="2"/><text x="205" y="251" fill="#f3f2f2">AI</text>
<circle cx="250" cy="212" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="250" y="216" fill="#ff9783">AI</text>
<circle cx="340" cy="257" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="340" y="261" fill="#ff9783">AI</text>
<circle cx="380" cy="217" r="13" fill="#201e1d" stroke="#f3f2f2" stroke-width="2"/><text x="380" y="221" fill="#f3f2f2">AI</text>
<circle cx="470" cy="237" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="470" y="241" fill="#ff9783">AI</text>
<circle cx="520" cy="262" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="520" y="266" fill="#ff9783">AI</text>
<circle cx="610" cy="222" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="610" y="226" fill="#ff9783">AI</text>
<circle cx="680" cy="252" r="13" fill="#201e1d" stroke="#f3f2f2" stroke-width="2"/><text x="680" y="256" fill="#f3f2f2">AI</text>
<circle cx="730" cy="217" r="13" fill="#201e1d" stroke="#ec3013" stroke-width="2"/><text x="730" y="221" fill="#ff9783">AI</text>
</g><g fill="#7fd1a8" font-size="14" font-weight="800" text-anchor="middle">
</g><g stroke="#4a4747" stroke-width="2">
<line x1="77" y1="275" x2="77" y2="320"/>
<line x1="118" y1="230" x2="100" y2="320"/>
<line x1="205" y1="260" x2="215" y2="320"/>
<line x1="250" y1="225" x2="235" y2="320"/>
<line x1="340" y1="270" x2="345" y2="320"/>
<line x1="380" y1="230" x2="365" y2="320"/>
<line x1="470" y1="250" x2="475" y2="320"/>
<line x1="520" y1="275" x2="495" y2="320"/>
<line x1="610" y1="235" x2="605" y2="320"/>
<line x1="680" y1="265" x2="625" y2="320"/>
<line x1="730" y1="230" x2="735" y2="320"/>
</g><g font-size="14" font-weight="800" text-anchor="middle" fill="#f3f2f2">
<rect x="30" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="85" y="348"><?php echo esc_html( $c1_depts[0] ); ?></text>
<rect x="160" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="215" y="348"><?php echo esc_html( $c1_depts[1] ); ?></text>
<rect x="290" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="345" y="348"><?php echo esc_html( $c1_depts[2] ); ?></text>
<rect x="420" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="475" y="348"><?php echo esc_html( $c1_depts[3] ); ?></text>
<rect x="550" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="605" y="348"><?php echo esc_html( $c1_depts[4] ); ?></text>
<rect x="680" y="320" width="100" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="730" y="348"><?php echo esc_html( $c1_depts[5] ); ?></text>
</g><g font-weight="800"><rect x="30" y="398" width="740" height="72" fill="#2d2b2b" stroke="#4a4747" stroke-width="2"/>
<text x="60" y="430" font-size="28" fill="<?php echo esc_attr( $c1_stats[0]['red'] ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[0]['value'] ); ?></text><text x="60" y="452" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[0]['label'] ); ?></text>
<text x="240" y="430" font-size="28" fill="<?php echo esc_attr( $c1_stats[1]['red'] ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[1]['value'] ); ?></text><text x="240" y="452" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[1]['label'] ); ?></text>
<text x="400" y="430" font-size="28" fill="<?php echo esc_attr( $c1_stats[2]['red'] ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[2]['value'] ); ?></text><text x="400" y="452" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[2]['label'] ); ?></text>
<text x="590" y="430" font-size="28" fill="<?php echo esc_attr( $c1_stats[3]['red'] ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[3]['value'] ); ?></text><text x="590" y="452" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[3]['label'] ); ?></text>
</g></svg>
