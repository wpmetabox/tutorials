<?php
namespace MBB\Upgrade;

class Ver300 {
	public function __construct() {
		$query = new \WP_Query( [
			'post_type'              => 'meta-box',
			'post_status'            => 'any',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] );

		array_walk( $query->posts, [ $this, 'update_object_types' ] );
		array_walk( $query->posts, [ $this, 'update_fields' ] );
		array_walk( $query->posts, [ $this, 'update_post' ] );
	}

	private function update_object_types( &$post ) {
		$excerpt = json_decode( $post->post_excerpt, true );
		$content = unserialize( $post->post_content );

		if ( isset( $excerpt['for'] ) && 'attachments' === $excerpt['for'] ) {
			$excerpt['for'] = 'post_types';
			$excerpt['post_types'] = ['attachment'];
		}

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

		if ( ! empty( $excerpt['taxonomies'] ) ) {
			$excerpt['taxonomies'] = array_map( function( $taxonomy ) {
				return isset( $taxonomy['slug'] ) ? $taxonomy['slug'] : $taxonomy;
			}, $excerpt['taxonomies'] );
		}
		if ( ! empty( $content['taxonomies'] ) ) {
			$content['taxonomies'] = array_map( function( $taxonomy ) {
				return isset( $taxonomy['slug'] ) ? $taxonomy['slug'] : $taxonomy;
			}, $content['taxonomies'] );
		}

		if ( ! empty( $excerpt['settings_pages'] ) ) {
			$excerpt['settings_pages'] = array_map( function( $setting_page ) {
				return isset( $setting_page['id'] ) ? $setting_page['id'] : $setting_page;
			}, $excerpt['settings_pages'] );
		}
		if ( ! empty( $content['settings_pages'] ) ) {
			$content['settings_pages'] = array_map( function( $setting_page ) {
				return isset( $setting_page['id'] ) ? $setting_page['id'] : $setting_page;
			}, $content['settings_pages'] );
		}

		$post->post_excerpt = json_encode( $excerpt );
		$post->post_content = serialize( $content );
	}

	private function update_fields( &$post ) {
		$excerpt = json_decode( $post->post_excerpt, true );
		if ( empty( $excerpt['fields'] ) || ! is_array( $excerpt['fields'] ) ) {
			return;
		}
		array_walk( $excerpt['fields'], [$this, 'update_field_datalist'] );
		array_walk( $excerpt['fields'], [$this, 'update_field_options'] );
		$post->post_excerpt = json_encode( $excerpt );
	}

	private function update_field_datalist( &$field ) {
		if ( empty( $field['datalist'] ) ) {
			return;
		}
		$field['datalist_choices'] = implode( "\n", $field['datalist']['options'] );
		unset( $field['datalist'] );
	}

	private function update_field_options( &$field ) {
		if ( empty( $field['options'] ) || ! is_array( $field['options'] ) || in_array( $field['type'], ['fieldset_text', 'text_list', 'wysiwyg'] ) ) {
			return;
		}
		$field['options'] = implode( "\n", array_map( function( $option ) {
			return "{$option['key']}:{$option['value']}";
		}, $field['options'] ) );
	}

	private function update_post( $post ) {
		wp_update_post( [
			'ID'           => $post->ID,
			'post_excerpt' => addslashes( $post->post_excerpt ),
			'post_content' => addslashes( $post->post_content ),
		] );
	}
}
