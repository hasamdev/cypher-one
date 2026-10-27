<?php
/**
 * Template Name: AI Adoption Review
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'discovery' );
get_header();
?>
<div class="page is-active" id="page-discovery">
<?php
get_template_part( 'template-parts/home/report' );
get_template_part( 'template-parts/home/close' );
?>
</div>
<?php
get_footer();
