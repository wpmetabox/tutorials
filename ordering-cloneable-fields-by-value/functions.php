<?php
$target_field_id = 'services';
$sort_field = 'price';
$location = 'page';

add_filter( 'bricks/query/run', function( $results, $query_obj ) use ( $target_field_id, $sort_field, $location ) {
	$expected_object_type = 'mb_' . $location . '_' . $target_field_id;
	if ( $query_obj->object_type !== $expected_object_type ) {
        return $results;
    }
	if ( is_array( $results ) && ! empty( $results ) ) {
        usort( $results, function( $a, $b ) use ( $sort_field ) {
            return ( $a[$sort_field] ) <=> ( $b[$sort_field] );
        });
    }
	return $results;
}, 20, 2 );
