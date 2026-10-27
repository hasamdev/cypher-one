<?php
/**
 * Field schema: one definition drives the SCF field groups, the front-end
 * fallbacks (so the theme renders its original content even before anything
 * is saved) and the one-click content setup.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Tab separator inside a field group.
 *
 * @param string $label Tab label.
 * @return array
 */
function c1_tab( $label ) {
	return array(
		'type'  => 'tab',
		'label' => $label,
	);
}

/**
 * A simple field.
 *
 * Types: text, textarea, html (textarea that allows inline HTML), link (text that accepts
 * {tokens}), image, number, email, true_false, select.
 *
 * @param string $name    Field name (meta key).
 * @param string $type    Field type.
 * @param string $label   Label shown in the editor.
 * @param mixed  $default Default (also the front-end fallback).
 * @param array  $args    Extra SCF settings (instructions, wrapper, choices…).
 * @return array
 */
function c1_fld( $name, $type, $label, $default = '', $args = array() ) {
	return array_merge(
		array(
			'name'    => $name,
			'type'    => $type,
			'label'   => $label,
			'default' => $default,
		),
		$args
	);
}

/**
 * A repeater field.
 *
 * @param string $name    Field name.
 * @param string $label   Label.
 * @param array  $sub     Sub fields (built with c1_fld / c1_rep).
 * @param array  $default Default rows.
 * @param array  $args    Extra SCF settings.
 * @return array
 */
function c1_rep( $name, $label, $sub, $default = array(), $args = array() ) {
	return array_merge(
		array(
			'name'       => $name,
			'type'       => 'repeater',
			'label'      => $label,
			'sub_fields' => $sub,
			'default'    => $default,
		),
		$args
	);
}

/**
 * All field group definitions, keyed by context.
 *
 * @return array
 */
function c1_groups() {
	static $groups = null;
	if ( null !== $groups ) {
		return $groups;
	}
	$groups = array();
	require_once C1_DIR . '/inc/fields/sections.php';
	$files  = array( 'options', 'home', 'why', 'approach', 'about', 'contact', 'thanks', 'assessment', 'subpages', 'seo' );
	foreach ( $files as $file ) {
		$path = C1_DIR . '/inc/fields/' . $file . '.php';
		if ( file_exists( $path ) ) {
			$def = include $path;
			if ( is_array( $def ) ) {
				foreach ( $def as $ctx => $group ) {
					$groups[ $ctx ] = $group;
				}
			}
		}
	}
	return $groups;
}

/**
 * Find a field definition by name inside a context.
 *
 * @param string $ctx  Context.
 * @param string $name Field name.
 * @return array|null
 */
function c1_field_def( $ctx, $name ) {
	static $index = array();
	if ( ! isset( $index[ $ctx ] ) ) {
		$index[ $ctx ] = array();
		$groups        = c1_groups();
		if ( isset( $groups[ $ctx ] ) ) {
			foreach ( $groups[ $ctx ]['fields'] as $f ) {
				if ( isset( $f['name'] ) ) {
					$index[ $ctx ][ $f['name'] ] = $f;
				}
			}
		}
	}
	return isset( $index[ $ctx ][ $name ] ) ? $index[ $ctx ][ $name ] : null;
}

/**
 * Build the SCF key of a field.
 *
 * @param string $ctx  Context.
 * @param string $path Field name, or parent_child for sub fields.
 * @return string
 */
function c1_key( $ctx, $path ) {
	return 'field_c1_' . $ctx . '_' . $path;
}

/**
 * Convert schema fields into SCF field arrays.
 *
 * @param array  $fields Schema fields.
 * @param string $ctx    Context.
 * @param string $prefix Key prefix for nested fields.
 * @return array
 */
function c1_to_scf( $fields, $ctx, $prefix = '' ) {
	$out = array();
	$tab = 0;
	foreach ( $fields as $f ) {
		if ( 'tab' === $f['type'] ) {
			++$tab;
			$out[] = array(
				'key'       => c1_key( $ctx, $prefix . 'tab' . $tab ),
				'label'     => $f['label'],
				'name'      => '',
				'type'      => 'tab',
				'placement' => 'top',
			);
			continue;
		}

		$scf = array(
			'key'          => c1_key( $ctx, $prefix . $f['name'] ),
			'label'        => $f['label'],
			'name'         => $f['name'],
			'instructions' => isset( $f['instructions'] ) ? $f['instructions'] : '',
			'wrapper'      => isset( $f['wrapper'] ) ? $f['wrapper'] : array(),
		);

		switch ( $f['type'] ) {
			case 'html':
				$scf['type']          = 'textarea';
				$scf['new_lines']     = '';
				$scf['rows']          = isset( $f['rows'] ) ? $f['rows'] : 3;
				$scf['default_value'] = $f['default'];
				$scf['instructions']  = trim( $scf['instructions'] . ' ' . __( 'Inline HTML allowed (links, <strong>, <b>, <em>, <span>, <br>).', 'cypher-one' ) );
				break;
			case 'textarea':
				$scf['type']          = 'textarea';
				$scf['new_lines']     = '';
				$scf['rows']          = isset( $f['rows'] ) ? $f['rows'] : 3;
				$scf['default_value'] = $f['default'];
				break;
			case 'link':
				$scf['type']          = 'text';
				$scf['default_value'] = $f['default'];
				$scf['instructions']  = trim( $scf['instructions'] . ' ' . __( 'A full URL, an anchor such as #close, or a page token: {home}, {why}, {approach}, {about}, {contact}, {privacy}, {assessment}, {thanks}, {score}, {cost}, {gap}, {discovery}, {howwework}. Tokens can be followed by an anchor, e.g. {contact}#contact.', 'cypher-one' ) );
				break;
			case 'image':
				$scf['type']          = 'image';
				$scf['return_format'] = 'id';
				$scf['preview_size']  = 'medium';
				$scf['library']       = 'all';
				if ( '' === $scf['instructions'] ) {
					$scf['instructions'] = __( 'Leave empty to use the original photo.', 'cypher-one' );
				}
				break;
			case 'number':
				$scf['type']          = 'number';
				$scf['default_value'] = $f['default'];
				foreach ( array( 'min', 'max', 'step', 'append', 'prepend' ) as $k ) {
					if ( isset( $f[ $k ] ) ) {
						$scf[ $k ] = $f[ $k ];
					}
				}
				break;
			case 'true_false':
				$scf['type']          = 'true_false';
				$scf['ui']            = 1;
				$scf['default_value'] = $f['default'] ? 1 : 0;
				break;
			case 'select':
				$scf['type']          = 'select';
				$scf['choices']       = $f['choices'];
				$scf['default_value'] = $f['default'];
				$scf['return_format'] = 'value';
				break;
			case 'message':
				$scf['type']    = 'message';
				$scf['message'] = isset( $f['message'] ) ? $f['message'] : '';
				$scf['name']    = '';
				break;
			case 'repeater':
				$scf['type']         = 'repeater';
				$scf['layout']       = isset( $f['layout'] ) ? $f['layout'] : 'block';
				$scf['button_label'] = isset( $f['button_label'] ) ? $f['button_label'] : __( 'Add row', 'cypher-one' );
				$scf['sub_fields']   = c1_to_scf( $f['sub_fields'], $ctx, $prefix . $f['name'] . '__' );
				$scf['min']          = isset( $f['min'] ) ? $f['min'] : 0;
				$scf['max']          = isset( $f['max'] ) ? $f['max'] : 0;
				if ( ! empty( $scf['sub_fields'] ) ) {
					$scf['collapsed'] = $scf['sub_fields'][0]['key'];
				}
				break;
			default:
				$scf['type']          = $f['type'];
				$scf['default_value'] = $f['default'];
		}
		// Instructions mention HTML tags literally; escape them so the editor shows them as text.
		$scf['instructions'] = esc_html( $scf['instructions'] );
		$out[] = $scf;
	}
	return $out;
}

/**
 * Register the options page and every field group with SCF.
 */
function c1_register_scf() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			array(
				'page_title' => __( 'Cypher-One Settings', 'cypher-one' ),
				'menu_title' => __( 'Cypher-One', 'cypher-one' ),
				'menu_slug'  => 'c1-settings',
				'capability' => 'edit_theme_options',
				'icon_url'   => 'dashicons-admin-site-alt3',
				'position'   => 59,
				'redirect'   => false,
			)
		);
	}

	foreach ( c1_groups() as $ctx => $group ) {
		acf_add_local_field_group(
			array(
				'key'                   => 'group_c1_' . $ctx,
				'title'                 => $group['title'],
				'fields'                => c1_to_scf( $group['fields'], $ctx ),
				'location'              => $group['location'],
				'menu_order'            => isset( $group['menu_order'] ) ? $group['menu_order'] : 0,
				'position'              => isset( $group['position'] ) ? $group['position'] : 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => isset( $group['hide_on_screen'] ) ? $group['hide_on_screen'] : array(),
				'active'                => true,
			)
		);
	}
}
add_action( 'acf/init', 'c1_register_scf' );

/**
 * Location rule for a page template.
 *
 * @param string $template Template file relative to the theme.
 * @return array
 */
function c1_loc_template( $template ) {
	return array(
		array(
			array(
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => $template,
			),
		),
	);
}

/**
 * Shared "page intro + photo band" fields for inner pages.
 *
 * @param array $d Defaults: eyebrow, title, lede, photo, alt, caption.
 * @return array
 */
function c1_intro_fields( $d ) {
	return array(
		c1_tab( __( 'Page intro', 'cypher-one' ) ),
		c1_fld( 'intro_eyebrow', 'text', __( 'Eyebrow', 'cypher-one' ), $d['eyebrow'] ),
		c1_fld( 'intro_title', 'html', __( 'Heading', 'cypher-one' ), $d['title'] ),
		c1_fld( 'intro_lede', 'textarea', __( 'Introduction', 'cypher-one' ), $d['lede'] ),
		c1_tab( __( 'Photo band', 'cypher-one' ) ),
		c1_fld( 'photo_show', 'true_false', __( 'Show the photo band', 'cypher-one' ), true ),
		c1_fld( 'photo_image', 'image', __( 'Photo', 'cypher-one' ), $d['photo'], array( 'instructions' => __( 'Wide image, around 1800 × 420. Leave empty to use the original Unsplash photo.', 'cypher-one' ) ) ),
		c1_fld( 'photo_alt', 'text', __( 'Alternative text', 'cypher-one' ), $d['alt'] ),
		c1_fld( 'photo_caption', 'html', __( 'Caption / credit', 'cypher-one' ), $d['caption'] ),
	);
}

/**
 * Unsplash URL in the size the original build used.
 *
 * @param string $id Unsplash photo id.
 * @return string
 */
function c1_unsplash( $id ) {
	return 'https://images.unsplash.com/' . $id . '?w=1800&h=420&fit=crop&crop=entropy&q=70&auto=format';
}

/**
 * Default questions for the home-page idea scorer (weights match the original build).
 *
 * @return array
 */
function c1_ga_default_questions() {
	$o = function ( $label, $weight, $against = '', $favour = '' ) {
		return array(
			'label'   => $label,
			'weight'  => $weight,
			'against' => $against,
			'favour'  => $favour,
		);
	};
	return array(
		array(
			'question' => __( 'Where does the data for this process live?', 'cypher-one' ),
			'options'  => array(
				$o( __( 'In one system, with an owner', 'cypher-one' ), 15, '', __( 'Data sits in one owned system.', 'cypher-one' ) ),
				$o( __( 'In a few systems, many owners', 'cypher-one' ), 5, __( 'Data split across a few systems.', 'cypher-one' ) ),
				$o( __( 'Spread across spreadsheets and email, no owner', 'cypher-one' ), -10, __( 'Data is scattered with no clear owner.', 'cypher-one' ) ),
			),
		),
		array(
			'question' => __( 'How often does this task happen?', 'cypher-one' ),
			'options'  => array(
				$o( __( 'Daily, high volume', 'cypher-one' ), 10, '', __( 'High volume, so savings add up quickly.', 'cypher-one' ) ),
				$o( __( 'Weekly', 'cypher-one' ), 3, '', __( 'Regular task, so savings are steady.', 'cypher-one' ) ),
				$o( __( 'Occasionally', 'cypher-one' ), -5, __( 'Occasional task, so savings are small.', 'cypher-one' ) ),
			),
		),
		array(
			'question' => __( 'Can you check whether the AI got it right?', 'cypher-one' ),
			'options'  => array(
				$o( __( 'Yes, against rules or records', 'cypher-one' ), 12, '', __( 'Results can be checked against rules or records.', 'cypher-one' ) ),
				$o( __( 'Partly, informal expert judgement', 'cypher-one' ), 2, __( 'Results need expert review, so testing is harder.', 'cypher-one' ) ),
				$o( __( 'No clear way', 'cypher-one' ), -10, __( 'No clear way to check results.', 'cypher-one' ) ),
			),
		),
		array(
			'question' => __( 'Who would own this AI?', 'cypher-one' ),
			'options'  => array(
				$o( __( 'A named owner with budget', 'cypher-one' ), 12, '', __( 'A named owner with budget.', 'cypher-one' ) ),
				$o( __( 'An interested team, no budget', 'cypher-one' ), -2, __( 'No funded owner yet.', 'cypher-one' ) ),
				$o( __( 'Not decided', 'cypher-one' ), -10, __( 'No owner decided.', 'cypher-one' ) ),
			),
		),
		array(
			'question' => __( 'Does it involve personal or regulated data?', 'cypher-one' ),
			'options'  => array(
				$o( __( 'No', 'cypher-one' ), 5, '', __( 'No personal or regulated data involved.', 'cypher-one' ) ),
				$o( __( 'Yes, with clear policies', 'cypher-one' ), 0, '', __( 'Regulated data, but with clear policies.', 'cypher-one' ) ),
				$o( __( 'Yes, rules unclear', 'cypher-one' ), -8, __( 'Regulated data without clear rules.', 'cypher-one' ) ),
			),
		),
		array(
			'question' => __( 'Are your executives and staff adequately trained for AI?', 'cypher-one' ),
			'options'  => array(
				$o( __( 'Yes, leaders and teams have been trained', 'cypher-one' ), 8, '', __( 'Leaders and teams are ready to run it and question it.', 'cypher-one' ) ),
				$o( __( 'Some, informally', 'cypher-one' ), 0, __( 'Training is patchy, so adoption will be uneven.', 'cypher-one' ) ),
				$o( __( 'No', 'cypher-one' ), -8, __( 'Nobody has been trained to run it or question it.', 'cypher-one' ) ),
			),
		),
	);
}
