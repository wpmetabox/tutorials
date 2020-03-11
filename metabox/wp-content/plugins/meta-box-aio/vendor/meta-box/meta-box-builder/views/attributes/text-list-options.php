<label><?php esc_html_e( 'Inputs', 'meta-box-builder' ) ?></label>

<table class="mbb-settings-table">
	<tr ng-repeat="option in active.options track by $index">
		<td>
			<input type="text" class="widefat" ng-model="option.key" ng-change="autoFillValue($index)" placeholder="<?php esc_attr_e( 'Placeholder', 'meta-box-builder' ) ?>">
		</td>
		<td>
			<input type="text" class="widefat" ng-model="option.value" placeholder="<?php esc_attr_e( 'Label', 'meta-box-builder' ) ?>">
		</td>
		<td>
			<button type="button" class="button mbb-button-delete" ng-click="removeObject('options', $index);"><span class="dashicons dashicons-dismiss"></span></button>
		</td>
	</tr>
</table>
<button type="button" class="button" ng-click="addObject('options');"><?php esc_html_e( '+ Add Input', 'meta-box-builder' ) ?></button>
