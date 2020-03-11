( function( $, document, passwordStrength, i18n ) {
	var types = ['very-weak', 'very-weak', 'weak', 'medium', 'strong', 'mismatch'],
		requiredStrength = types.indexOf( i18n.strength ),
		$document = $( document ),
		$result,
		$submitButton = $( '[name="rwmb_profile_submit_register"], [name="rwmb_profile_submit_info"], [name="rwmb_profile_submit_login"]' ),
		$form = $submitButton.closest( 'form' );

	function checkPasswordStrength( password, password2 ) {
		if ( '' === password ) {
			$result.hide();
			return;
		}

		// Reset the form & meter.
		$submitButton.prop( 'disabled', true );
		$result.removeClass( 'very-weak weak medium strong mismatch' ).show();

		// Get the password strength.
		var strength = passwordStrength.meter( password, passwordStrength.userInputBlacklist(), password2 );
		if ( 0 > strength || 5 < strength ) {
			return;
		}
		var type = types[strength];

		$result.addClass( type ).html( i18n[type] );
		if ( requiredStrength <= strength && 5 !== strength ) {
			$submitButton.prop( 'disabled', false );
		}
	}

	function triggerCheck() {
		$result = $( '#password-strength' );

		var $user_pass = $( '#user_pass' ),
			$user_pass2 = $( '#user_pass2' );

		$document.on( 'keyup', '#user_pass, #user_pass2', function() {
			checkPasswordStrength( $user_pass.val(), $user_pass2.val() );
		} );
	}

	function checkRecaptcha( callback ) {
		grecaptcha.ready( function() {
			try {
				grecaptcha
					.execute( i18n.recaptchaKey, { action: 'mbup' } )
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

	function submitCallback() {
		$submitButton.prop( 'disabled', false ).trigger( 'click' );
		$submitButton.prop( 'disabled', true );
	}

	function handleSubmitClick( e ) {
		if ( '' !== i18n.recaptchaKey ) {
			e.preventDefault();

			if ( i18n.recaptchaKey ) {
				checkRecaptcha( submitCallback );
			} else {
				submitCallback();
			}
		}

		// Disable submit button right after submit to prevent submitting twice.
		setTimeout( function() {
			$submitButton.prop( 'disabled', true )
		}, 0 );
	}

	$submitButton.one( 'click', handleSubmitClick );

	$document.on( 'ready', triggerCheck );
} )( jQuery, document, wp.passwordStrength, MBUP_Data );