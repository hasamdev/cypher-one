<?php
/**
 * Template Name: Tool: Score one idea
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'score' );
get_header();
?>
<div class="page is-active" id="page-tools-score-an-idea">
<?php
get_template_part( 'template-parts/home/assess' );
get_template_part( 'template-parts/home/close' );
?>
</div>
<?php
get_footer();
