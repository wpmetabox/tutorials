<?php

class DetectBrowser {
	
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	public function enqueue() {
		wp_enqueue_script( 'detect-browser', DETECT_BROWSER_URL . 'dist/main.js', array( 'jquery' ), '1.0.0', true );	
	}
}
?>