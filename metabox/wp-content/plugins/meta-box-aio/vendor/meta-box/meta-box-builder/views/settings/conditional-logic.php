<?php
if ( ! mbb_is_extension_active( 'meta-box-conditional-logic' ) ) {
	return;
}
?>
<table class="form-table mbb-settings-conditional-logic">
	<tr>
		<th>
			<a href="https://metabox.io/plugins/meta-box-conditional-logic/" target="_blank"><?php esc_html_e( 'Conditional Logic', 'meta-box-builder' ); ?></a>
			<?= mbb_tooltip( __( 'Toggle the field group based on value of other fields, terms or HTML elements', 'meta-box-builder' ) ) ?>
		</th>
		<td>
			<div ng-show="meta.logic.when.length > 0">
				<header class="mbb-settings-header">
					<select ng-model="meta.logic.visibility">
						<option value="visible"><?php esc_html_e( 'Visible', 'meta-box-builder' ); ?></option>
						<option value="hidden"><?php esc_html_e( 'Hidden', 'meta-box-builder' ); ?></option>
					</select>

					<?php esc_html_e( 'when', 'meta-box-builder' ); ?>

					<select ng-model="meta.logic.relation">
						<option value="and"><?php esc_html_e( 'All', 'meta-box-builder' ); ?></option>
						<option value="or"><?php esc_html_e( 'Any', 'meta-box-builder' ); ?></option>
					</select>

					<?php esc_html_e( 'of these conditions match', 'meta-box-builder' ); ?>
				</header>

				<table class="mbb-settings-table">
					<tr ng-repeat="item in meta.logic.when track by $index">
						<td><input type="text" ng-model="meta.logic.when[$index][0]" list="available_fields" placeholder="<?php esc_attr_e( 'Select or enter a field', 'meta-box-builder' ); ?>"></td>
						<td>
							<select ng-model="meta.logic.when[$index][1]">
								<option value="=">=</option>
								<option value=">">&gt;</option>
								<option value="<">&lt;</option>
								<option value=">=">&gt;=</option>
								<option value="<=">&lt;=</option>
								<option value="!=">!=</option>
								<option value="contains"><?php esc_html_e( 'contains', 'meta-box-builder' ); ?></option>
								<option value="not contains"><?php esc_html_e( 'not contains', 'meta-box-builder' ); ?></option>
								<option value="starts with"><?php esc_html_e( 'starts with', 'meta-box-builder' ); ?></option>
								<option value="not starts with"><?php esc_html_e( 'not starts with', 'meta-box-builder' ); ?></option>
								<option value="ends with"><?php esc_html_e( 'ends with', 'meta-box-builder' ); ?></option>
								<option value="not ends with"><?php esc_html_e( 'not ends with', 'meta-box-builder' ); ?></option>
								<option value="between"><?php esc_html_e( 'between', 'meta-box-builder' ); ?></option>
								<option value="not between"><?php esc_html_e( 'not between', 'meta-box-builder' ); ?></option>
								<option value="in"><?php esc_html_e( 'in', 'meta-box-builder' ); ?></option>
								<option value="not in"><?php esc_html_e( 'not in', 'meta-box-builder' ); ?></option>
								<option value="match"><?php esc_html_e( 'match', 'meta-box-builder' ); ?></option>
								<option value="not match"><?php esc_html_e( 'not match', 'meta-box-builder' ); ?></option>
							</select>
						</td>
						<td><input type="text" ng-model="meta.logic.when[$index][2]" placeholder="<?php esc_attr_e( 'Enter a value', 'meta-box-builder' ); ?>"></td>
						<td>
							<button type="button" class="button mbb-button-delete" ng-click="removeConditionalLogic($index, 'meta');"><span class="dashicons dashicons-dismiss"></span></button>
						</td>
					</tr>
				</table>
			</div>
			<button type="button" class="button" ng-click="addConditionalLogic('meta');"><?php esc_html_e( '+ Add Rule', 'meta-box-builder' ); ?></button>
		</td>
	</tr>
</table>
