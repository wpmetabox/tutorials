<label for="{{field.id}}_field_type"><?php esc_html_e( 'Field type', 'meta-box-builder' ) ?></label>
<select ng-model="field.field_type" class="widefat" id="{{field.id}}_field_type">
	<option value="select"><?php esc_html_e( 'Select', 'meta-box-builder' ) ?></option>
	<option value="select_tree"><?php esc_html_e( 'Select tree', 'meta-box-builder' ) ?></option>
	<option value="select_advanced"><?php esc_html_e( 'Select advanced', 'meta-box-builder' ) ?></option>
	<option value="checkbox_list"><?php esc_html_e( 'Checkbox list', 'meta-box-builder' ) ?></option>
	<option value="checkbox_tree"><?php esc_html_e( 'Checkbox tree', 'meta-box-builder' ) ?></option>
	<option value="radio_list"><?php esc_html_e( 'Radio list', 'meta-box-builder' ) ?></option>
</select>