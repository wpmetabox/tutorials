<?php
namespace MBB\Fields;
class Wysiwyg extends Base {
	public function register_fields() {
		$fields = [
			'std' => ['type' => 'textarea'],
			'raw' => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
		unset( $this->basic['required'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );

		$label = '<a href="https://codex.wordpress.org/Function_Reference/wp_editor" target="_blank">' . __( 'Editor options', 'meta-box-builder' ) . '</a>';
		$options = mbb_get_attribute_content( 'key_value', 'options', $label, __( '+ Add Option', 'meta-box-builder' ) );

		$this->advanced = ['options' => ['type'    => 'custom', 'content' => $options]] + $this->advanced;
	}
}
