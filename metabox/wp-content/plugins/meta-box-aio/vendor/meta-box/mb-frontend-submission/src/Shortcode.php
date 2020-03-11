<?php
namespace MBFS;

class Shortcode {
	public function __construct() {
		add_shortcode( 'mb_frontend_form', array( $this, 'shortcode' ) );

		add_action( 'template_redirect', array( $this, 'init_session' ) );

		add_action('wp_ajax_ajax_submit', array( $this, 'process' ));
		add_action('wp_ajax_nopriv_ajax_submit', array( $this, 'process' ));

		add_action('wp_ajax_ajax_delete', array( $this, 'delete' ));
        add_action('wp_ajax_nopriv_ajax_delete', array( $this, 'delete' ));

		if ( filter_input( INPUT_POST, 'rwmb_delete', FILTER_SANITIZE_STRING ) ) {
			add_action( 'template_redirect', array( $this, 'delete' ) );
		}

		if ( filter_input( INPUT_POST, 'rwmb_submit', FILTER_SANITIZE_STRING ) ) {
			add_action( 'template_redirect', array( $this, 'process' ) );
		}
	}

	public function shortcode( $atts ) {
		/*
		 * Do not render the shortcode in the admin.
		 * Prevent errors with enqueue assets in Gutenberg where requests are made via REST to preload the post content.
		 */
		if ( is_admin() ) {
			return '';
		}

		$form = $this->get_form( $atts );
		if ( null === $form ) {
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
		// Make sure session is available for ajax requests.
		$this->init_session();

		$data = (array) $_POST;

		$config_key = filter_var( $data[ 'rwmb_form_config' ], FILTER_SANITIZE_STRING );
		$config     = ConfigStorage::get( $config_key );

		if ( empty( $config ) ) {
			return;
		}

		$form = $this->get_form( $config );
		if ( null === $form ) {
			return;
		}

		$this->check_ajax( $form, $data );

		$this->check_recaptcha( $form, $data );

		// Make sure to include the WordPress media uploader functions to process uploaded files.
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}

		$config['post_id'] = $form->process();

		$meta_box_ids = array_filter( explode( ',', $config['id'] . ',' ) );
		$meta_box_ids = implode( ',', $meta_box_ids );

		$this->after_submit_ajax( $form, $config );

		$redirect = add_query_arg( [] );
		if ( $config['post_id'] ) {
			$redirect = add_query_arg( 'rwmb-form-submitted', $meta_box_ids );
		}

		// Allow to re-edit the submitted post.
		if ( 'true' === $config['edit'] && $config['post_id'] ) {
			$redirect = add_query_arg( 'rwmb-post-id', $config['post_id'], $redirect );
		}

		$redirect = apply_filters( 'rwmb_frontend_redirect', $redirect, $config );

		if ( $form->config[ 'redirect' ] ) {
			$redirect = $form->config[ 'redirect' ];
		}

		wp_redirect( $redirect );

		die;
	}

	private function check_ajax( $form, $data ) {
		if ( ! $this->is_ajax( $form ) ) {
			return;
		}

		// Only check FormData support when doing ajax.
		$this->check_form_data_support( $data );

		if ( ! check_ajax_referer( 'ajax_nonce' ) ) {
			wp_send_json_error( __( 'Invalid nonce', 'mb-frontend-submission' ) );
		}
	}

	private function check_form_data_support( $data ) {
		if ( isset( $data[ 'formData' ] ) && ! $data[ 'formData' ] ) {
			wp_send_json_error( __( 'Your browser does not FormData.', 'mb-frontend-submission' ) );
		}
	}

	private function after_submit_ajax( $form, $config ) {
		if ( ! $this->is_ajax( $form ) ) {
			return;
		}

		$response = [
			'type'   => 'submit',
			'config' => $config,
		];

		header( 'Content-type:application/json;charset=utf-8' );
		wp_send_json_success( $response );
	}

	private function after_delete_ajax( $form, $config ) {
		if ( ! $this->is_ajax( $form ) ) {
			return;
		}

		$response = [
			'type'   => 'delete',
			'config' => $config,
		];

		header( 'Content-type:application/json;charset=utf-8' );
		wp_send_json_success( $response );
	}

	private function check_recaptcha( $form, $data ) {
		if ( ! $form->config['recaptcha_secret'] ) {
			return;
		}

		$captcha = filter_var( $data[ 'captcha_token' ], FILTER_SANITIZE_STRING );
		$action  = filter_var( $data[ 'recaptcha_action' ], FILTER_SANITIZE_STRING );

		if ( ! $captcha || ! $action ) {
			$error = __( 'Invalid captcha token', 'mb-frontend-submission' );
			$this->is_ajax( $form ) ? wp_send_json_error( $error ) : wp_die( $error );
		}

		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$url = add_query_arg( [
			'secret'   => $form->config['recaptcha_secret'],
			'response' => $captcha,
		], $url );

		$response = wp_remote_retrieve_body( wp_remote_get( $url ) );
		$response = json_decode( $response, true );

		if ( empty( $response[ 'success' ] ) || empty( $response['action'] ) || $action !== $response[ 'action' ] ) {
			$error = __( 'Cannot verify captcha', 'mb-frontend-submission' );
			$this->is_ajax( $form ) ? wp_send_json_error( $error ) : wp_die( $error );
		}
	}

	/**
	 * Handle the form submit delete.
	 */
	public function delete() {
		// Make sure session is available for ajax requests.
		$this->init_session();

		$data = (array) $_POST;

		$config_key = filter_var( $data[ 'rwmb_form_config' ], FILTER_SANITIZE_STRING );
		$config     = ConfigStorage::get( $config_key );

		if ( empty( $config ) || empty( $config['post_id'] ) ) {
			return;
		}

		$form = $this->get_form( $config );
		if ( null === $form ) {
			return;
		}

		$this->check_ajax( $form, $data );

		$form->delete();

		$meta_box_ids = array_filter( explode( ',', $config['id'] . ',' ) );
		$meta_box_ids = implode( ',', $meta_box_ids );

		$this->after_delete_ajax( $form, $config );

		$redirect = add_query_arg( 'rwmb-form-deleted', $meta_box_ids );
		$redirect = apply_filters( 'rwmb_frontend_redirect', $redirect, $config );

		if ( $form->config[ 'redirect' ] ) {
			$redirect = $form->config[ 'redirect' ];
		}

		wp_redirect( $redirect );
		die;
	}

	/**
	 * Get the form.
	 *
	 * @param array $args Form configuration.
	 *
	 * @return Form Form object.
	 */
	private function get_form( $args ) {
		$args = shortcode_atts(
			array(
				// Meta Box ID.
				'id'                  => '',

				// Allow to edit the submitted post.
				'edit'                => false,
				'allow_delete'        => false,
				'force_delete'        => 'false',

				'only_delete'         => 'false',

				// Ajax
				'ajax'                => '',

				// Redirect
				'redirect'            => '',

				// Google reCaptcha v3
				'recaptcha_key'       => '',
				'recaptcha_secret'    => '',

				// Post fields.
				'post_type'           => '',
				'post_id'             => 0,
				'post_status'         => 'publish',
				'post_fields'         => '',
				'label_title'         => '',
				'label_content'       => '',
				'label_excerpt'       => '',
				'label_date'          => '',
				'label_thumbnail'     => '',

				// Appearance options.
				'submit_button'       => __( 'Submit', 'mb-frontend-submission' ),
				'delete_button'       => __( 'Delete', 'mb-frontend-submission' ),
				'confirmation'        => __( 'Your post has been successfully submitted. Thank you.', 'mb-frontend-submission' ),
				'delete_confirmation' => __( 'Your post has been successfully deleted.', 'mb-frontend-submission' ),
			),
			$args
		);

		// Quick set the current post ID.
		if ( 'current' === $args['post_id'] ) {
			$args['post_id'] = get_the_ID();
		}

		// Allows developers to dynamically populate shortcode params via query string.
		$this->populate_via_query_string( $args );

		// Allows developers to dynamically populate shortcode params via hooks.
		$this->populate_via_hooks( $args );

		$meta_boxes   = array();
		$meta_box_ids = array_filter( explode( ',', $args['id'] . ',' ) );

		foreach ( $meta_box_ids as $meta_box_id ) {
			$meta_boxes[] = rwmb_get_registry( 'meta_box' )->get( $meta_box_id );
		}

		$meta_boxes = array_filter( $meta_boxes );

		if ( $meta_boxes ) {
			$meta_box_ids = array();
			foreach ( $meta_boxes as $meta_box ) {
				$meta_box->set_object_id( $args['post_id'] );
				if ( ! $args['post_type'] ) {
					$post_types        = $meta_box->post_types;
					$args['post_type'] = reset( $post_types );
				}
				$meta_box_ids[] = $meta_box->id;
			}

			$args['id'] = implode( ',', $meta_box_ids );
		}

		$template_loader = new TemplateLoader();

		$post = new Post( $args['post_type'], $args['post_id'], $args, $template_loader );

		return new Form( $meta_boxes, $post, $args, $template_loader );
	}

	/**
	 * Allows developers to dynamically populate post ID via query string.
	 *
	 * @param array $args Shortcode params.
	 */
	private function populate_via_query_string( &$args ) {
		$post_id = filter_input( INPUT_GET, 'rwmb_frontend_field_post_id', FILTER_SANITIZE_NUMBER_INT );
		if ( $post_id ) {
			$args['post_id'] = $post_id;
		}
	}

	/**
	 * Allows developers to dynamically populate shortcode params via hooks.
	 *
	 * @param array $args Shortcode params.
	 */
	private function populate_via_hooks( &$args ) {
		foreach ( $args as $key => $value ) {
			$args[ $key ] = apply_filters( "rwmb_frontend_field_value_{$key}", $value, $args );
		}
	}

	private function is_ajax( $form ) {
		return 'true' === $form->config['ajax'];
	}
}
