<?php
/**
 * "Why AI fails" page fields (website-new layout).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_mck = 'https://www.mckinsey.com/capabilities/quantumblack/our-insights/the-state-of-ai';
$c1_ibm = 'https://www.ibm.com/reports/data-breach';
$c1_fix = __( 'How we fix it', 'cypher-one' );

$c1_stage = function ( $title, $lede, $changes, $exposure ) {
	return array(
		'title'    => $title,
		'lede'     => $lede,
		'changes'  => $changes,
		'exposure' => $exposure,
	);
};

$c1_cause = function ( $anchor, $area, $title, $text, $stat, $src, $year, $url, $value, $fix, $more, $link, $chart = 'ring', $value2 = 0, $l1 = '', $l2 = '' ) use ( $c1_fix ) {
	return array(
		'anchor'    => $anchor,
		'area'      => $area,
		'title'     => $title,
		'text'      => $text,
		'stat'      => $stat,
		'src_name'  => $src,
		'src_year'  => $year,
		'src_url'   => $url,
		'chart'     => $chart,
		'value'     => $value,
		'value2'    => $value2,
		'label1'    => $l1,
		'label2'    => $l2,
		'fix_label' => $c1_fix,
		'fix'       => $fix,
		'more'      => $more,
		'link'      => $link,
	);
};

return array(
	'why' => array(
		'title'          => __( '“Why AI stalls” page content', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/why-ai-stalls.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array(
			/* ---------------------------------------------------------------- Hero */
			c1_tab( __( 'Hero', 'cypher-one' ) ),
			c1_fld( 'wf_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Why AI stalls', 'cypher-one' ) ),
			c1_fld( 'wf_title', 'html', __( 'Heading', 'cypher-one' ), __( '95% of organisations see no return from generative AI. <span>It is rarely the technology.</span>', 'cypher-one' ) ),
			c1_fld( 'wf_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Across the research, the same five root causes come up again and again. None of them is the model. Each is something a leadership team can fix, and each is something we fix with you.', 'cypher-one' ) ),
			c1_rep(
				'wf_sources',
				__( 'Source badges', 'cypher-one' ),
				array(
					c1_fld( 'name', 'text', __( 'Source', 'cypher-one' ) ),
					c1_fld( 'year', 'text', __( 'Year', 'cypher-one' ) ),
					c1_fld( 'url', 'text', __( 'URL', 'cypher-one' ) ),
				),
				array(
					array( 'name' => 'MIT Project NANDA', 'year' => '2025', 'url' => 'https://nanda.media.mit.edu/' ),
				),
				array( 'layout' => 'table' )
			),
			c1_fld( 'wf_red', 'number', __( 'Chart: red squares (out of 100)', 'cypher-one' ), 5, array( 'min' => 0, 'max' => 100, 'wrapper' => array( 'width' => 30 ) ) ),
			c1_fld( 'wf_aria', 'text', __( 'Chart: description for screen readers', 'cypher-one' ), __( '100 squares, 95 grey and 5 red: 5 in 100 organisations see a return from generative AI', 'cypher-one' ), array( 'wrapper' => array( 'width' => 70 ) ) ),
			c1_fld( 'wf_key1', 'text', __( 'Chart key: grey', 'cypher-one' ), __( 'No measurable return', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'wf_key2', 'text', __( 'Chart key: red', 'cypher-one' ), __( 'Measurable return', 'cypher-one' ), array( 'wrapper' => array( 'width' => 33 ) ) ),
			c1_fld( 'wf_key_note', 'text', __( 'Chart key: note', 'cypher-one' ), __( 'each square is 1% of organisations', 'cypher-one' ), array( 'wrapper' => array( 'width' => 34 ) ) ),

			c1_tab( __( 'Photo band', 'cypher-one' ) ),
			c1_fld( 'photo_show', 'true_false', __( 'Show the photo band', 'cypher-one' ), true ),
			c1_fld( 'photo_image', 'image', __( 'Photo', 'cypher-one' ), c1_unsplash( 'photo-1750315080835-6f8640a00a12' ) ),
			c1_fld( 'photo_alt', 'text', __( 'Alternative text', 'cypher-one' ), __( 'Abstract glowing orange light wave on black', 'cypher-one' ) ),
			c1_fld( 'photo_caption', 'html', __( 'Caption / credit', 'cypher-one' ), __( 'Abstract · <a href="https://unsplash.com/" rel="noopener">Unsplash</a>', 'cypher-one' ) ),

			/* ---------------------------------------------------------------- Root causes */
			c1_tab( __( 'Five root causes', 'cypher-one' ) ),
			c1_fld( 'rc_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'The five root causes', 'cypher-one' ) ),
			c1_fld( 'rc_title', 'html', __( 'Heading', 'cypher-one' ), __( 'What actually stops AI paying back, and how we fix it', 'cypher-one' ) ),
			c1_rep(
				'rc_causes',
				__( 'Root causes', 'cypher-one' ),
				array(
					c1_fld( 'anchor', 'text', __( 'Anchor id', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 25 ), 'instructions' => __( 'Used by links such as {why}#cause-data.', 'cypher-one' ) ) ),
					c1_fld( 'area', 'text', __( 'Area label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 35 ) ) ),
					c1_fld( 'title', 'text', __( 'Heading', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 40 ) ) ),
					c1_fld( 'text', 'textarea', __( 'Text', 'cypher-one' ) ),
					c1_fld( 'stat', 'text', __( 'Key figure sentence', 'cypher-one' ) ),
					c1_fld( 'src_name', 'text', __( 'Source', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 25 ) ) ),
					c1_fld( 'src_year', 'text', __( 'Year', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 15 ) ) ),
					c1_fld( 'src_url', 'text', __( 'Source URL', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 60 ) ) ),
					c1_fld( 'chart', 'select', __( 'Chart', 'cypher-one' ), 'ring', array( 'choices' => array( 'ring' => __( 'Ring (one figure)', 'cypher-one' ), 'compare' => __( 'Two bars (compare)', 'cypher-one' ) ), 'wrapper' => array( 'width' => 20 ) ) ),
					c1_fld( 'value', 'number', __( 'Figure (%)', 'cypher-one' ), 0, array( 'min' => 0, 'max' => 100, 'wrapper' => array( 'width' => 20 ) ) ),
					c1_fld( 'value2', 'number', __( 'Second figure (%) — bars only', 'cypher-one' ), 0, array( 'min' => 0, 'max' => 100, 'wrapper' => array( 'width' => 20 ) ) ),
					c1_fld( 'label1', 'text', __( 'Bar 1 label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 20 ) ) ),
					c1_fld( 'label2', 'text', __( 'Bar 2 label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 20 ) ) ),
					c1_fld( 'fix_label', 'text', __( '“How we fix it” label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 30 ) ) ),
					c1_fld( 'fix', 'textarea', __( 'How we fix it', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 70 ) ) ),
					c1_fld( 'more', 'text', __( 'Link label', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
					c1_fld( 'link', 'link', __( 'Link', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 50 ) ) ),
				),
				array(
					$c1_cause( 'cause-strategy', __( '1 · Strategy and direction', 'cypher-one' ), __( 'Nobody measures the value', 'cypher-one' ), __( 'AI is started because it is expected, not tied to a goal. With no baseline there is no proof, so the funding stops.', 'cypher-one' ), __( 'Only 37% of organisations attribute any EBIT impact to their AI use.', 'cypher-one' ), 'McKinsey', '2026', $c1_mck, 37, __( 'We tie every AI idea to a business goal and a baseline before anything is built, using our use-case scorecard.', 'cypher-one' ), __( 'Score an idea', 'cypher-one' ), '{home}#assess' ),
					$c1_cause( 'cause-data', __( '2 · Data and technology', 'cypher-one' ), __( 'Your data isn’t ready', 'cypher-one' ), __( 'Scattered, duplicated, and nobody owns it. The pilot works on clean data the real business does not have.', 'cypher-one' ), __( '60% of AI projects without AI-ready data are expected to be abandoned through 2026.', 'cypher-one' ), 'Gartner', '2025', 'https://www.gartner.com/en/newsroom/press-releases/2025-02-26-lack-of-ai-ready-data-puts-ai-projects-at-risk', 60, __( 'We map where your data sits, who owns it and whether it can be trusted, then fix what the first use case needs.', 'cypher-one' ), __( 'How the AI Adoption Review works', 'cypher-one' ), '{discovery}' ),
					$c1_cause( 'cause-governance', __( '3 · Governance and risk', 'cypher-one' ), __( 'Nobody owns the risk', 'cypher-one' ), __( 'AI spreads informally. Nobody is accountable, and leadership hears about it last.', 'cypher-one' ), __( '52% of department-level AI initiatives run with no formal approval or oversight.', 'cypher-one' ), 'EY', '2026', 'https://www.ey.com/en_us/newsroom/2026/03/ey-survey-autonomous-ai-adoption-surges-at-tech-companies-as-oversight-falls-behind', 52, __( 'We find every AI tool in use, name an owner for each, and build approvals and limits into the systems, not into a policy document.', 'cypher-one' ), __( 'How we govern', 'cypher-one' ), '{approach}#govern-title' ),
					$c1_cause( 'cause-workflow', __( '4 · Processes and operating model', 'cypher-one' ), __( 'It doesn’t fit how people work', 'cypher-one' ), __( 'The tool sits beside the process, not inside it. People drift back to the old way.', 'cypher-one' ), __( 'About three-quarters of AI high performers redesigned their workflows, against about a quarter of other companies.', 'cypher-one' ), 'McKinsey', '2026', $c1_mck, 75, __( 'We redesign the process around the AI with the people who do the work, so it becomes how work gets done.', 'cypher-one' ), __( 'How we work', 'cypher-one' ), '{howwework}', 'compare', 25, __( 'Leaders', 'cypher-one' ), __( 'Others', 'cypher-one' ) ),
					$c1_cause( 'cause-people', __( '5 · People, skills and change', 'cypher-one' ), __( 'Nobody was prepared', 'cypher-one' ), __( 'Staff are not trained to use AI well, or to question it when it is wrong.', 'cypher-one' ), __( 'Only 36% of employees feel adequately trained in AI use.', 'cypher-one' ), 'BCG', '2025', 'https://www.bcg.com/press/26june2025-beyond-ai-adoption-full-potential', 36, __( 'We train leaders and teams to use AI well and to challenge it, so adoption lasts after we leave.', 'cypher-one' ), __( 'How we train your people', 'cypher-one' ), '{approach}#educate-title' ),
				),
				array( 'button_label' => __( 'Add root cause', 'cypher-one' ) )
			),

			/* ---------------------------------------------------------------- Timeline */
			c1_tab( __( 'Risk timeline', 'cypher-one' ) ),
			c1_fld( 'rt_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Why it is getting harder', 'cypher-one' ) ),
			c1_fld( 'rt_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Every step of AI adoption adds value, and adds risk', 'cypher-one' ) ),
			c1_fld( 'rt_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'Adoption rarely happens by decision. It happens by accumulation: a few people try a tool, a team builds it into a process, someone connects it to a system, and one day it is running parts of the business. Most organisations are already past the first stage. Select one to see what changes.', 'cypher-one' ), array( 'rows' => 4 ) ),
			c1_rep(
				'rt_stages',
				__( 'Stages', 'cypher-one' ),
				array(
					c1_fld( 'title', 'text', __( 'Stage name', 'cypher-one' ) ),
					c1_fld( 'lede', 'textarea', __( 'Summary', 'cypher-one' ) ),
					c1_fld( 'changes', 'textarea', __( 'What changes', 'cypher-one' ) ),
					c1_fld( 'exposure', 'textarea', __( 'New exposure', 'cypher-one' ) ),
				),
				array(
					$c1_stage( __( 'AI adoption', 'cypher-one' ), __( 'Staff start using assistants and copilots on their own initiative.', 'cypher-one' ), __( 'Individual productivity rises, quickly and unevenly.', 'cypher-one' ), __( 'Company data goes to outside models with no clear rules.', 'cypher-one' ) ),
					$c1_stage( __( 'Automation', 'cypher-one' ), __( 'AI is built into routine work such as drafting, triage and summarising.', 'cypher-one' ), __( 'Output scales across teams.', 'cypher-one' ), __( 'Errors repeat at scale, and the review steps quietly disappear.', 'cypher-one' ) ),
					$c1_stage( __( 'Agents', 'cypher-one' ), __( 'Systems begin to take actions across your tools: sending, filing, updating, paying.', 'cypher-one' ), __( "Work moves without a person at each step. Yesterday's AI answered a question in ChatGPT or Copilot and a person decided what to do. An agent reads the inbox, updates the record and raises the order itself.", 'cypher-one' ), __( 'Actions are taken without clear authority or a record of what was done.', 'cypher-one' ) ),
					$c1_stage( __( 'Autonomy', 'cypher-one' ), __( 'Systems chain decisions together with less human review in between.', 'cypher-one' ), __( 'Decisions happen faster than anyone can check.', 'cypher-one' ), __( 'Outcomes emerge that nobody explicitly chose.', 'cypher-one' ) ),
					$c1_stage( __( 'Organisational complexity', 'cypher-one' ), __( 'Many systems, models and vendors interact across the business.', 'cypher-one' ), __( 'Capability compounds across functions.', 'cypher-one' ), __( 'Unexpected interactions, unclear ownership, and dependence on vendors you cannot see into.', 'cypher-one' ) ),
					$c1_stage( __( 'New risk surface', 'cypher-one' ), __( 'AI now touches data, decisions, customers and reputation at once.', 'cypher-one' ), __( 'AI becomes part of how the organisation runs.', 'cypher-one' ), __( 'Behaviour and risk that your existing controls were never designed for.', 'cypher-one' ) ),
				),
				array( 'button_label' => __( 'Add stage', 'cypher-one' ) )
			),
			c1_fld( 'rt_ask', 'text', __( 'Closing question', 'cypher-one' ), '' ),

			/* ---------------------------------------------------------------- Control gap */
			c1_tab( __( 'Control gap', 'cypher-one' ) ),
			c1_fld( 'cg_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'The control gap', 'cypher-one' ) ),
			c1_fld( 'cg_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Adoption has run ahead of control.', 'cypher-one' ) ),
			c1_fld( 'cg_lede', 'textarea', __( 'Introduction', 'cypher-one' ), __( 'When something goes wrong, the governance usually was not there.', 'cypher-one' ) ),
			c1_rep(
				'cg_stats',
				__( 'Figures', 'cypher-one' ),
				array(
					c1_fld( 'value', 'number', __( 'Figure (%)', 'cypher-one' ), 0, array( 'min' => 0, 'max' => 100, 'wrapper' => array( 'width' => 20 ) ) ),
					c1_fld( 'text', 'textarea', __( 'Description', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 80 ) ) ),
					c1_fld( 'src_name', 'text', __( 'Source', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 25 ) ) ),
					c1_fld( 'src_year', 'text', __( 'Year', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 15 ) ) ),
					c1_fld( 'src_url', 'text', __( 'Source URL', 'cypher-one' ), '', array( 'wrapper' => array( 'width' => 60 ) ) ),
				),
				array(
					array( 'value' => 63, 'text' => __( 'of organisations that suffered a breach had no AI governance policy, or were still writing one.', 'cypher-one' ), 'src_name' => 'IBM', 'src_year' => '2025', 'src_url' => $c1_ibm ),
					array( 'value' => 97, 'text' => __( 'of organisations that reported a breach of an AI model or application had no AI access controls in place.', 'cypher-one' ), 'src_name' => 'IBM', 'src_year' => '2025', 'src_url' => $c1_ibm ),
				)
			),

			/* ---------------------------------------------------------------- Readiness */
			c1_tab( __( 'Where do you stand?', 'cypher-one' ) ),
			c1_fld( 'rd_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), __( 'Where do you stand?', 'cypher-one' ) ),
			c1_fld( 'rd_title', 'html', __( 'Heading', 'cypher-one' ), __( 'Your organisation is probably ready for AI in some areas and not in others', 'cypher-one' ) ),
			c1_rep(
				'rd_paragraphs',
				__( 'Paragraphs', 'cypher-one' ),
				array( c1_fld( 'text', 'textarea', __( 'Paragraph', 'cypher-one' ), '', array( 'rows' => 4 ) ) ),
				array(
					array( 'text' => __( 'The five root causes above are the five parts of readiness we assess. Most organisations are strong in one or two, and exposed in the rest.', 'cypher-one' ) ),
					array( 'text' => __( 'A typical picture: the marketing team uses ChatGPT every day, so skills look fine. Customer data sits in six systems and a dozen spreadsheets that nobody owns. There is no AI policy, so nobody knows what staff are pasting into public tools. And the board has asked for "an AI strategy" twice. Strong in one or two areas, exposed in the rest. The chart shows that shape: five columns, five different heights.', 'cypher-one' ) ),
				),
				array( 'button_label' => __( 'Add paragraph', 'cypher-one' ) )
			),
			c1_fld( 'rd_ask', 'text', __( 'Question', 'cypher-one' ), __( 'Which of the five is your strongest today — and which one would a regulator or a customer find first?', 'cypher-one' ) ),
			c1_fld( 'rd_btn_label', 'text', __( 'Button label', 'cypher-one' ), __( 'Take the AI readiness assessment', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'rd_btn_link', 'link', __( 'Button link', 'cypher-one' ), '{assessment}', array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'rd_fig_title', 'text', __( 'Chart label', 'cypher-one' ), __( 'Your AI readiness', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'rd_fig_tag', 'text', __( 'Chart tag', 'cypher-one' ), __( 'Illustrative', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'rd_legend_1', 'text', __( 'Legend: white bar', 'cypher-one' ), __( 'Where you are', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'rd_legend_2', 'text', __( 'Legend: red dashed space', 'cypher-one' ), __( 'Readiness gap', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'rd_caption', 'textarea', __( 'Chart caption', 'cypher-one' ), __( 'The same five root causes as above. The white bar is how far you have got in each; the red dashed space above it is the work still to do before AI can safely act at that level. Illustrative.', 'cypher-one' ) ),
		),
	),
);
