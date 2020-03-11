<?php
namespace MBB\Fields;

class CheckboxList extends Base {
    public function register_fields() {
		$fields = [
			'options'         => ['type' => 'textarea'],
			'std'             => ['type' => 'textarea'],
			'inline'          => ['type' => 'checkbox'],
			'select_all_none' => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
		unset( $this->basic['required'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
