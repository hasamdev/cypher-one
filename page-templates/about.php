<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

c1_ctx( 'about' );
get_header();
$c1_email = c1_opt( 'contact_email' );
?>
<div class="page is-active" id="page-about">
<?php c1_page_intro( 'about', __( 'Page introduction', 'cypher-one' ) ); ?>

<section class="t-light" id="who-we-are" aria-labelledby="team-title">
  <div class="wrap">
    <div class="head-row">
      <div class="stack"><?php c1_section_head( 'team_eyebrow', 'team_title', 'team-title' ); ?></div>
      <p class="lede"><?php c1_e( 'team_lede' ); ?></p>
    </div>
    <div class="team-grid">
      <?php foreach ( (array) c1_f( 'team_members' ) as $c1_row ) : ?>
        <?php $c1_photo = c1_img_url( $c1_row['photo'], 'large' ); ?>
      <article class="tm"><div class="tm-photo"><?php if ( $c1_photo ) : ?><img src="<?php echo esc_url( $c1_photo ); ?>" alt="<?php echo esc_attr( $c1_row['name'] ); ?>" loading="lazy"><?php endif; ?></div><div class="tm-body"><h3><?php echo esc_html( $c1_row['name'] ); ?></h3><p class="tm-role"><?php echo esc_html( $c1_row['role'] ); ?></p><p class="bio"><?php echo esc_html( $c1_row['bio'] ); ?></p></div></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="band t-dark" id="close-full" aria-labelledby="close-full-title">
  <div class="wrap">
    <div class="close-grid"<?php echo c1_f( 'close_show_meta' ) ? '' : ' style="grid-template-columns:1fr"'; ?>>
      <div class="stack">
        <?php c1_section_head( 'close_eyebrow', 'close_title', 'close-full-title' ); ?>
        <p class="lede"><?php c1_e( 'close_lede' ); ?></p>
        <div class="row"><?php c1_button( 'close_btn1_label', 'close_btn1_link' ); ?><?php c1_button( 'close_btn2_label', 'close_btn2_link', 'btn btn-ghost' ); ?></div>
      </div>
      <?php if ( c1_f( 'close_show_meta' ) ) : ?>
      <dl class="contact-meta">
        <?php if ( $c1_email ) : ?><div><dt><?php c1_e( 'close_meta_email' ); ?></dt><dd><a href="<?php echo esc_url( 'mailto:' . antispambot( $c1_email ) ); ?>"><?php echo esc_html( antispambot( $c1_email ) ); ?></a></dd></div><?php endif; ?>
        <div><dt><?php c1_e( 'close_meta_response' ); ?></dt><dd><?php echo esc_html( c1_opt( 'contact_response' ) ); ?></dd></div>
        <div><dt><?php c1_e( 'close_meta_based' ); ?></dt><dd><?php echo esc_html( c1_opt( 'contact_based' ) ); ?></dd></div>
      </dl>
      <?php endif; ?>
    </div>
  </div>
</section>
</div>
<?php
get_footer();
