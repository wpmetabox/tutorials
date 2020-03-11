<?php
/**
 * Integrates Meta Box custom fields with Beaver Themer.
 *
 * @package    Meta Box
 * @subpackage Meta Box Beaver Themer Integrator
 */

namespace MBBTI;

/**
 * The plugin main class.
 */
class Terms extends Base {
	/**
	 * Settings group type.
	 *
	 * @var string
	 */
	protected $group = 'archives';

	/**
	 * Themer settings type: post, archive or site.
	 *
	 * @var string
	 */
	protected $type = 'archive';

	/**
	 * Object type: post, term or setting.
	 *
	 * @var string
	 */
	protected $object_type = 'term';

	/**
	 * Check if module is active.
	 *
	 * @return boolean
	 */
	public function is_active() {
		return function_exists( 'mb_term_meta_load' );
	}

	/**
	 * Parse settings to get field ID and object ID.
	 *
	 * @param  object $settings Themer settings.
	 * @return array            Field ID and object ID.
	 */
	public function parse_settings( $settings ) {
		return array( get_queried_object_id(), $settings->field );
	}

	/**
	 * Format list of fields to compatible with Beaver Themer's format.
	 *
	 * @param array $list List of fields, categoried by taxonomy.
	 * @return array
	 */
	public function format( $list ) {
		$sources = array();

		if ( empty( $list ) ) {
			return $sources;
		}

		foreach ( $list as $taxonomy => $fields ) {
			$taxonomy_object = get_taxonomy( $taxonomy );
			$options         = array();
			foreach ( $fields as $field ) {
				$options[ $field['id'] ] = $field['name'] ? $field['name'] : $field['id'];
			}
			$sources[ $taxonomy ] = array(
				'label'   => $taxonomy_object->labels->singular_name,
				'options' => $options,
			);
		}

		return $sources;
	}
}
