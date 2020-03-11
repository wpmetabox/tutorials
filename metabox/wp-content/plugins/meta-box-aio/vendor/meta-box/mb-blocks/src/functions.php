<?php
if ( ! function_exists( 'mb_get_block_field' ) ) {
	function mb_get_block_field( $field_id, $args = [] ) {
		$block_name = MBBlocks\ActiveBlock::get_block_name();
		$args['object_type'] = 'block';
		return rwmb_get_value( $field_id, $args, $block_name );
	}
}

if ( ! function_exists( 'mb_the_block_field' ) ) {
	function mb_the_block_field( $field_id, $args = [], $echo = true ) {
		$block_name = MBBlocks\ActiveBlock::get_block_name();
		$args['object_type'] = 'block';
		return rwmb_the_value( $field_id, $args, $block_name, $echo );
	}
}