<?php
namespace MBB\Fields;

class Heading extends Base {
    public function register_fields() {
		$this->basic = [
			'name' => true,
			'desc' => ['type' => 'textarea'],
		];

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
