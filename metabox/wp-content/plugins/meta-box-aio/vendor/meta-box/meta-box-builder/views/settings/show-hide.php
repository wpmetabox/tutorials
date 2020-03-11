<?php
if ( ! mbb_is_extension_active( 'meta-box-show-hide' ) ) {
	return;
}
?>
<table class="form-table mbb-settings-show-hide">
	<tr>
		<th>
			<a href="https://metabox.io/plugins/meta-box-show-hide/" target="_blank"><?php esc_html_e( 'Toggle rules', 'meta-box-builder' ); ?></a>
			<?= mbb_tooltip( __( 'Toggle the whole field group based on some conditions.', 'meta-box-builder' ) ) ?>
		</th>
		<td>
			<header class="mbb-settings-header">
				<select ng-model="meta.showhide.type" ng-init="meta.showhide.type = meta.showhide.type || 'off'">
					<option value="off"><?php esc_html_e( 'Always visible', 'meta-box-builder' ); ?></option>
					<option value="show"><?php esc_html_e( 'Visible', 'meta-box-builder' ); ?></option>
					<option value="hide"><?php esc_html_e( 'Hidden', 'meta-box-builder' ); ?></option>
				</select>

				<span ng-hide="meta.showhide.type=='off' || meta.showhide.type==''">
					<?php esc_html_e( 'when', 'meta-box-builder' ); ?>

					<select ng-model="meta.showhide.relation" ng-init="meta.showhide.relation = meta.showhide.relation || 'OR'">
						<option value="AND"><?php esc_html_e( 'All', 'meta-box-builder' ); ?></option>
						<option value="OR"><?php esc_html_e( 'Any', 'meta-box-builder' ); ?></option>
					</select>

					<?php esc_html_e( 'of these conditions match', 'meta-box-builder' ); ?>
				</span>
			</header>

			<div ng-hide="meta.showhide.type=='off' || meta.showhide.type==''">
				<table class="mbb-settings-table">
					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0 && getTemplates().length > 0">
						<td><?php esc_html_e( 'Templates', 'meta-box-builder' ); ?></td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.showhide.template" ng-options="template.id as template.name group by template.post_type_name for template in getTemplates()" multiple class="mbb-select2" style="width: 99%"></select>
						</td>
					</tr>

					<?php $post_formats = mbb_get_post_formats(); ?>
					<?php if ( ! empty( $post_formats ) ) : ?>
						<tr ng-show="meta.for == 'post_types' && meta.post_types.indexOf( 'post' ) !== -1">
							<td><?php esc_html_e( 'Post formats', 'meta-box-builder' ); ?></td>
							<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
							<td width="99%">
								<select ng-model="meta.showhide.post_format" multiple class="mbb-select2" style="width: 99%">
									<?php foreach ( $post_formats as $format ) : ?>
										<option value="<?= esc_attr( $format ); ?>"><?= esc_html( str_title( $format ) ); ?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
					<?php endif; ?>

					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0" ng-repeat="taxonomy in taxonomies">
						<td>{{ taxonomy.name }}</td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.showhide[taxonomy.slug]" ng-init="fetchTerms(taxonomy.slug)" multiple class="mbb-select2" style="width: 99%">
								<option ng-repeat="term in terms[taxonomy.slug]" ng-value="{{term.term_id}}">{{term.name}}</option>
							</select>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>
