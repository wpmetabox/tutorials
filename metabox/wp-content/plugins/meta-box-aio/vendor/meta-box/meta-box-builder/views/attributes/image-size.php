<label for="{{field.id}}-image-size">
	<?php esc_html_e( 'Image size', 'meta-box-builder' ); ?>
	<?= mbb_tooltip( __( 'Image size that displays in the edit page', 'meta-box-builder' ) ) ?>
</label>
<?php $image_sizes = get_intermediate_image_sizes(); ?>
<select ng-model="field.image_size" id="{{field.id}}-image-size" class="widefat">
	<option value=""></option>
	<?php $image_sizes = get_intermediate_image_sizes(); ?>
	<?php foreach ( $image_sizes as $image_size ) : ?>
		<option value="<?= esc_attr( $image_size ) ?>"><?= esc_html( $image_size ) ?></option>
	<?php endforeach ?>
</select>