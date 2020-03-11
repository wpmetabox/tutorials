<label><a href="https://metabox.io/plugins/meta-box-columns/" target="_blank"><?php esc_html_e( 'Columns', 'meta-box-builder' ) ?></a><?= mbb_tooltip( __( 'Select number of columns for this field in a 12-column grid', 'meta-box-builder' ) ) ?></label>
<select ng-model="field.columns" class="widefat">
	<?php for ( $i = 1; $i <= 12; $i++ ) : ?>
		<option value="<?= $i ?>"><?= $i ?></option>
	<?php endfor ?>
</select>