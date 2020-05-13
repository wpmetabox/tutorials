<?php
/**
 * Plugin Name: Hotel Management
 * Plugin URI: 
 * Description: Manage hotel bookings.
 * Version: 1.0 
 * Author: Dev WordPress
 * Author URI:  
 * License: GPLv2 or later
 */

class managerBooking {
	public function __construct() {
		// Add extra submenu to the admin panel
		add_action( 'admin_menu', array( $this, 'create_menu_admin_panel' ) );
		add_action( 'wp_ajax_feed_events', array( $this, 'feed_events_func') );
		add_action( 'wp_ajax_nopriv_feed_events', array( $this, 'feed_events_func' ) );
	}
   
	public function create_menu_admin_panel() {
		add_menu_page( 'Manager booking', 'Manager booking', 'edit_posts', 'manager-booking', array($this, 'manager_booking' ) );
	}   
	
	/**
	 * Create Plugin option page
	 */ 
	public function booking_management() {
		if (!current_user_can( 'edit_posts' )) {
			wp_die( __('You do not have sufficient permission to access this page.') );
		}
		
		wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
		wp_enqueue_style( 'fullcalendar-core', plugins_url( 'lib/fullcalendar/packages/core/main.css', __FILE__ ) );
		wp_enqueue_style( 'fullcalendar-daygrid', plugins_url( 'lib/fullcalendar/packages/daygrid/main.css', __FILE__ ) );
		wp_enqueue_style( 'css-custom', plugins_url( 'css/plugin.css', __FILE__ ) );

		wp_enqueue_script('ct-jquery', 'https://code.jquery.com/jquery-3.3.1.js');
		wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'  );
		wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'  );
		wp_enqueue_script( 'fullcalendar-core', plugins_url( 'lib/fullcalendar/packages/core/main.js', __FILE__ ) );
		wp_enqueue_script( 'fullcalendar-daygrid', plugins_url( 'lib/fullcalendar/packages/daygrid/main.js', __FILE__ ) );
		wp_enqueue_script( 'js-custom', plugins_url( 'js/plugin.js', __FILE__ ) );
		wp_localize_script( 'js-custom', 'ajaxurl', admin_url('admin-ajax.php') );
		
		include 'inc/front.php';
	}

	public function feed_events_func(){
			$args = array(
			'post_type' => 'booking',
			'posts_per_page' => -1,
		);

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			wp_die();
		}
		$events = array();
		while( $query->have_posts() ) {  $query->the_post();
			$bookings = get_post_meta( get_the_ID(), 'group_booking', true );
			if ( empty( $bookings ) ) {
				continue;
			}
			foreach ($bookings as $key => $booking) {
				$room = $booking['room'];
				$begin = $booking['check_in']; 
				$end = $booking['check_out']; 

				$e['title'] = "#".get_the_ID().' '.get_the_title($room);
				$e['start'] = $begin;
				$e['end'] =  $end;
				$e['url'] =  get_edit_post_link(get_the_ID(),'');
				$e['classNames'] = 'room-'.$room; 
				$e['allDay'] = true;

				array_push($events, $e);
			}
		}

		echo json_encode($events);
		wp_die();
	}
}

$Data = new managerBooking();
