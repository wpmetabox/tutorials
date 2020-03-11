<?php
namespace MBFS;

class Error {
	private static $key = 'mbfs_error';

	public static function set( $error = false ) {
		if ( false === $error ) {
			$error = __( 'There are some errors submitting the form. Please correct and try again.', 'mb-frontend-submission' );
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