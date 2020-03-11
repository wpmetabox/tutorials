<?php
namespace MBB\Fields;

class Group extends Base {
    public function register_fields() {
        $fields = [
			'collapsible' => ['type' => 'custom'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
		unset( $this->basic['required'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
