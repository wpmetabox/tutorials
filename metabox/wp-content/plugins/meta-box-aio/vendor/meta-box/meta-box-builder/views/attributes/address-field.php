<label>
	<?php esc_attr_e( 'Address field', 'meta-box-builder' ) ?><span class="required">*</span>
	<?= mbb_tooltip( __( 'The ID of address field. For multiple fields, separate them by comma.', 'meta-box-builder' ) ) ?>
</label>
<input type="text" class="widefat" ng-model="field.address_field" list="available_fields" placeholder="<?php esc_attr_e( 'Select or enter a field', 'meta-box-builder' ) ?>">
