<?php
namespace MBB\Fields;

class Select extends Base {
	public function register_fields() {
		$fields = [
			'options'         => ['type' => 'textarea'],
			'std'             => ['type' => 'textarea'],
			'select_all_none' => ['type' => 'checkbox'],
			'multiple'        => ['type' => 'checkbox', 'attrs' => ['ng-change', 'toggleMultiple()']],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->basic['required'] );
		$fields = [
			'html5_attributes' => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'html5-attributes', '', '', '', ['required', 'disabled'] )],
		];
		$this->basic = array_slice( $this->basic, 0, 7, true ) + $fields + array_slice( $this->basic, 4, null, true );

		unset( $this->appearance['size'] );
	}
}
