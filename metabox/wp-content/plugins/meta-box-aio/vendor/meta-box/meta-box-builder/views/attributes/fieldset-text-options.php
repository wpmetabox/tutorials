<label><?php esc_html_e( 'Inputs', 'meta-box-builder' ) ?></label>

<table class="mbb-settings-table" ng-show="active.<?= esc_attr( $param ) ?>.length > 0">
	<tr ng-repeat="item in active.<?= esc_attr( $param ) ?> track by $index">
		<td>
			<input type="text" ng-model="item.key" placeholder="<?php esc_attr_e( 'Enter key', 'meta-box-builder' ) ?>">
		</td>
		<td>
			<input type="text" ng-model="item.value" placeholder="<?php esc_attr_e( 'Enter label', 'meta-box-builder' ) ?>">
		</td>
		<td>
			<button type="button" class="button mbb-button-delete" ng-click="removeObject('<?= esc_attr( $param ) ?>', $index);"><span class="dashicons dashicons-dismiss"></span></button>
		</td>
	</tr>
</table>

<button type="button" class="button" ng-click="addObject('<?= esc_attr( $param ) ?>');" ng-show="field.type == 'fieldset_text'"><?php esc_html_e( '+ Add Input', 'meta-box-builder' ) ?></button>
