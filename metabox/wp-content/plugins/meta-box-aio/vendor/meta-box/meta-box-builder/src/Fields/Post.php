<?php
namespace MBB\Fields;

use MBB\Attribute;

class Post extends Base {
	public function register_fields() {
		$toggle_all = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\' || field.field_type == \'checkbox_list\'">
				<input type="checkbox" ng-model="field.select_all_none" ng-true-value="true" ng-false-value="false"> ' . Attribute::get_label( 'select_all_none' ) . '
			</label>
		';
		$multiple = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\'">
				<input type="checkbox" ng-model="field.multiple"  0="ng-change" 1="toggleMultiple()" ng-true-value="true" ng-false-value="false"> ' . Attribute::get_label( 'multiple' ) . '
			</label>
		';
		$inline = '<label ng-show="field.field_type == \'radio_list\' || field.field_type == \'checkbox_list\'">
				<input type="checkbox" ng-model="field.inline" ng-true-value="true" ng-false-value="false"> ' . Attribute::get_label( 'inline' ) . '
			</label>
		';

		$fields = [
			'post_type'       => ['type' => 'custom'],
			'field_type'      => ['type' => 'custom'],
			'select_all_none' => ['type' => 'custom', 'content' => $toggle_all],
			'inline'          => ['type' => 'custom', 'content' => $inline],
			'multiple'        => ['type' => 'custom', 'content' => $multiple],
			'parent'          => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		$label = '<a href="https://codex.wordpress.org/Class_Reference/WP_Query">' . __( 'Query arguments', 'meta-box-builder' ) . '</a>' . mbb_tooltip( __( 'Query arguments for getting posts. Use the same arguments as WP_Query.', 'meta-box-builder' ) );
		$query_args = mbb_get_attribute_content( 'key_value', 'query_args',  $label, __( '+ Add Argument', 'meta-box-builder' ) );

		$this->advanced = ['query_args' => ['type' => 'custom', 'content' => $query_args]] + $this->advanced;

		unset( $this->appearance['size'] );
	}
}
