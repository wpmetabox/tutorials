<div class="mbb-three">
	<div class="mbb-col">
		<label><?php esc_html_e( 'Minimum value', 'meta-box-builder' ) ?></label>
		<input type="text" class="widefat" ng-model="field.min">
	</div>
	<div class="mbb-col">
		<label><?php esc_html_e( 'Maximum value', 'meta-box-builder' ) ?></label>
		<input type="text" class="widefat" ng-model="field.max">
	</div>
	<div class="mbb-col">
		<label><?php esc_html_e( 'Step', 'meta-box-builder' ) ?><?= mbb_tooltip( __( 'Set the increments at which a numeric value can be set. It can be the string "any" (for floating numbers) or a positive number.', 'meta-box-builder' ) ) ?></label>
		<input type="text" class="widefat" ng-model="field.step">
	</div>
</div>