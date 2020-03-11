<div class="mbb-row">
	<label>
		<input type="checkbox" ng-model="field.collapsible">
		<?php esc_html_e( 'Collapsible', 'meta-box-builder' ) ?>
	</label>
</div>
<div class="mbb-row" ng-show="field.collapsible">
	<label><?php esc_html_e( 'Default state', 'meta-box-builder' ) ?></label>
	<div class="mbb-inline-choices">
		<label><input type="radio" name="{{field.id}}-state" ng-model="field.default_state" value="expanded"><?php esc_html_e( 'Expanded', 'meta-box-builder' ) ?></label>
		<label><input type="radio" name="{{field.id}}-state" ng-model="field.default_state" value="collapsed"><?php esc_html_e( 'Collapsed', 'meta-box-builder' ) ?></label>
	</div>
</div>
<div class="mbb-row" ng-show="field.collapsible">
	<label>
		<input type="checkbox" ng-model="field.save_state" ng-true-value="'true'" ng-false-value="'false'">
		<?php esc_html_e( 'Save the state', 'meta-box-builder' ) ?>
	</label>
</div>
<div class="mbb-row" ng-show="field.collapsible">
	<label>
		<?php esc_html_e( 'Group title', 'meta-box-builder' ) ?>
		<?= mbb_tooltip( __( 'Use {field_id} for a sub-field value and {#} for the clone index (if the group is cloneable)', 'meta-box-builder' ) ) ?>
	</label>
	<input type="text" ng-model="field.group_title" class="widefat">
</div>
