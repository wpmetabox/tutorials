<?php
/**
 * Plugin Name: Project Demo 
 * Plugin URI: https://metabox.io 
 * Version: 1.0
 * Author: Meta Box
 * Author URI: https://metabox.io
 */

require 'vendor/autoload.php';


//Thêm setting page
add_filter( 'mb_settings_pages', function ( $settings_pages ) {
    $settings_pages[] = array(
        'id'          => 'pencil',
        'option_name' => 'pencil',
        'menu_title'  => 'Pencil',
        'icon_url'    => 'dashicons-edit',
        'style'       => 'no-boxes',
        'columns'     => 1,
        'tabs'        => array(
            'general' => 'General Settings',
            'design'  => 'Design Customization',
            'faq'     => 'FAQ & Help',
        ),
    );
    return $settings_pages;
} );

// Register meta boxes and fields for settings page
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
    $meta_boxes[] = array(
        'id'             => 'general',
        'title'          => 'General',
        'settings_pages' => 'pencil',
        'tab'            => 'general',
        'fields' => array(
            array(
                'name' => 'Logo',
                'id'   => 'logo',
                'type' => 'file_input',
            ),
            array(
                'name'    => 'Layout',
                'id'      => 'layout',
                'type'    => 'image_select',
                'options' => array(
                    'sidebar-left'  => 'https://i.imgur.com/Y2sxQ2R.png',
                    'sidebar-right' => 'https://i.imgur.com/h7ONxhz.png',
                    'no-sidebar'    => 'https://i.imgur.com/m7oQKvk.png',
                ),
            ),
        ),
    );
    $meta_boxes[] = array(
        'id'             => 'colors',
        'title'          => 'Colors',
        'settings_pages' => 'pencil',
        'tab'            => 'design',
        'fields' => array(
            array(
                'name' => 'Heading Color',
                'id'   => 'heading-color',
                'type' => 'color',
            ),
            array(
                'name' => 'Text Color',
                'id'   => 'text-color',
                'type' => 'color',
            ),
             array(
                'name' => 'Ảnh',
                'id'   => 'image_new',
                'type' => 'image',
            ),
        ),
    );
    $meta_boxes[] = array(
        'id'             => 'info',
        'title'          => 'Theme Info',
        'settings_pages' => 'pencil',
        'tab'            => 'faq',
        'fields'         => array(
            array(
                'type' => 'custom_html',
                'std'  => 'Having questions? Check out our documentation',
            ),
        ),
    );
    return $meta_boxes;
} );


// Creat post type project
function frefix_register_post_type_project(){
	$label = array(
		'name' => 'Project',
		'singular_name' => 'Project',
	);

	$args = array(
		'labels'            => $label,
		'description'       => 'Post type project',
		'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
		'rewrite'           => array(
			'slug' => 'project',
			'with_front' => false,
			'feeds' => true,
			'pages' => true,
		),
		'public'            => true,
		'show_ui'           => true,
		'menu_position'     => 20,
		'capability_type'   => 'page',
		'map_meta_cap'      => true,
		'has_archive'       => true,
		'query_var'         => 'project',
		'show_in_rest'      => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => true,
	);
	register_post_type( 'project', $args );
}
add_action( 'init', 'frefix_register_post_type_project' );

/// Add fields post type project
function prefix_add_fields_project( $meta_boxes) {
    $meta_boxes[] = [
        'title'     => 'Information project',
        'post_types' => 'project',
        'fields'    => [
            [
                'id'   => 'investors',
                'name' => 'Investors',
            ],
            [
                'id'   => 'customer',
                'name' => 'Customer',
            ],
            [
                'id'   => 'description',
                'name' => 'Description',
                'type' => 'textarea',
            ],
            [
                'id'   => 'image',
                'name' => 'Images',
                'type' => 'image_advanced',
            ],
        ],
    ];
    return  $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'prefix_add_fields_project' );


// Add template cho single post type dự án 
function prefix_project_template( $template ) {
    if(  is_singular( 'project' )) {

        $new_template = plugin_dir_path( __FILE__ ) . 'project-template.php';

        if ( '' != $new_template ) {
            return $new_template ;
        }
    }
    return $template;
}
add_filter( 'template_include', 'prefix_project_template', 99 );

function prefix_project_styles() {
  wp_register_style( 'prefix_main-style', plugin_dir_url( __FILE__ ) . '/style.css', 'all' );
  wp_enqueue_style( 'prefix_main-style' );
}
add_action( 'wp_enqueue_scripts', 'prefix_project_styles' );