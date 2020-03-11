<?php
namespace MBB\Fields;

class Autocomplete extends Base {
    public function register_fields() {
    	$fields = [
			'options' => ['type' => 'textarea'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
		unset( $this->basic['required'] );

		unset( $this->appearance['placeholder'] );
    }
}
