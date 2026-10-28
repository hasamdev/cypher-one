<?php
/**
 * Template helpers: reading SCF values with schema fallbacks, links, images, menus.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get or set the current field context (home, why, approach, about, contact…).
 *
 * @param string|null $ctx Context to set.
 * @return string
 */
function c1_ctx( $ctx = null ) {
	static $current = 'home';
	if ( null !== $ctx ) {
		$current = $ctx;
	}
	return $current;
}

/**
 * Whether SCF (or ACF) is available.
 *
 * @return bool
 */
function c1_scf_active() {
	return function_exists( 'get_field' ) && function_exists( 'acf_add_local_field_group' );
}

/**
 * Read a field. Falls back to the schema default when nothing has been saved yet,
 * so the site renders its original content out of the box.
 *
 * @param string          $name    Field name.
 * @param string|null     $ctx     Context (defaults to the current one).
 * @param int|string|null $post_id Post ID or 'option'.
 * @return mixed
 */
function c1_f( $name, $ctx = null, $post_id = null ) {
	$ctx = $ctx ? $ctx : c1_ctx();
	$def = c1_field_def( $ctx, $name );
	if ( ! $def ) {
		return '';
	}
	$fallback = $def['default'];

	if ( ! c1_scf_active() ) {
		return $fallback;
	}

	if ( 'options' === $ctx ) {
		$post_id = 'option';
		$exists  = null !== get_option( 'options_' . $name, null );
	} else {
		if ( null === $post_id ) {
			$post_id = get_queried_object_id();
		}
		$exists = $post_id && metadata_exists( 'post', $post_id, $name );
	}

	if ( ! $exists ) {
		return $fallback;
	}

	$value = get_field( c1_key( $ctx, $name ), $post_id );

	if ( 'image' === $def['type'] && empty( $value ) ) {
		return $fallback;
	}
	if ( 'repeater' === $def['type'] && ! is_array( $value ) ) {
		return array();
	}
	if ( 'repeater' === $def['type'] ) {
		$value = c1_fill_row_images( $value, $def );
	}
	return null === $value ? '' : $value;
}

/**
 * Repeater rows whose image sub field is empty borrow the default row image.
 *
 * @param array $rows Rows.
 * @param array $def  Repeater schema.
 * @return array
 */
function c1_fill_row_images( $rows, $def ) {
	foreach ( $def['sub_fields'] as $sub ) {
		if ( 'image' !== $sub['type'] ) {
			continue;
		}
		foreach ( $rows as $i => $row ) {
			if ( empty( $row[ $sub['name'] ] ) && isset( $def['default'][ $i ][ $sub['name'] ] ) ) {
				$rows[ $i ][ $sub['name'] ] = $def['default'][ $i ][ $sub['name'] ];
			}
		}
	}
	return $rows;
}

/**
 * Option value (Cypher-One Settings page).
 *
 * @param string $name Field name.
 * @return mixed
 */
function c1_opt( $name ) {
	return c1_f( $name, 'options' );
}

/**
 * Allowed inline HTML for "html" fields.
 *
 * @return array
 */
function c1_inline_tags() {
	return array(
		'a'      => array(
			'href'   => true,
			'rel'    => true,
			'target' => true,
			'title'  => true,
			'class'  => true,
		),
		'strong' => array( 'class' => true ),
		'b'      => array(),
		'em'     => array(),
		'i'      => array(),
		'span'   => array(
			'class' => true,
			'style' => true,
		),
		'br'     => array(),
		'cite'   => array(),
		'small'  => array(),
		'sup'    => array(),
	);
}

/**
 * Sanitise inline HTML.
 *
 * @param string $html HTML.
 * @return string
 */
function c1_kses( $html ) {
	$html = preg_replace_callback(
		'/href="(\{[a-z]+\}[^"]*)"/',
		function ( $m ) {
			return 'href="' . esc_url( c1_url( $m[1] ) ) . '"';
		},
		(string) $html
	);
	return wp_kses( $html, c1_inline_tags() );
}

/**
 * Echo a plain-text field.
 *
 * @param string      $name Field name.
 * @param string|null $ctx  Context.
 */
function c1_e( $name, $ctx = null ) {
	echo esc_html( (string) c1_f( $name, $ctx ) );
}

/**
 * Echo an inline-HTML field.
 *
 * @param string      $name Field name.
 * @param string|null $ctx  Context.
 */
function c1_h( $name, $ctx = null ) {
	echo c1_kses( c1_f( $name, $ctx ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Map of template keys to template files.
 *
 * @return array
 */
function c1_templates() {
	return array(
		'why'        => 'page-templates/why-ai-stalls.php',
		'approach'   => 'page-templates/our-approach.php',
		'about'      => 'page-templates/about.php',
		'contact'    => 'page-templates/contact.php',
		'privacy'    => 'page-templates/legal.php',
		'assessment' => 'page-templates/assessment.php',
		'thanks'     => 'page-templates/thanks.php',
		'score'      => 'page-templates/tools-score-an-idea.php',
		'cost'       => 'page-templates/tools-cost-of-waiting.php',
		'gap'        => 'page-templates/readiness-gap.php',
		'discovery'  => 'page-templates/discovery.php',
		'howwework'  => 'page-templates/how-we-work.php',
	);
}

/**
 * URL of a theme page by key (home, why, approach…).
 *
 * @param string $key Page key.
 * @return string
 */
function c1_page_url( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$url = '';
	if ( 'home' === $key ) {
		$url = home_url( '/' );
	} elseif ( 'privacy' === $key && get_option( 'wp_page_for_privacy_policy' ) && 'publish' === get_post_status( (int) get_option( 'wp_page_for_privacy_policy' ) ) ) {
		$url = get_permalink( (int) get_option( 'wp_page_for_privacy_policy' ) );
	} else {
		$templates = c1_templates();
		if ( isset( $templates[ $key ] ) ) {
			$pages = get_posts(
				array(
					'post_type'      => 'page',
					'post_status'    => 'publish',
					'posts_per_page' => 1,
					'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					'meta_value'     => $templates[ $key ], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
					'fields'         => 'ids',
					'orderby'        => 'menu_order ID',
					'order'          => 'ASC',
				)
			);
			if ( $pages ) {
				$url = get_permalink( $pages[0] );
			}
		}
	}
	$cache[ $key ] = $url;
	return $url;
}

/**
 * Resolve a link value: tokens like {contact}#contact become real URLs.
 *
 * @param string $value Raw value.
 * @return string
 */
function c1_url( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	$value = preg_replace_callback(
		'/\{([a-z]+)\}/',
		function ( $m ) {
			$url = c1_page_url( $m[1] );
			return $url ? untrailingslashit( $url ) . '/' : home_url( '/' );
		},
		$value
	);
	return $value;
}

/**
 * Echo an escaped link from a field or a raw value.
 *
 * @param string $value Raw link value.
 */
function c1_eurl( $value ) {
	echo esc_url( c1_url( $value ) );
}

/**
 * Link attributes: open the assessment in a new tab, as the original did.
 *
 * @param string $value Raw link value.
 * @return string
 */
function c1_link_attrs( $value ) {
	$value = (string) $value;
	if ( false !== strpos( $value, '{assessment}' ) ) {
		return ' target="_blank" rel="noopener"';
	}
	if ( preg_match( '#^https?://#', $value ) && false === strpos( $value, wp_parse_url( home_url(), PHP_URL_HOST ) ) ) {
		return ' rel="noopener"';
	}
	return '';
}

/**
 * URL for an image value: attachment ID, theme-relative path or absolute URL.
 *
 * @param mixed  $value Image value.
 * @param string $size  Image size.
 * @return string
 */
function c1_img_url( $value, $size = 'full' ) {
	if ( is_array( $value ) && isset( $value['ID'] ) ) {
		$value = $value['ID'];
	}
	if ( is_numeric( $value ) && (int) $value > 0 ) {
		$src = wp_get_attachment_image_url( (int) $value, $size );
		return $src ? $src : '';
	}
	$value = (string) $value;
	if ( '' === $value ) {
		return '';
	}
	if ( preg_match( '#^(https?:)?//#', $value ) ) {
		return $value;
	}
	return C1_URI . '/' . ltrim( $value, '/' );
}

/**
 * Inline an SVG from assets/svg.
 *
 * @param string $name File name without extension.
 * @return string
 */
function c1_svg( $name ) {
	static $cache = array();
	if ( ! isset( $cache[ $name ] ) ) {
		$file           = C1_DIR . '/assets/svg/' . sanitize_file_name( $name ) . '.svg';
		$cache[ $name ] = file_exists( $file ) ? trim( (string) file_get_contents( $file ) ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	}
	return $cache[ $name ];
}

/**
 * Echo the theme logo: an uploaded custom logo, or the cypher•one word mark.
 *
 * @param string $href Link target.
 */
function c1_logo( $href ) {
	if ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		printf(
			'<a class="logo logo-image" href="%1$s">%2$s</a>',
			esc_url( $href ),
			wp_get_attachment_image( $logo_id, 'full', false, array( 'alt' => get_bloginfo( 'name' ) ) )
		);
		return;
	}
	printf(
		'<a class="logo" href="%1$s">%2$s<span>%3$s</span>%4$s<small>%5$s</small></a>',
		esc_url( $href ),
		esc_html( c1_opt( 'logo_word_1' ) ),
		esc_html( c1_opt( 'logo_separator' ) ),
		esc_html( c1_opt( 'logo_word_2' ) ),
		esc_html( c1_opt( 'logo_tagline' ) )
	);
}

/**
 * Default navigation items, used until a menu is assigned.
 *
 * @param string $location Menu location.
 * @return array[] Each item: title, url, classes, target.
 */
function c1_default_menu( $location ) {
	$assess = array(
		'url'    => c1_page_url( 'assessment' ),
		'target' => '_blank',
	);
	switch ( $location ) {
		case 'primary':
			return array(
				array( 'title' => __( 'Home', 'cypher-one' ), 'url' => c1_page_url( 'home' ) ),
				array( 'title' => __( 'Why AI stalls', 'cypher-one' ), 'url' => c1_page_url( 'why' ) ),
				array( 'title' => __( 'Our Approach', 'cypher-one' ), 'url' => c1_page_url( 'approach' ) ),
				array( 'title' => __( 'About', 'cypher-one' ), 'url' => c1_page_url( 'about' ) ),
				array( 'title' => __( 'Contact', 'cypher-one' ), 'url' => c1_page_url( 'contact' ) ),
				array_merge( $assess, array( 'title' => __( 'AI Assessment', 'cypher-one' ), 'classes' => array( 'nav-assess' ) ) ),
			);
		case 'footer_pages':
			return array(
				array( 'title' => __( 'Home', 'cypher-one' ), 'url' => c1_page_url( 'home' ) ),
				array( 'title' => __( 'Why AI stalls', 'cypher-one' ), 'url' => c1_page_url( 'why' ) ),
				array( 'title' => __( 'Our Approach', 'cypher-one' ), 'url' => c1_page_url( 'approach' ) ),
				array( 'title' => __( 'About', 'cypher-one' ), 'url' => c1_page_url( 'about' ) ),
				array( 'title' => __( 'Contact', 'cypher-one' ), 'url' => c1_page_url( 'contact' ) ),
				array( 'title' => __( 'Privacy', 'cypher-one' ), 'url' => c1_page_url( 'privacy' ) ),
			);
		case 'footer_tools':
			return array(
				array_merge( $assess, array( 'title' => __( 'Readiness assessment', 'cypher-one' ) ) ),
				array( 'title' => __( 'Score one idea', 'cypher-one' ), 'url' => home_url( '/#assess' ) ),
				array( 'title' => __( 'Cost of waiting', 'cypher-one' ), 'url' => home_url( '/#calculator' ) ),
				array( 'title' => __( 'AI Adoption Review', 'cypher-one' ), 'url' => c1_page_url( 'discovery' ) ),
			);
		case 'footer_legal':
			return array(
				array( 'title' => __( 'Privacy', 'cypher-one' ), 'url' => c1_page_url( 'privacy' ) ),
				array( 'title' => __( 'Back to top', 'cypher-one' ), 'url' => '#top' ),
			);
	}
	return array();
}

/**
 * Items of a menu location, normalised. Falls back to the defaults above.
 *
 * @param string $location Menu location.
 * @return array[]
 */
function c1_menu_items( $location ) {
	$locations = get_nav_menu_locations();
	$items     = array();
	if ( ! empty( $locations[ $location ] ) ) {
		$menu_items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( $menu_items ) {
			_wp_menu_item_classes_by_context( $menu_items );
			foreach ( $menu_items as $mi ) {
				if ( (int) $mi->menu_item_parent ) {
					continue; // The design has a flat navigation.
				}
				$classes = array_filter( (array) $mi->classes );
				$items[] = array(
					'title'   => $mi->title,
					'url'     => $mi->url,
					'target'  => $mi->target,
					'classes' => array_values(
						array_filter(
							$classes,
							function ( $c ) {
								return 0 !== strpos( $c, 'menu-item' ) && 0 !== strpos( $c, 'current' ) && 'page_item' !== $c && 0 !== strpos( $c, 'page-item' );
							}
						)
					),
					'current' => ! empty( $mi->current ),
				);
			}
			return $items;
		}
	}

	$current = '';
	if ( is_front_page() ) {
		$current = trailingslashit( home_url( '/' ) );
	} elseif ( is_singular() ) {
		$current = trailingslashit( (string) get_permalink( get_queried_object_id() ) );
	}
	foreach ( c1_default_menu( $location ) as $item ) {
		if ( empty( $item['url'] ) ) {
			continue;
		}
		$item          = wp_parse_args( $item, array( 'target' => '', 'classes' => array() ) );
		$item['current'] = ( false === strpos( $item['url'], '#' ) && trailingslashit( $item['url'] ) === $current );
		$items[]       = $item;
	}
	return $items;
}

/**
 * Render menu anchors (header) or a list (footer).
 *
 * @param string $location Menu location.
 * @param bool   $as_list  Wrap each link in <li>.
 */
function c1_menu( $location, $as_list = false ) {
	foreach ( c1_menu_items( $location ) as $item ) {
		$attrs = '';
		if ( ! empty( $item['classes'] ) ) {
			$attrs .= ' class="' . esc_attr( implode( ' ', $item['classes'] ) ) . '"';
		}
		if ( ! empty( $item['target'] ) ) {
			$attrs .= ' target="' . esc_attr( $item['target'] ) . '" rel="noopener"';
		}
		if ( ! empty( $item['current'] ) && ! $as_list ) {
			$attrs .= ' aria-current="page"';
		}
		$link = '<a href="' . esc_url( $item['url'] ) . '"' . $attrs . '>' . esc_html( $item['title'] ) . '</a>';
		echo $as_list ? '<li>' . $link . '</li>' : "\n      " . $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Render a reusable "ask" line (the question that closes every section).
 *
 * @param string $name  Field name.
 * @param string $style Inline style.
 */
function c1_ask( $name, $style = 'margin-top:28px' ) {
	$text = c1_f( $name );
	if ( '' === trim( (string) $text ) ) {
		return;
	}
	printf( '<p class="ask"%1$s>%2$s</p>', $style ? ' style="' . esc_attr( $style ) . '"' : '', c1_kses( $text ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Render an eyebrow + heading stack used in section head rows.
 *
 * @param string $eyebrow Eyebrow field.
 * @param string $title   Title field.
 * @param string $id      Heading id.
 */
function c1_section_head( $eyebrow, $title, $id ) {
	printf(
		'<p class="eyebrow">%1$s </p><h2 id="%2$s">%3$s</h2>',
		esc_html( c1_f( $eyebrow ) ),
		esc_attr( $id ),
		c1_kses( c1_f( $title ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Render a button pair / single button from label + link fields.
 *
 * @param string $label Label field.
 * @param string $link  Link field.
 * @param string $class Button class.
 */
function c1_button( $label, $link, $class = 'btn btn-primary' ) {
	$text = c1_f( $label );
	$url  = c1_f( $link );
	if ( '' === trim( (string) $text ) ) {
		return;
	}
	printf(
		'<a class="%1$s" href="%2$s"%3$s>%4$s</a>',
		esc_attr( $class ),
		esc_url( c1_url( $url ) ),
		c1_link_attrs( $url ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_html( $text )
	);
}

/**
 * Turn {tokens} in a sentence into live calculator outputs.
 *
 * @param string $text Text with {hours}, {save}, {year}, {lost}, {left}, {fte}, {pct}.
 * @return string
 */
function c1_calc_tokens( $text ) {
	$text = c1_kses( $text );
	return preg_replace_callback(
		'/\{(hours|save|year|lost|left|fte|pct)\}/',
		function ( $m ) {
			if ( 'pct' === $m[1] ) {
				return esc_html( (string) c1_f( 'calc_reclaim_pct' ) ) . '%';
			}
			return '<strong data-r="' . $m[1] . '">0</strong>';
		},
		$text
	);
}

/**
 * Inner-page intro band and photo.
 *
 * @param string $page_id   id attribute suffix (why, what, about…).
 * @param string $aria      Section aria-label.
 * @param string $h1_id     Optional id on the heading.
 */
function c1_page_intro( $page_id, $aria, $h1_id = '' ) {
	get_template_part(
		'template-parts/page-intro',
		null,
		array(
			'page_id' => $page_id,
			'aria'    => $aria,
			'h1_id'   => $h1_id,
		)
	);
}

/**
 * Small numbers as words ("six"), larger ones as digits — as the copy reads.
 *
 * @param int $n Number.
 * @return string
 */
function c1_number_word( $n ) {
	$words = array(
		1  => __( 'one', 'cypher-one' ),
		2  => __( 'two', 'cypher-one' ),
		3  => __( 'three', 'cypher-one' ),
		4  => __( 'four', 'cypher-one' ),
		5  => __( 'five', 'cypher-one' ),
		6  => __( 'six', 'cypher-one' ),
		7  => __( 'seven', 'cypher-one' ),
		8  => __( 'eight', 'cypher-one' ),
		9  => __( 'nine', 'cypher-one' ),
		10 => __( 'ten', 'cypher-one' ),
	);
	return isset( $words[ $n ] ) ? $words[ $n ] : number_format_i18n( $n );
}
