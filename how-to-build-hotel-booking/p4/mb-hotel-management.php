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

class managerBooking
{
	public function __construct()
	{
		// Add extra submenu to the admin panel
		add_action('admin_menu', array($this, 'create_menu_admin_panel'));
		add_action('wp_ajax_feed_events', array($this, 'feed_events_func'));
		add_action('wp_ajax_nopriv_feed_events', array($this, 'feed_events_func'));
	}

	public function create_menu_admin_panel()
	{
		add_menu_page('Manager booking', 'Manager booking', 'edit_posts', 'manager-booking', array($this, 'booking_management'));
	}

	/**
	 * Create Plugin option page
	 */
	public function booking_management()
	{
		if (!current_user_can('edit_posts')) {
			wp_die(__('You do not have sufficient permission to access this page.'));
		}

		wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
		wp_enqueue_style('fullcalendar-core', plugins_url('lib/fullcalendar/packages/core/main.min.css', __FILE__));
		wp_enqueue_style('fullcalendar-daygrid', plugins_url('lib/fullcalendar/packages/daygrid/main.min.css', __FILE__));
		wp_enqueue_style('css-custom', plugins_url('css/plugin.css', __FILE__));

		wp_enqueue_script('ct-jquery', 'https://code.jquery.com/jquery-3.3.1.js');
		wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
		wp_enqueue_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
		wp_enqueue_script('fullcalendar-core', plugins_url('lib/fullcalendar/packages/core/main.min.js', __FILE__));
		wp_enqueue_script('fullcalendar-daygrid', plugins_url('lib/fullcalendar/packages/daygrid/main.min.js', __FILE__));
		wp_enqueue_script('js-custom', plugins_url('js/plugin.js', __FILE__));
		wp_localize_script('js-custom', 'ajax_object', ['ajaxurl' => admin_url('admin-ajax.php')]);

		include 'inc/front.php';
	}

	public function feed_events_func()
	{
		$args = array(
			'post_type' => 'booking',
			'posts_per_page' => 5,
		);

		$query = new WP_Query($args);

		if (! $query->have_posts()) {
			wp_die();
		}

		$events = array();
		while ($query->have_posts()) {
			$query->the_post();
			$booking_id = get_the_ID();

			// get data booking
			$group_booking = get_post_meta($booking_id, 'group_booking', true);

			if (empty($group_booking) || !is_array($group_booking)) {
				continue;
			}

			foreach ($group_booking as $booking) {
				if (!isset($booking['room'], $booking['check_in'], $booking['check_out'])) {
					continue;
				}

				$rooms = array();
				if (is_array($booking['room'])) {
					// If room is an array, get all rooms
					foreach ($booking['room'] as $room) {
						if (is_array($room)) {
							$rooms = array_merge($rooms, $room);
						} else {
							$rooms[] = $room;
						}
					}
				} else {
					$rooms[] = $booking['room'];
				}

				// Create class string for all rooms
				$room_classes = array();
				foreach ($rooms as $room_id) {
					$room_classes[] = 'room-' . $room_id;
				}
				$classNames = implode(' ', $room_classes);

				$e['title'] = "#" . $booking_id . ' ' . get_the_title($rooms[0]);
				$e['start'] = $booking['check_in'];
				$e['end'] = $booking['check_out'];
				$e['url'] = get_edit_post_link($booking_id, '');
				$e['classNames'] = $classNames;
				$e['allDay'] = true;

				array_push($events, $e);
			}
		}

		wp_reset_postdata();
		wp_send_json_success($events);
	}
}

$Data = new managerBooking();
