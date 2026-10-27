<?php
/**
 * Theme setup: supports, menus, translations.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports, menus and load translations.
 */
function c1_setup() {
	load_theme_textdomain( 'cypher-one', C1_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary'      => __( 'Main navigation', 'cypher-one' ),
			'footer_pages' => __( 'Footer: Pages column', 'cypher-one' ),
			'footer_tools' => __( 'Footer: Tools column', 'cypher-one' ),
			'footer_legal' => __( 'Footer: Legal links', 'cypher-one' ),
		)
	);
}
add_action( 'after_setup_theme', 'c1_setup' );

/**
 * Use an em dash between the page name and the site name, as the original build did.
 *
 * @return string
 */
function c1_title_separator() {
	return '—';
}
add_filter( 'document_title_separator', 'c1_title_separator' );

/**
 * Remove emoji scripts (the original site loads no third-party scripts).
 */
function c1_cleanup_head() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'c1_cleanup_head' );

/**
 * Add a few body classes used by the templates.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function c1_body_classes( $classes ) {
	if ( is_page_template( 'page-templates/assessment.php' ) ) {
		$classes[] = 'c1-assessment';
	}
	return $classes;
}
add_filter( 'body_class', 'c1_body_classes' );

/**
 * Keep the old Netlify redirect: /what-we-do → Our Approach.
 */
function c1_legacy_redirects() {
	if ( ! is_404() ) {
		return;
	}
	$path = trim( (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$map  = array(
		'what-we-do'         => 'approach',
		'index.html'         => 'home',
		'why-ai-stalls.html' => 'why',
		'our-approach.html'  => 'approach',
		'about.html'         => 'about',
		'contact.html'       => 'contact',
		'privacy.html'       => 'privacy',
		'assessment.html'    => 'assessment',
		'thanks.html'        => 'thanks',
		'tools-score-an-idea.html'   => 'score',
		'tools-cost-of-waiting.html' => 'cost',
		'readiness-gap.html'         => 'gap',
		'discovery.html'             => 'discovery',
		'how-we-work.html'           => 'howwework',
	);
	$base = basename( $path );
	if ( isset( $map[ $base ] ) ) {
		$url = c1_page_url( $map[ $base ] );
		if ( $url ) {
			wp_safe_redirect( $url, 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'c1_legacy_redirects' );

/**
 * Pages built from fields (home and the designed templates) use the classic edit
 * screen, so their Secure Custom Fields tabs get the full width. The Legal / text
 * template and ordinary pages keep the block editor.
 *
 * @param bool    $use  Whether to use the block editor.
 * @param WP_Post $post Post.
 * @return bool
 */
function c1_block_editor_for_post( $use, $post ) {
	if ( ! $post || 'page' !== $post->post_type ) {
		return $use;
	}
	if ( (int) get_option( 'page_on_front' ) === (int) $post->ID ) {
		return false;
	}
	$template = get_page_template_slug( $post );
	if ( $template && 'page-templates/legal.php' !== $template && 0 === strpos( $template, 'page-templates/' ) ) {
		return false;
	}
	return $use;
}
add_filter( 'use_block_editor_for_post', 'c1_block_editor_for_post', 10, 2 );
