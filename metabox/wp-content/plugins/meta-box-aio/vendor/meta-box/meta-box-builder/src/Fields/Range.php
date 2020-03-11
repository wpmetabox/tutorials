<?php
namespace MBB\Fields;

class Range extends Base {
	public function register_fields() {
	   $fields = [
			'minmax' => ['type' => 'custom'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
	}
}
