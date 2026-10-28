<?php
/**
 * AI Readiness Assessment Excel (.xlsx) Report Generator.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build a valid ZIP archive binary in memory from an associative array of filename => content.
 *
 * @param array $entries Map of internal path => raw string content.
 * @return string Binary ZIP data.
 */
function c1_build_zip_bytes( $entries ) {
	$local_parts = array();
	$central_dir = array();
	$offset      = 0;
	$count       = 0;

	foreach ( $entries as $name => $data ) {
		$name     = str_replace( '\\', '/', $name );
		$unc_len  = strlen( $data );
		$crc      = crc32( $data );
		$comp     = gzdeflate( $data, 6 );
		$comp_len = strlen( $comp );
		$namelen  = strlen( $name );

		// Local file header (signature 0x04034b50).
		$local_header = pack(
			'VvvvvvVVVvv',
			0x04034b50,
			20,        // Version needed to extract (2.0).
			0,         // General purpose bit flag.
			8,         // Compression method (8 = deflate).
			0,         // Last mod file time.
			0,         // Last mod file date.
			$crc,
			$comp_len,
			$unc_len,
			$namelen,
			0          // Extra field length.
		) . $name;

		$local_parts[] = $local_header . $comp;

		// Central directory file header (signature 0x02014b50).
		$central_dir[] = pack(
			'VvvvvvvVVVvvvvvVV',
			0x02014b50,
			20,        // Version made by.
			20,        // Version needed to extract.
			0,         // General purpose bit flag.
			8,         // Compression method.
			0,         // Last mod time.
			0,         // Last mod date.
			$crc,
			$comp_len,
			$unc_len,
			$namelen,
			0,         // Extra field length.
			0,         // File comment length.
			0,         // Disk number start.
			0,         // Internal file attributes.
			32,        // External file attributes.
			$offset
		) . $name;

		$offset += strlen( $local_header ) + $comp_len;
		++$count;
	}

	$central_bytes = implode( '', $central_dir );
	$eocd          = pack(
		'VvvvvVVv',
		0x06054b50,
		0,
		0,
		$count,
		$count,
		strlen( $central_bytes ),
		$offset,
		0
	);

	return implode( '', $local_parts ) . $central_bytes . $eocd;
}

/**
 * Convert 0-based column index to Excel column letters (A, B, ..., Z, AA...).
 *
 * @param int $col_idx 0-based index.
 * @return string
 */
function c1_xlsx_col_letter( $col_idx ) {
	$letters = '';
	$n       = $col_idx + 1;
	while ( $n > 0 ) {
		$rem      = ( $n - 1 ) % 26;
		$letters  = chr( 65 + $rem ) . $letters;
		$n        = intdiv( $n - 1, 26 );
	}
	return $letters;
}

/**
 * Escape string for XML text content, stripping invalid XML control characters.
 *
 * @param mixed $val Input value.
 * @return string
 */
function c1_xlsx_xml_esc( $val ) {
	$str = (string) $val;
	$str = preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $str );
	return htmlspecialchars( $str, ENT_XML1 | ENT_QUOTES, 'UTF-8' );
}

/**
 * Build an OpenXML worksheet XML string from rows and column widths.
 *
 * Style indices:
 *   0 = Default cell (wrapped, thin border)
 *   1 = Title banner (Dark charcoal #1F1D1C fill, White 13pt Bold)
 *   2 = Section header (Red #B31B0C fill, White 11pt Bold)
 *   3 = Table column header (Dark charcoal #2D2B2A fill, White 10.5pt Bold)
 *   4 = Bold label cell (Soft grey #F2F2F2 fill, Bold 10.5pt)
 *   5 = Centered score/status cell (Bold 10.5pt, centered)
 *
 * @param array $rows   Array of row definitions: array( 'style' => int, 'cells' => array( val, ... ), 'cell_styles' => array( idx => style ) ).
 * @param array $widths Array of column widths (1-based index => width).
 * @return string XML content.
 */
function c1_xlsx_build_sheet_xml( $rows, $widths ) {
	$xml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
	$xml .= '<cols>';
	foreach ( $widths as $col_num => $w ) {
		$xml .= '<col min="' . (int) $col_num . '" max="' . (int) $col_num . '" width="' . (float) $w . '" customWidth="1"/>';
	}
	$xml .= '</cols>';
	$xml .= '<sheetData>';

	$r_num = 1;
	foreach ( $rows as $row ) {
		$default_style = isset( $row['style'] ) ? (int) $row['style'] : 0;
		$cell_styles   = isset( $row['cell_styles'] ) ? $row['cell_styles'] : array();
		$cells         = isset( $row['cells'] ) ? $row['cells'] : array();
		$height_attr   = isset( $row['height'] ) ? ' ht="' . (int) $row['height'] . '" customHeight="1"' : '';

		$xml .= '<row r="' . $r_num . '"' . $height_attr . '>';
		foreach ( $cells as $c_idx => $cell_val ) {
			$ref   = c1_xlsx_col_letter( $c_idx ) . $r_num;
			$style = isset( $cell_styles[ $c_idx ] ) ? (int) $cell_styles[ $c_idx ] : $default_style;
			if ( is_int( $cell_val ) || is_float( $cell_val ) ) {
				$xml .= '<c r="' . $ref . '" s="' . $style . '" t="n"><v>' . $cell_val . '</v></c>';
			} else {
				$xml .= '<c r="' . $ref . '" s="' . $style . '" t="inlineStr"><is><t xml:space="preserve">' . c1_xlsx_xml_esc( $cell_val ) . '</t></is></c>';
			}
		}
		$xml .= '</row>';
		++$r_num;
	}

	$xml .= '</sheetData>';
	$xml .= '</worksheet>';
	return $xml;
}

/**
 * Generate the Excel (.xlsx) workbook with all submitted answers against each question.
 *
 * @param array  $state    Decoded client state S.
 * @param array  $contact  Sanitised contact/request fields.
 * @param array  $computed Output of c1_assessment_compute().
 * @param string $filepath Destination .xlsx file path.
 * @return bool True on success.
 */
function c1_generate_assessment_xlsx( $state, $contact, $computed, $filepath ) {
	$schema   = $computed['schema'];
	$submitted = wp_date( 'j F Y, H:i T' );
	$aid       = isset( $contact['assessment_id'] ) ? $contact['assessment_id'] : '';
	$ai_types  = isset( $state['aiTypes'] ) && is_array( $state['aiTypes'] ) && ! empty( $state['aiTypes'] ) ? implode( ', ', $state['aiTypes'] ) : 'None selected';
	$consent   = ! empty( $state['consent'] ) ? 'Yes — agreed to readiness check terms' : 'No';

	// Sheet 1: Submitted Answers (All questions + respondent details).
	$s1_rows = array();

	// Title Banner.
	$s1_rows[] = array(
		'style'  => 1,
		'height' => 28,
		'cells'  => array(
			'CYPHER-ONE AI READINESS ASSESSMENT — SUBMITTED ANSWERS & RESULTS',
			'',
			'',
			'',
			'',
			'',
			'',
		),
	);

	// Section A: Respondent & Request Details.
	$s1_rows[] = array(
		'style'  => 2,
		'height' => 22,
		'cells'  => array( 'SECTION A', 'Respondent & Follow-up Request Details', '', '', '', '', '' ),
	);

	$meta_pairs = array(
		array( 'Submitted Date & Time', $submitted, 'Assessment ID', $aid ),
		array( 'Respondent Name', ! empty( $contact['name'] ) ? $contact['name'] : 'Not given', 'Work Email', ! empty( $contact['email'] ) ? $contact['email'] : 'Not given' ),
		array( 'Organisation', ! empty( $contact['organisation'] ) ? $contact['organisation'] : 'Not given', 'Role (Form)', ! empty( $contact['role'] ) ? $contact['role'] : 'Not given' ),
		array( 'Sector (Form)', ! empty( $contact['sector'] ) ? $contact['sector'] : $computed['sector_text'], 'Overall Readiness Score', $computed['composite'] . ' / 100 (' . $computed['band']['label'] . ')' ),
		array( 'What would you like from us?', ! empty( $contact['wants'] ) ? $contact['wants'] : 'Not chosen', 'Weakest Pillar', $computed['weak_pillar']['name'] . ' (' . $computed['weak_pillar']['value'] . '/100)' ),
		array( 'In your own words (Message)', ! empty( $contact['message'] ) ? $contact['message'] : '—', 'Blockers Named', ! empty( $computed['blockers'] ) ? implode( '; ', $computed['blockers'] ) : 'None' ),
	);

	foreach ( $meta_pairs as $mp ) {
		$s1_rows[] = array(
			'style'       => 0,
			'cell_styles' => array( 0 => 4, 1 => 0, 2 => 4, 3 => 0 ),
			'cells'       => array( $mp[0], $mp[1], $mp[2], $mp[3], '', '', '' ),
		);
	}

	$s1_rows[] = array( 'style' => 0, 'cells' => array( '', '', '', '', '', '', '' ) );

	// Section B: All Questions & Submitted Answers.
	$s1_rows[] = array(
		'style'  => 2,
		'height' => 22,
		'cells'  => array( 'SECTION B', 'All Submitted Answers Against Each Question', '', '', '', '', '' ),
	);

	$s1_rows[] = array(
		'style'  => 3,
		'height' => 24,
		'cells'  => array(
			'Q# / ID',
			'Part / Section',
			'Dimension / Area',
			'Question',
			'Submitted Answer',
			'Score (/100)',
			'Options / Context',
		),
	);

	// Pre-Assessment & Organisation Profile Questions (P0.1 - P0.9).
	$profile_questions = array(
		array(
			'P1 (sectors)',
			'Pre-Assessment: Start Card',
			'Organisation Profile',
			'Which sectors do you operate in?',
			$computed['sector_text'],
			'—',
			'Multi-select across 16 sectors',
		),
		array(
			'P2 (consent)',
			'Pre-Assessment: Start Card',
			'Consent',
			'I understand this is a readiness check, not legal advice or certification, and agree to anonymised benchmark storage.',
			$consent,
			'—',
			'Required to begin',
		),
		array(
			'P3 (country)',
			'Pre-Assessment: Before we start',
			'Organisation Profile',
			'Where is your organisation primarily based?',
			$computed['country_text'],
			'—',
			'Qatar | Saudi Arabia | United Arab Emirates | Kuwait | Bahrain | Oman | Other',
		),
		array(
			'P4 (size)',
			'Pre-Assessment: Before we start',
			'Organisation Profile',
			'How many people work in your organisation?',
			! empty( $state['size'] ) ? (string) $state['size'] : 'Not specified',
			'—',
			'1–50 | 51–250 | 251–1,000 | 1,001–5,000 | More than 5,000',
		),
		array(
			'P5 (role)',
			'Pre-Assessment: Before we start',
			'Organisation Profile',
			'Which best describes your role?',
			! empty( $state['role'] ) ? (string) $state['role'] : 'Not specified',
			'—',
			'Board / C-suite | Risk & Compliance | Legal | IT / Data | Other',
		),
		array(
			'P6 (usage)',
			'Pre-Assessment: Before we start',
			'AI Profile',
			'Are you currently using AI systems?',
			! empty( $state['usage'] ) ? (string) $state['usage'] : 'Not specified',
			'—',
			'Yes, we\'re actively using AI | Planning to implement soon | No current AI usage',
		),
		array(
			'P7 (aiTypes)',
			'Pre-Assessment: Before we start',
			'AI Profile',
			'What types of AI do you use?',
			$ai_types,
			'—',
			'Multi-select across 15 AI system types',
		),
		array(
			'P8 (riskClass)',
			'Pre-Assessment: Before we start',
			'AI Risk & Governance',
			'How would you classify your AI\'s risk?',
			! empty( $state['riskClass'] ) ? (string) $state['riskClass'] : 'Not specified',
			'—',
			'High-Risk AI | Limited-Risk AI | Minimal-Risk AI | Not sure',
		),
		array(
			'P9 (riskProcess)',
			'Pre-Assessment: Before we start',
			'AI Strategy',
			'Do you have a well-developed AI strategy?',
			! empty( $state['riskProcess'] ) ? (string) $state['riskProcess'] : 'Not specified',
			'—',
			'Yes | We\'re currently building one | No | Not sure',
		),
	);

	foreach ( $profile_questions as $pq ) {
		$s1_rows[] = array(
			'style'       => 0,
			'cell_styles' => array( 0 => 4, 5 => 5 ),
			'cells'       => $pq,
		);
	}

	// Main Assessment Questions 1 to 23 (Practice p1-p16, Knowledge k1-k4, Why r1-r3).
	foreach ( $computed['all_questions'] as $q ) {
		$s1_rows[] = array(
			'style'       => 0,
			'cell_styles' => array( 0 => 4, 5 => 5 ),
			'cells'       => array(
				'Q' . $q['num'] . ' (' . $q['id'] . ')',
				$q['section'],
				$q['topic'],
				$q['text'],
				$q['answer'],
				(int) $q['score'],
				'Options: ' . $q['options'],
			),
		);
	}

	// Question 24: Blockers Gate (Summary + each of the 7 blocker options).
	$s1_rows[] = array(
		'style'       => 0,
		'cell_styles' => array( 0 => 4, 5 => 5 ),
		'cells'       => array(
			'Q24 (gate)',
			'Step 24: Blockers Gate',
			'What\'s stalling you?',
			'What\'s stalling your AI? (Tick anything that applies — or none)',
			! empty( $computed['blockers'] ) ? implode( '; ', $computed['blockers'] ) : 'None selected',
			'—',
			count( $computed['blockers'] ) . ' of 7 constraints selected',
		),
	);

	foreach ( $schema['blockers'] as $b_idx => $brow ) {
		$is_selected = in_array( $brow[0], $computed['blockers'], true );
		$s1_rows[]   = array(
			'style'       => 0,
			'cell_styles' => array( 0 => 4, 5 => 5 ),
			'cells'       => array(
				'Q24.' . ( $b_idx + 1 ),
				'Step 24: Blockers Gate',
				ucfirst( $brow[2] ),
				'Blocker option: ' . $brow[0] . ' — ' . $brow[1],
				$is_selected ? 'Selected (Blocking)' : 'Not selected',
				'—',
				isset( $schema['fix'][ $brow[2] ] ) ? 'Remediation: ' . $schema['fix'][ $brow[2] ] : '',
			),
		);
	}

	// Sheet 2: Scores & Roadmap Summary.
	$s2_rows   = array();
	$s2_rows[] = array(
		'style'  => 1,
		'height' => 28,
		'cells'  => array( 'CYPHER-ONE AI READINESS — SCORES, PILLARS & ROADMAP', '', '', '', '', '' ),
	);

	$s2_rows[] = array(
		'style'  => 2,
		'height' => 22,
		'cells'  => array( 'OVERALL SUMMARY', '', '', '', '', '' ),
	);
	$s2_rows[] = array(
		'style'  => 3,
		'height' => 22,
		'cells'  => array( 'Metric', 'Score (/100)', 'Band / Classification', 'Notes', '', '' ),
	);
	$s2_rows[] = array(
		'cell_styles' => array( 0 => 4, 1 => 5 ),
		'cells'       => array( 'Overall AI Readiness (Composite)', $computed['composite'], $computed['band']['label'], $computed['plain'], '', '' ),
	);
	$s2_rows[] = array(
		'cell_styles' => array( 0 => 4, 1 => 5 ),
		'cells'       => array( 'Section 1: Your practice', $computed['composite'], $computed['band']['label'], c1_assessment_verdict( 'Section 1: Your practice', $computed['composite'] ), '', '' ),
	);
	$know_band = c1_assessment_band( $computed['know'], $schema['bands'] );
	$s2_rows[] = array(
		'cell_styles' => array( 0 => 4, 1 => 5 ),
		'cells'       => array( 'Section 2: What good looks like (Knowledge)', $computed['know'], $know_band['label'], c1_assessment_verdict( 'Section 2: What good looks like', $computed['know'] ), '', '' ),
	);
	$why_band  = c1_assessment_band( $computed['why'], $schema['bands'] );
	$s2_rows[] = array(
		'cell_styles' => array( 0 => 4, 1 => 5 ),
		'cells'       => array( 'Section 3: Why it matters (Mindset)', $computed['why'], $why_band['label'], c1_assessment_verdict( 'Section 3: Why it matters', $computed['why'] ), '', '' ),
	);

	$s2_rows[] = array( 'cells' => array( '', '', '', '', '', '' ) );
	$s2_rows[] = array(
		'style'  => 2,
		'height' => 22,
		'cells'  => array( 'THE FOUR PILLARS', '', '', '', '', '' ),
	);
	$s2_rows[] = array(
		'style'  => 3,
		'height' => 22,
		'cells'  => array( 'Pillar', 'Name', 'Score (/100)', 'Band', 'Areas Included', 'Recommended Starting Point' ),
	);
	foreach ( $computed['pillars'] as $p ) {
		$is_weak   = ( $p['n'] === $computed['weak_pillar']['n'] );
		$s2_rows[] = array(
			'cell_styles' => array( 0 => 4, 2 => 5 ),
			'cells'       => array(
				'Pillar ' . $p['n'] . ( $is_weak ? ' (Weakest)' : '' ),
				$p['name'],
				$p['value'],
				$p['band']['label'],
				implode( ', ', array_map( 'ucfirst', $p['dims'] ) ),
				$p['cta'],
			),
		);
	}

	$s2_rows[] = array( 'cells' => array( '', '', '', '', '', '' ) );
	$s2_rows[] = array(
		'style'  => 2,
		'height' => 22,
		'cells'  => array( 'SCORES BY AREA (WEAKEST FIRST)', '', '', '', '', '' ),
	);
	$s2_rows[] = array(
		'style'  => 3,
		'height' => 22,
		'cells'  => array( 'Area / Dimension', 'Your Score (/100)', 'Sector Median', 'Band', 'Description', 'Recommended Remediation' ),
	);
	foreach ( $computed['gaps'] as $dim ) {
		$sc        = $computed['d'][ $dim['key'] ];
		$dband     = c1_assessment_band( $sc, $schema['bands'] );
		$s2_rows[] = array(
			'cell_styles' => array( 0 => 4, 1 => 5, 2 => 5 ),
			'cells'       => array(
				$dim['label'],
				$sc,
				$dim['bench'],
				$dband['label'],
				$dim['desc'],
				$schema['fix'][ $dim['key'] ],
			),
		);
	}

	$s2_rows[] = array( 'cells' => array( '', '', '', '', '', '' ) );
	$s2_rows[] = array(
		'style'  => 2,
		'height' => 22,
		'cells'  => array( 'SEQUENCED ROADMAP (90 DAYS / 6 MONTHS / 12 MONTHS)', '', '', '', '', '' ),
	);
	$s2_rows[] = array(
		'style'  => 3,
		'height' => 22,
		'cells'  => array( 'Horizon', 'Phase', 'Action', 'Area Score', 'Details', '' ),
	);
	$horizons = array(
		array( 'Next 90 days', 'Stabilise', $computed['roadmap']['now'] ),
		array( 'Next 6 months', 'Build', $computed['roadmap']['six'] ),
		array( 'Next 12 months', 'Scale', $computed['roadmap']['twelve'] ),
	);
	foreach ( $horizons as $h ) {
		foreach ( $h[2] as $item ) {
			$s2_rows[] = array(
				'cell_styles' => array( 0 => 4, 3 => 5 ),
				'cells'       => array( $h[0], $h[1], $item['t'], $item['s'], $item['d'], '' ),
			);
		}
	}

	$sheet1_xml = c1_xlsx_build_sheet_xml(
		$s1_rows,
		array( 1 => 16, 2 => 28, 3 => 22, 4 => 54, 5 => 42, 6 => 14, 7 => 56 )
	);
	$sheet2_xml = c1_xlsx_build_sheet_xml(
		$s2_rows,
		array( 1 => 26, 2 => 30, 3 => 18, 4 => 18, 5 => 48, 6 => 54 )
	);

	$content_types = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
		. '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
		. '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
		. '<Default Extension="xml" ContentType="application/xml"/>'
		. '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
		. '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
		. '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
		. '<Override PartName="/xl/worksheets/sheet2.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
		. '</Types>';

	$root_rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
		. '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
		. '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
		. '</Relationships>';

	$workbook_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
		. '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
		. '<sheets>'
		. '<sheet name="Submitted Answers" sheetId="1" r:id="rId1"/>'
		. '<sheet name="Scores and Roadmap" sheetId="2" r:id="rId2"/>'
		. '</sheets>'
		. '</workbook>';

	$workbook_rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
		. '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
		. '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
		. '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet2.xml"/>'
		. '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
		. '</Relationships>';

	$styles_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
		. '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
		. '<fonts count="4">'
		. '<font><sz val="10.5"/><color rgb="FF1F1D1C"/><name val="Calibri"/></font>'
		. '<font><b/><sz val="12.5"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
		. '<font><b/><sz val="10.5"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
		. '<font><b/><sz val="10.5"/><color rgb="FF1F1D1C"/><name val="Calibri"/></font>'
		. '</fonts>'
		. '<fills count="6">'
		. '<fill><patternFill patternType="none"/></fill>'
		. '<fill><patternFill patternType="gray125"/></fill>'
		. '<fill><patternFill patternType="solid"><fgColor rgb="FF1F1D1C"/><bgColor indexed="64"/></patternFill></fill>'
		. '<fill><patternFill patternType="solid"><fgColor rgb="FFB31B0C"/><bgColor indexed="64"/></patternFill></fill>'
		. '<fill><patternFill patternType="solid"><fgColor rgb="FF2D2B2A"/><bgColor indexed="64"/></patternFill></fill>'
		. '<fill><patternFill patternType="solid"><fgColor rgb="FFF2F2F2"/><bgColor indexed="64"/></patternFill></fill>'
		. '</fills>'
		. '<borders count="2">'
		. '<border><left/><right/><top/><bottom/><diagonal/></border>'
		. '<border>'
		. '<left style="thin"><color rgb="FFD2D0CE"/></left>'
		. '<right style="thin"><color rgb="FFD2D0CE"/></right>'
		. '<top style="thin"><color rgb="FFD2D0CE"/></top>'
		. '<bottom style="thin"><color rgb="FFD2D0CE"/></bottom>'
		. '<diagonal/>'
		. '</border>'
		. '</borders>'
		. '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
		. '<cellXfs count="6">'
		. '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
		. '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf>'
		. '<xf numFmtId="0" fontId="2" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf>'
		. '<xf numFmtId="0" fontId="2" fillId="4" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf>'
		. '<xf numFmtId="0" fontId="3" fillId="5" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
		. '<xf numFmtId="0" fontId="3" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="top" wrapText="1"/></xf>'
		. '</cellXfs>'
		. '</styleSheet>';

	$zip_bytes = c1_build_zip_bytes(
		array(
			'[Content_Types].xml'        => $content_types,
			'_rels/.rels'                => $root_rels,
			'xl/workbook.xml'            => $workbook_xml,
			'xl/_rels/workbook.xml.rels' => $workbook_rels,
			'xl/styles.xml'              => $styles_xml,
			'xl/worksheets/sheet1.xml'   => $sheet1_xml,
			'xl/worksheets/sheet2.xml'   => $sheet2_xml,
		)
	);

	return false !== file_put_contents( $filepath, $zip_bytes ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
}

