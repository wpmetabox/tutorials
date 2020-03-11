<?php
namespace ElementorPro\Modules\ShareButtons;

use ElementorPro\Base\Module_Base;
use Elementor\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {

	const OPTION_NAME_API_KEY = 'pro_donreach_api_key';
	const OPTION_NAME_API_URL = 'pro_donreach_api_url';

	private function get_api_key() {
		return get_option( 'elementor_' . self::OPTION_NAME_API_KEY, '' );
	}

	private function get_api_url() {
		return get_option( 'elementor_' . self::OPTION_NAME_API_URL, '' );
	}

	private static $networks = [
		'facebook' => [
			'title' => 'Facebook',
			'has_counter' => true,
		],
		'twitter' => [
			'title' => 'Twitter',
		],
		'google' => [
			'title' => 'Google+',
			'has_counter' => true,
		],
		'linkedin' => [
			'title' => 'LinkedIn',
			'has_counter' => true,
		],
		'pinterest' => [
			'title' => 'Pinterest',
			'has_counter' => true,
		],
		'reddit' => [
			'title' => 'Reddit',
			'has_counter' => true,
		],
		'vk' => [
			'title' => 'VK',
			'has_counter' => true,
		],
		'odnoklassniki' => [
			'title' => 'OK',
			'has_counter' => true,
		],
		'tumblr' => [
			'title' => 'Tumblr',
		],
		'delicious' => [
			'title' => 'Delicious',
		],
		'digg' => [
			'title' => 'Digg',
		],
		'skype' => [
			'title' => 'Skype',
		],
		'stumbleupon' => [
			'title' => 'StumbleUpon',
			'has_counter' => true,
		],
		'telegram' => [
			'title' => 'Telegram',
		],
		'pocket' => [
			'title' => 'Pocket',
			'has_counter' => true,
		],
		'xing' => [
			'title' => 'XING',
			'has_counter' => true,
		],
		'whatsapp' => [
			'title' => 'WhatsApp',
		],
		'email' => [
			'title' => 'Email',
		],
		'print' => [
			'title' => 'Print',
		],
	];

	public static function get_networks( $network_name = null ) {
		if ( $network_name ) {
			return isset( self::$networks[ $network_name ] ) ? self::$networks[ $network_name ] : null;
		}

		return self::$networks;
	}

	public function get_widgets() {
		return [
			'Share_Buttons',
		];
	}

	public function get_name() {
		return 'share-buttons';
	}

	public function add_localize_data( $settings ) {
		$settings['shareButtonsNetworks'] = self::$networks;

		return $settings;
	}

	public function register_admin_fields( Settings $settings ) {
		$settings->add_section( Settings::TAB_INTEGRATIONS, 'donreach', [
			'callback' => function() {
				echo '<hr><h2>' . esc_html__( 'donReach', 'elementor-pro' ) . '</h2>';

				/* translators: %s: donReach home URL. */
				echo sprintf( __( '<a href="%s" target="_blank">donReach</a> is a service that has been integrated into the Share Buttons widget, and finds how many times a URL has been shared on different social networks.', 'elementor-pro' ), 'https://donreach.com/' );
			},
			'fields' => [
				self::OPTION_NAME_API_KEY => [
					'label' => __( 'API Key', 'elementor-pro' ),
					'field_args' => [
						'type' => 'text',
					],
				],
				self::OPTION_NAME_API_URL => [
					'label' => __( 'API Host', 'elementor-pro' ),
					'field_args' => [
						'type' => 'text',
						/* translators: %s: donReach pricing URL. */
						'desc' => sprintf( __( 'To integrate with our share buttons counter you need an <a href="%s" target="_blank">API Key</a>.', 'elementor-pro' ), 'https://donreach.com/pricing/' ),
					],
				],
			],
		] );
	}

	public function localize_settings( $localized_settings ) {
		$api_key = $this->get_api_key();
		$api_url = $this->get_api_url();

		if ( ! empty( $api_key ) && ! empty( $api_url ) ) {
			$localized_settings['donreach'] = [
				'key' => $this->get_api_key(),
				'api_url' => $this->get_api_url(),
			];
		}

		return $localized_settings;
	}

	public function __construct() {
		parent::__construct();

		add_filter( 'elementor_pro/frontend/localize_settings', [ $this, 'add_localize_data' ] );

		add_filter( 'elementor_pro/editor/localize_settings', [ $this, 'add_localize_data' ] );

		if ( is_admin() ) {
			add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, [ $this, 'register_admin_fields' ] );
		}

		add_filter( 'elementor_pro/frontend/localize_settings', [ $this, 'localize_settings' ] );
	}
}
