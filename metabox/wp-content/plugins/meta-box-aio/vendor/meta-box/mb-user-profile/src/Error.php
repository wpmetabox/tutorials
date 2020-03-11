<?php
namespace MBUP;

class Error {
	private static $key = 'mbup_error';

	public static function set( $error = false ) {
		if ( false === $error ) {
			$error = __( 'There are some errors submitting the form. Please correct and try again.', 'mb-user-profile' );
		}
		$_SESSION[ self::$key ] = $error;
	}

	public static function has() {
		return ! empty( $_SESSION[ self::$key ] );
	}

	public static function clear() {
		unset( $_SESSION[ self::$key ] );
	}

	public static function show() {
		?>
		<div class="rwmb-error"><?= wp_kses_post( $_SESSION[ self::$key ] ); ?></div>
		<?php
	}
}