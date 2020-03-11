<?php
/**
 * Hide metabox fields which is duplicated from default fields.
 * This class only hides fields from profile screen, not disabling saving process (which can be use elsewhere).
 */

namespace MBFS;

class DuplicatedFields {
	private $fields = [
		'post_title',
		'post_content',
		'post_excerpt',
		'post_date',
		'_thumbnail_id',
	];

	public function __construct() {
		add_filter( 'rwmb_outer_html', [$this, 'remove_field'], 10, 2 );
	}

	public function remove_field( $html, $field ) {
		if ( ! is_admin() ) {
			return $html;
		}
		return in_array( $field['id'], $this->fields, true ) ? '' : $html;
	}
}