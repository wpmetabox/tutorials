$( function () {
	var width_accordian = $( '.accordian ul' ).css( "width" );
	$( '.accordian .image_title' ).css( "width", width_accordian );

	var lis_count = $( '.accordian .mb-item' ).length;
	function set_width_time() {
		var width = 100 / lis_count;
		$( '.accordian .mb-item' ).css( "width", width + '%' );
	}
	set_width_time();

	$( ".accordian ul li.mb-item" ).hover( function () {
		var width1 = 40 / ( lis_count - 1 );
		$( '.accordian .mb-item' ).css( "width", width1 + '%' );
		$( this ).css( "width", '60%' );
	}, function () {
		set_width_time();
	} );
} );
