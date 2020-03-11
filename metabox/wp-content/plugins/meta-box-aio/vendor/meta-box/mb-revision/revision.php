<?php
/**
 * Handle the revision meta data when saving or restore posts.
 *
 * @package    Meta Box
 * @subpackage MB Revision
 */
class MB_Revision {
	/**
	 * Store last revision post id.
	 *
	 * @var int
	 */
	private $last_revision_id = 0;

	/**
	 * Fields support revision.
	 *
	 * @var array
	 */
	private $fields = array();

	public function __construct() {
		$this->get_fields();
		if ( empty( $this->fields ) ) {
			return;
		}

		// Priority 5: get before Meta Box saves fields.
		add_action( 'save_post', array( $this, 'get_last_revision_id' ), 5 );

		add_action( 'rwmb_after_save_post', array( $this, 'copy_fields_to_revision' ) );

		// Copy revision meta data to parent post and recent created revision.
		add_action( 'wp_restore_post_revision', array( $this, 'restore_revision' ), 10, 2 );

		// Filter fields displayed in revisions screen.
		add_filter( '_wp_post_revision_fields', array( $this, 'revision_fields' ) );

		add_filter( 'wp_save_post_revision_check_for_changes', array( $this, 'check_for_changes' ), 10, 3 );
		foreach ( $this->fields as $field ) {
			add_filter(
				'_wp_post_revision_field_' . $this->encode_field_key( $field ),
				array( $this, 'get_field_value_for_comparison' ),
				10,
				3
			);
		}
	}

	public function get_last_revision_id( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			$this->last_revision_id = $post_id;
		}
	}

	public function copy_fields_to_revision( $post_id ) {
		if ( ! post_type_supports( get_post_type( $post_id ), 'revisions' ) ) {
			return;
		}

		if ( ! $this->last_revision_id ) {
			return;
		}

		$revision_id = $this->last_revision_id;
		$parent_id   = $post_id;

		foreach ( $this->fields as $field ) {
			$this->copy_value( $parent_id, $revision_id, $field );
		}

		$this->update_data_for_custom_table( $revision_id );
	}

	public function restore_revision( $post_id, $revision_id ) {
		foreach ( $this->fields as $field ) {
			$this->copy_value( $revision_id, $post_id, $field );
			$this->copy_value( $revision_id, $this->last_revision_id, $field );
		}
		$this->update_data_for_custom_table( $post_id );
		$this->update_data_for_custom_table( $this->last_revision_id );
	}

	/**
	 * Add meta box fields to revision screen.
	 *
	 * @param  array $fields Displayed fields.
	 * @return array
	 */
	public function revision_fields( $fields ) {
		foreach ( $this->fields as $field ) {
			$fields[ $this->encode_field_key( $field ) ] = $field['name'];
		}

		return $fields;
	}

	public function check_for_changes( $is_changed, $revision, $post ) {
		foreach ( $this->fields as $field ) {
			$key = $this->encode_field_key( $field );

			// Add new value to post.
			$post->$key = $this->get_submitted_value( $field );

			// Serialize non-string value.
			if ( ! is_string( $revision->$key ) ) {
				$revision->$key = maybe_serialize( $revision->$key );
			}
			if ( ! is_string( $post->$key ) ) {
				$post->$key = maybe_serialize( $post->$key );
			}
		}

		return $is_changed;
	}

	/**
	 * Get field value to show on the revision comparison screen.
	 *
	 * @param  string  $value Field data.
	 * @param  string  $field Field id.
	 * @param  WP_Post $post  Post object.
	 * @return string
	 */
	public function get_field_value_for_comparison( $value, $field, $post ) {
		$field   = $this->decode_field_key( $field );
		$single  = $field['clone'] || ! $field['multiple'];
		$storage = $this->get_field_storage( $field );
		$value   = $storage->get( $post->ID, $field['id'], array( 'single' => $single ) );

		$value = $this->transform_choice_value_to_label( $value, $field );
		$value = $this->transform_object_value_to_label( $value, $field );

		$value = is_array( $value ) ? wp_json_encode( $value, JSON_PRETTY_PRINT ) : (string) $value;

		return $value;
	}

	private function get_fields() {
		$meta_boxes = rwmb_get_registry( 'meta_box' )->get_by( array( 'object_type' => 'post' ) );
		$meta_boxes = array_filter( $meta_boxes, array( $this, 'supports_revisions' ) );

		foreach ( $meta_boxes as $meta_box ) {
			$this->fields = array_merge( $this->fields, $meta_box->fields );
		}

		$this->fields = array_filter( $this->fields, array( $this, 'has_value' ) );
	}

	private function supports_revisions( $meta_box ) {
		return $meta_box->revision;
	}

	private function has_value( $field ) {
		$types = array( 'heading', 'custom_html', 'divider', 'button' );
		return ! empty( $field['id'] ) && ! in_array( $field['type'], $types, true );
	}

	private function transform_choice_value_to_label( $value, $field ) {
		$types = array( 'checkbox_list', 'radio', 'select', 'select_advanced' );
		if ( ! in_array( $field['type'], $types, true ) ) {
			return $value;
		}
		$options = $field['options'];

		return $this->get_option_label( $value, $options );
	}

	private function transform_object_value_to_label( $value, $field ) {
		$types = array( 'taxonomy', 'taxonomy_advanced', 'post', 'user' );
		if ( ! in_array( $field['type'], $types, true ) ) {
			return $value;
		}
		$options = RWMB_Field::call( $field, 'query', $value );
		$options = RWMB_Choice_Field::transform_options( $options );
		$options = wp_list_pluck( $options, 'label', 'value' );

		return $this->get_option_label( $value, $options );
	}

	private function get_option_label( $value, $options ) {
		if ( is_array( $value ) ) {
			array_walk_recursive( $value, array( $this, 'get_single_option_label' ), $options );
		} else {
			$this->get_single_option_label( $value, null, $options );
		}
		return $value;
	}

	private function get_single_option_label( &$value, $key, $options ) {
		$value = isset( $options[ $value ] ) ? $options[ $value ] : $value;
	}

	private function get_submitted_value( $field ) {
		$single  = $field['clone'] || ! $field['multiple'];
		$default = $single ? '' : array();

		return rwmb_request()->post( $field['id'], $default );
	}

	/**
	 * Copy meta value from post to another post.
	 *
	 * @param  int   $from_id From post ID.
	 * @param  int   $to_id   To post ID.
	 * @param  array $field   Field data.
	 */
	private function copy_value( $from_id, $to_id, $field ) {
		$single   = $field['clone'] || ! $field['multiple'];
		$meta_key = $field['id'];
		$storage  = $this->get_field_storage( $field );

		$value = $storage->get( $from_id, $meta_key, array( 'single' => $single ) );

		if ( $single ) {
			if ( '' !== $value ) {
				$storage->update( $to_id, $meta_key, $value );
				return;
			}

			$storage->delete( $to_id, $meta_key );
			return;
		}

		if ( ! empty( $value ) ) {
			$storage->delete( $to_id, $meta_key );
			foreach ( $value as $v ) {
				$storage->add( $to_id, $meta_key, $v );
			}
			return;
		}

		$storage->delete( $to_id, $meta_key );
	}

	private function encode_field_key( $field ) {
		return maybe_serialize( $field );
	}

	private function decode_field_key( $key ) {
		return maybe_unserialize( $key );
	}

	private function get_field_storage( $field ) {
		return isset( $field['storage'] ) ? $field['storage'] : rwmb_get_storage( 'post' );
	}

	private function update_data_for_custom_table( $object_id ) {
		if ( class_exists( 'MB_Custom_Table_Loader' ) && method_exists( 'MB_Custom_Table_Loader', 'update_object_data' ) ) {
			MB_Custom_Table_Loader::update_object_data( $object_id );
		}
	}
}
