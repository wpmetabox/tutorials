<?php
namespace ElementorPro\Modules\QueryControl\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use ElementorPro\Classes\Utils;
use ElementorPro\Modules\QueryControl\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Group_Control_Posts extends Group_Control_Base {

	const INLINE_MAX_RESULTS = 15;

	protected static $fields;

	public static function get_type() {
		return 'posts';
	}

	public static function on_export_remove_setting_from_element( $element, $control_id ) {
		unset( $element['settings'][ $control_id . '_posts_ids' ] );
		unset( $element['settings'][ $control_id . '_authors' ] );

		foreach ( Utils::get_public_post_types() as $post_type => $label ) {
			$taxonomy_filter_args = [
				'show_in_nav_menus' => true,
				'object_type' => [ $post_type ],
			];

			$taxonomies = get_taxonomies( $taxonomy_filter_args, 'objects' );

			foreach ( $taxonomies as $taxonomy => $object ) {
				unset( $element['settings'][ $control_id . '_' . $taxonomy . '_ids' ] );
			}
		}

		return $element;
	}

	protected function init_fields() {
		$fields = [];

		$fields['post_type'] = [
			'label' => __( 'Source', 'elementor-pro' ),
			'type' => Controls_Manager::SELECT,
		];

		$fields['posts_ids'] = [
			'label' => __( 'Search & Select', 'elementor-pro' ),
			'type' => Module::QUERY_CONTROL_ID,
			'post_type' => '',
			'options' => [],
			'label_block' => true,
			'multiple' => true,
			'filter_type' => 'by_id',
			'condition' => [
				'post_type' => 'by_id',
			],
		];

		$fields['authors'] = [
			'label' => __( 'Author', 'elementor-pro' ),
			'label_block' => true,
			'type' => Module::QUERY_CONTROL_ID,
			'multiple' => true,
			'default' => [],
			'options' => [],
			'filter_type' => 'author',
			'condition' => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
		];

		return $fields;
	}

	protected function prepare_fields( $fields ) {
		$args = $this->get_args();

		$post_types = Utils::get_public_post_types( $args );

		$post_types_options = $post_types;

		$post_types_options['by_id'] = __( 'Manual Selection', 'elementor-pro' );
		$post_types_options['current_query'] = __( 'Current Query', 'elementor-pro' );

		$fields['post_type']['options'] = $post_types_options;

		$fields['post_type']['default'] = key( $post_types );

		$fields['posts_ids']['object_type'] = array_keys( $post_types );

		$taxonomy_filter_args = [
			'show_in_nav_menus' => true,
		];

		if ( ! empty( $args['post_type'] ) ) {
			$taxonomy_filter_args['object_type'] = [ $args['post_type'] ];
		}

		$taxonomies = get_taxonomies( $taxonomy_filter_args, 'objects' );

		foreach ( $taxonomies as $taxonomy => $object ) {
			$taxonomy_args = [
				'label' => $object->label,
				'type' => Module::QUERY_CONTROL_ID,
				'label_block' => true,
				'multiple' => true,
				'object_type' => $taxonomy,
				'options' => [],
				'condition' => [
					'post_type' => $object->object_type,
				],
			];

			$count = wp_count_terms( $taxonomy );

			$options = [];

			// For large websites, use Ajax to search
			if ( $count > self::INLINE_MAX_RESULTS ) {
				$taxonomy_args['type'] = Module::QUERY_CONTROL_ID;

				$taxonomy_args['filter_type'] = 'taxonomy';
			} else {
				$taxonomy_args['type'] = Controls_Manager::SELECT2;

				$terms = get_terms( [
					'taxonomy' => $taxonomy,
					'hide_empty' => false,
				] );

				foreach ( $terms as $term ) {
					$options[ $term->term_id ] = $term->name;
				}

				$taxonomy_args['options'] = $options;
			}

			$fields[ $taxonomy . '_ids' ] = $taxonomy_args;
		}

		return parent::prepare_fields( $fields );
	}

	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}
