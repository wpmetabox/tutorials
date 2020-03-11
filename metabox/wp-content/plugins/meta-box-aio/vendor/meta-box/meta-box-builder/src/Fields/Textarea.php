<?php
namespace MBB\Fields;

class Textarea extends Base {
    public function register_fields() {
        $fields = [
			'std' => ['type' => 'textarea'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->basic['required'] );
		$fields = [
			'html5_attributes' => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'html5-attributes', '', '', '', ['required', 'readonly', 'disabled'] )],
		];
		$this->basic = array_slice( $this->basic, 0, 4, true ) + $fields + array_slice( $this->basic, 4, null, true );

		$this->appearance['rows_columns'] = [
			'type' => 'custom',
		];
		unset( $this->appearance['size'] );
    }
}
