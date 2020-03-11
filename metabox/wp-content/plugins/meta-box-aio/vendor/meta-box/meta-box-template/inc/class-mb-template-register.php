<?php
/**
 * Meta Box Template Register class
 * This class uses the plugin settings and register meta boxes
 *
 * @package    Meta Box
 * @subpackage Meta Box Template
 */

/**
 * Meta Box Template Register class
 */
class MB_Template_Register {
	/**
	 * Constructor
	 * Add hook to register meta boxes
	 */
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );
	}

	/**
	 * Register meta boxes
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	public function register_meta_boxes( $meta_boxes ) {
		return array_merge( $meta_boxes, $this->parse_user_input(), $this->parse_files() );
	}

	/**
	 * Parse user input into meta boxes.
	 * @return array Array of meta boxes.
	 */
	public function parse_user_input() {
		$option = get_option( 'meta_box_template' );

		return empty( $option['source'] ) ? array() : $this->parse( $option['source'] );
	}

	/**
	 * Parse files into meta boxes.
	 * @return array Array of meta boxes.
	 */
	public function parse_files() {
		$option = get_option( 'meta_box_template' );
		if ( empty( $option['file'] ) ) {
			return array();
		}

		// Convert list of files (separated by commas) to array.
		$files = rwmb_csv_to_array( $option['file'] );

		// Allow developers to add/remove more files.
		$files = apply_filters( 'meta_box_template_files', $files );

		// Get full path of files.
		$files   = array_map( array( $this, 'get_file_path' ), $files );

		$files   = array_filter( $files, 'file_exists' );
		$folders = array_filter( $files, 'is_dir' );
		$files   = array_diff( $files, $folders );

		// Get all files in all folders.
		$folder_files = array_map( array( $this, 'get_dir_files' ), $folders );
		$folder_files = ! empty( $folder_files ) ? call_user_func_array( 'array_merge', $folder_files ) : $folder_files;
		$files        = array_merge( $files, $folder_files );

		// Parse files to get meta boxes.
		$meta_boxes = array_map( array( $this, 'parse' ), $files );
		$meta_boxes = ! empty( $meta_boxes ) ? call_user_func_array( 'array_merge', $meta_boxes ) : array();

		return $meta_boxes;
	}

	/**
	 * Parse YAML string into an array
	 * Uses native PHP function is possible with fallback to Spyc
	 *
	 * @param string $input Template text or absolute path to config file
	 * @return array
	 */
	public function parse( $input ) {
		/**
		 * Use native PHP function if possible
		 * Requires PECL yaml package >= 0.4.0 installed
		 *
		 * @link http://php.net/manual/en/function.yaml-parse.php
		 */
		if ( function_exists( 'yaml_parse' ) ) {
			$meta_boxes = yaml_parse( $input );
		} else {
			/**
			 * Use Spyc library to parse YAML string as a fallback
			 *
			 * @link https://github.com/mustangostang/spyc
			 */
			if ( ! class_exists( 'Spyc' ) ) {
				require MB_TEMPLATE_DIR . 'lib/Spyc.php';
			}

			$meta_boxes = Spyc::YAMLLoad( $input );
		}

		// Single meta box.
		if ( isset( $meta_boxes['title'] ) ) {
			$meta_boxes = array( $meta_boxes );
		}

		return $meta_boxes;
	}

	public function get_file_path( $file ) {
		return strtr( $file, array(
			'%wp-content%' => WP_CONTENT_DIR,
			'%plugins%'    => WP_PLUGIN_DIR,
			'%themes%'     => get_theme_root(),
			'%template%'   => get_template_directory(),
			'%stylesheet%' => get_stylesheet_directory(),
		) );
	}

	public function get_dir_files( $dir ) {
		return glob( "$dir/*.yaml" );
	}
}
