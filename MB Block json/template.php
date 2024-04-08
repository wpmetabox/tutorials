<?php
add_filter( 'rwmb_meta_boxes', function( $meta_boxes ) {
    $meta_boxes[] = [
        'title'           => 'Quote',
        'id'              => 'quote',
        'type'            => 'block',
        'fields'      => [
            [
                'name'       => __( 'Name' ),
                'id'         => $prefix . 'name',
                'type'       => 'text',
            ],
            [
                'name'       => __( 'Positon' ),
                'id'         => $prefix . 'positon',
                'type'       => 'text',
            ],
            [
                'name'       => __( 'Content' ),
                'id'         => $prefix . 'content',
                'type'       => 'textarea',
            ],
            [
                'name' => __( 'Avatar' ),
                'id'   => $prefix . 'avatar',
                'type' => 'single_image',
            ],
        ],
    ];
    return $meta_boxes;
} );


add_action( 'init', function () {
    register_block_type( __DIR__ . '/blocks/quote' );
} );
