<script type="text/ng-template" id="nestable_item.html">
	<section ng-if="ngModelItem.type">
		<dl class="menu-item-bar menu-item-{{ngModelItem.type}}">
			<dt class="menu-item-handle" ng-click="toggleEdit(ngModelItem, $event)">
				<span class="item-title">
					<span class="menu-item-title" ng-show="ngModelItem.type != 'tab'">{{ngModelItem.name || ngModelItem.group_title || '<?php esc_html_e( '(No label)', 'meta-box-builder' ); ?>'}}</span>
					<span class="menu-item-title" ng-show="ngModelItem.type == 'tab'">
						<i class="wp-menu-image dashicons-before {{ngModelItem.icon}}"></i> {{ngModelItem.label}}
					</span>
				</span>
				<span class="item-controls">
					<span class="item-type">{{ngModelItem.type}}</span>
					<span class="mbb-item-actions">
						<a href="#" role="button" class="mbb-delete" ng-click="removeField(ngModelItem, $event)"><span class="dashicons dashicons-trash"></span></a>
						<a href="#" role="button" ng-show="ngModelItem.type != 'tab'" ng-click="cloneField(ngModelItem, $event)"><span class="dashicons dashicons-admin-page"></span></a>
					</span>
					<a class="item-edit" href="#"></a>
				</span>
			</dt>
		</dl>

		<div class="menu-item-settings" uib-collapse="field.id != active.id">
			<div class="field-edit-content" ng-include src="ngModelItem.type + '.edit.html'" role="tabpanel"></div>
		</div>
	</section>

	<ul class="apps-container menu ui-sortable" ui-sortable="sortableOptions" ng-model="ngModelItem.fields">
		<li class="mbb-group-container" ng-if="field.type=='group' && ngModelItem.fields.length < 1"><?php esc_html_e( 'Drag and drop child fields here.', 'meta-box-builder' ); ?></li>
		<li class="mbb-sub-fields menu-item builder-field builder-field-{{field.type}} {{field.id==active.id}}" ng-repeat="field in ngModelItem.fields track by field.id+$index">
			<tg-dynamic-directive ng-model="field" tg-dynamic-directive-view="getView">
			</tg-dynamic-directive>
		</li>
	</ul>
</script>