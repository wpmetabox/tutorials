<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Justread
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<header class="page-header">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'justread' ), '<span>' . get_search_query() . '</span>' );
			?>
		</header><!-- .page-header -->

		<main id="main" class="site-main grid grid--3">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );

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
