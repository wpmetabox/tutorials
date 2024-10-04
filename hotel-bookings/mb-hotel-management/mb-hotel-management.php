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

class ManagerBooking {
    public function __construct() {
        add_action('admin_menu', array($this, 'create_menu_admin_panel'));
        add_action('wp_ajax_feed_events', array($this, 'feed_events'));
        add_action('wp_ajax_nopriv_feed_events', array($this, 'feed_events'));
    }

    public function create_menu_admin_panel() {
        add_menu_page('Manager booking', 'Manager booking', 'edit_posts', 'manager-booking', array($this, 'booking_management'));
    }

    public function booking_management() {
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

        $object = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_nonce'), // Tạo nonce cho bảo mật
        );

        wp_localize_script('js-custom', 'ajax_object', $object);
        
        include 'inc/front.php';
    }

    public function feed_events() {
      
        $query = new WP_Query( [
        'post_type'      => 'booking',
        'posts_per_page' => - 1,
    ] );
       
        $events = array();
        while ($query->have_posts()) {
            $query->the_post();
            $bookings = get_post_meta(get_the_ID(), 'group_booking', false);
   
         
            
            foreach ($bookings as $booking) {
                $room = $booking['room'];
                $begin = date('Y-m-d', strtotime($booking['check_in'])); // Chuyển đổi định dạng
                $end = date('Y-m-d', strtotime($booking['check_out']));
                
      

               $e = array(
                    'title' => "#" . get_the_ID() . ' ' . get_the_title($room),
                    'start' => $begin,
                    'end' => $end,
                    'url' => get_edit_post_link(get_the_ID(), ''),
                    'classNames' => 'room-' . $room,
                    'allDay' => true,
                );
               
                array_push($events, $e);
           }
        }
        // var_dump($events);
        wp_reset_postdata(); // Dọn dẹp dữ liệu sau khi sử dụng WP_Query

        wp_send_json_success($events); // Gửi dữ liệu JSON
    }
}

$Data = new ManagerBooking();
