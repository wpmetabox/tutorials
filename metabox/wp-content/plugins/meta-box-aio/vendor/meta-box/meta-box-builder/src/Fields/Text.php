<?php
namespace MBB\Fields;

class Text extends Base {
	public function register_fields() {
		$fields = [
			'std' => true,
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->basic['required'] );
		$fields = [
			'html5_attributes' => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'html5-attributes', '', '', '', ['required', 'readonly', 'disabled'] )],
		];
		$this->basic = array_slice( $this->basic, 0, 4, true ) + $fields + array_slice( $this->basic, 4, null, true );

		$this->advanced['datalist_choices'] = array(
			'type'    => 'textarea',
			'label'   => esc_html__( 'Predefined values', 'meta-box-builder' ) . mbb_tooltip( __( 'Known as datalist, these are values that users can select from (they still can enter text if they want). Enter each value on a line.', 'meta-box-builder' ) ),
		);
	}
}
