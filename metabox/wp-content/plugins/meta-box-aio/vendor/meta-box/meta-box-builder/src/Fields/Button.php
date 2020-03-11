<?php
namespace MBB\Fields;

class Button extends Base {
    public function register_fields() {
		$fields = [
			'std'      => ['type' => 'text', 'label' => __( 'Button text', 'meta-box-builder' )],
			'disabled' => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->basic['required'] );
		unset( $this->basic['clone'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
