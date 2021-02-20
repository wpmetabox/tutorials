<?php
/**
 * Plugin Name: Detect Browser
 * Plugin URI: https://elightup.com/
 * Description: Detect Browser.
 * Version: 1.1
 * Author: eLightUp
 * Author URI: https://elightup.com/
 * License: GPL2+
 * Text Domain: detect-browser
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || die;

define( 'DETECT_BROWSER_DIR', plugin_dir_path( __FILE__ ) );
define( 'DETECT_BROWSER_URL', plugin_dir_url( __FILE__ ) );


require_once DETECT_BROWSER_DIR . 'loader.php';
new DetectBrowser();