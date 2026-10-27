<?php
/**
 * Per-page search & sharing fields.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

return array(
	'seo' => array(
		'title'      => __( 'Search & sharing', 'cypher-one' ),
		'location'   => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				),
			),
		),
		'position'   => 'side',
		'menu_order' => 99,
		'fields'     => array(
			c1_fld( 'seo_title', 'text', __( 'Browser title', 'cypher-one' ), '', array( 'instructions' => __( 'Optional. Replaces the whole title shown in the browser tab and search results.', 'cypher-one' ) ) ),
			c1_fld( 'seo_description', 'textarea', __( 'Meta description', 'cypher-one' ), '', array( 'instructions' => __( 'Optional. Falls back to the default in Cypher-One settings.', 'cypher-one' ) ) ),
			c1_fld( 'seo_image', 'image', __( 'Sharing image', 'cypher-one' ), '', array( 'instructions' => __( 'Optional. 1200 × 630.', 'cypher-one' ) ) ),
			c1_fld( 'seo_noindex', 'true_false', __( 'Hide from search engines', 'cypher-one' ), false ),
		),
	),
);
