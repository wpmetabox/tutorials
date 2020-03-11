<?php
namespace ElementorPro\Modules\DynamicTags\Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use ElementorPro\Modules\DynamicTags\Module;
use ElementorPro\Classes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Post_Terms extends Tag {
	public function get_name() {
		return 'post-terms';
	}

	public function get_title() {
		return __( 'Post Terms', 'elementor-pro' );
	}

	public function get_group() {
		return Module::POST_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	protected function _register_controls() {
		$taxonomy_filter_args = [
			'show_in_nav_menus' => true,
			'object_type' => [ get_post_type() ],
		];

		/**
		 * Dynamic tags taxonomy args.
		 *
		 * Filters the taxonomy arguments used to retrieve the registered taxonomies
		 * displayed in the taxonomy dynamic tag.
		 *
		 * @since 2.0.0
		 *
		 * @param array $taxonomy_filter_args An array of `key => value` arguments to
		 *                                    match against the taxonomy objects inside
		 *                                    the `get_taxonomies()` function.
		 */
		$taxonomy_filter_args = apply_filters( 'elementor_pro/dynamic_tags/post_terms/taxonomy_args', $taxonomy_filter_args );

		$taxonomies = Utils::get_taxonomies( $taxonomy_filter_args, 'objects' );

		$options = [];

		foreach ( $taxonomies as $taxonomy => $object ) {
			$options[ $taxonomy ] = $object->label;
		}

		$this->add_control(
			'taxonomy',
			[
				'label' => __( 'Taxonomy', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => $options,
				'default' => 'post_tag',
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => __( 'Separator', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => ', ',
			]
		);
	}

	public function render() {
		$settings = $this->get_settings();

		$value = get_the_term_list( get_the_ID(), $settings['taxonomy'], '', $settings['separator'] );

		echo wp_kses_post( $value );
	}
}
