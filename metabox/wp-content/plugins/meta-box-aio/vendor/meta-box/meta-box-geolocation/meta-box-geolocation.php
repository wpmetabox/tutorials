<?php
/**
 * Plugin Name: Meta Box Geolocation
 * Plugin URI:  https://metabox.io/plugins/meta-box-geolocation/
 * Description: Powerful tool to interact with Google Maps API and save location data
 * Version:     1.2.6
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || die;

if ( ! function_exists( 'meta_box_geolocation_load' ) ) {
    /**
     * Hook to 'init' with priority 5 to make sure all actions are registered before Meta Box 4.9.0 runs
     */
    add_action( 'init', 'meta_box_geolocation_load', 5 );

    /**
     * Load plugin files after Meta Box is loaded
     */
    function meta_box_geolocation_load() {

        if ( ! defined( 'RWMB_VER' ) ) {
            return;
        }

        require 'geolocation.php';
        new MB_Geolocation();
    }
}
