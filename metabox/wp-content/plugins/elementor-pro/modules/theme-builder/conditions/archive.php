<?php
namespace ElementorPro\Modules\ThemeBuilder\Conditions;

use ElementorPro\Classes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Archive extends Condition_Base {

	protected $sub_conditions = [
		'author',
		'date',
		'search',
	];

	public static function get_type() {
		return 'archive';
	}

	public static function get_priority() {
		return 80;
	}

	public function get_name() {
		return 'archive';
	}

	public function get_label() {
		return __( 'Archives', 'elementor-pro' );
	}

	public function get_all_label() {
		return __( 'All Archives', 'elementor-pro' );
	}

	public function register_sub_conditions() {
		$post_types = Utils::get_public_post_types();
		unset( $post_types['product'] );

		foreach ( $post_types as $post_type => $label ) {
			if ( ! get_post_type_archive_link( $post_type ) ) {
				continue;
			}

			$condition = new Post_Type_Archive( [
				'post_type' => $post_type,
			] );

			$this->register_sub_condition( $condition );
		}
	}

	public function check( $args ) {
		return is_archive() || is_home() || is_search();
	}
}
