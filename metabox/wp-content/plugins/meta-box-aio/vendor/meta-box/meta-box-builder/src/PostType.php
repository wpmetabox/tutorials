<?php
namespace MBB;

class PostType {
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );
	}

	public function register_post_type() {
		$post_type = 'meta-box';

		$labels = array(
			'name'               => _x( 'Field Groups', 'post type general name', 'meta-box-builder' ),
			'singular_name'      => _x( 'Field Group', 'post type singular name', 'meta-box-builder' ),
			'menu_name'          => _x( 'Custom Fields', 'admin menu', 'meta-box-builder' ),
			'name_admin_bar'     => _x( 'Custom Fields', 'add new on admin bar', 'meta-box-builder' ),
			'add_new'            => _x( 'Add New', 'meta-box-builder', 'meta-box-builder' ),
			'add_new_item'       => __( 'Add New Field Group', 'meta-box-builder' ),
			'new_item'           => __( 'New Field Group', 'meta-box-builder' ),
			'edit_item'          => __( 'Edit Field Group', 'meta-box-builder' ),
			'view_item'          => __( 'View Field Group', 'meta-box-builder' ),
			'all_items'          => __( 'Custom Fields', 'meta-box-builder' ),
			'search_items'       => __( 'Search Field Groups', 'meta-box-builder' ),
			'parent_item_colon'  => __( 'Parent Field Groups:', 'meta-box-builder' ),
			'not_found'          => __( 'No field groups found.', 'meta-box-builder' ),
			'not_found_in_trash' => __( 'No field groups found in Trash.', 'meta-box-builder' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => 'meta-box',
			'query_var'       => true,
			'rewrite'         => array( 'slug' => 'metabox' ),
			'capability_type' => 'post',
			'hierarchical'    => false,
			'menu_position'   => null,
			'supports'        => false,

			'map_meta_cap'    => true,
			'capabilities'    => array(
				// Meta capabilities.
				'edit_post'              => 'edit_meta_box',
				'read_post'              => 'read_meta_box',
				'delete_post'            => 'delete_meta_box',

				// Primitive capabilities used outside of map_meta_cap():
				'edit_posts'             => 'manage_options',
				'edit_others_posts'      => 'manage_options',
				'publish_posts'          => 'manage_options',
				'read_private_posts'     => 'manage_options',

				// Primitive capabilities used within map_meta_cap():
				'read'                   => 'read',
				'delete_posts'           => 'manage_options',
				'delete_private_posts'   => 'manage_options',
				'delete_published_posts' => 'manage_options',
				'delete_others_posts'    => 'manage_options',
				'edit_private_posts'     => 'manage_options',
				'edit_published_posts'   => 'manage_options',
				'create_posts'           => 'manage_options',
			),
		);

		register_post_type( $post_type, $args );
	}

	/**
	 * Modify the output message of meta-box post type
	 *
	 * @param  mixed $messages Message array
	 *
	 * @return mixed $messages Message after modified
	 */
	public function updated_messages( $messages ) {
		$messages['meta-box'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Field group updated.', 'meta-box-builder' ),
			2 => __( 'Custom field updated.', 'meta-box-builder' ),
			3 => __( 'Custom field deleted.', 'meta-box-builder' ),
			4 => __( 'Field group updated.', 'meta-box-builder' ),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Field group restored to revision from %s', 'meta-box-builder' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __( 'Field group updated.', 'meta-box-builder' ),
			7 => __( 'Field group updated.', 'meta-box-builder' ),
			8 => __( 'Field group submitted.', 'meta-box-builder' ),
		);

		return $messages;
	}
}
