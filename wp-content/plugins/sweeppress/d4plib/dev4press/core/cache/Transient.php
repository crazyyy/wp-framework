<?php

/*
Name:    Dev4Press\v42\Core\Cache\Transient
Version: v4.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com/

== Copyright ==
Copyright 2008 - 2023 Milan Petrovic (email: support@dev4press.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

namespace Dev4Press\v42\Core\Cache;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Transient {
	public $store = 'd4plib';

	protected $expiration = DAY_IN_SECONDS;
	protected $elements = array();

	public function __construct() {

	}

	protected function _key( $name, $args = array() ) : string {
		$key = $name;

		if ( ! empty( $args ) ) {
			$key .= '-' . md5( json_encode( $args ) );
		}

		return $this->store . '-' . $key;
	}

	protected function expiration( $name ) {
		return $this->elements[ $name ][ 'expiration' ] ?? $this->expiration;
	}

	public function get( string $name, array $args = array(), bool $force_current = false ) {
		$key   = $this->_key( $name, $args );
		$value = $force_current ? false : get_transient( $key );

		if ( ! $value ) {
			$value = $this->call( $name, $args );

			set_transient( $key, $value, $this->expiration( $name ) );
		}

		return $value;
	}

	abstract protected function call( $name, $args = array() ) : array;
}
