<?php
/**
 * Plugin Name: MB Custom Table
 * Plugin URI:  https://metabox.io/plugins/mb-custom-table/
 * Description: Save custom fields data to custom table instead of the default meta tables.
 * Version:     1.1.10
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: mb-custom-table
 * Domain Path: /languages/
 *
 * @package    Meta Box
 * @subpackage MB Custom Table
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_custom_table_load' ) ) {
	require __DIR__ . '/inc/class-mb-custom-table-api.php';
	require __DIR__ . '/inc/class-mb-custom-table-cache.php';

	/**
	 * Hook to 'init' with priority 5 to make sure all actions are registered before Meta Box 4.9.0 runs
	 */
	add_action( 'init', 'mb_custom_table_load', 5 );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function mb_custom_table_load() {
		if ( ! defined( 'RWMB_VER' ) ) {
			return;
		}

		require __DIR__ . '/inc/class-mb-custom-table-loader.php';
		require __DIR__ . '/inc/class-rwmb-table-storage.php';

		$loader = new MB_Custom_Table_Loader;
		$loader->init();
	}
}
