<?php
namespace MBUP\Shortcodes;

use RWMB_Helpers_Array as ArrayHelper;
use MBUP\Forms\Register as Form;
use MBUP\User;
use MBUP\Appearance;

class Register extends Base {
	/**
	 * Shortcode type.
	 *
	 * @var string
	 */
	protected $type = 'register';

	protected function get_form( $args ) {
		$args = shortcode_atts( [
			// Meta Box ID.
			'id'                => '',

			'redirect'          => '',
			'form_id'           => 'register-form',

			// Google reCaptcha v3
			'recaptcha_key'       => '',
			'recaptcha_secret'    => '',

			// Appearance options.
			'label_username'    => __( 'Username', 'mb-user-profile' ),
			'label_email'       => __( 'Email', 'mb-user-profile' ),
			'label_password'    => __( 'Password', 'mb-user-profile' ),
			'label_password2'   => __( 'Confirm Password', 'mb-user-profile' ),
			'label_submit'      => __( 'Register', 'mb-user-profile' ),

			'id_username'       => 'user_login',
			'id_email'          => 'user_email',
			'id_password'       => 'user_pass',
			'id_password2'      => 'user_pass2',
			'id_submit'         => 'submit',

			'confirmation'      => __( 'Your account has been created successfully.', 'mb-user-profile' ),

			'password_strength' => 'strong',

			'email_as_username' => false,
		], $args );

		// Compatible with old shortcode attributes.
		ArrayHelper::change_key( $args, 'submit_button', 'label_submit' );

		// Apply changes to appearance.
		$base_meta_box = rwmb_get_registry( 'meta_box' )->get( 'rwmb-user-register' );
		$appearance = new Appearance( $base_meta_box );

		$appearance->set( 'username.name', $args['label_username'] );
		$appearance->set( 'username.id', $args['id_username'] );

		$appearance->set( 'email.name', $args['label_email'] );
		$appearance->set( 'email.id', $args['id_email'] );

		$appearance->set( 'password.name', $args['label_password'] );
		$appearance->set( 'password.id', $args['id_password'] );

		$appearance->set( 'password2.name', $args['label_password2'] );
		$appearance->set( 'password2.id', $args['id_password2'] );

		if ( 'true' === $args['email_as_username'] ) {
			unset( $base_meta_box->meta_box['fields']['username'] );
		}

		$meta_box_ids = ArrayHelper::from_csv( $args['id'] );
		$meta_boxes   = array_map( function( $meta_box_id ) {
			return rwmb_get_registry( 'meta_box' )->get( $meta_box_id );
		}, $meta_box_ids );

		array_unshift( $meta_boxes, $base_meta_box );

		$user = new User( $args );

		return new Form( $meta_boxes, $user, $args );
	}
}
