<?php
namespace MBB\Fields;

class Radio extends Base {
	public function register_fields() {
		$fields = [
			'options' => ['type' => 'textarea'],
			'std'     => true,
			'inline'  => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
	}
}
