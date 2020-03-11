<?php
namespace ElementorPro\Modules\QueryControl;

use Elementor\Controls_Manager;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\Widget_Base;
use ElementorPro\Base\Module_Base;
use ElementorPro\Classes\Utils;
use Elementor\Utils as ElementorUtils;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Posts;
use ElementorPro\Modules\QueryControl\Controls\Query;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {

	const QUERY_CONTROL_ID = 'query';

	public static $displayed_ids = [];

	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}

	public static function add_to_avoid_list( $ids ) {
		self::$displayed_ids = array_merge( self::$displayed_ids, $ids );
	}

	public static function get_avoid_list_ids() {
		return self::$displayed_ids;
	}

	/**
	 * @param Widget_Base $widget
	 */
	public static function add_exclude_controls( $widget ) {
		$widget->add_control(
			'exclude',
			[
				'label' => __( 'Exclude', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'current_post' => __( 'Current Post', 'elementor-pro' ),
					'manual_selection' => __( 'Manual Selection', 'elementor-pro' ),
				],
				'label_block' => true,
			]
		);

		$widget->add_control(
			'exclude_ids',
			[
				'label' => __( 'Search & Select', 'elementor-pro' ),
				'type' => self::QUERY_CONTROL_ID,
				'post_type' => '',
				'options' => [],
				'label_block' => true,
				'multiple' => true,
				'filter_type' => 'by_id',
				'condition' => [
					'exclude' => 'manual_selection',
				],
			]
		);

		$widget->add_control(
			'avoid_duplicates',
			[
				'label' => __( 'Avoid Duplicates', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'description' => __( 'Set to Yes to avoid duplicate posts from showing up on the page. This only affects the frontend.', 'elementor-pro' ),
			]
		);

	}

	public function get_name() {
		return 'query-control';
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function ajax_posts_filter_autocomplete( array $data ) {
		if ( empty( $data['filter_type'] ) || empty( $data['q'] ) ) {
			throw new \Exception( 'Bad Request' );
		}

		$results = [];

		switch ( $data['filter_type'] ) {
			case 'taxonomy':
				$query_params = [
					'taxonomy' => $this->extract_post_type( $data ),
					'search' => $data['q'],
					'hide_empty' => false,
				];

				$terms = get_terms( $query_params );

				global $wp_taxonomies;

				foreach ( $terms as $term ) {
					$term_name = $this->get_term_name_with_parents( $term );
					if ( ! empty( $data['include_type'] ) ) {
						$text = $wp_taxonomies[ $term->taxonomy ]->labels->singular_name . ': ' . $term_name;
					} else {
						$text = $term_name;
					}

					$results[] = [
						'id' => $term->term_id,
						'text' => $text,
					];
				}

				break;

			case 'by_id':
			case 'post':
				$query_params = [
					'post_type' => $this->extract_post_type( $data ),
					's' => $data['q'],
					'posts_per_page' => -1,
				];

				if ( 'attachment' === $query_params['post_type'] ) {
					$query_params['post_status'] = 'inherit';
				}

				$query = new \WP_Query( $query_params );

				foreach ( $query->posts as $post ) {
					$post_type_obj = get_post_type_object( $post->post_type );
					if ( ! empty( $data['include_type'] ) ) {
						$text = $post_type_obj->labels->singular_name . ': ' . $post->post_title;
					} else {
						$text = ( $post_type_obj->hierarchical ) ? $this->get_post_name_with_parents( $post ) : $post->post_title;
					}

					$results[] = [
						'id' => $post->ID,
						'text' => $text,
					];
				}
				break;

			case 'author':
				$query_params = [
					'who' => 'authors',
					'has_published_posts' => true,
					'fields' => [
						'ID',
						'display_name',
					],
					'search' => '*' . $data['q'] . '*',
					'search_columns' => [
						'user_login',
						'user_nicename',
					],
				];

				$user_query = new \WP_User_Query( $query_params );

				foreach ( $user_query->get_results() as $author ) {
					$results[] = [
						'id' => $author->ID,
						'text' => $author->display_name,
					];
				}
				break;
			default:
				$results = apply_filters( 'elementor_pro/query_control/get_autocomplete/' . $data['filter_type'], [], $data );
		} // End switch().

		return [
			'results' => $results,
		];
	}

	public function ajax_posts_control_value_titles( $request ) {
		$ids = (array) $request['id'];

		$results = [];

		switch ( $request['filter_type'] ) {
			case 'taxonomy':
				$terms = get_terms(
					[
						'include' => $ids,
						'hide_empty' => false,
					]
				);

				foreach ( $terms as $term ) {
					$results[ $term->term_id ] = $term->name;
				}
				break;

			case 'by_id':
			case 'post':
				$query = new \WP_Query(
					[
						'post_type' => 'any',
						'post__in' => $ids,
						'posts_per_page' => -1,
					]
				);

				foreach ( $query->posts as $post ) {
					$results[ $post->ID ] = $post->post_title;
				}
				break;

			case 'author':
				$query_params = [
					'who' => 'authors',
					'has_published_posts' => true,
					'fields' => [
						'ID',
						'display_name',
					],
					'include' => $ids,
				];

				$user_query = new \WP_User_Query( $query_params );

				foreach ( $user_query->get_results() as $author ) {
					$results[ $author->ID ] = $author->display_name;
				}
				break;
			default:
				$results = apply_filters( 'elementor_pro/query_control/get_value_titles/' . $request['filter_type'], [], $request );
		}

		return $results;
	}

	public function register_controls() {
		$controls_manager = Plugin::elementor()->controls_manager;

		$controls_manager->add_group_control( Group_Control_Posts::get_type(), new Group_Control_Posts() );

		$controls_manager->register_control( self::QUERY_CONTROL_ID, new Query() );
	}

	private function extract_post_type( $data ) {

		if ( ! empty( $data['query'] ) && ! empty( $data['query']['post_type'] ) ) {
			return $data['query']['post_type'];
		}

		return $data['object_type'];
	}

	/**
	 * get_term_name_with_parents
	 * @param \WP_Term $term
	 * @param int $max
	 *
	 * @return string
	 */
	private function get_term_name_with_parents( \WP_Term $term, $max = 3 ) {
		if ( 0 === $term->parent ) {
			return $term->name;
		}
		$separator = is_rtl() ? ' < ' : ' > ';
		$test_term = $term;
		$names = [];
		while ( $test_term->parent > 0 ) {
			$test_term = get_term_by( 'id', $test_term->parent, $test_term->taxonomy );
			if ( ! $test_term ) {
				break;
			}
			$names[] = $test_term->name;
		}

		$names = array_reverse( $names );
		if ( count( $names ) < ( $max ) ) {
			return implode( $separator, $names ) . $separator . $term->name;
		}

		$name_string = '';
		for ( $i = 0; $i < ( $max - 1 ); $i++ ) {
			$name_string .= $names[ $i ] . $separator;
		}
		return $name_string . '...' . $separator . $term->name;
	}

	/**
	 * get post name with parents
	 * @param \WP_Post $post
	 * @param int $max
	 *
	 * @return string
	 */
	private function get_post_name_with_parents( $post, $max = 3 ) {
		if ( 0 === $post->post_parent ) {
			return $post->post_title;
		}
		$separator = is_rtl() ? ' < ' : ' > ';
		$test_post = $post;
		$names = [];
		while ( $test_post->post_parent > 0 ) {
			$test_post = get_post( $test_post->post_parent );
			if ( ! $test_post ) {
				break;
			}
			$names[] = $test_post->post_title;
		}

		$names = array_reverse( $names );
		if ( count( $names ) < ( $max ) ) {
			return implode( $separator, $names ) . $separator . $post->post_title;
		}

		$name_string = '';
		for ( $i = 0; $i < ( $max - 1 ); $i++ ) {
			$name_string .= $names[ $i ] . $separator;
		}
		return $name_string . '...' . $separator . $post->post_title;
	}

	public static function get_query_args( $control_id, $settings ) {
		$defaults = [
			$control_id . '_post_type' => 'post',
			$control_id . '_posts_ids' => [],
			'orderby' => 'date',
			'order' => 'desc',
			'posts_per_page' => 3,
			'offset' => 0,
		];

		$settings = wp_parse_args( $settings, $defaults );

		$post_type = $settings[ $control_id . '_post_type' ];

		if ( 'current_query' === $post_type ) {
			$current_query_vars = $GLOBALS['wp_query']->query_vars;

			/**
			 * Current query variables.
			 *
			 * Filters the query variables for the current query.
			 *
			 * @since 1.0.0
			 *
			 * @param array $current_query_vars Current query variables.
			 */
			$current_query_vars = apply_filters( 'elementor_pro/query_control/get_query_args/current_query', $current_query_vars );

			return $current_query_vars;
		}

		$query_args = [
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
			'ignore_sticky_posts' => 1,
			'post_status' => 'publish', // Hide drafts/private posts for admins
		];

		if ( 'by_id' === $post_type ) {
			$post_types = Utils::get_public_post_types();

			$query_args['post_type'] = array_keys( $post_types );
			$query_args['posts_per_page'] = -1;

			$query_args['post__in'] = $settings[ $control_id . '_posts_ids' ];

			if ( empty( $query_args['post__in'] ) ) {
				// If no selection - return an empty query
				$query_args['post__in'] = [ 0 ];
			}
		} else {
			$query_args['post_type'] = $post_type;
			$query_args['posts_per_page'] = $settings['posts_per_page'];
			$query_args['tax_query'] = [];

			if ( 0 < $settings['offset'] ) {
				/**
				 * Due to a WordPress bug, the offset will be set later, in $this->fix_query_offset()
				 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
				 */
				$query_args['offset_to_fix'] = $settings['offset'];
			}

			$taxonomies = get_object_taxonomies( $post_type, 'objects' );

			foreach ( $taxonomies as $object ) {
				$setting_key = $control_id . '_' . $object->name . '_ids';

				if ( ! empty( $settings[ $setting_key ] ) ) {
					$query_args['tax_query'][] = [
						'taxonomy' => $object->name,
						'field' => 'term_id',
						'terms' => $settings[ $setting_key ],
					];
				}
			}
		}

		if ( ! empty( $settings[ $control_id . '_authors' ] ) ) {
			$query_args['author__in'] = $settings[ $control_id . '_authors' ];
		}

		$post__not_in = [];
		if ( ! empty( $settings['exclude'] ) ) {
			if ( in_array( 'current_post', $settings['exclude'] ) ) {
				if ( ElementorUtils::is_ajax() && ! empty( $_REQUEST['post_id'] ) ) {
					$post__not_in[] = $_REQUEST['post_id'];
				} elseif ( is_singular() ) {
					$post__not_in[] = get_queried_object_id();
				}
			}

			if ( in_array( 'manual_selection', $settings['exclude'] ) && ! empty( $settings['exclude_ids'] ) ) {
				$post__not_in = array_merge( $post__not_in, $settings['exclude_ids'] );
			}
		}

		if ( ! empty( $settings['avoid_duplicates'] ) && 'yes' === $settings['avoid_duplicates'] ) {
			$post__not_in = array_merge( $post__not_in, self::$displayed_ids );
		}

		$query_args['post__not_in'] = $post__not_in;

		return $query_args;
	}

	/**
	 * @param \WP_Query $query
	 */
	public function fix_query_offset( &$query ) {
		if ( ! empty( $query->query_vars['offset_to_fix'] ) ) {
			if ( $query->is_paged ) {
				$query->query_vars['offset'] = $query->query_vars['offset_to_fix'] + ( ( $query->query_vars['paged'] - 1 ) * $query->query_vars['posts_per_page'] );
			} else {
				$query->query_vars['offset'] = $query->query_vars['offset_to_fix'];
			}
		}
	}

	/**
	 * @param int       $found_posts
	 * @param \WP_Query $query
	 *
	 * @return mixed
	 */
	public function fix_query_found_posts( $found_posts, $query ) {
		$offset_to_fix = $query->get( 'offset_to_fix' );

		if ( $offset_to_fix ) {
			$found_posts -= $offset_to_fix;
		}

		return $found_posts;
	}

	/**
	 * @param Ajax $ajax_manager
	 */
	public function register_ajax_actions( $ajax_manager ) {
		$ajax_manager->register_ajax_action( 'query_control_value_titles', [ $this, 'ajax_posts_control_value_titles' ] );
		$ajax_manager->register_ajax_action( 'pro_panel_posts_control_filter_autocomplete', [ $this, 'ajax_posts_filter_autocomplete' ] );
	}

	public function localize_settings( $settings ) {
		$settings = array_replace_recursive( $settings, [
			'i18n' => [
				'all' => __( 'All', 'elementor-pro' ),
			],
		] );

		return $settings;
	}

	protected function add_actions() {
		add_action( 'elementor/ajax/register_actions', [ $this, 'register_ajax_actions' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

		add_filter( 'elementor_pro/editor/localize_settings', [ $this, 'localize_settings' ] );

		/**
		 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
		 */
		add_action( 'pre_get_posts', [ $this, 'fix_query_offset' ], 1 );
		add_filter( 'found_posts', [ $this, 'fix_query_found_posts' ], 1, 2 );
	}
}
