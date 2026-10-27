<?php
/**
 * Template Name: The readiness gap
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'gap' );
get_header();
?>
<div class="page is-active" id="page-readiness-gap">
<?php
get_template_part( 'template-parts/home/gap' );
get_template_part( 'template-parts/home/close' );
?>
</div>
<?php
get_footer();
