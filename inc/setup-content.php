<?php
/**
 * One-click setup: creates the pages, assigns templates and menus, and fills the
 * SCF fields with the original site content so editors see real text in the dashboard.
 *
 * Runs automatically once after the theme is activated (when SCF is active),
 * and can be re-run from Appearance → Cypher-One setup.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pages the theme needs: key => [title, slug, template, context].
 *
 * @return array
 */
function c1_setup_pages() {
	return array(
		'home'       => array( __( 'Home', 'cypher-one' ), 'home', '', 'home' ),
		'why'        => array( __( 'Why AI fails', 'cypher-one' ), 'why-ai-stalls', 'page-templates/why-ai-stalls.php', 'why' ),
		'approach'   => array( __( 'Our Approach', 'cypher-one' ), 'our-approach', 'page-templates/our-approach.php', 'approach' ),
		'about'      => array( __( 'About', 'cypher-one' ), 'about', 'page-templates/about.php', 'about' ),
		'contact'    => array( __( 'Contact', 'cypher-one' ), 'contact', 'page-templates/contact.php', 'contact' ),
		'privacy'    => array( __( 'Privacy', 'cypher-one' ), 'privacy', 'page-templates/legal.php', 'privacy' ),
		'thanks'     => array( __( 'Thank you', 'cypher-one' ), 'thanks', 'page-templates/thanks.php', 'thanks' ),
		'assessment' => array( __( 'AI Readiness Assessment', 'cypher-one' ), 'assessment', 'page-templates/assessment.php', 'assessment' ),
		'score'      => array( __( 'Score one AI idea', 'cypher-one' ), 'tools-score-an-idea', 'page-templates/tools-score-an-idea.php', 'score' ),
		'cost'       => array( __( 'What is waiting costing you?', 'cypher-one' ), 'tools-cost-of-waiting', 'page-templates/tools-cost-of-waiting.php', 'cost' ),
		'gap'        => array( __( 'The readiness gap', 'cypher-one' ), 'readiness-gap', 'page-templates/readiness-gap.php', 'gap' ),
		'discovery'  => array( __( 'AI Adoption Review', 'cypher-one' ), 'discovery', 'page-templates/discovery.php', 'discovery' ),
		'howwework'  => array( __( 'How we work', 'cypher-one' ), 'how-we-work', 'page-templates/how-we-work.php', 'howwework' ),
	);
}

/**
 * Original browser titles and descriptions for pages that had their own.
 *
 * @return array key => [title, description]
 */
function c1_setup_seo() {
	return array(
		'home'      => array( __( 'Cypher-One — AI delivers real returns when it is built on the right foundation', 'cypher-one' ), '' ),
		'score'     => array( __( 'Score one AI idea | Cypher-One', 'cypher-one' ), __( 'Describe one AI idea and answer six questions to see an indicative likelihood of success, and what would hold it back.', 'cypher-one' ) ),
		'cost'      => array( __( 'What is waiting costing you? | Cypher-One', 'cypher-one' ), __( 'A planning estimate of what manual work costs your team each month, and what the right AI foundation could reclaim.', 'cypher-one' ) ),
		'gap'       => array( __( 'The readiness gap | Cypher-One', 'cypher-one' ), __( 'Why AI potential is growing faster than most organisations are ready for, and what closing the gap involves.', 'cypher-one' ) ),
		'discovery' => array( __( 'What the AI Adoption Review delivers | Cypher-One', 'cypher-one' ), __( 'A comprehensive assessment for AI adoption that ends in a report your board can read and your team can act on.', 'cypher-one' ) ),
		'howwework' => array( __( 'How we work | Cypher-One', 'cypher-one' ), __( 'We look at everything already in place, score every AI idea against the same six questions, and decide what makes sense, in order.', 'cypher-one' ) ),
	);
}

/**
 * Original privacy notice, as blocks.
 *
 * @return string
 */
function c1_privacy_content() {
	$email    = c1_opt( 'contact_email' );
	$sections = array(
		__( 'What this site collects', 'cypher-one' )           => __( 'Nothing automatically. This site sets no cookies, runs no analytics and uses no tracking pixels. If that changes, this page will say so first.', 'cypher-one' ),
		__( 'The assessment and the calculator', 'cypher-one' ) => __( 'The readiness assessment and the cost-of-waiting calculator run in your browser. Your answers and figures are not sent to us unless you choose to share the result with us at the end.', 'cypher-one' ),
		__( 'When you contact us', 'cypher-one' )               => __( 'If you email us or book a conversation, we keep your name, organisation and what you told us so that we can reply and prepare. We do not sell or share it, and we delete it on request.', 'cypher-one' ),
		__( 'Hosting and third parties', 'cypher-one' )         => __( 'Our hosting provider records standard server logs (IP address, pages requested, time) for security and reliability. Photographs are served from Unsplash. Neither receives anything you type here.', 'cypher-one' ),
		/* translators: %s: email link. */
		__( 'Your rights', 'cypher-one' )                       => sprintf( __( "Under Qatar's Personal Data Privacy Protection Law (PDPPL) you can ask what we hold about you, ask us to correct it, or ask us to delete it. Write to %s.", 'cypher-one' ), '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' ),
	);
	$out = '';
	foreach ( $sections as $h => $p ) {
		$out .= "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">" . esc_html( $h ) . "</h3>\n<!-- /wp:heading -->\n\n";
		$out .= "<!-- wp:paragraph -->\n<p>" . wp_kses_post( $p ) . "</p>\n<!-- /wp:paragraph -->\n\n";
	}
	return $out;
}

/**
 * Find the page for a key: by template, by slug, or create it.
 *
 * @param string $key    Page key.
 * @param array  $def    Definition.
 * @param bool   $create Create when missing.
 * @return int
 */
function c1_setup_find_page( $key, $def, $create = true ) {
	list( $title, $slug, $template ) = $def;

	if ( 'home' === $key && 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) && get_post( (int) get_option( 'page_on_front' ) ) ) {
		return (int) get_option( 'page_on_front' );
	}
	if ( $template ) {
		$found = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => array( 'publish', 'draft', 'private' ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'     => $template, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		);
		if ( $found ) {
			return (int) $found[0];
		}
	}
	$by_slug = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $by_slug ) {
		if ( $template ) {
			update_post_meta( $by_slug->ID, '_wp_page_template', $template );
		}
		return (int) $by_slug->ID;
	}
	if ( ! $create ) {
		return 0;
	}
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => 'privacy' === $key ? c1_privacy_content() : '',
			'menu_order'   => array_search( $key, array_keys( c1_setup_pages() ), true ),
		)
	);
	if ( $id && ! is_wp_error( $id ) && $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Import a theme image into the media library once; returns the attachment ID.
 *
 * @param string $rel Theme-relative path.
 * @return int
 */
function c1_setup_import_image( $rel ) {
	$map = get_option( 'c1_imported_media', array() );
	if ( isset( $map[ $rel ] ) && get_post( $map[ $rel ] ) ) {
		return (int) $map[ $rel ];
	}
	$src = C1_DIR . '/' . ltrim( $rel, '/' );
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( basename( $src ) );
	if ( ! $tmp || ! copy( $src, $tmp ) ) {
		return 0;
	}
	$id = media_handle_sideload(
		array(
			'name'     => basename( $src ),
			'tmp_name' => $tmp,
		),
		0
	);
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	$map[ $rel ] = (int) $id;
	update_option( 'c1_imported_media', $map, false );
	return (int) $id;
}

/**
 * Convert schema defaults into values SCF can store (images become attachment IDs).
 *
 * @param array $field Schema field.
 * @param mixed $value Default value.
 * @return mixed
 */
function c1_setup_prepare_value( $field, $value ) {
	if ( 'image' === $field['type'] ) {
		if ( is_string( $value ) && '' !== $value && ! preg_match( '#^(https?:)?//#', $value ) ) {
			return c1_setup_import_image( $value );
		}
		return '';
	}
	if ( 'repeater' === $field['type'] && is_array( $value ) ) {
		$rows = array();
		foreach ( $value as $row ) {
			$clean = array();
			foreach ( $field['sub_fields'] as $sub ) {
				if ( 'tab' === $sub['type'] || 'message' === $sub['type'] ) {
					continue;
				}
				$v                     = isset( $row[ $sub['name'] ] ) ? $row[ $sub['name'] ] : ( 'repeater' === $sub['type'] ? array() : '' );
				$clean[ $sub['name'] ] = c1_setup_prepare_value( $sub, $v );
			}
			$rows[] = $clean;
		}
		return $rows;
	}
	if ( 'true_false' === $field['type'] ) {
		return $value ? 1 : 0;
	}
	return $value;
}

/**
 * Fill a context's fields on a post (or the options page).
 *
 * @param string     $ctx       Context.
 * @param int|string $post_id   Post ID or 'option'.
 * @param bool       $overwrite Replace saved values.
 */
function c1_setup_seed( $ctx, $post_id, $overwrite = false ) {
	$groups = c1_groups();
	if ( empty( $groups[ $ctx ] ) || ! function_exists( 'update_field' ) ) {
		return;
	}
	foreach ( $groups[ $ctx ]['fields'] as $field ) {
		if ( empty( $field['name'] ) || 'tab' === $field['type'] || 'message' === $field['type'] ) {
			continue;
		}
		$exists = ( 'option' === $post_id ) ? null !== get_option( 'options_' . $field['name'], null ) : metadata_exists( 'post', $post_id, $field['name'] );
		if ( $exists && ! $overwrite ) {
			continue;
		}
		update_field( c1_key( $ctx, $field['name'] ), c1_setup_prepare_value( $field, $field['default'] ), $post_id );
	}
}

/**
 * Build a menu for a location from the theme defaults.
 *
 * @param string $location Location.
 * @param string $name     Menu name.
 * @param array  $pages    Page IDs by key.
 */
function c1_setup_menu( $location, $name, $pages ) {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations[ $location ] ) && wp_get_nav_menu_object( $locations[ $location ] ) ) {
		return;
	}
	$menu = wp_get_nav_menu_object( $name );
	$id   = $menu ? $menu->term_id : wp_create_nav_menu( $name );
	if ( is_wp_error( $id ) ) {
		return;
	}
	if ( ! $menu ) {
		$by_url = array_flip( array_map( 'get_permalink', $pages ) );
		foreach ( c1_default_menu( $location ) as $i => $item ) {
			$args = array(
				'menu-item-title'   => $item['title'],
				'menu-item-status'  => 'publish',
				'menu-item-position' => $i + 1,
				'menu-item-classes' => isset( $item['classes'] ) ? implode( ' ', $item['classes'] ) : '',
				'menu-item-target'  => isset( $item['target'] ) ? $item['target'] : '',
			);
			$page_key = isset( $by_url[ $item['url'] ] ) ? $by_url[ $item['url'] ] : null;
			if ( null !== $page_key && 'home' !== $page_key ) {
				$args['menu-item-type']      = 'post_type';
				$args['menu-item-object']    = 'page';
				$args['menu-item-object-id'] = $pages[ $page_key ];
			} else {
				$args['menu-item-type'] = 'custom';
				$args['menu-item-url']  = ( '#top' === $item['url'] ) ? '#top' : $item['url'];
				if ( 'home' === $page_key ) {
					$args['menu-item-url'] = home_url( '/' );
				}
			}
			wp_update_nav_menu_item( $id, 0, $args );
		}
	}
	$locations              = get_nav_menu_locations();
	$locations[ $location ] = $id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Run the setup.
 *
 * @param bool $overwrite Replace existing field values with the originals.
 * @return array Page IDs.
 */
function c1_run_setup( $overwrite = false ) {
	$pages = array();
	foreach ( c1_setup_pages() as $key => $def ) {
		$pages[ $key ] = c1_setup_find_page( $key, $def );
	}

	if ( $pages['home'] ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );
	}
	if ( function_exists( 'update_field' ) ) {
		foreach ( c1_setup_seo() as $key => $seo ) {
			if ( empty( $pages[ $key ] ) ) {
				continue;
			}
			if ( $seo[0] && ( $overwrite || ! metadata_exists( 'post', $pages[ $key ], 'seo_title' ) ) ) {
				update_field( c1_key( 'seo', 'seo_title' ), $seo[0], $pages[ $key ] );
			}
			if ( $seo[1] && ( $overwrite || ! metadata_exists( 'post', $pages[ $key ], 'seo_description' ) ) ) {
				update_field( c1_key( 'seo', 'seo_description' ), $seo[1], $pages[ $key ] );
			}
		}
	}
	if ( $pages['privacy'] ) {
		update_option( 'wp_page_for_privacy_policy', $pages['privacy'] );
	}

	if ( c1_scf_active() ) {
		c1_setup_seed( 'options', 'option', $overwrite );
		foreach ( c1_setup_pages() as $key => $def ) {
			if ( $pages[ $key ] ) {
				c1_setup_seed( $def[3], $pages[ $key ], $overwrite );
			}
		}
		update_option( 'c1_content_seeded', C1_VERSION );
	}

	c1_setup_menu( 'primary', __( 'Main navigation', 'cypher-one' ), $pages );
	c1_setup_menu( 'footer_pages', __( 'Footer: Pages', 'cypher-one' ), $pages );
	c1_setup_menu( 'footer_tools', __( 'Footer: Tools', 'cypher-one' ), $pages );
	c1_setup_menu( 'footer_legal', __( 'Footer: Legal', 'cypher-one' ), $pages );

	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	flush_rewrite_rules();
	update_option( 'c1_setup_done', C1_VERSION );
	if ( c1_scf_active() ) {
		update_option( 'c1_content_version', C1_CONTENT_VERSION );
	}
	return $pages;
}

/**
 * Flag the setup to run on the next admin load (after SCF has initialised).
 */
function c1_flag_setup() {
	update_option( 'c1_needs_setup', 1 );
}
add_action( 'after_switch_theme', 'c1_flag_setup' );

/**
 * Run the pending setup.
 */
function c1_maybe_run_setup() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$needs = get_option( 'c1_needs_setup' );
	// Also fill fields the first time SCF is activated after the theme.
	if ( ! $needs && c1_scf_active() && ! get_option( 'c1_content_seeded' ) && get_option( 'c1_setup_done' ) ) {
		$needs = 1;
	}
	if ( $needs ) {
		delete_option( 'c1_needs_setup' );
		c1_run_setup( false );
	}
}
add_action( 'admin_init', 'c1_maybe_run_setup', 20 );

/**
 * Admin page: Appearance → Cypher-One setup.
 */
function c1_setup_menu_page() {
	add_theme_page(
		__( 'Cypher-One setup', 'cypher-one' ),
		__( 'Cypher-One setup', 'cypher-one' ),
		'edit_theme_options',
		'c1-setup',
		'c1_setup_screen'
	);
}
add_action( 'admin_menu', 'c1_setup_menu_page' );

/**
 * Handle the setup buttons.
 */
function c1_setup_actions() {
	if ( ! isset( $_POST['c1_setup_action'] ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	check_admin_referer( 'c1_setup' );
	$action = sanitize_key( wp_unslash( $_POST['c1_setup_action'] ) );
	if ( 'upgrade' === $action ) {
		c1_upgrade_content();
	} else {
		c1_run_setup( 'reset' === $action );
	}
	wp_safe_redirect( add_query_arg( array( 'page' => 'c1-setup', 'done' => $action ), admin_url( 'themes.php' ) ) );
	exit;
}
add_action( 'admin_init', 'c1_setup_actions' );

/**
 * Render the setup screen.
 */
function c1_setup_screen() {
	$done = isset( $_GET['done'] ) ? sanitize_key( wp_unslash( $_GET['done'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Cypher-One setup', 'cypher-one' ); ?></h1>
		<?php if ( $done ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Done. Pages, menus and content are in place.', 'cypher-one' ); ?></p></div>
		<?php endif; ?>
		<?php if ( ! c1_scf_active() ) : ?>
			<div class="notice notice-warning"><p>
				<?php
				printf(
					/* translators: %s: link to the plugin installer. */
					esc_html__( 'Install and activate the free Secure Custom Fields plugin to edit the content. %s', 'cypher-one' ),
					'<a href="' . esc_url( admin_url( 'plugin-install.php?s=secure%20custom%20fields&tab=search&type=term' ) ) . '">' . esc_html__( 'Find Secure Custom Fields', 'cypher-one' ) . '</a>'
				);
				?>
			</p></div>
		<?php endif; ?>
		<p><?php esc_html_e( 'The setup creates any missing pages (Home, Why AI fails, Our Approach, About, Contact, Privacy, Thank you, the AI Readiness Assessment, Score one idea, Cost of waiting, The readiness gap, AI Adoption Review and How we work), assigns their templates, sets the homepage and privacy page, builds the menus, and fills empty fields with the original content.', 'cypher-one' ); ?></p>
		<h2><?php esc_html_e( 'Pages', 'cypher-one' ); ?></h2>
		<ul>
			<?php foreach ( c1_setup_pages() as $key => $def ) : ?>
				<?php $pid = c1_setup_find_page( $key, $def, false ); ?>
				<li><strong><?php echo esc_html( $def[0] ); ?></strong> —
					<?php if ( $pid ) : ?>
						<a href="<?php echo esc_url( get_edit_post_link( $pid ) ); ?>"><?php esc_html_e( 'Edit', 'cypher-one' ); ?></a> · <a href="<?php echo esc_url( get_permalink( $pid ) ); ?>"><?php esc_html_e( 'View', 'cypher-one' ); ?></a>
					<?php else : ?>
						<em><?php esc_html_e( 'missing', 'cypher-one' ); ?></em>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<form method="post" style="margin-top:24px">
			<?php wp_nonce_field( 'c1_setup' ); ?>
			<button class="button button-primary" name="c1_setup_action" value="run"><?php esc_html_e( 'Run setup (keeps your edits)', 'cypher-one' ); ?></button>
			<button class="button" name="c1_setup_action" value="reset" onclick="return confirm('<?php echo esc_js( __( 'Replace all page content and settings with the original Cypher-One content?', 'cypher-one' ) ); ?>');"><?php esc_html_e( 'Reset content to the original', 'cypher-one' ); ?></button>
		</form>
	</div>
	<?php
}

/**
 * Admin notice when SCF is missing.
 */
function c1_scf_notice() {
	if ( c1_scf_active() || ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-warning"><p>%1$s <a href="%2$s">%3$s</a></p></div>',
		esc_html__( 'The Cypher-One theme uses the free Secure Custom Fields plugin for its editable content. The site shows its original content until it is installed.', 'cypher-one' ),
		esc_url( admin_url( 'plugin-install.php?s=secure%20custom%20fields&tab=search&type=term' ) ),
		esc_html__( 'Install Secure Custom Fields', 'cypher-one' )
	);
}
add_action( 'admin_notices', 'c1_scf_notice' );

/**
 * Bring an existing 1.0 site to the website-new content: new pages are created by the
 * setup; the redesigned pages (Home, Why AI fails, Our Approach) get the new content,
 * the contact form gets the renamed option, and the theme's menus are rebuilt.
 */
function c1_upgrade_content() {
	$pages = c1_run_setup( false );
	if ( c1_scf_active() ) {
		foreach ( array( 'home', 'why', 'approach' ) as $key ) {
			if ( ! empty( $pages[ $key ] ) ) {
				$def = c1_setup_pages();
				c1_setup_seed( $def[ $key ][3], $pages[ $key ], true );
			}
		}
		$groups = c1_groups();
		if ( ! empty( $pages['contact'] ) ) {
			foreach ( $groups['contact']['fields'] as $field ) {
				if ( isset( $field['name'] ) && 'cf_wants' === $field['name'] ) {
					update_field( c1_key( 'contact', 'cf_wants' ), c1_setup_prepare_value( $field, $field['default'] ), $pages['contact'] );
				}
			}
		}
		$desc = c1_field_def( 'options', 'seo_description' );
		update_field( c1_key( 'options', 'seo_description' ), $desc['default'], 'option' );
	}
	if ( ! empty( $pages['why'] ) ) {
		wp_update_post(
			array(
				'ID'         => $pages['why'],
				'post_title' => __( 'Why AI fails', 'cypher-one' ),
			)
		);
	}
	// Rebuild the menus the theme created, so they pick up the new pages and labels.
	foreach ( array( __( 'Main navigation', 'cypher-one' ), __( 'Footer: Pages', 'cypher-one' ), __( 'Footer: Tools', 'cypher-one' ) ) as $name ) {
		$menu = wp_get_nav_menu_object( $name );
		if ( $menu ) {
			wp_delete_nav_menu( $menu->term_id );
		}
	}
	c1_setup_menu( 'primary', __( 'Main navigation', 'cypher-one' ), $pages );
	c1_setup_menu( 'footer_pages', __( 'Footer: Pages', 'cypher-one' ), $pages );
	c1_setup_menu( 'footer_tools', __( 'Footer: Tools', 'cypher-one' ), $pages );
	update_option( 'c1_content_version', C1_CONTENT_VERSION );
}

/**
 * Whether this site was set up with older content.
 *
 * @return bool
 */
function c1_needs_upgrade() {
	return get_option( 'c1_setup_done' ) && c1_scf_active() && version_compare( (string) get_option( 'c1_content_version', '1.0' ), C1_CONTENT_VERSION, '<' );
}

/**
 * Notice offering the content upgrade.
 */
function c1_upgrade_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) || ! c1_needs_upgrade() ) {
		return;
	}
	?>
	<div class="notice notice-info">
		<p><strong><?php esc_html_e( 'Cypher-One: new website content is available.', 'cypher-one' ); ?></strong>
		<?php esc_html_e( 'This version adds the new Home page, Why AI fails, Our Approach, five new pages (Score one idea, Cost of waiting, The readiness gap, AI Adoption Review, How we work) and the new AI Readiness Assessment. Updating replaces the content of Home, Why AI fails and Our Approach, and rebuilds the theme menus. Other pages keep your edits.', 'cypher-one' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'themes.php?page=c1-setup' ) ); ?>" style="margin:0 0 10px">
			<?php wp_nonce_field( 'c1_setup' ); ?>
			<button class="button button-primary" name="c1_setup_action" value="upgrade"><?php esc_html_e( 'Update content now', 'cypher-one' ); ?></button>
		</form>
	</div>
	<?php
}
add_action( 'admin_notices', 'c1_upgrade_notice' );
