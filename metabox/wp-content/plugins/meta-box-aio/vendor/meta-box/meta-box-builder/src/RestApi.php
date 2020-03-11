<?php
namespace MBB;

use WP_REST_Server;
use WP_REST_Request;
use WP_Query;
use RWMB_Helpers_Array;

class RestApi {
	public function __construct() {
		add_action( 'rest_api_init', [$this, 'register_routes'] );
	}

	public function register_routes() {
		register_rest_route( 'mbb', 'terms', [
			'method' => WP_REST_Server::READABLE,
			'callback' => [$this, 'get_terms'],
			'permission_callback' => [$this, 'has_permission'],
			'args' => [
				'taxonomy' => [
					'default' => 'category',
					'sanitize_callback' => 'sanitize_title',
				],
			],
		] );
		register_rest_route( 'mbb', 'posts', [
			'method' => WP_REST_Server::READABLE,
			'callback' => [$this, 'get_posts'],
			'permission_callback' => [$this, 'has_permission'],
			'args' => [
				'term' => [
					'sanitize_callback' => 'sanitize_text_field',
				],
				'_type' => [
					'sanitize_callback' => 'sanitize_text_field',
				],
				'ids' => [
					'sanitize_callback' => 'sanitize_text_field',
				],
				'page' => [
					'sanitize_callback' => 'absint',
				],
			],
		] );
		register_rest_route( 'mbb', 'users', [
			'method' => WP_REST_Server::READABLE,
			'callback' => [$this, 'get_users'],
			'permission_callback' => [$this, 'has_permission'],
			'args' => [
				'term' => [
					'sanitize_callback' => 'sanitize_text_field',
				],
				'_type' => [
					'sanitize_callback' => 'sanitize_text_field',
				],
				'ids' => [
					'sanitize_callback' => 'sanitize_text_field',
				],
				'page' => [
					'sanitize_callback' => 'absint',
				],
			],
		] );
	}

	public function get_terms( WP_REST_Request $request ) {
		return get_terms( [
			'taxonomy' => $request->get_param( 'taxonomy' ),
			'orderby' => 'name',
			'number' => 0,
			'hide_empty' => false,
		] );
	}

	public function get_posts( WP_REST_Request $request ) {
		$ids         = RWMB_Helpers_Array::from_csv( $request->get_param( 'ids' ) );
		$search_term = $request->get_param( 'term' );
		$paged       = 'query:append' === $request->get_param( '_type' ) ? $request->get_param( 'page' ) : null;
		$post_types  = wp_list_pluck( mbb_get_post_types(), 'slug' );
		$limit       = 10;

		$args = array_filter( [
			'post_type'              => $post_types,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			's'                      => $search_term,
			'paged'                  => $paged,
			'posts_per_page'         => $ids ? count( $ids ) : $limit,
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'post__in'               => $ids,
		] );

		// Get from cache to prevent same queries.
		$last_changed = wp_cache_get_last_changed( 'posts' );
		$key          = md5( serialize( $args ) );
		$cache_key    = "$key:$last_changed";
		$items        = wp_cache_get( $cache_key, 'mbb-posts' );

		if ( false === $items ) {
			$query   = new WP_Query( $args );
			$items   = [];
			foreach ( $query->posts as $post ) {
				$items[] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}

			// Cache the query.
			wp_cache_set( $cache_key, $items, 'mbb-posts' );
		}

		$data = ['results' => $items];

		// More items for pagination.
		if ( count( $items ) === 10 ) {
			$data['pagination'] = ['more' => true];
		}

		return $data;
	}

	public function get_users( WP_REST_Request $request ) {
		$ids         = RWMB_Helpers_Array::from_csv( $request->get_param( 'ids' ) );
		$search_term = $request->get_param( 'term' );
		$paged       = 'query:append' === $request->get_param( '_type' ) ? $request->get_param( 'page' ) : '';
		$limit       = 10;

		$args = array_filter( [
			'search'  => "*{$search_term}*",
			'paged'   => $paged,
			'number'  => $ids ? count( $ids ) : $limit,
			'orderby' => 'display_name',
			'order'   => 'ASC',
			'include' => $ids,
			'fields'  => ['ID', 'display_name'],
		] );

		// Get from cache to prevent same queries.
		$last_changed = wp_cache_get_last_changed( 'users' );
		$key          = md5( serialize( $args ) );
		$cache_key    = "$key:$last_changed";
		$items        = wp_cache_get( $cache_key, 'mbb-users' );

		if ( false === $items ) {
			$users = get_users( $args );
			$items = [];
			foreach ( $users as $user ) {
				$items[] = [
					'id'   => $user->ID,
					'text' => $user->display_name,
				];
			}

			// Cache the query.
			wp_cache_set( $cache_key, $items, 'mbb-users' );
		}

		$data = ['results' => $items];

		// More items for pagination.
		if ( count( $items ) === 10 ) {
			$data['pagination'] = ['more' => true];
		}

		return $data;
	}

	public function has_permission() {
		return current_user_can( 'manage_options' );
	}
}