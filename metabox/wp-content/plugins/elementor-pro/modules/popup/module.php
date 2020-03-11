<?php
namespace ElementorPro\Modules\Popup;

use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\Core\Documents_Manager;
use Elementor\TemplateLibrary\Source_Local;
use ElementorPro\Base\Module_Base;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {
	const DOCUMENT_TYPE = 'popup';

	public function __construct() {
		parent::__construct();

		add_action( 'elementor/documents/register', [ $this, 'register_documents' ] );
		add_action( 'elementor/theme/register_locations', [ $this, 'register_location' ] );
		add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'register_tag' ] );
		add_action( 'elementor/ajax/register_actions', [ $this, 'register_ajax_actions' ] );

		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'wp_footer', [ $this, 'print_popups' ] );
		add_action( 'elementor_pro/init', [ $this, 'add_form_action' ] );

		add_filter( 'elementor_pro/editor/localize_settings', [ $this, 'localize_settings' ] );
		add_filter( 'elementor_pro/query_control/get_autocomplete/popup_templates', [ $this, 'get_autocomplete_for_popup_templates' ], 10, 2 );
		add_filter( 'elementor_pro/query_control/get_value_titles/popup_templates', [ $this, 'get_titles_for_popup_templates' ], 10, 2 );
		add_filter( 'elementor/finder/categories', [ $this, 'add_finder_items' ] );
	}

	public function get_name() {
		return 'popup';
	}

	public function add_form_action() {
		$this->add_component( 'form-action', new Form_Action() );
	}

	public static function add_popup_to_location( $popup_id ) {
		/** @var \ElementorPro\Modules\ThemeBuilder\Module $theme_builder */
		$theme_builder = Plugin::instance()->modules_manager->get_modules( 'theme-builder' );

		$theme_builder->get_locations_manager()->add_doc_to_location( Document::get_property( 'location' ), $popup_id );
	}

	/**
	 * @param Documents_Manager $documents_manager
	 */
	public function register_documents( $documents_manager ) {
		$documents_manager->register_document_type( self::DOCUMENT_TYPE, Document::get_class_full_name() );
	}

	/**
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $location_manager
	 */
	public function register_location( $location_manager ) {
		$location_manager->register_location(
			'popup',
			[
				'label' => __( 'Popup', 'elementor-pro' ),
				'multiple' => true,
				'public' => false,
				'edit_in_content' => false,
			]
		);
	}

	public function print_popups() {
		elementor_theme_do_location( 'popup' );
	}

	/**
	 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags
	 */
	public function register_tag( $dynamic_tags ) {
		$dynamic_tags->register_tag( __NAMESPACE__ . '\Tag' );
	}

	public function get_autocomplete_for_popup_templates( array $results, array $data ) {
		$query_params = [
			's' => $data['q'],
			'post_type' => Source_Local::CPT,
			'posts_per_page' => 20,
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_query' => [
				[
					'key' => Document::TYPE_META_KEY,
					'value' => 'popup',
				],
			],
		];

		$query = new \WP_Query( $query_params );

		foreach ( $query->posts as $post ) {
			$document = Plugin::elementor()->documents->get( $post->ID );

			if ( $document ) {
				$results[] = [
					'id' => $post->ID,
					'text' => $post->post_title,
				];
			}
		}

		return $results;
	}

	public function get_titles_for_popup_templates( array $results, array $data ) {
		$document = Plugin::elementor()->documents->get( $data['id'] );

		if ( $document ) {
			$results[ $data['id'] ] = $document->get_post()->post_title;
		}

		return $results;
	}

	public function register_ajax_actions( Ajax $ajax ) {
		$ajax->register_ajax_action( 'pro_popup_save_display_settings', [ $this, 'save_display_settings' ] );
	}

	public function localize_settings( array $settings ) {
		$settings = array_replace_recursive( $settings, [
			'i18n' => [
				'popups' => __( 'Popups', 'elementor-pro' ),
				'triggers' => __( 'Triggers', 'elementor-pro' ),
				'timing' => __( 'Advanced Rules', 'elementor-pro' ),
				'popup_publish_screen_triggers_description' => __( 'What action the user needs to do for the popup to open.', 'elementor-pro' ),
				'popup_publish_screen_timing_description' => __( 'Requirements that have to be met for the popup to open.', 'elementor-pro' ),
				'popup_settings_introduction_title' => __( 'Please Note', 'elementor-pro' ),
				'popup_settings_introduction_message' => __( 'Popup settings are accessed via the settings icon in the bottom menu', 'elementor-pro' ),
			],
		] );

		return $settings;
	}

	public function save_display_settings( $data ) {
		/** @var Document $popup_document */
		$popup_document = Plugin::elementor()->documents->get( $data['editor_post_id'] );

		$popup_document->save_display_settings_data( $data['settings'] );
	}

	/**
	 * Add New item to admin menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 2.4.0
	 * @access public
	 */
	public function admin_menu() {
		add_submenu_page( Source_Local::ADMIN_MENU_SLUG, '', __( 'Popups', 'elementor-pro' ), 'publish_posts', $this->get_admin_url( true ) );
	}

	public function add_finder_items( array $categories ) {
		$categories['general']['items']['popups'] = [
			'title' => __( 'Popups', 'elementor-pro' ),
			'icon' => 'library-save',
			'url' => $this->get_admin_url(),
			'keywords' => [ 'template', 'popup', 'library' ],
		];

		$categories['create']['items']['popups'] = [
			'title' => __( 'Add New Popup', 'elementor-pro' ),
			'icon' => 'plus-circle',
			'url' => $this->get_admin_url() . '#add_new',
			'keywords' => [ 'template', 'theme', 'popup', 'new', 'create' ],
		];

		return $categories;

	}

	private function get_admin_url( $relative = false ) {
		$base_url = Source_Local::ADMIN_MENU_SLUG;
		if ( ! $relative ) {
			$base_url = admin_url( $base_url );
		}

		return add_query_arg(
			[
				'tabs_group' => 'popup',
				'elementor_library_type' => 'popup',
			],
			$base_url
		);
	}
}
