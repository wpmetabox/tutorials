<label><?php esc_html_e( 'Post Type', 'meta-box-builder' ) ?></label>
<select ng-model="field.post_type" ng-options="post_type.slug as post_type.name for post_type in post_types" multiple class="widefat"></select>
