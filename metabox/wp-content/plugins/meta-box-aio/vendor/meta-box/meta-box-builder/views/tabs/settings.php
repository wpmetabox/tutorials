<?php include MBB_DIR . 'views/settings/location.php'; ?>
<?php include MBB_DIR . 'views/settings/include-exclude.php'; ?>
<?php include MBB_DIR . 'views/settings/show-hide.php'; ?>
<?php include MBB_DIR . 'views/settings/conditional-logic.php'; ?>

<?php include MBB_DIR . 'views/settings/post.php'; ?>
<?php include MBB_DIR . 'views/settings/block.php'; ?>

<h2><?php esc_html_e( 'Advanced', 'meta-box-builder' ); ?></h2>

<table class="form-table">
	<tr>
		<th>
			<?php esc_html_e( 'Field ID prefix', 'meta-box-builder' ); ?>
			<?= mbb_tooltip( __( 'Auto add a prefix to all field IDs to keep them separated from other field groups or other plugins.', 'meta-box-builder' ) ) ?>
		</th>
		<td>
			<input type="text" class="regular-text" ng-model="meta.prefix">
			<p class="description"><?= wp_kses_post( __( 'Leave empty to ignore this or use <code>_</code> to make the fields hidden.', 'meta-box-builder' ) ) ?></p>
		</td>
	</tr>
	<tr>
		<th>
			<?php esc_html_e( 'Text domain', 'meta-box-builder' ); ?>
			<?= mbb_tooltip( __( 'Required for multilingual website. Used in the exported code only.', 'meta-box-builder' ) ) ?>
		</th>
		<td>
			<input type="text" class="regular-text" ng-model="meta.text_domain">
		</td>
	</tr>
</table>

<?php include MBB_DIR . 'views/settings/custom-attributes.php'; ?>
<?php include MBB_DIR . 'views/settings/custom-table.php'; ?>

<h2 ng-show="tabExists"><?php esc_html_e( 'Tabs', 'meta-box-builder' ); ?></h2>
<table class="form-table" ng-show="tabExists">
	<tr>
		<th><?php esc_html_e( 'Tabs style', 'meta-box-builder' ); ?></th>
		<td>
			<select ng-model="meta.tab_style">
				<option value="default"><?php esc_html_e( 'Default', 'meta-box-builder' ); ?></option>
				<option value="box"><?php esc_html_e( 'Box', 'meta-box-builder' ); ?></option>
				<option value="left"><?php esc_html_e( 'Left', 'meta-box-builder' ); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'Show meta box wrapper', 'meta-box-builder' ); ?></th>
		<td><input type="checkbox" ng-model="meta.tab_wrapper" ng-true-value="'true'" ng-false-value="'false'"></td>
	</tr>
</table>

<p><button class="button button-primary"><?php esc_html_e( 'Save Changes', 'meta-box-builder' ); ?></button></p>
