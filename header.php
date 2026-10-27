<?php
/**
 * Site header.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body id="top" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to main content', 'cypher-one' ); ?></a>

<header class="site">
  <div class="wrap">
    <?php c1_logo( home_url( '/' ) ); ?>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav"><span class="bars" aria-hidden="true"><i></i><i></i><i></i></span><?php esc_html_e( 'Menu', 'cypher-one' ); ?></button>
    <nav class="main" id="site-nav" aria-label="<?php esc_attr_e( 'Main', 'cypher-one' ); ?>"><?php c1_menu( 'primary' ); ?>
    </nav>
  </div>
</header>

<main id="main">
