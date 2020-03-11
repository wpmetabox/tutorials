<?php
namespace MBUP\Shortcodes;

use MBUP\ConfigStorage;

abstract class Base {
	/**
	 * Shortcode type. Defined in subclass.
	 *
	 * @var string
	 */
	protected $type;

	public function __construct() {
		add_shortcode( "mb_user_profile_{$this->type}", [ $this, 'shortcode' ] );

		add_action( 'template_redirect', [ $this, 'init_session' ] );

		if ( filter_input( INPUT_POST, "rwmb_profile_submit_{$this->type}", FILTER_SANITIZE_STRING ) ) {
			add_action( 'template_redirect', [ $this, 'process' ] );
		}
	}

	/**
	 * Output the user form in the frontend.
	 *
	 * @param array $atts Form parameters.
	 *
	 * @return string
	 */
	public function shortcode( $atts ) {
		/*
		 * Do not render the shortcode in the admin.
		 * Prevent errors with enqueue assets in Gutenberg where requests are made via REST to preload the post content.
		 */
		if ( is_admin() ) {
			return '';
		}
		$form = $this->get_form( $atts );
		if ( ! $form ) {
			return '';
		}
		ob_start();
		$form->render();

		return ob_get_clean();
	}

	public function init_session() {
		if ( session_status() === PHP_SESSION_NONE && ! headers_sent() ) {
			session_start();
		}
	}

	/**
	 * Handle the form submit.
	 */
	public function process() {
		$config_key = filter_input( INPUT_POST, 'rwmb_form_config', FILTER_SANITIZE_STRING );
		$config     = ConfigStorage::get( $config_key );
		if ( empty( $config ) ) {
			return;
		}
		$form = $this->get_form( $config );
		if ( ! $form ) {
			return;
		}

		// Make sure to include the WordPress media uploader functions to process uploaded files.
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}

		$user_id  = $form->process();
		$redirect = add_query_arg( 'rwmb-form-submitted', $user_id ? 'success' : 'error' );

		if ( $user_id && $config['redirect'] ) {
			$redirect = $config['redirect'];
		}

		$redirect = apply_filters( 'rwmb_profile_redirect', $redirect, $config );
		wp_safe_redirect( $redirect );
		die;
	}
}
