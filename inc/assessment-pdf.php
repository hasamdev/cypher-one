<?php
/**
 * AI Readiness Assessment PDF Report Generator.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Lightweight, self-contained A4 PDF 1.4 document builder with vector drawing,
 * brand colours, word wrapping, and automatic multi-page pagination.
 */
class C1_PDF_Report_Builder {
	/**
	 * Page width in points (A4 portrait).
	 *
	 * @var float
	 */
	public $pw = 595.28;

	/**
	 * Page height in points (A4 portrait).
	 *
	 * @var float
	 */
	public $ph = 841.89;

	/**
	 * Horizontal margin in points.
	 *
	 * @var float
	 */
	public $margin_x = 40.0;

	/**
	 * Top margin in points.
	 *
	 * @var float
	 */
	public $margin_top = 48.0;

	/**
	 * Bottom margin in points.
	 *
	 * @var float
	 */
	public $margin_bottom = 44.0;

	/**
	 * Current Y cursor from top of page (0 = top edge, increases downward).
	 *
	 * @var float
	 */
	public $y = 48.0;

	/**
	 * Array of content stream strings, one per page.
	 *
	 * @var array
	 */
	public $pages = array();

	/**
	 * Current page index (0-based).
	 *
	 * @var int
	 */
	public $page_idx = -1;

	/**
	 * Running header metadata.
	 *
	 * @var string
	 */
	public $header_meta = '';

	/**
	 * Running footer date string.
	 *
	 * @var string
	 */
	public $footer_date = '';

	/**
	 * Constructor.
	 *
	 * @param string $header_meta Meta text shown in running header on pages 2+.
	 * @param string $footer_date Date text shown in running footer.
	 */
	public function __construct( $header_meta = '', $footer_date = '' ) {
		$this->header_meta = $header_meta;
		$this->footer_date = $footer_date;
		$this->add_page( true );
	}

	/**
	 * Usable content width.
	 *
	 * @return float
	 */
	public function content_width() {
		return $this->pw - ( 2 * $this->margin_x );
	}

	/**
	 * Start a new page.
	 *
	 * @param bool $is_first Whether this is the first page.
	 */
	public function add_page( $is_first = false ) {
		++$this->page_idx;
		$this->pages[ $this->page_idx ] = '';
		if ( $is_first ) {
			$this->y = 0.0;
		} else {
			$this->y = $this->margin_top;
			// Running header on page 2+.
			$this->draw_text( $this->margin_x, 28.0, 'cypher•one  AI Readiness Report', 'F2', 8.5, '#1F1D1C' );
			if ( $this->header_meta ) {
				$this->draw_text_right( $this->pw - $this->margin_x, 28.0, $this->header_meta, 'F1', 8.0, '#6B6866' );
			}
			$this->draw_line( $this->margin_x, 34.0, $this->pw - $this->margin_x, 34.0, '#D2D0CE', 0.6 );
		}
	}

	/**
	 * Ensure at least $needed_h points remain on the current page; otherwise add a page.
	 *
	 * @param float $needed_h Height needed in points.
	 */
	public function ensure_space( $needed_h ) {
		if ( ( $this->y + $needed_h ) > ( $this->ph - $this->margin_bottom ) ) {
			$this->add_page( false );
		}
	}

	/**
	 * Convert hex colour (#RRGGBB) to normalized RGB floats [r, g, b].
	 *
	 * @param string $hex Hex colour string.
	 * @return array
	 */
	public function hex_to_rgb( $hex ) {
		$hex = ltrim( trim( $hex ), '#' );
		if ( 3 === strlen( $hex ) ) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}
		if ( 6 !== strlen( $hex ) ) {
			return array( 0.12, 0.11, 0.11 );
		}
		return array(
			round( hexdec( substr( $hex, 0, 2 ) ) / 255, 3 ),
			round( hexdec( substr( $hex, 2, 2 ) ) / 255, 3 ),
			round( hexdec( substr( $hex, 4, 2 ) ) / 255, 3 ),
		);
	}

	/**
	 * Convert UTF-8 string to WinAnsi (CP1252) and escape PDF string literals.
	 *
	 * @param string $text UTF-8 text.
	 * @return string
	 */
	public function pdf_str( $text ) {
		$replacements = array(
			"\xe2\x80\x94" => "\x97", // em-dash —
			"\xe2\x80\x93" => "\x96", // en-dash –
			"\xe2\x80\x98" => "\x91", // ‘
			"\xe2\x80\x99" => "\x92", // ’
			"\xe2\x80\x9c" => "\x93", // “
			"\xe2\x80\x9d" => "\x94", // ”
			"\xe2\x80\xa2" => "\x95", // bullet •
			"\xe2\x80\xa6" => "\x85", // …
			"\xc2\xb7"     => "\xb7", // middle dot ·
			"\xe2\x86\x92" => '->',   // →
			"\xe2\x9a\xa0" => '[!]',  // ⚠
			"\xe2\x9c\x93" => '[x]',  // ✓
		);
		$s = strtr( (string) $text, $replacements );
		if ( function_exists( 'iconv' ) ) {
			$conv = @iconv( 'UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $s ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			if ( false !== $conv ) {
				$s = $conv;
			}
		}
		$s = str_replace( array( '\\', '(', ')', "\r", "\n" ), array( '\\\\', '\\(', '\\)', '', ' ' ), $s );
		return $s;
	}

	/**
	 * Estimate width of a string in points for Helvetica/Courier.
	 *
	 * @param string $text      UTF-8 string.
	 * @param float  $font_size Font size in points.
	 * @param string $font      Font key (F1=Regular, F2=Bold, F3=Oblique, F4=Mono).
	 * @return float
	 */
	public function text_width( $text, $font_size, $font = 'F1' ) {
		$len = function_exists( 'mb_strlen' ) ? mb_strlen( (string) $text, 'UTF-8' ) : strlen( (string) $text );
		$avg = ( 'F4' === $font ) ? 0.60 : ( 'F2' === $font ? 0.54 : 0.51 );
		return $len * $font_size * $avg;
	}

	/**
	 * Word-wrap text to fit within $max_width points.
	 *
	 * @param string $text      Text to wrap.
	 * @param float  $max_width Maximum line width in points.
	 * @param float  $font_size Font size in points.
	 * @param string $font      Font key.
	 * @return array Array of lines.
	 */
	public function wrap_text( $text, $max_width, $font_size, $font = 'F1' ) {
		$text = trim( preg_replace( '/\s+/', ' ', (string) $text ) );
		if ( '' === $text ) {
			return array();
		}
		$words = explode( ' ', $text );
		$lines = array();
		$cur   = '';
		foreach ( $words as $word ) {
			$test = ( '' === $cur ) ? $word : $cur . ' ' . $word;
			if ( '' !== $cur && $this->text_width( $test, $font_size, $font ) > $max_width ) {
				$lines[] = $cur;
				$cur     = $word;
			} else {
				$cur = $test;
			}
		}
		if ( '' !== $cur ) {
			$lines[] = $cur;
		}
		return $lines;
	}

	/**
	 * Append raw command to current page stream.
	 *
	 * @param string $cmd PDF operator command.
	 */
	public function out( $cmd ) {
		$this->pages[ $this->page_idx ] .= $cmd . "\n";
	}

	/**
	 * Draw a filled and/or stroked rectangle using top-left coordinates.
	 *
	 * @param float       $x           Left X.
	 * @param float       $top_y       Top Y.
	 * @param float       $w           Width.
	 * @param float       $h           Height.
	 * @param string|null $fill_hex    Fill hex colour or null.
	 * @param string|null $stroke_hex  Stroke hex colour or null.
	 * @param float       $line_width  Stroke width.
	 */
	public function draw_rect( $x, $top_y, $w, $h, $fill_hex = null, $stroke_hex = null, $line_width = 0.75 ) {
		$pdf_y = $this->ph - $top_y - $h;
		$this->out( 'q' );
		if ( $fill_hex ) {
			list( $r, $g, $b ) = $this->hex_to_rgb( $fill_hex );
			$this->out( sprintf( '%.3f %.3f %.3f rg', $r, $g, $b ) );
		}
		if ( $stroke_hex ) {
			list( $sr, $sg, $sb ) = $this->hex_to_rgb( $stroke_hex );
			$this->out( sprintf( '%.3f %.3f %.3f RG %.2f w', $sr, $sg, $sb, $line_width ) );
		}
		$op = ( $fill_hex && $stroke_hex ) ? 'B' : ( $fill_hex ? 'f' : 'S' );
		$this->out( sprintf( '%.2f %.2f %.2f %.2f re %s', $x, $pdf_y, $w, $h, $op ) );
		$this->out( 'Q' );
	}

	/**
	 * Draw a straight line using top-origin coordinates.
	 *
	 * @param float  $x1         Start X.
	 * @param float  $y1         Start top Y.
	 * @param float  $x2         End X.
	 * @param float  $y2         End top Y.
	 * @param string $stroke_hex Hex colour.
	 * @param float  $line_width Width in points.
	 */
	public function draw_line( $x1, $y1, $x2, $y2, $stroke_hex = '#BDBBB9', $line_width = 0.75 ) {
		list( $r, $g, $b ) = $this->hex_to_rgb( $stroke_hex );
		$py1               = $this->ph - $y1;
		$py2               = $this->ph - $y2;
		$this->out( sprintf( 'q %.3f %.3f %.3f RG %.2f w %.2f %.2f m %.2f %.2f l S Q', $r, $g, $b, $line_width, $x1, $py1, $x2, $py2 ) );
	}

	/**
	 * Draw single-line text at ($x, $baseline_top_y).
	 *
	 * @param float  $x          Left X.
	 * @param float  $baseline_y Distance from top of page to text baseline.
	 * @param string $text       Text string.
	 * @param string $font       Font key (F1..F4).
	 * @param float  $size       Font size in pt.
	 * @param string $color_hex  Hex colour.
	 */
	public function draw_text( $x, $baseline_y, $text, $font = 'F1', $size = 10.0, $color_hex = '#1F1D1C' ) {
		list( $r, $g, $b ) = $this->hex_to_rgb( $color_hex );
		$py                = $this->ph - $baseline_y;
		$this->out(
			sprintf(
				'BT /%s %.2f Tf %.3f %.3f %.3f rg %.2f %.2f Td (%s) Tj ET',
				$font,
				$size,
				$r,
				$g,
				$b,
				$x,
				$py,
				$this->pdf_str( $text )
			)
		);
	}

	/**
	 * Draw right-aligned single-line text ending at $right_x.
	 *
	 * @param float  $right_x    Right X coordinate.
	 * @param float  $baseline_y Baseline Y from top.
	 * @param string $text       Text string.
	 * @param string $font       Font key.
	 * @param float  $size       Font size.
	 * @param string $color_hex  Hex colour.
	 */
	public function draw_text_right( $right_x, $baseline_y, $text, $font = 'F1', $size = 10.0, $color_hex = '#1F1D1C' ) {
		$w = $this->text_width( $text, $size, $font );
		$this->draw_text( $right_x - $w, $baseline_y, $text, $font, $size, $color_hex );
	}

	/**
	 * Draw a section heading with a bottom red rule.
	 *
	 * @param string $num_label Section number (e.g. "01").
	 * @param string $title     Section title.
	 */
	public function add_section_heading( $num_label, $title ) {
		$this->ensure_space( 48.0 );
		$this->y += 10.0;
		$this->draw_rect( $this->margin_x, $this->y, 20.0, 15.0, '#B31B0C', null );
		$this->draw_text( $this->margin_x + 4.5, $this->y + 11.0, $num_label, 'F2', 8.5, '#FFFFFF' );
		$this->draw_text( $this->margin_x + 26.0, $this->y + 12.0, $title, 'F2', 13.0, '#1F1D1C' );
		$this->y += 19.0;
		$this->draw_line( $this->margin_x, $this->y, $this->pw - $this->margin_x, $this->y, '#B31B0C', 1.2 );
		$this->y += 8.0;
	}

	/**
	 * Draw wrapped paragraph and advance $this->y.
	 *
	 * @param string $text        Paragraph text.
	 * @param float  $font_size   Font size.
	 * @param string $font        Font key.
	 * @param string $color_hex   Colour hex.
	 * @param float  $line_height Line height in pt.
	 */
	public function add_paragraph( $text, $font_size = 9.5, $font = 'F1', $color_hex = '#3F3D3B', $line_height = 13.5 ) {
		$lines = $this->wrap_text( $text, $this->content_width(), $font_size, $font );
		if ( empty( $lines ) ) {
			return;
		}
		$this->ensure_space( count( $lines ) * $line_height + 4.0 );
		foreach ( $lines as $line ) {
			$this->draw_text( $this->margin_x, $this->y + $font_size, $line, $font, $font_size, $color_hex );
			$this->y += $line_height;
		}
		$this->y += 4.0;
	}

	/**
	 * Draw a left-bordered callout box and advance $this->y.
	 *
	 * @param string $kicker     Small uppercase label.
	 * @param string $body       Main callout text.
	 * @param string $accent_hex Left border colour.
	 * @param string $bg_hex     Background colour.
	 */
	public function add_callout( $kicker, $body, $accent_hex = '#B31B0C', $bg_hex = '#F7F7F7' ) {
		$cw    = $this->content_width();
		$lines = $this->wrap_text( $body, $cw - 24.0, 9.5, 'F1' );
		$box_h = 22.0 + ( count( $lines ) * 13.5 ) + 8.0;
		$this->ensure_space( $box_h + 6.0 );

		$this->draw_rect( $this->margin_x, $this->y, $cw, $box_h, $bg_hex, '#E0DEDB', 0.5 );
		$this->draw_rect( $this->margin_x, $this->y, 4.0, $box_h, $accent_hex, null );
		$this->draw_text( $this->margin_x + 12.0, $this->y + 13.0, strtoupper( $kicker ), 'F2', 8.0, $accent_hex );

		$ly = $this->y + 26.0;
		foreach ( $lines as $line ) {
			$this->draw_text( $this->margin_x + 12.0, $ly, $line, 'F1', 9.5, '#1F1D1C' );
			$ly += 13.5;
		}
		$this->y += $box_h + 7.0;
	}

	/**
	 * Render final PDF 1.4 binary string with running footers on all pages.
	 *
	 * @return string Binary PDF content.
	 */
	public function output_pdf_bytes() {
		$total_pages = count( $this->pages );
		$save_idx    = $this->page_idx;

		// Stamp running footers onto every page.
		for ( $i = 0; $i < $total_pages; $i++ ) {
			$this->page_idx = $i;
			$fy             = $this->ph - 26.0;
			$this->draw_line( $this->margin_x, $fy - 9.0, $this->pw - $this->margin_x, $fy - 9.0, '#D2D0CE', 0.5 );
			$this->draw_text( $this->margin_x, $fy, 'Cypher•One · AI Readiness Report · Confidential · ' . $this->footer_date, 'F1', 7.5, '#6B6866' );
			$this->draw_text_right( $this->pw - $this->margin_x, $fy, 'www.cypher-one.ai · Page ' . ( $i + 1 ) . ' of ' . $total_pages, 'F2', 7.5, '#6B6866' );
		}
		$this->page_idx = $save_idx;

		$objects = array();
		// Object 1: Catalog.
		$objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
		// Object 3..6: Fonts (Helvetica, Helvetica-Bold, Helvetica-Oblique, Courier-Bold).
		$objects[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>';
		$objects[4] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>';
		$objects[5] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Oblique /Encoding /WinAnsiEncoding >>';
		$objects[6] = '<< /Type /Font /Subtype /Type1 /BaseFont /Courier-Bold /Encoding /WinAnsiEncoding >>';

		$kids    = array();
		$next_id = 7;
		foreach ( $this->pages as $stream ) {
			$page_obj_id    = $next_id++;
			$content_obj_id = $next_id++;
			$kids[]         = $page_obj_id . ' 0 R';

			$objects[ $content_obj_id ] = "<< /Length " . strlen( $stream ) . " >>\nstream\n" . $stream . "endstream";
			$objects[ $page_obj_id ]    = sprintf(
				'<< /Type /Page /Parent 2 0 R /MediaBox [0 0 %.2f %.2f] /Resources << /Font << /F1 3 0 R /F2 4 0 R /F3 5 0 R /F4 6 0 R >> >> /Contents %d 0 R >>',
				$this->pw,
				$this->ph,
				$content_obj_id
			);
		}

		// Object 2: Pages root.
		$objects[2] = '<< /Type /Pages /Kids [' . implode( ' ', $kids ) . '] /Count ' . count( $kids ) . ' >>';
		ksort( $objects );

		$pdf     = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
		$offsets = array();
		foreach ( $objects as $id => $body ) {
			$offsets[ $id ] = strlen( $pdf );
			$pdf           .= $id . " 0 obj\n" . $body . "\nendobj\n";
		}

		$xref_pos = strlen( $pdf );
		$max_id   = max( array_keys( $objects ) );
		$pdf     .= "xref\n0 " . ( $max_id + 1 ) . "\n";
		$pdf     .= "0000000000 65535 f \n";
		for ( $i = 1; $i <= $max_id; $i++ ) {
			$pdf .= sprintf( "%010d 00000 n \n", isset( $offsets[ $i ] ) ? $offsets[ $i ] : 0 );
		}
		$pdf .= "trailer\n<< /Size " . ( $max_id + 1 ) . " /Root 1 0 R >>\nstartxref\n" . $xref_pos . "\n%%EOF";

		return $pdf;
	}
}

/**
 * Generate the user's personalised AI Readiness Report PDF.
 *
 * @param array  $state    Decoded client state S.
 * @param array  $contact  Sanitised contact/request fields.
 * @param array  $computed Output of c1_assessment_compute().
 * @param string $filepath Destination .pdf file path.
 * @return bool True on success.
 */
function c1_generate_assessment_pdf( $state, $contact, $computed, $filepath ) {
	$schema   = $computed['schema'];
	$date_str = wp_date( 'j F Y' );
	$org_lbl  = ! empty( $contact['organisation'] ) && 'Not given' !== $contact['organisation'] ? $contact['organisation'] : ( ! empty( $contact['name'] ) ? $contact['name'] : 'Respondent' );
	$pdf      = new C1_PDF_Report_Builder( $org_lbl . ' · ' . $date_str, $date_str );
	$cw       = $pdf->content_width();
	$mx       = $pdf->margin_x;

	/* ---- 1. Cover Masthead Banner ---- */
	$pdf->draw_rect( 0, 0, $pdf->pw, 128.0, '#1F1D1C', null );
	$pdf->draw_rect( 0, 128.0, $pdf->pw, 4.0, '#B31B0C', null );

	$pdf->draw_text( $mx, 28.0, 'cypher•one', 'F2', 14.0, '#FFFFFF' );
	$pdf->draw_text( $mx + 82.0, 28.0, 'AI READINESS ASSESSMENT', 'F2', 9.0, '#F0856F' );
	$pdf->draw_text_right( $pdf->pw - $mx, 28.0, 'CONFIDENTIAL · VERSION 1', 'F1', 8.5, '#B8B4B1' );

	$pdf->draw_text( $mx, 64.0, 'AI Readiness Report', 'F2', 26.0, '#FFFFFF' );
	$prep_line = 'Prepared for ' . ( ! empty( $contact['name'] ) ? $contact['name'] : 'Leadership Team' );
	if ( ! empty( $contact['organisation'] ) && 'Not given' !== $contact['organisation'] ) {
		$prep_line .= ' · ' . $contact['organisation'];
	}
	if ( ! empty( $contact['role'] ) && 'Not given' !== $contact['role'] ) {
		$prep_line .= ' (' . $contact['role'] . ')';
	}
	$pdf->draw_text( $mx, 88.0, $prep_line, 'F2', 10.5, '#F2F2F2' );
	$pdf->draw_text( $mx, 106.0, 'Sectors: ' . $computed['sector_text'] . '  ·  Country: ' . $computed['country_text'] . '  ·  ' . $date_str, 'F1', 9.0, '#CFCBC8' );

	$pdf->y = 146.0;

	/* ---- 2. Score Hero & At a Glance ---- */
	$hero_h = 94.0;
	$pdf->draw_rect( $mx, $pdf->y, $cw, $hero_h, '#FFFFFF', '#BDBBB9', 0.8 );
	$pdf->draw_rect( $mx, $pdf->y, 5.0, $hero_h, $computed['band']['color'], null );

	// Left side: Big score + band + segmented gauge bar.
	$pdf->draw_text( $mx + 16.0, $pdf->y + 16.0, 'OVERALL AI READINESS SCORE', 'F2', 8.0, '#6B6866' );
	$pdf->draw_text( $mx + 16.0, $pdf->y + 52.0, (string) $computed['composite'], 'F2', 36.0, $computed['band']['color'] );
	$pdf->draw_text( $mx + 68.0, $pdf->y + 42.0, '/ 100', 'F2', 11.0, '#6B6866' );
	$pdf->draw_text( $mx + 68.0, $pdf->y + 54.0, strtoupper( $computed['band']['label'] ), 'F2', 11.0, $computed['band']['color'] );

	// 4-band horizontal gauge bar.
	$gx = $mx + 16.0;
	$gy = $pdf->y + 66.0;
	$gw = 210.0;
	foreach ( $schema['bands'] as $b ) {
		$seg_x = $gx + ( $b['min'] / 100.0 ) * $gw;
		$seg_w = ( ( $b['max'] - $b['min'] + ( 100 === $b['max'] ? 0 : 1 ) ) / 100.0 ) * $gw;
		$pdf->draw_rect( $seg_x, $gy, $seg_w, 7.0, $b['color'], null );
	}
	// Score marker pin on gauge.
	$pin_x = $gx + ( max( 0, min( 100, $computed['composite'] ) ) / 100.0 ) * $gw;
	$pdf->draw_rect( $pin_x - 1.5, $gy - 3.0, 3.0, 13.0, '#1F1D1C', null );
	$pdf->draw_text( $gx, $gy + 18.0, '0 Exploring', 'F1', 7.0, '#6B6866' );
	$pdf->draw_text( $gx + 66.0, $gy + 18.0, '41 Experimenting', 'F1', 7.0, '#6B6866' );
	$pdf->draw_text( $gx + 134.0, $gy + 18.0, '61 Scaling', 'F1', 7.0, '#6B6866' );
	$pdf->draw_text( $gx + 178.0, $gy + 18.0, '81+ Leading', 'F1', 7.0, '#6B6866' );

	// Right side: 4 At-a-Glance tiles.
	$n_strong = 0;
	$n_weak   = 0;
	foreach ( $computed['d'] as $dv ) {
		if ( $dv >= 60 ) {
			++$n_strong;
		}
		if ( $dv < 40 ) {
			++$n_weak;
		}
	}
	$tx    = $mx + 245.0;
	$tw    = ( $cw - 255.0 ) / 2.0 - 4.0;
	$tiles = array(
		array( 'WEAKEST PILLAR', $computed['weak_pillar']['name'] . ' (' . $computed['weak_pillar']['value'] . '/100)', '#B31B0C' ),
		array( 'STRONG AREAS (60+)', $n_strong . ' of 8 areas', '#2C6E5B' ),
		array( 'URGENT AREAS (<40)', $n_weak . ' of 8 areas', '#E8321A' ),
		array( 'ACTIVE BLOCKERS NAMED', count( $computed['blockers'] ) . ' of 7 constraints', count( $computed['blockers'] ) ? '#E8321A' : '#2C6E5B' ),
	);
	foreach ( $tiles as $ti => $tile ) {
		$col = $ti % 2;
		$row = intdiv( $ti, 2 );
		$bx  = $tx + $col * ( $tw + 8.0 );
		$by  = $pdf->y + 10.0 + $row * 39.0;
		$pdf->draw_rect( $bx, $by, $tw, 34.0, '#F7F7F7', '#E0DEDB', 0.5 );
		$pdf->draw_rect( $bx, $by, $tw, 2.5, $tile[2], null );
		$pdf->draw_text( $bx + 7.0, $by + 12.0, $tile[0], 'F2', 6.8, '#6B6866' );
		$pdf->draw_text( $bx + 7.0, $by + 25.0, $tile[1], 'F2', 8.8, '#1F1D1C' );
	}

	$pdf->y += $hero_h + 6.0;

	/* ---- 3. Section 01: Executive Summary ---- */
	$pdf->add_section_heading( '01', 'Executive summary' );
	$pdf->add_callout( 'In plain terms · ' . $computed['band']['label'], $computed['plain'], $computed['band']['color'], '#F7F7F7' );
	$pdf->add_paragraph( $computed['across'], 9.5, 'F1', '#1F1D1C', 13.5 );
	if ( $computed['pre_adoption'] ) {
		$pdf->add_callout( 'Pre-adoption note', 'Assessed as pre-adoption readiness — scores reflect preparedness rather than current practice.', '#B31B0C', '#FBEAE6' );
	}

	/* ---- 4. Section 02: The Four Pillars ---- */
	$pdf->add_section_heading( '02', 'The four pillars' );
	$pdf->add_paragraph( 'Your eight areas of readiness roll into the four pillars every organisation must address to adopt AI successfully.', 9.0, 'F1', '#3F3D3B', 13.0 );

	$pdf->ensure_space( 86.0 );
	$pw_card = ( $cw - 18.0 ) / 4.0;
	foreach ( $computed['pillars'] as $pi => $p ) {
		$px      = $mx + $pi * ( $pw_card + 6.0 );
		$py      = $pdf->y;
		$is_weak = ( $p['n'] === $computed['weak_pillar']['n'] );
		$pdf->draw_rect( $px, $py, $pw_card, 68.0, '#FFFFFF', '#BDBBB9', 0.6 );
		$pdf->draw_rect( $px, $py, $pw_card, 3.5, $p['band']['color'], null );
		$pdf->draw_text( $px + 8.0, $py + 14.0, 'PILLAR ' . $p['n'] . ( $is_weak ? ' · WEAKEST' : '' ), 'F2', 7.0, $is_weak ? '#B31B0C' : '#6B6866' );
		$pdf->draw_text( $px + 8.0, $py + 34.0, $p['value'] . '/100', 'F2', 16.0, $p['band']['color'] );
		$p_lines = $pdf->wrap_text( $p['name'], $pw_card - 14.0, 8.2, 'F2' );
		$ply     = $py + 47.0;
		foreach ( array_slice( $p_lines, 0, 2 ) as $pl ) {
			$pdf->draw_text( $px + 8.0, $ply, $pl, 'F2', 8.2, '#1F1D1C' );
			$ply += 10.0;
		}
	}
	$pdf->y += 75.0;
	$pdf->add_callout(
		'Recommended starting point · ' . $computed['weak_pillar']['name'],
		'Where you scored lowest, we would start with: ' . $computed['weak_pillar']['cta'],
		'#1F1D1C',
		'#F2F2F2'
	);

	/* ---- 5. Section 03: How You Did in Each Part ---- */
	$pdf->add_section_heading( '03', 'How you did in each part' );
	$parts = array(
		array(
			'Section 1: Your practice',
			$computed['composite'],
			'How well you actually run and control AI day to day — who owns it, whether people are trained for it, whether it can reach your data, and whether anyone measures what it returns.',
		),
		array(
			'Section 2: What good looks like',
			$computed['know'],
			'How well you know what strong AI adoption looks like in this region, including that data access, not ambition, is the Gulf\'s binding constraint.',
		),
		array(
			'Section 3: Why it matters',
			$computed['why'],
			'Whether your organisation recognises what makes AI different from ordinary software: that it reaches production only with ownership, data and workflow change behind it.',
		),
	);
	foreach ( $parts as $pt ) {
		$pband = c1_assessment_band( $pt[1], $schema['bands'] );
		$body  = $pt[2] . ' ' . c1_assessment_verdict( $pt[0], $pt[1] );
		$lines = $pdf->wrap_text( $body, $cw - 20.0, 8.8, 'F1' );
		$bh    = 28.0 + count( $lines ) * 12.0 + 8.0;
		$pdf->ensure_space( $bh + 6.0 );

		$pdf->draw_rect( $mx, $pdf->y, $cw, $bh, '#FFFFFF', '#D2D0CE', 0.6 );
		$pdf->draw_text( $mx + 10.0, $pdf->y + 13.0, $pt[0], 'F2', 9.8, '#1F1D1C' );
		$pdf->draw_text_right( $mx + $cw - 10.0, $pdf->y + 13.0, $pt[1] . '/100 · ' . $pband['label'], 'F2', 9.5, $pband['color'] );

		// Progress bar.
		$bar_w = $cw - 20.0;
		$pdf->draw_rect( $mx + 10.0, $pdf->y + 18.0, $bar_w, 5.5, '#E0E0E0', null );
		if ( $pt[1] > 0 ) {
			$pdf->draw_rect( $mx + 10.0, $pdf->y + 18.0, ( $pt[1] / 100.0 ) * $bar_w, 5.5, $pband['color'], null );
		}

		$ly = $pdf->y + 34.0;
		foreach ( $lines as $l ) {
			$pdf->draw_text( $mx + 10.0, $ly, $l, 'F1', 8.8, '#3F3D3B' );
			$ly += 12.0;
		}
		$pdf->y += $bh + 5.0;
	}

	/* ---- 6. Section 04: Your Score in Every Area (All 8 Dimensions) ---- */
	$pdf->add_section_heading( '04', 'Your score in every area (weakest first)' );
	$pdf->add_paragraph( 'Your eight areas of readiness, ordered from lowest score to highest, compared against the illustrative sector median.', 9.0, 'F1', '#3F3D3B', 12.5 );

	foreach ( $computed['gaps'] as $dim ) {
		$sc    = $computed['d'][ $dim['key'] ];
		$dband = c1_assessment_band( $sc, $schema['bands'] );
		$pdf->ensure_space( 42.0 );

		$pdf->draw_rect( $mx, $pdf->y, $cw, 36.0, '#FFFFFF', '#D2D0CE', 0.5 );
		$pdf->draw_text( $mx + 10.0, $pdf->y + 12.0, $dim['label'], 'F2', 9.8, '#1F1D1C' );
		$pdf->draw_text( $mx + 95.0, $pdf->y + 12.0, $dim['desc'], 'F1', 8.3, '#6B6866' );
		$pdf->draw_text_right( $mx + $cw - 10.0, $pdf->y + 12.0, $sc . '/100  (Median ' . $dim['bench'] . ')', 'F2', 8.8, $dband['color'] );

		// Progress bar with median marker.
		$bx = $mx + 10.0;
		$by = $pdf->y + 20.0;
		$bw = $cw - 20.0;
		$pdf->draw_rect( $bx, $by, $bw, 6.5, '#E6E4E2', null );
		if ( $sc > 0 ) {
			$pdf->draw_rect( $bx, $by, ( $sc / 100.0 ) * $bw, 6.5, $dband['color'], null );
		}
		$med_x = $bx + ( $dim['bench'] / 100.0 ) * $bw;
		$pdf->draw_rect( $med_x - 0.8, $by - 2.0, 1.6, 10.5, '#1F1D1C', null );

		$pdf->y += 40.0;
	}

	/* ---- 7. Section 05: Fix These First (Top 3 Priority Gaps) ---- */
	$pdf->add_section_heading( '05', 'Fix these first (top 3 priority gaps)' );
	foreach ( array_slice( $computed['gaps'], 0, 3 ) as $gi => $gdim ) {
		$gsc   = $computed['d'][ $gdim['key'] ];
		$gband = c1_assessment_band( $gsc, $schema['bands'] );
		$pdf->add_callout(
			'Priority ' . ( $gi + 1 ) . ' · ' . $gdim['label'] . ' (' . $gsc . '/100)',
			$schema['fix'][ $gdim['key'] ],
			$gband['color'],
			'#FFFFFF'
		);
	}

	/* ---- 8. Section 06: Sequenced Roadmap ---- */
	$pdf->add_section_heading( '06', 'Your 90-day, 6-month and 12-month roadmap' );
	$pdf->add_paragraph( 'Built from your lowest scores and the blockers you named, sequenced so organisational foundations land first while long-lead work starts early.', 9.0, 'F1', '#3F3D3B', 12.5 );

	$roadmap_bands = array(
		array( 'NEXT 90 DAYS · STABILISE', '#B31B0C', $computed['roadmap']['now'] ),
		array( 'NEXT 6 MONTHS · BUILD', '#C8892A', $computed['roadmap']['six'] ),
		array( 'NEXT 12 MONTHS · SCALE', '#2E7D8A', $computed['roadmap']['twelve'] ),
	);
	foreach ( $roadmap_bands as $rb ) {
		$pdf->ensure_space( 26.0 );
		$pdf->draw_rect( $mx, $pdf->y, $cw, 18.0, '#1F1D1C', null );
		$pdf->draw_text( $mx + 8.0, $pdf->y + 12.5, $rb[0], 'F2', 8.5, '#FFFFFF' );
		$pdf->y += 21.0;

		foreach ( $rb[2] as $rit ) {
			$rband = c1_assessment_band( $rit['s'], $schema['bands'] );
			$lines = $pdf->wrap_text( $rit['d'], $cw - 56.0, 8.8, 'F1' );
			$rh    = 16.0 + count( $lines ) * 11.5 + 6.0;
			$pdf->ensure_space( $rh + 4.0 );

			$pdf->draw_rect( $mx, $pdf->y, $cw, $rh, '#FFFFFF', '#D2D0CE', 0.5 );
			$pdf->draw_rect( $mx + 8.0, $pdf->y + 6.0, 32.0, 14.0, $rband['color'], null );
			$pdf->draw_text( $mx + 13.0, $pdf->y + 15.5, $rit['s'] . '/100', 'F2', 7.5, '#FFFFFF' );
			$pdf->draw_text( $mx + 46.0, $pdf->y + 14.0, $rit['t'], 'F2', 9.5, '#1F1D1C' );

			$ly = $pdf->y + 26.0;
			foreach ( $lines as $l ) {
				$pdf->draw_text( $mx + 46.0, $ly, $l, 'F1', 8.8, '#3F3D3B' );
				$ly += 11.5;
			}
			$pdf->y += $rh + 3.0;
		}
		$pdf->y += 4.0;
	}

	/* ---- 9. Section 07: Recommended Actions ---- */
	$pdf->add_section_heading( '07', 'Recommended actions' );
	foreach ( $computed['actions'] as $ai => $act ) {
		$pdf->add_callout( 'Action ' . ( $ai + 1 ) . ' · ' . $act['t'], $act['d'], '#E8321A', '#FBEAE6' );
	}

	/* ---- 10. Section 08: What's Stalling You (Blockers) ---- */
	$pdf->add_section_heading( '08', 'What\'s stalling you' );
	$pdf->add_callout(
		'What your blocker profile tells us',
		$computed['blocker_narrative'],
		count( $computed['blockers'] ) ? '#E8321A' : '#2C6E5B',
		count( $computed['blockers'] ) ? '#FBEAE6' : '#EAF5EF'
	);

	if ( ! empty( $computed['blockers'] ) ) {
		foreach ( $computed['blockers'] as $bi => $bname ) {
			foreach ( $schema['blockers'] as $brow ) {
				if ( $brow[0] === $bname ) {
					$why_txt = isset( $schema['blocker_why'][ $bname ] ) ? $schema['blocker_why'][ $bname ] : '';
					$fix_txt = isset( $schema['fix'][ $brow[2] ] ) ? $schema['fix'][ $brow[2] ] : '';
					$pdf->add_callout(
						'Active Blocker ' . ( $bi + 1 ) . ': ' . $brow[0] . ' (' . ucfirst( $brow[2] ) . ')',
						$brow[1] . ' Why it stalls things: ' . $why_txt . ' What clears it: ' . $fix_txt,
						'#B31B0C',
						'#FFFFFF'
					);
					break;
				}
			}
		}
	}

	/* ---- 11. Section 09: What This Is Costing You (Exposure) ---- */
	$pdf->add_section_heading( '09', 'What this is costing you' );
	$pdf->add_callout( 'Value at risk', '• ' . implode( '  • ', $computed['exposure']['value'] ), '#E8321A', '#FFFFFF' );
	$pdf->add_callout( 'Competitive position', '• ' . implode( '  • ', $computed['exposure']['comp'] ), '#C8892A', '#FFFFFF' );

	/* ---- 12. Section 10: The Five Frameworks ---- */
	$pdf->add_section_heading( '10', 'The five frameworks you\'re judged against' );
	foreach ( $schema['anchors'] as $anc ) {
		$pdf->add_callout( $anc[0] . ' — ' . $anc[3], $anc[2], $anc[1], '#FFFFFF' );
	}

	/* ---- 13. Section 11: Your AI Profile & Submitted Survey Answers ---- */
	$pdf->add_section_heading( '11', 'Your AI profile & submitted survey answers' );

	$profile_rows = array(
		array( 'Respondent', ( ! empty( $contact['name'] ) ? $contact['name'] : '—' ) . ( ! empty( $contact['email'] ) ? ' <' . $contact['email'] . '>' : '' ) ),
		array( 'Organisation & Role', ( ! empty( $contact['organisation'] ) ? $contact['organisation'] : '—' ) . ' · ' . ( ! empty( $contact['role'] ) ? $contact['role'] : ( ! empty( $state['role'] ) ? $state['role'] : '—' ) ) ),
		array( 'Country & Size', $computed['country_text'] . ' · ' . ( ! empty( $state['size'] ) ? $state['size'] . ' employees' : 'Not specified' ) ),
		array( 'Sectors of Operation', $computed['sector_text'] ),
		array( 'Current AI Usage', ! empty( $state['usage'] ) ? $state['usage'] : 'Not specified' ),
		array( 'Types of AI Used', ! empty( $state['aiTypes'] ) && is_array( $state['aiTypes'] ) ? implode( ', ', $state['aiTypes'] ) : 'None selected' ),
		array( 'Self-Assessed Risk Level', ! empty( $state['riskClass'] ) ? $state['riskClass'] : 'Not specified' ),
		array( 'Written AI Strategy', ! empty( $state['riskProcess'] ) ? $state['riskProcess'] : 'Not specified' ),
		array( 'Follow-up Requested', ! empty( $contact['wants'] ) ? $contact['wants'] : 'Not specified' ),
	);

	foreach ( $profile_rows as $pr ) {
		$val_lines = $pdf->wrap_text( $pr[1], $cw - 150.0, 8.5, 'F1' );
		$rh        = max( 18.0, count( $val_lines ) * 11.5 + 6.0 );
		$pdf->ensure_space( $rh + 2.0 );
		$pdf->draw_rect( $mx, $pdf->y, 140.0, $rh, '#F2F2F2', '#D2D0CE', 0.5 );
		$pdf->draw_rect( $mx + 140.0, $pdf->y, $cw - 140.0, $rh, '#FFFFFF', '#D2D0CE', 0.5 );
		$pdf->draw_text( $mx + 8.0, $pdf->y + 12.0, $pr[0], 'F2', 8.5, '#1F1D1C' );
		$ly = $pdf->y + 12.0;
		foreach ( $val_lines as $vl ) {
			$pdf->draw_text( $mx + 148.0, $ly, $vl, 'F1', 8.5, '#3F3D3B' );
			$ly += 11.5;
		}
		$pdf->y += $rh;
	}

	$pdf->y += 10.0;
	$pdf->ensure_space( 34.0 );
	$pdf->draw_rect( $mx, $pdf->y, $cw, 20.0, '#1F1D1C', null );
	$pdf->draw_text( $mx + 8.0, $pdf->y + 13.5, 'Q#', 'F2', 8.0, '#FFFFFF' );
	$pdf->draw_text( $mx + 38.0, $pdf->y + 13.5, 'Area', 'F2', 8.0, '#FFFFFF' );
	$pdf->draw_text( $mx + 115.0, $pdf->y + 13.5, 'Question & Submitted Answer', 'F2', 8.0, '#FFFFFF' );
	$pdf->draw_text_right( $mx + $cw - 8.0, $pdf->y + 13.5, 'Score', 'F2', 8.0, '#FFFFFF' );
	$pdf->y += 20.0;

	foreach ( $computed['all_questions'] as $q ) {
		$q_lines = $pdf->wrap_text( $q['text'], $cw - 170.0, 8.3, 'F2' );
		$a_lines = $pdf->wrap_text( 'Answer: ' . $q['answer'], $cw - 170.0, 8.2, 'F1' );
		$rh      = ( count( $q_lines ) + count( $a_lines ) ) * 11.0 + 8.0;
		$pdf->ensure_space( $rh + 2.0 );

		$pdf->draw_rect( $mx, $pdf->y, $cw, $rh, '#FFFFFF', '#D2D0CE', 0.4 );
		$pdf->draw_text( $mx + 8.0, $pdf->y + 12.0, 'Q' . $q['num'], 'F2', 8.0, '#6B6866' );
		$pdf->draw_text( $mx + 38.0, $pdf->y + 12.0, $q['topic'], 'F2', 8.0, '#1F1D1C' );

		$qband = c1_assessment_band( (int) $q['score'], $schema['bands'] );
		$pdf->draw_text_right( $mx + $cw - 8.0, $pdf->y + 12.0, $q['score'] . '/100', 'F2', 8.3, $qband['color'] );

		$ly = $pdf->y + 12.0;
		foreach ( $q_lines as $ql ) {
			$pdf->draw_text( $mx + 115.0, $ly, $ql, 'F2', 8.3, '#1F1D1C' );
			$ly += 11.0;
		}
		foreach ( $a_lines as $al ) {
			$pdf->draw_text( $mx + 115.0, $ly, $al, 'F1', 8.2, '#3F3D3B' );
			$ly += 11.0;
		}
		$pdf->y += $rh;
	}

	/* ---- 14. Methodology & Contact Box ---- */
	$pdf->y += 10.0;
	$pdf->add_paragraph(
		'Methodology: The Cypher-One AI Readiness Assessment scores eight areas of AI readiness weighted by sector, alongside regional benchmarks drawn from PwC\'s 29th Global CEO Survey (Middle East findings, January 2026), the MCIT National AI Policy, the GCC AI Regulation Playbook, Qatar National Vision 2030, Digital Agenda 2030 and ISO/IEC 42001. This report is a readiness check, not certification or legal advice.',
		8.0,
		'F3',
		'#6B6866',
		11.5
	);

	$pdf->ensure_space( 68.0 );
	$pdf->draw_rect( $mx, $pdf->y, $cw, 58.0, '#1F1D1C', null );
	$pdf->draw_rect( $mx, $pdf->y, 4.0, 58.0, '#B31B0C', null );
	$pdf->draw_text( $mx + 14.0, $pdf->y + 16.0, 'WE\'RE HERE TO HELP · TURN THIS RESULT INTO A BOARD-READY PLAN', 'F2', 8.5, '#F0856F' );
	$pdf->draw_text( $mx + 14.0, $pdf->y + 32.0, 'Weakest pillar: ' . $computed['weak_pillar']['name'] . ' — ' . $computed['weak_pillar']['cta'], 'F2', 9.0, '#FFFFFF' );
	$c_email = c1_opt( 'contact_email' ) ? c1_opt( 'contact_email' ) : 'contact@cypher-one.ai';
	$c_web   = c1_opt( 'website_label' ) ? c1_opt( 'website_label' ) : 'www.cypher-one.ai';
	$c_loc   = c1_opt( 'contact_location' ) ? c1_opt( 'contact_location' ) : 'Doha, Qatar';
	$pdf->draw_text( $mx + 14.0, $pdf->y + 47.0, 'Email: ' . $c_email . '   ·   Web: ' . $c_web . '   ·   Location: ' . $c_loc, 'F1', 8.5, '#CFCBC8' );

	$pdf_bytes = $pdf->output_pdf_bytes();
	return false !== file_put_contents( $filepath, $pdf_bytes ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
}

