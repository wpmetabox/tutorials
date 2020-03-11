<?php
namespace MBUP\Forms;

class Info extends Base {
	protected function has_privilege() {
		if ( is_user_logged_in() ) {
			return true;
		}
		$request = rwmb_request();
		if ( 'error' !== $request->get( 'rwmb-form-submitted' ) && ! $request->get( 'lost-password' ) && ! $request->get( 'reset-password' ) ) {
			echo '<div class="rwmb-notice">';
			esc_html_e( 'Please login to continue.', 'mb-user-profile' );
			echo '</div>';
		}
		$url = remove_query_arg( 'rwmb-form-submitted' ); // Do not show success message after logging in.
		echo do_shortcode( "[mb_user_profile_login redirect='$url' ]" );
		return false;
	}

	protected function submit_button() {
		?>
		<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit">
			<button class="rwmb-button" id="<?= esc_attr( $this->config['id_submit'] ) ?>" name="rwmb_profile_submit_info" value="1"><?= esc_html( $this->config['label_submit'] ) ?></button>
		</div>
		<?php
	}
}
