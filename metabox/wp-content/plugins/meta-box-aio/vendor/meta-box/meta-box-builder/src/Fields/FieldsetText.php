<?php
namespace MBB\Fields;

class FieldsetText extends Base {
    public function register_fields() {
    	$fields = [
			'options' => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'fieldset-text-options', 'options' )],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
		unset( $this->basic['required'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
