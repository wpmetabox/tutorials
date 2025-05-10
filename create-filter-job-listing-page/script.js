jQuery( function ( $ ) {
	let qsRegex, buttonFilter, dropdownFilter, technicalSkills = [];

	const item = $( '.mb-container' ).isotope( {
		itemSelector: '.mb-item',
		layoutMode: 'fitRows',
		filter: function () {
			const $el = $( this );
			return (
				( !qsRegex || $el.text().match( qsRegex ) ) &&
				( !buttonFilter || $el.is( buttonFilter ) ) &&
				( !dropdownFilter || $el.is( dropdownFilter ) ) &&
				( !technicalSkills.length || technicalSkills.some( skill => $el.hasClass( skill ) ) )
			);
		}
	} );

	const applyIsotope = () => item.isotope();

	$( '#quicksearch' ).on( 'keyup', debounce( function () {
		qsRegex = new RegExp( $( this ).val(), 'gi' );
		applyIsotope();
	}, 100 ) );

	function debounce( func, wait ) {
		let timeout;
		return function ( ...args ) {
			clearTimeout( timeout );
			timeout = setTimeout( () => func.apply( this, args ), wait );
		};
	}

	$( '#job-type-filters' ).on( 'click', 'button', function () {
		buttonFilter = $( this ).data( 'filter' );
		$( '#job-type-filters .is-checked' ).removeClass( 'is-checked' );
		$( this ).addClass( 'is-checked' );
		applyIsotope();
	} );

	$( '.technical-skill-checkbox' ).on( 'change', function () {
		const value = $( this ).val();
		technicalSkills = $( this ).is( ':checked' )
			? [ ...technicalSkills, value ]
			: technicalSkills.filter( skill => skill !== value );
		applyIsotope();
	} );

	$( '#experience-level-select' ).on( 'change', function () {
		dropdownFilter = $( this ).val();
		applyIsotope();
	} );

} );
