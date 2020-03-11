<?php
namespace MBBTI;

use FLPageData;

class Authors extends Base {
	protected $group = 'author';
	protected $type = 'post';
	protected $object_type = 'user';

	public function add_properties() {
		if ( ! $this->is_active() ) {
			return;
		}

		$func = "add_{$this->type}_property";
		FLPageData::$func( 'meta_box_post_author', [
			'label'  => __( 'Meta Box Field', 'meta-box-beaver-themer-integrator' ),
			'group'  => $this->group,
			'type'   => [
				'string',
				'html',
				'photo',
				'multiple-photos',
				'url',
				'custom_field',
			],
			'getter' => [ $this, 'get_field_value' ],
			'form'   => 'meta_box',
		] );
		FLPageData::$func( 'meta_box_color_post_author', [
			'label'  => __( 'Meta Box Field', 'meta-box-beaver-themer-integrator' ),
			'group'  => $this->group,
			'type'   => ['color'],
			'getter' => [ $this, 'get_color_field_value' ],
			'form'   => 'meta_box',
		] );

		$func = "add_{$this->type}_property_settings_fields";
		$fields = [
			'field' => [
				'type'    => 'select',
				'label'   => __( 'Field Name', 'meta-box-beaver-themer-integrator' ),
				'options' => $this->get_fields(),
				'toggle'  => $this->get_toggle_rules(),
			]
		];
		if ( $this->has_image_field() ) {
			$fields['image_size'] = [
				'type'  => 'photo-sizes',
				'label' => __( 'Image Size', 'meta-box-beaver-themer-integrator' ),
			];
		}
		if ( $this->has_date_field() ) {
			$fields['date_format'] = [
				'type'        => 'text',
				'label'       => __( 'Date Format', 'meta-box-beaver-themer-integrator' ),
				'description' => __( 'Enter a <a href="http://php.net/date">PHP date format string</a>. Leave empty to use the default field format.', 'meta-box-beaver-themer-integrator' ),
			];
		}
		FLPageData::$func( 'meta_box_post_author', $fields );
		FLPageData::$func( 'meta_box_color_post_author', [
			'field' => [
				'type'    => 'select',
				'label'   => __( 'Field Name', 'meta-box-beaver-themer-integrator' ),
				'options' => $this->get_color_fields(),
			],
		] );
	}

	public function is_active() {
		return function_exists( 'mb_user_meta_load' );
	}

	/**
	 * Parse settings to get field ID and object ID.
	 *
	 * @param  object $settings Themer settings.
	 * @return array            Field ID and object ID.
	 */
	public function parse_settings( $settings ) {
		$post = get_post();
		return [ $post->post_author, $settings->field ];
	}

	public function format( $list ) {
		$sources = [];

		if ( empty( $list ) ) {
			return $sources;
		}

		$fields = $list['user'];
		foreach ( $fields as $field ) {
			$sources[ $field['id'] ] = $field['name'] ? $field['name'] : $field['id'];
		}

		return $sources;
	}
}
