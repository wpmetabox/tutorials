<?php
require __DIR__ . '/nav.php';
$post = get_post( $_GET['post'] );
$encoder = new MBB\Encoders\MetaBox( $post );
$encoder->encode();
?>

<div id="export-gui">
	<p><?php echo __( 'Copy the snippet below and paste it into your theme\'s <code>functions.php</code> file. Then you can safely deactivate Meta Box Builder (do not deactivate Meta Box).', 'meta-box-builder' ); ?></p>
	<p><?php echo __( 'For more details, please see the <a href="https://docs.metabox.io/extensions/meta-box-builder/#getting-php-code" target="_blank">documentation</a>.', 'meta-box-builder' ); ?></p>

	<div class="render-html">
		<pre class="builder-code"><code class="php"><?= esc_textarea( $encoder->get_encoded_string() ); ?></code></pre>
		<a href="javascript:void(0)" class="mbb-button--copy" title="<?php esc_attr_e( 'Click to copy the code', 'meta-box-builder' ); ?>"><svg class="mbb-icon--copy" aria-hidden="true" role="img"><use href="#mbb-icon-copy" xlink:href="#icon-copy"></use></svg> <?php esc_html_e( 'Copy', 'meta-box-builder' ); ?></a>
	</div>
</div>

<svg style="display: none;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	<symbol id="mbb-icon-copy" viewBox="0 0 1024 896">
		<path d="M128 768h256v64H128v-64z m320-384H128v64h320v-64z m128 192V448L384 640l192 192V704h320V576H576z m-288-64H128v64h160v-64zM128 704h160v-64H128v64z m576 64h64v128c-1 18-7 33-19 45s-27 18-45 19H64c-35 0-64-29-64-64V192c0-35 29-64 64-64h192C256 57 313 0 384 0s128 57 128 128h192c35 0 64 29 64 64v320h-64V320H64v576h640V768zM128 256h512c0-35-29-64-64-64h-64c-35 0-64-29-64-64s-29-64-64-64-64 29-64 64-29 64-64 64h-64c-35 0-64 29-64 64z" />
	</symbol>
</svg>
