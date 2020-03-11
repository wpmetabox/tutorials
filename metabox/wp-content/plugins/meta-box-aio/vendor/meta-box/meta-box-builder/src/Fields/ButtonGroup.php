<?php
namespace MBB\Fields;

class ButtonGroup extends CheckboxList {
    public function register_fields() {
    	$fields = [
			'options'  => ['type' => 'textarea', 'label' => __( 'Buttons', 'meta-box-builder' ) . mbb_tooltip( __( 'Enter each button text on a line. For more control, you may specify both a value and label like "red: Red" (without quotes)', 'meta-box-builder' ) )],
			'std'      => ['type' => 'textarea'],
			'multiple' => ['type' => 'checkbox'],
			'inline'   => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
