<?php
/**
 * Loader for comment meta
 *
 * @package    Meta Box
 * @subpackage MB Comment Meta
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

/**
 * Loader class
 */
class MB_Comment_Meta_Loader {
	/**
	 * Run hooks to get meta boxes for comments and initialize them.
	 */
	public function init() {
		add_filter( 'rwmb_meta_box_class_name', array( $this, 'meta_box_class_name' ), 10, 2 );
		add_filter( 'rwmb_meta_type', array( $this, 'filter_meta_type' ), 10, 2 );
	}

	/**
	 * Filter meta box class name.
	 *
	 * @param  string $class_name Meta box class name.
	 * @param  array  $meta_box   Meta box data.
	 *
	 * @return string
	 */
	public function meta_box_class_name( $class_name, $meta_box ) {
		if ( isset( $meta_box['type'] ) && 'comment' === $meta_box['type'] ) {
			$class_name = 'MB_Comment_Meta_Box';
		}

		return $class_name;
	}

	/**
	 * Filter meta type from object type and object id.
	 *
	 * @param string $type        Meta type get from object type and object id.
	 * @param string $object_type Object type.
	 *
	 * @return string
	 */
	public function filter_meta_type( $type, $object_type ) {
		return 'comment' === $object_type ? 'comment' : $type;
	}
}
