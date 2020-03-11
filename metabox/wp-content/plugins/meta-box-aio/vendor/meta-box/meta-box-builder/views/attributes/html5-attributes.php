<?php $class = count( $extra_params ) === 3 ? 'mbb-three' : 'mbb-two'; ?>
<div class="<?= esc_attr( $class ) ?>">
	<?php if ( in_array( 'required', $extra_params, true ) ) : ?>
		<label><input type="checkbox" ng-model="field.required" ng-true-value="1" ng-false-value="0"> <?php esc_html_e( 'Required', 'meta-box-builder' ) ?></label>
	<?php endif; ?>
	<?php if ( in_array( 'readonly', $extra_params, true ) ) : ?>
		<label><input type="checkbox" ng-model="field.readonly" ng-true-value="1" ng-false-value="0"> <?php esc_html_e( 'Read only', 'meta-box-builder' ) ?></label>
	<?php endif; ?>
	<?php if ( in_array( 'disabled', $extra_params, true ) ) : ?>
		<label><input type="checkbox" ng-model="field.disabled" ng-true-value="1" ng-false-value="0"> <?php esc_html_e( 'Disabled', 'meta-box-builder' ) ?></label>
	<?php endif; ?>
</div>