<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Justread
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found tc mh3">
				<header>
					<h1><?php esc_html_e( 'Not found.', 'justread' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'justread' ); ?></p>
					<p class="f5"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( '&larr; Back to home', 'justread' ); ?></a></p>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
