<?php
namespace MBB\Encoders;

use MBB\SettingsTrait;

class Field {
	use SettingsTrait;

	private $text_domain;
	private $id_prefix;

	public function __construct( $settings, $text_domain, $id_prefix ) {
		$this->settings    = $settings;
		$this->text_domain = $text_domain;
		$this->id_prefix   = $id_prefix;
	}

	public function encode() {
		$translatable_fields = ['name', 'desc', 'label_description', 'add_button', 'placeholder', 'prefix', 'suffix'];
		array_walk( $translatable_fields, [ $this, 'make_translatable' ] );

		$this->transform_id_prefix();
		$this->make_options_translatable();
	}

	private function transform_id_prefix() {
		$this->id = substr( $this->id, strlen( $this->id_prefix ) );
		$this->id = '{{ prefix }}' . $this->id;
	}

	private function make_options_translatable() {
		$choice_types = ['select', 'radio', 'checkbox_list', 'select_advanced', 'button_group', 'image_select', 'autocomplete'];
		if ( ! in_array( $this->type, $choice_types ) ) {
			return;
		}
		if ( empty( $this->options ) || ! is_array( $this->options ) ) {
			return;
		}
		$options = $this->options;
		foreach ( $options as &$label ) {
			$label = sprintf( '###%s###', $label );
		}
		$this->options = $options;
	}

	private function make_translatable( $name ) {
		if ( ! empty( $this->{$name} ) ) {
			$this->{$name} = sprintf( '###%s###', $this->{$name} );
		}
	}
}
