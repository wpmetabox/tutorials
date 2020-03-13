<?php
/**
 * Just Read functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Justread
 */

if ( ! function_exists( 'justread_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function justread_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Just Read, use a find and replace
		 * to change 'justread' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'justread', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'justread-adjacent', 444, 230, true );
		set_post_thumbnail_size( 363, 188, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Header', 'justread' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'justread_custom_background_args',
				array(
					'default-color' => 'f5f7f8',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Add theme support for editor style.
		add_editor_style();

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Add support for post formats.
		add_theme_support( 'post-formats', array( 'quote' ) );

		// Support Gutenberg.
		add_theme_support( 'align-wide' );
	}
endif;
add_action( 'after_setup_theme', 'justread_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function justread_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'justread_content_width', 960 );
}
add_action( 'after_setup_theme', 'justread_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function justread_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'justread' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Appears in the footer of the site.', 'justread' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'justread_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function justread_scripts() {
	wp_enqueue_style( 'justread-style', get_stylesheet_uri(), array(), '1.0.0' );

	wp_enqueue_script( 'justread-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true );

	wp_enqueue_script( 'justread-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '1.0.0', true );

	// Scripts for sticky sharing icons. Applied only for single posts and icon style.
	if ( justread_is_sharing_icons_enabled() ) {
		wp_enqueue_script( 'sticky-sidebar', get_template_directory_uri() . '/js/sticky-sidebar.js', array(), '3.2.0', true );
	}

	wp_enqueue_script( 'justread', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'justread_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * SVG icons functions and filters.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if ( is_admin() ) {
	/**
	 * Load TGM Activation Class.
	 */
	require_once get_template_directory() . '/inc/admin/class-tgm-plugin-activation.php';
	require_once get_template_directory() . '/inc/admin/plugins.php';

	/**
	 * Load theme dashboard.
	 */
	require get_template_directory() . '/inc/dashboard/class-justread-dashboard.php';
	new Justread_Dashboard();
}

/**
 * Customizer Pro.
 */
require get_template_directory() . '/inc/customizer-pro/class-justread-customizer-pro.php';
$customizer_pro = new Justread_Customizer_Pro();
$customizer_pro->init();

/**
 * Style gutenberg
 */
function justread_style_editor_gutenberg() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'style-editor', get_theme_file_uri( '/editor-gutenberg.css' ), false );
}
add_action( 'enqueue_block_editor_assets', 'justread_style_editor_gutenberg' );

/**
 * add dashboardwidget Meta Box
 */
require get_template_directory() . '/inc/dashboard-widget.php';
new Justread_Dashboard_Widget();

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if(!get_option('rwmb_bookings_full')){

  add_option('rwmb_bookings_full', array());

}

add_action( 'rwmb_booking-fields_after_save_post', 'bookings_option' );

function bookings_option( $post_id ) {

  $bookings = get_post_meta( $post_id, 'group_booking', true ); // Lấy giá trị của field group_booking đưa vào biến $booking

  if (empty($bookings) && !is_array($bookings)) return;

  $option = get_option('rwmb_bookings_full');

  foreach ($bookings as $key => $booking) { // Chạy vòng lặp biến $booking vì đây là 1 group field

    $room = $booking['room']; //$room là biến chứa id của phòng

    $begin = $booking['check_in']; // $begin là ngày bắt đầu cũng như ngày check in phòng

    $end = $booking['check_out']; // $end là ngày kết thúc cũng như ngày check out

    $option[$room][$post_id][$key] = array('checkin'=> $begin, 'checkout'=>$end); // Gán lại giá trị cho biến options
    
  }

  update_option('rwmb_bookings_full', $option); // Cập nhật option 'rwmb_bookings'
    
}

if(!get_option('rwmb_bookings')){

	add_option('rwmb_bookings', array());

}

add_action( 'rwmb_booking-fields_after_save_post', 'update_bookings_date' );

function update_bookings_date( $post_id ) {

    $bookings = get_post_meta( $post_id, 'group_booking', true ); // Lấy giá trị của field group_booking đưa vào biến $booking

    if (empty($bookings) && !is_array($bookings)) return;

    $option = get_option('rwmb_bookings');

	foreach ($bookings as $key => $booking) { // Chạy vòng lặp biến $booking vì đây là 1 group field

		$room = $booking['room']; //$room là biến chứa id của phòng

		$begin = new DateTime( $booking['check_in'] ); // $begin là ngày bắt đầu cũng như ngày check in phòng

		$end = new DateTime( $booking['check_out'] ); // $end là ngày kết thúc cũng như ngày check out

		$end = $end->modify( '+1 day' ); // Cộng biến $end lên 1 ngày vì hàm DatePeriod không bao gồm ngày end

		$interval = new DateInterval('P1D'); 

		$daterange = new DatePeriod($begin, $interval ,$end); // Hàm DatePeriod trả về mảng chứa tất cả ngày giữa 2 ngày đưa vào

		$dates_booking = array(); 

		foreach($daterange as $date){

		    array_push($dates_booking, $date->format("Y-m-d")); // Đưa giá trị vào biến $dates_booking

		}

		$option[$room][$post_id][$key] = $dates_booking; // Gán lại giá trị cho biến options
		
	}

	update_option('rwmb_bookings', $option); // Cập nhật option 'rwmb_bookings'
    
}


function dates_disable($room_id){
	$bookings = get_option('rwmb_bookings')[$room_id];
	if (empty($bookings) && !is_array($bookings)) return;
	$dates = array();
	$disable = array();
	foreach ($bookings as $booking) {
		foreach ($booking as $value) {
			foreach ($value as $k ) {
				array_push($dates, $k);
			}
		}
	}
	$dates = array_count_values($dates);
	$quantity = rwmb_meta( 'quantity', $room_id);
	foreach ($dates as $key => $date) {
		if ($date >= $quantity) {
			array_push($disable, $key);
		}
	}
	return $disable;
}

function enqueue_script() {
  	if (is_singular('room')) { 
		wp_enqueue_script('custom-script', get_template_directory_uri().'/js/custom.js', array( 'jquery' ));
		wp_localize_script( 'custom-script', 'ajaxurl', admin_url('admin-ajax.php'));
		wp_localize_script( 'custom-script', 'disable_dates', json_encode(dates_disable(get_the_ID())));
  	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_script');


/**
 * Remove expired date in variable option
 */

function array_filter_recursive ($data) {
    $original = $data;
    $data = array_filter($data);
    $data = array_map(function ($e) {
        return is_array($e) ? array_filter_recursive($e) : $e;
    }, $data);
    return $original === $data ? $data : array_filter_recursive($data);
}

function optimal_bookings_option() {
	$bookings = get_option('rwmb_bookings');
	$today = date("Y-m-d");
	foreach ($bookings as $key_1 => $bk_1) {
		foreach ($bk_1 as $key_2 => $bk_2) {
			foreach ($bk_2 as $key_3 => $bk_3 ) {
				foreach ($bk_3 as $key_4 => $bk_4) {
					if ($bk_4 < $today) {
						unset($bookings[$key_1][$key_2][$key_3][$key_4]);
					}
				}
				
			}
		}
	}
	$bookings = array_filter_recursive($bookings);
	update_option('rwmb_bookings', $bookings);
}

add_action( 'init', 'optimal_bookings_option' );


add_filter( 'rwmb_frontend_validate', function( $validate, $config ) {
    if ( 'booking-fields' !== $config['id'] ) {
        return $validate;
    }
    $disable_dates = dates_disable(get_the_ID());
	$checkin =  date("Y-m-d", strtotime($_POST['group_booking_check_in']));
	$checkout =  date("Y-m-d", strtotime($_POST['group_booking_check_out']));

    if ( false !== array_search($checkin, $disable_dates)) {
        $validate = false;
    } else {
    	update_post_meta($config['post_id'], 'group_booking_room', get_the_ID());
    }


    return $validate;
    
}, 10, 2 );



