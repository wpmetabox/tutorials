jQuery( document ).ready( function ( $ ) {

	// Get current room ID from body class
	var currentRoomId = null;
	var bodyClass = $( 'body' ).attr( 'class' );
	var match = bodyClass.match( /postid-(\d+)/ );
	if ( match ) {
		currentRoomId = match[ 1 ];
	}

	// Initialize datepicker for booking_date
	if ( !$( "#booking_date" ).val() ) {
		const today = $.datepicker.formatDate( 'yy-mm-dd', new Date() );
		$( "#booking_date" ).val( today ).datepicker( { dateFormat: "yy-mm-dd" } );
		$( '#booking_date' ).prop( "readonly", true );
	} else {
		$( '#booking_date' ).prop( "readonly", true );
	}

	// Function to get disabled dates
	function getDisabledDates( roomId ) {
		return new Promise( ( resolve, reject ) => {
			if ( !booking_ajax ) {
				reject( "booking_ajax is not defined" );
				return;
			}
			jQuery.ajax( {
				url: booking_ajax.ajax_url,
				type: 'POST',
				data: {
					action: 'get_disabled_dates',
					room_id: roomId,
					nonce: booking_ajax.nonce
				},
				success: function ( response ) {
					if ( response.success ) {
						let disabledDates = [];
						if ( typeof response.data.disabled_dates === 'string' ) {
							disabledDates = response.data.disabled_dates.split( ',' );
						} else if ( Array.isArray( response.data.disabled_dates ) ) {
							disabledDates = response.data.disabled_dates;
						}
						resolve( disabledDates );
					} else {
						reject( response.data );
					}
				},
				error: function ( xhr, status, error ) {
					reject( error );
				}
			} );
		} );
	}

	// Function to get all selected dates from other rooms
	function getAllSelectedDates( roomSelect ) {
		const selectedDates = [];
		const currentRoomId = roomSelect.val();
		const currentGroupIndex = roomSelect.closest( '.rwmb-group-clone' ).index();

		$( '.group-booking .rwmb-group-clone:not(.rwmb-clone-template)' ).each( function ( index ) {
			const groupRoomId = $( this ).find( "select[name*='[room]']" ).val();

			// Skip if it's the current room
			if ( index === currentGroupIndex ) {
				return;
			}

			// If it's another room with the same ID, add selected dates
			if ( groupRoomId === currentRoomId ) {
				const checkIn = $( this ).find( "input[name*='[check_in]']" ).val();
				const checkOut = $( this ).find( "input[name*='[check_out]']" ).val();
				if ( checkIn && checkOut ) {
					const dates = getDatesBetween( checkIn, checkOut );
					// Remove check-out date from disabled dates list
					dates.pop();
					selectedDates.push( ...dates );
				}
			}
		} );
		return selectedDates;
	}

	// Function to get all dates between two dates
	function getDatesBetween( startDate, endDate ) {
		const dates = [];
		const start = new Date( startDate );
		const end = new Date( endDate );
		for ( let date = start; date <= end; date.setDate( date.getDate() + 1 ) ) {
			dates.push( $.datepicker.formatDate( 'yy-mm-dd', date ) );
		}
		return dates;
	}

	// Function to update room price and datepicker
	function updateRoom( roomSelect ) {
		var curr = roomSelect.val();
		if ( !curr ) return;

		var price_unit = roomSelect.closest( '.rwmb-field' ).siblings().find( "input[name*='[price]']" );
		var check_in = roomSelect.closest( '.rwmb-field' ).siblings().find( "input[name*='[check_in]']" );
		var check_out = roomSelect.closest( '.rwmb-field' ).siblings().find( "input[name*='[check_out]']" );
		var total_nights = roomSelect.closest( '.rwmb-field' ).siblings().find( "input[name*='[total_nights_of_stay]']" );
		var extra_bed = roomSelect.closest( '.rwmb-field' ).siblings().find( "input[name*='[extra_bed]']" );
		var total_amount = roomSelect.closest( '.rwmb-field' ).siblings().find( "input[name*='[total_amount]']" );

		// Update room price
		var roomPrice = 0;
		rooms_data.forEach( function ( val ) {
			if ( curr == val[ 'id' ] ) {
				roomPrice = parseInt( val[ 'price' ] ) || 0;
				price_unit.val( roomPrice );
			}
		} );
		roomSelect.data( 'roomPrice', roomPrice );

		// Update Total Amount if check-out date exists
		if ( check_out.val() ) {
			var total = calculate_total_day( check_in.val(), check_out.val() );
			if ( !isNaN( total ) ) {
				total_nights.val( total );
				var extra = parseInt( extra_bed.val() ) || 0;
				var total_extra = extra * roomPrice;
				var finalAmount = ( roomPrice + total_extra ) * total;
				if ( !isNaN( finalAmount ) ) {
					total_amount.val( finalAmount );
					update_total_payment();
				}
			}
		}

		// Update datepicker
		getDisabledDates( curr ).then( disabledDates => {

			// Get all selected dates from other rooms
			const selectedDates = getAllSelectedDates( roomSelect );
			// Combine disabled dates and selected dates
			const allDisabledDates = [ ...new Set( [ ...disabledDates, ...selectedDates ] ) ];

			// Set up datepicker for check_in
			check_in.datepicker( 'destroy' ).datepicker( {
				dateFormat: "yy-mm-dd",
				beforeShowDay: function ( date ) {
					var formattedDate = $.datepicker.formatDate( 'yy-mm-dd', date );
					var isDisabled = allDisabledDates.includes( formattedDate );
					var today = new Date();
					today.setHours( 0, 0, 0, 0 );
					var isPastDate = date < today;

					return [ !isDisabled && !isPastDate, '', isDisabled ? 'This date cannot be booked' : isPastDate ? 'Cannot select past dates' : '' ];
				},
				onSelect: function ( date ) {
					var d = new Date( date );
					var af_date = d.getDate() + 1;
					var af_month = d.getMonth() + 1;
					var af_year = d.getFullYear();
					var min_date = af_year + '-' + af_month + '-' + af_date;
					check_out.datepicker( 'option', 'minDate', min_date );
				}
			} );

			// Set up datepicker for check_out
			check_out.datepicker( 'destroy' ).datepicker( {
				dateFormat: "yy-mm-dd",
				beforeShowDay: function ( date ) {
					var formattedDate = $.datepicker.formatDate( 'yy-mm-dd', date );
					var isDisabled = allDisabledDates.includes( formattedDate );
					var today = new Date();
					today.setHours( 0, 0, 0, 0 );
					var isPastDate = date < today;

					return [ !isDisabled && !isPastDate, '', isDisabled ? 'This date cannot be booked' : isPastDate ? 'Cannot select past dates' : '' ];
				},
				onSelect: function ( date ) {
					var total = calculate_total_day( check_in.val(), date );
					if ( !isNaN( total ) ) {
						total_nights.val( total );
						var extra = parseInt( extra_bed.val() ) || 0;
						var roomPrice = roomSelect.data( 'roomPrice' ) || 0;
						var total_extra = extra * roomPrice;
						var finalAmount = ( roomPrice + total_extra ) * total;
						if ( !isNaN( finalAmount ) ) {
							total_amount.val( finalAmount );
							update_total_payment();
						}
					}
				}
			} );
		} ).catch( error => {
			console.error( "Error updating disabled dates:", error );
		} );
	}

	// Initialize event for room select
	$( ".group-booking" ).on( 'change', "select[name*='[room]']", function () {
		updateRoom( $( this ) );
	} );

	// Initialize event for extra bed
	$( ".group-booking" ).on( 'change', "input[name*='[extra_bed]']", function () {
		var roomSelect = $( this ).closest( '.rwmb-field' ).siblings().find( "select[name*='[room]']" );
		var check_out = $( this ).closest( '.rwmb-field' ).siblings().find( "input[name*='[check_out]']" );
		var total_nights = $( this ).closest( '.rwmb-field' ).siblings().find( "input[name*='[total_nights_of_stay]']" );
		var total_amount = $( this ).closest( '.rwmb-field' ).siblings().find( "input[name*='[total_amount]']" );

		if ( check_out.val() ) {
			var roomPrice = roomSelect.data( 'roomPrice' ) || 0;
			var extra = parseInt( $( this ).val() ) || 0;
			var total = parseInt( total_nights.val() ) || 0;
			var total_extra = extra * roomPrice;
			var finalAmount = ( roomPrice + total_extra ) * total;
			if ( !isNaN( finalAmount ) ) {
				total_amount.val( finalAmount );
				update_total_payment();
			}
		}
	} );

	// Initialize for first room if exists
	if ( currentRoomId ) {
		var roomSelect = $( ".group-booking .rwmb-field select[name*='[room]']" );
		roomSelect.val( currentRoomId );
		updateRoom( roomSelect );
	}

	// Initialize for all rooms with existing values
	$( ".group-booking .rwmb-field select[name*='[room]']" ).each( function () {
		updateRoom( $( this ) );
	} );

	// Handle adding new room
	$( '.group-booking .add-clone' ).on( 'click', function ( e ) {
		setTimeout( function () {
			var rooms = $( '.group-booking .rwmb-group-clone:not(.rwmb-clone-template)' ).length;
			$( '#total_number_of_rooms' ).val( rooms );

			// Update all rooms
			$( ".group-booking .rwmb-field select[name*='[room]']" ).each( function () {
				updateRoom( $( this ) );
			} );
		}, 100 );
	} );

	// Handle room removal
	$( '.group-booking .remove-clone' ).on( 'click', function ( e ) {
		setTimeout( function () {
			var rooms = $( '.group-booking .rwmb-group-clone:not(.rwmb-clone-template)' ).length;
			$( '#total_number_of_rooms' ).val( rooms );
			update_total_payment();
		}, 100 );
	} );

	// Utility functions
	function calculate_total_day( check_in, check_out ) {
		var date1 = new Date( check_in );
		var date2 = new Date( check_out );
		return ( date2.getTime() - date1.getTime() ) / ( 1000 * 3600 * 24 );
	}

	function update_total_payment() {
		var total_payment = 0;
		$( ".group-booking .rwmb-field input[name*='[total_amount]']" ).each( function () {
			var value = parseInt( $( this ).val() ) || 0;
			total_payment += value;
		} );
		$( '#total' ).val( total_payment );
		var paid_amount = parseInt( $( '#paid_amount' ).val() ) || 0;
		var unpaid = total_payment - paid_amount;
		$( '#unpaid_amount' ).val( unpaid );
	}

	function update_paid_amount() {
		$( "#paid_amount" ).on( 'change', function () {
			$( '#unpaid_amount' ).val( parseInt( $( '#total' ).val() ) - parseInt( $( this ).val() ) );
		} );
	}
	update_paid_amount();
} );
