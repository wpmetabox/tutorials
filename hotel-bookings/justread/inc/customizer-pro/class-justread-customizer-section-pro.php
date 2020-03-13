<?php
/**
 * The "Go Pro" section in the Customizer.
 *
 * @package Justread
 */

/**
 * Pro customizer section.
 */
class Justread_Customizer_Section_Pro extends WP_Customize_Section {
	/**
	 * The type of customize section being rendered.
	 *
	 * @var string
	 */
	public $type = 'gt-go-pro';

	/**
	 * Custom doc title.
	 *
	 * @var string
	 */
	public $doc_title = '';

	/**
	 * Custom doc button text to output.
	 *
	 * @var string
	 */
	public $doc_text = '';

	/**
	 * Custom doc button URL.
	 *
	 * @var string
	 */
	public $doc_url = '';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @return array
	 */
	public function json() {
		$json = parent::json();

		$json['doc_title'] = $this->doc_title;
		$json['doc_text']  = $this->doc_text;
		$json['doc_url']   = esc_url( $this->doc_url );

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}-doc" class="accordion-section control-section cannot-expand link-doc">
			<h3 class="accordion-section-title">
				<a href="{{{ data.doc_url }}}" target="_blank">{{ data.doc_text }}</a>
			</h3>
		</li>
		<?php
	}
}
