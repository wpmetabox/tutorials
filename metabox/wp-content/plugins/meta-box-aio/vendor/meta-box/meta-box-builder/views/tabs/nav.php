<h2 class="nav-tab-wrapper wp-clearfix">
	<?php
	$tab    = mbb_get_current_tab();
	$active = filter_input( INPUT_GET, 'active' );
	$active = $active ?: 'fields';
	if ( $tab === 'code' ) {
		?>
		<a href="<?= add_query_arg( ['tab' => 'fields', 'active' => 'fields'] ); ?>" class="nav-tab"><?php esc_html_e( 'Fields', 'meta-box-builder' ); ?></a>
		<a href="<?= add_query_arg( ['tab' => 'fields', 'active' => 'settings'] ); ?>" class="nav-tab"><?php esc_html_e( 'Settings', 'meta-box-builder' ); ?></a>
		<?php
	} else {
		?>
		<a href="#" data-tab="fields" class="nav-tab nav-tab-js<?php if ( 'fields' === $active  ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Fields', 'meta-box-builder' ); ?></a>
		<a href="#" data-tab="setting" class="nav-tab nav-tab-js<?php if ( 'settings' === $active ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Settings', 'meta-box-builder' ); ?></a>
    	<?php
	}
	?>
	<?php if ( isset( $_GET['post'] ) ) : ?>
		<a href="<?= add_query_arg( 'tab', 'code' ); ?>" class="nav-tab <?php if ( 'code' === $tab ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Code', 'meta-box-builder' ); ?></a>
	<?php endif; ?>
</h2>
