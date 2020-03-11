<?php
namespace MBAIO;

class Plugin {
	public function __construct() {
		add_action( 'tgmpa_register', [$this, 'require_plugins'] );
	}

	public function require_plugins() {
		$plugins = [
			[
				'name'     => 'Meta Box',
				'slug'     => 'meta-box',
				'required' => true,
			]
		];
		$config = [
			'id'           => 'mb-aio',
			'menu'         => 'mb-aio-install-plugins',
			'parent_slug'  => 'plugins.php',
			'capability'   => 'manage_options',
		];
		tgmpa( $plugins, $config );
	}
}