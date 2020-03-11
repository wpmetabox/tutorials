<?php
require __DIR__ . '/nav.php';
$active = filter_input( INPUT_GET, 'active' );
$active = $active ?: 'fields';

$menu    = mbb_get_builder_menu();
$post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
?>

<div id="builder-gui" class="builder-gui nav-menus-php" ng-app="Builder">

	<div id="nav-menus-frame" ng-controller="BuilderController" ng-init="init()">
		<input type="hidden" name="post_excerpt" value="{{meta}}">

		<div class="builder-code-tab builder-code-tab--fields content-field <?php if ( 'fields' === $active ) echo 'metabox-tab-show'; ?>">
			<div id="menu-settings-column" class="metabox-holder">
				<input type="search" ng-model="searchKeyword" class="mbb-search-fields-input" placeholder="<?php esc_attr_e( 'Enter field type here', 'meta-box-builder' ); ?>">

				<div class="accordion-container">
					<ul class="outer-border">
						<li ng-repeat="(group, fields) in menu" class="control-section accordion-section {{searchKeyword ? (isFieldGroupVisible(fields) ? ' open' : ' hidden') : ($first ? ' open' : '')}}">
							<h3 class="accordion-section-title hndle" tabindex="0">{{ group }}</h3>
							<div class="accordion-section-content">
								<div class="inside mbb-two">
									<button type="button" class="button" ng-repeat="(type, label) in fields" ng-click="addField(type)" ng-show="!searchKeyword || isFound(label)">{{ label }}</button>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<div id="menu-management-liquid">
				<div id="menu-management">
					<div class="menu-edit">
						<div id="nav-menu-header">
							<div class="major-publishing-actions">
								<div class="pull-menu-name">
									<label class="menu-name-label howto open-label" for="menu-name"><?php esc_html_e( 'Title', 'meta-box-builder' ); ?></label>
									<input name="post_title" ng-change="onchangetitle('{{meta.slug}}')" ng-model="meta.title" id="menu-name" type="text" class="menu-name regular-text menu-item-textbox" placeholder="<?php esc_attr_e( 'Enter name here', 'meta-box-builder' ); ?>">
								</div>
								<div class="pull-menu-slug">
									<label class="menu-name-label howto open-label" for="menu-name-slug"><?php esc_html_e( 'ID', 'meta-box-builder' ); ?></label>
									<input name="post_slug" ng-model="meta.id" id="menu-name-slug" type="text" class="menu-name-slug regular-text menu-item-textbox" ng-change="meta.is_id_modified = true">
								</div>
								<div class="publishing-action">
									<?php $status = get_post_status( $post_id ); ?>
									<?php if ( 'publish' === $status ) : ?>
										<button disabled class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"><?php esc_html_e( 'Switch to Draft', 'meta-box-builder' ); ?></button>
										<button disabled class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Update', 'meta-box-builder' ); ?></button>
									<?php else : ?>
										<button disabled class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"> <?php esc_html_e( 'Save Draft', 'meta-box-builder' ); ?></button>
										<button disabled class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Publish', 'meta-box-builder' ); ?></button>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div id="post-body">
							<div id="post-body-content">

								<h3><?php esc_html_e( 'Fields', 'meta-box-builder' ); ?></h3>
								<p ng-show="meta.fields.length == 0">
									<?php esc_html_e( 'No fields. Select fields on the left to add them to this field group.', 'meta-box-builder' ); ?>
								</p>
								<p ng-show="meta.fields.length > 0">
									<?php esc_html_e( 'Drag and drop fields to reorder. Click the title bar to reveal field settings.', 'meta-box-builder' ); ?>
								</p>

								<tg-dynamic-directive class="mbb-fields-wrapper" ng-model="meta" tg-dynamic-directive-view="getView"></tg-dynamic-directive>

								<?php include MBB_DIR . 'views/item-template.php' ?>

							</div>
						</div>

						<div id="nav-menu-footer">
							<div class="major-publishing-actions">
								<?php if ( current_user_can( 'delete_post', $post_id ) ) : ?>
									<span class="delete-action">
										<a class="submitdelete deletion menu-delete" href="<?= esc_url( get_delete_post_link( $post_id ) ); ?> "><?php esc_html_e( 'Move to Trash', 'meta-box-builder' ); ?></a>
									</span>
								<?php endif; ?>
								<div class="publishing-action">
									<?php $status = get_post_status( $post_id ); ?>
									<?php if ( 'publish' === $status ) : ?>
										<button disabled class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"><?php esc_html_e( 'Switch to Draft', 'meta-box-builder' ); ?></button>
										<button disabled class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Update', 'meta-box-builder' ); ?></button>
									<?php else : ?>
										<button disabled class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"> <?php esc_html_e( 'Save Draft', 'meta-box-builder' ); ?></button>
										<button disabled class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Publish', 'meta-box-builder' ); ?></button>
									<?php endif; ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<?php
			// Generate script content for each template
			foreach ( $menu as $block => $fields ):
				foreach ( $fields as $k => $v ) : ?>

					<script type="text/ng-template" id="<?= $k ?>.edit.html">
						<?php mbb_get_field_edit_content( $k ); ?>
					</script>

				<?php endforeach; endforeach; ?>

			<datalist id="available_fields">
				<option ng-repeat="field in available_fields track by $index" value="{{field}}">
			</datalist>
		</div>

		<div class="builder-code-tab builder-code-tab--setting content-setting <?php if ( 'settings' === $active ) echo 'metabox-tab-show'; ?>">
			<?php require __DIR__ . '/settings.php'; ?>
		</div>

    </div>

</div>
