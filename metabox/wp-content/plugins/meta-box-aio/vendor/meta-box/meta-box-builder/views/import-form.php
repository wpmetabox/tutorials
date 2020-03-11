<?php if ( isset( $_GET['imported'] ) ) : ?>
	<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Field groups have been imported successfully!', 'meta-box-builder' ); ?></p></div>
<?php endif; ?>

<script type="text/template" id="mbb-import-form">
	<div class="mbb-import-form">
		<p><?php esc_html_e( 'Choose a ".dat" file from your computer:', 'meta-box-builder' ); ?></p>
		<form enctype="multipart/form-data" method="post" action="">
			<?php wp_nonce_field( 'import', 'nonce' ); ?>
			<input type="file" name="file">
			<?php submit_button( esc_attr__( 'Import', 'meta-box-builder' ), 'secondary', 'submit', false, ['disabled' => true] ); ?>
		</form>
	</div>
</script>