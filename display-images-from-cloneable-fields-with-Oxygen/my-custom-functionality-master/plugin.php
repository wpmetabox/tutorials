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
