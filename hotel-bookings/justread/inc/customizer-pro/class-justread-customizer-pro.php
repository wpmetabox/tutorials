<?php
/**
 * Handles the "Go Pro" section in the Customizer.
 *
 * @package Justread
 */

/**
 * The customizer pro class.
 */
final class Justread_Customizer_Pro {

	/**
	 * Theme slug.
	 *
	 * @var string Theme slug.
	 */
	private $slug;

	/**
	 * UTM link.
	 *
	 * @var string UTM link.
	 */
	private $utm;

	/**
	 * Sets up initial actions.
	 */
	public function init() {

		$theme      = wp_get_theme();
		$this->slug = $theme->template;
		$this->utm  = '?utm_source=WordPress&utm_medium=link&utm_campaign=' . $this->slug;

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @param  WP_Customize_Manager $manager WP_Customize_Manager instance.
	 */
	public function sections( $manager ) {
		// Load custom sections.
		require get_template_directory() . '/inc/customizer-pro/class-justread-customizer-section-pro.php';

		// Register custom section types.
		$manager->register_section_type( 'Justread_Customizer_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Justread_Customizer_Section_Pro(
				$manager,
				'justread',
				array(
					'doc_title' => esc_html__( 'Need Some Help?', 'justread' ),
					'doc_text'  => esc_html__( 'Need help setting up your site?', 'justread' ),
					'doc_url'   => esc_url( "https://gretathemes.com/docs/{$this->slug}/{$this->utm}" ),
					'priority'  => 0,
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_style( 'justread-customize-pro-style', get_template_directory_uri() . '/inc/customizer-pro/customize-controls.css', array(), '1.0.0' );
		wp_enqueue_script( 'justread-customize-pro-script', get_template_directory_uri() . '/inc/customizer-pro/customize-controls.js', array( 'customize-controls' ), '1.0.0', true );
	}
}
