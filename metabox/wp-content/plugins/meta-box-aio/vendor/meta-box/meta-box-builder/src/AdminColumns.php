<?php
namespace MBB;

class AdminColumns {
	public function __construct() {
		add_action( 'admin_print_styles-edit.php', [ $this, 'enqueue' ] );
		add_filter( 'manage_meta-box_posts_columns', [ $this, 'add_columns' ] );
		add_action( 'manage_meta-box_posts_custom_column', [ $this, 'show_column' ] );
	}

	public function enqueue() {
		if ( 'edit-meta-box' !== get_current_screen()->id ) {
			return;
		}

		wp_enqueue_style( 'mbb-list', MBB_URL . 'assets/css/list.css', [], MBB_VER );
		wp_enqueue_script( 'mbb-list', MBB_URL . 'assets/js/list.js', [ 'jquery' ], MBB_VER );
		wp_localize_script( 'mbb-list', 'MBB', [
			'export' => esc_html__( 'Export', 'meta-box-builder' ),
			'import' => esc_html__( 'Import', 'meta-box-builder' ),
		] );

		wp_register_script( 'popper', MBB_URL . 'assets/js/popper.min.js', [], '1.15.0', true );
		wp_enqueue_script( 'tippy', MBB_URL . 'assets/js/tippy.min.js', ['popper'], '4.3.1', true );
		wp_add_inline_script( 'tippy', 'tippy( document.body, {target: ".mbb-tooltip", placement: "top-start", arrow: true, animation: "fade"} );' );
	}

	public function add_columns( $columns ) {
		$new_columns = array(
			'for'      => __( 'Show For', 'meta-box-builder' ),
			'location' => __( 'Location', 'meta-box-builder' ),
		);
		if ( mbb_is_extension_active( 'mb-frontend-submission' ) ) {
			$new_columns['shortcode'] = __( 'Shortcode', 'meta-box-builder' ) . mbb_tooltip( __( 'Embed the field group in the front end for users to submit posts.', 'meta-box-builder' ) );
		}
		$columns = array_slice( $columns, 0, 2, true ) + $new_columns + array_slice( $columns, 2, null, true );
		return $columns;
	}

	public function show_column( $name ) {
		global $post;
		if ( ! in_array( $name, array( 'for', 'location', 'shortcode' ) ) ) {
			return;
		}
		$info = json_decode( $post->post_excerpt );
		$this->{"show_$name"}( $info );
	}

	private function show_for( $info ) {
		$for = $info->for;
		switch ( $for ) {
			case 'user':
				esc_html_e( 'Users', 'meta-box-builder' );
				break;
			case 'comment':
				esc_html_e( 'Comments', 'meta-box-builder' );
				break;
			case 'attachments':
				esc_html_e( 'Attachments', 'meta-box-builder' );
				break;
			case 'settings_pages':
				esc_html_e( 'Settings Pages', 'meta-box-builder' );
				break;
			case 'post_types':
				esc_html_e( 'Posts', 'meta-box-builder' );
				break;
			case 'taxonomies':
				esc_html_e( 'Taxonomies', 'meta-box-builder' );
			case 'block':
				esc_html_e( 'Blocks', 'meta-box-builder' );
		}
	}

	private function show_location( $info ) {
		$for  = $info->for;
		switch ( $for ) {
			case 'user':
				esc_html_e( 'All Users', 'meta-box-builder' );
				break;
			case 'comment':
				esc_html_e( 'All Comments', 'meta-box-builder' );
				break;
			case 'attachments':
				esc_html_e( 'All Attachments', 'meta-box-builder' );
				break;
			case 'settings_pages':
				echo implode( '<br>', array_filter( array_map( function( $setting_page ) {
					return isset( $settings_pages[$setting_page] ) ? $settings_pages[$setting_page]['title'] : '';
				}, $info->settings_pages ) ) );
				break;
			case 'post_types':
				echo implode( '<br>', array_filter( array_map( function( $post_type ) {
					$post_type_object = get_post_type_object( $post_type );
					return $post_type_object ? $post_type_object->labels->singular_name : '';
				}, $info->post_types ) ) );
				break;
			case 'taxonomies':
				echo implode( '<br>', array_filter( array_map( function( $taxonomy ) {
					$taxonomy_object = get_taxonomy( $taxonomy );
					return $taxonomy_object ? $taxonomy_object->labels->singular_name : '';
				}, $info->taxonomies ) ) );
		}
	}

	private function show_shortcode( $info ) {
		$shortcode = "[mb_frontend_form id='{$info->id}' post_fields='title,content']";
		echo '<input type="text" readonly value="' . esc_attr( $shortcode ) . '" onclick="this.select()">';
	}
}
