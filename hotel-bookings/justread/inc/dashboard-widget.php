<?php
/**
 * The dashboard widget that display latest news/tutorials 
 *
 * @package    justread
 */

class Justread_Dashboard_Widget {
	public $feed_url = 'https://gretathemes.com/feed/';

	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'register' ) );
	}

	public function register() {
		wp_add_dashboard_widget( 'justread_dashboard_widget', esc_html__( 'GretaThemes News and Tutorials', 'justread' ), array( $this, 'render' ) );
	}

	public function render() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output( $this->feed_url, array( 'items' => 10 ) );
		echo '</div>';
	}
}
