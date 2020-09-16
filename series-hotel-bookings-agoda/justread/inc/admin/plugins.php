<?php
/**
 * Add required and recommended plugins.
 *
 * @package Justread
 */

add_action( 'tgmpa_register', 'justread_register_required_plugins' );

/**
 * Register required plugins
 *
 * @since  1.0
 */
function justread_register_required_plugins() {
	$plugins = justread_required_plugins();

	$config = array(
		'id'          => 'justread',
		'has_notices' => false,
	);

	tgmpa( $plugins, $config );
}

/**
 * List of required plugins
 */
function justread_required_plugins() {
	return array(
		array(
			'name' => esc_html__( 'Jetpack', 'justread' ),
			'slug' => 'jetpack',
		),
		array(
			'name' => esc_html__( 'Slim SEO', 'justread' ),
			'slug' => 'slim-seo',
		),
	);
}
