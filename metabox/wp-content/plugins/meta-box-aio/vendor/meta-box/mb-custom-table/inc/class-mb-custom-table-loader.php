<?php
class MB_Custom_Table_Loader {
	public function init() {
		add_filter( 'rwmb_get_storage', array( $this, 'get_storage' ), 10, 3 );
		add_action( 'rwmb_after_save_post', array( __CLASS__, 'update_object_data' ) );
		add_action( 'delete_post', array( $this, 'delete_object_data' ) );
		add_action( 'delete_term', array( $this, 'delete_object_data' ) );
		add_action( 'deleted_user', array( $this, 'delete_object_data' ) );
	}

	public function get_storage( $storage, $object_type, $meta_box ) {
		if ( $meta_box && $this->uses_custom_table( $meta_box ) ) {
			$storage = new RWMB_Table_Storage;
			$storage->table = $meta_box->table;
		}

		return $storage;
	}

	public static function update_object_data( $object_id ) {
		$object_type = self::get_saved_object_type();
		$meta_boxes  = self::get_meta_boxes_for( $object_type, $object_id );

		foreach ( $meta_boxes as $meta_box ) {
			$storage = $meta_box->get_storage();
			$row     = MB_Custom_Table_Cache::get( $object_id, $meta_box->table );
			$row     = array_map( array( __CLASS__, 'maybe_serialize' ), $row );

			$has_data = self::has_data( $row );

			if ( ! $storage->row_exists( $object_id ) && $has_data ) {
				$storage->insert_row( $object_id, $row );
				continue;
			}

			if ( $storage->row_exists( $object_id ) && $has_data ) {
				$storage->update_row( $object_id, $row );
				continue;
			}

			$storage->delete_row( $object_id );
		}
	}

	/**
	 * Don't use WordPress's maybe_serialize() because it double-serializes if the data is already serialized.
	 */
	public static function maybe_serialize( $data ) {
		return is_array( $data ) ? serialize( $data ) : $data;
	}

	public function delete_object_data( $object_id ) {
		$object_type = self::get_deleted_object_type();
		$meta_boxes  = self::get_meta_boxes_for( $object_type, $object_id );

		foreach ( $meta_boxes as $meta_box ) {
			$storage = $meta_box->get_storage();
			$storage->delete( $object_id ); // Delete from cache.
			$storage->delete_row( $object_id ); // Delete from DB.
		}
	}

	protected function uses_custom_table( $meta_box ) {
		return 'custom_table' === $meta_box->storage_type && $meta_box->table;
	}

	protected static function get_meta_boxes_for( $object_type, $object_id ) {
		$meta_boxes = rwmb_get_registry( 'meta_box' )->get_by(
			array(
				'storage_type' => 'custom_table',
				'object_type'  => $object_type,
			)
		);
		if ( 'user' === $object_type ) {
			return $meta_boxes;
		}

		array_walk( $meta_boxes, array( __CLASS__, 'check_type' ), array( $object_type, $object_id ) );
		$meta_boxes = array_filter( $meta_boxes );

		return $meta_boxes;
	}

	protected static function get_saved_object_type() {
		global $wp_current_filter;

		foreach ( $wp_current_filter as $hook ) {
			if ( 'edit_comment' === $hook ) {
				return 'comment';
			}
			if ( 'profile_update' === $hook || 'user_register' === $hook ) {
				return 'user';
			}
			if ( 0 === strpos( $hook, 'edited_' ) || 0 === strpos( $hook, 'created_' ) ) {
				return 'term';
			}
		}
		return 'post';
	}

	protected function get_deleted_object_type() {
		return str_replace( array( 'delete_', 'deleted_' ), '', current_filter() );
	}

	protected static function check_type( &$meta_box, $key, $object_data ) {
		list( $object_type, $object_id ) = $object_data;

		$type = null;
		$prop = null;
		switch ( $object_type ) {
			case 'post':
				$type = get_post_type( $object_id );
				if ( 'revision' === $type ) {
					return;
				}
				$prop = 'post_types';
				break;
			case 'term':
				$type = $object_id;
				$term = get_term( $object_id );
				$type = is_object( $term ) ? $term->taxonomy : null;
				$prop = 'taxonomies';
				break;
		}
		if ( ! $type || ! in_array( $type, $meta_box->meta_box[ $prop ], true ) ) {
			$meta_box = false;
		}
	}

	protected static function has_data( $row ) {
		if ( ! $row ) {
			return false;
		}

		unset( $row['ID'] );
		$row = array_filter( $row );
		return ! empty( $row );
	}
}
