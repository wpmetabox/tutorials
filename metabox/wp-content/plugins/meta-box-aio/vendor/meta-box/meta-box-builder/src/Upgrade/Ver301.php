<?php
namespace MBB\Upgrade;

class Ver301 {
	public function __construct() {
		$query = new \WP_Query( [
			'post_type'              => 'meta-box',
			'post_status'            => 'any',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] );

		array_walk( $query->posts, [ $this, 'update_context' ] );
		array_walk( $query->posts, [ $this, 'update_post_types' ] );
		array_walk( $query->posts, [ $this, 'write_to_db' ] );
	}

	private function update_context( &$post ) {
		$excerpt = json_decode( $post->post_excerpt, true );
		$content = unserialize( $post->post_content );

		$new_context = [
			'advanced'         => 'normal',
			'after_editor'     => 'normal',
			'before_permalink' => 'after_title',
		];
		if ( isset( $excerpt['context'] ) && isset( $new_context[ $excerpt['context'] ] ) ) {
			$excerpt['context'] = $new_context[ $excerpt['context'] ];
		}
		if ( isset( $content['context'] ) && isset( $new_context[ $content['context'] ] ) ) {
			$content['context'] = $new_context[ $content['context'] ];
		}

		$post->post_excerpt = json_encode( $excerpt );
		$post->post_content = serialize( $content );
	}

	private function update_post_types( &$post ) {
		$excerpt = json_decode( $post->post_excerpt, true );
		$content = unserialize( $post->post_content );

		if ( ! empty( $excerpt['pages'] ) && empty( $excerpt['post_types'] ) ) {
			$excerpt['post_types'] = $excerpt['pages'];
			unset( $excerpt['pages'] );
		}
		if ( ! empty( $content['pages'] ) && empty( $content['post_types'] ) ) {
			$content['post_types'] = $content['pages'];
			unset( $content['pages'] );
		}

		// Make sure post_types is an array of slug. Copied from Ver300.
		if ( ! empty( $excerpt['post_types'] ) && is_array( $excerpt['post_types'] ) ) {
			$excerpt['post_types'] = array_map( function( $post_type ) {
				return isset( $post_type['slug'] ) ? $post_type['slug'] : $post_type;
			}, $excerpt['post_types'] );
		}
		if ( ! empty( $content['post_types'] ) && is_array( $content['post_types'] ) ) {
			$content['post_types'] = array_map( function( $post_type ) {
				return isset( $post_type['slug'] ) ? $post_type['slug'] : $post_type;
			}, $content['post_types'] );
		}

		$post->post_excerpt = json_encode( $excerpt );
		$post->post_content = serialize( $content );
	}

	private function write_to_db( $post ) {
		wp_update_post( [
			'ID'           => $post->ID,
			'post_excerpt' => addslashes( $post->post_excerpt ),
			'post_content' => addslashes( $post->post_content ),
		] );
	}
}
