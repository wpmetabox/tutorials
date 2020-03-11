<?php
namespace MBB\Fields;

class KeyValue extends Base {
	public function register_fields() {
		unset( $this->basic['required'] );
		unset( $this->basic['clone'] );

		unset( $this->appearance['placeholder'] );
		$fields = [
			'placeholder.key'   => ['label' => __( 'Placeholder for key', 'meta-box-builder' )],
			'placeholder.value' => ['label' => __( 'Placeholder for value', 'meta-box-builder' )],
		];
		$this->appearance = $fields + $this->appearance;

		unset( $this->advanced['custom_attributes'] );
	}
}
