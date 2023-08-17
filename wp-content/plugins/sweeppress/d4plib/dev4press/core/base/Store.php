<?php

/*
Name:    Dev4Press\v42\Core\Base\Store
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

namespace Dev4Press\v42\Core\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Store {
	protected $_data = array();

	public function __get( $name ) {
		return $this->_data[ $name ] ?? '';
	}

	public function __set( $name, $value ) {
		$this->_data[ $name ] = $value;
	}

	public function __clone() {
		foreach ( $this as $key => $val ) {
			if ( is_object( $val ) || ( is_array( $val ) ) ) {
				$this->{$key} = unserialize( serialize( $val ) );
			}
		}
	}

	public function init_data( $data ) {
		$this->_data = $data;
	}

	public function to_array() : array {
		return $this->_data;
	}
}
