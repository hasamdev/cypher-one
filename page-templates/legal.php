<?php
/**
 * Template Name: Legal / text page
 * Template Post Type: page
 *
 * Intro band and photo from fields; the body comes from the block editor.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'privacy' );
get_header();

while ( have_posts() ) :
	the_post();
	?>
<div class="page is-active" id="page-<?php echo esc_attr( get_post_field( 'post_name' ) ); ?>">
	<?php c1_page_intro( 'privacy', __( 'Page introduction', 'cypher-one' ) ); ?>
<section class="t-light" id="<?php echo esc_attr( get_post_field( 'post_name' ) ); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
  <div class="wrap" style="max-width:860px">
    <div class="stack entry-content">
      <?php the_content(); ?>
      <?php if ( c1_f( 'legal_updated' ) ) : ?>
      <p class="route" style="letter-spacing:0;font-weight:400"><?php c1_e( 'legal_updated' ); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
</div>
	<?php
endwhile;

get_footer();
