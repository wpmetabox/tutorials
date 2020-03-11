( function ( document ) {
	var data = {
		'mb-admin-columns'                 : ['premium',                    'ui', 'admin'                                   ],
		'mb-blocks'                        : ['premium',            'data', 'ui', 'admin',                     'integration'],
		'mb-comment-meta'                  : [                      'data',                          , 'free'               ],
		'mb-custom-post-type'              : [           'popular', 'data', 'ui', 'admin',           , 'free'               ],
		'mb-custom-table'                  : ['premium',            'data'                                                  ],
		'mb-elementor-integrator'          : [                              'ui',          'frontend', 'free', 'integration'],
		'mb-frontend-submission'           : ['premium', 'popular',         'ui',          'frontend'                       ],
		'mb-relationships'                 : [           'popular', 'data',                          , 'free'               ],
		'mb-rest-api'                      : [                      'data',                          , 'free'               ],
		'mb-revision'                      : ['premium',            'data',       'admin'                                   ],
		'mb-settings-page'                 : ['premium', 'popular', 'data',       'admin'                                   ],
		'mb-term-meta'                     : ['premium', 'popular', 'data'                                                  ],
		'mb-user-meta'                     : ['premium', 'popular', 'data'                                                  ],
		'mb-user-profile'                  : ['premium',            'data', 'ui',          'frontend'                       ],
		'meta-box-beaver-themer-integrator': [                              'ui',          'frontend', 'free', 'integration'],
		'meta-box-builder'                 : ['premium', 'popular',         'ui', 'admin'                                   ],
		'meta-box-columns'                 : ['premium',                    'ui',                                           ],
		'meta-box-conditional-logic'       : ['premium', 'popular',         'ui'                                            ],
		'meta-box-facetwp-integrator'      : [                              'ui',          'frontend', 'free', 'integration'],
		'meta-box-geolocation'             : ['premium',            'data'                                                  ],
		'meta-box-group'                   : ['premium', 'popular', 'data', 'ui'                                            ],
		'meta-box-include-exclude'         : ['premium', 'popular',         'ui'                                            ],
		'meta-box-show-hide'               : ['premium',                    'ui'                                            ],
		'meta-box-tabs'                    : ['premium',                    'ui'                                            ],
		'meta-box-template'                : ['premium',            'data', 'ui', 'admin'                                   ],
		'meta-box-text-limiter'            : [                              'ui',                    , 'free'               ],
		'meta-box-tooltip'                 : ['premium',                    'ui'                                            ],
		'meta-box-yoast-seo'               : [                                    'admin',           , 'free', 'integration'],
	};
	var items = Array.prototype.slice.call( document.querySelectorAll( '.mbaio-list tbody tr' ) ),
		list = document.querySelectorAll( '.mbaio-filter a' );

	function show( item ) {
		item.classList.remove( 'hidden' );
	}

	function hide( item ) {
		item.classList.add( 'hidden' );
	}

	function filter( event ) {
		if ( 'A' !== event.target.tagName ) {
			return;
		}

		event.preventDefault();

		items.forEach( show );

		list.forEach( function( a ) {
			a.classList.remove( 'mbaio-active' );
		} );
		event.target.classList.add( 'mbaio-active' );

		var type = event.target.dataset.filter;
		if ( ! type ) {
			return;
		}
		items.filter( function( item ) {
			var extension = item.querySelector( 'input' ).value;

			return ! data.hasOwnProperty( extension ) || -1 === data[extension].indexOf( type );
		} ).forEach( hide );
	}

	document.querySelector( '.mbaio-filter' ).addEventListener( 'click', filter, false );

	tippy( document.body, {
		target: '.mbaio-tooltip',
		placement: 'right',
		arrow: true,
		animation: 'fade'
	} );
} )( document );
