<?php
/**
 * Photo band under a page intro.
 *
 * @package Cypher_One
 *
 * @var array $args { @type string $id figure id. }
 */

defined( 'ABSPATH' ) || exit;

if ( ! empty( $args['id'] ) && ! in_array( $args['id'], array( 'photo-about', 'photo-contact' ), true ) ) {
	return;
}

if ( ! c1_f( 'photo_show' ) ) {
	return;
}
$c1_src = c1_img_url( c1_f( 'photo_image' ), 'full' );
if ( ! $c1_src ) {
	return;
}
$c1_caption = c1_f( 'photo_caption' );
?>
<figure class="photo" id="<?php echo esc_attr( $args['id'] ); ?>"><img src="<?php echo esc_url( $c1_src ); ?>" alt="<?php echo esc_attr( c1_f( 'photo_alt' ) ); ?>" loading="lazy"><?php if ( $c1_caption ) : ?><figcaption><?php echo c1_kses( $c1_caption ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figcaption><?php endif; ?></figure>
