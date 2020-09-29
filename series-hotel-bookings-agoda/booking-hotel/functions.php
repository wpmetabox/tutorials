<?php
/**
 * Just Read functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Justread
 */



/**
 * Enqueue scripts and styles.
 */
function justread_child_scripts() {
	$parenthandle = 'justread-style';
	$theme = wp_get_theme();
	wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
		array(),
		$theme->parent()->get('Version')
	);
	wp_enqueue_style( 'justread-child-style', get_stylesheet_directory_uri() . '/style.css' );

	if ( is_singular( 'hotel' ) ) {
		wp_enqueue_script( 'justread-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), '1.8.1', true );
		wp_enqueue_script( 'justread-magnific', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array(), '1.1.0', true );


		wp_enqueue_style( 'justread-slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array(), '1.8.1' );
		wp_enqueue_style( 'justread-slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), '1.8.1' );
		wp_enqueue_style( 'justread-magnific-css', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', array(), '1.1.0' );
	}
	wp_enqueue_style( 'fruits-datepicker', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
}
add_action( 'wp_enqueue_scripts', 'justread_child_scripts' );




/**
 * Thêm Filter trang archive hotel.
 */
function justread_child_custom_scripts() {
	$terms = get_terms( array(
		'taxonomy'   => 'location',
		'hide_empty' => false,
	) );
	foreach ( $terms as $term ) {
		$location[] = $term->name;
	}
	$object = [
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'location_autocomplete' => $location,
	];

	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_enqueue_script( 'justread-ajax-filter-hotel', get_stylesheet_directory_uri() . '/js/filter-hotel.js', array( 'jquery' ), '', true );
	wp_localize_script( 'justread-ajax-filter-hotel', 'ajax_object', $object );
}
add_action( 'wp_enqueue_scripts', 'justread_child_custom_scripts' );

function justread_filter_hotel() {
	$location        = isset( $_POST['location'] ) ? $_POST['location'] : '';
	$rate            = isset( $_POST['rate'] ) ? $_POST['rate'] : '';
	$hotel_type      = isset( $_POST['hotel_type'] ) ? $_POST['hotel_type'] : '';
	$facilities      = isset( $_POST['facilities'] ) ? $_POST['facilities'] : '';
	$room_facilities = isset( $_POST['room_facilities'] ) ? $_POST['room_facilities'] : '';
	$min_price       = isset( $_POST['min_price'] ) ? $_POST['min_price'] : '';
	$max_price       = isset( $_POST['max_price'] ) ? $_POST['max_price'] : '';
	$adults          = isset( $_POST['adults'] ) ? $_POST['adults'] : '';
	$children        = isset( $_POST['children'] ) ? $_POST['children'] : '';

	$rate_array = array(
		'taxonomy' => 'rate',
		'field'    => 'name',
		'terms'    => $rate,
		'operator' => 'IN',
	);
	$rate_array = $rate ? $rate_array : '';

	$location_array = array(
		'taxonomy' => 'location',
		'field'    => 'name',
		'terms'    => array( $location ),
		'operator' => 'IN',
	);
	$location_array = $location ? $location_array : '';

	$hotel_type_array = array(
		'key'     => 'hotel_type',
		'value'   => $hotel_type,
		'compare' => 'IN',
	);
	$hotel_type_array = $hotel_type ? $hotel_type_array : '';

	$facilities_array = array(
		'key'     => 'facilities',
		'value'   => $facilities,
		'compare' => 'IN',
	);
	$facilities_array = $facilities ? $facilities_array : '';

	$room_facilities_array = array(
		'key'     => 'room_facilities',
		'value'   => $room_facilities,
		'compare' => 'IN',
	);
	$room_facilities_array = $room_facilities ? $room_facilities_array : '';


	$price_array = array(
		'key'     => 'price_p',
		'value'   => array( $min_price, $max_price ),
		'compare' => 'BETWEEN',
		'type'    => 'NUMERIC',
	);
	$price_array = $max_price ? $price_array : '';

	$adults_array  = array(
		'key'     => 'adults',
		'value'   => $adults,
		'type'    => 'NUMERIC',
		'compare' => '>=',
	);
	$adults_array = $adults ? $adults_array : '';

	$children_array  = array(
		'key'     => 'children',
		'value'   => $children,
		'type'    => 'NUMERIC',
		'compare' => '>=',
	);
	$children_array = $children ? $children_array : '';

	$query_arr = array(
		'post_type' => 'hotel',
		'post_status' => 'publish',
		// 'meta_key' => 'location_hotel',
		// 'meta_value' => $location,
		// 'meta_compare' => 'LIKE',
		'tax_query' => array(
			'relation' => 'AND',
			$rate_array,
			$location_array,
		),
		'meta_query' => array(
			'relation' => 'AND',
			$adults_array,
			$hotel_type_array,
			$facilities_array,
			$room_facilities_array,
			$price_array,
		),
	);
	$query = new WP_Query( $query_arr );

	if ( $query->have_posts() ) :
		ob_start();
		while ( $query->have_posts() ) : $query->the_post();
			get_template_part( 'template-parts/content', 'hotel' );
		endwhile;
		$posts = ob_get_clean();
	else :
		$posts = '<h1>' . __( 'No post', 'justread' ) .'</h1>';
	endif;


	$return = array(
		'post' => $posts,
		'test' => $location,
	);
	wp_send_json( $return );
}
add_action( 'wp_ajax_justread_filter_hotel', 'justread_filter_hotel' );
add_action( 'wp_ajax_nopriv_justread_filter_hotel', 'justread_filter_hotel' );


function justread_filter_main_hotel( $query ) {
	if ( is_post_type_archive( 'hotel' ) ) {
		$new_location = [
			'taxonomy' => 'location',
			'field'    => 'name',
			'terms'    => array( $_GET['new_location'] ),
			'operator' => 'IN',
		];
		$new_location = $_GET['new_location'] ? $new_location : '';

		$taxquery = [
			'relation' => 'AND',
			$new_location,
		];
		$query->set( 'tax_query', $taxquery );
	}
}
add_action( 'pre_get_posts', 'justread_filter_main_hotel' );

// Add các field ở group ra 1 field riêng.
function justread_add_field_group( $post_id ) {
	$rooms = get_post_meta( $post_id, 'group_room', true );
	delete_post_meta( $post_id, 'price_p' );
	delete_post_meta( $post_id, 'adults' );
	delete_post_meta( $post_id, 'children' );
	delete_post_meta( $post_id, 'room_facilities' );
	foreach ($rooms as $key => $room) {
		add_post_meta( $post_id, 'price_p', (int)$room['price'] );
		add_post_meta( $post_id, 'adults', (int)$room['adults'] );
		add_post_meta( $post_id, 'children', (int)$room['children'] );
		foreach ( $room['room_facilities'] as $key => $facilities ) {
			add_post_meta( $post_id, 'room_facilities', $facilities );
		}
	}
}
add_action( 'rwmb_field-for-hotel_after_save_post', 'justread_add_field_group' );



/**
 * Shortcode thêm filter ở widget.
 */
function justread_shortcode_main_filter() {
	ob_start();
	?>

	<div class="filter-hotel">
		<p>Search Hotel</p>
		<input class="filter-input" id="location" type="" name="" placeholder="Destination">
		<input class="filter-input check-in-date" id="check-in-date" type="" name="" placeholder="Check-in date">
		<input class="filter-input check-out-date" id="check-out-date" type="" name="" placeholder="Check-out date">
		<input style="width: 48%; float: left;" class="filter-input" id="adults" type="" name="" placeholder="Adults">
		<input style="width: 48%; float: right;" class="filter-input" id="children" type="" name="" placeholder="Children">
		<input class="filter-action" type="submit" name="" value="Search">
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_main_filter', 'justread_shortcode_main_filter' );

function justread_shortcode_rate_hotel() {
	ob_start();
	$terms = get_terms( array(
		'taxonomy'   => 'rate',
		'hide_empty' => false,
	) );
	foreach ( $terms as $term ) {
		// var_dump($term);
		echo '<a class="filter-sidebar filter-checkbox" data-rate-value="' . $term->name . '">
				<input class="filter-checkbox__input" type="checkbox" name="filter-rate" value="' . $term->name . '">
				<div class="filter-checkbox__label">
					<span class="filter_label">' . $term->name . '</span>
					<span class="filter_count">(' . $term->count . ')</span>
				</div>
			  </a>';
	}
	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_rate_hotel', 'justread_shortcode_rate_hotel' );



function justread_shortcode_hotel_type() {
	ob_start();
	?>

	<a class="filter-sidebar filter-hotel-type" data-hotel-type-value="hotel">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Hotel</span>
		</div>
	</a>
	<a class="filter-sidebar filter-hotel-type" data-hotel-type-value="apartment">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Apartment</span>
		</div>
	</a>
	<a class="filter-sidebar filter-hotel-type" data-hotel-type-value="homestay">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Homestay</span>
		</div>
	</a>
	<a class="filter-sidebar filter-hotel-type" data-hotel-type-value="villa">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Villa</span>
		</div>
	</a>
	<a class="filter-sidebar filter-hotel-type" data-hotel-type-value="resort">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Resort</span>
		</div>
	</a>
	<a class="filter-sidebar filter-hotel-type" data-hotel-type-value="motel">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Motel</span>
		</div>
	</a>
	<?php

	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_hotel_type', 'justread_shortcode_hotel_type' );

function justread_shortcode_facilities() {
	ob_start();
	?>

	<a class="filter-sidebar filter-facilities" data-facilities-value="parking">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Parking</span>
		</div>
	</a>
	<a class="filter-sidebar filter-facilities" data-facilities-value="retaurant">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Restaurant</span>
		</div>
	</a>
	<a class="filter-sidebar filter-facilities" data-facilities-value="wi-fi">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Free wifi</span>
		</div>
	</a>
	<a class="filter-sidebar filter-facilities" data-facilities-value="swimming-pool">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Swimming pool</span>
		</div>
	</a>
	<a class="filter-sidebar filter-facilities" data-facilities-value="family-room">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Family room</span>
		</div>
	</a>
	<a class="filter-sidebar filter-facilities" data-facilities-value="bus-from-airport">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Bus from airport</span>
		</div>
	</a>
	<a class="filter-sidebar filter-facilities" data-facilities-value="elevator">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Elevator</span>
		</div>
	</a>

	<?php
	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_facilities', 'justread_shortcode_facilities' );

function justread_shortcode_room_facilities() {
	ob_start();
	?>

	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="kitchen">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Kitchen</span>
		</div>
	</a>
	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="bathroom">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Bathroom</span>
		</div>
	</a>
	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="air-conditioning">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Air conditioning</span>
		</div>
	</a>
	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="toilet">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Toilet</span>
		</div>
	</a>
	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="tv">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">TV</span>
		</div>
	</a>
	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="balcony">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Balcony</span>
		</div>
	</a>
	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="washing-machine">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Washing machine</span>
		</div>
	</a>
	<a class="filter-sidebar filter-room-facilities" data-room-facilities-value="sea-view">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Sea view</span>
		</div>
	</a>

	<?php
	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_room_facilities', 'justread_shortcode_room_facilities' );

function justread_shortcode_hotel_price() {
	ob_start();
	?>

	<a class="filter-sidebar filter-price" data-min-price="0" data-max-price="50">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Under 50$</span>
		</div>
	</a>
	<a class="filter-sidebar filter-price" data-min-price="50" data-max-price="100">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">From 50$ to 100$</span>
		</div>
	</a>
	<a class="filter-sidebar filter-price" data-min-price="100" data-max-price="200">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">From 100$ to 200$</span>
		</div>
	</a>
	<?php

	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_hotel_price', 'justread_shortcode_hotel_price' );


/**
 * Lấy danh sách phòng đã book theo ngày search trong file json.
 */
function justread_get_room_unavailability( $get_hotel_id, $room_key ) {
	$booking_data = json_decode( file_get_contents( get_stylesheet_directory_uri() . '/js/booking-data.json' ) );
	$search_check_in  = $_POST['check-in-date'];
	$search_check_out = $_POST['check-out-date'];
	$array = [];
	foreach ( $booking_data as $key => $data ) {
		$hotel_id       = $data->hotel_id;
		$room_type      = $data->room_type;
		$room_check_in  = $data->check_in;
		$room_check_out = $data->check_out;

		if ( $hotel_id !== $get_hotel_id ) {
			continue;
		}
		if ( $room_type !== $room_key + 1 ) {
			continue;
		}
		if ( ( strtotime( $room_check_in ) <= strtotime( $search_check_in ) && strtotime( $room_check_out ) >= strtotime( $search_check_in ) ) || ( strtotime( $room_check_in ) <= strtotime( $search_check_out ) && strtotime( $room_check_out ) >= strtotime( $search_check_out ) ) ) {
			$array[] = [
				'room_type' => $room_type,
				'number'    => $data->room_number,
			];
		}
	}
	return $array;
}