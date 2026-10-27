<?php
/**
 * Styles and scripts.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Version string for an asset: file modification time, so edits bust caches.
 *
 * @param string $rel Path relative to the theme.
 * @return string
 */
function c1_asset_ver( $rel ) {
	$file = C1_DIR . '/' . $rel;
	return file_exists( $file ) ? C1_VERSION . '.' . filemtime( $file ) : C1_VERSION;
}

/**
 * Enqueue front-end assets.
 */
function c1_enqueue_assets() {
	if ( is_page_template( 'page-templates/assessment.php' ) ) {
		c1_enqueue_assessment();
		return;
	}

	wp_enqueue_style( 'cypher-one', C1_URI . '/assets/css/main.css', array(), c1_asset_ver( 'assets/css/main.css' ) );

	// Page-specific component styles (kept separate, exactly as in the source build).
	$page_css = '';
	if ( is_front_page() ) {
		$page_css = 'home';
	} elseif ( is_page_template( 'page-templates/why-ai-stalls.php' ) ) {
		$page_css = 'why';
	} elseif ( is_page_template( 'page-templates/our-approach.php' ) ) {
		$page_css = 'approach';
	} elseif ( is_page_template( array( 'page-templates/tools-score-an-idea.php', 'page-templates/tools-cost-of-waiting.php', 'page-templates/readiness-gap.php', 'page-templates/discovery.php', 'page-templates/how-we-work.php' ) ) ) {
		$page_css = 'lean';
	}
	if ( $page_css ) {
		wp_enqueue_style( 'cypher-one-' . $page_css, C1_URI . '/assets/css/pages/' . $page_css . '.css', array( 'cypher-one' ), c1_asset_ver( 'assets/css/pages/' . $page_css . '.css' ) );
	}
	if ( is_rtl() ) {
		wp_enqueue_style( 'cypher-one-rtl', C1_URI . '/assets/css/rtl.css', $page_css ? array( 'cypher-one-' . $page_css ) : array( 'cypher-one' ), c1_asset_ver( 'assets/css/rtl.css' ) );
	}

	wp_enqueue_script( 'cypher-one', C1_URI . '/assets/js/main.js', array(), c1_asset_ver( 'assets/js/main.js' ), true );
	wp_localize_script(
		'cypher-one',
		'C1',
		array(
			'locale' => str_replace( '_', '-', determine_locale() ),
			'i18n'   => array(
				/* translators: %s: score. Keep the % sign. */
				'pct'       => __( '%s%', 'cypher-one' ),
				/* translators: 1: answered questions, 2: total questions. */
				'progress'  => __( '%1$d of %2$d answered.', 'cypher-one' ),
				'noBack'    => __( 'Nothing major from these answers.', 'cypher-one' ),
				'noFor'     => __( 'Nothing yet from these answers.', 'cypher-one' ),
				/* translators: 1: currency code, 2: amount. */
				'money'     => __( '%1$s %2$s', 'cypher-one' ),
				/* translators: 1: amount, 2: currency code. */
				'rateValue' => __( '%1$s %2$s per month', 'cypher-one' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'c1_enqueue_assets' );

/**
 * Assets for the standalone assessment app.
 */
function c1_enqueue_assessment() {
	wp_enqueue_style( 'cypher-one-assessment', C1_URI . '/assets/css/assessment.css', array(), c1_asset_ver( 'assets/css/assessment.css' ) );
	wp_enqueue_script( 'cypher-one-assessment', C1_URI . '/assets/js/assessment.js', array(), c1_asset_ver( 'assets/js/assessment.js' ), true );

	$store = (bool) c1_opt( 'assess_store' );
	wp_localize_script(
		'cypher-one-assessment',
		'C1A',
		array(
			'endpoint' => $store ? untrailingslashit( rest_url( 'cypher-one/v1/assessment' ) ) : '',
			'title'    => c1_f( 'as_title', 'assessment' ),
			'tagline'  => c1_f( 'as_tagline', 'assessment' ),
			'version'  => c1_f( 'as_version', 'assessment' ),
			'aligned'  => c1_f( 'as_aligned', 'assessment' ),
			'email'    => c1_opt( 'contact_email' ),
			'web'      => c1_opt( 'website_label' ),
			'location' => c1_opt( 'contact_location' ),
			'web3formsKey' => (string) c1_opt( 'assess_web3forms_key' ),
		)
	);
}

/**
 * The assessment is a full-screen app: no admin bar, no block-library CSS.
 */
function c1_assessment_cleanup() {
	if ( ! is_page_template( 'page-templates/assessment.php' ) ) {
		return;
	}
	add_filter( 'show_admin_bar', '__return_false' );
	add_action(
		'wp_enqueue_scripts',
		function () {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'classic-theme-styles' );
		},
		100
	);
}
add_action( 'template_redirect', 'c1_assessment_cleanup' );

/**
 * Editor styles: keep the block editor close to the front end.
 */
function c1_editor_assets() {
	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'after_setup_theme', 'c1_editor_assets' );
