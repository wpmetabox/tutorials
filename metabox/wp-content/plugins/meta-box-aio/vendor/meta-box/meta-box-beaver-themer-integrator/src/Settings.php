<?php
/**
 * Integrates MB Settings Page with Beaver Themer.
 *
 * @package    Meta Box
 * @subpackage Meta Box Beaver Themer Integrator
 */

namespace MBBTI;

/**
 * Settings class.
 */
class Settings extends Base {
	/**
	 * Settings group type.
	 *
	 * @var string
	 */
	protected $group = 'site';

	/**
	 * Themer settings type: post, archive or site.
	 *
	 * @var string
	 */
	protected $type = 'site';

	/**
	 * Object type: post, term or setting.
	 *
	 * @var string
	 */
	protected $object_type = 'setting';

	/**
	 * Check if module is active.
	 *
	 * @return boolean
	 */
	public function is_active() {
		return function_exists( 'mb_settings_page_load' );
	}

	/**
	 * Parse settings to get field ID and object ID.
	 *
	 * @param  object $settings Themer settings.
	 * @return array            Field ID and object ID.
	 */
	public function parse_settings( $settings ) {
		return explode( '#', $settings->field );
	}

	/**
	 * Format list of fields to compatible with Beaver Themer's format.
	 *
	 * @param array $list List of fields, categoried by settings page.
	 * @return array
	 */
	public function format( $list ) {
		$sources = array();

		if ( empty( $list ) ) {
			return $sources;
		}

		foreach ( $list as $settings_page => $fields ) {
			$options = array();
			foreach ( $fields as $field ) {
				$key             = "{$settings_page}#{$field['id']}";
				$options[ $key ] = $field['name'] ? $field['name'] : $field['id'];
			}
			$sources[ $settings_page ] = array(
				'label'   => $settings_page,
				'options' => $options,
			);
		}

		return $sources;
	}
}
