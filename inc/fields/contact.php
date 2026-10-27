<?php
/**
 * Contact page fields.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_sectors = array(
	__( 'Healthcare & Medical', 'cypher-one' ),
	__( 'Financial Services', 'cypher-one' ),
	__( 'Government & Public Sector', 'cypher-one' ),
	__( 'HR & Recruitment', 'cypher-one' ),
	__( 'Legal Services', 'cypher-one' ),
	__( 'Education', 'cypher-one' ),
	__( 'Security & Law Enforcement', 'cypher-one' ),
	__( 'Transportation & Logistics', 'cypher-one' ),
	__( 'Energy & Utilities', 'cypher-one' ),
	__( 'Manufacturing & Industrial', 'cypher-one' ),
	__( 'Real Estate & Construction', 'cypher-one' ),
	__( 'Hospitality & Tourism', 'cypher-one' ),
	__( 'Telecommunications', 'cypher-one' ),
	__( 'Media / Technology', 'cypher-one' ),
	__( 'Retail & E-commerce', 'cypher-one' ),
	__( 'Other', 'cypher-one' ),
);

$c1_want = function ( $value, $label, $other = false ) {
	return array(
		'value' => $value,
		'label' => $label,
		'other' => $other,
	);
};

return array(
	'contact' => array(
		'title'          => __( 'Contact page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/contact.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge(
			c1_intro_fields(
				array(
					'eyebrow' => __( 'Page 5 of 5', 'cypher-one' ),
					'title'   => __( 'Tell us where we can help you', 'cypher-one' ),
					'lede'    => __( 'Pick the closest option, add a line or two in your own words, and we will reply within one business day with a plain view of whether and how we can help.', 'cypher-one' ),
					'photo'   => c1_unsplash( 'photo-1760978631985-590e3b5f4057' ),
					'alt'     => __( 'Golden particle wave on black', 'cypher-one' ),
					'caption' => __( 'Abstract · <a href="https://unsplash.com/" rel="noopener">BoliviaInteligente on Unsplash</a>', 'cypher-one' ),
				)
			),
			array(
				c1_tab( __( 'Form', 'cypher-one' ) ),
				c1_fld( 'cf_legend', 'text', __( 'Options heading', 'cypher-one' ), __( 'What would you like from us?', 'cypher-one' ) ),
				c1_rep(
					'cf_wants',
					__( 'Options', 'cypher-one' ),
					array(
						c1_fld( 'label', 'text', __( 'Label shown', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
						c1_fld( 'value', 'text', __( 'Short name in the email', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 35 ) ) ),
						c1_fld( 'other', 'true_false', __( 'Ask for details', 'cypher-one' ), false, array( 'wrapper' => array( 'width' => 15 ) ) ),
					),
					array(
						$c1_want( __( 'A 30-minute conversation', 'cypher-one' ), __( 'A 30-minute conversation about where AI could advance my organisation', 'cypher-one' ) ),
						$c1_want( __( 'An in-depth readiness review', 'cypher-one' ), __( 'An in-depth readiness review across strategy, data, governance, process and people', 'cypher-one' ) ),
						$c1_want( __( 'AI Adoption Review on one process', 'cypher-one' ), __( 'An AI Adoption Review of one priority process', 'cypher-one' ) ),
						$c1_want( __( 'Manage risk and bring existing AI under control', 'cypher-one' ), __( 'Manage risk and bring the AI we already use under control', 'cypher-one' ) ),
						$c1_want( __( 'Capability building for our people', 'cypher-one' ), __( 'Capability building for our leaders and teams', 'cypher-one' ) ),
						$c1_want( __( 'Something else', 'cypher-one' ), __( 'Something else', 'cypher-one' ), true ),
					),
					array( 'layout' => 'table' )
				),
				c1_fld( 'cf_other_placeholder', 'text', __( '“Something else” placeholder', 'cypher-one' ), __( 'Tell us what, in a few words', 'cypher-one' ) ),
				c1_fld( 'cf_name', 'text', __( 'Label: name', 'cypher-one' ), __( 'Your name', 'cypher-one' ), array( 'wrapper' => array( 'width' => 25 ) ) ),
				c1_fld( 'cf_org', 'text', __( 'Label: organisation', 'cypher-one' ), __( 'Organisation', 'cypher-one' ), array( 'wrapper' => array( 'width' => 25 ) ) ),
				c1_fld( 'cf_email', 'text', __( 'Label: email', 'cypher-one' ), __( 'Work email', 'cypher-one' ), array( 'wrapper' => array( 'width' => 25 ) ) ),
				c1_fld( 'cf_role', 'text', __( 'Label: role', 'cypher-one' ), __( 'Role', 'cypher-one' ), array( 'wrapper' => array( 'width' => 25 ) ) ),
				c1_fld( 'cf_sector', 'text', __( 'Label: sector', 'cypher-one' ), __( 'Sector', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'cf_sector_placeholder', 'text', __( 'Sector placeholder', 'cypher-one' ), __( 'Select the sector you operate in', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'cf_sectors', 'textarea', __( 'Sectors (one per line)', 'cypher-one' ), implode( "\n", $c1_sectors ), array( 'rows' => 8 ) ),
				c1_fld( 'cf_message', 'text', __( 'Label: message', 'cypher-one' ), __( 'In your own words', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'cf_message_placeholder', 'text', __( 'Message placeholder', 'cypher-one' ), __( 'What is the problem, the idea, or the question you want answered?', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'cf_submit', 'text', __( 'Button label', 'cypher-one' ), __( 'Send', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'cf_alt', 'text', __( 'Email alternative text', 'cypher-one' ), __( 'Prefer email?', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			)
		),
	),
);
