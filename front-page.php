<?php
/**
 * Home page.
 *
 * Every section is edited under Pages → Home (the page set as the homepage).
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'home' );
get_header();
?>
<div class="page is-active" id="page-home">
<?php
get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/gap-lean' );
get_template_part( 'template-parts/home/alone' );
get_template_part( 'template-parts/home/calculator', null, array( 'class' => 't-light' ) );
get_template_part( 'template-parts/home/governance' );
get_template_part( 'template-parts/home/assess', null, array( 'variant' => 'lean', 'class' => 't-light' ) );
get_template_part( 'template-parts/home/review' );
?>
</div>
<?php
get_footer();
