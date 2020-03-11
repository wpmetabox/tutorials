<?php
namespace ElementorPro\Modules\Woocommerce\Classes;

use ElementorPro\Modules\QueryControl\Module as QueryControl;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Products_Renderer extends \WC_Shortcode_Products {

	private $settings = [];
	private $is_added_product_filter = false;

	public function __construct( $settings = [], $type = 'products' ) {
		$this->settings = $settings;
		$this->type = $type;
		$this->attributes = $this->parse_attributes( [
			'columns' => $settings['columns'],
			'rows' => $settings['rows'],
			'paginate' => $settings['paginate'],
			'cache' => false,
		] );
		$this->query_args = $this->parse_query_args();
	}

	/**
	 * Override the original `get_query_results`
	 * with modifications that:
	 * 1. Remove `pre_get_posts` action if `is_added_product_filter`.
	 *
	 * @return bool|mixed|object
	 */

	protected function get_query_results() {
		$results = parent::get_query_results();
		// Start edit.
		if ( $this->is_added_product_filter ) {
			remove_action( 'pre_get_posts', [ wc()->query, 'product_query' ] );
		}
		// End edit.

		return $results;
	}

	protected function parse_query_args() {
		$settings = &$this->settings;
		$query_args = [
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows' => false === wc_string_to_bool( $this->attributes['paginate'] ),
		];

		if ( 'current_query' === $this->settings['query_post_type'] ) {
			if ( ! is_page( wc_get_page_id( 'shop' ) ) ) {
				$query_args = $GLOBALS['wp_query']->query_vars;
			}

			// Fix for parent::get_transient_name.
			if ( ! isset( $query_args['orderby'] ) ) {
				$query_args['orderby'] = '';
				$query_args['order'] = '';
			}

			add_action( 'pre_get_posts', [ wc()->query, 'product_query' ] );
			$this->is_added_product_filter = true;

		} else {
			$query_args = [
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
				'no_found_rows' => false === wc_string_to_bool( $this->attributes['paginate'] ),
				'orderby' => $settings['orderby'],
				'order' => strtoupper( $settings['order'] ),
			];

			$query_args['meta_query'] = WC()->query->get_meta_query();
			$query_args['tax_query'] = [];

			// Visibility.
			$this->set_visibility_query_args( $query_args );

			$this->set_featured_query_args( $query_args );

			// IDs.
			$this->set_ids_query_args( $query_args );

			// Set specific types query args.
			if ( method_exists( $this, "set_{$this->type}_query_args" ) ) {
				$this->{"set_{$this->type}_query_args"}( $query_args );
			}

			// Categories.
			$this->set_categories_query_args( $query_args );

			// Tags.
			$this->set_tags_query_args( $query_args );

			//Exclude.
			$this->set_exclude_query_args( $query_args );

			$query_args = apply_filters( 'woocommerce_shortcode_products_query', $query_args, $this->attributes, $this->type );

			if ( 'yes' === $settings['paginate'] && 'yes' === $settings['allow_order'] ) {
				$ordering_args = WC()->query->get_catalog_ordering_args();
			} else {
				$ordering_args = WC()->query->get_catalog_ordering_args( $query_args['orderby'], $query_args['order'] );
			}

			$query_args['orderby'] = $ordering_args['orderby'];
			$query_args['order'] = $ordering_args['order'];
			if ( $ordering_args['meta_key'] ) {
				$query_args['meta_key'] = $ordering_args['meta_key'];
			}

			$query_args['posts_per_page'] = intval( $settings['columns'] * $settings['rows'] );
		} // End if().

		if ( 'yes' === $settings['paginate'] ) {
			$page = absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] );

			if ( 1 < $page ) {
				$query_args['paged'] = $page;
			}

			if ( 'yes' !== $settings['allow_order'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}

			if ( 'yes' !== $settings['show_result_count'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}
		}
		$query_args['posts_per_page'] = intval( $settings['columns'] * $settings['rows'] );

		// Always query only IDs.
		$query_args['fields'] = 'ids';

		return $query_args;
	}

	protected function set_exclude_query_args( &$query_args ) {
		if ( empty( $this->settings['exclude'] ) ) {
			return;
		}

		$exclude_ids = in_array( 'manual_selection', $this->settings['exclude'], true ) && ! empty( $this->settings['exclude_ids'] ) ? $this->settings['exclude_ids'] : [];

		if ( in_array( 'current_post', $this->settings['exclude'], true ) && is_single() ) {
			$exclude_ids[] = get_queried_object_id();
		}

		if ( ! empty( $this->settings['avoid_duplicates'] ) ) {
			$exclude_ids = array_merge( $exclude_ids, QueryControl::get_avoid_list_ids() );
		}

		if ( ! empty( $exclude_ids ) ) {
			$query_args['post__not_in'] = empty( $query_args['post__not_in'] ) ? $exclude_ids : array_merge( $query_args['post__not_in'], $exclude_ids );
		}
	}

	protected function set_ids_query_args( &$query_args ) {
		switch ( $this->settings['query_post_type'] ) {
			case 'by_id':
				$post__in = $this->settings['query_posts_ids'];
				break;
			case 'sale':
				$post__in = wc_get_product_ids_on_sale();
				break;
		}

		if ( ! empty( $post__in ) ) {
			$query_args['post__in'] = $post__in;
			remove_action( 'pre_get_posts', [ wc()->query, 'product_query' ] );
		}
	}

	protected function set_categories_query_args( &$query_args ) {
		$query_type = $this->settings['query_post_type'];

		if ( 'by_id' === $query_type || 'current_query' === $query_type ) {
			return;
		}

		if ( ! empty( $this->settings['query_product_cat_ids'] ) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'product_cat',
				'terms' => $this->settings['query_product_cat_ids'],
				'field' => 'term_id',
			];
		}
	}

	protected function set_tags_query_args( &$query_args ) {
		$query_type = $this->settings['query_post_type'];

		if ( 'by_id' === $query_type || 'current_query' === $query_type ) {
			return;
		}

		if ( ! empty( $this->settings['query_product_tag_ids'] ) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'product_tag',
				'terms' => $this->settings['query_product_tag_ids'],
				'field' => 'term_id',
				'operator' => 'IN',
			];
		}
	}

	protected function set_featured_query_args( &$query_args ) {
		if ( 'featured' === $this->settings['query_post_type'] ) {
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();

			$query_args['tax_query'][] = [
				'taxonomy' => 'product_visibility',
				'field' => 'term_taxonomy_id',
				'terms' => [ $product_visibility_term_ids['featured'] ],
			];
		}
	}
}
