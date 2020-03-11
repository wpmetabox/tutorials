<?php
namespace MBB\Fields;

class SelectAdvanced extends Select {
	public function register_fields() {
		parent::register_fields();

		$label = '<a href="https://select2.org/configuration">' . __( 'Select2 options', 'meta-box-builder' ) . '</a>';
		$js_options = mbb_get_attribute_content( 'key_value', 'js_options', $label, __( '+ Add Option', 'meta-box-builder' ) );

		$fields = [
			'js_options' => ['type' => 'custom', 'content' => $js_options]
		];
		$this->advanced = $fields + $this->advanced;
	}
}
