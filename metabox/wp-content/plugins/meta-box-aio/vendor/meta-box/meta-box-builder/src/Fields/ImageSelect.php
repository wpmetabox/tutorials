<?php
namespace MBB\Fields;

class ImageSelect extends Base {
	public function register_fields() {
		$fields = [
			'options'  => ['type' => 'textarea', 'label' => __( 'Choices', 'meta-box-builder' ) . mbb_tooltip( __( 'Enter each choice on a line in format "value: http://url-to-image.jpg" (without quotes)', 'meta-box-builder' ) )],
			'std'      => true,
			'multiple' => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
	}
}
