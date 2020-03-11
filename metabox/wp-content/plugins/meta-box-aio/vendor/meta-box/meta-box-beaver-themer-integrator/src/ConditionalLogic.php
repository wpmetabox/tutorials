<?php
namespace MBBTI;

use BB_Logic_Rules;

class ConditionalLogic {
	public function __construct() {
		if ( did_action( 'bb_logic_init' ) ) {
			$this->init();
		} else {
			add_action( 'bb_logic_init', [ $this, 'init' ] );
		}
	}

	public function init() {
		BB_Logic_Rules::register( [
			'metabox/archive-field'       => [ $this, 'archive_field' ],
			'metabox/post-field'          => [ $this, 'post_field' ],
			'metabox/post-author-field'   => [ $this, 'post_author_field' ],
			'metabox/user-field'          => [ $this, 'user_field' ],
			'metabox/settings-page-field' => [ $this, 'settings_page_field' ],
		] );
		add_action( 'bb_logic_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	public function enqueue() {
		wp_enqueue_script( 'mbbti-logic', plugin_dir_url( __DIR__ ) . 'js/logic.js', ['bb-logic-core'], BB_LOGIC_VERSION, true );
		wp_localize_script( 'mbbti-logic', 'MBBTILogic', [
			'settingsPages' => $this->get_setting_pages(),
		] );
	}

	public function evaluate_rule( $value = false, $rule ) {
		if ( is_array( $value ) ) {
			$value = empty( $value ) ? 0 : 1;
		} elseif ( is_object( $value ) ) {
			$value = 1;
		}

		return BB_Logic_Rules::evaluate_rule( [
			'value'    => $value,
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
			'isset'    => $value,
		] );
	}

	public function archive_field( $rule ) {
		$value = rwmb_meta( $rule->key, ['object_type' => 'term'], get_queried_object_id() );
		return $this->evaluate_rule( $value, $rule );
	}

	public function post_field( $rule ) {
		$value = rwmb_meta( $rule->key );
		return $this->evaluate_rule( $value, $rule );
	}

	public function post_author_field( $rule ) {
		global $post;
		$id    = is_object( $post ) ? $post->post_author : 0;
		$value = rwmb_meta( $rule->key, ['object_type' => 'user'], $post->post_author );

		return $this->evaluate_rule( $value, $rule );
	}

	public function user_field( $rule ) {
		$value = rwmb_meta( $rule->key, ['object_type' => 'user'], get_current_user_id() );
		return $this->evaluate_rule( $value, $rule );
	}

	public function settings_page_field( $rule ) {
		$value = rwmb_meta( $rule->key, ['object_type' => 'setting'], $rule->option_name );
		return $this->evaluate_rule( $value, $rule );
	}

	private function get_setting_pages() {
		$settings_pages = apply_filters( 'mb_settings_pages', [] );
		return array_map( function( $settings_page ) {
			$title = '';
			if ( ! empty( $settings_page['menu_title'] ) ) {
				$title = $settings_page['menu_title'];
			} elseif ( ! empty( $settings_page['page_title'] ) ) {
				$title = $settings_page['page_title'];
			}
			return [
				'value' => $settings_page['option_name'],
				'label' => $title,
			];
		}, $settings_pages );
	}
}
