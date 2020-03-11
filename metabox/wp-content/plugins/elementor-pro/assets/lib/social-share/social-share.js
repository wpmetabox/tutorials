( function( $ ) {
	var ShareLink = function( element, userSettings ) {
		var $element,
			settings = {};

		var getNetworkLink = function( networkName ) {
			var link = ShareLink.networkTemplates[ networkName ].replace( /{([^}]+)}/g, function( fullMatch, pureMatch ) {
				return settings[ pureMatch ];
			} );

			if ( 'email' === networkName && link.indexOf( '?subject=&body') ) {
				link = link.replace( 'subject=&', '' );
			}

			return encodeURI( link );
		};

		var getNetworkNameFromClass = function( className ) {
			var classNamePrefix = className.substr( 0, settings.classPrefixLength );

			return classNamePrefix === settings.classPrefix ? className.substr( settings.classPrefixLength ) : null;
		};

		var bindShareClick = function( networkName ) {
			$element.on( 'click', function() {
				openShareLink( networkName );
			} );
		};

		var openShareLink = function( networkName ) {
			var shareWindowParams = '';

			if ( settings.width && settings.height ) {
				var shareWindowLeft = ( screen.width / 2 ) - ( settings.width / 2 ),
					shareWindowTop = ( screen.height / 2 ) - ( settings.height / 2 );

				shareWindowParams = 'toolbar=0,status=0,width=' + settings.width + ',height=' + settings.height + ',top=' + shareWindowTop + ',left=' + shareWindowLeft;
			}

			var link = getNetworkLink( networkName ),
				isPlainLink = /^https?:\/\//.test( link ),
				windowName = isPlainLink ? '' : '_self';

			open( link, windowName, shareWindowParams );
		};

		var run = function() {
			$.each( element.classList, function() {
				var networkName = getNetworkNameFromClass( this );

				if ( networkName ) {
					bindShareClick( networkName );

					return false;
				}
			} );
		};

		var initSettings = function() {
			$.extend( settings, ShareLink.defaultSettings, userSettings );

			[ 'title', 'text' ].forEach( function( propertyName ) {
				settings[ propertyName ] = settings[ propertyName ].replace( '#', '' );
			} );

			settings.classPrefixLength = settings.classPrefix.length;
		};

		var initElements = function() {
			$element = $( element );
		};

		var init = function() {
			initSettings();

			initElements();

			run();
		};

		init();
	};

	ShareLink.networkTemplates = {
		twitter: 'https://twitter.com/intent/tweet?url={url}&text={text}',
		pinterest: 'https://www.pinterest.com/pin/find/?url={url}',
		facebook: 'https://www.facebook.com/sharer.php?u={url}',
		vk: 'https://vkontakte.ru/share.php?url={url}&title={title}&description={text}&image={image}',
		linkedin: 'https://www.linkedin.com/shareArticle?mini=true&url={url}&title={title}&summary={text}&source={url}',
		odnoklassniki: 'https://connect.ok.ru/offer?url={url}&title={title}&imageUrl={image}',
		tumblr: 'https://tumblr.com/share/link?url={url}',
		delicious: 'https://del.icio.us/save?url={url}&title={title}',
		google: 'https://plus.google.com/share?url={url}',
		digg: 'https://digg.com/submit?url={url}',
		reddit: 'https://reddit.com/submit?url={url}&title={title}',
		stumbleupon: 'https://www.stumbleupon.com/submit?url={url}',
		pocket: 'https://getpocket.com/edit?url={url}',
		whatsapp: 'whatsapp://send?text=*{title}*\n{text}\n{url}',
		xing: 'https://www.xing.com/app/user?op=share&url={url}',
		print: 'javascript:print()',
		email: 'mailto:?subject={title}&body={text}\n{url}',
		telegram: 'https://telegram.me/share/url?url={url}&text={text}',
		skype: 'https://web.skype.com/share?url={url}',
	};

	ShareLink.defaultSettings = {
		title: '',
		text: '',
		image: '',
		url: location.href,
		classPrefix: 's_',
		width: 640,
		height: 480,
	};

	var ShareCounter = function( element, userSettings ) {
		var $element,
			settings = {};

		var formatNumber = function( number ) {
			var numberLength = ( number + '' ).length,
				symbols = [ 'K', 'M', 'B' ],
				nextPoint = 3;

			if ( numberLength <= nextPoint ) {
				return number;
			}

			for ( var i = 0; i < symbols.length; i++ ) {
				var currentLength = nextPoint * ( i + 1 );

				if ( numberLength > currentLength + nextPoint ) {
					continue;
				}

				number = number / Math.pow( 10, currentLength );

				if ( currentLength + 1 === numberLength ) {
					number = +number.toFixed( 1 );
				} else {
					number = Math.floor( number );
				}

				return number + symbols[ i ];
			}

			return number;
		};

		var getNetworkNameFromClass = function( className ) {
			var classNamePrefix = className.substr( 0, settings.classPrefixLength );

			return classNamePrefix === settings.classPrefix ? className.substr( settings.classPrefixLength ) : null;
		};

		var getShareCount = function( networkName ) {
			ShareCounter.getNetworkShareCounts( settings.url, settings.providers, function( shareCounts ) {
				var number = shareCounts[ networkName ] || 0;

				if ( settings.formatCount ) {
					number = formatNumber( number );
				}

				$element.text( number );
			} );
		};

		var run = function() {
			$.each( element.classList, function() {
				var networkName = getNetworkNameFromClass( this );

				if ( networkName ) {
					getShareCount( networkName );

					return false;
				}
			} );
		};

		var initSettings = function() {
			$.extend( settings, ShareCounter.defaultSettings, userSettings );

			settings.classPrefixLength = settings.classPrefix.length;
		};

		var initElements = function() {
			$element = $( element );
		};

		var init = function() {
			initSettings();

			initElements();

			run();
		};

		init();
	};

	ShareCounter.defaultSettings = {
		url: location.href,
		classPrefix: 'c_',
		formatCount: false,
		shareCountsAPI: 'https://{domain}/shares?url={url}&providers={providers}',
		providers: [ 'all' ],
	};

	ShareCounter.providers = {
		general: {
			url: function( url, providers ) {
				return ShareCounter.defaultSettings.shareCountsAPI
					.replace( '{url}', url )
					.replace( '{domain}', ElementorProFrontendConfig.donreach.api_url )
					.replace( '{providers}', providers.join( ',' ) );
			},
			getParsedData: function( data ) {
				return data.shares;
			},
		},
	};

	ShareCounter.requests = {};

	ShareCounter.getNetworkShareCounts = function( url, providers, callback ) {
		if ( ! ShareCounter.requests[ url ] ) {
			ShareCounter.requests[ url ] = {
				providers: [],
				data: {},
				xhRequest: {},
			};
		}

		var currentRequest = ShareCounter.requests[ url ];

		var notLoadedProviders = $.map( providers, function( provider ) {
			return -1 === currentRequest.providers.indexOf( provider ) ? provider : null;
		} );

		if ( notLoadedProviders.length ) {
			currentRequest.providers = currentRequest.providers.concat( notLoadedProviders );

			var generalProviders = notLoadedProviders.slice(); // Clone the array

			generalProviders.forEach( function( providerName, index ) {
				if ( ShareCounter.providers[ providerName ] ) {
					generalProviders.splice( index, 1 );

					currentRequest.xhRequest[ providerName ] = $.get(
						ShareCounter.providers[ providerName ].url( url ),
						function( data ) {
							currentRequest.data[ providerName ] = ShareCounter.providers[ providerName ].getParsedData( data );
						}
					);
				}
			} );

			var requestParams = {
				url: ShareCounter.providers.general.url( url, generalProviders ),
				headers: {
					Authorization: ElementorProFrontendConfig.donreach.key,
				},
				success: function( data ) {
					$.extend( currentRequest.data, ShareCounter.providers.general.getParsedData( data ) );
				},
			};
			currentRequest.xhRequest.general = $.get( requestParams );
		}

		$.when.apply( null, Object.values( currentRequest.xhRequest ) ).then( function() {
			callback( currentRequest.data );
		} );
	};

	$.each( { shareLink: ShareLink, shareCounter: ShareCounter }, function( pluginName ) {
		var PluginConstructor = this;

		$.fn[ pluginName ] = function( settings ) {
			return this.each( function() {
				$( this ).data( pluginName, new PluginConstructor( this, settings ) );
			} );
		};
	} );
} )( jQuery );
