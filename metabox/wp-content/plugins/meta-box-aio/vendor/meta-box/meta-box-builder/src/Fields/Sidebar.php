<?php
namespace MBB\Fields;

class Sidebar extends Base {
	public function register_fields() {
		$fields = [
			'field_type' => ['type' => 'custom'],
			'std'        => ['type' => 'textarea'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['size'] );
	}
}
