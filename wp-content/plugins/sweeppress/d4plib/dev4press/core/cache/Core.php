<?php

/*
Name:    Dev4Press\v42\Core\Cache\Core
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

abstract class Core {
	public $store = 'd4plib';

	public function __construct() {
		$this->clear();
	}

	/** @return static */
	public static function instance() {
		static $instance = array();

		if ( ! isset( $instance[ static::class ] ) ) {
			$instance[ static::class ] = new static();
		}

		return $instance[ static::class ];
	}

	private function _key( $group, $key ) : string {
		return $group . '::' . $key;
	}

	public function store() : Store {
		return Store::instance();
	}

	public function add( $group, $key, $data ) : bool {
		return $this->store()->add( $this->_key( $group, $key ), $data, $this->store );
	}

	public function set( $group, $key, $data ) : bool {
		return $this->store()->set( $this->_key( $group, $key ), $data, $this->store );
	}

	public function get( $group, $key, $default = false ) {
		$obj = $this->store()->get( $this->_key( $group, $key ), $this->store );

		return $obj === false ? $default : $obj;
	}

	public function delete( $group, $key ) : bool {
		return $this->store()->delete( $this->_key( $group, $key ), $this->store );
	}

	public function in( $group, $key ) : bool {
		return $this->store()->in( $this->_key( $group, $key ), $this->store );
	}

	public function clear() {
		$this->store()->flush( $this->store );
	}

	public function storage() : array {
		return $this->store()->get_group( $this->store );
	}
}
