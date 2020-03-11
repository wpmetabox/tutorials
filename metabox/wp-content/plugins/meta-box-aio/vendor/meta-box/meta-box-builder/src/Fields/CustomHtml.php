<?php
namespace MBB\Fields;

class CustomHtml extends Base {
	public function register_fields() {
		$fields = [
			'std' => ['type' => 'textarea', 'label' => __( 'Content (HTML allowed)', 'meta-box-builder' )],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['placeholder'] );
		unset( $this->appearance['size'] );
	}
}
