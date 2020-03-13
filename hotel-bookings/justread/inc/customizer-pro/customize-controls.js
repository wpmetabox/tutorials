/**
 * Script for theme dashboard.
 *
 * @package Justread.
 */

( function( api ) {

	// Extends our custom "gt-go-pro" section.
	api.sectionConstructor['gt-go-pro'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
