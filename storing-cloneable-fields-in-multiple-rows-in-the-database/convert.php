<?php
function prefix_convert( $field_id ) {
     $query = new WP_Query( [
     'post_type' => 'event',
     'posts_per_page' => -1,
     ] );
     if ( ! $query->have_posts() ) {
        return;
     }
     while ( $query->have_posts() ) {
         $query->the_post();
         $values = rwmb_meta( $field_id );
         if ( ! is_array( $values ) || empty( $values ) ) {
            continue;
         }
         delete_post_meta( get_the_ID(), $field_i
d );         foreach ( $values as $value ) {
            add_post_meta( get_the_ID(), $field_id, $value );
         }
     }
     wp_reset_postdata();
}

add_action( 'init', function() {
     if ( ! isset( $_GET['unique_key'] ) ) {
        return;
     }
     $field_id = 'start_date';
     prefix_convert( $field_id );
} );
?>
