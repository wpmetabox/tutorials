<?php
namespace MBB;

use Twig_Loader_Array;
use Twig_Environment;

class Register {
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_box' ) );
	}

	public function register_meta_box( $meta_boxes ) {
		$query = new \WP_Query( [
			'post_type'              => 'meta-box',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] );

		foreach ( $query->posts as $post ) {
			$meta_box = mbb_parse_meta_box_settings( $post->post_content );

			$this->transform_for_block( $meta_box );

			$meta_boxes[] = $meta_box;
		}

		return $meta_boxes;
	}

	private function transform_for_block( &$meta_box ) {
		if ( empty( $meta_box['type'] ) || 'block' !== $meta_box['type'] ) {
			return;
		}

		if ( empty( $meta_box['render_code'] ) ) {
			return;
		}

		$meta_box['render_callback'] = function( $attributes, $is_preview = false, $post_id = null ) use ( $meta_box ) {
			$data               = $attributes;
			$data['is_preview'] = $is_preview;
			$data['post_id']    = $post_id;

			// Get all fields data.
			foreach ( $meta_box['fields'] as $field ) {
				$data[ $field['id'] ] = 'group' === $field['type'] ? mb_get_block_field( $field['id'], [] ) : mb_the_block_field( $field['id'], [], false );
			}

			// Proxy for all PHP/WordPress functions.
			$loader     = new Twig_Loader_Array( [
			    'block' => '{% autoescape false %}' . $meta_box['render_code'] . '{% endautoescape %}',
			] );
			$twig       = new Twig_Environment( $loader );
			$data['mb'] = new TwigProxy;

			echo $twig->render( 'block', $data );
		};
	}
}
