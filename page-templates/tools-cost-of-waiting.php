<?php
/**
 * Template Name: Tool: Cost of waiting
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'cost' );
get_header();
?>
<div class="page is-active" id="page-tools-cost-of-waiting">
<?php
get_template_part( 'template-parts/home/calculator' );
get_template_part( 'template-parts/home/close' );
?>
</div>
<?php
get_footer();
