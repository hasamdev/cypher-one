<?php
/**
 * Cypher-One theme bootstrap.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

define( 'C1_VERSION', '1.2.1' );
define( 'C1_CONTENT_VERSION', '1.2.2' );
define( 'C1_DIR', get_template_directory() );
define( 'C1_URI', get_template_directory_uri() );

$c1_includes = array(
	'inc/setup.php',
	'inc/schema.php',
	'inc/template-functions.php',
	'inc/enqueue.php',
	'inc/seo.php',
	'inc/contact-form.php',
	'inc/assessment.php',
	'inc/setup-content.php',
);

foreach ( $c1_includes as $c1_file ) {
	require_once C1_DIR . '/' . $c1_file;
}
unset( $c1_includes, $c1_file );
