jQuery( function ( $ ) {
	// Add "Export" option to the Bulk Actions dropdowns.
	$( '<option value="export-meta-boxes">' )
		.text( MBB.export )
		.appendTo( 'select[name="action"], select[name="action2"]' );

	// Toggle upload form.
	var $form = $( $( '#mbb-import-form' ).html() ).insertAfter( '.wp-header-end' );
	var $toggle = $( '<button class="page-title-action">' )
		.text( MBB.import )
		.insertAfter( '.page-title-action' );

	$toggle.on( 'click', function( e ) {
		e.preventDefault();
		$form.toggle();
	} );

	// Enable submit button when selecting a file.
	var $input = $form.find( 'input[type="file"]' ),
		$submit = $form.find( 'input[type="submit"]' );

	$input.on( 'change', function() {
		$submit.prop( 'disabled', ! $input.val() );
	} );
} );