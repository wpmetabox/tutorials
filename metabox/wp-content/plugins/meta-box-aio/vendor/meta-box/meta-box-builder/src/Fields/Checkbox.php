<?php
namespace MBB\Fields;

class Checkbox extends Base {
    public function register_fields() {
       $fields = [
			'std' => ['type' => 'checkbox', 'label' => __( 'Default checked?', 'meta-box-builder' )],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->basic['required'] );
		unset( $this->basic['clone'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
