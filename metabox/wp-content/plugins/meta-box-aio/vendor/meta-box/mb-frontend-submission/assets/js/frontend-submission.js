( function ( $, i18n, window, document ) {
	// Set ajax URL for ajax actions.
	if ( ! window.ajaxurl ) {
		window.ajaxurl = i18n.ajaxUrl;
	}

	function detectRedirection() {
		var urlParams = new URLSearchParams( window.location.search ),
			paramSubmit = urlParams.get( 'rwmb-form-submitted' ),
			paramDelete = urlParams.get( 'rwmb-form-deleted' );

		if ( ( paramSubmit || paramDelete ) && '' !== i18n.redirect ) {
			setTimeout( () => window.location.href = i18n.redirect, 2500 );
		}
	}

	function processForm() {
		var $form = $( this );
		var $submitBtn = $form.find( 'button[name=rwmb_submit]' );
		var $deleteBtn = $form.find( 'button[name=rwmb_delete]' );
		var isEdit = $submitBtn.attr( 'data-edit' );

		function disableSubmitButton() {
			var disabled = true;

			if ( $.validator && ! $form.valid() ) {
				disabled = false;
			}
			$submitBtn.prop( 'disabled', disabled );
		}

		function submitCallback() {
			if ( 'true' === i18n.ajax ) {
				performAjax( $submitBtn );
			} else {
				// Remove disable then trigger click again.
				$submitBtn.prop( 'disabled', false ).trigger( 'click' );
				disableSubmitButton();
			}
		}

		function addLoading( $btn ) {
			$btn.append( '<div class="rwmb-loading"></div>' );
		}

		function removeLoading() {
			$( '.rwmb-loading' ).remove();
		}

		function handleSubmitClick( e ) {
			if ( '' !== i18n.recaptchaKey || 'true' === i18n.ajax ) {
				e.preventDefault();

				$form.prepend( '<input name="action" type="hidden" value="ajax_submit" />' );

				if ( i18n.recaptchaKey ) {
					checkRecaptcha( submitCallback );
				} else {
					submitCallback();
				}
			}

			// Disable submit button right after submit to prevent submitting twice.
			setTimeout( disableSubmitButton, 0 );
		}

		function checkRecaptcha( callback ) {
			grecaptcha.ready( function() {
				try {
					grecaptcha
						.execute( i18n.recaptchaKey, { action: 'submit_frontend' } )
						.then( function( token ) {
							// Add token to form.
							$( '#captcha_token' ).val( token );
						} )
						.then( callback );
				} catch( error ) {
					displayMessage( i18n.captchaExecuteError );
				}
			} );
		}

		function performAjax() {
			// When doing ajax in edit mode, remove the old message first.
			if ( isEdit && $( '.rwmb-confirmation' ) ) {
				$( '.rwmb-confirmation' ).remove();
			}

			const data   = getAjaxData();
			const config = getAjaxConfig( data );

			addLoading( $submitBtn );

			const ajax = $.ajax( config );

			ajax.done( function( res ) {
				removeLoading();
				if( res.success ) {
					handleSuccessResponse( res );
				} else {
					handleFailureResponse( res );
				}
				scrollToResponse();
			} );
		}

		function scrollToResponse() {
			$( 'html, body' ).animate( {
				scrollTop: $form.offset().top - 50
			}, 200 );
		}

		function getAjaxData() {
			var data = new FormData( $form[0] );
			data.append( '_ajax_nonce', i18n.nonce );

			return data;
		}

		function getAjaxConfig( data ) {
			return {
				dataType: 'json',
				type: 'POST',
				data: data,
				url: i18n.ajaxUrl,
				contentType: false,
				processData: false
			};
		}

		function hasFileField() {
			$fileFields = $form.find( 'input[type="file"]' );
			return $fileFields.length > 0;
		}

		function handleSuccessResponse( res ) {
			const data = res.data;
			if ( 'submit' === data.type ) {
				displayMessage( i18n.ajaxSubmitResult );
			} else if ( 'delete' === data.type ) {
				displayMessage( i18n.ajaxDeleteResult );
			}
			if ( '' !== data.config.redirect ) {
				setTimeout( () => window.location.href = data.config.redirect, 2000 );
			}
		}

		function handleFailureResponse( res ) {
			displayMessage( res.data  );
		}

		function displayMessage( message ) {
			let messageHTML = '<div class="rwmb-confirmation">' + message + '</div>';
			let dashboardDelMes = '<div class="rwmb-confirmation is-deleted">' + message + '</div>';

			if ( isEdit ) {
				$form.prepend( messageHTML );
				// Enable submit button again.
				// The handler for submit button click only executes once, so we need to attach it again.
				$submitBtn
					.prop( 'disabled', false )
					.one( 'click', handleSubmitClick );
			} else {
				$form.replaceWith( dashboardDelMes );
			}
		}

		$submitBtn.one( 'click', handleSubmitClick );

		$deleteBtn.click( function( e ) {
			if ( 'true' === i18n.ajax ) {
				e.preventDefault();

				$form.prepend( '<input name="action" type="hidden" value="ajax_delete" />' );
				performAjax( $deleteBtn );
			} else {
				$( this ).off( 'click' ).click();
				disableSubmitButton();
			}
		} );
	}

	// Handle saving editor as doing ajax.
	function savingEditor() {
		var id = $( this ).attr( 'id' );

		$( document ).on( 'tinymce-editor-init', ( event, editor ) => {
			editor.on( 'input keyup', function(e) {
				editor.save();
			} );
		} );
	}

	function deletePostFromDashboard() {
		var $row;
		$( document )
			.on( 'click', '.mbfs-delete', function() {
				var $this = $( this );
				$this.siblings( '.mbfs-confirm' ).addClass( 'show' );
				$row = $this.parent().parent();
			} )
			.on( 'click', '.mbfs-close', function() {
				$( '.mbfs-confirm' ).removeClass( 'show' );
				setTimeout( () => $row.remove(), 1000 );
			} );
	}

	detectRedirection();
	deletePostFromDashboard();

	$( function() {
		$( '.rwmb-wysiwyg' ).each( savingEditor );
		$( '.rwmb-form' ).each( processForm );
	} );
} )( jQuery, mbFrontendForm, window, document );
