<?php
namespace ElementorPro\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Posts;
use ElementorPro\Modules\QueryControl\Module;
use ElementorPro\Modules\Woocommerce\Classes\Products_Renderer;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Products extends Products_Base {

	public function get_name() {
		return 'woocommerce-products';
	}

	public function get_title() {
		return __( 'Products', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'product', 'archive' ];
	}

	public function get_categories() {
		return [
			'woocommerce-elements',
		];
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'query' );

		return $element;
	}

	protected function register_query_controls() {
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
				'name' => 'query',
				'post_type' => 'product',
				'fields_options' => [
					'post_type' => [
						'default' => 'product',
						'options' => [
							'current_query' => __( 'Current Query', 'elementor-pro' ),
							'product' => __( 'Latest Products', 'elementor-pro' ),
							'sale' => __( 'Sale', 'elementor-pro' ),
							'featured' => __( 'Featured', 'elementor-pro' ),
							'by_id' => _x( 'Manual Selection', 'Posts Query Control', 'elementor-pro' ),
						],
					],
					'product_cat_ids' => [
						'condition' => [
							'query_post_type!' => [
								'current_query',
								'by_id',
							],
						],
					],
					'product_tag_ids' => [
						'condition' => [
							'query_post_type!' => [
								'current_query',
								'by_id',
							],
						],
					],
				],
				'exclude' => [
					'authors',
				],
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __( 'Date', 'elementor-pro' ),
					'title' => __( 'Title', 'elementor-pro' ),
					'price' => __( 'Price', 'elementor-pro' ),
					'popularity' => __( 'Popularity', 'elementor-pro' ),
					'rating' => __( 'Rating', 'elementor-pro' ),
					'rand' => __( 'Random', 'elementor-pro' ),
					'menu_order' => __( 'Menu Order', 'elementor-pro' ),
				],
				'condition' => [
					'query_post_type!' => 'current_query',
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
					'query_post_type!' => 'current_query',
				],
			]
		);

		Module::add_exclude_controls( $this );

		$this->end_controls_section();
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'elementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'prefix_class' => 'elementor-products-columns%s-',
				'min' => 1,
				'max' => 12,
				'default' => 4,
				'required' => true,
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'required' => false,
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'required' => false,
					],
				],
				'min_affected_device' => [
					Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
					Controls_Stack::RESPONSIVE_TABLET => Controls_Stack::RESPONSIVE_TABLET,
				],
			]
		);

		$this->add_control(
			'rows',
			[
				'label' => __( 'Rows', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'max' => 20,
					],
				],
			]
		);

		$this->add_control(
			'paginate',
			[
				'label' => __( 'Pagination', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->add_control(
			'allow_order',
			[
				'label' => __( 'Allow Order', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_result_count',
			[
				'label' => __( 'Show Result Count', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->register_query_controls();

		parent::_register_controls();
	}

	protected function render() {

		if ( WC()->session ) {
			wc_print_notices();
		}

		// For Products_Renderer.
		if ( ! isset( $GLOBALS['post'] ) ) {
			$GLOBALS['post'] = null; // WPCS: override ok.
		}

		$settings = $this->get_settings();

		$shortcode = new Products_Renderer( $settings, 'products' );

		$content = $shortcode->get_content();

		if ( $content ) {
			echo $content;
		} elseif ( $this->get_settings( 'nothing_found_message' ) ) {
			echo '<div class="elementor-nothing-found elementor-products-nothing-found">' . esc_html( $this->get_settings( 'nothing_found_message' ) ) . '</div>';
		}
	}

	public function render_plain_content() {}
}
