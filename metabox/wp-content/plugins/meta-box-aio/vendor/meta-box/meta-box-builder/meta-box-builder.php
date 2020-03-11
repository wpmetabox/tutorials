<?php
/**
 * Plugin Name: Meta Box Builder
 * Plugin URI:  https://metabox.io/plugins/meta-box-builder/
 * Description: Drag and drop UI for creating custom meta boxes and custom fields.
 * Version:     3.2.5
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 *
 * @package    Meta Box
 * @subpackage Meta Box Builder
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_builder_load' ) ) {
	/**
	 * Hook to 'init' with priority 5 to make sure all actions are registered before Meta Box 4.9.0 runs
	 */
	add_action( 'init', 'mb_builder_load', 5 );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function mb_builder_load() {
		if ( ! defined( 'RWMB_VER' ) ) {
			return;
		}

		if ( version_compare( phpversion(), '5.6', '<' ) ) {
			die( esc_html__( 'Meta Box Builder plugin requires PHP version 5.6+. Please contact your host and ask them to upgrade.', 'meta-box-builder' ) );
		}

		require __DIR__ . '/bootstrap.php';
	}
}
