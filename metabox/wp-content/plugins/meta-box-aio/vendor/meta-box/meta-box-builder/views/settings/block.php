<?php
if ( ! mbb_is_extension_active( 'mb-blocks' ) ) {
	return;
}
?>
<div ng-show="meta.for === 'block'">
	<h2><?php esc_html_e( 'Options', 'meta-box-builder' ); ?></h2>

	<table class="form-table mbb-settings-block">
		<tr>
			<th><?php esc_html_e( 'Description', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="regular-text" ng-model="meta.description">
			</td>
		</tr>
		<tr ng-init="meta.icon_type = 'dashicons'">
			<th><?php esc_html_e( 'Icon type', 'meta-box-builder' ); ?></th>
			<td>
				<label><input type="radio" name="icon_type" ng-model="meta.icon_type" value="dashicons"> <?php esc_html_e( 'Dashicons', 'meta-box-builder' ) ?></label>
				<label><input type="radio" name="icon_type" ng-model="meta.icon_type" value="svg"> <?php esc_html_e( 'Custom SVG', 'meta-box-builder' ) ?></label>
			</td>
		</tr>
		<tr ng-show="meta.icon_type === 'dashicons'">
			<th><?php esc_html_e( 'Icon', 'meta-box-builder' ); ?></th>
			<td>
				<div class="icon-panel">
					<label ng-repeat="icon in icons" class="icon-single {{meta.icon == icon ? 'active' : ''}}">
						<i class="wp-menu-image dashicons-before dashicons-{{icon}}"></i>
						<input type="radio" ng-model="meta.icon" value="{{icon}}" class="hidden" name="block_icon">
					</label>
				</div>
			</td>
		</tr>
		<tr ng-show="meta.icon_type === 'dashicons'">
			<th><?php esc_html_e( 'Custom icon background color', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="mbb-color" ng-model="meta.icon_background">
				<p class="description"><?php esc_html_e( 'Leave empty to use default color', 'meta-box-builder' ) ?></p>
			</td>
		</tr>
		<tr ng-show="meta.icon_type === 'dashicons'">
			<th><?php esc_html_e( 'Custom icon color', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="mbb-color" ng-model="meta.icon_foreground">
				<p class="description"><?php esc_html_e( 'Leave empty to use default color', 'meta-box-builder' ) ?></p>
			</td>
		</tr>
		<tr ng-show="meta.icon_type === 'svg'">
			<th><?php esc_html_e( 'SVG icon', 'meta-box-builder' ); ?></th>
			<td>
				<textarea class="large-text" placeholder="<?php esc_attr_e( 'Paste the SVG content here', 'meta-box-builder' ) ?>">{{meta.icon_svg}}</textarea>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Category', 'meta-box-builder' ); ?></th>
			<td>
				<select ng-model="meta.category" ng-init="meta.category = 'layout'">
					<option value="layout"><?php esc_html_e( 'Layout', 'meta-box-builder' ) ?></option>
					<option value="common"><?php esc_html_e( 'Common', 'meta-box-builder' ) ?></option>
					<option value="formatting"><?php esc_html_e( 'Formatting', 'meta-box-builder' ) ?></option>
					<option value="widgets"><?php esc_html_e( 'Widgets', 'meta-box-builder' ) ?></option>
					<option value="embed"><?php esc_html_e( 'Embed', 'meta-box-builder' ) ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Keywords', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="regular-text" ng-model="meta.keywords">
				<p class="description"><?php esc_html_e( 'Separate by commas', 'meta-box-builder' ) ?></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Block Settings Position', 'meta-box-builder' ); ?></th>
			<td>
				<select ng-model="meta.block_context">
					<option value=""><?php esc_html_e( 'In the content area', 'meta-box-builder' ); ?></option>
					<option value="side"><?php esc_html_e( 'On the right sidebar', 'meta-box-builder' ); ?></option>
				</select>
			</td>
		</tr>
	</table>

	<h2><?php esc_html_e( 'Block Supports', 'meta-box-builder' ); ?></h2>

	<table class="form-table mbb-settings-block">
		<tr>
			<th><?php esc_html_e( 'Alignment', 'meta-box-builder' ); ?></th>
			<td>
				<label ng-repeat="(value, label) in align">
					<input type="checkbox" checklist-model="meta.supports.align" checklist-value="value"> {{label}}
				</label>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Anchor', 'meta-box-builder' ); ?></th>
			<td>
				<input type="checkbox" ng-model="meta.supports.anchor" ng-true-value="true" ng-false-value="false">
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Custom CSS class name', 'meta-box-builder' ); ?></th>
			<td>
				<input type="checkbox" ng-model="meta.supports.customClassName" ng-true-value="true" ng-false-value="false">
			</td>
		</tr>
	</table>

	<h2 ng-show="meta.for == 'block'"><?php esc_html_e( 'Render Options', 'meta-box-builder' ); ?></h2>

	<table class="form-table mbb-settings-block">
		<tr ng-init="meta.render_with = 'code'">
			<th><?php esc_html_e( 'Render with', 'meta-box-builder' ); ?></th>
			<td>
				<label><input type="radio" name="render_with" ng-model="meta.render_with" value="callback"> <?php esc_html_e( 'PHP function', 'meta-box-builder' ) ?></label>
				<label><input type="radio" name="render_with" ng-model="meta.render_with" value="template"> <?php esc_html_e( 'Template file', 'meta-box-builder' ) ?></label>
				<label><input type="radio" name="render_with" ng-model="meta.render_with" value="code"> <?php esc_html_e( 'Code', 'meta-box-builder' ) ?></label>
			</td>
		</tr>
		<tr ng-show="meta.render_with === 'callback'">
			<th><?php esc_html_e( 'Render callback', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="regular-text" ng-model="meta.render_callback" placeholder="<?php esc_attr_e( 'Enter PHP function name', 'meta-box-builder' ) ?>">
			</td>
		</tr>
		<tr ng-show="meta.render_with === 'template'">
			<th><?php esc_html_e( 'Render template', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="regular-text" ng-model="meta.render_template" placeholder="<?php esc_attr_e( 'Enter absolute path to the template file', 'meta-box-builder' ) ?>">
			</td>
		</tr>
		<tr ng-show="meta.render_with === 'code'">
			<th><?php esc_html_e( 'Code', 'meta-box-builder' ); ?></th>
			<td>
				<textarea ui-codemirror="{autoRefresh: true, lineWrapping: true}" ng-model="meta.render_code"></textarea>
				<p class="description"><?php printf( wp_kses_post( __( 'Supports <a href="%s" target="_blank">Twig template engine</a> with additional variables, functions:', 'meta-box-builder' ) ), 'https://twig.symfony.com/doc/1.x/templates.html' ); ?></p>
				<table class="mbb-desc-table">
					<tr>
						<td><code ng-non-bindable>{{ attribute }}</code></td>
						<td><?= wp_kses_post( __( 'Block attribute. Replace <code>attribute</code> with <code>anchor</code>, <code>align</code> or <code>className</code>).', 'meta-box-builder' ) ); ?></td>
					</tr>
					<tr>
						<td><code ng-non-bindable>{{ field_id }}</code></td>
						<td><?= wp_kses_post( __( 'Field value. Replace <code>field_id</code> with a real field ID.', 'meta-box-builder' ) ); ?></td>
					</tr>
					<tr>
						<td><code ng-non-bindable>{{ is_preview }}</code></td>
						<td><?php esc_html_e( 'Whether in preview mode.', 'meta-box-builder' ); ?></td>
					</tr>
					<tr>
						<td><code ng-non-bindable>{{ post_id }}</code></td>
						<td><?php esc_html_e( 'Current post ID.', 'meta-box-builder' ); ?></td>
					</tr>
					<tr>
						<td><code>mb.function()</code></td>
						<td><?= wp_kses_post( __( 'Run a PHP/WordPress function via <code>mb</code> namespace. Replace <code>function</code> with a valid PHP/WordPress function name.', 'meta-box-builder' ) ); ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Custom CSS', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="regular-text" ng-model="meta.enqueue_style" placeholder="<?php esc_attr_e( 'Enter URL to the custom CSS file', 'meta-box-builder' ) ?>">
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Custom JavaScript', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="regular-text" ng-model="meta.enqueue_script" placeholder="<?php esc_attr_e( 'Enter URL to the custom JavaScript file', 'meta-box-builder' ) ?>">
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Custom assets callback', 'meta-box-builder' ); ?></th>
			<td>
				<input type="text" class="regular-text" ng-model="meta.enqueue_assets" placeholder="<?php esc_attr_e( 'Enter PHP function name', 'meta-box-builder' ) ?>">
			</td>
		</tr>
	</table>

	<p class="description"><?php esc_html_e( 'Supported variables (no trailing slash):', 'meta-box-builder' ) ?></p>
	<table class="mbb-desc-table">
		<tr>
			<td><code ng-non-bindable>{{ site.path }}</code><td>
			<td><?php esc_html_e( 'Site path', 'meta-box-builder' ) ?></td>
		</tr>
		<tr>
			<td><code ng-non-bindable>{{ site.url }}</code><td>
			<td><?php esc_html_e( 'Site URL', 'meta-box-builder' ) ?></td>
		</tr>
		<tr>
			<td><code ng-non-bindable>{{ theme.path }}</code><td>
			<td>
				<?php esc_html_e( 'Path to the current theme directory', 'meta-box-builder' ) ?>
				<?= mbb_tooltip( __( 'If you are using a child theme, then this variable refers to the child theme', 'meta-box-builder' ) ) ?>
			</td>
		</tr>
		<tr>
			<td><code ng-non-bindable>{{ theme.url }}</code><td>
			<td>
				<?php esc_html_e( 'URL to the current theme directory', 'meta-box-builder' ) ?>
				<?= mbb_tooltip( __( 'If you are using a child theme, then this variable refers to the child theme', 'meta-box-builder' ) ) ?>
			</td>
		</tr>
	</table>
	<p>&nbsp;</p>
</div>