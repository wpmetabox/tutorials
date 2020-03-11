<?php
namespace MBB\Fields;

class Hidden extends Base {
    public function register_fields() {
		$this->basic = [
			'id'  => true,
			'std' => true,
		];

		unset( $this->appearance['size'] );
		unset( $this->appearance['label_description'] );
		unset( $this->appearance['placeholder'] );
		unset( $this->advanced['conditional_logic'] );
    }
}
