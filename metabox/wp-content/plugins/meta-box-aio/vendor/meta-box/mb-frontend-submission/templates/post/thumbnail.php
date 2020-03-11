<?php
/**
 * The template file for post thumbnail.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

$default      = [];
$thumbnail_id = $data->post_id ? get_post_thumbnail_id( $data->post_id ) : '';
if ( $thumbnail_id ) {
	$default = [ $thumbnail_id ];
}

$name  = ! empty( $data->config['label_thumbnail'] ) ? $data->config['label_thumbnail'] : esc_html__( 'Thumbnail', 'rwmb-frontend-submission' );
$field = apply_filters(
	'rwmb_frontend_post_thumbnail',
	[
		'type' => 'single_image',
		'name' => $name,
		'id'   => '_thumbnail_id',
		'std'  => $default,
	]
);
$field = RWMB_Field::call( 'normalize', $field );
RWMB_Field::call( $field, 'add_actions' );
RWMB_Field::call( $field, 'admin_enqueue_scripts' );
RWMB_Field::call( 'show', $field, false, $data->post_id );