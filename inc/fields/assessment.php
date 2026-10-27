<?php
/**
 * AI Readiness Assessment page fields.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

return array(
	'assessment' => array(
		'title'          => __( 'AI Readiness Assessment settings', 'cypher-one' ),
		'location'       => c1_loc_template( 'page-templates/assessment.php' ),
		'hide_on_screen' => array( 'the_content' ),
		'fields'         => array(
			c1_tab( __( 'App', 'cypher-one' ) ),
			c1_fld( 'as_title', 'text', __( 'Assessment name', 'cypher-one' ), __( 'Cypher-One AI Readiness Assessment', 'cypher-one' ) ),
			c1_fld( 'as_tagline', 'text', __( 'Tagline', 'cypher-one' ), __( 'Ambition is not the constraint. Execution is.', 'cypher-one' ) ),
			c1_fld( 'as_version', 'text', __( 'Rubric version', 'cypher-one' ), __( 'Version 1', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'as_aligned', 'text', __( 'Aligned as of', 'cypher-one' ), __( 'August 2026', 'cypher-one' ), array( 'wrapper' => array( 'width' => 50 ) ) ),
			c1_fld( 'as_logo_sub', 'text', __( 'Header label', 'cypher-one' ), __( 'AI Readiness', 'cypher-one' ) ),
			c1_fld( 'as_footer_left', 'text', __( 'Footer text (left)', 'cypher-one' ), __( 'Cypher-One AI Readiness Assessment · Version 1 · August 2026', 'cypher-one' ) ),
			c1_fld( 'as_footer_right', 'text', __( 'Footer text (right)', 'cypher-one' ), __( 'Cypher-One — Enable · Empower · Excel', 'cypher-one' ) ),
			c1_fld( 'as_back_label', 'text', __( '“Back to website” button', 'cypher-one' ), __( 'Back to website', 'cypher-one' ) ),
			c1_fld( 'as_lang_label', 'text', __( 'Language switch label', 'cypher-one' ), 'العربية' ),
			c1_fld( 'as_note', 'message', __( 'Questions and scoring', 'cypher-one' ), '', array( 'message' => __( 'The assessment’s questions, scoring rubric and its English/Arabic copy live in assets/js/assessment.js. Results and report requests are saved under Assessments in the dashboard (see Cypher-One → Assessment).', 'cypher-one' ) ) ),
		),
	),
);
