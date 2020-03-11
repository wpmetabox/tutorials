<?php
namespace MBUP\Forms;

class Register extends Base {
	protected function has_privilege() {
		if ( is_user_logged_in() && ! $this->is_processed() ) {
			esc_html_e( 'You are already logged in.', 'mb-user-profile' );
			return false;
		}
		return true;
	}

	protected function submit_button() {
		?>
		<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit">
			<button class="rwmb-button" id="<?= esc_attr( $this->config['id_submit'] ) ?>" name="rwmb_profile_submit_register" value="1"><?= esc_html( $this->config['label_submit'] ) ?></button>
		</div>
		<?php
	}
}
