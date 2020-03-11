<?php
namespace MBBlocks;

class MetaBox extends \RW_Meta_Box {
	private $storage;

	public static function normalize( $meta_box ) {
		$meta_box = parent::normalize( $meta_box );

		$meta_box = wp_parse_args( $meta_box, [
			'description' => '',
			'icon'        => 'schedule',
			'category'    => 'layout',
			'keywords'    => [],
			'supports'    => [],
		] );

		// Block preview.
		if ( empty( $meta_box['preview'] ) ) {
			return $meta_box;
		}
		$meta_box['example'] = [
			'attributes' => [
				'data' => $meta_box['preview'],
			],
		];
		unset( $meta_box['preview'] );

		return $meta_box;
	}

	protected function object_hooks() {
		$this->add_block_data();
		$this->register_block_type();

		add_action( 'wp_ajax_mb_blocks_fetch', [ $this, 'fetch' ] );
	}

	private function add_block_data() {
		$block = $this->meta_box;

		// Remove unnecessary keys to keep JSON short and bug away.
		$keys = ['fields', 'autosave', 'default_hidden', 'priority', 'style', 'post_types', 'type'];
		foreach ( $keys as $key ) {
			unset( $block[ $key ] );
		}

		$json = json_encode( $block );
		wp_add_inline_script( 'mb-blocks', "rwmb.blocks.push({$json});", 'before' );
	}

	private function register_block_type() {
		register_block_type( "meta-box/{$this->id}", [
			'editor_script'   => 'mb-blocks',
			'editor_style'    => 'mb-blocks',
			'render_callback' => [$this, 'render'],
		] );
	}

	public function enqueue() {
		parent::enqueue();

		if ( is_admin() && ! $this->is_edit_screen() ) {
			return;
		}

		$this->enqueue_block_assests();
	}

	public function fetch() {
		$block = filter_input( INPUT_POST, 'block', FILTER_SANITIZE_STRING );
		if ( $block !== "meta-box/$this->id" ) {
			return;
		}

		$nonce = filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_STRING );
		if ( ! wp_verify_nonce( $nonce, 'fetch' ) ) {
			return;
		}

		$mode       = filter_input( INPUT_POST, 'mode', FILTER_SANITIZE_STRING );
		$attributes = isset( $_POST['attributes'] ) ? $_POST['attributes'] : [];
		$attributes = wp_unslash( $attributes );
		$this->set_block_data( $attributes );

		if ( 'edit' === $mode ) {
			$this->show();
		} else {
			$this->preview( $attributes );
		}

		die;
	}

	public function render( $attributes = [] ) {
		$this->set_block_data( $attributes );

		ob_start();
		$post_id = get_the_ID();
		$this->render_block( $attributes, false, $post_id );
		return ob_get_clean();
	}

	private function preview( $attributes = [] ) {
		// Alignment is handled by theme editor styles, it should not be outputted in block HTML when preview.
		unset( $attributes['align'] );

		$post_id = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		$this->render_block( $attributes, true, $post_id );
	}

	private function set_block_data( $attributes ) {
		$attributes['name'] = $this->id;
		$data = isset( $attributes['data'] ) ? $attributes['data'] : [];
		$this->storage->set_data( $data );
		ActiveBlock::set_block_name( $this->id );
	}

	private function render_block( $attributes = [], $is_preview = false, $post_id = null ) {
		$this->enqueue_block_assests();

		if ( $this->render_callback ) {
			call_user_func( $this->render_callback, $attributes, $is_preview, $post_id );
			return;
		}

		if ( file_exists( $this->render_template ) ) {
			include $this->render_template;
		} else {
			locate_template( $this->render_template, true );
		}
	}

	private function enqueue_block_assests() {
		$handle = "meta-box/$this->id";

		if ( $this->enqueue_style ) {
			wp_enqueue_style( $handle, $this->enqueue_style );
		}

		if ( $this->enqueue_script ) {
			wp_enqueue_script( $handle, $this->enqueue_script, [ 'jquery' ], '', true );
		}

		if ( $this->enqueue_assets && is_callable( $this->enqueue_assets ) ) {
			call_user_func( $this->enqueue_assets );
		}
	}

	public function get_storage() {
		if ( null === $this->storage ) {
			$this->storage = new Storage;
		}
		return $this->storage;
	}

	public function register_fields() {
		$field_registry = rwmb_get_registry( 'field' );

		foreach ( $this->fields as $field ) {
			$field_registry->add( $field, $this->id, 'block' );
		}
	}

	public function is_edit_screen( $screen = null ) {
		if ( ! ( $screen instanceof WP_Screen ) ) {
			$screen = get_current_screen();
		}
		return 'post' === $screen->base && use_block_editor_for_post_type( $screen->post_type );
	}
}