<?php
require __DIR__ . '/vendor/autoload.php';
new EStar\Loader;


add_action('save_post_booking', function ($post_id) {
	if (wp_is_post_revision($post_id) || defined('DOING_AUTOSAVE')) return;

	$post = get_post($post_id);
	if ($post->post_title !== "#$post_id" || $post->post_name !== (string)$post_id) {
		wp_update_post([
			'ID'         => $post_id,
			'post_title' => "#$post_id",
			'post_name'  => $post_id,
		]);
	}

	update_post_meta($post_id, 'order_number', $post_id);
}, 20);


function add_admin_scripts($hook)
{
	$screen = get_current_screen();
	if ($hook == 'post-new.php' || $hook == 'post.php') {
		if (isset($screen->post_type) && 'booking' === $screen->post_type) {
			wp_register_script('booking-js', get_stylesheet_directory_uri() . '/js/booking.js');

			// Passing AJAX Data into JavaScript
			$ajax_data = array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('booking_nonce')
			);
			wp_localize_script('booking-js', 'booking_ajax', $ajax_data);

			// Passing room data into JavaScript
			$rooms = get_posts([
				'post_type'      => 'room',
				'posts_per_page' => -1
			]);
			$arr_rooms = [];
			foreach ($rooms as $room) {
				$disabled_dates = dates_disable($room->ID);
				$arr_rooms[] = [
					'id'    => $room->ID,
					'price' => rwmb_get_value('price', '', $room->ID),
					'disabled_dates' => $disabled_dates
				];
			}
			wp_localize_script('booking-js', 'rooms_data', $arr_rooms);

			wp_enqueue_script('booking-js');
		}
	}
}
add_action('admin_enqueue_scripts', 'add_admin_scripts');


function dates_disable($room_id)
{
	error_log("Checking dates_disable for room_id: " . $room_id);

	$args = [
		'post_type'      => 'booking',
		'post_status'    => ['publish', 'pending', 'draft'],
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'booking_status',
				'value' => 'cancelled',
				'compare' => '!='
			)
		)
	];

	$bookings = get_posts($args);
	$all_booked_dates = [];

	// Get date from existing bookings
	foreach ($bookings as $booking) {
		$booking_data = get_post_meta($booking->ID, 'group_booking', true);
		error_log("Checking booking ID: " . $booking->ID);
		error_log("Booking data: " . print_r($booking_data, true));

		if (!is_array($booking_data)) continue;

		foreach ($booking_data as $item) {
			if (!isset($item['room'][0], $item['check_in'], $item['check_out'])) continue;

			$booked_room_id = (string)$item['room'][0];

			// Get only the date of the requested room
			if ($booked_room_id !== (string)$room_id) continue;

			$check_in = new DateTime($item['check_in']);
			$check_out = new DateTime($item['check_out']);
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($check_in, $interval, $check_out);

			foreach ($daterange as $date) {
				$all_booked_dates[] = $date->format("Y-m-d");
			}
		}
	}

	// Remove duplicate dates
	$all_booked_dates = array_unique($all_booked_dates);
	sort($all_booked_dates);

	error_log("Final disabled dates for room " . $room_id . ": " . implode(", ", $all_booked_dates));
	return $all_booked_dates;
}


add_action('wp_ajax_get_disabled_dates', 'get_disabled_dates_callback');
function get_disabled_dates_callback()
{
	if (!isset($_POST['room_id'])) {
		wp_send_json_error('Missing room_id');
	}

	$room_id = intval($_POST['room_id']);
	error_log("AJAX request for room_id: " . $room_id);

	$disabled_dates = dates_disable($room_id);
	wp_send_json_success(['disabled_dates' => implode(',', $disabled_dates)]);
}