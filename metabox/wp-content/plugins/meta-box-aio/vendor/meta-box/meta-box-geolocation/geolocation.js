/* global google */

( function ( $, document, google ) {
	'use strict';

	// Use function construction to store location & DOM elements separately for meta box.
	var Location = function ( $container ) {
		this.$container = $container;
		this.settings = null;
	};

	Location.prototype = {
		/**
		 * Initialize.
		 */
		init: function () {
			this.getDataGeo();
			this.initAutocomplete();
		},

		/**
		 * Get data geo config.
		 */
		getDataGeo: function () {
			if ( this.settings === null ) {
				this.settings = this.$container.find( '.data-geo' ).data( 'geo' );
			}
		},

		/**
		 * Setup the autocomplete and run.
		 */
		initAutocomplete: function () {
			if ( this.settings === null ) {
				return;
			}
			var that = this;
			this.getAutocompleteFields().each( function() {
				that.autocomplete( this );
			} );
		},

		/**
		 * Get autocomplete fields. Which is text field and has name starts with "address".
		 */
		getAutocompleteFields: function () {
			// 2 cases: not in or in a group.
			return this.$container.find( '.rwmb-text[name^="address"], .rwmb-text[name*="[address"]' );
		},

		/**
		 * Setup the autocomplete for each address field.
		 *
		 * @param field Current DOM element of the address field.
		 *
		 * @link https://developers.google.com/maps/documentation/javascript/places-autocomplete
		 */
		autocomplete: function ( field ) {
			var that = this,
				$field = $( field ),
				autocomplete = $field.data( 'autocompleteController' );

			if ( autocomplete ) {
				return;
			}

			autocomplete = new google.maps.places.Autocomplete( field, this.settings );
			// When user select a place in drop down, bind data to related fields
			autocomplete.addListener( 'place_changed', function () {
				// Trigger for Map and other extensions.
				$field.trigger( 'selected_address' );

				var place = this.getPlace();
				if ( typeof place === 'undefined' ) {
					return;
				}

				// If auto complete field and related field inside group. Only populate data inside that group. And vice versa.
				var isGroup = $field.closest( '.rwmb-group-clone' ).length > 0,
					$scope = isGroup ? $field.closest( '.rwmb-group-clone' ) : $field.closest( '.rwmb-meta-box' ),
					lastAddressIndex = field.name.lastIndexOf( 'address' ),
					fieldId = field.name.substr( lastAddressIndex ).replace( ']', '' ),
					$elements = $scope.find( '.rwmb-geo-binding');

				$elements.each( function () {
					// What data is prepared to bind to that field
					var $this = $( this ),
						dataBinding = $this.data( 'binding' ),
						dataBindEmpty = $this.data( 'bind_if_empty' ),
						addressField = $this.data( 'address_field' ),
						// What is that data's value
						fieldValue = that.getFieldData( dataBinding, place );

						if ( addressField && fieldId != addressField ) {
							return;
						}
						if ( dataBinding !== 'address' && typeof fieldValue !== 'undefined' ) {
							if ( fieldValue || dataBindEmpty ) {
								$this.siblings( '.rwmb-input' ).children().val( fieldValue ).change();
							}
						}
				} );
			} );

			// Don't submit the form when select a address: https://metabox.io/support/topic/how-to-disable-submit-when-selecting-an-address/
			$field.on( 'keypress', function( e ) {
				return e.which !== 13;
			} );

			$field.data( 'autocompleteController', autocomplete );
		},

		/**
		 * Get value of a address component type.
		 *
		 * @link https://developers.google.com/maps/documentation/javascript/reference/3.exp/places-service#PlaceResult
		 *
		 * @param type  string                         Address component type.
		 * @param place google.maps.places.PlaceResult Information about a Place.
		 * @returns string
		 */
		getFieldData: function ( type, place ) {
			var that = this;

			// If field is not in address_component then try to find them in another place
			if ( [
					'formatted_address',
					'id',
					'name',
					'place_id',
					'reference',
					'url',
					'vicinity'
				].indexOf( type ) > - 1
				&& typeof place !== 'undefined' && typeof place[type] !== 'undefined' ) {
				return place[type];
			}
			if ( type === 'lat' ) {
				return place.geometry.location.lat();
			}

			if ( type === 'lng' ) {
				return place.geometry.location.lng();
			}

			if ( type === 'geometry' ) {
				return place.geometry.location.lat() + ',' + place.geometry.location.lng();
			}

			var val = '';

			// Allows users to merge data. For example: `shortname:country + ' ' + postal_code`
			if ( type.indexOf( '+' ) > -1 ) {
				type = type.split( '+' );
				type.forEach( function ( field ) {
					field = field.trim();

					if ( field.indexOf( "'" ) > -1 || field.indexOf( '"' ) > -1 ) {
						field = field.replace( /['"]+/g, '' );
						val += field;
					} else {
						val += that.getFieldData( field, place );
					}
				} );

				return val;
			}

			// Find value in `address_components`.
			for ( var i = 0, l = place.address_components.length; i < l; i ++ ) {
				var component = place.address_components[i],
					longName = true,
					fieldType = type;

				if ( type.indexOf( 'short:' ) > -1 ) {
					longName = false;
					fieldType = type.replace( 'short:', '' );
				}

				if ( component.types.indexOf( fieldType ) > -1 ) {
					val = longName ? component.long_name : component.short_name;
					break;
				}
			}
			return val;
		}
	};

	function update() {
		$( '.rwmb-meta-box' ).each( function () {
			var $this = $( this ),
				controller = $this.data( 'locationController' );
			if ( ! controller ) {
				controller = new Location( $this );
			}

			controller.init();
			$this.data( 'locationController', controller );
		} );
	}

	$( function () {
		update();
		$( document ).on( 'clone_completed', update ); // Handle group clone event.
	} );

} )( jQuery, document, google );
