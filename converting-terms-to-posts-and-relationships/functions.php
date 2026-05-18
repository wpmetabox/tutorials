<?php
add_action( 'admin_init', function () {
    $terms = get_terms( [
        'taxonomy'   => 'location',
        'hide_empty' => false,
    ] );
    foreach ( $terms as $term ) {
        if ( get_page_by_path( $term->slug, OBJECT, 'restaurant' ) ) {
            continue;
        }
        wp_insert_post( [
            'post_type'   => 'restaurant',
            'post_title'  => $term->name,
            'post_name'   => $term->slug,
            'post_status' => 'publish',
        ] );
    }
});


add_action( 'admin_init', function () {
    $events = get_posts([
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]);
    foreach ( $events as $event_id ) {
        $terms = wp_get_post_terms( $event_id, 'location' );
        foreach ( $terms as $term ) {
            $restaurant = get_page_by_path(
                $term->slug,
                OBJECT,
                'restaurant'
            );
            if ( $restaurant ) {
                MB_Relationships_API::add(
                    $event_id,
                    $restaurant->ID,
                    'event-to-restaurant'
                );
            }
        }
    }
});
