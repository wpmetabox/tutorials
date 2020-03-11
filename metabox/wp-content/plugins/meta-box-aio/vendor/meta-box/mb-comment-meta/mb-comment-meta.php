<?php
/**
 * Plugin Name: MB Comment Meta
 * Plugin URI: https://metabox.io/plugins/mb-comment-meta/
 * Description: Add custom fields (meta data) for comments.
 * Version: 1.0
 * Author: MetaBox.io
 * Author URI: https://metabox.io
 * License: GPL2+
 * Text Domain: mb-comment-meta
 * Domain Path: /languages/
 *
 * @package Meta Box
 * @subpackage MB Comment Meta
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_comment_meta_load' ) ) {
	/**
	 * Hook to 'init' with priority 5 to make sure all actions are registered before Meta Box 4.9.0 runs
	 */
	add_action( 'init', 'mb_comment_meta_load', 5 );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function mb_comment_meta_load() {
		if ( ! defined( 'RWMB_VER' ) || class_exists( 'MB_Comment_Meta_Box' ) ) {
			return;
		}

		require dirname( __FILE__ ) . '/inc/class-mb-comment-meta-loader.php';
		require dirname( __FILE__ ) . '/inc/class-mb-comment-meta-box.php';
		require dirname( __FILE__ ) . '/inc/class-rwmb-comment-storage.php';
		$loader = new MB_Comment_Meta_Loader;
		$loader->init();
	}
}
