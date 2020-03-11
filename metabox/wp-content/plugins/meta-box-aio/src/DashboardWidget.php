<?php
/**
 * The dashboard widget that display latest news/tutorials from MetaBox.io
 *
 * @package    Meta Box
 * @subpackage Meta Box AIO
 */

namespace MBAIO;

class DashboardWidget {
	public $feed_url = 'https://metabox.io/feed/';

	public function __construct() {
		$option = get_option( 'meta_box_aio' );
		if ( isset( $option['dashboard_widget'] ) && ! $option['dashboard_widget'] ) {
			return;
		}
		add_action( 'wp_dashboard_setup', array( $this, 'register' ) );
	}

	public function register() {
		wp_add_dashboard_widget( 'meta_box_dashboard_widget', esc_html__( 'Meta Box News and Tutorials', 'meta-box-aio' ), array( $this, 'render' ) );
	}

	public function render() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output( $this->feed_url, array( 'items' => 10 ) );
		echo '</div>';
	}
}