<?php
/**
 * Global settings (Cypher-One → Settings).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_email = 'contact@cypher-one.ai';

return array(
	'options' => array(
		'title'    => __( 'Cypher-One site settings', 'cypher-one' ),
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'c1-settings',
				),
			),
		),
		'fields'   => array(
			c1_tab( __( 'Brand', 'cypher-one' ) ),
			c1_fld( 'logo_word_1', 'text', __( 'Word mark: first word', 'cypher-one' ), 'cypher', array( 'wrapper' => array( 'width' => 33 ), 'instructions' => __( 'Upload an image logo under Appearance → Customize → Site Identity to replace the word mark.', 'cypher-one' ) ) ),
			c1_fld( 'logo_separator', 'text', __( 'Word mark: separator', 'cypher-one' ), '•', array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'logo_word_2', 'text', __( 'Word mark: second word', 'cypher-one' ), 'one', array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'logo_tagline', 'text', __( 'Logo tagline', 'cypher-one' ), __( 'AI Deployment and Assurance', 'cypher-one' ) ),
			c1_fld( 'theme_color', 'text', __( 'Browser theme colour', 'cypher-one' ), '#201e1d' ),

			c1_tab( __( 'Contact details', 'cypher-one' ) ),
			c1_fld( 'contact_email', 'email', __( 'Public email address', 'cypher-one' ), $c1_email ),
			c1_fld( 'contact_response', 'text', __( 'Response time', 'cypher-one' ), __( 'Within one business day', 'cypher-one' ) ),
			c1_fld( 'contact_response_long', 'text', __( 'Response time (footer)', 'cypher-one' ), __( 'Replies within one business day', 'cypher-one' ) ),
			c1_fld( 'contact_location', 'text', __( 'Location', 'cypher-one' ), __( 'Doha, Qatar', 'cypher-one' ) ),
			c1_fld( 'contact_based', 'text', __( 'Where we are based (long)', 'cypher-one' ), __( 'Doha, Qatar · working across the GCC', 'cypher-one' ) ),
			c1_fld( 'website_label', 'text', __( 'Website shown in reports', 'cypher-one' ), 'www.cypher-one.ai' ),

			c1_tab( __( 'Footer', 'cypher-one' ) ),
			c1_fld( 'footer_about', 'textarea', __( 'About text', 'cypher-one' ), __( 'Cypher-One helps leaders in Qatar and the GCC find where AI pays, build the data and governance it depends on, and keep it safe and sovereign after go-live.', 'cypher-one' ) ),
			c1_rep(
				'social',
				__( 'Social links', 'cypher-one' ),
				array(
					c1_fld( 'icon', 'select', __( 'Icon', 'cypher-one' ), 'linkedin', array( 'choices' => array( 'linkedin' => 'LinkedIn', 'email' => __( 'Email', 'cypher-one' ) ), 'wrapper' => array( 'width' => 25 ) ) ),
					c1_fld( 'url', 'text', __( 'URL (or mailto:)', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 40 ) ) ),
					c1_fld( 'label', 'text', __( 'Accessible label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 35 ) ) ),
				),
				array(
					array(
						'icon'  => 'linkedin',
						'url'   => 'https://www.linkedin.com/company/cypher-one',
						'label' => __( 'Cypher-One on LinkedIn', 'cypher-one' ),
					),
					array(
						'icon'  => 'email',
						'url'   => 'mailto:' . $c1_email,
						'label' => __( 'Email Cypher-One', 'cypher-one' ),
					),
				),
				array( 'layout' => 'table' )
			),
			c1_fld( 'footer_pages_heading', 'text', __( 'Column heading: pages', 'cypher-one' ), __( 'Pages', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ), 'instructions' => __( 'The links in each column are managed under Appearance → Menus.', 'cypher-one' ) ) ),
			c1_fld( 'footer_tools_heading', 'text', __( 'Column heading: tools', 'cypher-one' ), __( 'Tools', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'footer_contact_heading', 'text', __( 'Column heading: contact', 'cypher-one' ), __( 'Contact', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'footer_copyright', 'text', __( 'Copyright holder', 'cypher-one' ), 'Cypher-One' ),
			c1_fld( 'footer_rights', 'text', __( 'Rights line', 'cypher-one' ), __( 'All rights reserved.', 'cypher-one' ) ),
			c1_fld( 'footer_note', 'text', __( 'Footer note', 'cypher-one' ), __( 'This site sets no cookies and runs no trackers.', 'cypher-one' ) ),

			c1_tab( __( 'Contact form', 'cypher-one' ) ),
			c1_fld( 'form_recipient', 'email', __( 'Send enquiries to', 'cypher-one' ), $c1_email, array( 'instructions' => __( 'Enquiries are emailed here and also saved under Enquiries in the dashboard.', 'cypher-one' ) ) ),
			c1_fld( 'form_subject', 'text', __( 'Email subject', 'cypher-one' ), __( 'New enquiry from the Cypher-One website', 'cypher-one' ) ),
			c1_fld( 'form_error', 'text', __( 'Error message', 'cypher-one' ), __( 'Please add your name, a valid work email and your sector, then send again.', 'cypher-one' ) ),

			c1_tab( __( 'Assessment', 'cypher-one' ) ),
			c1_fld( 'assess_store', 'true_false', __( 'Receive assessment requests in WordPress', 'cypher-one' ), true, array( 'instructions' => __( 'When on, the “Let’s dive deeper” form at the end of the assessment saves each request, with the visitor’s full results, under Assessments in the dashboard and emails it to the address below. Nothing is sent unless the visitor submits that form.', 'cypher-one' ) ) ),
			c1_fld( 'assess_notify', 'email', __( 'Email assessment requests to', 'cypher-one' ), $c1_email ),
			c1_fld( 'assess_web3forms_key', 'text', __( 'Web3Forms access key (optional)', 'cypher-one' ), '', array( 'instructions' => __( 'Only if you prefer Web3Forms: paste a key here and requests go to Web3Forms instead of WordPress.', 'cypher-one' ) ) ),

			c1_tab( __( 'SEO & sharing', 'cypher-one' ) ),
			c1_fld( 'seo_description', 'textarea', __( 'Default meta description', 'cypher-one' ), __( 'UNDERSTAND · PROTECT · GOVERN · ACCELERATE. Built around people, process and technology for Qatar and the GCC.', 'cypher-one' ), array( 'instructions' => __( 'Skipped automatically when an SEO plugin (Yoast, Rank Math, SEOPress, AIOSEO) is active.', 'cypher-one' ) ) ),
			c1_fld( 'seo_image', 'image', __( 'Default sharing image (1200 × 630)', 'cypher-one' ), 'assets/img/og-image.png' ),
			c1_fld( 'seo_image_alt', 'text', __( 'Sharing image alt text', 'cypher-one' ), __( 'Cypher-One: AI delivers real returns when it is built on the right foundation', 'cypher-one' ) ),
			c1_fld( 'org_alt_name', 'text', __( 'Organisation alternate name (structured data)', 'cypher-one' ), 'cypher•one' ),
			c1_fld( 'org_description', 'textarea', __( 'Organisation description (structured data)', 'cypher-one' ), __( 'AI deployment and assurance for organisations in Qatar and the GCC: finding where AI pays, building the data and governance it depends on, and keeping it safe after go-live.', 'cypher-one' ) ),

			c1_tab( __( '404 page', 'cypher-one' ) ),
			c1_fld( 'notfound_title', 'text', __( 'Heading', 'cypher-one' ), __( 'That page is not here', 'cypher-one' ) ),
			c1_fld( 'notfound_text', 'textarea', __( 'Text', 'cypher-one' ), __( 'The link may be old, or the page may have moved.', 'cypher-one' ) ),
			c1_fld( 'notfound_link', 'text', __( 'Link label', 'cypher-one' ), __( 'Back to the homepage', 'cypher-one' ) ),
		),
	),
);
