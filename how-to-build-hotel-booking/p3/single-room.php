<?php get_header(); ?>
<main class="main" role="main">
	<?php
	while (have_posts()) {
		the_post();
		get_template_part('template-parts/content/post');

		echo  do_shortcode('[mb_frontend_form id="booking-fields"]');
	}
	?>
</main>
<?php get_footer(); ?>