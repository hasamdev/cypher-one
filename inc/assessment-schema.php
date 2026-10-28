<?php
/**
 * AI Readiness Assessment Question Bank and Rubric Engine.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return the full AI Readiness Assessment question bank and scoring schema.
 *
 * @return array
 */
function c1_assessment_schema() {
	return array(
		'bands'        => array(
			array( 'min' => 0, 'max' => 40, 'label' => 'Exploring', 'color' => '#E8321A' ),
			array( 'min' => 41, 'max' => 60, 'label' => 'Experimenting', 'color' => '#C8892A' ),
			array( 'min' => 61, 'max' => 80, 'label' => 'Scaling', 'color' => '#2E7D8A' ),
			array( 'min' => 81, 'max' => 100, 'label' => 'Leading', 'color' => '#2C6E5B' ),
		),
		'dims'         => array(
			array( 'key' => 'strategy', 'label' => 'Strategy', 'bench' => 58, 'desc' => 'A written AI plan tied to business goals, and someone who owns it.' ),
			array( 'key' => 'leadership', 'label' => 'Leadership', 'bench' => 55, 'desc' => 'Whether your board understands AI, and whether AI is properly funded.' ),
			array( 'key' => 'people', 'label' => 'People', 'bench' => 48, 'desc' => 'Training matched to the role, and access to the skills you need.' ),
			array( 'key' => 'data', 'label' => 'Data', 'bench' => 42, 'desc' => 'Whether AI can reach your data, and whether that data can be trusted.' ),
			array( 'key' => 'technology', 'label' => 'Technology', 'bench' => 52, 'desc' => 'A shared platform, and AI connected to the systems people use daily.' ),
			array( 'key' => 'process', 'label' => 'Process', 'bench' => 45, 'desc' => 'Redesigning the work around AI, and managing the change with staff.' ),
			array( 'key' => 'value', 'label' => 'Value', 'bench' => 44, 'desc' => 'Choosing use cases by value, and measuring what AI actually returns.' ),
			array( 'key' => 'trust', 'label' => 'Trust', 'bench' => 50, 'desc' => 'Basic rules for AI use, and knowing every AI tool in the organisation.' ),
		),
		'pillars'      => array(
			array(
				'n'      => 1,
				'name'   => 'Capability Building',
				'dims'   => array( 'people', 'leadership' ),
				'colour' => '#B31B0C',
				'cta'    => 'A tiered AI literacy programme, plus a Board-Level AI Briefing.',
			),
			array(
				'n'      => 2,
				'name'   => 'Governance & Value Assurance',
				'dims'   => array( 'trust', 'value' ),
				'colour' => '#C8892A',
				'cta'    => 'The ISO 42001 AIMS Readiness Sprint — gap assessment and remediation roadmap.',
			),
			array(
				'n'      => 3,
				'name'   => 'Transformation & Strategy',
				'dims'   => array( 'strategy', 'process' ),
				'colour' => '#2E7D8A',
				'cta'    => 'An AI maturity assessment with use-case prioritisation and workflow redesign.',
			),
			array(
				'n'      => 4,
				'name'   => 'Platforms & Solutions',
				'dims'   => array( 'data', 'technology' ),
				'colour' => '#2C6E5B',
				'cta'    => 'Solution scoping and architecture, vendor selection and AI vendor due diligence.',
			),
		),
		'sector_group' => array(
			'Healthcare & Medical'        => 'Healthcare',
			'Financial Services'          => 'Financial services',
			'Government & Public Sector'  => 'Government & public',
			'HR & Recruitment'            => 'Government & public',
			'Legal Services'              => 'Government & public',
			'Education'                   => 'Government & public',
			'Security & Law Enforcement'  => 'Government & public',
			'Transportation & Logistics'  => 'Energy & industrial',
			'Energy & Utilities'          => 'Energy & industrial',
			'Manufacturing & Industrial'  => 'Energy & industrial',
			'Real Estate & Construction'  => 'Energy & industrial',
			'Hospitality & Tourism'       => 'SME / Enterprise',
			'Telecommunications'          => 'Media & technology',
			'Media / Technology'          => 'Media & technology',
			'Retail & E-commerce'         => 'SME / Enterprise',
			'Other'                       => 'Other',
		),
		'weights'      => array(
			'Financial services'  => array( 'strategy' => 1.3, 'leadership' => 1.3, 'people' => 1.2, 'data' => 1.4, 'technology' => 1.3, 'process' => 1.2, 'value' => 1.3, 'trust' => 1.8 ),
			'Government & public' => array( 'strategy' => 1.3, 'leadership' => 1.7, 'people' => 1.7, 'data' => 1.3, 'technology' => 1.1, 'process' => 1.3, 'value' => 1.1, 'trust' => 1.4 ),
			'Energy & industrial' => array( 'strategy' => 1.2, 'leadership' => 1.1, 'people' => 1.2, 'data' => 1.8, 'technology' => 1.7, 'process' => 1.4, 'value' => 1.2, 'trust' => 1.2 ),
			'Healthcare'          => array( 'strategy' => 1.2, 'leadership' => 1.3, 'people' => 1.4, 'data' => 1.6, 'technology' => 1.2, 'process' => 1.3, 'value' => 1.1, 'trust' => 1.5 ),
			'Media & technology'  => array( 'strategy' => 1.3, 'leadership' => 1.1, 'people' => 1.3, 'data' => 1.4, 'technology' => 1.5, 'process' => 1.2, 'value' => 1.4, 'trust' => 1.2 ),
			'SME / Enterprise'    => array( 'strategy' => 1.2, 'leadership' => 1.1, 'people' => 1.2, 'data' => 1.2, 'technology' => 1.1, 'process' => 1.2, 'value' => 1.6, 'trust' => 1.1 ),
			'Other'               => array( 'strategy' => 1.2, 'leadership' => 1.2, 'people' => 1.2, 'data' => 1.2, 'technology' => 1.2, 'process' => 1.2, 'value' => 1.2, 'trust' => 1.2 ),
		),
		'practice'     => array(
			array(
				'id'      => 'p1',
				'dim'     => 'strategy',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Is there a written AI plan tied to your business goals?',
				'example' => 'A written plan naming what AI is for this year, its business objectives, and who owns it.',
				'matters' => 'Every funded AI programme starts with a written plan that someone has signed. Without one, spend scatters.',
				'wrong'   => 'AI spend scatters across departments with nothing to show at year end.',
				'opts'    => array( 'No plan', 'Ideas, nothing written', 'A slide, not a plan', 'A written plan', 'A funded plan tied to business targets' ),
			),
			array(
				'id'      => 'p2',
				'dim'     => 'strategy',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Who holds the budget and the mandate for AI?',
				'example' => 'One person the board can ask "how is AI going?" and get an answer.',
				'matters' => '70% of Middle East CEOs have an AI roadmap. Far fewer have a single person accountable for delivering it.',
				'wrong'   => 'Everyone assumes someone else owns it, so nothing scales past AI pilot.',
				'opts'    => array( 'No one', 'Split across departments', 'IT owns it by default', 'A named executive sponsor', 'A sponsor with budget and a steering group' ),
			),
			array(
				'id'      => 'p3',
				'dim'     => 'leadership',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Does your board or executive team understand AI well enough to make decisions about it?',
				'example' => 'Approving an AI investment without needing to take the vendor\'s word for it.',
				'matters' => 'Boards approve or block AI investment. Their level of understanding sets the ceiling on what you can do.',
				'wrong'   => 'You either over-buy on hype or freeze on fear — both are expensive.',
				'opts'    => array( 'Not at all', 'Aware of the headlines', 'Some understand', 'Briefed and confident', 'Trained, and it shapes strategy' ),
			),
			array(
				'id'      => 'p4',
				'dim'     => 'leadership',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'How is AI funded?',
				'example' => 'Whether a promising AI pilot has a route to real money, or dies at the end of the trial.',
				'matters' => 'Pilots are cheap. Scaling is not. Money set aside for the second stage is what separates a demo from a system.',
				'wrong'   => 'Pilots succeed and then stop, because nothing was set aside to scale them.',
				'opts'    => array( 'No budget', 'Ad hoc, case by case', 'A AI pilot budget only', 'An annual AI budget', 'Funding over several years, including money to grow what works' ),
			),
			array(
				'id'      => 'p5',
				'dim'     => 'people',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Are your people trained to use AI in their actual jobs?',
				'example' => 'A finance analyst and a board member need very different AI training.',
				'matters' => 'AI literacy works when it is matched to the role. Generic training is the most common way to waste a training budget.',
				'wrong'   => 'Tools go unused, or get used badly — and the spend returns nothing.',
				'opts'    => array( 'No training', 'Optional online links', 'One generic session', 'Role-based training', 'Matched to each role, kept current and tracked' ),
			),
			array(
				'id'      => 'p6',
				'dim'     => 'people',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Can you hire or access the AI skills you need?',
				'example' => 'Needing someone who can build and run an AI system, not just talk about one.',
				'matters' => '59% of Middle East CEOs say they can access high-quality technical talent. Using it in-house is what builds lasting capability.',
				'wrong'   => 'Delivery depends entirely on vendors, and you never build internal capability.',
				'opts'    => array( 'No access', 'Vendors only', 'A few individuals', 'A small internal team', 'An internal team plus trusted partners' ),
			),
			array(
				'id'      => 'p7',
				'dim'     => 'data',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Can your AI tools actually reach the data they need?',
				'example' => 'The model is fine, but the documents it needs sit in five systems it cannot open.',
				'matters' => 'Only 16% of GCC CEOs say their AI tools can reach all the data they need. This is the region\'s single biggest brake on AI.',
				'wrong'   => 'The model works but cannot see what it needs, so the results stay thin.',
				'opts'    => array( 'No access', 'Locked in silos', 'Partial access', 'Most key data connected', 'Connected, controlled and up to date' ),
			),
			array(
				'id'      => 'p8',
				'dim'     => 'data',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Do you trust the quality of the data your AI would use?',
				'example' => 'Duplicate customer records producing confidently wrong answers.',
				'matters' => 'AI built on poor data produces confident, wrong output that is hard to spot.',
				'wrong'   => 'Decisions get made on output nobody has checked against reality.',
				'opts'    => array( 'Untested', 'Known to be poor', 'Mixed', 'Good in key systems', 'Checked, owned and improving' ),
			),
			array(
				'id'      => 'p9',
				'dim'     => 'technology',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Do you have a platform for AI, or is every project starting from scratch?',
				'example' => 'Three teams separately buying three different tools for the same job.',
				'matters' => 'A shared platform is what makes the second AI project cheaper than the first.',
				'wrong'   => 'Duplicate cost, no reuse, and nothing you build carries forward.',
				'opts'    => array( 'Nothing', 'Whatever each team buys', 'Some shared tools', 'A standard platform', 'A shared platform teams can reuse' ),
			),
			array(
				'id'      => 'p10',
				'dim'     => 'technology',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Can AI connect to the systems people work in every day?',
				'example' => 'AI that lives in a separate window nobody opens.',
				'matters' => 'AI that sits outside daily systems gets used during the AI pilot and forgotten after it.',
				'wrong'   => 'Usage collapses the moment the AI pilot enthusiasm fades.',
				'opts'    => array( 'Not connected', 'Manual copy-paste', 'One or two integrations', 'Integrated into main systems', 'Embedded in daily workflow' ),
			),
			array(
				'id'      => 'p11',
				'dim'     => 'process',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'When AI is introduced, do you redesign the work around it?',
				'example' => 'The AI drafts the report, but the same three approvals still take a week.',
				'matters' => 'Automating a step while keeping every approval around it delivers no time saving at all.',
				'wrong'   => 'You automate one step and keep all the delay — so the benefit never lands.',
				'opts'    => array( 'Never', 'We bolt it on', 'Small tweaks', 'We redesign key processes', 'Redesign is standard practice' ),
			),
			array(
				'id'      => 'p12',
				'dim'     => 'process',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Do you manage the change — communication, resistance, support?',
				'example' => 'Staff quietly assuming AI is there to replace them.',
				'matters' => 'Adoption is a people problem. Staff who fear AI will not use it, whatever it can do.',
				'wrong'   => 'The best tool in the world fails against an unconvinced workforce.',
				'opts'    => array( 'Not managed', 'An announcement email', 'Some support', 'A change plan per rollout', 'Managing the change is part of every rollout' ),
			),
			array(
				'id'      => 'p13',
				'dim'     => 'value',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'How do you choose which AI use cases to do first?',
				'example' => 'Picking the idea with the loudest sponsor rather than the biggest return.',
				'matters' => 'Ranking use cases by value and effort is what keeps AI spend pointed at the business.',
				'wrong'   => 'Effort goes to visible projects instead of valuable ones.',
				'opts'    => array( 'We don\'t', 'Whatever\'s suggested', 'A list, unranked', 'Ranked by value and effort needed', 'A scored list, kept current and reviewed regularly' ),
			),
			array(
				'id'      => 'p14',
				'dim'     => 'value',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Do you measure what AI delivers?',
				'example' => 'Hours saved, errors avoided, revenue gained — with a baseline to compare against.',
				'matters' => 'A programme that cannot show a return is the first thing cut in a budget review.',
				'wrong'   => 'You cannot defend the budget, and you cannot tell success from noise.',
				'opts'    => array( 'No measurement', 'Anecdotes', 'Usage only — how often it is used', 'Business outcomes tracked', 'Compared against a starting point and reported to the board' ),
			),
			array(
				'id'      => 'p15',
				'dim'     => 'trust',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Do you have basic rules for how AI is used?',
				'example' => 'Whether staff may paste client information into a free AI tool.',
				'matters' => 'Staff using free AI tools with work data is the most common cause of data loss today, and a PDPPL exposure.',
				'wrong'   => 'Client or customer information ends up on a server you do not control.',
				'opts'    => array( 'No rules', 'Spoken guidance', 'A line in a policy', 'A clear AI use policy', 'Policy, approved-tools list and training' ),
			),
			array(
				'id'      => 'p16',
				'dim'     => 'trust',
				'section' => 'practice',
				'type'    => 'scale',
				'text'    => 'Do you know every AI tool in use across the organisation?',
				'example' => 'The tools bought on a departmental card that nobody central knows about.',
				'matters' => 'You cannot govern, secure or scale what you cannot see.',
				'wrong'   => 'A tool nobody was tracking becomes a problem nobody saw coming.',
				'opts'    => array( 'No idea', 'The big ones only', 'A partial, old list', 'A maintained list', 'A current list with owners and risk levels' ),
			),
		),
		'know'         => array(
			array(
				'id'      => 'k1',
				'section' => 'know',
				'type'    => 'knowledge',
				'text'    => 'In the Middle East, how many CEOs say their company culture makes it easy to use AI?',
				'opts'    => array( 'About 2 in 10', 'About 4 in 10', 'About 8 in 10', 'I\'m not sure' ),
				'correct' => 2,
				'because' => 'About 8 in 10 (82%) — the highest of any region in the world. Wanting to use AI is not your problem. Making it work is.',
				'scores'  => array( 20, 40, 100, 0 ),
				'src'     => 'PwC 29th Global CEO Survey, Middle East findings, January 2026',
			),
			array(
				'id'      => 'k2',
				'section' => 'know',
				'type'    => 'knowledge',
				'text'    => 'In the Gulf, how many companies say their AI tools can open all the files and data they need?',
				'opts'    => array( 'Most of them', 'About half', 'Fewer than 1 in 5', 'I\'m not sure' ),
				'correct' => 2,
				'because' => 'Fewer than 1 in 5. It is 16% in the Gulf, 22% across the Middle East and 29% worldwide. Getting AI to your data is the region\'s biggest problem — not a lack of interest in AI.',
				'scores'  => array( 20, 40, 100, 0 ),
				'src'     => 'PwC 29th Global CEO Survey, Middle East findings, January 2026',
			),
			array(
				'id'      => 'k3',
				'section' => 'know',
				'type'    => 'knowledge',
				'text'    => 'Do Middle East companies plan their AI better or worse than the world average?',
				'opts'    => array( 'Worse', 'About the same', 'Better', 'I\'m not sure' ),
				'correct' => 2,
				'because' => 'Better. About 7 in 10 have a clear AI plan, against 5 in 10 worldwide. The region plans well. The gap appears when the plan has to be delivered.',
				'scores'  => array( 20, 40, 100, 0 ),
				'src'     => 'PwC 29th Global CEO Survey, Middle East findings, January 2026',
			),
			array(
				'id'      => 'k4',
				'section' => 'know',
				'type'    => 'knowledge',
				'text'    => 'Who sets Qatar\'s national direction on AI?',
				'opts'    => array( 'Qatar Central Bank (QCB)', 'The Ministry of Communications and Information Technology (MCIT)', 'ISO, the international standards body', 'I\'m not sure' ),
				'correct' => 1,
				'because' => 'MCIT leads AI for the country. The QCB sets AI rules that banks must follow, and ISO/IEC 42001 is the international standard you can be checked against.',
				'scores'  => array( 30, 100, 30, 0 ),
				'src'     => 'MCIT National AI Policy consultation; GCC AI Regulation Playbook, July 2026',
			),
		),
		'why'          => array(
			array(
				'id'      => 'r1',
				'section' => 'why',
				'type'    => 'scale',
				'text'    => 'Most AI pilots never become part of daily work. If you started one today, how sure are you that people would still be using it in a year?',
				'example' => 'A chatbot that works in a demo, and six months later is still only a demo.',
				'lesson'  => 'The technology is almost never the problem. What stops it is having no clear owner, no access to the data, and no change to how the work is done.',
				'opts'    => array( 'It would stall', 'Probably not', 'Maybe', 'Likely', 'Yes — we have a route to production' ),
			),
			array(
				'id'      => 'r2',
				'section' => 'why',
				'type'    => 'scale',
				'text'    => 'AI is only useful when people change the way they work. How ready are your staff to do that?',
				'example' => 'A new tool is given to staff, and three months later most of them still work the old way.',
				'lesson'  => 'This is about skills, not software. Training has to match the job: a front-line employee and a board member need very different things.',
				'opts'    => array( 'Not ready at all', 'A few enthusiasts', 'Mixed by team', 'Mostly ready', 'Ready — trained by role' ),
			),
			array(
				'id'      => 'r3',
				'section' => 'why',
				'type'    => 'scale',
				'text'    => 'If your CEO asked what last year\'s spending on AI gave back to the business, could you answer with a number?',
				'example' => 'At the next board meeting, someone asks what the AI budget has returned.',
				'lesson'  => 'If you cannot measure it, you cannot defend it. AI work that shows no result is usually the first thing cut from the budget.',
				'opts'    => array( 'No idea', 'Anecdotes only', 'Rough estimate', 'Measured on some projects', 'Tracked against a business case' ),
			),
		),
		'blockers'     => array(
			array( 'No one owns it', 'Nobody is named as responsible for AI, and nobody holds the budget.', 'strategy' ),
			array( 'We can\'t reach our own data', 'Data sits in separate systems, or in old systems AI cannot open.', 'data' ),
			array( 'No pipeline', 'Ideas come up here and there, and nobody ranks them by value.', 'value' ),
			array( 'Skills gap', 'Teams do not know how to use AI, or how to build with it.', 'people' ),
			array( 'Shadow AI', 'Staff use free AI tools because there is no approved way to do it properly.', 'trust' ),
			array( 'No measurement', 'Nobody can say what AI has given back to the business.', 'value' ),
			array( 'AI pilot purgatory', 'Things work in a trial and never grow beyond it.', 'process' ),
		),
		'blocker_why'  => array(
			'No one owns it'                => 'Without a single accountable owner, AI moves at the speed of whoever has spare time. Decisions wait for a meeting nobody schedules, the budget is defended by no one, and initiatives stop the moment their internal champion changes role.',
			'We can\'t reach our own data' => 'The most expensive blocker on this list, because it is the slowest to clear. Connecting systems, resolving ownership and cleaning source data take quarters rather than weeks, so every month of delay pushes the entire programme back by the same amount.',
			'No pipeline'                   => 'When ideas arrive informally, what gets built is whatever was asked for loudest rather than whatever returns most. Effort spreads thinly across small initiatives, none reaches production, and there is nothing to show at the year end.',
			'Skills gap'                    => 'Tools without capability become licences nobody uses. It also creates dependency: every change needs a vendor, costs stay variable, and internal knowledge never accumulates.',
			'Shadow AI'                     => 'Staff will use AI whether or not you provide it. Where there is no approved route, work data ends up in tools you neither control nor can audit — the most common cause of AI-related data loss today, and a direct PDPPL exposure.',
			'No measurement'                => 'Without a baseline, success and noise look identical. The programme cannot be defended at budget time and cannot be extended on evidence, so funding decisions get made on impressions.',
			'AI pilot purgatory'            => 'The single most common failure pattern in AI. The cause is rarely the technology; it is what sits around it — no production owner, no data access, no change to the workflow, and no measurement to justify going further.',
		),
		'fix'          => array(
			'strategy'   => 'Establish executive-level ownership of AI and a funded plan tied to business objectives, rather than accountability distributed across functions.',
			'leadership' => 'Build genuine board-level understanding of AI, and secure funding that covers scaling and not only AI pilots.',
			'people'     => 'Establish an AI capability programme differentiated by role and seniority, and build internal capacity rather than depending on vendors.',
			'data'       => 'Establish the data foundations AI depends on — access, quality and ownership across the systems that matter most to your use cases.',
			'technology' => 'Consolidate onto a shared AI platform integrated with the systems people already work in, so capability compounds instead of fragmenting.',
			'process'    => 'Redesign the workflows AI touches, and manage the organisational change that adoption depends on.',
			'value'      => 'Put a value framework in place — prioritisation criteria, baselines and board-level reporting on what AI returns.',
			'trust'      => 'Establish the governance basics: an AI use policy, controlled tooling, and a maintained register of every AI system in use.',
		),
		'anchors'      => array(
			array( 'QNV 2030', '#1F1D1C', 'Qatar National Vision 2030 sets human, social, economic and environmental development as the national goal. AI adoption is judged against whether it serves those aims.', 'The national frame for every organisation in Qatar.' ),
			array( 'MCIT National AI Policy', '#B31B0C', 'Qatar\'s national AI direction, setting the principles and pillars organisations are expected to align to.', 'Applies to everyone operating in Qatar.' ),
			array( 'Digital Agenda 2030', '#2E7D8A', 'Qatar\'s digital transformation programme, including supervised routes for testing higher-risk AI before it goes to market.', 'Relevant if you are building something new.' ),
			array( 'GCC AI Playbook 2026', '#C8892A', 'Regional best practice on building AI capability: assess risk and capability first, then build literacy by tier and function.', 'Applies across the Gulf.' ),
			array( 'ISO/IEC 42001', '#2C6E5B', 'The international standard for managing AI. The pivot point that bridges Qatar, Gulf and EU expectations in one system.', 'The standard your partners will ask about.' ),
		),
		'wants'        => array(
			'A 30-minute session to walk through my full report',
			'An in-depth readiness review across strategy, data, governance, process and people',
			'An AI Adoption Review of one priority process',
			'Manage risk and bring the AI we already use under control',
			'Capability building for our leaders and teams',
			'Something else',
		),
	);
}

/**
 * Helper to find the band for a numeric score (0-100).
 *
 * @param int   $score Score 0-100.
 * @param array $bands Band definitions.
 * @return array
 */
function c1_assessment_band( $score, $bands ) {
	foreach ( $bands as $b ) {
		if ( $score >= $b['min'] && $score <= $b['max'] ) {
			return $b;
		}
	}
	return $bands[0];
}

/**
 * Compute all scores, bands, pillars, roadmap, actions, and question answers from $state.
 *
 * @param array $state Decoded client state S.
 * @return array
 */
function c1_assessment_compute( $state ) {
	$schema  = c1_assessment_schema();
	$answers = isset( $state['answers'] ) && is_array( $state['answers'] ) ? $state['answers'] : array();
	$unsure  = isset( $state['unsure'] ) && is_array( $state['unsure'] ) ? $state['unsure'] : array();
	$sectors = isset( $state['sectors'] ) && is_array( $state['sectors'] ) ? array_values( $state['sectors'] ) : array();
	$other_s = isset( $state['otherSector'] ) ? sanitize_text_field( (string) $state['otherSector'] ) : '';
	$country = isset( $state['country'] ) ? sanitize_text_field( (string) $state['country'] ) : '';
	$other_c = isset( $state['otherCountry'] ) ? sanitize_text_field( (string) $state['otherCountry'] ) : '';

	$val_fn = function ( $q ) use ( $answers, $unsure ) {
		$id = $q['id'];
		if ( ! isset( $answers[ $id ] ) || null === $answers[ $id ] || '' === $answers[ $id ] ) {
			return 0;
		}
		if ( ! empty( $unsure[ $id ] ) ) {
			return 0;
		}
		$idx = (int) $answers[ $id ];
		if ( 'knowledge' === $q['type'] ) {
			return isset( $q['scores'][ $idx ] ) ? (int) $q['scores'][ $idx ] : 0;
		}
		return max( 0, min( 100, $idx * 25 ) );
	};

	$ans_label_fn = function ( $q ) use ( $answers, $unsure ) {
		$id = $q['id'];
		if ( ! empty( $unsure[ $id ] ) ) {
			return 'I\'m not sure / Don\'t know';
		}
		if ( ! isset( $answers[ $id ] ) || null === $answers[ $id ] || '' === $answers[ $id ] ) {
			return 'Not answered';
		}
		$idx   = (int) $answers[ $id ];
		$label = isset( $q['opts'][ $idx ] ) ? $q['opts'][ $idx ] : 'Not answered';
		if ( 'knowledge' === $q['type'] ) {
			if ( $idx === (int) $q['correct'] ) {
				$label .= ' [Correct]';
			} else {
				$label .= ' [Incorrect — Correct answer: ' . $q['opts'][ $q['correct'] ] . ']';
			}
		}
		return $label;
	};

	// Dimension scores.
	$d = array();
	foreach ( $schema['dims'] as $dim ) {
		$k   = $dim['key'];
		$sum = 0;
		$cnt = 0;
		foreach ( $schema['practice'] as $q ) {
			if ( $q['dim'] === $k ) {
				$sum += $val_fn( $q );
				++$cnt;
			}
		}
		$d[ $k ] = $cnt > 0 ? (int) round( $sum / $cnt ) : 0;
	}

	// Sector-weighted composite score.
	$groups = array();
	if ( ! empty( $sectors ) ) {
		foreach ( $sectors as $s ) {
			$groups[] = isset( $schema['sector_group'][ $s ] ) ? $schema['sector_group'][ $s ] : 'Other';
		}
	} else {
		$groups[] = 'Other';
	}
	$num = 0.0;
	$den = 0.0;
	foreach ( $schema['dims'] as $dim ) {
		$k = $dim['key'];
		$t = 0.0;
		foreach ( $groups as $g ) {
			$t += isset( $schema['weights'][ $g ][ $k ] ) ? $schema['weights'][ $g ][ $k ] : 1.2;
		}
		$w    = $t / count( $groups );
		$num += $d[ $k ] * $w;
		$den += $w;
	}
	$composite = $den > 0 ? (int) round( $num / $den ) : 0;

	// Knowledge & Why scores.
	$know_sum = 0;
	foreach ( $schema['know'] as $q ) {
		$know_sum += $val_fn( $q );
	}
	$know = (int) round( $know_sum / count( $schema['know'] ) );

	$why_sum = 0;
	foreach ( $schema['why'] as $q ) {
		$why_sum += $val_fn( $q );
	}
	$why = (int) round( $why_sum / count( $schema['why'] ) );

	// Pillars.
	$pillars = array();
	foreach ( $schema['pillars'] as $p ) {
		$psum = 0;
		foreach ( $p['dims'] as $dk ) {
			$psum += isset( $d[ $dk ] ) ? $d[ $dk ] : 0;
		}
		$pval      = (int) round( $psum / count( $p['dims'] ) );
		$pillars[] = array_merge( $p, array( 'value' => $pval, 'band' => c1_assessment_band( $pval, $schema['bands'] ) ) );
	}
	$sorted_pillars = $pillars;
	usort(
		$sorted_pillars,
		function ( $a, $b ) {
			return $a['value'] <=> $b['value'];
		}
	);
	$weak_pillar = $sorted_pillars[0];

	// Gaps (dimensions sorted weakest first).
	$gaps = $schema['dims'];
	usort(
		$gaps,
		function ( $a, $b ) use ( $d ) {
			return $d[ $a['key'] ] <=> $d[ $b['key'] ];
		}
	);

	// Blockers.
	$blockers = isset( $state['blockers'] ) && is_array( $state['blockers'] ) ? array_values( $state['blockers'] ) : array();

	// Roadmap.
	$fix    = $schema['fix'];
	$now    = array();
	$six    = array();
	$twelve = array();

	$now[] = array( 't' => $gaps[0]['label'], 'd' => $fix[ $gaps[0]['key'] ], 's' => $d[ $gaps[0]['key'] ] );
	if ( $d['strategy'] < 70 ) {
		$now[] = array( 't' => 'Establish accountability', 'd' => 'Executive-level ownership of AI, with the mandate and budget to act on it.', 's' => $d['strategy'] );
	}
	if ( $d['trust'] < 70 ) {
		$now[] = array( 't' => 'Set the ground rules', 'd' => 'Baseline policy and controlled tooling — the fastest way to reduce exposure while the wider programme is built.', 's' => $d['trust'] );
	}
	if ( $d['trust'] < 80 ) {
		$now[] = array( 't' => 'Establish visibility', 'd' => 'A maintained inventory of AI in use, with owners and risk levels. Every other control depends on it.', 's' => $d['trust'] );
	}

	$six[] = array( 't' => $gaps[1]['label'], 'd' => $fix[ $gaps[1]['key'] ], 's' => $d[ $gaps[1]['key'] ] );
	$six[] = array( 't' => $gaps[2]['label'], 'd' => $fix[ $gaps[2]['key'] ], 's' => $d[ $gaps[2]['key'] ] );
	if ( $d['data'] < 70 ) {
		$six[] = array( 't' => 'Establish data foundations', 'd' => 'Access, quality and ownership across the systems AI depends on. This carries the longest lead time of anything here.', 's' => $d['data'] );
	}
	if ( $d['technology'] < 70 ) {
		$six[] = array( 't' => 'Consolidate the platform', 'd' => 'A shared foundation, so capability compounds across initiatives instead of being rebuilt each time.', 's' => $d['technology'] );
	}

	if ( $d['value'] < 80 ) {
		$twelve[] = array( 't' => 'Institutionalise measurement', 'd' => 'Baselines, business cases and board reporting, so the programme can be defended and extended.', 's' => $d['value'] );
	}
	if ( $d['process'] < 80 ) {
		$twelve[] = array( 't' => 'Scale what proved out', 'd' => 'Move validated AI pilots into production with the surrounding workflow properly redesigned.', 's' => $d['process'] );
	}
	if ( $pillars[1]['value'] < 70 ) {
		$twelve[] = array( 't' => 'Begin the ISO 42001 pathway', 'd' => 'An AI management system turns readiness into something you can evidence to partners, regulators and clients.', 's' => $pillars[1]['value'] );
	}
	if ( empty( $twelve ) ) {
		$twelve[] = array( 't' => 'Protect the position', 'd' => 'Keep evidence current, re-assess as the AI estate grows, and bring every new system inside the same controls.', 's' => $composite );
	}

	$roadmap = array(
		'now'    => array_slice( $now, 0, 4 ),
		'six'    => array_slice( $six, 0, 4 ),
		'twelve' => array_slice( $twelve, 0, 3 ),
	);

	// Recommended actions.
	$risk_class   = isset( $state['riskClass'] ) ? (string) $state['riskClass'] : '';
	$risk_process = isset( $state['riskProcess'] ) ? (string) $state['riskProcess'] : '';
	$usage        = isset( $state['usage'] ) ? (string) $state['usage'] : '';
	$pre_adoption = ( 'No current AI usage' === $usage );

	$actions = array();
	foreach ( $blockers as $bname ) {
		foreach ( $schema['blockers'] as $brow ) {
			if ( $brow[0] === $bname ) {
				$actions[] = array(
					't' => 'Unblock — ' . $brow[0],
					'd' => 'You told us this is stalling you. ' . $fix[ $brow[2] ],
				);
				break;
			}
		}
	}
	if ( 'High-Risk AI' === $risk_class ) {
		$actions[] = array( 't' => 'High-risk AI requires full controls', 'd' => 'Risk management, human oversight, logging, accuracy testing and technical documentation, in place before deployment rather than after.' );
	}
	if ( 'No' === $risk_process || 'Not sure' === $risk_process ) {
		$actions[] = array( 't' => 'Establish AI risk management', 'd' => 'Readiness cannot be evidenced without it, and it is a prerequisite for high-risk AI under the EU AI Act.' );
	}
	if ( $d['strategy'] < 70 ) {
		$actions[] = array( 't' => 'Establish ownership and a funded plan', 'd' => 'AI needs a single accountable executive and a plan tied to business objectives. Where ownership is distributed, initiatives stall between functions rather than failing outright.' );
	}
	if ( $d['data'] < 70 ) {
		$actions[] = array( 't' => 'Establish the data foundations', 'd' => 'Only 16% of GCC CEOs say their AI tools can reach the data they need. Access, quality and ownership take the longest to put right, so this work has to start early.' );
	}
	if ( $d['people'] < 70 ) {
		$actions[] = array( 't' => 'Build capability by role', 'd' => 'A frontline user, an analyst and a board member require materially different capability. Undifferentiated training absorbs budget without changing how work is done.' );
	}
	if ( $d['value'] < 70 ) {
		$actions[] = array( 't' => 'Put a value framework in place', 'd' => 'Prioritisation criteria, baselines set before deployment, and reporting the board can act on. Without it the programme cannot be defended at the next budget review.' );
	}
	if ( $d['leadership'] < 70 ) {
		$actions[] = array( 't' => 'Raise board-level understanding', 'd' => 'Board comprehension sets the ceiling on what an organisation can attempt, and determines whether funding covers scaling or stops at AI pilots.' );
	}
	if ( $d['technology'] < 70 ) {
		$actions[] = array( 't' => 'Consolidate onto a shared platform', 'd' => 'Where teams procure separately, cost duplicates and nothing carries forward. A shared foundation is what makes each initiative cheaper than the last.' );
	}
	if ( $d['process'] < 70 ) {
		$actions[] = array( 't' => 'Redesign the work around AI', 'd' => 'Automating a single step while the surrounding process is unchanged delivers no measurable saving. The workflow and the change management have to move together.' );
	}
	if ( $d['trust'] < 70 ) {
		$actions[] = array( 't' => 'Establish the governance basics', 'd' => 'An AI use policy, controlled tooling and a maintained register of AI in use. These are the minimum an auditor, partner or regulator will expect to see.' );
	}
	if ( $pre_adoption ) {
		$actions[] = array( 't' => 'Start narrow and prove it', 'd' => 'A small number of use cases selected on value and effort, delivered end to end and measured. Breadth before depth is the most common way early AI programmes stall.' );
	}
	$actions = array_slice( $actions, 0, 8 );

	// Exposure.
	$exp_val  = array();
	$exp_comp = array();
	if ( $composite < 61 ) {
		$exp_val[] = 'AI spend that never reaches daily use — the most common outcome for organisations at this level of readiness.';
	}
	if ( $d['value'] < 60 ) {
		$exp_val[] = 'No baseline, so no way to prove or defend the return on AI investment at the next budget review.';
	}
	if ( $d['data'] < 60 ) {
		$exp_val[] = 'Projects delayed or abandoned because the data could not be reached in time.';
	}
	if ( $d['people'] < 60 ) {
		$exp_val[] = 'Licences and tools paid for but barely used, because staff were never trained for their actual role.';
	}
	if ( $d['process'] < 60 ) {
		$exp_val[] = 'Automation that saves no time, because the workflow around it was left unchanged.';
	}
	if ( empty( $exp_val ) ) {
		$exp_val[] = 'No major value leakage flagged from your answers.';
	}

	if ( $composite < 61 ) {
		$exp_comp[] = 'Falling behind regional peers — 70% of Middle East CEOs already have a defined AI roadmap.';
	}
	if ( $d['trust'] < 60 ) {
		$exp_comp[] = 'Governance gaps that surface in tender, procurement and partner due-diligence questionnaires.';
	}
	if ( $d['technology'] < 60 ) {
		$exp_comp[] = 'Duplicated spend across teams buying separate tools for the same job.';
	}
	if ( $d['leadership'] < 60 ) {
		$exp_comp[] = 'AI decisions made on vendor claims rather than internal understanding.';
	}
	if ( ! empty( $blockers ) ) {
		$exp_comp[] = 'Named blockers that will stall the next initiative exactly as they stalled the last one.';
	}
	if ( empty( $exp_comp ) ) {
		$exp_comp[] = 'Well positioned against peers — the risk now is losing ground by standing still.';
	}

	// Blocker narrative.
	$nb = count( $blockers );
	if ( 0 === $nb ) {
		$blocker_narrative = 'You did not identify any blockers, which is unusual and worth treating as a finding in itself. Either the organisation is genuinely unobstructed — in which case the roadmap above is a matter of sequencing rather than unblocking — or the constraints have not yet surfaced because AI has not been pushed hard enough to reveal them. Re-run this assessment once delivery is underway; blockers tend to appear at the point of scaling, not at the point of planning.';
	} else {
		$bpillars = array();
		foreach ( $blockers as $bname ) {
			foreach ( $schema['blockers'] as $brow ) {
				if ( $brow[0] === $bname ) {
					foreach ( $schema['pillars'] as $p ) {
						if ( in_array( $brow[2], $p['dims'], true ) ) {
							$bpillars[ $p['name'] ] = true;
						}
					}
				}
			}
		}
		$pnames = array_keys( $bpillars );
		if ( 1 === $nb ) {
			$where = 'It sits under ' . $pnames[0] . '.';
		} elseif ( 1 === count( $pnames ) ) {
			$where = 'All of them sit under a single pillar, ' . $pnames[0] . ', which makes the remedy unusually focused: concentrated effort in one area would clear the whole set.';
		} else {
			$last  = array_pop( $pnames );
			$where = 'They span ' . ( count( $pnames ) + 1 ) . ' of the four pillars — ' . implode( ', ', $pnames ) . ' and ' . $last . ' — which is why they are unlikely to resolve individually. Work in one pillar tends to stall against an unresolved constraint in another.';
		}
		if ( $nb >= 4 ) {
			$weight = 'Four or more blockers at once is not a delivery problem but a structural one. Addressing them in isolation will not work; they need to be sequenced deliberately, which is what the roadmap above sets out.';
		} elseif ( 1 === $nb ) {
			$weight = 'A single named blocker is the best position to be in: the constraint is known, bounded, and can be cleared before it compounds into others.';
		} else {
			$weight = 'At this number the blockers are still tractable, provided they are cleared before further AI investment is committed.';
		}
		$blocker_narrative = 'You identified ' . $nb . ' of the seven constraints below as active in your organisation. ' . $where . ' ' . $weight;
	}

	// Band & Executive summary copy.
	$band  = c1_assessment_band( $composite, $schema['bands'] );
	$plain = array(
		'Leading'       => 'Your organisation scored ' . $composite . ' out of 100 — a strong result. You are set up to adopt AI properly: the plan, the people, the data and the platform are largely in place. The task now is to protect that position, bring every new AI tool inside the same controls, and turn readiness into measured value.',
		'Scaling'       => 'Your organisation scored ' . $composite . ' out of 100. You have real foundations and are past the experiment stage, but a few specific areas are holding you back from scaling cleanly. Close the gaps below and AI moves from working in places to working across the organisation.',
		'Experimenting' => 'Your organisation scored ' . $composite . ' out of 100. AI is being tried, but the conditions for it to succeed are not yet in place — which is exactly how AI pilots stall. The fixes are known, sequenced below, and mostly organisational rather than technical.',
		'Exploring'     => 'Your organisation scored ' . $composite . ' out of 100 — a low result that should be taken seriously. Adopting AI in this state risks spending money on tools that never reach daily use. Start with ownership, data access and a small number of well-chosen use cases, and treat this as a board-level priority.',
	);
	$across = array(
		'Leading'       => 'Across the eight areas of readiness, coverage is strong and consistent. That is a mature position few organisations in the region have reached. Keep the evidence current, re-run this check as your AI estate grows, and the advantage compounds.',
		'Scaling'       => 'Across the eight areas of readiness the core is solid, but the weakest areas are the ones that decide whether an AI pilot becomes a system. They are named below, in the order that lifts your score fastest.',
		'Experimenting' => 'Across the eight areas of readiness the coverage is uneven — some are handled well while others are effectively unmanaged. That inconsistency is itself the risk: it is the unmanaged areas where AI pilots quietly stall, spend goes unmeasured, and the organisation concludes that AI does not work for them.',
		'Exploring'     => 'Across the eight areas of readiness, the basics are largely missing. Ambition is not the constraint here — 82% of Middle East CEOs say their culture enables AI adoption. Execution is. Without ownership, data access and a way to measure value, further AI spend is unlikely to return anything.',
	);

	// Sector & country display text.
	if ( empty( $sectors ) ) {
		$sector_text = 'Not specified';
	} else {
		$mapped = array();
		foreach ( $sectors as $s ) {
			$mapped[] = ( 'Other' === $s && '' !== $other_s ) ? 'Other (' . $other_s . ')' : $s;
		}
		$sector_text = implode( ', ', $mapped );
	}
	$country_text = ( 'Other' === $country ) ? ( '' !== $other_c ? $other_c : 'Other' ) : ( '' !== $country ? $country : 'Not specified' );

	// Build flat list of all 23 scored questions with respondent's answer and score.
	$dim_labels = array();
	foreach ( $schema['dims'] as $dim ) {
		$dim_labels[ $dim['key'] ] = $dim['label'];
	}
	$all_questions = array();
	$q_num         = 1;
	foreach ( $schema['practice'] as $q ) {
		$all_questions[] = array(
			'num'     => $q_num++,
			'id'      => $q['id'],
			'section' => 'Part 1: Your practice',
			'topic'   => isset( $dim_labels[ $q['dim'] ] ) ? $dim_labels[ $q['dim'] ] : ucfirst( $q['dim'] ),
			'text'    => $q['text'],
			'answer'  => $ans_label_fn( $q ),
			'score'   => $val_fn( $q ),
			'options' => implode( ' | ', $q['opts'] ),
			'notes'   => $q['matters'],
		);
	}
	foreach ( $schema['know'] as $q ) {
		$all_questions[] = array(
			'num'     => $q_num++,
			'id'      => $q['id'],
			'section' => 'Part 2: What good looks like',
			'topic'   => 'Knowledge check',
			'text'    => $q['text'],
			'answer'  => $ans_label_fn( $q ),
			'score'   => $val_fn( $q ),
			'options' => implode( ' | ', $q['opts'] ),
			'notes'   => $q['because'] . ' (' . $q['src'] . ')',
		);
	}
	foreach ( $schema['why'] as $q ) {
		$all_questions[] = array(
			'num'     => $q_num++,
			'id'      => $q['id'],
			'section' => 'Part 3: Why it matters',
			'topic'   => 'Readiness mindset',
			'text'    => $q['text'],
			'answer'  => $ans_label_fn( $q ),
			'score'   => $val_fn( $q ),
			'options' => implode( ' | ', $q['opts'] ),
			'notes'   => $q['lesson'],
		);
	}

	return array(
		'schema'            => $schema,
		'd'                 => $d,
		'composite'         => $composite,
		'know'              => $know,
		'why'               => $why,
		'band'              => $band,
		'pillars'           => $pillars,
		'weak_pillar'       => $weak_pillar,
		'gaps'              => $gaps,
		'blockers'          => $blockers,
		'roadmap'           => $roadmap,
		'actions'           => $actions,
		'exposure'          => array( 'value' => $exp_val, 'comp' => $exp_comp ),
		'blocker_narrative' => $blocker_narrative,
		'plain'             => isset( $plain[ $band['label'] ] ) ? $plain[ $band['label'] ] : $plain['Exploring'],
		'across'            => isset( $across[ $band['label'] ] ) ? $across[ $band['label'] ] : $across['Exploring'],
		'sector_text'       => $sector_text,
		'country_text'      => $country_text,
		'pre_adoption'      => $pre_adoption,
		'all_questions'     => $all_questions,
	);
}

/**
 * Verdict text for each part of the assessment.
 *
 * @param string $section Section title.
 * @param int    $v       Score 0-100.
 * @return string
 */
function c1_assessment_verdict( $section, $v ) {
	$i = $v >= 70 ? 0 : ( $v >= 40 ? 1 : 2 );
	$m = array(
		'Section 1: Your practice'        => array(
			'your day-to-day practice is largely sound, and the work now is to keep it consistent and evidenced as your AI estate grows.',
			'the foundations exist but coverage is uneven, and it is the uneven areas where initiatives quietly stall.',
			'the operating conditions AI depends on are not yet in place, which is where remediation needs to start.',
		),
		'Section 2: What good looks like' => array(
			'you are well informed about what strong adoption actually requires here, which is what allows you to challenge vendor claims and set realistic expectations internally.',
			'you know part of the picture, and the gaps are usually where investment gets misdirected.',
			'the regional evidence is largely unknown to you today, and decisions taken without it typically cost more to unwind than they would have cost to get right.',
		),
		'Section 3: Why it matters'       => array(
			'leadership clearly understands why AI behaves differently from ordinary software, which is the mindset that gets governance and capability funded early.',
			'the awareness is there but uneven, and the underestimated risks are usually where the first surprise comes from.',
			'the stakes are not yet fully recognised, which is the most exposed position to be in: the risk exists before anyone is watching for it.',
		),
	);
	return 'You scored ' . $v . ' here — ' . ( isset( $m[ $section ][ $i ] ) ? $m[ $section ][ $i ] : '' );
}

