<?php
/**
 * The main class of the plugin which handle show, edit, save custom fields for comments.
 *
 * @package    Meta Box
 * @subpackage MB Comment Meta
 */

/**
 * Class for handling custom fields (meta data) for comments.
 */
class MB_Comment_Meta_Box extends RW_Meta_Box {
	/**
	 * The object type.
	 *
	 * @var string
	 */
	protected $object_type = 'comment';

	/**
	 * Specific hooks for comment.
	 */
	protected function object_hooks() {
		$this->meta_box['post_types'] = array( 'comment' );

		add_action( 'add_meta_boxes_comment', array( $this, 'add_meta_boxes' ) );
		add_action( 'edit_comment', array( $this, 'save_post' ) );
	}

	/**
	 * Check if we're on the right edit screen.
	 *
	 * @param WP_Screen $screen Screen object. Optional. Use current screen object by default.
	 *
	 * @return bool
	 */
	public function is_edit_screen( $screen = null ) {
		$screen = get_current_screen();

		return 'comment' === $screen->id;
	}

	/**
	 * Get current object id.
	 *
	 * @return int|string
	 */
	protected function get_current_object_id() {
		// @codingStandardsIgnoreLine
		return isset( $_REQUEST['c'] ) ? absint( $_REQUEST['c'] ) : false;
	}

	/**
	 * Add fields to field registry.
	 */
	public function register_fields() {
		$field_registry = rwmb_get_registry( 'field' );

		foreach ( $this->fields as $field ) {
			$field_registry->add( $field, 'comment', 'comment' );
		}
	}
}
