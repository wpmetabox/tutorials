add_action( 'admin_init', function () {
    if ( get_option( 'event_speaker_migrated' ) ) {
        return;
    }
    $query = new WP_Query( [
        'post_type'      => 'event',
        'posts_per_page' => 100,
        'post_status'    => 'any',
        'meta_query'     => [
            [
                'key'     => 'speaker',
                'compare' => 'EXISTS',
            ],
        ],
    ] );
    foreach ( $query->posts as $post ) {
        $old = get_post_meta( $post->ID, 'speaker', true );
        if ( empty( $old ) || is_array( $old[0] ) ) {
            continue;
        }
        $new = [];
        foreach ( $old as $name ) {
            $new[] = [
                'name'   => $name,
                'title'  => '',
                'avatar' => '',
            ];
        }
        update_post_meta( $post->ID, 'speaker', $new );
    }
    update_option( 'event_speaker_migrated', true );
} );
