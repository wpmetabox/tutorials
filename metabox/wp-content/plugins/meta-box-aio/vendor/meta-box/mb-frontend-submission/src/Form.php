<?php
namespace MBFS;

class Form {
	private $meta_boxes;
	private $post;
	public $config;
	private $template_loader;

	/**
	 * Constructor.
	 *
	 * @param array          $meta_boxes      Meta box array.
	 * @param object         $post            Post object.
	 * @param array          $config          Form configuration.
	 * @param TemplateLoader $template_loader Template loader for loading form templates.
	 */
	public function __construct( $meta_boxes, $post, $config, $template_loader ) {
		$this->meta_boxes      = array_filter( $meta_boxes, array( $this, 'is_meta_box_visible' ) );
		$this->post            = $post;
		$this->config          = $config;
		$this->template_loader = $template_loader;
		$this->localize_data   = [];
	}

	/**
	 * Output the form.
	 */
	public function render() {
		$this->enqueue();
		$this->enqueue_recaptcha();
		$this->localize();

		if ( ! $this->user_can_edit() ) {
			echo '<div class="rwmb-error">', esc_html__( 'You are not allowed to edit this post.', 'mb-frontend-submission' ), '</div>';
			return;
		}

		if ( $this->is_deleted() ) {
			do_action( 'rwmb_frontend_before_delete_confirmation', $this->config );
			$this->display_message( 'delete-confirmation' );
			do_action( 'rwmb_frontend_after_delete_confirmation', $this->config );
			return;
		}

		$this->display_errors();

		if ( $this->is_processed() ) {
			do_action( 'rwmb_frontend_before_display_confirmation', $this->config );
			$this->display_message( 'confirmation' );
			do_action( 'rwmb_frontend_after_display_confirmation', $this->config );

			if ( 'true' !== $this->config['edit'] ) {
				return;
			}
		}

		do_action( 'rwmb_frontend_before_form', $this->config );
		echo '<form class="rwmb-form" method="post" enctype="multipart/form-data" encoding="multipart/form-data">';
		$this->render_hidden_fields();

		// Register wp color picker scripts for frontend.
		$this->register_scripts();
		wp_localize_jquery_ui_datepicker();

		$delete_button = '';
		if ( 'true' === $this->config['allow_delete'] && $this->config['post_id'] && get_post_status( $this->config['post_id'] ) ) {
			$delete_button = '<button class="rwmb-button rwmb-button--delete" name="rwmb_delete" value="1">' . esc_html( $this->config['delete_button'] ) . '</button>';
		}

		if ( 'false' === $this->config['only_delete'] ) {

			// Make sure Meta Box script is enqueued first.
			foreach ( $this->meta_boxes as $meta_box ) {
				$meta_box->enqueue();
			}

			// Output post fields and assets.
			$this->post->render();

			foreach ( $this->meta_boxes as $meta_box ) {
				$meta_box->show();
			}

			do_action( 'rwmb_frontend_before_submit_button', $this->config );
			echo '<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit"><button class="rwmb-button" data-edit="' , esc_attr( $this->config['edit'] ) , '" name="rwmb_submit" value="1">', esc_html( $this->config['submit_button'] ), '</button>' , $delete_button , '</div>';
			do_action( 'rwmb_frontend_after_submit_button', $this->config );
		} else {
			do_action( 'rwmb_frontend_before_submit_button', $this->config );
			echo '<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit">' . $delete_button . '</div>';
			do_action( 'rwmb_frontend_after_submit_button', $this->config );
		}

		echo '</form>';

		do_action( 'rwmb_frontend_after_form', $this->config );
	}

	private function user_can_edit() {
		if ( empty( $this->config['post_id'] ) ) {
			return true;
		}
		if ( ! is_user_logged_in() ) {
			return false;
		}
		$post = get_post( $this->config['post_id'] );
		return $post && ( $post->post_author == get_current_user_id() || current_user_can( 'edit_post', $post->ID ) );
	}

	/**
	 * Check if a meta box is visible.
	 *
	 * @param  \RW_Meta_Box $meta_box Meta Box object.
	 * @return bool
	 */
	public function is_meta_box_visible( $meta_box ) {
		if ( empty( $meta_box ) ) {
			return false;
		}
		if ( is_callable( $meta_box, 'is_shown' ) ) {
			return $meta_box->is_shown();
		}
		$show = apply_filters( 'rwmb_show', true, $meta_box->meta_box );
		return apply_filters( "rwmb_show_{$meta_box->id}", $show, $meta_box->meta_box );
	}

	/**
	 * Process the form.
	 * Meta box auto hooks to 'save_post' action to save its data, so we only need to save the post.
	 *
	 * @return int Inserted object ID.
	 */
	public function process() {
		Error::clear();

		$validate = true;
		foreach ( $this->meta_boxes as $meta_box ) {
			$validate = $validate && $meta_box->validate();
		}

		$validate  = apply_filters( 'rwmb_frontend_validate', $validate, $this->config );

		if ( true !== $validate ) {
			Error::set( $validate );
			return null;
		}

		do_action( 'rwmb_frontend_before_process', $this->config );
		$post_id             = $this->post->save();
		$this->post->post_id = $post_id;
		do_action( 'rwmb_frontend_after_process', $this->config, $post_id );

		return $post_id;
	}

	/**
	 * Handling deleting posts by id.
	 */
	public function delete() {
		if ( empty( $this->config['post_id'] ) ) {
			return;
		}

		$force_delete = 'true' === $this->config['force_delete'];

		do_action( 'rwmb_frontend_before_delete', $this->config );
		wp_delete_post( $this->config['post_id'], $force_delete );
		do_action( 'rwmb_frontend_after_delete', $this->config, $this->config['post_id'] );
	}

	protected function display_errors() {
		if ( Error::has() ) {
			Error::show();
			Error::clear();
		}
	}

	private function register_scripts() {
		if ( wp_script_is( 'wp-color-picker', 'registered' ) ) {
			return;
		}
		wp_register_script(
			'iris',
			admin_url( 'js/iris.min.js' ),
			array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch',
			),
			'1.0.7',
			true
		);
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), '', true );
		wp_localize_script(
			'wp-color-picker',
			'wpColorPickerL10n',
			array(
				'clear'            => __( 'Clear', 'mb-frontend-submission' ),
				'clearAriaLabel'   => __( 'Clear color', 'mb-frontend-submission' ),
				'defaultString'    => __( 'Default', 'mb-frontend-submission' ),
				'defaultAriaLabel' => __( 'Select default color', 'mb-frontend-submission' ),
				'pick'             => __( 'Select Color', 'mb-frontend-submission' ),
				'defaultLabel'     => __( 'Color value', 'mb-frontend-submission' ),
			)
		);
	}

	private function enqueue() {
		wp_enqueue_style( 'mb-frontend-form', MBFS_URL . 'assets/css/frontend-submission.css', '', '2.0.0' );

		wp_enqueue_script( 'mb-frontend-form', MBFS_URL . 'assets/js/frontend-submission.js', array( 'jquery' ), '2.0.0', true );

		$is_ajax = isset( $this->config['ajax'] ) ? $this->config['ajax'] : '';
		$ajax_submit_result = $is_ajax ? $this->config[ 'confirmation' ] : '';
		$ajax_delete_result = $is_ajax ? $this->config[ 'delete_confirmation' ] : '';

		$redirect = isset( $this->config['redirect'] ) ? $this->config['redirect'] : '';

		$this->localize_data = array_merge(
			$this->localize_data,
			array(
				'ajaxUrl'             => admin_url( 'admin-ajax.php' ),
				'nonce'               => wp_create_nonce( 'ajax_nonce' ),
				'ajax'                => $is_ajax,
				'ajaxSubmitResult'    => $ajax_submit_result,
				'ajaxDeleteResult'    => $ajax_delete_result,
				'redirect'            => $redirect,
			)
		);
	}

	private function enqueue_recaptcha() {
		if ( ! $this->config['recaptcha_key'] ) {
			return;
		}
		wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . $this->config['recaptcha_key'], [], '3', true );

		$this->localize_data = array_merge(
			$this->localize_data,
			array(
				'recaptchaKey'        => $this->config['recaptcha_key'],
				'captchaExecuteError' => __( 'Error trying to execute grecaptcha.', 'mb-frontend-submission' ),
			)
		);
	}

	private function localize() {
		wp_localize_script( 'mb-frontend-form', 'mbFrontendForm', $this->localize_data );
	}

	private function render_hidden_fields() {
		$key = ConfigStorage::store( $this->config );
		echo '<input type="hidden" name="rwmb_form_config" value="', esc_attr( $key ), '">';
		// add hidden input if has recaptcha v3
		if ( $this->config[ 'recaptcha_key' ] ) {
			echo '<input id="captcha_token" type="hidden" name="captcha_token" value="">';
			echo '<input type="hidden" name="recaptcha_action" value="submit_frontend">';
		}
	}

	private function is_processed() {
		$id = array();
		foreach ( $this->meta_boxes as $meta_box ) {
			$id[] = $meta_box->id;
		}
		$id = implode( ',', $id );

		return filter_input( INPUT_GET, 'rwmb-form-submitted' ) === $id;
	}

	private function is_deleted() {
		$id = array();
		foreach ( $this->meta_boxes as $meta_box ) {
			$id[] = $meta_box->id;
		}
		$id = implode( ',', $id );

		return filter_input( INPUT_GET, 'rwmb-form-deleted' ) === $id;
	}

	private function display_message( $type ) {
		if ( $this->config['confirmation'] ) {
			$this->template_loader->set_template_data( $this->config )->get_template_part( $type );
		}
	}
}
