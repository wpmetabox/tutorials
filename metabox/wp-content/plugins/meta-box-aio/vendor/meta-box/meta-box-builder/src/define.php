<?php

/**
 * Define default value for metabox attributes
 *
 * @since 1.0
 * @author Tan Nguyen
 *
 * @return array Attributes array
 */

return array(

	'autocomplete'      => array(
		'id'          => '',
		'type'        => 'autocomplete',
		'name'        => 'Autocomplete Field',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'size'        => '',
		'options'     => '',
		'multiple'    => true,
		'clone'       => false,
	),

	'text_list'         => array(
		'id'          => '',
		'type'        => 'text_list',
		'name'        => 'Text List Field',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'size'        => '',
		'options'     => array(),
		'clone'       => false,
	),

	'text'              => array(
		'id'          => '',
		'type'        => 'text',
		'name'        => 'Text Field',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'size'        => '',
		'clone'       => false,
	),

	'textarea'          => array(
		'id'          => '',
		'type'        => 'textarea',
		'name'        => 'Textarea Field',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'rows'        => '',
		'cols'        => '',
		'clone'       => false,
	),

	'number'            => array(
		'id'          => '',
		'type'        => 'number',
		'name'        => 'Number Field',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'min'         => '',
		'max'         => '',
		'clone'       => false,
	),

	'url'               => array(
		'id'          => '',
		'type'        => 'url',
		'name'        => 'URL Field',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'size'        => '',
		'clone'       => false,
	),

	'password'          => array(
		'id'          => '',
		'type'        => 'password',
		'name'        => 'Password Field',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'size'        => '',
	),


	'select'            => array(
		'id'          => '',
		'name'        => 'Select Field',
		'type'        => 'select',
		'desc'        => '',
		'std'         => '',
		'placeholder' => 'Select an Item',
		'options'     => '',
		'multiple'    => false,
		'clone'       => false,
	),

	'select_advanced'   => array(
		'id'          => '',
		'name'        => 'Select Advanced',
		'type'        => 'select_advanced',
		'desc'        => '',
		'std'         => '',
		'placeholder' => 'Select an Item',
		'options'     => '',
		'multiple'    => false,
		'js_options'  => array(),
		'clone'       => false,
	),

	'checkbox_list'     => array(
		'id'      => '',
		'name'    => 'Checkbox List',
		'type'    => 'checkbox_list',
		'desc'    => '',
		'std'     => '',
		'options' => '',
		'clone'   => false,
		'inline'  => false,
	),

	'checkbox'          => array(
		'id'    => '',
		'name'  => 'Checkbox',
		'type'  => 'checkbox',
		'desc'  => 'Default Description',
		'std'   => 0,
		'clone' => false,
	),

	'radio'             => array(
		'id'          => '',
		'name'        => 'Radio',
		'type'        => 'radio',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'options'     => '',
		'clone'       => false,
		'inline'      => false,
	),

	'range'             => array(
		'id'    => '',
		'name'  => 'Range Field',
		'type'  => 'range',
		'clone' => false,
	),

	'wysiwyg'           => array(
		'id'      => '',
		'name'    => 'WYSIWYG Field',
		'type'    => 'wysiwyg',
		'desc'    => '',
		'std'     => '',
		'raw'     => false,
		'clone'   => false,
		'options' => array(),
	),

	'email'             => array(
		'id'          => '',
		'name'        => 'Email Field',
		'type'        => 'email',
		'desc'        => '',
		'std'         => '',
		'placeholder' => '',
		'clone'       => false,
	),

	'hidden'            => array(
		'id'   => '',
		'type' => 'hidden',
		'std'  => '',
		'name' => 'Hidden',
	),

	'heading'           => array(
		'id'   => '',
		'type' => 'heading',
		'desc' => '',
		'name' => 'Heading Field',
	),

	'color'             => array(
		'id'    => '',
		'name'  => 'Color Picker',
		'type'  => 'color',
		'std'   => '',
		'desc'  => '',
		'size'  => 7,
		'clone' => false,
		'class' => '',
	),

	'date'              => array(
		'id'         => '',
		'type'       => 'date',
		'name'       => 'Date Picker',
		'std'        => '',
		'desc'       => '',
		'js_options' => array(),
		'clone'      => false,
		'class'      => '',
	),

	'datetime'          => array(
		'id'         => '',
		'type'       => 'datetime',
		'name'       => 'Date Time Picker',
		'std'        => '',
		'desc'       => '',
		'js_options' => array(),
		'clone'      => false,
		'class'      => '',
	),

	'time'              => array(
		'id'         => '',
		'name'       => 'Time Picker',
		'type'       => 'time',
		'std'        => '',
		'desc'       => '',
		'js_options' => array(),
		'class'      => '',
		'clone'      => false,
	),

	'divider'           => array(
		'id'   => uniqid(),
		'type' => 'divider',
		'name' => 'Divider',
	),

	'fieldset_text'     => array(
		'id'      => '',
		'type'    => 'fieldset_text',
		'name'    => 'Fieldset Text Field',
		'std'     => [],
		'desc'    => '',
		'class'   => '',
		'rows'    => 2,
		'options' => array(), // k => v
	),
	'key_value'         => array(
		'id'          => '',
		'type'        => 'key_value',
		'name'        => 'Key Value Field',
		'std'         => '',
		'desc'        => '',
		'class'       => '',
		'placeholder' => ['key' => '', 'value' => ''],
	),

	'button'            => array(
		'id'    => '',
		'type'  => 'button',
		'name'  => 'Button',
		'desc'  => '',
		'class' => '',
		'clone' => false,
	),

	'oembed'            => array(
		'id'   => '',
		'type' => 'oembed',
		'name' => 'oEmbed Field',
		'std'  => '',
		'desc' => 'oEmbed description',
		'size' => '',
	),

	'map'               => array(
		'id'            => '',
		'type'          => 'map',
		'name'          => 'Map',
		'std'           => '',
		'desc'          => '',
		'address_field' => '',
		'language'      => 'en',
		'style'         => '',
		'class'         => '',
	),

	'slider'            => array(
		'id'         => '',
		'type'       => 'slider',
		'name'       => 'Slider',
		'std'        => '',
		'desc'       => '',
		'js_options' => array(),
		'prefix'     => '',
		'suffix'     => '',
	),

	'taxonomy'          => array(
		'id'          => '',
		'type'        => 'taxonomy',
		'name'        => 'Taxonomy Field',
		'std'         => '',
		'desc'        => '',
		'placeholder' => '',
		'query_args'  => array(),
		'taxonomy'    => 'category',
		'field_type'  => 'select_advanced',
		'multiple'    => false,
	),

	'taxonomy_advanced' => array(
		'id'          => '',
		'type'        => 'taxonomy_advanced',
		'name'        => 'Taxonomy Advanced Field',
		'std'         => '',
		'desc'        => '',
		'placeholder' => '',
		'query_args'  => array(),
		'taxonomy'    => 'category',
		'field_type'  => 'select_advanced',
		'multiple'    => false,
	),

	'post'              => array(
		'id'         => '',
		'type'       => 'post',
		'name'       => 'Post',
		'std'        => '',
		'desc'       => '',
		'post_type'  => 'post',
		'field_type' => 'select_advanced', // select, select_advanced
		'parent'     => false,
		'query_args' => array(),
	),

	'sidebar'           => array(
		'id'          => '',
		'type'        => 'sidebar',
		'name'        => 'Sidebar',
		'std'         => '',
		'desc'        => '',
		'placeholder' => '',
		'field_type'  => 'select_advanced', // select, select_advanced
	),

	'file'              => array(
		'id'               => '',
		'type'             => 'file',
		'name'             => 'File',
		'std'              => '',
		'desc'             => '',
		'force_delete'     => false,
		'max_file_uploads' => 0,
		'mime_type'        => '',
	),

	'file_advanced'     => array(
		'id'               => '',
		'type'             => 'file_advanced',
		'name'             => 'File Advanced',
		'std'              => '',
		'desc'             => '',
		'force_delete'     => false,
		'mime_type'        => '',
		'max_file_uploads' => 4,
		'max_status'       => 'false',
	),

	'file_input'        => array(
		'id'          => '',
		'type'        => 'file_input',
		'name'        => 'File Input',
		'placeholder' => '',
		'size'        => '',
		'std'         => '',
		'clone'       => false,
	),

	'image'             => array(
		'id'               => '',
		'type'             => 'image',
		'name'             => 'Image Upload',
		'std'              => '',
		'desc'             => '',
		'force_delete'     => false,
		'max_file_uploads' => 4,
	),

	'image_advanced'    => array(
		'id'               => '',
		'type'             => 'image_advanced',
		'name'             => 'Image Advanced',
		'std'              => '',
		'desc'             => '',
		'force_delete'     => false,
		'max_file_uploads' => 4,
		'image_size'       => '',
		'max_status'       => 'false',
	),

	'image_select'      => array(
		'id'      => '',
		'type'    => 'image_select',
		'name'    => 'Image Select',
		'std'     => '',
		'desc'    => '',
		'options' => '',
	),

	'user'              => array(
		'id'         => '',
		'type'       => 'user',
		'name'       => 'User',
		'std'        => '',
		'desc'       => '',
		'class'      => '',
		'query_args' => array(),
		'field_type' => 'select_advanced', // select, select_advanced
	),

	'video'             => array(
		'id'           => '',
		'type'         => 'video',
		'name'         => 'Video',
		'std'          => '',
		'desc'         => '',
		'force_delete' => false,
	),

	'single_image'      => array(
		'id'           => '',
		'type'         => 'single_image',
		'name'         => 'Single Image',
		'std'          => '',
		'desc'         => '',
		'force_delete' => false,
	),

	'background'        => array(
		'id'   => '',
		'type' => 'background',
		'name' => 'Background Field',
		'std'  => '',
		'desc' => '',
	),

	'switch'            => array(
		'id'    => '',
		'type'  => 'switch',
		'name'  => 'Switch Field',
		'desc'  => '',
		'std'   => 0,
		'clone' => false,
		'style' => 'rounded',
	),

	'button_group'      => array(
		'id'       => '',
		'name'     => 'Button Group',
		'type'     => 'button_group',
		'desc'     => '',
		'std'      => '',
		'options'  => '',
		'clone'    => false,
		'inline'   => true,
		'multiple' => false,
	),

	'tab'               => array(
		'id'        => '',
		'type'      => 'tab',
		'label'     => 'Tab',
		'tab_style' => 'default',
	),

	'group'             => array(
		'id'            => '',
		'type'          => 'group',
		'name'          => 'Group',
		'fields'        => array(),
		'clone'         => false,
		'sort_clone'    => false,
		'default_state' => 'expanded',
		'groupfield'    => 'text',
	),
	'custom_html'       => array(
		'id'   => '',
		'type' => 'custom_html',
		'name' => 'Custom HTML',
		'std'  => '',
	),
	'osm'               => array(
		'id'   => '',
		'type' => 'osm',
		'name' => 'OSM',
		'std'  => '',
	),
	'file_upload'       => array(
		'id'               => '',
		'type'             => 'file_upload',
		'name'             => 'File upload',
		'max_status'       => 'false',
		'force_delete'     => false,
		'max_file_uploads' => 2,
	),
	'image_upload'      => array(
		'id'               => '',
		'type'             => 'image_upload',
		'name'             => 'Image upload',
		'max_status'       => 'false',
		'force_delete'     => false,
		'max_file_uploads' => 2,
		'image_size'       => '',
	),
);
