<?php
namespace MBB;

class Attribute {
	private static $labels;

	public static function set_labels() {
		self::$labels = [
			'alpha_channel'     => __( 'Allow to select opacity', 'meta-box-builder' ),
			'after'             => __( 'Custom HTML displayed after field output', 'meta-box-builder' ),
			'attrs'             => '<a href="https://docs.metabox.io/extensions/meta-box-builder/#custom-attributes" target="_blank">' . __( 'Custom attributes', 'meta-box-builder' ) . '</a>',
			'before'            => __( 'Custom HTML displayed before field output', 'meta-box-builder' ),
			'clone'             => __( 'Cloneable', 'meta-box-builder' ) . mbb_tooltip( __( 'Make field clonable (repeatable)', 'meta-box-builder' ) ),
			'desc'              => __( 'Description', 'meta-box-builder' ),
			'disabled'          => __( 'Disabled', 'meta-box-builder' ),
			'force_delete'      => __( 'Force delete?', 'meta-box-builder' ) . mbb_tooltip( __( 'Delete files from the Media Library when deleting them from post meta', 'meta-box-builder' ) ),
			'id'                => __( 'ID', 'meta-box-builder' ) . '<span class="required">*</span>' . mbb_tooltip( __( 'Must be unique, will be used as meta key when saving to the database. Recommended to use only lowercase letters, numbers, and underscores.', 'meta-box-builder' ) ),
			'inline'            => __( 'Display choices on a single line', 'meta-box-builder' ),
			'label_description' => __( 'Label description', 'meta-box-builder' ) . mbb_tooltip( __( 'Optional label description, displayed below the field label', 'meta-box-builder' ) ),
			'max_file_uploads'  => __( 'Maximum number of files (leave empty for unlimited files)', 'meta-box-builder' ),
			'max_status'        => __( 'Show status', 'meta-box-builder' ) . mbb_tooltip( __( 'Display how many files uploaded/remaining', 'meta-box-builder' ) ),
			'mime_type'         => __( 'MIME types', 'meta-box-builder' ) . mbb_tooltip( __( 'This is a filter for items in Media Library popup, it does not restrict file types when upload.', 'meta-box-builder' ) ),
			'multiple'          => __( 'Allow to select multiple choices', 'meta-box-builder' ),
			'name'              => __( 'Label', 'meta-box-builder' ) . mbb_tooltip( __( 'Optional field label. If empty, the field input is 100% width.', 'meta-box-builder' ) ),
			'options'           => __( 'Choices', 'meta-box-builder' ) . mbb_tooltip( __( 'Enter each choice on a line. For more control, you may specify both a value and label like "red: Red" (without quotes)', 'meta-box-builder' ) ),
			'parent'            => __( 'Set the selected post as the parent for the current being edited post', 'meta-box-builder' ),
			'placeholder'       => __( 'Placeholder', 'meta-box-builder' ),
			'prefix'            => __( 'Prefix', 'meta-box-builder' ) . mbb_tooltip( __( 'Text displayed before the field value', 'meta-box-builder' ) ),
			'raw'               => __( 'Save data in raw format', 'meta-box-builder' ),
			'readonly'          => __( 'Read only', 'meta-box-builder' ),
			'region'            => __( 'Region code', 'meta-box-builder' ) . mbb_tooltip( __( 'The region code, specified as a country code top-level domain. This parameter returns autocompleted address results influenced by the region (typically the country) from the address field.', 'meta-box-builder' ) ),
			'required'          => __( 'Required', 'meta-box-builder' ),
			'select_all_none'   => __( 'Display "Toggle All" button', 'meta-box-builder' ),
			'size'              => __( 'Size of the input box', 'meta-box-builder' ) . mbb_tooltip( __( 'Enter a number here. The bigger value, the longer input box. Normal size is around 30.', 'meta-box-builder' ) ),
			'std'               => __( 'Default value', 'meta-box-builder' ),
			'suffix'            => __( 'Suffix', 'meta-box-builder' ) . mbb_tooltip( __( 'Text displayed after the field value', 'meta-box-builder' ) ),
			'timestamp'         => __( 'Save the date in the Unix timestamp format', 'meta-box-builder' ),
		];
	}

	public static function has_label( $name ) {
		return isset( self::$labels[ $name ] );
	}

	public static function get_label( $name ) {
		return self::has_label( $name ) ? self::$labels[ $name ] : null;
	}

	/**
	 * Generate Input Content
	 *
	 * @param  string $name  Name of the input.
	 * @param  string $label Label of the input.
	 * @param  array  $attrs Other attributes.
	 * @param  string $type  input type.
	 *
	 * @return string html
	 */
	public static function input( $name, $label = null, $attrs = array(), $type = 'text' ) {
		// Turn key => value array to key="value" html output.
		$attrs = self::build_attributes( $attrs );

		if ( null === $label && self::has_label( $name ) ) {
			$label = self::get_label( $name );
		}

		$output = '
			<label>' . $label . '</label>
			<input type="' . $type . '" ng-model="field.' . $name . '" class="widefat field-' . $name . '"' . $attrs . '>
		';

		if ( 'checkbox' === $type ) {
			$output = '<label><input type="' . $type . '" ng-model="field.' . $name . '" ' . $attrs . '> ' . $label . '</label>';
		}

		return $output;
	}

	public static function text( $name, $label = null, $attrs = array() ) {
		return self::input( $name, $label, $attrs );
	}

	public static function email( $name, $label = null, $attrs = array() ) {
		return self::input( $name, $label, $attrs, 'email' );
	}

	public static function number( $name, $label = null, $attrs = array() ) {
		return self::input( $name, $label, $attrs, 'number' );
	}

	public static function range( $name, $label = null, $attrs = array() ) {
		return self::input( $name, $label, $attrs, 'range' );
	}

	public static function checkbox( $name, $label = null, $attrs = array() ) {
		$attrs['ng-true-value']  = 1;
		$attrs['ng-false-value'] = 0;

		return self::input( $name, $label, $attrs, 'checkbox' );
	}

	public static function build_attributes( $attrs = array() ) {
		$attributes = '';

		if ( ! empty( $attrs ) ) {
			foreach ( $attrs as $k => $v ) {
				$attributes .= " {$k}=\"{$v}\"";
			}
		}

		return $attributes;
	}

	public static function textarea( $name, $label = null, $attrs = array() ) {
		$attributes = self::build_attributes( $attrs );

		if ( null === $label && self::has_label( $name ) ) {
			$label = self::get_label( $name );
		}

		$output = '
			<label for="{{field.id}}_' . $name . '">' . $label . '</label>
			<textarea ng-model="field.' . $name . '" id="{{field.id}}_' . $name . '" class="widefat"' . $attributes . '></textarea>';

		return $output;
	}
}
