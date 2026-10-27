<?php
/**
 * Head metadata: description, Open Graph, icons, structured data.
 * Skipped when a dedicated SEO plugin is active.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether an SEO plugin handles metadata.
 *
 * @return bool
 */
function c1_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' ) || class_exists( 'The_SEO_Framework\Load' );
}

/**
 * Value of a per-page SEO field (empty when not set).
 *
 * @param string $name Field name.
 * @return mixed
 */
function c1_seo_field( $name ) {
	if ( ! is_singular() ) {
		return '';
	}
	return c1_f( $name, 'seo', get_queried_object_id() );
}

/**
 * Custom browser title per page.
 *
 * @param string $title Title.
 * @return string
 */
function c1_document_title( $title ) {
	if ( c1_seo_plugin_active() ) {
		return $title;
	}
	$custom = c1_seo_field( 'seo_title' );
	return $custom ? $custom : $title;
}
add_filter( 'pre_get_document_title', 'c1_document_title' );

/**
 * Print meta tags and icons.
 */
function c1_head_meta() {
	$theme_color = c1_opt( 'theme_color' );
	if ( $theme_color ) {
		printf( "<meta name=\"theme-color\" content=\"%s\">\n", esc_attr( $theme_color ) );
	}

	if ( ! has_site_icon() ) {
		printf( "<link rel=\"icon\" href=\"%s\" type=\"image/svg+xml\">\n", esc_url( C1_URI . '/assets/img/favicon.svg' ) );
		printf( "<link rel=\"icon\" href=\"%s\" sizes=\"32x32\" type=\"image/png\">\n", esc_url( C1_URI . '/assets/img/favicon-32.png' ) );
		printf( "<link rel=\"apple-touch-icon\" href=\"%s\">\n", esc_url( C1_URI . '/assets/img/apple-touch-icon.png' ) );
	}

	if ( c1_seo_plugin_active() ) {
		return;
	}

	$desc = c1_seo_field( 'seo_description' );
	if ( ! $desc && is_page_template( 'page-templates/assessment.php' ) ) {
		$desc = __( 'Cypher-One AI Readiness Assessment — find out how ready your organisation is to adopt AI, across strategy, leadership, people, data, technology, process, value and trust. Your AI readiness snapshot in about ten minutes.', 'cypher-one' );
	}
	if ( ! $desc ) {
		$desc = c1_opt( 'seo_description' );
	}
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );
	if ( is_front_page() ) {
		$url = home_url( '/' );
	}

	$img_value = c1_seo_field( 'seo_image' );
	if ( ! $img_value && is_singular() && has_post_thumbnail() ) {
		$img_value = get_post_thumbnail_id();
	}
	$img = $img_value ? c1_img_url( $img_value, 'full' ) : c1_img_url( c1_opt( 'seo_image' ), 'full' );

	$noindex = c1_seo_field( 'seo_noindex' ) || is_page_template( 'page-templates/thanks.php' );

	echo "\n<!-- Cypher-One theme metadata -->\n";
	if ( $desc ) {
		printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	}
	if ( $noindex ) {
		echo "<meta name=\"robots\" content=\"noindex\">\n";
	}
	if ( is_singular() || is_front_page() ) {
		printf( "<link rel=\"canonical\" href=\"%s\">\n", esc_url( $url ) );
	}
	printf( "<meta property=\"og:type\" content=\"%s\">\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	}
	printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
	printf( "<meta property=\"og:locale\" content=\"%s\">\n", esc_attr( get_locale() ) );
	if ( $img ) {
		printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $img ) );
		if ( ! is_numeric( $img_value ) ) {
			echo "<meta property=\"og:image:width\" content=\"1200\">\n<meta property=\"og:image:height\" content=\"630\">\n";
		}
		printf( "<meta property=\"og:image:alt\" content=\"%s\">\n", esc_attr( c1_opt( 'seo_image_alt' ) ) );
		printf( "<meta name=\"twitter:image\" content=\"%s\">\n", esc_url( $img ) );
	}
	echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
	printf( "<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( "<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr( $desc ) );
	}

	if ( is_front_page() ) {
		$home  = home_url( '/' );
		$graph = array(
			'@context' => 'https://schema.org',
			'@graph'   => array(
				array(
					'@type'         => 'Organization',
					'@id'           => $home . '#org',
					'name'          => get_bloginfo( 'name' ),
					'alternateName' => c1_opt( 'org_alt_name' ),
					'url'           => $home,
					'email'         => c1_opt( 'contact_email' ),
					'description'   => c1_opt( 'org_description' ),
					'logo'          => C1_URI . '/assets/img/icon-512.png',
				),
				array(
					'@type'     => 'WebSite',
					'@id'       => $home . '#website',
					'url'       => $home,
					'name'      => get_bloginfo( 'name' ),
					'inLanguage' => get_bloginfo( 'language' ),
					'publisher' => array( '@id' => $home . '#org' ),
				),
				array(
					'@type'    => 'WebPage',
					'url'      => $home,
					'name'     => $title,
					'isPartOf' => array( '@id' => $home . '#website' ),
					'about'    => array( 'AI governance', 'AI risk', 'Agentic AI', 'AI transformation' ),
				),
			),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	}
}
add_action( 'wp_head', 'c1_head_meta', 2 );

/**
 * WordPress prints its own canonical link; ours already covers singular pages.
 */
function c1_maybe_remove_core_canonical() {
	if ( ! c1_seo_plugin_active() ) {
		remove_action( 'wp_head', 'rel_canonical' );
	}
}
add_action( 'wp', 'c1_maybe_remove_core_canonical' );
