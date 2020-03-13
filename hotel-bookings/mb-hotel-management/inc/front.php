<div class="wrap">
	
	<h1 class="wp-heading-inline mb-4">Manager Booking</h1>

	<div class="navbar mb-4">
		<?php 
		$args = array(
		    'post_type' => 'room',
		    'posts_per_page' => -1,
		    'post__not_in' => array(498)
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

		    $events = array();

		    echo '<button class="button filter-bookings" data-room="all">ALL</button>';

		    while( $query->have_posts() ) {  $query->the_post(); ?>

				<button class="button filter-bookings" data-room="<?php the_ID(); ?>"><?php the_title(); ?></button>

			<?php }
		} ?>
	</div>

	<div id='calendar'>
		
	</div>

</div>


