<?php
/**
 * Home page fields (website-new layout).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_lbl = function ( $label ) {
	return array( 'label' => $label );
};

return array(
	'home' => array(
		'title'          => __( 'Home page content', 'cypher-one' ),
		'location'       => array(
			array(
				array(
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => 'front_page',
				),
			),
		),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge(
			array(
				/* ------------------------------------------------------------ Hero */
				c1_tab( __( 'Hero', 'cypher-one' ) ),
				c1_fld( 'hero_pill', 'text', __( 'Location pill', 'cypher-one' ), __( 'Qatar · GCC · Global', 'cypher-one' ) ),
				c1_fld( 'hero_title', 'html', __( 'Heading', 'cypher-one' ), __( '“Everyone says we need AI. <span>Nobody can tell us where it will pay.”</span>', 'cypher-one' ), array( 'instructions' => __( 'Wrap the second part in <span>…</span> to show it in red.', 'cypher-one' ) ) ),
				c1_rep(
					'hero_thoughts',
					__( 'Quotes from leadership teams', 'cypher-one' ),
					array( c1_fld( 'text', 'text', __( 'Quote', 'cypher-one' ) ) ),
					array(
						array( 'text' => __( '“We’ve run pilots. None of them made it into the business.”', 'cypher-one' ) ),
						array( 'text' => __( '“Our staff use ChatGPT every day. I don’t know what data they’re putting into it.”', 'cypher-one' ) ),
						array( 'text' => __( '“The board wants an AI strategy. Every vendor says their tool is the answer.”', 'cypher-one' ) ),
					),
					array( 'layout' => 'table' )
				),
				c1_fld( 'hero_thoughts_label', 'text', __( 'Quotes: accessible label', 'cypher-one' ), __( 'What we hear from leadership teams', 'cypher-one' ) ),
				c1_fld( 'hero_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Take the AI readiness assessment', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'hero_btn_link', 'link', __( 'Button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'hero_show_wire', 'true_false', __( 'Show the animated wire background', 'cypher-one' ), true ),

				c1_tab( __( 'Hero illustration', 'cypher-one' ) ),
				c1_fld( 'hero_fig_caption', 'text', __( 'Caption', 'cypher-one' ), __( 'Lots of AI. Little of it checked.', 'cypher-one' ) ),
				c1_fld( 'hero_fig_aria', 'text', __( 'Description for screen readers', 'cypher-one' ), __( 'Illustration: AI tools across departments, most of which never pass checks for return, risk, workflow fit or strategy', 'cypher-one' ) ),
				c1_rep(
					'hero_fig_checks',
					__( 'Checks (top row, 4)', 'cypher-one' ),
					array( c1_fld( 'label', 'text', __( 'Label', 'cypher-one' ) ) ),
					array_map( $c1_lbl, array( __( 'Meets ROI', 'cypher-one' ), __( 'Risk assessed', 'cypher-one' ), __( 'Fits the workflow', 'cypher-one' ), __( 'Aligned to strategy', 'cypher-one' ) ) ),
					array(
						'layout' => 'table',
						'min'    => 4,
						'max'    => 4,
					)
				),
				c1_rep(
					'hero_fig_depts',
					__( 'Departments (bottom row, 6)', 'cypher-one' ),
					array( c1_fld( 'label', 'text', __( 'Label', 'cypher-one' ) ) ),
					array_map( $c1_lbl, array( __( 'Finance', 'cypher-one' ), __( 'HR', 'cypher-one' ), __( 'Sales', 'cypher-one' ), __( 'Operations', 'cypher-one' ), __( 'Legal', 'cypher-one' ), __( 'Marketing', 'cypher-one' ) ) ),
					array(
						'layout' => 'table',
						'min'    => 6,
						'max'    => 6,
					)
				),
				c1_rep(
					'hero_fig_stats',
					__( 'Figures (4)', 'cypher-one' ),
					array(
						c1_fld( 'value', 'text', __( 'Figure', 'cypher-one' ) ),
						c1_fld( 'label', 'text', __( 'Label', 'cypher-one' ) ),
						c1_fld( 'red', 'true_false', __( 'Red', 'cypher-one' ), false ),
					),
					array(
						array( 'value' => '80', 'label' => __( 'AI tools in use', 'cypher-one' ), 'red' => false ),
						array( 'value' => '35', 'label' => __( 'approved', 'cypher-one' ), 'red' => false ),
						array( 'value' => '20', 'label' => __( 'risk assessed', 'cypher-one' ), 'red' => true ),
						array( 'value' => '?', 'label' => __( 'return on AI spend', 'cypher-one' ), 'red' => true ),
					),
					array(
						'layout' => 'table',
						'min'    => 4,
						'max'    => 4,
					)
				),

				c1_tab( __( 'Photo band', 'cypher-one' ) ),
				c1_fld( 'photo_show', 'true_false', __( 'Show the photo band', 'cypher-one' ), true ),
				c1_fld( 'photo_image', 'image', __( 'Photo', 'cypher-one' ), c1_unsplash( 'photo-1708457753320-02e52a276a80' ) ),
				c1_fld( 'photo_alt', 'text', __( 'Alternative text', 'cypher-one' ), __( 'Abstract folded red curves on black', 'cypher-one' ) ),
				c1_fld( 'photo_caption', 'html', __( 'Caption / credit', 'cypher-one' ), __( 'Abstract · <a href="https://unsplash.com/" rel="noopener">Pawel Czerwinski on Unsplash</a>', 'cypher-one' ) ),
			),
			/* ---------------------------------------------------------------- Calculator */
			c1_sec_calc(
				array(
					'calc_lede'        => __( 'Fewer leaders put a number on the risk of not moving. Move the sliders to see yours.', 'cypher-one' ),
					'calc_team_value'  => 10,
					'calc_hours_value' => 10,
					'calc_rate_value'  => 20000,
					'calc_summary_2'   => __( 'The real question is which of that work is safe to hand to AI and where a person has to stay in the loop. That is what an AI Adoption Review answers.', 'cypher-one' ),
					'calc_btn_label'   => __( 'Take the AI readiness assessment', 'cypher-one' ),
					'calc_btn_link'    => '{assessment}',
					'calc_ask'         => '',
				)
			),
			array(
				/* ------------------------------------------------------------ Readiness gap (short) */
				c1_tab( __( 'Readiness gap', 'cypher-one' ) ),
				c1_fld( 'gap_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'The readiness gap', 'cypher-one' ) ),
				c1_fld( 'gap_title', 'html', __( 'Heading', 'cypher-one' ), __( 'AI is moving faster than most organisations are ready for.', 'cypher-one' ) ),
				c1_fld( 'gap_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'The space between what AI can do and what you are ready for is where value is lost and risk grows.', 'cypher-one' ) ),
				c1_fld( 'gap_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Where are you on the curve?', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'gap_btn_link', 'link', __( 'Button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'gap_more_label', 'text', __( '“Read more” label', 'cypher-one' ), __( 'Read more', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'gap_more_link', 'link', __( '“Read more” link', 'cypher-one' ), '{gap}', array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'gap_caption', 'text', __( 'Chart caption', 'cypher-one' ), __( 'A conceptual picture of the pattern we see in client organisations.', 'cypher-one' ) ),

				/* ------------------------------------------------------------ You're not alone */
				c1_tab( __( 'You’re not alone', 'cypher-one' ) ),
				c1_fld( 'alone_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'You’re not alone', 'cypher-one' ) ),
				c1_fld( 'alone_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Most organisations are in the same place. You don’t have to fix it alone.', 'cypher-one' ) ),
				c1_fld( 'alone_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Our founders are consulting on and implementing AI solutions for large enterprises across the GCC today. We fix it in six steps:', 'cypher-one' ) ),
				c1_rep(
					'alone_steps',
					__( 'Steps', 'cypher-one' ),
					array(
						c1_fld( 'title', 'text', __( 'Step', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 25 ) ) ),
						c1_fld( 'text', 'text', __( 'Text', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 45 ) ) ),
						c1_fld( 'link', 'link', __( 'Link', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 30 ) ) ),
					),
					array(
						array( 'title' => __( 'Analyse', 'cypher-one' ), 'text' => __( 'Know where AI will pay, and whether you are ready.', 'cypher-one' ), 'link' => '{approach}#analyse-title' ),
						array( 'title' => __( 'Educate', 'cypher-one' ), 'text' => __( 'Tailored training, so your people use AI well.', 'cypher-one' ), 'link' => '{approach}#educate-title' ),
						array( 'title' => __( 'Prioritise', 'cypher-one' ), 'text' => __( 'Agree which ideas go first, with a plan and owners.', 'cypher-one' ), 'link' => '{approach}#prioritise-title' ),
						array( 'title' => __( 'Build', 'cypher-one' ), 'text' => __( 'Secure, sovereign solutions that fit how people work.', 'cypher-one' ), 'link' => '{approach}#build-title' ),
						array( 'title' => __( 'Govern', 'cypher-one' ), 'text' => __( 'Clear owners, limits and compliance built into the systems.', 'cypher-one' ), 'link' => '{approach}#govern-title' ),
						array( 'title' => __( 'Accelerate', 'cypher-one' ), 'text' => __( 'Deploy faster, and prove the return.', 'cypher-one' ), 'link' => '{approach}#accel-title' ),
					),
					array( 'layout' => 'table' )
				),
				c1_fld( 'alone_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Take the AI readiness assessment', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'alone_btn_link', 'link', __( 'Button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'alone_more_label', 'text', __( 'Link label', 'cypher-one' ), __( 'How we work', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'alone_more_link', 'link', __( 'Link', 'cypher-one' ), '{howwework}', array( 'wrapper' => array( 'width' => 50 ) ) ),
			),
			/* ---------------------------------------------------------------- Score your idea */
			c1_sec_ga(
				array(
					'__tab'        => __( 'Score your idea', 'cypher-one' ),
					'ga_eyebrow'   => __( 'Score your idea', 'cypher-one' ),
					'ga_title'     => __( 'Not every idea needs AI.', 'cypher-one' ),
					'ga_lede'      => '',
					'ga_caveat'    => __( 'This is a quick, indicative read from six answers. In an AI Adoption Review we validate it properly, with your data and your people.', 'cypher-one' ),
					'ga_btn_label' => __( 'Book a 30-minute call', 'cypher-one' ),
					'ga_ask'       => '',
				)
			),
			array(
				c1_fld( 'ga_sub', 'text', __( 'Sub-heading', 'cypher-one' ), __( 'Test one idea against our use-case scorecard', 'cypher-one' ) ),

				/* ------------------------------------------------------------ AI Adoption Review */
				c1_tab( __( 'AI Adoption Review', 'cypher-one' ) ),
				c1_fld( 'rev_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'AI Adoption Review', 'cypher-one' ) ),
				c1_fld( 'rev_title', 'html', __( 'Heading', 'cypher-one' ), __( 'A full picture before you spend. A report you can act on.', 'cypher-one' ) ),
				c1_fld( 'rev_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'A comprehensive assessment for AI adoption, across your organisation or one priority process. You get a report your board can read and your team can execute.', 'cypher-one' ) ),
				c1_fld( 'rev_paper_title', 'text', __( 'Report cover title', 'cypher-one' ), __( 'Cypher-One AI Opportunity and Risk Report', 'cypher-one' ) ),
				c1_fld( 'rev_get', 'text', __( 'List heading', 'cypher-one' ), __( 'You get:', 'cypher-one' ) ),
				c1_rep(
					'rev_items',
					__( 'What you get', 'cypher-one' ),
					array(
						c1_fld( 'bold', 'text', __( 'Bold start', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 40 ) ) ),
						c1_fld( 'text', 'text', __( 'Rest of the sentence', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 60 ) ) ),
					),
					array(
						array( 'bold' => __( 'Every AI tool already in use', 'cypher-one' ), 'text' => __( 'across your organisation, approved or not.', 'cypher-one' ) ),
						array( 'bold' => __( 'Your AI ideas scored,', 'cypher-one' ), 'text' => __( 'with the expected return for each.', 'cypher-one' ) ),
						array( 'bold' => __( 'Organisation readiness:', 'cypher-one' ), 'text' => __( 'how ready your people, processes and leadership are.', 'cypher-one' ) ),
						array( 'bold' => __( 'Governance:', 'cypher-one' ), 'text' => __( 'where you stand on risk and compliance.', 'cypher-one' ) ),
						array( 'bold' => __( 'What must be fixed first:', 'cypher-one' ), 'text' => __( 'data, owners and controls.', 'cypher-one' ) ),
						array( 'bold' => __( 'A 30/90/180-day plan,', 'cypher-one' ), 'text' => __( 'and a team to deliver it.', 'cypher-one' ) ),
					),
					array( 'layout' => 'table' )
				),
				c1_fld( 'rev_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Take the AI readiness assessment', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'rev_btn_link', 'link', __( 'Button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'rev_more_label', 'text', __( 'Link label', 'cypher-one' ), __( 'See what’s in the report', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'rev_more_link', 'link', __( 'Link', 'cypher-one' ), '{discovery}', array( 'wrapper' => array( 'width' => 50 ) ) ),
			),
			/* ---------------------------------------------------------------- Close */
			c1_sec_close(
				array(
					'close_title'      => __( 'Thirty minutes to discuss your needs', 'cypher-one' ),
					'close_lede'       => __( 'Tell us what you want AI to achieve. We will tell you where we see the value, what it would take, and how we can help.', 'cypher-one' ),
					'close_ask'        => '',
					'close_btn1_label' => __( 'Book 30 minutes', 'cypher-one' ),
				)
			)
		),
	),
);
