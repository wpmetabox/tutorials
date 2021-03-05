import { createHooks } from '@wordpress/hooks';

jQuery( function ($) {

	let globalHooks = createHooks();
	function getBrowser() {
		let result = '';
		if ( ( navigator.userAgent.indexOf( 'Opera' ) || navigator.userAgent.indexOf( 'OPR' ) ) != -1 ) {
			result = 'Opera Browser';
		}
		else if ( navigator.userAgent.indexOf( 'Chrome' ) != -1 ) {
			result = 'Hi Chrome Browser';
		}
		else if ( navigator.userAgent.indexOf( 'Safari' ) != -1 ) {
			result = 'Safari Browser';
		}
		else if ( navigator.userAgent.indexOf( 'Firefox' ) != -1 )  {
			result = 'Firefox Browser';
		}
		else if ( ( navigator.userAgent.indexOf( 'MSIE' ) != -1 ) || ( !! document.documentMode == true ) ) {
			result = 'IE Browser';
		}
		else {
			result = 'unknown Browser';
		}
		return globalHooks.applyFilters( 'detect_browser', result );
	}

	
	globalHooks.addFilter( 'detect_browser', 'myApp', filterGetBrowser );
	function filterGetBrowser() {
		return navigator.appVersion;
	}


	console.log( getBrowser() );
} );