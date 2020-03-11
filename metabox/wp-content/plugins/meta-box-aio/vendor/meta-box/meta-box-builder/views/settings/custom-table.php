<?php
if ( ! mbb_is_extension_active( 'mb-custom-table' ) ) {
	return;
}
?>
<table class="form-table mbb-settings-custom-table" ng-hide="meta.for == 'settings_pages'">
	<tr>
		<th>
			<a href="https://metabox.io/plugins/mb-custom-table/" target="_blank"><?php esc_html_e( 'Save data in a custom table', 'meta-box-builder' ); ?></a>
			<?= mbb_tooltip( __( 'Use a custom table rather than meta table to save space and increase performance.', 'meta-box-builder' ) ) ?>
		</th>
		<td><input type="text" class="regular-text" ng-model="meta.table" placeholder="<?php esc_attr_e( 'Enter table name', 'meta-box-builder' ); ?>"></td>
	</tr>
</table>
