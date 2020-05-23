<?php 

function libs_import() {
    wp_enqueue_style( 'datatable-style', 'https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/css/jquery.dataTables.min.css', '1.10.18', true );
    wp_enqueue_script( 'datatable-script', 'https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/js/jquery.dataTables.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/js/script.js' );
}
add_action( 'wp_enqueue_scripts', 'libs_import' );

?>

