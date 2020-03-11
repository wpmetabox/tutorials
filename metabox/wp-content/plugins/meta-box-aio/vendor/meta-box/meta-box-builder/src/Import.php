<?php
namespace MBB;

use WP_Query;

class Import {
	public function __construct() {
		add_filter( 'post_row_actions', [$this, 'add_export_link'], 10, 2 );

		add_action( 'admin_footer-edit.php', [ $this, 'output_js_templates' ] );
		add_action( 'admin_init', [ $this, 'export' ] );

		// Must run before upgrade.
		$this->import();
	}

	public function add_export_link( $actions, $post ) {
		if ( 'meta-box' !== $post->post_type ) {
			return $actions;
		}
		$actions['export'] = '<a href="' . add_query_arg( ['action' => 'export-meta-boxes', 'post[]' => $post->ID] ) . '">' . esc_html__( 'Export', 'meta-box-builder' ) . '</a>';
		return $actions;
	}

	public function output_js_templates() {
		if ( 'edit-meta-box' === get_current_screen()->id ) {
			require MBB_DIR . 'views/import-form.php';
		}
	}

	public function export() {
		$action = isset( $_REQUEST['action'] ) && 'export-meta-boxes' === $_REQUEST['action'];
		$action2 = isset( $_REQUEST['action2'] ) && 'export-meta-boxes' === $_REQUEST['action2'];

		if ( ( ! $action && ! $action2 ) || empty( $_REQUEST['post'] ) ) {
			return;
		}

		$post_ids = $_REQUEST['post'];

		$query = new WP_Query( [
			'post_type'              => 'meta-box',
			'post__in'               => $post_ids,
			'posts_per_page'         => 100,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] );

		$data = [];
		foreach ( $query->posts as $post ) {
			$data[] = base64_encode( serialize( $post ) );
		}
		$data = serialize( $data );

		$file_name = count( $post_ids ) > 1 ? 'field-groups-exported' : sanitize_title( $query->posts[0]->post_title );

		header( 'Content-Type: application/octet-stream' );
		header( "Content-Disposition: attachment; filename=$file_name.dat" );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . strlen( $data ) );
		echo $data;
		die;
	}

	private function import() {
		// No file uploaded.
		if ( empty( $_FILES['file'] ) || empty( $_FILES['file']['tmp_name'] ) ) {
			return;
		}

		// Verify nonce.
		$nonce = filter_input( INPUT_POST, 'nonce' );
		if ( ! wp_verify_nonce( $nonce, 'import' ) ) {
			return;
		}

		/**
		 * Removed excerpt_save_pre filter for meta box, which adds rel="noopener"
		 * to <a target="_blank"> links, thus braking JSON validity.
		 *
		 * @see https://elightup.freshdesk.com/a/tickets/27894
		 */
		remove_all_filters( 'excerpt_save_pre' );

		$content    = file_get_contents( $_FILES['file']['tmp_name'] );
		$meta_boxes = unserialize( $content );

		foreach ( $meta_boxes as $meta_box ) {
			$post    = unserialize( base64_decode( $meta_box ) );
			$post    = (array) $post;
			$excerpt = $post['post_excerpt'];
			$excerpt = addslashes( $excerpt );

			$post['post_excerpt'] = $excerpt;
			unset( $post['ID'] );

			wp_insert_post( $post );
		}

		$url = add_query_arg( 'imported', 'true' );
		wp_safe_redirect( $url );
		die;
	}
}
