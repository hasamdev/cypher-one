<?php
/**
 * Home hero illustration: AI in use across six departments, tested against five
 * readiness domains; most land on domains that are not ready.
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
$c1_checks = array_column( $c1_pad( c1_f( 'hero_fig_checks' ), 5, array( 'label' => '' ) ), 'label' );
$c1_depts  = array_column( $c1_pad( c1_f( 'hero_fig_depts' ), 6, array( 'label' => '' ) ), 'label' );
$c1_stats  = $c1_pad( c1_f( 'hero_fig_stats' ), 4, array( 'value' => '', 'label' => '', 'red' => true ) );
$c1_kicker = c1_f( 'hero_fig_kicker' );
?>
<svg class="hero-org" viewBox="0 0 800 500" role="img" aria-label="<?php echo esc_attr( c1_f( 'hero_fig_aria' ) ); ?>">
<?php if ( $c1_kicker ) : ?><text x="20" y="20" font-size="11" font-weight="800" fill="#bab6b6" letter-spacing="2.4"><?php echo esc_html( $c1_kicker ); ?></text><?php endif; ?>
<g font-size="13" font-weight="800" text-anchor="middle">
<rect rx="4" x="20" y="34" width="136" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="88" y="61" fill="#f3f2f2"><?php echo esc_html( $c1_checks[0] ); ?></text>
<rect rx="4" x="176" y="34" width="136" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="244" y="61" fill="#f3f2f2"><?php echo esc_html( $c1_checks[1] ); ?></text>
<rect rx="4" x="332" y="34" width="136" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="400" y="61" fill="#f3f2f2"><?php echo esc_html( $c1_checks[2] ); ?></text>
<rect rx="4" x="488" y="34" width="136" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="556" y="61" fill="#f3f2f2"><?php echo esc_html( $c1_checks[3] ); ?></text>
<rect rx="4" x="644" y="34" width="136" height="44" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="712" y="61" fill="#f3f2f2"><?php echo esc_html( $c1_checks[4] ); ?></text>
</g><g fill="none" stroke-width="1.7">
<path class="hflow" d="M77 249 C77 200 60 160 60 122" stroke="#ec3013"/>
<path class="hflow" d="M118 204 C118 160 244 160 244 122" stroke="#ec3013"/>
<path class="hflow-s" d="M205 234 C205 160 110 150 100 78" stroke="#f3f2f2"/>
<path class="hflow" d="M250 199 C250 155 380 160 380 122" stroke="#ec3013"/>
<path class="hflow" d="M340 244 C340 200 556 170 556 122" stroke="#ec3013"/>
<path class="hflow-s" d="M380 204 C380 130 262 140 262 78" stroke="#f3f2f2"/>
<path class="hflow" d="M470 224 C470 180 420 160 420 122" stroke="#ec3013"/>
<path class="hflow" d="M520 249 C520 205 712 170 712 122" stroke="#ec3013"/>
<path class="hflow" d="M610 209 C610 165 580 160 576 122" stroke="#ec3013"/>
<path class="hflow-s" d="M680 239 C680 160 700 140 700 78" stroke="#f3f2f2"/>
<path class="hflow" d="M730 204 C730 160 730 160 730 122" stroke="#ec3013"/>
<path class="hflow-s" d="M45 209 C45 150 380 140 386 78" stroke="#f3f2f2"/>
<path class="hflow-s" d="M440 249 C440 190 520 150 520 78" stroke="#f3f2f2"/>
<path class="hflow-s" d="M765 239 C765 170 765 120 765 78" stroke="#f3f2f2"/>
</g><g stroke="#ec3013" stroke-width="2.6" stroke-linecap="square">
<path d="M55 110 l10 10 M65 110 l-10 10"/>
<path d="M239 110 l10 10 M249 110 l-10 10"/>
<path d="M375 110 l10 10 M385 110 l-10 10"/>
<path d="M551 110 l10 10 M561 110 l-10 10"/>
<path d="M415 110 l10 10 M425 110 l-10 10"/>
<path d="M707 110 l10 10 M717 110 l-10 10"/>
<path d="M571 110 l10 10 M581 110 l-10 10"/>
<path d="M725 110 l10 10 M735 110 l-10 10"/>
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
<circle cx="45" cy="222" r="13" fill="#201e1d" stroke="#f3f2f2" stroke-width="2"/><text x="45" y="226" fill="#f3f2f2">AI</text>
<circle cx="440" cy="262" r="13" fill="#201e1d" stroke="#f3f2f2" stroke-width="2"/><text x="440" y="266" fill="#f3f2f2">AI</text>
<circle cx="765" cy="252" r="13" fill="#201e1d" stroke="#f3f2f2" stroke-width="2"/><text x="765" y="256" fill="#f3f2f2">AI</text>
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
<line x1="45" y1="235" x2="60" y2="320"/>
<line x1="440" y1="275" x2="455" y2="320"/>
<line x1="765" y1="265" x2="760" y2="320"/>
</g><g font-size="14" font-weight="800" text-anchor="middle" fill="#f3f2f2">
<rect rx="4" x="30" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="85" y="348"><?php echo esc_html( $c1_depts[0] ); ?></text>
<rect rx="4" x="160" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="215" y="348"><?php echo esc_html( $c1_depts[1] ); ?></text>
<rect rx="4" x="290" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="345" y="348"><?php echo esc_html( $c1_depts[2] ); ?></text>
<rect rx="4" x="420" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="475" y="348"><?php echo esc_html( $c1_depts[3] ); ?></text>
<rect rx="4" x="550" y="320" width="110" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="605" y="348"><?php echo esc_html( $c1_depts[4] ); ?></text>
<rect rx="4" x="680" y="320" width="100" height="46" fill="#2d2b2b" stroke="#f3f2f2" stroke-width="2"/><text x="730" y="348"><?php echo esc_html( $c1_depts[5] ); ?></text>
</g><g font-weight="800"><rect rx="4" x="30" y="398" width="750" height="72" fill="#2d2b2b" stroke="#4a4747" stroke-width="2"/>
<line x1="217" y1="398" x2="217" y2="470" stroke="#4a4747" stroke-width="2"/><line x1="405" y1="398" x2="405" y2="470" stroke="#4a4747" stroke-width="2"/><line x1="592" y1="398" x2="592" y2="470" stroke="#4a4747" stroke-width="2"/>
<text x="50" y="432" font-size="24" fill="<?php echo esc_attr( ! empty( $c1_stats[0]['red'] ) ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[0]['value'] ); ?></text><text x="50" y="454" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[0]['label'] ); ?></text>
<text x="237" y="432" font-size="24" fill="<?php echo esc_attr( ! empty( $c1_stats[1]['red'] ) ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[1]['value'] ); ?></text><text x="237" y="454" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[1]['label'] ); ?></text>
<text x="425" y="432" font-size="24" fill="<?php echo esc_attr( ! empty( $c1_stats[2]['red'] ) ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[2]['value'] ); ?></text><text x="425" y="454" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[2]['label'] ); ?></text>
<text x="612" y="432" font-size="24" fill="<?php echo esc_attr( ! empty( $c1_stats[3]['red'] ) ? '#ec3013' : '#f3f2f2' ); ?>"><?php echo esc_html( $c1_stats[3]['value'] ); ?></text><text x="612" y="454" font-size="12" fill="#bab6b6" font-weight="600"><?php echo esc_html( $c1_stats[3]['label'] ); ?></text>
</g></svg>
