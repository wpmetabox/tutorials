<?php
namespace MBUP\Forms;

use MBUP\Error;

class Login extends Base {
	protected function has_privilege() {
		if ( is_user_logged_in() && ! $this->is_processed() ) {
			esc_html_e( 'You are already logged in.', 'mb-user-profile' );
			return false;
		}
		return true;
	}

	public function process() {
		if ( isset( $_GET['lost-password'] ) ) {
			return $this->retrieve_password();
		}

		if ( isset( $_GET['reset-password'] ) ) {
			return $this->reset_password();
		}

		Error::clear();

		$request     = rwmb_request();
		$credentials = [
			'user_login'    => $request->post( 'user_login' ),
			'user_password' => $request->post( 'user_pass' ),
			'remember'      => (bool) $request->post( 'remember' ),
		];

		add_filter( 'lostpassword_url', [ $this, 'change_lost_password_url' ] );
		$user = wp_signon( $credentials, true );
		remove_filter( 'lostpassword_url', [ $this, 'change_lost_password_url' ] );

		if ( is_wp_error( $user ) ) {
			Error::set( $user->get_error_message() );
			return null;
		}

		return $user->ID;
	}

	private function retrieve_password() {
		Error::clear();

		$login = rwmb_request()->post( 'user_login' );

		if ( ! $login ) {
			Error::set( __( 'Please enter a username or email address.', 'mb-user-profile' ) );
			return null;
		}

		$user = get_user_by( 'login', $login );
		if ( ! $user && is_email( $login ) ) {
			$user = get_user_by( 'email', $login );
		}

		if ( ! $user ) {
			Error::set( __( 'Invalid username or email.', 'mb-user-profile' ) );
			return null;
		}

		$key = get_password_reset_key( $user );

		$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

		$url = remove_query_arg( ['lost-password', 'rwmb-form-submitted'], $current_url );
		$url = add_query_arg( [
			'reset-password' => 'true',
			'key'            => $key,
			'login'          => $user->user_login,
		], $url );

		$subject = sprintf( __( '[%s] Password Reset', 'mb-user-profile' ), get_bloginfo( 'name' ) );

		$message = '<p>' . esc_html( sprintf( __( 'Hi, %s', 'mb-user-profile' ), $user->display_name ) ) . '</p>';
		$message .= '<p>' . esc_html( sprintf( __( 'Someone has requested a new password for your account on %s site.', 'mb-user-profile' ), get_bloginfo( 'name' ) ) ) . '</p>';
		$message .= '<p><a href="' . esc_url( $url ) . '">' . esc_html__( 'Click here to reset your password' ) . '</a></p>';

		$headers = ['Content-type: text/html'];

		$result = wp_mail( $user->user_email, $subject, $message, $headers );

		if ( ! $result ) {
			Error::set( __( 'Error sending email. Please try again.', 'mb-user-profile' ) );
			return null;
		}

		$redirect = add_query_arg( 'rwmb-form-submitted', 'success', $current_url );
		wp_safe_redirect( $redirect );
		die;
	}

	private function reset_password() {
		Error::clear();

		$request = rwmb_request();

		$key = $request->get( 'key' );
		$login = $request->get( 'login' );

		$user = check_password_reset_key( $key, $login );

		if ( is_wp_error( $user ) ) {
			Error::set( __( 'This key is invalid or has already been used. Please reset your password again if needed.', 'mb-user-profile' ) );
			$redirect = remove_query_arg( ['reset-password', 'key', 'login', 'rwmb-form-submitted'] );
			$redirect = add_query_arg( 'lost-password', 'true', $redirect );
			wp_safe_redirect( $redirect );
			die;
		}

		$password = $request->post( 'user_pass' );
		$password2 = $request->post( 'user_pass2' );

		if ( ! $password || ! $password2 ) {
			Error::set( __( 'Please enter a valid password.', 'mb-user-profile' ) );
			return null;
		}
		if ( $password !== $password2 ) {
			Error::set( __( 'Password does not coincide.', 'mb-user-profile' ) );
			return null;
		}

		$result = wp_update_user( [
			'ID'        => $user->ID,
			'user_pass' => $password,
		] );

		if ( is_wp_error( $result ) ) {
			Error::set( $result->get_error_message() );
			return null;
		}

		$redirect = add_query_arg( 'rwmb-form-submitted', 'success' );
		wp_safe_redirect( $redirect );
		die;
	}

	protected function display_confirmation() {
		$confirmation = $this->config['confirmation'];
		if ( isset( $_GET['lost-password'] ) ) {
			$confirmation = __( 'Please check your email for the confirmation link.', 'mb-user-profile' );
		}
		if ( isset( $_GET['reset-password'] ) ) {
			$confirmation = __( 'Your password has been reset.', 'mb-user-profile' ) . ' <a href="' . remove_query_arg( ['lost-password', 'reset-password', 'rwmb-form-submitted', 'key', 'login'] ) . '">' . __( 'Log in', 'mb-user-profile' ) . '</a>';
		}
		?>
		<div class="rwmb-confirmation"><?= wp_kses_post( $confirmation ); ?></div>
		<?php
	}

	public function change_lost_password_url( $url ) {
		$url = remove_query_arg( 'rwmb-form-submitted' );
		return add_query_arg( 'lost-password', 'true', $url );
	}
}
