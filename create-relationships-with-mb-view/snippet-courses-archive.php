add_shortcode( 'instructor_list', function ($atts) {
	extract( shortcode_atts( array(
		   'courseid' =>''
		), $atts));
	ob_start();
	$connected = new WP_Query( [
		'relationship' => [
			'id' 	=>	'instructor-to-course',
			'to'  => $courseid,
		],
		
	]);
	
	$resultstr = array(); 
  	if( $connected->have_posts() ): while ( $connected->have_posts() ) : $connected->the_post();
		 $resultstr[] = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
  	endwhile; endif;	
	echo implode(", ",$resultstr);
  	wp_reset_postdata();
	return ob_get_clean();
} );
