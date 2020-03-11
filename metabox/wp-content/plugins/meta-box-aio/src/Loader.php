<?php
namespace MBAIO;

class Loader {
	public function __construct() {
		// Use 'init' hook to make the filter 'mb_aio_extensions' can be used in themes or other plugins that loaded after this plugin.
		// Priority -5  make sure it runs before any required hook required by premium extensions.
		add_action( 'init', array( $this, 'load_extensions' ), -5 );
	}

	public function load_extensions( $extensions = [] ) {
		$extensions = empty( $extensions ) ? $this->get_enabled_extensions() : $extensions;
		$files = array_map( array( $this, 'get_extension_file' ), $extensions );
		$files = array_filter( $files );
		foreach ( $files as $file ) {
			require_once $file;
		}
	}

	private function get_enabled_extensions() {
		$option     = get_option( 'meta_box_aio' );
		$extensions = isset( $option['extensions'] ) ? $option['extensions'] : array();
		$extensions = apply_filters( 'mb_aio_extensions', $extensions );
		$extensions = array_unique( $extensions );

		return $extensions;
	}

	private function get_extension_file( $extension ) {
		$files = array_merge(
			array(
				$extension => $extension,
			),
			array(
				'meta-box-text-limiter' => 'text-limiter',
				'meta-box-yoast-seo'    => 'mb-yoast-seo',
			)
		);
		$file = $files[$extension];
		$file = dirname( __DIR__ ) . "/vendor/meta-box/$file/$file.php";

		return file_exists( $file ) ? $file : null;
	}
}
