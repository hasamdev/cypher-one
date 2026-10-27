<?php
/**
 * Thank-you page and privacy page fields.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

return array(
	'thanks'  => array(
		'title'          => __( 'Thank-you page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/thanks.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array(
			c1_fld( 'th_title', 'text', __( 'Heading', 'cypher-one' ), __( 'Thank you. We have it.', 'cypher-one' ) ),
			c1_fld( 'th_text', 'html', __( 'Text', 'cypher-one' ), __( 'Someone from Cypher-One will reply within one business day. If it is urgent, email {email}.', 'cypher-one' ), array( 'instructions' => __( '{email} is replaced by the public email address.', 'cypher-one' ) ) ),
			c1_fld( 'th_link', 'text', __( 'Link label', 'cypher-one' ), __( 'Back to the homepage', 'cypher-one' ) ),
		),
	),
	'privacy' => array(
		'title'    => __( 'Page intro', 'cypher-one' ),
		'location' => c1_loc_template( 'page-templates/legal.php' ),
		'fields'   => array_merge(
			c1_intro_fields(
				array(
					'eyebrow' => __( 'Privacy', 'cypher-one' ),
					'title'   => __( 'How this site treats your information', 'cypher-one' ),
					'lede'    => __( 'Short, because there is not much to say. This site collects as little as possible.', 'cypher-one' ),
					'photo'   => c1_unsplash( 'photo-1750315080835-6f8640a00a12' ),
					'alt'     => __( 'Abstract glowing orange light wave on black', 'cypher-one' ),
					'caption' => __( 'Abstract · <a href="https://unsplash.com/" rel="noopener">Unsplash</a>', 'cypher-one' ),
				)
			),
			array(
				c1_tab( __( 'Small print', 'cypher-one' ) ),
				c1_fld( 'legal_updated', 'text', __( 'Closing note', 'cypher-one' ), __( 'Last updated 16 October 2026. Legal entity, registered address and a named data contact to be added before launch.', 'cypher-one' ), array( 'instructions' => __( 'The page body itself is edited in the main editor.', 'cypher-one' ) ) ),
			)
		),
	),
);
