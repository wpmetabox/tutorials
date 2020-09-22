<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Justread
 */

get_header(); ?>
	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-archive-hotel' ); ?>
	</aside><!-- #secondary -->
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'hotel' );

				endwhile;

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->

		<?php the_posts_pagination(); ?>

	</div><!-- #primary -->

<?php

get_footer();
