<?php
namespace MBB\Fields;

class Color extends Base {
    public function register_fields() {
       $fields = [
			'std'           => true,
			'alpha_channel' => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->basic['required'] );
		$fields = [
			'html5_attributes' => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'html5-attributes', '', '', '', ['readonly', 'disabled'] )],
		];
		$this->basic = array_slice( $this->basic, 0, 5, true ) + $fields + array_slice( $this->basic, 5, null, true );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );

		$label  = '<a href="https://automattic.github.io/Iris">' . __( 'Color picker options', 'meta-box-builder' ) . '</a>';
		$fields = [
			'js_options' => [
				'type'    => 'custom',
				'content' => mbb_get_attribute_content( 'key_value', 'js_options', $label, __( '+ Add Option', 'meta-box-builder' ) ),
			],
		];
		$this->advanced = $fields + $this->advanced;
    }
}
