<?php
/**
 * Default page / post template: intro band + block editor content.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
<div class="page is-active" id="page-<?php echo esc_attr( get_post_field( 'post_name' ) ); ?>">
<section class="band pageintro t-dark" aria-labelledby="entry-title">
  <div class="wrap">
    <?php if ( is_singular( 'post' ) ) : ?>
    <p class="eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
    <?php endif; ?>
    <h1 id="entry-title" style="margin-top:12px;font-size:clamp(2.2rem,5vw,3.8rem)"><?php the_title(); ?></h1>
    <?php if ( has_excerpt() ) : ?>
    <p class="lede" style="margin-top:16px"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
  </div>
</section>
	<?php if ( has_post_thumbnail() ) : ?>
<figure class="photo"><?php the_post_thumbnail( 'full', array( 'loading' => 'lazy' ) ); ?></figure>
	<?php endif; ?>
<section class="t-light">
  <div class="wrap" style="max-width:860px">
    <div class="stack entry-content">
      <?php
		the_content();
		wp_link_pages();
		?>
    </div>
  </div>
</section>
</div>
	<?php
endwhile;

get_footer();
