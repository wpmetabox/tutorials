<?php
/**
 * Plugin Name: MB Revision
 * Plugin URI:  https://metabox.io/plugins/mb-revision/
 * Description: Enable revision for meta box.
 * Version:     1.3.3
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: mb-revision
 * Domain Path: /languages/
 *
 * @package    Meta Box
 * @subpackage MB Revision
 */

defined( 'ABSPATH' ) || die;

if ( ! function_exists( 'mb_revision_init' ) ) {
	function mb_revision_init() {
		if ( ! defined( 'RWMB_VER' ) ) {
			return;
		}
		require_once __DIR__ . '/revision.php';
		new MB_Revision;
	}
	add_action( 'admin_init', 'mb_revision_init' );
}
