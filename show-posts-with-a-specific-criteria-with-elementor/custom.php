<?php 
/**
 * Update the query to use specific post types.
 *
 * @since 1.0.0
 * @param \WP_Query $query The WordPress query instance.
 */
function my_query_by_post_types( $query ) {
	$query->set( 'post_type', [ 'cuisine' ] );
}
add_action( 'elementor/query/my_custom_filter', 'my_query_by_post_types' );

/**
 * Update the query by specific post meta.
 *
 * @since 1.0.0
 * @param \WP_Query $query The WordPress query instance.
 */
function my_query_by_post_meta( $query ) {

	// Get current meta Query
	$meta_query = $query->get( 'meta_query' );

	// If there is no meta query when this filter runs, it should be initialized as an empty array.
	if ( ! $meta_query ) {
		$meta_query = [];
	}

	// Append our meta query
	$meta_query[] = [
		'key' => 'promotional_price',
		'compare' => 'EXISTS'
	];

	$query->set( 'meta_query', $meta_query );

}
add_action( 'elementor/query/my_custom_filter', 'my_query_by_post_meta' );


