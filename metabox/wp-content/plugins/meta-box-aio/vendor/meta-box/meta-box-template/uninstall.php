<?php
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	die;

// Delete plugin options
delete_option( 'meta_box_template' );
