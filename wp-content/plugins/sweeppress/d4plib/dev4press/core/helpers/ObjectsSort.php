<?php

/*
Name:    Dev4Press\v42\Core\Helpers\ObjectsSort
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

namespace Dev4Press\v42\Core\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ObjectsSort {
	public $properties;
	public $sorted;

	public function __construct( $objects_array, $properties = array(), $associative = false ) {
		$properties = (array) $properties;

		if ( count( $properties ) > 0 ) {
			$this->properties = $properties;

			if ( $associative ) {
				uasort( $objects_array, array( $this, 'array_compare' ) );
			} else {
				usort( $objects_array, array( $this, 'array_compare' ) );
			}
		}

		$this->sorted = $objects_array;
	}

	public function array_compare( $one, $two, $i = 0 ) : int {
		$column = $this->properties[ $i ][ 'property' ];
		$order  = strtolower( $this->properties[ $i ][ 'order' ] );

		if ( $one->$column == $two->$column ) {
			if ( $i < count( $this->properties ) - 1 ) {
				$i ++;

				return $this->array_compare( $one, $two, $i );
			} else {
				return 0;
			}
		}

		if ( strtolower( $order ) == 'asc' ) {
			return ( $one->$column < $two->$column ) ? - 1 : 1;
		} else {
			return ( $one->$column < $two->$column ) ? 1 : - 1;
		}
	}

	public static function run( $objects_array, $properties = array(), $uasort = false ) {
		$_sort = new ObjectsSort( $objects_array, $properties, $uasort );

		return $_sort->sorted;
	}
}
