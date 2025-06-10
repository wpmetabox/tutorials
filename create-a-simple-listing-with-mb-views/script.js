jQuery( document ).ready( function ( $ ) {
	var $grid = $( '.grid' ).isotope( {
		itemSelector: '.grid-item',
		layoutMode: 'fitRows'
	} );

	$( '.filter-buttons button' ).on( 'click', function () {
		var filterValue = $( this ).attr( 'data-filter' );
		$grid.isotope( { filter: filterValue } );
		$( '.filter-buttons button' ).removeClass( 'active' );
		$( this ).addClass( 'active' );
	} );
} );
