<?php
/**
 * Store form config in the session.
 */

namespace MBFS;

class ConfigStorage {
	public static function get( $key ) {
		return isset( $_SESSION[ $key ] ) ? $_SESSION[ $key ] : null;
	}

	public static function store( $config ) {
		$key              = md5( serialize( $config ) );
		$_SESSION[ $key ] = $config;
		return $key;
	}
}