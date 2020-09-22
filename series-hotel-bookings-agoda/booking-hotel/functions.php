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
	$parenthandle = 'justread';
	$theme = wp_get_theme();
	wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
		array(),
		$theme->parent()->get('Version')
	);
	wp_enqueue_style( 'justread-child-style', get_stylesheet_uri(), array(), '1.0.0' );

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
	$location   = $_POST['location'];
	$rate       = $_POST['rate'];
	$loai_phong = $_POST['loai_phong'];
	$tien_nghi  = $_POST['tien_nghi'];
	$tien_nghi_phong  = $_POST['tien_nghi_phong'];
	$min_price  = $_POST['min_price'];
	$max_price  = $_POST['max_price'];
	$nguoi_lon  = $_POST['nguoi_lon'];
	$tre_em     = $_POST['tre_em'];

	$rate_array = array(
		'taxonomy' => 'xep-hang',
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

	$loai_phong_array = array(
		'key'     => 'loai-cho-o',
		'value'   => $loai_phong,
		'compare' => 'IN',
	);
	$loai_phong_array = $loai_phong ? $loai_phong_array : '';

	$tien_nghi_array = array(
		'key'     => 'tien-nghi',
		'value'   => $tien_nghi,
		'compare' => 'IN',
	);
	$tien_nghi_array = $tien_nghi ? $tien_nghi_array : '';

	$tien_nghi_phong_array = array(
		'key'     => 'tien-nghi-phong',
		'value'   => $tien_nghi_phong,
		'compare' => 'IN',
	);
	$tien_nghi_phong_array = $tien_nghi_phong ? $tien_nghi_phong_array : '';


	$price_array = array(
		'key'     => 'price_p',
		'value'   => array( $min_price, $max_price ),
		'compare' => 'BETWEEN',
		'type'    => 'NUMERIC',
	);
	$price_array = $max_price ? $price_array : '';

	$nguoi_lon_array  = array(
		'key'     => 'nguoi_lon',
		'value'   => $nguoi_lon,
		'type'    => 'NUMERIC',
		'compare' => '>=',
	);
	$nguoi_lon_array = $nguoi_lon ? $nguoi_lon_array : '';

	$tre_em_array  = array(
		'key'     => 'tre_em',
		'value'   => $tre_em,
		'type'    => 'NUMERIC',
		'compare' => '>=',
	);
	$tre_em_array = $tre_em ? $tre_em_array : '';

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
			$nguoi_lon_array,
			$loai_phong_array,
			$tien_nghi_array,
			$tien_nghi_phong_array,
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
	delete_post_meta( $post_id, 'nguoi_lon' );
	delete_post_meta( $post_id, 'tre_em' );
	delete_post_meta( $post_id, 'tien-nghi-phong' );
	foreach ($rooms as $key => $room) {
		add_post_meta( $post_id, 'price_p', (int)$room['price'] );
		add_post_meta( $post_id, 'nguoi_lon', (int)$room['so-nguoi'] );
		add_post_meta( $post_id, 'tre_em', (int)$room['so-tre-em'] );
		foreach ( $room['tien-nghi_g4zooy6n28n'] as $key => $tien_nghi ) {
			add_post_meta( $post_id, 'tien-nghi-phong', $tien_nghi );
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
		'taxonomy'   => 'xep-hang',
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



function justread_shortcode_loai_hotel() {
	ob_start();
	?>

	<a class="filter-sidebar filter-loai-phong" data-loai-phong-value="khach-san">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Khách sạn</span>
		</div>
	</a>
	<a class="filter-sidebar filter-loai-phong" data-loai-phong-value="can-ho">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Căn hộ</span>
		</div>
	</a>
	<a class="filter-sidebar filter-loai-phong" data-loai-phong-value="nha-dan">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Chỗ nghỉ nhà dân</span>
		</div>
	</a>
	<a class="filter-sidebar filter-loai-phong" data-loai-phong-value="biet-thu">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Biệt thự</span>
		</div>
	</a>
	<a class="filter-sidebar filter-loai-phong" data-loai-phong-value="resort">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Resort</span>
		</div>
	</a>
	<a class="filter-sidebar filter-loai-phong" data-loai-phong-value="nha-tro">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Nhà trọ</span>
		</div>
	</a>
	<?php

	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_loai_hotel', 'justread_shortcode_loai_hotel' );

function justread_shortcode_facilities() {
	ob_start();
	?>

	<a class="filter-sidebar filter-tien-nghi" data-tien-nghi-value="do-xe">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Chỗ đỗ xe</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi" data-tien-nghi-value="nha-hang">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Nhà hàng</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi" data-tien-nghi-value="wi-fi">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Wi-fi miễn phí</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi" data-tien-nghi-value="ho-boi">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Hồ bơi</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi" data-tien-nghi-value="phong-gd">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Phòng gia đình</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi" data-tien-nghi-value="xe-san-bay">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Xe đưa đón sân bay</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi" data-tien-nghi-value="thang-may">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Thang máy</span>
		</div>
	</a>

	<?php
	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_facilities', 'justread_shortcode_facilities' );

function justread_shortcode_room_facilities() {
	ob_start();
	?>

	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="bep">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Khu vực bếp</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="phong-tam">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Phòng tắm riêng</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="dieu-hoa">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Điều hòa</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="bon-tam">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Bồn tắm</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="ti-vi">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Ti vi</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="ban-cong">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Ban công</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="may-giat">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Máy giặt</span>
		</div>
	</a>
	<a class="filter-sidebar filter-tien-nghi-phong" data-tien-nghi-phong-value="view-bien">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">View biển</span>
		</div>
	</a>

	<?php
	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_room_facilities', 'justread_shortcode_room_facilities' );

function justread_shortcode_gia_hotel() {
	ob_start();
	?>

	<a class="filter-sidebar filter-gia-phong" data-min-price="0" data-max-price="50">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Nhỏ hơn 50$</span>
		</div>
	</a>
	<a class="filter-sidebar filter-gia-phong" data-min-price="50" data-max-price="100">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Từ 50$ đến 100$</span>
		</div>
	</a>
	<a class="filter-sidebar filter-gia-phong" data-min-price="100" data-max-price="200">
		<input class="filter-checkbox__input" type="checkbox">
		<div class="filter-checkbox__label">
			<span class="filter_label">Từ 100$ đến 200$</span>
		</div>
	</a>
	<?php

	return ob_get_clean();
}
add_shortcode( 'justread_shortcode_gia_hotel', 'justread_shortcode_gia_hotel' );