<?php
namespace ElementorPro\Core\Upgrade;

use ElementorPro\Plugin;
use Elementor\Modules\History\Revisions_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Upgrades {

	public static function _v_1_3_0() {
		global $wpdb;

		// Fix Button widget to new sizes options
		$post_ids = $wpdb->get_col(
			'SELECT `post_id` FROM `' . $wpdb->postmeta . '` WHERE `meta_key` = "_elementor_data" AND `meta_value` LIKE \'%"widgetType":"form"%\';'
		);

		if ( empty( $post_ids ) ) {
			return;
		}

		foreach ( $post_ids as $post_id ) {
			$data = Plugin::elementor()->db->get_plain_editor( $post_id );
			if ( empty( $data ) ) {
				continue;
			}

			$data = Plugin::elementor()->db->iterate_data( $data, function( $element ) {
				if ( empty( $element['widgetType'] ) || 'form' !== $element['widgetType'] ) {
					return $element;
				}

				if ( ! isset( $element['settings']['submit_actions'] ) ) {
					$element['settings']['submit_actions'] = [ 'email' ];
				}

				if ( ! empty( $element['settings']['redirect_to'] ) ) {
					if ( ! in_array( 'redirect', $element['settings']['submit_actions'] ) ) {
						$element['settings']['submit_actions'][] = 'redirect';
					}
				}

				if ( ! empty( $element['settings']['webhooks'] ) ) {
					if ( ! in_array( 'webhook', $element['settings']['submit_actions'] ) ) {
						$element['settings']['submit_actions'][] = 'webhook';
					}
				}

				return $element;
			} );

			self::save_editor( $post_id, $data );
		}
	}

	public static function _v_1_4_0() {
		global $wpdb;

		// Move all posts columns to classic skin (Just add prefix)
		$post_ids = $wpdb->get_col(
			'SELECT `post_id` FROM `' . $wpdb->postmeta . '` WHERE `meta_key` = "_elementor_data" AND `meta_value` LIKE \'%"widgetType":"posts"%\';'
		);

		if ( empty( $post_ids ) ) {
			return;
		}

		foreach ( $post_ids as $post_id ) {
			$data = Plugin::elementor()->db->get_plain_editor( $post_id );
			if ( empty( $data ) ) {
				continue;
			}

			$data = Plugin::elementor()->db->iterate_data( $data, function( $element ) {
				if ( empty( $element['widgetType'] ) || 'posts' !== $element['widgetType'] ) {
					return $element;
				}

				$fields_to_change = [
					'columns',
					'columns_mobile',
					'columns_tablet',
				];

				foreach ( $fields_to_change as $field ) {
					// TODO: Remove old value later
					$new_field_key = 'classic_' . $field;
					if ( isset( $element['settings'][ $field ] ) && ! isset( $element['settings'][ $new_field_key ] ) ) {
						$element['settings'][ $new_field_key ] = $element['settings'][ $field ];
					}
				}

				return $element;
			} );

			Plugin::elementor()->db->save_editor( $post_id, $data );
		}
	}

	public static function _v_1_12_0() {
		global $wpdb;

		// Set `mailchimp_api_key_source` to `custom`.
		$post_ids = $wpdb->get_col(
			'SELECT `post_id` FROM `' . $wpdb->postmeta . '` WHERE `meta_key` = "_elementor_data" AND `meta_value` LIKE \'%"widgetType":"form"%\';'
		);

		if ( empty( $post_ids ) ) {
			return;
		}

		foreach ( $post_ids as $post_id ) {
			$do_update = false;
			$data = Plugin::elementor()->db->get_plain_editor( $post_id );
			if ( empty( $data ) ) {
				continue;
			}

			$data = Plugin::elementor()->db->iterate_data( $data, function( $element ) use ( & $do_update ) {
				if ( empty( $element['widgetType'] ) || 'form' !== $element['widgetType'] ) {
					return $element;
				}

				if ( ! empty( $element['settings']['mailchimp_api_key'] ) && ! isset( $element['settings']['mailchimp_api_key_source'] ) ) {
					$element['settings']['mailchimp_api_key_source'] = 'custom';
					$do_update = true;
				}

				return $element;
			} );

			// Only update if form has mailchimp
			if ( ! $do_update ) {
				continue;
			}
			// We need the `wp_slash` in order to avoid the unslashing during the `update_post_meta`
			$json_value = wp_slash( wp_json_encode( $data ) );

			update_metadata( 'post', $post_id, '_elementor_data', $json_value );
		}
	}

	/**
	 * Replace 'sticky' => 'yes' with 'sticky' => 'top' in sections.
	 */
	public static function _v_2_0_3() {
		global $wpdb;

		$post_ids = $wpdb->get_col(
			'SELECT `post_id` FROM `' . $wpdb->postmeta . '` WHERE `meta_key` = "_elementor_data" AND `meta_value` LIKE \'%"sticky":"yes"%\';'
		);

		if ( empty( $post_ids ) ) {
			return;
		}

		foreach ( $post_ids as $post_id ) {
			$do_update = false;

			$document = Plugin::elementor()->documents->get( $post_id );

			if ( ! $document ) {
				continue;
			}

			$data = $document->get_elements_data();

			if ( empty( $data ) ) {
				continue;
			}

			$data = Plugin::elementor()->db->iterate_data( $data, function( $element ) use ( & $do_update ) {
				if ( empty( $element['elType'] ) || 'section' !== $element['elType'] ) {
					return $element;
				}

				if ( ! empty( $element['settings']['sticky'] ) && 'yes' === $element['settings']['sticky'] ) {
					$element['settings']['sticky'] = 'top';
					$do_update = true;
				}

				return $element;
			} );

			if ( ! $do_update ) {
				continue;
			}
			// We need the `wp_slash` in order to avoid the unslashing during the `update_metadata`
			$json_value = wp_slash( wp_json_encode( $data ) );

			update_metadata( 'post', $post_id, '_elementor_data', $json_value );
		} // End foreach().
	}

	private static function save_editor( $post_id, $posted ) {
		// Change the global post to current library post, so widgets can use `get_the_ID` and other post data
		if ( isset( $GLOBALS['post'] ) ) {
			$global_post = $GLOBALS['post'];
		}
		$GLOBALS['post'] = get_post( $post_id ); // WPCS: override ok.

		$editor_data = self::get_editor_data( $posted );

		// We need the `wp_slash` in order to avoid the unslashing during the `update_post_meta`
		$json_value = wp_slash( wp_json_encode( $editor_data ) );

		$is_meta_updated = update_metadata( 'post', $post_id, '_elementor_data', $json_value );

		if ( $is_meta_updated ) {
			Revisions_Manager::handle_revision();
		}

		// Restore global post
		if ( isset( $global_post ) ) {
			$GLOBALS['post'] = $global_post; // WPCS: override ok.
		} else {
			unset( $GLOBALS['post'] );
		}

		/**
		 * After editor saves data.
		 *
		 * Fires after Elementor editor data was saved.
		 *
		 * @since 1.0.0
		 *
		 * @param int   $post_id     The ID of the post.
		 * @param array $editor_data The editor data.
		 */
		do_action( 'elementor/editor/after_save', $post_id, $editor_data );
	}

	private static function get_editor_data( $data, $with_html_content = false ) {
		$editor_data = [];

		foreach ( $data as $element_data ) {
			$element = Plugin::elementor()->elements_manager->create_element_instance( $element_data );

			if ( ! $element ) {
				continue;
			}

			$editor_data[] = $element->get_raw_data( $with_html_content );
		} // End Section

		return $editor_data;
	}
}
