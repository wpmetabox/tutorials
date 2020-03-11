<?php
namespace MBUP\Shortcodes;

use RWMB_Helpers_Array as ArrayHelper;
use MBUP\Forms\Login as Form;
use MBUP\User;
use MBUP\Appearance;

class Login extends Base {
	/**
	 * Shortcode type.
	 *
	 * @var string
	 */
	protected $type = 'login';

	protected function get_form( $args ) {
		$args = (array) $args;

		// Compatible with old shortcode attributes.
		ArrayHelper::change_key( $args, 'remember', 'label_remember' );
		ArrayHelper::change_key( $args, 'lost_pass', 'label_lost_password' );
		ArrayHelper::change_key( $args, 'submit_button', 'label_submit' );

		$args = shortcode_atts( [
			'redirect'            => '',
			'form_id'             => 'login-form',

			// Google reCaptcha v3
			'recaptcha_key'       => '',
			'recaptcha_secret'    => '',

			// Appearance options.
			'label_username'      => __( 'Username or Email Address', 'mb-user-profile' ),
			'label_password'      => __( 'Password', 'mb-user-profile' ),
			'label_remember'      => __( 'Remember Me', 'mb-user-profile' ),
			'label_lost_password' => __( 'Lost Password?', 'mb-user-profile' ),
			'label_submit'        => __( 'Log In', 'mb-user-profile' ),

			'id_username'         => 'user_login',
			'id_password'         => 'user_pass',
			'id_remember'         => 'remember',
			'id_submit'           => 'submit',

			'value_username'      => '',
			'value_remember'      => false,

			'confirmation'        => __( 'You are now logged in.', 'mb-user-profile' ),

			'password_strength'   => 'strong',
		], $args );

		if ( isset( $_GET['lost-password'] ) ) {
			return $this->get_lost_password_form( $args );
		}

		if ( isset( $_GET['reset-password'] ) ) {
			return $this->get_reset_password_form( $args );
		}

		// Apply changes to appearance.
		$base_meta_box = rwmb_get_registry( 'meta_box' )->get( 'rwmb-user-login' );
		$appearance = new Appearance( $base_meta_box );

		$appearance->set( 'username.name', $args['label_username'] );
		$appearance->set( 'username.id', $args['id_username'] );
		$appearance->set( 'username.std', $args['value_username'] );

		$appearance->set( 'password.name', $args['label_password'] );
		$appearance->set( 'password.id', $args['id_password'] );

		$appearance->set( 'remember.desc', $args['label_remember'] );
		$appearance->set( 'remember.id', $args['id_remember'] );
		$appearance->set( 'remember.std', $args['value_remember'] );

		$appearance->set( 'submit.std', $args['label_submit'] );
		$appearance->set( 'submit.id', $args['id_submit'] );

		$appearance->set( 'lost_password.std', '<a href="' . esc_url( add_query_arg( 'lost-password', 'true' ) ) . '">' . esc_html( $args['label_lost_password'] ). '</a>' );

		$meta_boxes = [ $base_meta_box ];

		return new Form( $meta_boxes, null, $args );
	}

	private function get_lost_password_form( $args ) {
		$meta_box = rwmb_get_registry( 'meta_box' )->get( 'rwmb-user-lost-password' );
		return new Form( [ $meta_box ], null, $args );
	}

	private function get_reset_password_form( $args ) {
		$meta_box = rwmb_get_registry( 'meta_box' )->get( 'rwmb-user-reset-password' );
		return new Form( [ $meta_box ], null, $args );
	}
}
