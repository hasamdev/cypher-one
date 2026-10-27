<?php
/**
 * Template Name: Our Approach
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'approach' );
get_header();

$c1_steps = array_values( (array) c1_f( 'st_steps' ) );
$c1_icon  = function ( $name ) {
	$svg = c1_svg( 'icon-' . sanitize_key( $name ) );
	return $svg ? $svg : c1_svg( 'icon-search' );
};
$c1_anchor = function ( $row ) {
	return sanitize_title( $row['anchor'] ? $row['anchor'] : $row['name'] );
};
?>
<div class="page is-active" id="page-what">
<section class="band t-dark oa-hero" aria-labelledby="oa-title">
  <div class="wrap">
    <div class="oa-grid">
      <div>
        <p class="eyebrow"><?php c1_e( 'oa_eyebrow' ); ?></p>
        <h1 id="oa-title" class="oa-h"><?php c1_h( 'oa_title' ); ?></h1>
        <p class="lede" style="margin-top:18px"><?php c1_h( 'oa_lede' ); ?></p>
      </div>
      <figure class="oa-fig"><?php get_template_part( 'template-parts/charts/cycle', null, array( 'steps' => $c1_steps ) ); ?></figure>
    </div>
  </div>
</section>
<?php get_template_part( 'template-parts/photo', null, array( 'id' => 'photo-what' ) ); ?>
<section class="t-light" id="foundations" aria-labelledby="fd-title">
  <div class="wrap">
    <div class="ln-head"><p class="eyebrow"><?php c1_e( 'st_eyebrow' ); ?></p><h2 id="fd-title"><?php c1_h( 'st_title' ); ?></h2></div>
    <div class="pl-list">
      <?php foreach ( $c1_steps as $c1_i => $c1_row ) : ?>
        <?php $c1_a = $c1_anchor( $c1_row ); ?>
      <article class="pl" id="<?php echo esc_attr( $c1_a ); ?>">
        <div class="pl-id"><span class="pl-ic"><?php echo $c1_icon( $c1_row['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span class="pl-n"><?php echo esc_html( sprintf( '%02d', $c1_i + 1 ) ); ?></span><span class="pl-name"><?php echo esc_html( $c1_row['name'] ); ?></span></div>
        <div class="pl-main"><h3 id="<?php echo esc_attr( $c1_a ); ?>-title"><?php echo esc_html( $c1_row['title'] ); ?></h3><p><?php echo esc_html( $c1_row['text'] ); ?></p>
        <?php if ( ! empty( $c1_row['bullets'] ) ) : ?><ul class="check-list"><?php foreach ( $c1_row['bullets'] as $c1_b ) : ?><li><?php echo c1_svg( 'icon-check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $c1_b['text'] ); ?></span></li><?php endforeach; ?></ul><?php endif; ?></div>
        <div class="pl-get"><p class="rc-fk"><?php echo esc_html( $c1_row['get_label'] ); ?></p><p class="pl-g"><?php echo esc_html( $c1_row['get'] ); ?></p>
        <?php if ( ! empty( $c1_row['fixes'] ) ) : ?><p class="pl-fx"><?php c1_e( 'st_fixes_label' ); ?><?php foreach ( $c1_row['fixes'] as $c1_fx ) : ?> <a class="fx" href="<?php echo esc_url( c1_url( $c1_fx['link'] ) ); ?>"><?php echo esc_html( $c1_fx['label'] ); ?></a><?php endforeach; ?></p><?php endif; ?>
        <?php if ( $c1_row['more'] ) : ?><a class="ln-more" href="<?php echo esc_url( c1_url( $c1_row['link'] ) ); ?>"><?php echo esc_html( $c1_row['more'] ); ?></a><?php endif; ?></div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php get_template_part( 'template-parts/home/scorecard' ); ?>
<section class="t-light" id="opmodel" aria-labelledby="op-title">
  <div class="wrap">
    <div class="ln-head"><p class="eyebrow"><?php c1_e( 'op_eyebrow' ); ?></p><h2 id="op-title"><?php c1_h( 'op_title' ); ?></h2>
      <?php if ( c1_f( 'op_lede' ) ) : ?><p class="lede"><?php c1_e( 'op_lede' ); ?></p><?php endif; ?></div>
    <div class="stk" role="img" aria-label="<?php echo esc_attr( c1_f( 'op_aria' ) ); ?>">
      <div class="stk-row stk-kinds"><?php foreach ( (array) c1_f( 'op_kinds' ) as $c1_row ) : ?><div><b><?php echo esc_html( $c1_row['title'] ); ?></b><span><?php echo esc_html( $c1_row['text'] ); ?></span></div><?php endforeach; ?></div>
    </div>
  </div>
</section>
<section class="t-light" id="bring" aria-labelledby="bring-title">
  <div class="wrap">
    <div class="ln-head"><p class="eyebrow"><?php c1_e( 'bring_eyebrow' ); ?></p><h2 id="bring-title"><?php c1_h( 'bring_title' ); ?></h2>
      <?php if ( c1_f( 'bring_lede' ) ) : ?><p class="lede"><?php c1_e( 'bring_lede' ); ?></p><?php endif; ?></div>
    <div class="tiers">
      <?php foreach ( (array) c1_f( 'bring_tiers' ) as $c1_row ) : ?>
      <div><p class="rc-fk"><?php echo esc_html( $c1_row['label'] ); ?></p><h3><?php echo esc_html( $c1_row['title'] ); ?></h3><p><?php echo esc_html( $c1_row['text'] ); ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="band t-dark" id="assurance" aria-labelledby="as-title">
  <div class="wrap">
    <div class="ln-head" style="max-width:70ch"><p class="eyebrow"><?php c1_e( 'as_eyebrow' ); ?></p><h2 id="as-title"><?php c1_h( 'as_title' ); ?></h2>
      <?php if ( c1_f( 'as_lede' ) ) : ?><p class="lede"><?php c1_e( 'as_lede' ); ?></p><?php endif; ?></div>
    <div class="as-grid">
      <div class="as-cols">
        <?php foreach ( (array) c1_f( 'as_cols' ) as $c1_row ) : ?>
          <?php $c1_items = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $c1_row['items'] ) ) ); ?>
        <div><span class="pl-ic"><?php echo $c1_icon( $c1_row['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><h3><?php echo esc_html( $c1_row['title'] ); ?></h3><?php if ( $c1_items ) : ?><ul><?php foreach ( $c1_items as $c1_it ) : ?><li><?php echo esc_html( $c1_it ); ?></li><?php endforeach; ?></ul><?php endif; ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<section class="t-light" id="start" aria-labelledby="st-title">
  <div class="wrap st">
    <div><p class="eyebrow"><?php c1_e( 'start_eyebrow' ); ?></p><h2 id="st-title"><?php c1_h( 'start_title' ); ?></h2>
    <?php if ( c1_f( 'start_lede' ) ) : ?><p class="lede"><?php c1_e( 'start_lede' ); ?></p><?php endif; ?></div>
    <?php c1_button( 'start_btn_label', 'start_btn_link' ); ?>
  </div>
</section>
</div>
<?php
get_footer();
