<?php
namespace MBUP\Shortcodes;

use RWMB_Helpers_Array as ArrayHelper;
use MBUP\Forms\Info as Form;
use MBUP\User;
use MBUP\Appearance;

class Info extends Base {
	/**
	 * Shortcode type.
	 *
	 * @var string
	 */
	protected $type = 'info';

	protected function get_form( $args ) {
		$args = shortcode_atts( [
			// Meta Box ID.
			'id'                => '',

			// User fields.
			'user_id'           => get_current_user_id(),

			'redirect'          => '',
			'form_id'           => 'profile-form',

			// Google reCaptcha v3
			'recaptcha_key'       => '',
			'recaptcha_secret'    => '',

			// Appearance options.
			'label_password'    => __( 'New Password', 'mb-user-profile' ),
			'label_password2'   => __( 'Confirm Password', 'mb-user-profile' ),
			'label_submit'      => __( 'Submit', 'mb-user-profile' ),

			'id_password'       => 'user_pass',
			'id_password2'      => 'user_pass2',
			'id_submit'         => 'submit',

			'confirmation'      => __( 'Your information has been successfully submitted. Thank you.', 'mb-user-profile' ),

			'password_strength' => 'strong',
		], $args );

		// Compatible with old shortcode attributes.
		ArrayHelper::change_key( $args, 'submit_button', 'label_submit' );

		// Apply changes to appearance.
		$base_meta_box = rwmb_get_registry( 'meta_box' )->get( 'rwmb-user-info' );
		$appearance = new Appearance( $base_meta_box );

		$appearance->set( 'password.name', $args['label_password'] );
		$appearance->set( 'password.id', $args['id_password'] );

		$appearance->set( 'password2.name', $args['label_password2'] );
		$appearance->set( 'password2.id', $args['id_password2'] );

		$meta_box_ids = ArrayHelper::from_csv( $args['id'] );
		$meta_boxes   = array_map( function( $meta_box_id ) use ( $args ) {
			$meta_box = rwmb_get_registry( 'meta_box' )->get( $meta_box_id );
			$meta_box->object_id = $args['user_id'];
			return $meta_box;
		}, $meta_box_ids );

		if ( ! $meta_boxes ) {
			return null;
		}

		$user = new User( $args );
		$user->set_user_id( $args['user_id'] );

		return new Form( $meta_boxes, $user, $args );
	}
}
