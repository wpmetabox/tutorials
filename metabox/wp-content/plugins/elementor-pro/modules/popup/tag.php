<?php
namespace ElementorPro\Modules\Popup;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag as DynamicTagsTag;
use ElementorPro\Modules\DynamicTags\Module as DynamicTagsModule;
use ElementorPro\Modules\LinkActions\Module as LinkActionsModule;
use ElementorPro\Modules\QueryControl\Module as QueryControlModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Tag extends DynamicTagsTag {

	public function get_name() {
		return 'popup';
	}

	public function get_title() {
		return __( 'Popup', 'elementor-pro' );
	}

	public function get_group() {
		return DynamicTagsModule::ACTION_GROUP;
	}

	public function get_categories() {
		return [ DynamicTagsModule::URL_CATEGORY ];
	}

	public function _register_controls() {
		$this->add_control(
			'action',
			[
				'label' => __( 'Action', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'open',
				'options' => [
					'open' => __( 'Open Popup', 'elementor-pro' ),
					'close' => __( 'Close Popup', 'elementor-pro' ),
					'toggle' => __( 'Toggle Popup', 'elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'popup',
			[
				'label' => __( 'Popup', 'elementor-pro' ),
				'type' => QueryControlModule::QUERY_CONTROL_ID,
				'filter_type' => 'popup_templates',
				'label_block' => true,
				'condition' => [
					'action' => [ 'open', 'toggle' ],
				],
			]
		);

		$this->add_control(
			'do_not_show_again',
			[
				'label' => __( 'Don\'t Show Again', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'action' => 'close',
				],
			]
		);
	}

	public function render() {
		$settings = $this->get_active_settings();

		if ( 'close' === $settings['action'] ) {
			$this->print_close_popup_link( $settings );

			return;
		}

		$this->print_open_popup_link( $settings );
	}

	// Keep Empty to avoid default advanced section
	protected function register_advanced_section() {}

	private function print_open_popup_link( array $settings ) {
		if ( ! $settings['popup'] ) {
			return;
		}

		$link_action_url = LinkActionsModule::create_action_url( 'popup:open', [
			'id' => $settings['popup'],
			'toggle' => 'toggle' === $settings['action'],
		] );

		Module::add_popup_to_location( $settings['popup'] );

		echo $link_action_url;
	}

	private function print_close_popup_link( array $settings ) {
		echo LinkActionsModule::create_action_url( 'popup:close', [ 'do_not_show_again' => $settings['do_not_show_again'] ] );
	}
}
