<?php
namespace MBB\Encoders;

use MBB\SettingsTrait;

class MetaBox {
	use SettingsTrait;

	private $text_domain;
	private $prefix;
	private $function_name = 'your_prefix_register_meta_boxes';

	public function __construct( $post ) {
		$this->settings = mbb_parse_meta_box_settings( $post->post_content );

		$json_data         = json_decode( $post->post_excerpt, true );
		$this->text_domain = empty( $json_data['text_domain'] ) ? 'text-domain' : $json_data['text_domain'];
		$this->prefix      = empty( $json_data['prefix'] ) ? '' : $json_data['prefix'];
	}

	public function get_encoded_string() {
		return $this->encoded_string;
	}

	public function encode() {
		$this->make_translatable( 'title' );

		if ( isset( $this->settings['fields'] ) && is_array( $this->settings['fields'] ) ) {
			$this->encode_fields( $this->settings['fields'] );
		}

		$this->encoded_string = var_export( $this->settings, true );

		$this->replace_get_text_function()
			->replace_field_id_prefix()
			->fix_code_standard()
			->wrap_function_call();
	}

	private function encode_fields( &$fields ) {
		array_walk( $fields, array( $this, 'encode_field' ) );
		$fields = array_filter( $fields ); // Make sure to remove empty (such as empty groups) or "tab" fields.
	}

	private function encode_field( &$field ) {
		$encoder = new Field( $field, $this->text_domain, $this->prefix );
		$encoder->encode();
		$field = $encoder->get_settings();

		if ( isset( $field['fields'] ) ) {
			$this->encode_fields( $field['fields'] );
		}
	}

	private function make_translatable( $name ) {
		if ( ! empty( $this->{$name} ) ) {
			$this->{$name} = sprintf( '###%s###', $this->{$name} );
		}
	}

	/**
	 * Replace translatable string with gettext function.
	 */
	private function replace_get_text_function() {
		$find    = "/'###(.*)###'/";
		$replace = "esc_html__( '$1', '" . $this->text_domain . "' )";

		$this->encoded_string = preg_replace( $find, $replace, $this->encoded_string );
		return $this;
	}

	private function replace_field_id_prefix() {
		$this->encoded_string = str_replace( '\'{{ prefix }}', '$prefix . \'', $this->encoded_string );
		return $this;
	}

	/**
	 * Make text compatible with WordPress coding standard.
	 */
	private function fix_code_standard() {
		$search = array(
			'/  /', // Replace space with tabs.
			"/\n\t/", // Add 1 more indent to all lines.
			"/\n\)/", // Indent the last closing bracket ")".
			"/\n\t{3,}\\d+ =>\s*$/m", // Remove integer index for fields.
			"/=> \n\t+array \(/", // Move array() of field settings on the same line.
		);

		$replace = array(
			"\t",
			"\n\t\t",
			"\n\t)",
			'',
			'=> array(',
		);

		$this->encoded_string = preg_replace( $search, $replace, $this->encoded_string );
		return $this;
	}

	/**
	 * Wrap encoded string with function name and hook.
	 */
	private function wrap_function_call() {
		$this->encoded_string = sprintf(
			'add_filter( \'rwmb_meta_boxes\', \'%1$s\' );

function %1$s( $meta_boxes ) {
	$prefix = \'%3$s\';

	$meta_boxes[] = %2$s;

	return $meta_boxes;
}',
			$this->function_name,
			$this->encoded_string,
			$this->prefix
		);
		return $this;
	}
}
