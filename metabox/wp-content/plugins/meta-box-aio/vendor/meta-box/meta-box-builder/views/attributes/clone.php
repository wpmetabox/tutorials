<div class="mbb-row">
	<label>
		<input type="checkbox" ng-model="field.clone" ng-true-value="1" ng-false-value="0">
		<?php esc_html_e( 'Cloneable', 'meta-box-builder' ) ?>
		<?= mbb_tooltip( __( 'Make field clonable (repeatable)', 'meta-box-builder' ) ) ?>
	</label>
</div>
<div class="mbb-row mbb-two" ng-show="field.clone">
	<div class="mbb-col">
		<label>
			<input type="checkbox" ng-model="field.sort_clone" ng-true-value="1" ng-false-value="0">
			<?php esc_html_e( 'Sortable', 'meta-box-builder' ) ?>
			<?= mbb_tooltip( __( 'Allows users to drag-and-drop reorder clones', 'meta-box-builder' ) ) ?>
		</label>
	</div>
	<div class="mbb-col">
		<label>
			<input type="checkbox" ng-model="field.clone_default" ng-true-value="1" ng-false-value="0">
			<?php esc_html_e( 'Clone default value', 'meta-box-builder' ) ?>
		</label>
	</div>
</div>
<div class="mbb-row mbb-two" ng-show="field.clone">
	<div class="mbb-col">
		<label>
			<?php esc_html_e( 'Maximum number of clones', 'meta-box-builder' ) ?>
			<?= mbb_tooltip( __( 'Leave empty for unlimited clones', 'meta-box-builder' ) ) ?>
		</label>
		<input type="text" ng-model="field.max_clone" class="widefat">
	</div>
	<div class="mbb-col">
		<label>
			<?php esc_html_e( 'Add more text', 'meta-box-builder' ) ?>
			<?= mbb_tooltip( __( 'Custom text for the "+ Add more" button', 'meta-box-builder' ) ) ?>
		</label>
		<input type="text" ng-model="field.add_button" class="widefat" value="+ Add more">
	</div>
</div>
