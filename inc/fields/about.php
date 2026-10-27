<?php
/**
 * About page fields.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

return array(
	'about' => array(
		'title'          => __( 'About page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/about.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge(
			c1_intro_fields(
				array(
					'eyebrow' => __( 'Page 4 of 5', 'cypher-one' ),
					'title'   => __( 'The people who will do the work', 'cypher-one' ),
					'lede'    => __( 'Who we are, and how to start a conversation. We measure our work by what your organisation can do on its own once we have left.', 'cypher-one' ),
					'photo'   => c1_unsplash( 'photo-1692477729539-881615b4109d' ),
					'alt'     => __( 'Smooth black and red layered curves', 'cypher-one' ),
					'caption' => __( 'Abstract · <a href="https://unsplash.com/" rel="noopener">Philip Oroni on Unsplash</a>', 'cypher-one' ),
				)
			),
			array(
				c1_tab( __( 'Team', 'cypher-one' ) ),
				c1_fld( 'team_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'The team', 'cypher-one' ) ),
				c1_fld( 'team_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Who we are', 'cypher-one' ) ),
				c1_fld( 'team_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Three practitioners who have built, run and governed technology inside large organisations, not just advised on it. The people on this page are the people who do the work.', 'cypher-one' ) ),
				c1_rep(
					'team_members',
					__( 'Team members', 'cypher-one' ),
					array(
						c1_fld( 'photo', 'image', __( 'Photo (4:5 portrait)', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 30 ) ) ),
						c1_fld( 'name', 'text', __( 'Name', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 35 ) ) ),
						c1_fld( 'role', 'text', __( 'Role', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 35 ) ) ),
						c1_fld( 'bio', 'textarea', __( 'Biography', 'cypher-one' ), '', array( 'rows' => 5 ) ),
					),
					array(
						array(
							'photo' => 'assets/img/team/satnam-matharu.jpg',
							'name'  => 'Satnam Matharu',
							'role'  => __( 'CEO', 'cypher-one' ),
							'bio'   => __( 'Served as Director of Global Brand at Al Jazeera Media Network for nearly twenty years, contributing to the launch and development of its international channels and platforms. Earlier worked on innovation and interactive strategy at Apple and digital projects at KPMG. Also taught at the University of Toronto. Based in Doha.', 'cypher-one' ),
						),
						array(
							'photo' => 'assets/img/team/abid-mustafa.jpg',
							'name'  => 'Abid Mustafa',
							'role'  => __( 'Lead, AI Systems Strategy', 'cypher-one' ),
							'bio'   => __( 'Board-level AI strategist with thirty years in technology and telecoms, including eight years as Director of B2B Digital Transformation at Etisalat. Has written AI-first operating models for telecoms companies, cut operating costs by over 30% through process redesign, and advises on AI sovereignty. Based in Saudi Arabia.', 'cypher-one' ),
						),
						array(
							'photo' => 'assets/img/team/mohammed-hussein.jpg',
							'name'  => 'Mohammed Hussein',
							'role'  => __( 'Lead, AI Solutions Architect', 'cypher-one' ),
							'bio'   => __( "Spent more than thirty years building ERP, CRM and tailored business systems for organisations in the UK and the Gulf, including six years running HansaWorld's Middle East operation. Now architects AI platforms, including a bilingual Arabic and English knowledge system for government. Fluent in Arabic and English. Based in London.", 'cypher-one' ),
						),
					),
					array( 'button_label' => __( 'Add team member', 'cypher-one' ) )
				),

				c1_tab( __( 'Talk to us', 'cypher-one' ) ),
				c1_fld( 'close_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Talk to us', 'cypher-one' ) ),
				c1_fld( 'close_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Thirty minutes with the people on this page', 'cypher-one' ) ),
				c1_fld( 'close_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Tell us what you want AI to achieve. We will tell you plainly where we think the value is, what it would take to get there, and whether we are the right people to help.', 'cypher-one' ) ),
				c1_fld( 'close_btn1_label', 'text', __( 'Primary button label', 'cypher-one' ), __( 'Tell us what you need', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'close_btn1_link', 'link', __( 'Primary button link', 'cypher-one' ), '{contact}#contact', array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'close_btn2_label', 'text', __( 'Secondary button label', 'cypher-one' ), __( 'Or take the assessment first', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'close_btn2_link', 'link', __( 'Secondary button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'close_show_meta', 'true_false', __( 'Show contact details (from Cypher-One settings)', 'cypher-one' ), true ),
				c1_fld( 'close_meta_email', 'text', __( 'Label: email', 'cypher-one' ), __( 'Email', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
				c1_fld( 'close_meta_response', 'text', __( 'Label: response', 'cypher-one' ), __( 'Response', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
				c1_fld( 'close_meta_based', 'text', __( 'Label: based', 'cypher-one' ), __( 'Based', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			)
		),
	),
);
