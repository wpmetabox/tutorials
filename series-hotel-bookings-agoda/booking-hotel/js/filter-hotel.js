jQuery( function ( $ ) {
	function filterHotel() {
		$( '.check-in-date, .check-out-date' ).datepicker({
			minDate: 0,
			numberOfMonths: 2,
			showButtonPanel: true,

		});
		var location = ajax_object.location_autocomplete;
		$( '#location' ).autocomplete({
			source: location
		});


		rate_list  = [];
		hotel_type = [];
		facilities  = [];
		room_facilities = [];

		$( 'input.filter-checkbox__input' ).removeAttr( 'checked' );
		$( '.filter-action, .filter-checkbox, .filter-hotel-type, .filter-facilities, .filter-room-facilities, .filter-price' ).on( 'click', function() {
			var location   = $( '#location' ).val(),
			adults  = $( '#adults' ).val(),
			chidren     = $( '#chidren' ).val(),
			min_price  = $(this).attr( 'data-min-price' ),
			max_price  = $(this).attr( 'data-max-price' );

			rate_list.push( $(this).attr( 'data-rate-value' ) );
			hotel_type.push( $(this).attr( 'data-hotel-type-value' ) );
			facilities.push( $(this).attr( 'data-facilities-value' ) );
			room_facilities.push( $(this).attr( 'data-room-facilities-value' ) );

			var input_check = $(this).find( 'input' ).attr( 'checked' );
			
			$(this).find( 'input' ).attr( 'checked', 'checked' );
			jQuery.ajax({
				url: ajax_object.ajax_url,
				type: "POST",
				data: {
					action: 'justread_filter_hotel',
					rate: rate_list,
					location: location,
					hotel_type: hotel_type,
					facilities: facilities,
					room_facilities: room_facilities,
					min_price: min_price,
					max_price: max_price,
					adults: adults,
					chidren: chidren,
				},
				success: function(response) {
					$( '.site-main' ).html(response.post);
					console.log(response.test);
				}
			});
		} );

		$( '.single-hotel .filter-action' ).on( 'click', () => {
			let new_location = $( '#location' ).val(),
				new_adults  = $( '#adults' ).val(),
				new_chidren = $( '#children' ).val();
				
			if ( new_location ) {
				new_location = 'new_location=' + new_location;
			} else {
				new_location = '';
			}

			if ( new_adults ) {
				new_adults = 'new_adults=' + new_adults;
			} else {
				new_adults = '';
			}

			if ( new_chidren ) {
				new_chidren = 'new_chidren=' + new_chidren;
			} else {
				new_chidren = '';
			}
			// console.log(new_adults,new_chidren);
			window.location = 'http://demo1.elightup.com/test-metabox/hotel?' + new_location + '&' + new_adults + '&' + new_chidren;
			
		} );
	}
	

	function slideGallerySingleHotel() {
		$( '.gallery-side-reviews-wrapper' ).slick( {

		} );
		// $( '.gallery-side-popup' ).slick( {

		// } );
	}

	function popupThongTinHotel() {
		$( '.gallery-side-popup' ).magnificPopup( {
			type: 'image',
			delegate: 'a',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
			}
		} );
	}

	let filterSingleHotel = () => {

	}

	if ( $( 'body' ).hasClass( 'single-hotel' ) ) {
		popupThongTinHotel();
		slideGallerySingleHotel();
		filterSingleHotel();
	}
	filterHotel();
} );