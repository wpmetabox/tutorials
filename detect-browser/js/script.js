import { createHooks } from '@wordpress/hooks';

jQuery( function ($) {

	let globalHooks = createHooks();
	function detect_browser() {
		if ( ( navigator.userAgent.indexOf( 'Opera' ) || navigator.userAgent.indexOf( 'OPR' ) ) != -1 ) {
			console.log( 'Opera Browser' );
		}
		else if ( navigator.userAgent.indexOf( 'Chrome' ) != -1 ) {
			console.log( 'Hi Chrome Browser' );
		}
		else if ( navigator.userAgent.indexOf( 'Safari' ) != -1 ) {
			console.log( 'Safari Browser' );
		}
		else if ( navigator.userAgent.indexOf( 'Firefox' ) != -1 )  {
			console.log( 'Firefox Browser' );
		}
		else if ( ( navigator.userAgent.indexOf( 'MSIE' ) != -1 ) || ( !! document.documentMode == true ) ) {
			console.log( 'IE Browser' ); 
		}
		else {
			console.log( 'unknown Browser' );
		}

	}
	// detect_browser();
	globalHooks.applyFilters( 'detect_browser', detect_browser() );

	// globalHooks.removeAllFilters( 'detect_browser' );
} );