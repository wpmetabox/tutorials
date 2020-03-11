<?php
/**
 * Meta Box Template Settings
 *
 * This class handles plugin settings, including adding settings page, show fields, save settings
 *
 * @package    Meta Box
 * @subpackage Meta Box Template
 */

/**
 * Meta Box Template Settings class
 */
class MB_Template_Settings {
	/**
	 * Constructor
	 * Add hooks
	 */
	public function __construct() {
		// Register plugin setting
		add_action( 'admin_init', array( $this, 'register_setting' ) );

		// Add plugin menu
		add_action( 'admin_menu', array( $this, 'add_plugin_menu' ) );
	}

	/**
	 * Register plugin setting, settings section and fields using Settings API
	 */
	public function register_setting() {
		register_setting( 'meta_box_template', 'meta_box_template' );

		add_settings_section( 'general', '', '__return_null', 'meta-box-template' );
		add_settings_field( 'template', __( 'Enter template:', 'meta-box-template' ), array( $this, 'template_field' ), 'meta-box-template', 'general' );
		add_settings_field( 'file', __( 'Or specify path to config file:', 'meta-box-template' ), array( $this, 'file_field' ), 'meta-box-template', 'general' );
	}

	/**
	 * Add plugin menu under Settings WordPress menu
	 */
	public function add_plugin_menu() {
		$page = add_submenu_page( 'meta-box', __( 'Template', 'meta-box-template' ), __( 'Template', 'meta-box-template' ), 'manage_options', 'meta-box-template', array( $this, 'show_page' ) );
		add_action( "admin_print_styles-$page", array( $this, 'enqueue' ) );
	}

	/**
	 * Enqueue scripts for plugin settings page
	 */
	public function enqueue() {
		wp_register_script( 'behave', MB_TEMPLATE_URL . 'js/behave.js', '', '1.5', true );
		wp_enqueue_script( 'meta-box-template', MB_TEMPLATE_URL . 'js/script.js', array( 'behave' ), '', true );
	}

	/**
	 * Show content of settings page
	 * Content is added via Settings API
	 */
	public function show_page() {
		?>
		<div class="wrap">
			<h1><?php _e( 'Template' ); ?></h1>

			<form action="options.php" method="post">

				<?php settings_fields( 'meta_box_template' ); ?>

				<?php do_settings_sections( 'meta-box-template' ); ?>

				<?php submit_button( __( 'Save Changes', 'meta-box-template' ) ); ?>

			</form>
		</div>
		<?php
	}

	/**
	 * Show template textarea field
	 */
	public function template_field() {
		$option = get_option( 'meta_box_template' );
		$source = isset( $option['source'] ) ? $option['source'] : '';
		?>
		<textarea class="code large-text" rows="20" name="meta_box_template[source]" id="meta-box-template"><?php echo esc_textarea( $source ); ?></textarea>
		<p class="description">
			<?php
			printf(
				__( 'Supports YAML format. See <a href="%s" target="_blank">documentation</a>.', 'meta-box-template' ),
				'http://metabox.io/docs/meta-box-template/'
			);
			?>
		</p>
		<?php
	}

	/**
	 * Show file input field
	 */
	public function file_field() {
		$option = get_option( 'meta_box_template' );
		$file   = isset( $option['file'] ) ? $option['file'] : '';
		?>
		<input type="text" class="large-text" name="meta_box_template[file]" value="<?php echo esc_attr( $file ); ?>">
		<p class="description">
			<?php _e( 'Please enter absolute path to <code>.yaml</code> file. Supports following variables (no trailing slash):', 'meta-box-template' ); ?>
		</p>
		<ul>
			<li>
				<code>%wp-content%</code> -
				<span class="description"><?php _e( 'Path to <code>wp-content</code> directory', 'meta-box-template' ); ?></span>
			</li>
			<li>
				<code>%plugins%</code> -
				<span class="description"><?php _e( 'Path to <code>wp-content/plugins</code> directory', 'meta-box-template' ); ?></span>
			</li>
			<li>
				<code>%themes%</code> -
				<span class="description"><?php printf( __( 'Path to <code>wp-content/themes</code> directory. Same as <a href="%s">get_theme_root()</a> function', 'meta-box-template' ), 'http://codex.wordpress.org/Function_Reference/get_theme_root' ); ?></span>
			</li>
			<li>
				<code>%template%</code> -
				<span class="description"><?php printf( __( 'Path to current theme directory. Same as <a href="%s">get_template_directory()</a> function', 'meta-box-template' ), 'http://codex.wordpress.org/Function_Reference/get_template_directory' ); ?></span>
			</li>
			<li>
				<code>%stylesheet%</code> -
				<span class="description"><?php printf( __( 'Path to current child theme directory. Same as <a href="%s">get_stylesheet_directory()</a> function', 'meta-box-template' ), 'http://codex.wordpress.org/Function_Reference/get_stylesheet_directory' ); ?></span>
			</li>
		</ul>
		<?php
	}
}
