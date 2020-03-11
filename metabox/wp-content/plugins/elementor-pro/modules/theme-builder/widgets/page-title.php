<?php
namespace ElementorPro\Modules\ThemeBuilder\Widgets;

use Elementor\Widget_Heading;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Page_Title extends Widget_Heading {

	public function get_name() {
		// `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
		return 'theme-page-title';
	}

	public function get_title() {
		return __( 'Page Title', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-archive-title';
	}

	public function get_categories() {
		return [ 'theme-elements' ];
	}

	public function get_keywords() {
		return [ 'title', 'heading', 'page' ];
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->update_control(
			'title',
			[
				'dynamic' => [
					'default' => Plugin::elementor()->dynamic_tags->tag_data_to_tag_text( null, 'page-title' ),
				],
			],
			[
				'recursive' => true,
			]
		);

		$this->update_control(
			'header_size',
			[
				'default' => 'h1',
			]
		);
	}

	protected function get_html_wrapper_class() {
		return parent::get_html_wrapper_class() . ' elementor-page-title elementor-widget-' . parent::get_name();
	}
}
