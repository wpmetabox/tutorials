/**
 * Dashboard script.
 *
 * @package Justread.
 */

( function ( $ ) {
	'use strict';

	function tabs() {
		var $container = $( '.nav-tab-wrapper' ),
			$tabs = $container.find( '.nav-tab' ),
			$actionLinks = $( '.action-links' ),
			$panes = $( '.gt-tab-pane' );

		$container.on( 'click', '.nav-tab', function ( e ) {
			e.preventDefault();

			$tabs.removeClass( 'nav-tab-active' );
			$( this ).addClass( 'nav-tab-active' );

			$panes.removeClass( 'gt-is-active' );
			$panes.filter( $( this ).attr( 'href' ) ).addClass( 'gt-is-active' );
		} );

		$actionLinks.on( 'click', function( e ) {
			e.preventDefault();

			var href = $( this ).attr( 'href' );

			$tabs.filter( function() {
				return $( this ).attr( 'href' ) === href;
			} ).trigger( 'click' );
		} );
	}

	// Auto activate tabs when DOM ready.
	$( tabs );
} ( jQuery ) );
