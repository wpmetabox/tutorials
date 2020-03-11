<?php
namespace ElementorPro\Modules\Forms\Classes;

use Elementor\Settings;
use Elementor\Widget_Base;
use ElementorPro\Classes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Integration with Google reCAPTCHA
 */
class Recaptcha_Handler {

	const OPTION_NAME_SITE_KEY = 'elementor_pro_recaptcha_site_key';
	const OPTION_NAME_SECRET_KEY = 'elementor_pro_recaptcha_secret_key';

	public static function get_site_key() {
		return get_option( self::OPTION_NAME_SITE_KEY );
	}

	public static function get_secret_key() {
		return get_option( self::OPTION_NAME_SECRET_KEY );
	}

	public static function is_enabled() {
		return self::get_site_key() && self::get_secret_key();
	}

	public static function get_setup_message() {
		return __( 'To use reCAPTCHA, you need to add the API Key and complete the setup process in Dashboard > Elementor > Settings > Integrations > reCAPTCHA.', 'elementor-pro' );
	}

	public function register_admin_fields( Settings $settings ) {
		$settings->add_section( Settings::TAB_INTEGRATIONS, 'recaptcha', [
			'label' => __( 'reCAPTCHA', 'elementor-pro' ) . ' (v2)',
			'callback' => function() {
				echo __( '<a target="_blank" href="https://www.google.com/recaptcha/">reCAPTCHA</a> is a free service by Google that protects your website from spam and abuse. It does this while letting your valid users pass through with ease.', 'elementor-pro' );
			},
			'fields' => [
				'pro_recaptcha_site_key' => [
					'label' => __( 'Site Key', 'elementor-pro' ),
					'field_args' => [
						'type' => 'text',
					],
				],
				'pro_recaptcha_secret_key' => [
					'label' => __( 'Secret Key', 'elementor-pro' ),
					'field_args' => [
						'type' => 'text',
					],
				],
			],
		] );
	}

	public function localize_settings( $settings ) {
		$settings = array_replace_recursive( $settings, [
			'forms' => [
				'recaptcha' => [
					'enabled' => self::is_enabled(),
					'site_key' => self::get_site_key(),
					'setup_message' => self::get_setup_message(),
				],
			],
		] );

		return $settings;
	}

	public function register_scripts() {
		wp_register_script( 'elementor-recaptcha-api', 'https://www.google.com/recaptcha/api.js?render=explicit', [], ELEMENTOR_PRO_VERSION );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'elementor-recaptcha-api' );
	}

	/**
	 * @param Form_Record  $record
	 * @param Ajax_Handler $ajax_handler
	 */
	public function validation( $record, $ajax_handler ) {
		$fields = $record->get_field( [
			'type' => 'recaptcha',
		] );

		if ( empty( $fields ) ) {
			return;
		}

		$field = current( $fields );

		if ( empty( $_POST['g-recaptcha-response'] ) ) {
			$ajax_handler->add_error( $field['id'], __( 'The Captcha field cannot be blank. Please enter a value.', 'elementor-pro' ) );

			return;
		}

		$recaptcha_errors = [
			'missing-input-secret' => __( 'The secret parameter is missing.', 'elementor-pro' ),
			'invalid-input-secret' => __( 'The secret parameter is invalid or malformed.', 'elementor-pro' ),
			'missing-input-response' => __( 'The response parameter is missing.', 'elementor-pro' ),
			'invalid-input-response' => __( 'The response parameter is invalid or malformed.', 'elementor-pro' ),
		];

		$recaptcha_response = $_POST['g-recaptcha-response'];
		$recaptcha_secret = self::get_secret_key();
		$client_ip = Utils::get_client_ip();

		$request = [
			'body' => [
				'secret' => $recaptcha_secret,
				'response' => $recaptcha_response,
				'remoteip' => $client_ip,
			],
		];

		$response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', $request );

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( 200 !== (int) $response_code ) {
			/* translators: %d: Response code. */
			$ajax_handler->add_error( $field['id'], sprintf( __( 'Can not connect to the reCAPTCHA server (%d).', 'elementor-pro' ), $response_code ) );

			return;
		}

		$body = wp_remote_retrieve_body( $response );

		$result = json_decode( $body, true );

		if ( ! $result['success'] ) {
			$message = __( 'Invalid Form', 'elementor-pro' );

			$result_errors = array_flip( $result['error-codes'] );

			foreach ( $recaptcha_errors as $error_key => $error_desc ) {
				if ( isset( $result_errors[ $error_key ] ) ) {
					$message = $recaptcha_errors[ $error_key ];
					break;
				}
			}
			$ajax_handler->add_error( $field['id'], $message );
		}

		// If success - remove the field form list (don't send it in emails and etc )
		$record->remove_field( $field['id'] );
	}

	/**
	 * @param $item
	 * @param $item_index
	 * @param $widget Widget_Base
	 */
	public function render_field( $item, $item_index, $widget ) {
		$recaptcha_html = '<div class="elementor-field" id="form-field-' . $item['_id'] . '">';

		if ( self::is_enabled() ) {
			$this->enqueue_scripts();

			$widget->add_render_attribute(
				[
					'recaptcha' . $item_index => [
						'class' => 'elementor-g-recaptcha',
						'data-sitekey' => self::get_site_key(),
						'data-theme' => $item['recaptcha_style'],
						'data-size' => $item['recaptcha_size'],
					],
				]
			);

			$recaptcha_html .= '<div ' . $widget->get_render_attribute_string( 'recaptcha' . $item_index ) . '></div>';
		} elseif ( current_user_can( 'manage_options' ) ) {
			$recaptcha_html .= '<div class="elementor-alert elementor-alert-info">';
			$recaptcha_html .= self::get_setup_message();
			$recaptcha_html .= '</div>';
		}

		$recaptcha_html .= '</div>';

		echo $recaptcha_html;
	}

	public function add_field_type( $field_types ) {
		$field_types['recaptcha'] = __( 'reCAPTCHA', 'elementor-pro' );

		return $field_types;
	}

	public function filter_field_item( $item ) {
		if ( 'recaptcha' === $item['field_type'] ) {
			$item['field_label'] = false;
		}

		return $item;
	}

	public function __construct() {
		$this->register_scripts();

		add_filter( 'elementor_pro/forms/field_types', [ $this, 'add_field_type' ] );
		add_action( 'elementor_pro/forms/render_field/recaptcha', [ $this, 'render_field' ], 10, 3 );
		add_filter( 'elementor_pro/forms/render/item', [ $this, 'filter_field_item' ] );
		add_filter( 'elementor_pro/editor/localize_settings', [ $this, 'localize_settings' ] );

		if ( self::is_enabled() ) {
			add_action( 'elementor_pro/forms/validation', [ $this, 'validation' ], 10, 2 );
			add_action( 'elementor/preview/enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		}

		if ( is_admin() ) {
			add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, [ $this, 'register_admin_fields' ] );
		}
	}
}
