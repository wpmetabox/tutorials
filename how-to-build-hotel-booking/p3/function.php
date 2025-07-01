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


function enqueue_scripts()
{
	// Register and enqueue script
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('booking-js', get_template_directory_uri() . '/js/booking.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);

	// Pass data into JavaScript using wp_add_inline_script()
	$ajax_data = array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('booking_nonce')
	);

	$inline_script = 'var booking_ajax = ' . wp_json_encode($ajax_data) . ';';
	wp_add_inline_script('booking-js', $inline_script, 'before');

	// Passing room data into JavaScript
	$rooms = get_posts(array(
		'post_type' => 'room',
		'posts_per_page' => -1,
	));

	$rooms_data = array();
	foreach ($rooms as $room) {
		// Get room rates from Meta Box
		$room_price = rwmb_get_value('price', array(), $room->ID);
		if (!$room_price) {
			$room_price = 0;
		}

		$rooms_data[] = array(
			'id' => $room->ID,
			'title' => $room->post_title,
			'price' => $room_price
		);
	}

	$rooms_script = 'var rooms_data = ' . wp_json_encode($rooms_data) . ';';
	wp_add_inline_script('booking-js', $rooms_script, 'before');

	// Pass current_room_id if available
	$current_room_id = get_the_ID();
	if ($current_room_id) {
		$current_room_script = 'var current_room_id = ' . wp_json_encode($current_room_id) . ';';
		wp_add_inline_script('booking-js', $current_room_script, 'before');
	}
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

// Function to get all days between 2 dates
function get_dates_between($start_date, $end_date)
{
	$dates = array();
	$current = strtotime($start_date);
	$end = strtotime($end_date);

	while ($current <= $end) {
		$dates[] = date('Y-m-d', $current);
		$current = strtotime('+1 day', $current);
	}

	return $dates;
}

add_filter('rwmb_frontend_validate', function ($validate, $config) {
	if ('booking-fields' !== $config['id']) {
		return $validate;
	}

	// Get all selected rooms in the form
	$selected_rooms = array();
	if (isset($_POST['group_booking']) && is_array($_POST['group_booking'])) {
		foreach ($_POST['group_booking'] as $index => $room) {
			if (empty($room['room']) || empty($room['check_in']) || empty($room['check_out'])) {
				continue;
			}
			// Make sure room_id is an integer
			$room_id = is_array($room['room']) ? $room['room'][0] : $room['room'];
			$selected_rooms[] = array(
				'room_id' => (int)$room_id,
				'check_in' => date("Y-m-d", strtotime($room['check_in'])),
				'check_out' => date("Y-m-d", strtotime($room['check_out']))
			);
		}
	}

	// Check each selected room
	foreach ($selected_rooms as $room) {
		$room_id = $room['room_id'];
		$check_in = $room['check_in'];
		$check_out = $room['check_out'];

		// Get a list of disabled days for this room
		$disabled_dates = dates_disable($room_id);

		// Check check-in date
		if (in_array($check_in, $disabled_dates)) {
			$validate = false;
			break;
		}

		// Check check-out date
		if (in_array($check_out, $disabled_dates)) {
			$validate = false;
			break;
		}

		// Check the days between check-in and check-out
		$dates = get_dates_between($check_in, $check_out);
		foreach ($dates as $date) {
			if (in_array($date, $disabled_dates)) {
				$validate = false;
				break 2;
			}
		}
	}

	return $validate;
}, 10, 2);
