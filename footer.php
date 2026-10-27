<?php
/**
 * Site footer.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_email   = c1_opt( 'contact_email' );
$c1_socials = c1_opt( 'social' );
?>
</main>

<footer class="site" aria-label="<?php esc_attr_e( 'Site footer', 'cypher-one' ); ?>">
  <div class="wrap">
    <div class="footer-grid">
      <div class="footer-about">
        <?php c1_logo( '#top' ); ?>
        <p><?php echo esc_html( c1_opt( 'footer_about' ) ); ?></p>
        <?php if ( ! empty( $c1_socials ) ) : ?>
        <ul class="social" aria-label="<?php esc_attr_e( 'Social media', 'cypher-one' ); ?>">
          <?php foreach ( $c1_socials as $c1_social ) : ?>
            <?php
            if ( empty( $c1_social['url'] ) ) {
				continue;
            }
            $c1_icon = ( isset( $c1_social['icon'] ) && 'email' === $c1_social['icon'] ) ? 'icon-email' : 'icon-linkedin';
            ?>
          <li><a href="<?php echo esc_url( $c1_social['url'] ); ?>" aria-label="<?php echo esc_attr( $c1_social['label'] ); ?>"<?php echo 0 === strpos( $c1_social['url'], 'mailto:' ) ? '' : ' rel="noopener"'; ?>><?php echo c1_svg( $c1_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme SVG file. ?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
      <div>
        <h5><?php echo esc_html( c1_opt( 'footer_pages_heading' ) ); ?></h5><ul><?php c1_menu( 'footer_pages', true ); ?></ul>
      </div>
      <div>
        <h5><?php echo esc_html( c1_opt( 'footer_tools_heading' ) ); ?></h5><ul><?php c1_menu( 'footer_tools', true ); ?></ul>
      </div>
      <div>
        <h5><?php echo esc_html( c1_opt( 'footer_contact_heading' ) ); ?></h5>
        <address style="font-style:normal"><ul>
          <?php if ( $c1_email ) : ?>
          <li><a href="<?php echo esc_url( 'mailto:' . antispambot( $c1_email ) ); ?>"><?php echo esc_html( antispambot( $c1_email ) ); ?></a></li>
          <?php endif; ?>
          <li><?php echo esc_html( c1_opt( 'contact_response_long' ) ); ?></li>
          <li><?php echo esc_html( c1_opt( 'contact_location' ) ); ?></li>
        </ul></address>
      </div>
    </div>
    <div class="legal">
      <p>
      <?php
		printf(
			/* translators: 1: copyright holder, 2: year, 3: "All rights reserved." */
			esc_html__( '© %1$s %2$s. %3$s', 'cypher-one' ),
			esc_html( c1_opt( 'footer_copyright' ) ),
			'<span data-year>' . esc_html( wp_date( 'Y' ) ) . '</span>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_html( c1_opt( 'footer_rights' ) )
		);
		$c1_note = c1_opt( 'footer_note' );
		if ( $c1_note ) {
			echo ' &nbsp;·&nbsp; ' . esc_html( $c1_note );
		}
		?>
      </p>
      <ul><?php c1_menu( 'footer_legal', true ); ?></ul>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
