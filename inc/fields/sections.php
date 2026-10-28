<?php
/**
 * Reusable section field sets. Each returns fields for one section; pages pass
 * overrides (field name => default) to change the default content.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Apply default overrides by field name (top-level fields of a section).
 * Use '__tab' to rename the section tab.
 *
 * @param array $fields Fields.
 * @param array $o      Overrides.
 * @return array
 */
function c1_apply_ov( $fields, $o ) {
	foreach ( $fields as $i => $f ) {
		if ( 'tab' === $f['type'] && isset( $o['__tab'] ) ) {
			$fields[ $i ]['label'] = $o['__tab'];
		} elseif ( isset( $f['name'] ) && array_key_exists( $f['name'], $o ) ) {
			$fields[ $i ]['default'] = $o[ $f['name'] ];
		}
	}
	return $fields;
}

/**
 * Section fields: gap.
 *
 * @param array $o Overrides.
 * @return array
 */
function c1_sec_gap( $o = array() ) {
	return c1_apply_ov(
		array(
			c1_tab( __( 'Readiness gap', 'cypher-one' ) ),
			c1_fld( 'gap_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'The readiness gap', 'cypher-one' ) ),
			c1_fld( 'gap_title', 'html', __( 'Heading', 'cypher-one' ), __( 'What AI could do for you is growing faster than most organisations are ready for', 'cypher-one' ) ),
			c1_fld( 'gap_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( "AI's potential grows every few months, while an organisation's readiness grows in steps, and the space between the two is the readiness gap: the technology can do more than the organisation around it is set up to handle. It is also an opportunity gap, because that same space is the value AI could be returning to you right now, and is not.", 'cypher-one' ), array( 'rows' => 4 ) ),
			c1_fld( 'gap_caption', 'text', __( 'Chart caption', 'cypher-one' ), __( 'A conceptual picture of the pattern we see in client organisations.', 'cypher-one' ) ),
			c1_fld( 'gap_side_title', 'text', __( 'List heading', 'cypher-one' ), __( 'What the gap looks like in practice', 'cypher-one' ) ),
			c1_rep(
				'gap_points',
				__( 'Points', 'cypher-one' ),
				array(
					c1_fld( 'title', 'text', __( 'Heading', 'cypher-one' ) ),
					c1_fld( 'text', 'textarea', __( 'Text', 'cypher-one' ) ),
				),
				array(
					array(
						'title' => __( 'The technology arrives before the organisation is ready for it', 'cypher-one' ),
						'text'  => __( 'Tools get adopted faster than the people, data, processes and rules around them can adjust.', 'cypher-one' ),
					),
					array(
						'title' => __( 'Decisions outpace review', 'cypher-one' ),
						'text'  => __( 'When a system acts in seconds, a weekly approval meeting cannot see what happened, let alone stop it.', 'cypher-one' ),
					),
					array(
						'title' => __( 'Ownership blurs', 'cypher-one' ),
						'text'  => __( 'When a result comes from several systems, it is not clear who is accountable for it. Boards and regulators will still ask.', 'cypher-one' ),
					),
					array(
						'title' => __( 'Closing the gap is management work, not a software purchase', 'cypher-one' ),
						'text'  => __( 'It is about how the organisation decides, owns, measures and changes. That is where we work.', 'cypher-one' ),
					),
				)
			),
			c1_fld( 'gap_ask', 'text', __( 'Closing question', 'cypher-one' ), __( 'Where is your organisation on this chart today, and is the gap getting wider or narrower?', 'cypher-one' ) ),

			/* ---------------------------------------------------------------- How we work */
		),
		$o
	);
}

/**
 * Section fields: int.
 *
 * @param array $o Overrides.
 * @return array
 */
function c1_sec_int( $o = array() ) {
	return c1_apply_ov(
		array(
			c1_tab( __( 'How we work', 'cypher-one' ) ),
			c1_fld( 'int_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'How we work', 'cypher-one' ) ),
			c1_fld( 'int_title', 'html', __( 'Heading', 'cypher-one' ), __( 'We look at the whole picture before we recommend anything', 'cypher-one' ) ),
			c1_fld( 'int_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Most AI advice starts with a use case; we start with everything already there, the systems, the AI in use, the data, the people and their skills, the processes and the rules, then sort it against one rubric and decide what makes sense, in what order. We do it with your people, not around them, so the organisation can repeat the exercise without us.', 'cypher-one' ), array( 'rows' => 4 ) ),
			c1_rep(
				'int_steps',
				__( 'Steps', 'cypher-one' ),
				array(
					c1_fld( 'label', 'text', __( 'Step label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 30 ) ) ),
					c1_fld( 'title', 'text', __( 'Heading', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 70 ) ) ),
					c1_fld( 'text', 'textarea', __( 'Text', 'cypher-one' ) ),
					c1_fld( 'result_label', 'text', __( 'Result label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 30 ) ) ),
					c1_fld( 'result', 'text', __( 'Result', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 70 ) ) ),
				),
				array(
					array(
						'label'        => __( 'Step 1', 'cypher-one' ),
						'title'        => __( 'Look at everything', 'cypher-one' ),
						'text'         => __( 'One inventory, not a wish list. Every system, every AI tool already in use (approved or not), where the data sits and who owns it, how the work actually flows, who does what, and which rules already apply.', 'cypher-one' ),
						'result_label' => __( 'Result:', 'cypher-one' ),
						'result'       => __( 'a plain map of your organisation as it is today.', 'cypher-one' ),
					),
					array(
						'label'        => __( 'Step 2', 'cypher-one' ),
						'title'        => __( 'Sort it against one rubric', 'cypher-one' ),
						'text'         => __( 'Everything on the map is placed under the five parts of readiness: strategy and direction, data and technology, governance and risk, processes and operating model, people, skills and change. Each part gets an honest score.', 'cypher-one' ),
						'result_label' => __( 'Result:', 'cypher-one' ),
						'result'       => __( 'you can see where you are strong, where you are exposed, and how the pieces connect.', 'cypher-one' ),
					),
					array(
						'label'        => __( 'Step 3', 'cypher-one' ),
						'title'        => __( 'Decide what makes sense', 'cypher-one' ),
						'text'         => __( 'Only now do we talk about what to do. Some things need fixing before any AI will work. Some AI should be stopped or brought under control. Some ideas are ready to build. Some should be left alone.', 'cypher-one' ),
						'result_label' => __( 'Result:', 'cypher-one' ),
						'result'       => __( 'a short list, in order, with a reason for each item.', 'cypher-one' ),
					),
				),
				array( 'button_label' => __( 'Add step', 'cypher-one' ) )
			),
			c1_fld( 'int_ask', 'text', __( 'Closing question', 'cypher-one' ), __( 'If someone had to list every AI tool, data source and process in your organisation today, how long would the list be, and who would know?', 'cypher-one' ) ),

			/* ---------------------------------------------------------------- Scorecard */
		),
		$o
	);
}

/**
 * Section fields: sc.
 *
 * @param array $o Overrides.
 * @return array
 */
function c1_sec_sc( $o = array() ) {
	return c1_apply_ov(
		array(
			c1_tab( __( 'How we find value', 'cypher-one' ) ),
			c1_fld( 'sc_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'How we find value', 'cypher-one' ) ),
			c1_fld( 'sc_title', 'html', __( 'Heading', 'cypher-one' ), __( 'How we tell which AI ideas are worth doing', 'cypher-one' ) ),
			c1_fld( 'sc_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Before you spend a riyal, every idea is scored the same way, against the same questions, by people with no stake in the answer. The score weighs what an idea could return against what it would take to make it work and keep it safe.', 'cypher-one' ) ),
			c1_rep(
				'sc_dims',
				__( 'Questions', 'cypher-one' ),
				array(
					c1_fld( 'title', 'text', __( 'Question', 'cypher-one' ) ),
					c1_fld( 'text', 'text', __( 'Explanation', 'cypher-one' ) ),
				),
				array(
					array( 'title' => __( 'Is the Return Real?', 'cypher-one' ), 'text' => __( 'And can it be measured, so you know afterwards whether it worked.', 'cypher-one' ) ),
					array( 'title' => __( 'Is the Organisation Ready for It?', 'cypher-one' ), 'text' => __( 'The data, the process and the rules it would depend on.', 'cypher-one' ) ),
					array( 'title' => __( 'Does the Organisation Have the Capability?', 'cypher-one' ), 'text' => __( 'The people, the skills and the leadership to run it well, not just to launch it.', 'cypher-one' ) ),
					array( 'title' => __( 'Can It Be Controlled?', 'cypher-one' ), 'text' => __( 'Who owns it, what it may do, and whether it complies with the rules that apply to you.', 'cypher-one' ) ),
					array( 'title' => __( 'Is AI Good Enough at This Today?', 'cypher-one' ), 'text' => __( 'Some tasks it does reliably. Some it does not yet. We say which.', 'cypher-one' ) ),
					array( 'title' => __( 'Can It Be Hosted the Way You Need?', 'cypher-one' ), 'text' => __( 'In line with Gulf data rules, in-country or on your premises where that matters.', 'cypher-one' ) ),
				),
				array( 'layout' => 'table' )
			),
			c1_fld( 'sc_ex_label', 'text', __( 'Example label', 'cypher-one' ), __( 'Illustrative', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'sc_ex_title', 'text', __( 'Example heading', 'cypher-one' ), __( 'What a scored idea looks like', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'sc_ex_verdict', 'text', __( 'Example verdict', 'cypher-one' ), __( 'Strong candidate', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_rep(
				'sc_bars',
				__( 'Example bars', 'cypher-one' ),
				array(
					c1_fld( 'label', 'text', __( 'Label', 'cypher-one' ) ),
					c1_fld( 'value', 'number', __( 'Length (%)', 'cypher-one' ), 50, array( 'min' => 0, 'max' => 100 ) ),
				),
				array(
					array( 'label' => __( 'Return', 'cypher-one' ), 'value' => 82 ),
					array( 'label' => __( 'Readiness', 'cypher-one' ), 'value' => 58 ),
					array( 'label' => __( 'Capability', 'cypher-one' ), 'value' => 50 ),
					array( 'label' => __( 'Control', 'cypher-one' ), 'value' => 64 ),
					array( 'label' => __( 'Feasibility', 'cypher-one' ), 'value' => 78 ),
					array( 'label' => __( 'Hosting', 'cypher-one' ), 'value' => 95 ),
				),
				array( 'layout' => 'table' )
			),
			c1_fld( 'sc_ex_note', 'text', __( 'Example note', 'cypher-one' ), __( 'Every idea gets the same bars. Long means ready; short means work to do first. Illustrative, not a real client.', 'cypher-one' ) ),
			c1_fld( 'sc_ask', 'text', __( 'Closing question', 'cypher-one' ), __( 'Take your most-talked-about AI idea. Which of these questions would it struggle to answer?', 'cypher-one' ) ),

			/* ---------------------------------------------------------------- Guided scorer */
		),
		$o
	);
}

/**
 * Section fields: ga.
 *
 * @param array $o Overrides.
 * @return array
 */
function c1_sec_ga( $o = array() ) {
	return c1_apply_ov(
		array(
			c1_tab( __( 'Score your own idea', 'cypher-one' ) ),
			c1_fld( 'ga_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Score your own idea', 'cypher-one' ) ),
			c1_fld( 'ga_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Describe one idea and get a first score in a minute', 'cypher-one' ) ),
			c1_fld( 'ga_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'These are the same questions we ask in a discovery. Answer them for one idea and you will see what is working in its favour and what would hold it back — before anyone has spent money on it.', 'cypher-one' ) ),
			c1_fld( 'ga_usecase_label', 'text', __( 'Idea box label', 'cypher-one' ), __( 'What would you like AI to do?', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'ga_usecase_placeholder', 'text', __( 'Idea box placeholder', 'cypher-one' ), __( 'What is your use case or idea?', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'ga_base', 'number', __( 'Starting score', 'cypher-one' ), 50, array( 'wrapper' => array( 'width' => 33 ), 'instructions' => __( 'Each answer adds or subtracts its weight from this.', 'cypher-one' ) ) ),
			c1_fld( 'ga_min', 'number', __( 'Lowest score shown', 'cypher-one' ), 8, array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'ga_max', 'number', __( 'Highest score shown', 'cypher-one' ), 95, array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_rep(
				'ga_questions',
				__( 'Questions', 'cypher-one' ),
				array(
					c1_fld( 'question', 'text', __( 'Question', 'cypher-one' ) ),
					c1_rep(
						'options',
						__( 'Answers', 'cypher-one' ),
						array(
							c1_fld( 'label', 'text', __( 'Answer', 'cypher-one' ) ),
							c1_fld( 'weight', 'number', __( 'Weight', 'cypher-one' ), 0 ),
							c1_fld( 'against', 'text', __( '“Holding it back” note', 'cypher-one' ) ),
							c1_fld( 'favour', 'text', __( '“In your favour” note', 'cypher-one' ) ),
						),
						array(),
						array(
							'layout'       => 'table',
							'button_label' => __( 'Add answer', 'cypher-one' ),
						)
					),
				),
				c1_ga_default_questions(),
				array( 'button_label' => __( 'Add question', 'cypher-one' ) )
			),
			c1_fld( 'ga_result_label', 'text', __( 'Result label', 'cypher-one' ), __( 'Indicative likelihood of success', 'cypher-one' ) ),
			c1_fld( 'ga_back_title', 'text', __( '“Holding it back” heading', 'cypher-one' ), __( "What's holding it back", 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'ga_for_title', 'text', __( '“In your favour” heading', 'cypher-one' ), __( 'In your favour', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'ga_caveat', 'textarea', __( 'Caveat', 'cypher-one' ), __( 'This is a quick, indicative read from five answers. In a discovery we validate it properly, with your data and your people.', 'cypher-one' ) ),
			c1_fld( 'ga_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Book a discovery session', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'ga_btn_link', 'link', __( 'Button link', 'cypher-one' ), '#close', array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'ga_ask', 'text', __( 'Closing question', 'cypher-one' ), __( 'Does the score surprise you? That reaction is usually the most useful part.', 'cypher-one' ) ),

			/* ---------------------------------------------------------------- Calculator */
		),
		$o
	);
}

/**
 * Section fields: calc.
 *
 * @param array $o Overrides.
 * @return array
 */
function c1_sec_calc( $o = array() ) {
	return c1_apply_ov(
		array(
			c1_tab( __( 'Cost of waiting', 'cypher-one' ) ),
			c1_fld( 'calc_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'The cost of waiting', 'cypher-one' ) ),
			c1_fld( 'calc_title', 'html', __( 'Heading', 'cypher-one' ), __( 'What is waiting costing you?', 'cypher-one' ) ),
			c1_fld( 'calc_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Most leaders can name the risk of moving on AI. Fewer put a number on the risk of not moving. This estimate does that, using three figures you already know. Move the sliders.', 'cypher-one' ) ),
			c1_fld( 'calc_legend', 'text', __( 'Panel heading', 'cypher-one' ), __( 'Your team', 'cypher-one' ) ),
			c1_fld( 'calc_currency', 'text', __( 'Currency', 'cypher-one' ), 'QAR', array( 'wrapper' => array( 'width' => 25 ) ) ),
			c1_fld( 'calc_reclaim_pct', 'number', __( 'Reclaimable share of time (%)', 'cypher-one' ), 80, array( 'wrapper' => array( 'width' => 25 ), 'min' => 0, 'max' => 100 ) ),
			c1_fld( 'calc_month_hours', 'number', __( 'Working hours per month', 'cypher-one' ), 160, array( 'wrapper' => array( 'width' => 25 ) ) ),
			c1_fld( 'calc_weeks', 'number', __( 'Weeks per month', 'cypher-one' ), 4, array( 'wrapper' => array( 'width' => 25 ) ) ),
			c1_fld( 'calc_team_label', 'text', __( 'Team size label', 'cypher-one' ), __( 'Team size', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_team_max', 'number', __( 'Team size maximum', 'cypher-one' ), 500, array( 'wrapper' => array( 'width' => 25 ) ) ),
			c1_fld( 'calc_team_value', 'number', __( 'Team size starting value', 'cypher-one' ), 0, array( 'wrapper' => array( 'width' => 25 ) ) ),
			c1_fld( 'calc_hours_label', 'text', __( 'Hours label', 'cypher-one' ), __( 'Hours', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_hours_max', 'number', __( 'Hours maximum', 'cypher-one' ), 40, array( 'wrapper' => array( 'width' => 25 ) ) ),
			c1_fld( 'calc_hours_value', 'number', __( 'Hours starting value', 'cypher-one' ), 0, array( 'wrapper' => array( 'width' => 25 ) ) ),
			c1_fld( 'calc_hours_hint', 'text', __( 'Hours hint', 'cypher-one' ), __( 'Hours per week each person spends on manual, repeatable work (estimated).', 'cypher-one' ) ),
			c1_fld( 'calc_rate_label', 'text', __( 'Cost label', 'cypher-one' ), __( 'Average monthly cost of a team member', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_rate_max', 'number', __( 'Cost maximum', 'cypher-one' ), 150000, array( 'wrapper' => array( 'width' => 16 ) ) ),
			c1_fld( 'calc_rate_step', 'number', __( 'Cost step', 'cypher-one' ), 1000, array( 'wrapper' => array( 'width' => 17 ) ) ),
			c1_fld( 'calc_rate_value', 'number', __( 'Cost starting value', 'cypher-one' ), 0, array( 'wrapper' => array( 'width' => 17 ) ) ),
			c1_fld( 'calc_note', 'html', __( 'How it works', 'cypher-one' ), __( '<strong>How it works:</strong> team size × weekly manual hours × 4 weeks gives monthly hours; × hourly cost (monthly cost ÷ 160 hours) gives the monthly cost. We assume up to 80% of that time can be reclaimed with the right skills, redesigned workflows and clear governance. A planning estimate, not a quote.', 'cypher-one' ), array( 'rows' => 4 ) ),
			c1_fld( 'calc_lost_label', 'text', __( 'Label: productivity lost', 'cypher-one' ), __( 'Productivity lost every month', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_per_month', 'text', __( 'Label: per month suffix', 'cypher-one' ), __( '/ month', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_today_label', 'text', __( 'Label: today', 'cypher-one' ), __( 'Today', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_after_label', 'text', __( 'Label: with the right foundation', 'cypher-one' ), __( 'With the right foundation', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_month_label', 'text', __( 'Label: reclaimable per month', 'cypher-one' ), __( 'Reclaimable / month', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_year_label', 'text', __( 'Label: reclaimable per year', 'cypher-one' ), __( 'Reclaimable / year', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_fte_text', 'html', __( 'Capacity freed', 'cypher-one' ), __( 'Capacity freed: {fte} full-time roles', 'cypher-one' ), array( 'instructions' => __( 'Live values: {hours}, {lost}, {save}, {year}, {left}, {fte}, {pct}.', 'cypher-one' ) ) ),
			c1_fld( 'calc_summary_1', 'html', __( 'Summary paragraph 1', 'cypher-one' ), __( 'Your team spends about {hours} hours a month on manual, repeatable work. With the right skills, redesigned workflows and clear governance, up to {pct} of that time comes back, worth about {save} a month.', 'cypher-one' ), array( 'instructions' => __( 'Live values: {hours}, {lost}, {save}, {year}, {left}, {fte}, {pct}.', 'cypher-one' ) ) ),
			c1_fld( 'calc_summary_2', 'html', __( 'Summary paragraph 2', 'cypher-one' ), __( 'The real question is which of that work is safe to hand to AI and where a person has to stay in the loop. That is what a discovery answers.', 'cypher-one' ) ),
			c1_fld( 'calc_next', 'html', __( 'Call to action text', 'cypher-one' ), __( 'Waiting costs about {year} a year in capacity you are already paying for.', 'cypher-one' ), array( 'instructions' => __( 'Live values: {hours}, {lost}, {save}, {year}, {left}, {fte}, {pct}.', 'cypher-one' ) ) ),
			c1_fld( 'calc_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Turn this estimate into a plan →', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_btn_link', 'link', __( 'Button link', 'cypher-one' ), '#close', array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'calc_ask', 'text', __( 'Closing question', 'cypher-one' ), __( 'If that capacity came back next quarter, what would you have your people do with it?', 'cypher-one' ) ),

			/* ---------------------------------------------------------------- Report */
		),
		$o
	);
}

/**
 * Section fields: report.
 *
 * @param array $o Overrides.
 * @return array
 */
function c1_sec_report( $o = array() ) {
	return c1_apply_ov(
		array(
			c1_tab( __( 'What a discovery delivers', 'cypher-one' ) ),
			c1_fld( 'rep_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'What a discovery delivers', 'cypher-one' ) ),
			c1_fld( 'rep_title', 'html', __( 'Heading', 'cypher-one' ), __( 'A fixed-price discovery that ends in a report you can act on, and a team that will guide you through the implementation', 'cypher-one' ) ),
			c1_fld( 'rep_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'In two to four weeks we map one priority process and answer the same six questions we score every idea on. You receive a report your board and leadership can read, and your team can execute with our assistance.', 'cypher-one' ) ),
			c1_fld( 'rep_paper_title', 'text', __( 'Report cover title', 'cypher-one' ), __( 'Cypher-One AI Opportunity and Risk Report', 'cypher-one' ) ),
			c1_rep(
				'rep_items',
				__( 'Report sections', 'cypher-one' ),
				array(
					c1_fld( 'title', 'text', __( 'Heading', 'cypher-one' ) ),
					c1_fld( 'text', 'textarea', __( 'Text', 'cypher-one' ) ),
				),
				array(
					array( 'title' => __( 'The problem and what it costs', 'cypher-one' ), 'text' => __( 'Where it sits in the process, and the number it is costing you today.', 'cypher-one' ) ),
					array( 'title' => __( 'The return, and how to measure it', 'cypher-one' ), 'text' => __( 'What the idea is worth, with a baseline so you can prove it afterwards.', 'cypher-one' ) ),
					array( 'title' => __( 'What must be in place first', 'cypher-one' ), 'text' => __( 'The data, the process changes and the rules the idea depends on.', 'cypher-one' ) ),
					array( 'title' => __( 'Who will own and run it', 'cypher-one' ), 'text' => __( 'The people, skills and leadership needed, and the gaps.', 'cypher-one' ) ),
					array( 'title' => __( 'How it will be controlled', 'cypher-one' ), 'text' => __( 'Limits built into the system, named owners, and compliance with the rules that apply to you.', 'cypher-one' ) ),
					array( 'title' => __( 'What to build, where to host it, and the plan', 'cypher-one' ), 'text' => __( 'What AI can and cannot do here, an independent technology recommendation, in-country hosting where it matters, and a 30/90/180-day plan with a fixed price for phase one.', 'cypher-one' ) ),
				)
			),
			c1_fld( 'rep_ask', 'text', __( 'Closing question', 'cypher-one' ), __( 'Which one process, if it worked better, would your whole organisation feel?', 'cypher-one' ) ),

			/* ---------------------------------------------------------------- Close */
		),
		$o
	);
}

/**
 * Section fields: close.
 *
 * @param array $o Overrides.
 * @return array
 */
function c1_sec_close( $o = array() ) {
	return c1_apply_ov(
		array(
			c1_tab( __( 'Talk to us', 'cypher-one' ) ),
			c1_fld( 'close_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Talk to us', 'cypher-one' ) ),
			c1_fld( 'close_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Thirty minutes to discuss your needs', 'cypher-one' ) ),
			c1_fld( 'close_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Tell us what you want AI to achieve. We will tell you where we see the value, what it would take, and how we can help.', 'cypher-one' ) ),
			c1_fld( 'close_ask', 'text', __( 'Question', 'cypher-one' ), '' ),
			c1_fld( 'close_btn1_label', 'text', __( 'Primary button label', 'cypher-one' ), __( 'Tell us what you need', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'close_btn1_link', 'link', __( 'Primary button link', 'cypher-one' ), '{contact}#contact', array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'close_btn2_label', 'text', __( 'Secondary button label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'close_btn2_link', 'link', __( 'Secondary button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
		),
		$o
	);
}
