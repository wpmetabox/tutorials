<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Justread
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div class="footer-widgets grid grid--4">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div>
		<?php endif; ?>

		<div class="site-info">
			<?php
			$footer = rwmb_meta( 'footer_text', ['object_type' => 'setting'], 'theme_mods_justread' );
			if ( $footer ) :
				echo $footer;			
			else : ?>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'justread' ) ); ?>">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'justread' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
				<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %1$s by %2$s.', 'justread' ), 'Justread', '<a href="https://gretathemes.com">GretaThemes</a>' );
				?>
			<?php endif; ?>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
