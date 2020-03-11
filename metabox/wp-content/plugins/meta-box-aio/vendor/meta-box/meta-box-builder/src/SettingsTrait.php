<?php
namespace MBB;

trait SettingsTrait {
	protected $settings;

	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Use overloading magic methods for short syntax.
	 */

	public function __get( $key ) {
		return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : null;
	}

	public function __set( $key, $value ) {
		return $this->settings[ $key ] = $value;
	}

	public function __isset( $key ) {
		return isset( $this->settings[ $key ] );
	}

	public function __unset( $key ) {
		unset( $this->settings[ $key ] );
	}
}
