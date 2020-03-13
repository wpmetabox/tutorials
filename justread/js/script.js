/**
 * Theme main script.
 *
 * @package Justread.
 */

( function( document, window, undefined ) {
	var form = document.getElementById( 'form-wrapper' ),
		toggle = document.querySelector( '.search-toggle' ),
		close = document.getElementById( 'search-close' ),
		click = 'ontouchstart' in window ? 'touchstart' : 'click';
	toggle.addEventListener( click, toggleSearchForm );
	close.addEventListener( click, closeSearchForm );

	function toggleSearchForm() {
		if ( form.classList.contains( 'is-visible' ) ) {
			closeSearchForm();
		} else {
			form.classList.add( 'is-visible' );
			form.querySelector( '.search-field' ).focus();
		}
	}
	function closeSearchForm() {
		form.classList.remove( 'is-visible' );
	}

	// Press ESC key close search form.
	document.addEventListener( 'keyup', function( event ) {
		if ( 27 === event.keyCode ) {
			closeSearchForm();
		}
	} );

	// Sticky share button for single posts. Applied only for large screens and icon style.
	if ( window.innerWidth >= 1200 && 'undefined' !== typeof StickySidebar ) {
		var adminBarHeight = document.body.classList.contains( 'admin-bar' ) ? 32 : 0,
			sharedaddy = new StickySidebar( '.entry-body .sharedaddy', {
				containerSelector: '.entry-body',
				innerWrapperSelector: '.sd-social-icon',
				topSpacing: adminBarHeight
			} );
	}

} )( document, window );
