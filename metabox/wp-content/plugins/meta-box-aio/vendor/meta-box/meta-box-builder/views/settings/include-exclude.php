<?php
if ( ! mbb_is_extension_active( 'meta-box-include-exclude' ) ) {
	return;
}
?>
<table class="form-table mbb-settings-include-exclude">
	<tr>
		<th>
			<a href="https://metabox.io/plugins/meta-box-include-exclude/" target="_blank"><?php esc_html_e( 'Advanced rules', 'meta-box-builder' ); ?></a>
			<?= mbb_tooltip( __( 'More controls on where to show this field group.', 'meta-box-builder' ) ) ?>
		</th>
		<td>
			<header class="mbb-settings-header">
				<select ng-model="meta.includeexclude.type" ng-init="meta.includeexclude.type = meta.includeexclude.type || 'off'">
					<option value="off"><?php esc_html_e( 'Always show', 'meta-box-builder' ); ?></option>
					<option value="include"><?php esc_html_e( 'Show', 'meta-box-builder' ); ?></option>
					<option value="exclude"><?php esc_html_e( 'Hide', 'meta-box-builder' ); ?></option>
				</select>

				<span ng-hide="meta.includeexclude.type=='off' || meta.includeexclude.type==''">
					<?php esc_html_e( 'when', 'meta-box-builder' ); ?>

					<select ng-model="meta.includeexclude.relation" ng-init="meta.includeexclude.relation = meta.includeexclude.relation || 'OR'">
						<option value="AND"><?php esc_html_e( 'all', 'meta-box-builder' ); ?></option>
						<option value="OR"><?php esc_html_e( 'any', 'meta-box-builder' ); ?></option>
					</select>

					<?php esc_html_e( 'of these conditions match', 'meta-box-builder' ); ?>
				</span>
			</header>

			<div ng-hide="meta.includeexclude.type=='off' || meta.includeexclude.type==''">
				<table class="mbb-settings-table">
					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0">
						<td><?php esc_html_e( 'Post', 'meta-box-builder' ); ?></td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.includeexclude.ID" ng-init="initFetch( 'posts', meta.includeexclude.ID, 'includeExcludePosts')" multiple class="mbb-select2-ajax-posts" style="width: 99%">
								<option ng-repeat="post in includeExcludePosts" value="{{ post.id }}">{{ post.text }}</option>
							</select>
						</td>
					</tr>
					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0">
						<td><?php esc_html_e( 'Parent post', 'meta-box-builder' ); ?></td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.includeexclude.parent" ng-init="initFetch( 'posts', meta.includeexclude.parent, 'includeExcludeParents')" multiple class="mbb-select2-ajax-posts" style="width: 99%">
								<option ng-repeat="post in includeExcludeParents" value="{{ post.id }}">{{ post.text }}</option>
							</select>
						</td>
					</tr>
					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0 && getTemplates().length > 0">
						<td><?php esc_html_e( 'Page template', 'meta-box-builder' ); ?></td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.includeexclude.template" ng-options="template.file as template.name for template in getTemplates('page')" multiple class="mbb-select2" style="width: 99%"></select>
						</td>
					</tr>
					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0" ng-repeat="taxonomy in taxonomies">
						<td>{{ taxonomy.name }}</td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.includeexclude[taxonomy.slug]" ng-init="fetchTerms(taxonomy.slug)" multiple class="mbb-select2" style="width: 99%">
								<option ng-repeat="term in terms[taxonomy.slug]" ng-value="{{term.term_id}}">{{term.name}}</option>
							</select>
						</td>
					</tr>
					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0" ng-repeat="taxonomy in taxonomies | filter: {hierarchical: true}">
						<td><?php esc_html_e( 'Parent' ); ?> {{ taxonomy.name }}</td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.includeexclude['parent_' + taxonomy.slug]" multiple class="mbb-select2" style="width: 99%">
								<option ng-repeat="term in terms[taxonomy.slug]" ng-value="{{term.term_id}}">{{term.name}}</option>
							</select>
						</td>
					</tr>

					<tr>
						<td><?php esc_html_e( 'User role', 'meta-box-builder' ); ?></td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.includeexclude.user_role" multiple class="mbb-select2" style="width: 99%">
								<?php wp_dropdown_roles(); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'User', 'meta-box-builder' ); ?></td>
						<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
						<td width="99%">
							<select ng-model="meta.includeexclude.user_id" ng-init="initFetch( 'users', meta.includeexclude.user_id, 'includeExcludeUsers')" multiple class="mbb-select2-ajax-users" style="width: 99%">
								<option ng-repeat="user in includeExcludeUsers" value="{{ user.id }}">{{ user.text }}</option>
							</select>
						</td>
					</tr>
					<?php if ( mbb_is_extension_active( 'mb-user-meta' ) ) : ?>
						<tr ng-show="meta.for == 'user'">
							<td><?php esc_html_e( 'Edited user role', 'meta-box-builder' ); ?></td>
							<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
							<td width="99%">
								<select ng-model="meta.includeexclude.edited_user_role" multiple class="mbb-select2" style="width: 99%">
									<?php wp_dropdown_roles(); ?>
								</select>
							</td>
						</tr>
						<tr ng-show="meta.for == 'user'">
							<td><?php esc_html_e( 'Edited user', 'meta-box-builder' ); ?></td>
							<td><?php esc_html_e( 'in', 'meta-box-builder' ); ?></td>
							<td width="99%">
								<select ng-model="meta.includeexclude.edited_user_id" ng-init="initFetch( 'users', meta.includeexclude.edited_user_id, 'includeExcludeEditedUsers')" multiple class="mbb-select2-ajax-users" style="width: 99%">
									<option ng-repeat="user in includeExcludeEditedUsers" value="{{ user.id }}">{{ user.text }}</option>
								</select>
							</td>
						</tr>
					<?php endif; ?>
					<tr ng-show="meta.for == 'post_types' && meta.post_types.length > 0 && isPostTypeHierarchical()">
						<td><?php esc_html_e( 'Is a child post?', 'meta-box-builder' ); ?></td>
						<td></td>
						<td width="99%">
							<input type="checkbox" ng-model="meta.includeexclude.is_child" ng-true-value="1" ng-false-value="0">
						</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Custom callback', 'meta-box-builder' ); ?></td>
						<td></td>
						<td width="99%">
							<input type="text" class="large-text" ng-model="meta.includeexclude.custom" placeholder="<?php esc_attr_e( 'Enter PHP callback function name', 'meta-box-builder' ); ?>"></textarea>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>
