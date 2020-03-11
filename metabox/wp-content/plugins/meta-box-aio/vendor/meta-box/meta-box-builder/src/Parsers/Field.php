<?php
namespace MBB\Parsers;

class Field extends Base {
	protected $ignore_empty_keys = ['max_status', 'save_field'];
	private $choice_types        = ['select', 'radio', 'checkbox_list', 'select_advanced', 'button_group', 'image_select', 'autocomplete'];

	public function parse() {
		$this->remove_tabs()
			->parse_boolean_values()
			->parse_numeric_values()
			->remove_angular_keys()
			->parse_datalist()
			->parse_group_title()
			->parse_object_field()
			->parse_choice_options()
			->parse_choice_std()
			->parse_array_attributes( 'options' )
			->parse_array_attributes( 'js_options' )
			->parse_array_attributes( 'query_args' )
			->parse_custom_attributes()
			->parse_conditional_logic()
			->remove_empty_values();
	}

	private function remove_tabs() {
		if ( 'tab' === $this->type ) {
			$this->settings = array();
		}
		return $this;
	}

	private function parse_datalist() {
		if ( empty( $this->settings['datalist_choices'] ) ) {
			return $this;
		}
		$this->datalist = [
			'id'      => uniqid(),
			'options' => explode( "\n", $this->settings['datalist_choices'] ),
		];
		unset( $this->settings['datalist_choices'] );
		return $this;
	}

	private function parse_group_title() {
		if ( 'group' !== $this->type ) {
			return $this;
		}
		unset( $this->groupfield );
		return $this;
	}

	private function parse_object_field() {
		if ( ! in_array( $this->type, array( 'taxonomy', 'taxonomy_advanced', 'post', 'user' ), true ) ) {
			return $this;
		}
		unset( $this->terms );

		/**
		 * Available field types:
		 * - select
		 * - select_advanced
		 * - select_tree
		 * - checkbox_list
		 * - checkbox_tree
		 * - radio_list
		 */

		if ( in_array( $this->field_type, array( 'select', 'select_advanced', 'select_tree', 'checkbox_tree' ), true ) ) {
			unset( $this->inline );
		}
		if ( in_array( $this->field_type, array( 'select_tree', 'checkbox_list', 'checkbox_tree', 'radio_list' ), true ) ) {
			unset( $this->multiple );
		}
		if ( in_array( $this->field_type, array( 'select_tree', 'checkbox_tree', 'radio_list' ), true ) ) {
			unset( $this->select_all_none );
		}
		if ( empty( $this->multiple ) && in_array( $this->field_type, array( 'select', 'select_advanced' ), true ) ) {
			unset( $this->select_all_none );
		}

		return $this;
	}

	private function parse_choice_options() {
		if ( ! in_array( $this->type, $this->choice_types ) ) {
			return $this;
		}
		if ( empty( $this->options ) || is_array( $this->options ) ) {
			return $this;
		}
		$options = array();

		$this->options = wp_unslash( $this->options );
		$this->options = explode( "\n", $this->options );

		foreach ( $this->options as $choice ) {
			if ( false !== strpos( $choice, ':' ) ) {
				list( $value, $label )     = explode( ':', $choice, 2 );
				$options[ trim( $value ) ] = trim( $label );
			} else {
				$options[ trim( $choice ) ] = trim( $choice );
			}
		}

		$this->options = array_filter( $options );

		return $this;
	}

	private function parse_choice_std() {
		if ( $this->multiple != true || in_array( $this->field_type, array( 'select', 'select_advanced' ), true ) ) {
			return $this;
		}

		$this->std = is_string( $this->std ) ? preg_split('/\r\n|\r|\n/', $this->std ) : $this->std;

		return $this;
	}
}
