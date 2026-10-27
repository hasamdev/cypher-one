<?php
/**
 * "Six steps around ongoing assurance" cycle diagram for Our Approach.
 * Built from the steps repeater, so renaming or adding steps updates it.
 *
 * @package Cypher_One
 *
 * @var array $args { @type array $steps Step rows. }
 */

defined( 'ABSPATH' ) || exit;

$c1_steps = array_values( isset( $args['steps'] ) ? (array) $args['steps'] : array() );
$c1_n     = count( $c1_steps );
if ( ! $c1_n ) {
	return;
}
$c1_names = wp_list_pluck( $c1_steps, 'name' );
/* translators: %s: comma-separated list of step names. */
$c1_aria = sprintf( __( 'Steps in a cycle, %s, around an ongoing assurance service', 'cypher-one' ), implode( ', ', $c1_names ) );
$c1_pos  = function ( $deg, $r = 162 ) {
	$rad = deg2rad( $deg );
	return array( 210 + $r * cos( $rad ), 210 + $r * sin( $rad ) );
};
$c1_step = 360 / $c1_n;
?>
<svg viewBox="0 0 420 420" role="img" aria-label="<?php echo esc_attr( $c1_aria ); ?>"><circle cx="210" cy="210" r="162" fill="none" style="stroke:#4a4747" stroke-width="2"/>
<?php
for ( $c1_i = 0; $c1_i < $c1_n; $c1_i++ ) {
	$c1_phi = -90 + $c1_step * $c1_i + $c1_step / 2;
	list( $c1_x, $c1_y ) = $c1_pos( $c1_phi );
	printf( '<path d="M0 -7 L12 0 L0 7z" style="fill:#ec3013" transform="translate(%1$s %2$s) rotate(%3$s)"/>', esc_attr( number_format( $c1_x, 1, '.', '' ) ), esc_attr( number_format( $c1_y, 1, '.', '' ) ), esc_attr( round( $c1_phi + 90 ) ) );
}
for ( $c1_i = 0; $c1_i < $c1_n; $c1_i++ ) {
	list( $c1_x, $c1_y ) = $c1_pos( -90 + $c1_step * $c1_i );
	printf( '<line x1="210" y1="210" x2="%1$d" y2="%2$d" style="stroke:#ec3013" stroke-width="1.5" stroke-dasharray="4 5"/>', (int) round( $c1_x ), (int) round( $c1_y ) );
}
?>
<circle cx="210" cy="210" r="80" style="fill:#2d2b2b;stroke:#ec3013" stroke-width="3"/><circle cx="210" cy="210" r="94" fill="none" style="stroke:#ec3013" stroke-width="1" stroke-dasharray="2 6"/><text x="210" y="196" text-anchor="middle" font-size="12" font-weight="800" letter-spacing="2" style="fill:#ff9783"><?php c1_e( 'oa_fig_top' ); ?></text><text x="210" y="220" text-anchor="middle" font-size="19" font-weight="800" style="fill:#fff"><?php c1_e( 'oa_fig_mid' ); ?></text><text x="210" y="242" text-anchor="middle" font-size="13" style="fill:#c9c4c2"><?php c1_e( 'oa_fig_bottom' ); ?></text>
<?php
foreach ( $c1_steps as $c1_i => $c1_row ) {
	list( $c1_x, $c1_y ) = $c1_pos( -90 + $c1_step * $c1_i );
	$c1_x   = (int) round( $c1_x );
	$c1_y   = (int) round( $c1_y );
	$c1_a   = sanitize_title( $c1_row['anchor'] ? $c1_row['anchor'] : $c1_row['name'] );
	printf(
		'<a href="#%1$s-title"><rect x="%2$d" y="%3$d" width="124" height="58" style="fill:#201e1d;stroke:#4a4747" stroke-width="2"/><text x="%4$d" y="%5$d" text-anchor="middle" font-size="11" font-weight="800" letter-spacing="2" style="fill:#ff9783">%6$s</text><text x="%4$d" y="%7$d" text-anchor="middle" font-size="17" font-weight="800" style="fill:#fff">%8$s</text></a>',
		esc_attr( $c1_a ),
		$c1_x - 62,
		$c1_y - 29,
		$c1_x,
		$c1_y - 6,
		esc_html( sprintf( '%02d', $c1_i + 1 ) ),
		$c1_y + 16,
		esc_html( $c1_row['name'] )
	);
}
?>
</svg>
