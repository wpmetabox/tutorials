<?php
namespace ElementorPro\Modules\Library\Widgets;

use Elementor\Controls_Manager;
use Elementor\TemplateLibrary\Source_Local;
use ElementorPro\Base\Base_Widget;
use ElementorPro\Modules\Library\Module;
use ElementorPro\Modules\QueryControl\Controls\Query;
use ElementorPro\Modules\QueryControl\Module as QueryControlModule;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Template extends Base_Widget {

	public function get_name() {
		return 'template';
	}

	public function get_title() {
		return __( 'Template', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-document-file';
	}

	public function get_keywords() {
		return [ 'elementor', 'template', 'library', 'block', 'page' ];
	}

	public function is_reload_preview_required() {
		return false;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_template',
			[
				'label' => __( 'Template', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'template_id',
			[
				'label' => __( 'Choose Template', 'elementor-pro' ),
				'type' => QueryControlModule::QUERY_CONTROL_ID,
				'filter_type' => 'library_widget_templates',
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$template_id = $this->get_settings( 'template_id' );

		if ( 'publish' !== get_post_status( $template_id ) ) {
			return;
		}

		?>
		<div class="elementor-template">
			<?php
			echo Plugin::elementor()->frontend->get_builder_content_for_display( $template_id );
			?>
		</div>
		<?php
	}

	public function render_plain_content() {}
}
