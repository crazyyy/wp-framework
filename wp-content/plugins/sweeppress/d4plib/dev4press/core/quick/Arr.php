<?php

/*
Name:    Dev4Press\v42\Core\Quick\Arr
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

namespace Dev4Press\v42\Core\Quick;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Arr {
	public static function is_associative( $array ) : bool {
		return is_array( $array ) && ( 0 !== count( array_diff_key( $array, array_keys( array_keys( $array ) ) ) ) || count( $array ) == 0 );
	}

	public static function to_html_attributes( $input ) : string {
		$list = array();

		foreach ( $input as $item => $value ) {
			if ( is_bool( $value ) ) {
				$list[] = $item;
			} else {
				$list[] = $item . '="' . esc_attr( $value ) . '"';
			}
		}

		return join( ' ', $list );
	}

	public static function remove_by_value( $input, $val, $preserve_keys = true ) : array {
		if ( empty( $input ) || ! is_array( $input ) ) {
			return array();
		}

		while ( in_array( $val, $input ) ) {
			unset( $input[ array_search( $val, $input ) ] );
		}

		return $preserve_keys ? $input : array_values( $input );
	}

	public static function get_css_size_units() : array {
		return array(
			'px'   => 'px',
			'%'    => '%',
			'em'   => 'em',
			'rem'  => 'rem',
			'in'   => 'in',
			'cm'   => 'cm',
			'mm'   => 'mm',
			'pt'   => 'pt',
			'pc'   => 'pc',
			'ex'   => 'ex',
			'ch'   => 'ch',
			'vw'   => 'vw',
			'vh'   => 'vh',
			'vmin' => 'vmin',
			'vmax' => 'vmax'
		);
	}
}
