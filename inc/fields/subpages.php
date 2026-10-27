<?php
/**
 * Fields for the single-topic pages: Score one idea, Cost of waiting,
 * The readiness gap, AI Adoption Review (discovery) and How we work.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_review = __( 'AI Adoption Review', 'cypher-one' );

return array(
	'score'     => array(
		'title'          => __( '“Score one idea” page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/tools-score-an-idea.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge(
			c1_sec_ga(
				array(
					'ga_lede'      => __( 'These are the same questions we ask in an AI Adoption Review. Answer them for one idea and you will see what is working in its favour and what would hold it back — before anyone has spent money on it.', 'cypher-one' ),
					'ga_caveat'    => __( 'This is a quick, indicative read from six answers. In an AI Adoption Review we validate it properly, with your data and your people.', 'cypher-one' ),
					'ga_btn_label' => __( 'Book a 30-minute call', 'cypher-one' ),
				)
			),
			c1_sec_close()
		),
	),
	'cost'      => array(
		'title'          => __( '“Cost of waiting” page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/tools-cost-of-waiting.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge(
			c1_sec_calc(
				array(
					'calc_summary_2' => __( 'The real question is which of that work is safe to hand to AI and where a person has to stay in the loop. That is what an AI Adoption Review answers.', 'cypher-one' ),
					'calc_btn_link'  => '{contact}#contact',
				)
			),
			c1_sec_close()
		),
	),
	'gap'       => array(
		'title'          => __( '“Readiness gap” page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/readiness-gap.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge( c1_sec_gap(), c1_sec_close() ),
	),
	'discovery' => array(
		'title'          => __( '“AI Adoption Review” page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/discovery.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge(
			c1_sec_report(
				array(
					'__tab'       => $c1_review,
					'rep_eyebrow' => $c1_review,
					'rep_title'   => __( 'A comprehensive assessment for AI adoption, a report you can act on, and a team that will guide you through the implementation', 'cypher-one' ),
					'rep_lede'    => __( 'We map your organisation, or one priority process, and answer the same six questions we score every idea on. You receive a report your board and leadership can read, and your team can execute with our assistance.', 'cypher-one' ),
					'rep_items'   => array(
						array( 'title' => __( 'The problem and what it costs', 'cypher-one' ), 'text' => __( 'Where it sits in the process, and the number it is costing you today.', 'cypher-one' ) ),
						array( 'title' => __( 'The return, and how to measure it', 'cypher-one' ), 'text' => __( 'What the idea is worth, with a baseline so you can prove it afterwards.', 'cypher-one' ) ),
						array( 'title' => __( 'What must be in place first', 'cypher-one' ), 'text' => __( 'The data, the process changes and the rules the idea depends on.', 'cypher-one' ) ),
						array( 'title' => __( 'Who will own and run it', 'cypher-one' ), 'text' => __( 'The people, skills and leadership needed, and the gaps.', 'cypher-one' ) ),
						array( 'title' => __( 'How it will be controlled', 'cypher-one' ), 'text' => __( 'Limits built into the system, named owners, and compliance with the rules that apply to you.', 'cypher-one' ) ),
						array( 'title' => __( 'What to build, where to host it, and the plan', 'cypher-one' ), 'text' => __( 'What AI can and cannot do here, an independent technology recommendation, in-country hosting where it matters, and a 30/90/180-day plan with a costed first phase.', 'cypher-one' ) ),
					),
				)
			),
			c1_sec_close()
		),
	),
	'howwework' => array(
		'title'          => __( '“How we work” page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/how-we-work.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array_merge( c1_sec_int(), c1_sec_sc(), c1_sec_close() ),
	),
);
