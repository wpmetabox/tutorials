<?php
/*
Plugin Name:	My Custom Functionality
Plugin URI:		https://example.com
Description:	My custom functions.
Version:		1.0.0
Author:			Your Name
Author URI:		https://example.com
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with This plugin. If not, see {URI to Plugin License}.
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'wp_enqueue_scripts', 'custom_enqueue_files' );
/**
 * Loads <list assets here>.
 */
function custom_enqueue_files() {
	wp_enqueue_style('slick', plugin_dir_url( __FILE__ ).'/assets/css/slick.css');
	wp_enqueue_style('slick-theme', plugin_dir_url( __FILE__ ).'/assets/css/slick-theme.css');

	wp_enqueue_script('custom', plugin_dir_url( __FILE__ ).'/assets/js/custom.js', ['jquery']);
	wp_enqueue_script('slick-min', plugin_dir_url( __FILE__ ).'/assets/js/slick.min.js', ['jquery']);
}

add_shortcode( 'new-arrival-product', 'new_arrival_shortcode1' );
function new_arrival_shortcode1( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type'   => 'restaurant',
		'post_status' => 'publish',
		'order'          => 'DESC',
    ) );
    if ( $query->have_posts() ) { ?>
	<div class="product-show-homepage">
         <ul class="slider-product">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php 
			   $contacts = rwmb_meta( 'info_menu' );
				if ( ! empty( $contacts ) ) {
					foreach ( $contacts as $contact ) {
						echo '<p>', $contact['heading_meal'], '</p>';
					}
				}
			  ?>
	  
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
		</div>
    <?php $myvariable1 = ob_get_clean();
    return $myvariable1;
    }
}