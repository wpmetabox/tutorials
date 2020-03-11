<table class="form-table mbb-settings-custom-attributes">
	<tr>
		<th>
			<a href="https://docs.metabox.io/extensions/meta-box-builder/#custom-attributes" target="_blank"><?php esc_html_e( 'Custom attributes', 'meta-box-builder' ); ?></a>
			<?= mbb_tooltip( __( 'Apply to the current field group. For individual fields, please go to each field > tab Advanced and set.', 'meta-box-builder' ) ) ?>
		</th>
		<td>
			<table class="mbb-settings-table" ng-show="meta.attrs.length > 0">
				<tr ng-repeat="attr in meta.attrs track by $index">
					<td><input type="text" class="widefat" ng-model="attr.key" placeholder="<?php esc_attr_e( 'Enter key', 'meta-box-builder' ); ?>"></td>
					<td><input type="text" class="widefat" ng-model="attr.value" placeholder="<?php esc_attr_e( 'Enter value', 'meta-box-builder' ); ?>"></td>
					<td><button type="button" class="button mbb-button-delete" ng-click="removeMetaBoxAttribute($index);"><span class="dashicons dashicons-dismiss"></span></button></td>
				</tr>
			</table>
			<button type="button" class="button" ng-click="addMetaBoxAttribute();"><?php esc_html_e( '+ Attribute', 'meta-box-builder' ); ?></button>
		</td>
	</tr>
</table>
