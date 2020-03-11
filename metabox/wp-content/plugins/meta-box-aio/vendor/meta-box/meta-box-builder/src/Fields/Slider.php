<?php
namespace MBB\Fields;

class Slider extends Base {
	public function register_fields() {
		$fields = [
			'std' => true,
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		$this->appearance['prefix'] = true;
		$this->appearance['suffix'] = true;

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );

		$label = '<a href="https://api.jqueryui.com/slider">' . __( 'jQueryUI slider options', 'meta-box-builder' ) . '</a>';
		$js_options = mbb_get_attribute_content( 'key_value', 'js_options', $label, __( '+ Add Option', 'meta-box-builder' ) );

		$fields = [
			'js_options' => ['type' => 'custom', 'content' => $js_options],
		];
		$this->advanced = $fields + $this->advanced;
	}
}
