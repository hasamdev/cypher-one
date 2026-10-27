<?php
/**
 * "Our Approach" page fields (website-new layout).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_icons = array(
	'search'   => __( 'Magnifier', 'cypher-one' ),
	'learn'    => __( 'Mortarboard', 'cypher-one' ),
	'chart'    => __( 'Bar chart', 'cypher-one' ),
	'blocks'   => __( 'Blocks', 'cypher-one' ),
	'lines'    => __( 'Lines', 'cypher-one' ),
	'arrow'    => __( 'Arrow', 'cypher-one' ),
	'bell'     => __( 'Bell', 'cypher-one' ),
	'shield'   => __( 'Shield', 'cypher-one' ),
	'compass'  => __( 'Compass', 'cypher-one' ),
);

$c1_list = function ( $items ) {
	return array_map(
		function ( $t ) {
			return array( 'text' => $t );
		},
		$items
	);
};
$c1_fx = function ( $pairs ) {
	$out = array();
	foreach ( $pairs as $label => $link ) {
		$out[] = array(
			'label' => $label,
			'link'  => $link,
		);
	}
	return $out;
};
$c1_get  = __( 'You get', 'cypher-one' );
$c1_step = function ( $anchor, $icon, $name, $title, $text, $bullets, $get, $fixes, $more, $link ) use ( $c1_list, $c1_fx, $c1_get ) {
	return array(
		'anchor'    => $anchor,
		'icon'      => $icon,
		'name'      => $name,
		'title'     => $title,
		'text'      => $text,
		'bullets'   => $c1_list( $bullets ),
		'get_label' => $c1_get,
		'get'       => $get,
		'fixes'     => $c1_fx( $fixes ),
		'more'      => $more,
		'link'      => $link,
	);
};
$c1_s  = __( 'Strategy', 'cypher-one' );
$c1_d  = __( 'Data', 'cypher-one' );
$c1_g  = __( 'Governance', 'cypher-one' );
$c1_p  = __( 'Processes', 'cypher-one' );
$c1_pe = __( 'People', 'cypher-one' );

return array(
	'approach' => array(
		'title'          => __( '“Our Approach” page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/our-approach.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge(
			array(
				/* ------------------------------------------------------------ Hero */
				c1_tab( __( 'Hero', 'cypher-one' ) ),
				c1_fld( 'oa_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Our approach', 'cypher-one' ) ),
				c1_fld( 'oa_title', 'html', __( 'Heading', 'cypher-one' ), __( 'We fix the root causes in six steps. <span>Then we can keep watch.</span>', 'cypher-one' ) ),
				c1_fld( 'oa_lede', 'html', __( 'Introduction', 'cypher-one' ), __( 'Analyse, Educate, Prioritise, Build, Govern and Accelerate. Each one closes one or more of the <a class="ln-more" href="{why}#root-causes">five reasons AI fails</a>. We do it with your people, and after go-live our assurance service can keep watch for you.', 'cypher-one' ), array( 'rows' => 4, 'instructions' => __( 'Page tokens such as {why} work inside links here too.', 'cypher-one' ) ) ),
				c1_fld( 'oa_fig_top', 'text', __( 'Diagram centre: small label', 'cypher-one' ), __( 'ONGOING', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
				c1_fld( 'oa_fig_mid', 'text', __( 'Diagram centre: title', 'cypher-one' ), __( 'Assurance', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
				c1_fld( 'oa_fig_bottom', 'text', __( 'Diagram centre: note', 'cypher-one' ), __( 'reviewed quarterly', 'cypher-one' ), array( 'wrapper' => array( 'width' => 34 ) ) ),

				c1_tab( __( 'Photo band', 'cypher-one' ) ),
				c1_fld( 'photo_show', 'true_false', __( 'Show the photo band', 'cypher-one' ), true ),
				c1_fld( 'photo_image', 'image', __( 'Photo', 'cypher-one' ), c1_unsplash( 'photo-1709377195538-5522ed0f9e10' ) ),
				c1_fld( 'photo_alt', 'text', __( 'Alternative text', 'cypher-one' ), __( 'Abstract amber and dark curves on black', 'cypher-one' ) ),
				c1_fld( 'photo_caption', 'html', __( 'Caption / credit', 'cypher-one' ), __( 'Abstract · <a href="https://unsplash.com/" rel="noopener">Pawel Czerwinski on Unsplash</a>', 'cypher-one' ) ),

				/* ------------------------------------------------------------ Six steps */
				c1_tab( __( 'Six steps', 'cypher-one' ) ),
				c1_fld( 'st_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Six steps', 'cypher-one' ) ),
				c1_fld( 'st_title', 'html', __( 'Heading', 'cypher-one' ), __( 'What we do, what you get, and which root cause it fixes', 'cypher-one' ) ),
				c1_fld( 'st_fixes_label', 'text', __( '“Fixes:” label', 'cypher-one' ), __( 'Fixes:', 'cypher-one' ) ),
				c1_rep(
					'st_steps',
					__( 'Steps', 'cypher-one' ),
					array(
						c1_fld( 'anchor', 'text', __( 'Anchor', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 25 ), 'instructions' => __( 'Heading id becomes anchor-title, e.g. #govern-title.', 'cypher-one' ) ) ),
						c1_fld( 'icon', 'select', __( 'Icon', 'cypher-one' ), 'search', array( 'choices' => $c1_icons, 'wrapper' => array( 'width' => 25 ) ) ),
						c1_fld( 'name', 'text', __( 'Step name', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
						c1_fld( 'title', 'text', __( 'Heading', 'cypher-one' ) ),
						c1_fld( 'text', 'textarea', __( 'Text', 'cypher-one' ) ),
						c1_rep( 'bullets', __( 'Checklist', 'cypher-one' ), array( c1_fld( 'text', 'text', __( 'Item', 'cypher-one' ) ) ), array(), array( 'layout' => 'table' ) ),
						c1_fld( 'get_label', 'text', __( '“You get” label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 30 ) ) ),
						c1_fld( 'get', 'text', __( 'What you get', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 70 ) ) ),
						c1_rep(
							'fixes',
							__( 'Fixes (root cause tags)', 'cypher-one' ),
							array(
								c1_fld( 'label', 'text', __( 'Tag', 'cypher-one' ) ),
								c1_fld( 'link', 'link', __( 'Link', 'cypher-one' ) ),
							),
							array(),
							array( 'layout' => 'table' )
						),
						c1_fld( 'more', 'text', __( 'Link label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
						c1_fld( 'link', 'link', __( 'Link', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
					),
					array(
						$c1_step( 'analyse', 'search', __( 'Analyse', 'cypher-one' ), __( 'See what you have, and where it pays', 'cypher-one' ), __( 'We find every AI tool already in use and check whether your organisation, data and controls are ready for more.', 'cypher-one' ), array( __( 'Every AI tool, vendor and data flow listed', 'cypher-one' ), __( 'Data readiness checked for the processes that matter', 'cypher-one' ), __( 'Organisation readiness and governance: the risk and compliance gaps', 'cypher-one' ) ), __( 'The AI Opportunity and Risk Report, written for your board.', 'cypher-one' ), array( $c1_s => '{why}#cause-strategy', $c1_d => '{why}#cause-data', $c1_g => '{why}#cause-governance' ), __( 'What the AI Adoption Review delivers', 'cypher-one' ), '{discovery}' ),
						$c1_step( 'educate', 'learn', __( 'Educate', 'cypher-one' ), __( 'Tailored training for every level', 'cypher-one' ), __( 'Training built around your roles, your tools and your use cases, so people use AI well and question it when it is wrong.', 'cypher-one' ), array( __( 'Leaders: set the direction and judge which ideas pay', 'cypher-one' ), __( 'Managers: run AI inside their teams and measure it', 'cypher-one' ), __( 'Teams: hands-on with the tools they actually use', 'cypher-one' ) ), __( 'A training programme tailored to your organisation.', 'cypher-one' ), array( $c1_pe => '{why}#cause-people' ), __( 'Who we train', 'cypher-one' ), '#bring' ),
						$c1_step( 'prioritise', 'chart', __( 'Prioritise', 'cypher-one' ), __( 'Agree what goes first', 'cypher-one' ), __( 'Every idea is scored the same way on our use-case scorecard, so the budget goes where the return is.', 'cypher-one' ), array( __( 'Ideas scored on six questions, by people with no stake in the answer', 'cypher-one' ), __( 'A shortlist with the expected return and cost of each', 'cypher-one' ), __( 'A 30, 90 and 180-day plan with owners', 'cypher-one' ) ), __( 'A ranked shortlist and a plan your board can sign off.', 'cypher-one' ), array( $c1_s => '{why}#cause-strategy' ), __( 'How we score ideas', 'cypher-one' ), '#scorecard' ),
						$c1_step( 'build', 'blocks', __( 'Build', 'cypher-one' ), __( 'Deliver secure, sovereign solutions', 'cypher-one' ), __( 'We design and oversee; vetted partners build and integrate. The work is redesigned around the AI with the people who do it.', 'cypher-one' ), array( __( 'Hosted in-country or on your premises where it matters', 'cypher-one' ), __( 'Tested and red-teamed before go-live: we try to make it misbehave before anyone else does', 'cypher-one' ), __( 'Workflows redesigned with the people who do the work', 'cypher-one' ) ), __( 'AI in production that fits how your people work.', 'cypher-one' ), array( $c1_d => '{why}#cause-data', $c1_p => '{why}#cause-workflow' ), __( 'See the operating model', 'cypher-one' ), '#opmodel' ),
						$c1_step( 'govern', 'lines', __( 'Govern', 'cypher-one' ), __( 'One set of rules over every kind of AI', 'cypher-one' ), __( 'Owners, limits and approvals are built into the systems, so the next tool follows the same rules as the last.', 'cypher-one' ), array( __( 'A named owner and limits for every system', 'cypher-one' ), __( 'A person approves where the consequences are high', 'cypher-one' ), __( 'Mapped to PDPPL, NCSA and QCB requirements', 'cypher-one' ) ), __( 'An AI operating model your own teams run.', 'cypher-one' ), array( $c1_g => '{why}#cause-governance', $c1_p => '{why}#cause-workflow' ), __( 'Ongoing assurance', 'cypher-one' ), '#assurance' ),
						$c1_step( 'accel', 'arrow', __( 'Accelerate', 'cypher-one' ), __( 'Then approve new AI faster', 'cypher-one' ), __( 'Once the risky uses are controlled, the safe ones get a fast track, and what works is scaled.', 'cypher-one' ), array( __( 'Fast-track approval for low-risk uses', 'cypher-one' ), __( 'What works scaled across the organisation', 'cypher-one' ), __( 'One view of return for the board, every quarter', 'cypher-one' ) ), __( 'More AI in use, safely, with the return measured.', 'cypher-one' ), array( $c1_p => '{why}#cause-workflow', $c1_pe => '{why}#cause-people' ), __( 'What waiting costs you', 'cypher-one' ), '{cost}' ),
					),
					array( 'button_label' => __( 'Add step', 'cypher-one' ) )
				),
			),
			/* ---------------------------------------------------------------- Scorecard */
			c1_sec_sc(
				array(
					'__tab'      => __( 'How we prioritise', 'cypher-one' ),
					'sc_eyebrow' => __( 'How we prioritise', 'cypher-one' ),
					'sc_ask'     => '',
				)
			),
			array(
				/* ------------------------------------------------------------ Operating model */
				c1_tab( __( 'One operating model', 'cypher-one' ) ),
				c1_fld( 'op_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'One operating model', 'cypher-one' ) ),
				c1_fld( 'op_title', 'html', __( 'Heading', 'cypher-one' ), __( 'You already have several kinds of AI. We make them work as one.', 'cypher-one' ) ),
				c1_fld( 'op_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Most organisations bought AI in pieces, from different vendors, over several years. We put one set of rules over all of it, on one foundation your teams can run.', 'cypher-one' ) ),
				c1_fld( 'op_aria', 'text', __( 'Description for screen readers', 'cypher-one' ), __( 'Six kinds of AI most organisations already run', 'cypher-one' ) ),
				c1_rep(
					'op_kinds',
					__( 'Kinds of AI', 'cypher-one' ),
					array(
						c1_fld( 'title', 'text', __( 'Name', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 35 ) ) ),
						c1_fld( 'text', 'text', __( 'Description', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 65 ) ) ),
					),
					array(
						array( 'title' => __( 'Existing systems', 'cypher-one' ), 'text' => __( 'Finance, HR, customer and core platforms, where the real data lives.', 'cypher-one' ) ),
						array( 'title' => __( 'Rules and automation', 'cypher-one' ), 'text' => __( 'If this, then that. Predictable and easy to audit.', 'cypher-one' ) ),
						array( 'title' => __( 'Machine learning', 'cypher-one' ), 'text' => __( 'Predictions from your past data: churn, fraud, demand.', 'cypher-one' ) ),
						array( 'title' => __( 'Reading text', 'cypher-one' ), 'text' => __( 'Pulls what matters from contracts and emails, in Arabic and English.', 'cypher-one' ) ),
						array( 'title' => __( 'Generative AI', 'cypher-one' ), 'text' => __( 'Writes, summarises and answers. The kind most often used without approval.', 'cypher-one' ) ),
						array( 'title' => __( 'Agents', 'cypher-one' ), 'text' => __( 'AI that takes action. The biggest gains, and where limits matter most.', 'cypher-one' ) ),
					),
					array( 'layout' => 'table' )
				),

				/* ------------------------------------------------------------ Built with your people */
				c1_tab( __( 'Built with your people', 'cypher-one' ) ),
				c1_fld( 'bring_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Built with your people', 'cypher-one' ) ),
				c1_fld( 'bring_title', 'html', __( 'Heading', 'cypher-one' ), __( 'The capability stays when we leave', 'cypher-one' ) ),
				c1_fld( 'bring_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'We design and oversee. Vetted partners build and integrate. The competence is yours.', 'cypher-one' ) ),
				c1_rep(
					'bring_tiers',
					__( 'Who we train', 'cypher-one' ),
					array(
						c1_fld( 'label', 'text', __( 'Group', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 25 ) ) ),
						c1_fld( 'title', 'text', __( 'Heading', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 25 ) ) ),
						c1_fld( 'text', 'text', __( 'Text', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
					),
					array(
						array( 'label' => __( 'Leaders', 'cypher-one' ), 'title' => __( 'Set the direction', 'cypher-one' ), 'text' => __( 'Decide where AI goes and judge which ideas will pay.', 'cypher-one' ) ),
						array( 'label' => __( 'Managers', 'cypher-one' ), 'title' => __( 'Run it', 'cypher-one' ), 'text' => __( 'Put AI inside their teams’ work and measure what it returns.', 'cypher-one' ) ),
						array( 'label' => __( 'Teams', 'cypher-one' ), 'title' => __( 'Use it well', 'cypher-one' ), 'text' => __( 'Get the most from AI, and question it when it is wrong.', 'cypher-one' ) ),
					),
					array( 'layout' => 'table' )
				),

				/* ------------------------------------------------------------ Assurance */
				c1_tab( __( 'Assurance service', 'cypher-one' ) ),
				c1_fld( 'as_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Assurance service', 'cypher-one' ) ),
				c1_fld( 'as_title', 'html', __( 'Heading', 'cypher-one' ), __( 'After go-live, we can keep watch. <span class="as-h">Monitored throughout, reviewed with you every quarter.</span>', 'cypher-one' ) ),
				c1_fld( 'as_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'A paid service for clients with AI in production. We monitor the AI you use on an ongoing basis, and every quarter we review the findings with you and report to your board. You hear about a problem from us first, not from a customer, an auditor or a regulator.', 'cypher-one' ), array( 'rows' => 4 ) ),
				c1_rep(
					'as_cols',
					__( 'Columns', 'cypher-one' ),
					array(
						c1_fld( 'icon', 'select', __( 'Icon', 'cypher-one' ), 'bell', array( 'choices' => $c1_icons, 'wrapper' => array( 'width' => 25 ) ) ),
						c1_fld( 'title', 'text', __( 'Heading', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 75 ) ) ),
						c1_fld( 'items', 'textarea', __( 'Items (one per line)', 'cypher-one' ), '', array( 'rows' => 3 ) ),
					),
					array(
						array( 'icon' => 'bell', 'title' => __( 'Alert', 'cypher-one' ), 'items' => implode( "\n", array( __( 'New or unapproved AI tools', 'cypher-one' ), __( 'Sensitive data going where it should not', 'cypher-one' ), __( 'Systems behaving outside their limits', 'cypher-one' ) ) ) ),
						array( 'icon' => 'shield', 'title' => __( 'Protect', 'cypher-one' ), 'items' => implode( "\n", array( __( 'Every tool checked against your rules and Qatar’s requirements', 'cypher-one' ), __( 'High-risk uses held for a person to approve', 'cypher-one' ), __( 'The evidence trail auditors ask for', 'cypher-one' ) ) ) ),
						array( 'icon' => 'compass', 'title' => __( 'Guide', 'cypher-one' ), 'items' => implode( "\n", array( __( 'What to fix first, in plain language', 'cypher-one' ), __( 'Return tracked against each baseline', 'cypher-one' ), __( 'A quarterly review and board report', 'cypher-one' ) ) ) ),
					)
				),

				/* ------------------------------------------------------------ Start here */
				c1_tab( __( 'Start here', 'cypher-one' ) ),
				c1_fld( 'start_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Start here', 'cypher-one' ) ),
				c1_fld( 'start_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Find out which foundation to build first', 'cypher-one' ) ),
				c1_fld( 'start_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'The assessment scores you on the five root causes and shows where you stand today.', 'cypher-one' ) ),
				c1_fld( 'start_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Take the AI readiness assessment', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
				c1_fld( 'start_btn_link', 'link', __( 'Button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
			)
		),
	),
);
