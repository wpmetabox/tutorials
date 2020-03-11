<?php
namespace MBB\Fields;

class Taxonomy extends Base {
	public function register_fields() {
		$taxonomy = '
			<label for="{{field.id}}_taxonomy">' . esc_html__( 'Taxonomy', 'meta-box-builder' ) . '</label>
			<select ng-model="field.taxonomy" ng-options="tax.slug as tax.name for tax in taxonomies" class="widefat" id="{{field.id}}_taxonomy" ng-change="fetchTerms()" ng-init="fetchTerms(\'category\')"></select>';

		$default = '<label for="{{field.id}}_type" >' . esc_html__( 'Default value' ) . '</label>
			<select ng-model="field.std" class="widefat" id="{{field.id}}_type">
				<option value=""></option>
				<option ng-repeat="term in terms[field.taxonomy]" value="{{term.term_id}}">{{term.name}}</option>
			</select>';

		$toggle_all = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\' || field.field_type == \'checkbox_list\'">
			<input type="checkbox" ng-model="field.select_all_none" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Display "Toggle All" button', 'meta-box-builder' ) . '
		</label>';

		$multiple = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\'">
			<input type="checkbox" ng-model="field.multiple" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Allow to select multiple choices', 'meta-box-builder' ) . '
		</label>';

		$inline = '<label ng-show="field.field_type == \'radio_list\' || field.field_type == \'checkbox_list\'">
			<input type="checkbox" ng-model="field.inline" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Display choices in a single line', 'meta-box-builder' ) . '
		</label>';

		$fields = [
			'taxonomy' => [
				'type'    => 'custom',
				'content' => $taxonomy,
			],
			'field_type'  => [
				'type' => 'custom',
			],
			'std' => [
				'type'    => 'custom',
				'content' => $default,
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
		if ( 'Taxonomy' === basename( get_class( $this ) ) ) {
			unset( $this->basic['clone'] );
		}

		$label = '<a href="https://developer.wordpress.org/reference/functions/get_terms/">' . __( 'Query arguments', 'meta-box-builder' ) . '</a>' . mbb_tooltip( __( 'Query arguments for getting taxonomy terms. Use the same arguments as get_terms().', 'meta-box-builder' ) );
		$query_args = mbb_get_attribute_content( 'key_value', 'query_args',  $label, __( '+ Add Argument', 'meta-box-builder' ) );
		$this->advanced = ['query_args' => ['type' => 'custom', 'content' => $query_args]] + $this->advanced;

		unset( $this->appearance['size'] );
	}
}
