<div ng-show="meta.for == 'post_types' && meta.post_types.length > 0">
	<h2><?php esc_html_e( 'Options', 'meta-box-builder' ); ?></h2>
	<table class="form-table">
		<tr>
			<th><?php esc_html_e( 'Position', 'meta-box-builder' ); ?></th>
			<td>
				<select name="context" ng-model="meta.context">
					<option value="normal"><?php esc_html_e( 'After content', 'meta-box-builder' ); ?></option>
					<option value="side"><?php esc_html_e( 'Side', 'meta-box-builder' ); ?></option>
					<option value="form_top" ng-hide="hasGutenbergSupport()"><?php esc_html_e( 'Before post title', 'meta-box-builder' ); ?></option>
					<option value="after_title" ng-hide="hasGutenbergSupport()"><?php esc_html_e( 'After post title', 'meta-box-builder' ); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Priority', 'meta-box-builder' ); ?></th>
			<td>
				<label><input type="radio" ng-model="meta.priority" name="priority" value="high"> <?php esc_html_e( 'High', 'meta-box-builder' ); ?></label>
				<label><input type="radio" ng-model="meta.priority" name="priority" value="low"> <?php esc_html_e('Low', 'meta-box-builder'); ?></label>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Style', 'meta-box-builder' ); ?></th>
			<td>
				<select name="style" ng-model="meta.style">
					<option value=""><?php esc_html_e( 'Standard (WordPress meta box)', 'meta-box-builder' ); ?></option>
					<option value="seamless"><?php esc_html_e( 'Seamless (no meta box)', 'meta-box-builder' ); ?></option>
				</select>
			</td>
		</tr>
		<tr ng-hide="hasGutenbergSupport()">
			<th><?php esc_html_e( 'Hidden by default.', 'meta-box-builder' ); ?></th>
			<td>
				<label>
					<input type="checkbox" ng-model="meta.default_hidden" ng-true-value="'true'" ng-false-value="'false'">
					<?php esc_html_e( 'The meta box is hidden by default and requires users to select the corresponding checkbox in Screen Options to show it', 'meta-box-builder' ); ?>
				</label>
			</td>
		</tr>
		<tr ng-hide="hasGutenbergSupport()">
			<th><?php esc_html_e( 'Autosave', 'meta-box-builder' ); ?></th>
			<td><input ng-true-value="'true'" ng-false-value="'false'" type="checkbox" ng-model="meta.autosave"></td>
		</tr>
	</table>
</div>