<?php

/**

 * The template for displaying all single hotel

 *

 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post

 *

 * @package Justread

 */
$rooms = get_post_meta( get_the_ID(), 'group_room', true );
$number = [];
foreach ($rooms as $room) {
	$number[] = (int)$room['so-nguoi'];
}
// var_dump($number,$rooms);
get_header(); ?>

	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-single-hotel' ); ?>
	</aside><!-- #secondary -->

	<div id="primary" class="content-area">

		<main id="main" class="site-main">



		<?php

		while ( have_posts() ) : the_post();



			get_template_part( 'template-parts/content', 'single-hotel' );


			// If comments are open or we have at least one comment, load up the comment template.

			if ( comments_open() || get_comments_number() ) :

				comments_template();

			endif;



		endwhile; // End of the loop.

		?>



		</main><!-- #main -->

	</div><!-- #primary -->



<?php

get_footer();

