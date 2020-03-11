<?php
namespace ElementorPro\Modules\Posts\Widgets;

use Elementor\Controls_Manager;
use ElementorPro\Modules\QueryControl\Module as Query_Control;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Posts;
use ElementorPro\Modules\Posts\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Posts
 */
class Posts extends Posts_Base {

	public function get_name() {
		return 'posts';
	}

	public function get_title() {
		return __( 'Posts', 'elementor-pro' );
	}

	public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );

		return $element;
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Classic( $this ) );
		$this->add_skin( new Skins\Skin_Cards( $this ) );
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->register_query_section_controls();
		$this->register_pagination_section_controls();
	}

	public function query_posts() {
		$avoid_duplicates = $this->get_settings( 'avoid_duplicates' );
		$query_args = Query_Control::get_query_args( 'posts', $this->get_settings() );

		$query_args['posts_per_page'] = $this->get_current_skin()->get_instance_value( 'posts_per_page' );
		$query_args['paged'] = $this->get_current_page();

		$query_id = $this->get_settings( 'posts_query_id' );
		if ( ! empty( $query_id ) ) {
			add_action( 'pre_get_posts', [ $this, 'pre_get_posts_filter' ] );
			$this->query = new \WP_Query( $query_args );
			remove_action( 'pre_get_posts', [ $this, 'pre_get_posts_filter' ] );
		} else {
			$this->query = new \WP_Query( $query_args );
		}
		Query_Control::add_to_avoid_list( wp_list_pluck( $this->query->posts, 'ID' ) );
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Posts::get_type(),
			[
				'name' => 'posts',
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'posts_post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'elementor-pro' ),
					'post_title' => __( 'Title', 'elementor-pro' ),
					'menu_order' => __( 'Menu Order', 'elementor-pro' ),
					'rand' => __( 'Random', 'elementor-pro' ),
				],
				'condition' => [
					'posts_post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'elementor-pro' ),
					'desc' => __( 'DESC', 'elementor-pro' ),
				],
				'condition' => [
					'posts_post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'condition' => [
					'posts_post_type!' => [
						'by_id',
						'current_query',
					],
				],
				'description' => __( 'Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'elementor-pro' ),
			]
		);

		Query_Control::add_exclude_controls( $this );

		$this->add_control(
			'posts_query_id',
			[
				'label' => __( 'Query ID', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'Give your Query a custom unique id to allow server side filtering', 'elementor-pro' ),
			]
		);

		$this->end_controls_section();
	}

	public function pre_get_posts_filter( $wp_query ) {
		$query_id = $this->get_settings( 'posts_query_id' );

		/**
		 * Elementor Pro posts widget Query args.
		 *
		 * It allows developers to alter individual posts widget queries.
		 *
		 * The dynamic portion of the hook name, `$query_id`, refers to the Query ID.
		 *
		 * @since 2.1.0
		 *
		 * @param \WP_Query $wp_query
		 * @param Posts     $this
		 */
		do_action( "elementor_pro/posts/query/{$query_id}", $wp_query, $this );
	}
}
