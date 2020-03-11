<?php
/**
 * Plugin Name: Meta Box - FacetWP Integrator
 * Plugin URI:  https://metabox.io/plugins/mb-facetwp-integrator/
 * Description: Integrates Meta Box custom fields with FacetWP.
 * Author:      MetaBox.io
 * Version:     1.0.3
 * Author URI:  https://metabox.io
 *
 * @package    Meta Box
 * @subpackage MB FacetWP Integrator
 */

if ( ! class_exists( 'MB_FacetWP_Integrator' ) ) {
	require __DIR__ . '/class-mb-facetwp-integrator.php';
	new MB_FacetWP_Integrator;
}