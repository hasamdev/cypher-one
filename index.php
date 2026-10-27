<?php
/**
 * Fallback template (blog index, archives, search).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="page is-active" id="page-archive">
<section class="band pageintro t-dark" aria-labelledby="archive-title">
  <div class="wrap">
    <h1 id="archive-title" style="font-size:clamp(2.2rem,5vw,3.8rem)">
    <?php
	if ( is_search() ) {
		/* translators: %s: search query. */
		printf( esc_html__( 'Search results for “%s”', 'cypher-one' ), esc_html( get_search_query() ) );
	} elseif ( is_archive() ) {
		echo wp_kses_post( get_the_archive_title() );
	} else {
		echo esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) ? get_the_title( (int) get_option( 'page_for_posts' ) ) : __( 'Latest updates', 'cypher-one' ) );
	}
	?>
    </h1>
  </div>
</section>
<section class="t-light">
  <div class="wrap" style="max-width:860px">
    <div class="stack">
    <?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
      <article <?php post_class( 'c1-entry' ); ?>>
        <h2 style="font-size:1.6rem"><a href="<?php the_permalink(); ?>" style="text-decoration:none"><?php the_title(); ?></a></h2>
        <p class="route" style="margin-top:6px"><?php echo esc_html( get_the_date() ); ?></p>
        <div style="margin-top:10px"><?php the_excerpt(); ?></div>
      </article>
		<?php endwhile; ?>
		<?php
		the_posts_pagination(
			array(
				'prev_text' => __( 'Previous', 'cypher-one' ),
				'next_text' => __( 'Next', 'cypher-one' ),
			)
		);
		?>
    <?php else : ?>
      <p><?php esc_html_e( 'Nothing has been published here yet.', 'cypher-one' ); ?></p>
    <?php endif; ?>
    </div>
  </div>
</section>
</div>
<?php
get_footer();
