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
		loai_phong = [];
		tien_nghi  = [];
		tien_nghi_phong = [];

		$( 'input.filter-checkbox__input' ).removeAttr( 'checked' );
		$( '.filter-action, .filter-checkbox, .filter-loai-phong, .filter-tien-nghi, .filter-tien-nghi-phong, .filter-gia-phong' ).on( 'click', function() {
			var location   = $( '#location' ).val(),
			nguoi_lon  = $( '#adults' ).val(),
			tre_em     = $( '#chidren' ).val(),
			min_price  = $(this).attr( 'data-min-price' ),
			max_price  = $(this).attr( 'data-max-price' );

			rate_list.push( $(this).attr( 'data-rate-value' ) );
			loai_phong.push( $(this).attr( 'data-loai-phong-value' ) );
			tien_nghi.push( $(this).attr( 'data-tien-nghi-value' ) );
			tien_nghi_phong.push( $(this).attr( 'data-tien-nghi-phong-value' ) );

			var input_check = $(this).find( 'input' ).attr( 'checked' );
			
			$(this).find( 'input' ).attr( 'checked', 'checked' );
			jQuery.ajax({
				url: ajax_object.ajax_url,
				type: "POST",
				data: {
					action: 'justread_filter_hotel',
					rate: rate_list,
					location: location,
					loai_phong: loai_phong,
					tien_nghi: tien_nghi,
					tien_nghi_phong: tien_nghi_phong,
					min_price: min_price,
					max_price: max_price,
					nguoi_lon: nguoi_lon,
					tre_em: tre_em,
				},
				success: function(response) {
					$( '.site-main' ).html(response.post);
					console.log(response.test);
				}
			});
		} );

		$( '.single-hotel .filter-action' ).on( 'click', () => {
			let new_location = $( '#location' ).val(),
				new_nguoi_lon  = $( '#adults' ).val(),
				new_tre_em     = $( '#children' ).val();
				
			if ( new_location ) {
				new_location = 'new_location=' + new_location;
			} else {
				new_location = '';
			}

			if ( new_nguoi_lon ) {
				new_nguoi_lon = 'new_nguoi_lon=' + new_nguoi_lon;
			} else {
				new_nguoi_lon = '';
			}

			if ( new_tre_em ) {
				new_tre_em = 'new_tre_em=' + new_tre_em;
			} else {
				new_tre_em = '';
			}
			// console.log(new_nguoi_lon,new_tre_em);
			window.location = 'http://demo1.elightup.com/test-metabox/hotel?' + new_location + '&' + new_nguoi_lon + '&' + new_tre_em;
			
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