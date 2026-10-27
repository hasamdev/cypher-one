<?php
/**
 * Template Name: How we work
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'howwework' );
get_header();
?>
<div class="page is-active" id="page-how-we-work">
<?php
get_template_part( 'template-parts/home/integrated' );
get_template_part( 'template-parts/home/scorecard' );
get_template_part( 'template-parts/home/close' );
?>
</div>
<?php
get_footer();
