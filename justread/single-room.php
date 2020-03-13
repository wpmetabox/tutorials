<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Justread
 */

get_header(); ?>

<script>
	console.log(ajaxurl);
</script>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php

		while ( have_posts() ) : the_post();
			$date = '01/28/2020';
			echo date("Y-m-d", strtotime($date) );
			get_template_part( 'template-parts/content', 'single' );
			
			the_post_navigation();

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
