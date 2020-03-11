<?php
namespace MBB\Fields;

class Divider extends Base {
	public function register_fields() {
		$this->basic = [];
		unset( $this->appearance['placeholder'] );
		unset( $this->appearance['size'] );
		unset( $this->appearance['label_description'] );
		unset( $this->appearance['class'] );
		unset( $this->advanced['custom_attributes'] );
	}
}
