<?php
/**
 * Dark introduction band used at the top of inner pages, followed by the photo band.
 *
 * @package Cypher_One
 *
 * @var array $args page_id, aria, h1_id.
 */

defined( 'ABSPATH' ) || exit;

$c1_title = c1_f( 'intro_title' );
if ( '' === trim( (string) $c1_title ) ) {
	$c1_title = esc_html( get_the_title() );
}
?>
<section class="band pageintro t-dark" aria-label="<?php echo esc_attr( $args['aria'] ); ?>">
  <div class="wrap">
    <?php if ( c1_f( 'intro_eyebrow' ) ) : ?>
    <p class="eyebrow"><?php c1_e( 'intro_eyebrow' ); ?></p>
    <?php endif; ?>
    <h1 style="margin-top:12px;font-size:clamp(2.2rem,5vw,3.8rem)"<?php echo $args['h1_id'] ? ' id="' . esc_attr( $args['h1_id'] ) . '"' : ''; ?>><?php echo c1_kses( $c1_title ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <?php if ( c1_f( 'intro_lede' ) ) : ?>
    <p class="lede" style="margin-top:16px"><?php c1_e( 'intro_lede' ); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php
if ( in_array( $args['page_id'], array( 'about', 'contact' ), true ) ) {
	get_template_part( 'template-parts/photo', null, array( 'id' => 'photo-' . $args['page_id'] ) );
}
