<?php
namespace MBB\Fields;

class User extends Base {
	public function register_fields() {
		$toggle_all = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\' || field.field_type == \'checkbox_list\'">
			<input type="checkbox" ng-model="field.select_all_none" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Display "Toggle All" button', 'meta-box-builder' ) . '
		</label>';

		$multiple = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\'">
			<input type="checkbox" ng-model="field.multiple" 0="ng-change" 1="toggleMultiple()" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Allow to select multiple choices', 'meta-box-builder' ) . '
		</label>';

		$inline = '<label ng-show="field.field_type == \'radio_list\' || field.field_type == \'checkbox_list\'">
			<input type="checkbox" ng-model="field.inline" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Display choices in a single line', 'meta-box-builder' ) . '
		</label>';

		$fields = [
			'field_type'  => [
				'type' => 'custom',
			],
			'select_all_none' => [
				'type'    => 'custom',
				'content' => $toggle_all,
			],
			'multiple' => [
				'type'    => 'custom',
				'content' => $multiple,
			],
			'inline' => [
				'type'    => 'custom',
				'content' => $inline,
			],
		];

		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		$label = '<a href="https://codex.wordpress.org/Function_Reference/get_users">' . __( 'Query arguments', 'meta-box-builder' ) . '</a>' . mbb_tooltip( __( 'Query arguments for getting users. Use the same arguments as get_users().', 'meta-box-builder' ) );
		$query_args = mbb_get_attribute_content( 'key_value', 'query_args',  $label, __( '+ Add Argument', 'meta-box-builder' ) );

		$this->advanced = ['query_args' => ['type' => 'custom', 'content' => $query_args]] + $this->advanced;

		unset( $this->appearance['size'] );
	}
}
