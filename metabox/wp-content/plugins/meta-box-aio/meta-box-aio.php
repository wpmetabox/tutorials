<?php
/**
 * Plugin Name: Meta Box AIO
 * Plugin URI:  https://metabox.io/pricing/
 * Description: All Meta Box extensions in one package.
 * Version:     1.10.18
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: meta-box-aio
 * Domain Path: /languages/
 *
 * @package    Meta Box
 * @subpackage Meta Box AIO
 */

defined( 'ABSPATH' ) || die;

define( 'MBAIO_DIR', __DIR__ );

require __DIR__ . '/vendor/autoload.php';
new MBAIO\Loader;
new MBAIO\Settings;
new MBAIO\Plugin;

if ( is_admin() ) {
	new MBAIO\DashboardWidget;
}
