<?php
namespace MBB\Fields;

class Date extends Base {
	public function register_fields() {
		$fields = [
			'std'       => true,
			'inline'    => ['type' => 'checkbox', 'label' => __( 'Display the date picker inline with the input', 'meta-box-builder' ) . mbb_tooltip( __( 'Do not require to click the input field to trigger the date picker', 'meta-box-builder' ) )],
			'timestamp' => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->basic['required'] );
		$fields = [
			'html5_attributes' => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'html5-attributes', '', '', '', ['required', 'readonly', 'disabled'] )],
		];
		$this->basic = array_slice( $this->basic, 0, 6, true ) + $fields + array_slice( $this->basic, 6, null, true );

		$label  = '<a href="http://api.jqueryui.com/datepicker">' . __( 'Date picker options', 'meta-box-builder ' ) . '</a>';
		$fields = [
			'js_options' => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'key_value', 'js_options', $label, __( '+ Add Option', 'meta-box-builder' ) )],
		];
		$this->advanced = $fields + $this->advanced;

		unset( $this->appearance['placeholder'] );
	}
}
