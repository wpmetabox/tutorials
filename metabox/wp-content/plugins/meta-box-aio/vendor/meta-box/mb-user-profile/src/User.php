<?php
namespace MBUP;

class User {
	public $user_id;
	public $config;

	public function __construct( $config = [] ) {
		$this->config  = $config;
	}

	public function set_user_id( $user_id ) {
		$this->user_id = $user_id;
	}

	public function save() {
		do_action( 'rwmb_profile_before_save_user', $this );

		if ( $this->user_id ) {
			$this->update();
		} else {
			$this->create();
		}

		do_action( 'rwmb_profile_after_save_user', $this );

		return $this->user_id;
	}

	private function update() {
		$data = $this->get_data();
		$data = apply_filters( 'rwmb_profile_update_user_data', $data, $this->config );

		// Do not update user data, only trigger an action for Meta Box to update custom fields.
		if ( empty( $data ) ) {
			$old_user_data = get_userdata( $this->user_id );
			if ( ! $old_user_data ) {
				Error::set( __( 'Invalid user ID.', 'mb-user-profile' ) );
				return;
			}
			do_action( 'profile_update', $this->user_id, $old_user_data );
			return;
		}

		// Update user data.
		$data['ID'] = $this->user_id;
		if ( isset( $data['user_pass'] ) && isset( $data['user_pass2'] ) && $data['user_pass'] !== $data['user_pass2'] ) {
			Error::set( __( 'Passwords do not coincide.', 'mb-user-profile' ) );
			return;
		}
		unset( $data['user_pass2'] );

		$result = wp_update_user( $data );
		if ( is_wp_error( $result ) ) {
			Error::set( $result->get_error_message() );
		}
	}

	private function create() {
		$data = $this->get_data();

		$data = apply_filters( 'rwmb_profile_insert_user_data', $data, $this->config );
		if ( isset( $data['user_email'] ) && email_exists( $data['user_email'] ) ) {
			Error::set( __( 'Your email already exists.', 'mb-user-profile' ) );
			return;
		}
		if ( isset( $this->config['email_as_username'] ) && 'true' === $this->config['email_as_username'] && isset( $data['user_email'] ) ) {
			$data['user_login'] = $data['user_email'];
		}
		if ( isset( $data['user_login'] ) && username_exists( $data['user_login'] ) ) {
			Error::set( __( 'Your username already exists.', 'mb-user-profile' ) );
			return;
		}
		if ( isset( $data['user_pass'] ) && isset( $data['user_pass2'] ) && $data['user_pass'] !== $data['user_pass2'] ) {
			Error::set( __( 'Passwords do not coincide.', 'mb-user-profile' ) );
			return;
		}
		unset( $data['user_pass2'] );

		$result = wp_insert_user( $data );
		if ( is_wp_error( $result ) ) {
			Error::set( $result->get_error_message() );
		} else {
			$this->user_id = $result;
		}
	}

	private function get_data() {
		$data = [
			'user_login' => '',
			'user_email' => '',
			'user_pass'  => '',
			'user_pass2' => '',
		];

		foreach ( $data as $field => $value ) {
			$data[ $field ] = (string) filter_input( INPUT_POST, $field );
		}
		return array_filter( $data );
	}
}
