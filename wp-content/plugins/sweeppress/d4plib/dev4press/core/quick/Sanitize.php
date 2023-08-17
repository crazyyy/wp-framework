<?php

/*
Name:    Dev4Press\v42\Core\Quick\Sanitize
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

use DateTime;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sanitize {
	public static function date( $value, $format = 'Y-m-d', $return_on_error = '' ) : string {
		$dt = DateTime::createFromFormat( '!' . $format, $value );

		if ( $dt === false ) {
			return $return_on_error;
		}

		return $dt->format( $format );
	}

	public static function time( $value, $format = 'H:i:s', $return_on_error = '' ) : string {
		return Sanitize::date( $value, $format, $return_on_error );
	}

	public static function month( $value, $format = 'Y-m', $return_on_error = '' ) : string {
		return Sanitize::date( $value, $format, $return_on_error );
	}

	public static function absint( $value ) : int {
		return absint( $value );
	}

	public static function key( $key ) : string {
		$key = strtolower( $key );

		return preg_replace( '/[^a-z0-9._\-]/', '', $key );
	}

	public static function slug( $text ) : string {
		return trim( sanitize_title_with_dashes( stripslashes( $text ) ), "-_ \t\n\r\0\x0B" );
	}

	public static function email( $email ) : string {
		return sanitize_email( $email );
	}

	public static function url( $url ) : string {
		return sanitize_url( $url );
	}

	public static function basic( string $text, bool $strip_shortcodes = true ) : string {
		$text = stripslashes( $text );

		if ( $strip_shortcodes ) {
			$text = strip_shortcodes( $text );
		}

		return trim( wp_kses( $text, array() ) );
	}

	public static function extended( $text, $tags = null, $protocols = array(), bool $strip_shortcodes = false ) : string {
		$tags = is_null( $tags ) ? wp_kses_allowed_html( 'post' ) : $tags;
		$text = stripslashes( $text );

		if ( $strip_shortcodes ) {
			$text = strip_shortcodes( $text );
		}

		return wp_kses( trim( $text ), $tags, $protocols );
	}

	public static function html( $text, $tags = null, $protocols = array() ) : string {
		$tags = is_null( $tags ) ? wp_kses_allowed_html( 'post' ) : $tags;

		return wp_kses( trim( stripslashes( $text ) ), $tags, $protocols );
	}

	public static function html_classes( $classes ) : string {
		$list = is_array( $classes ) ? $classes : explode( ' ', trim( stripslashes( $classes ) ) );
		$list = array_map( 'sanitize_html_class', $list );

		return trim( join( ' ', $list ) );
	}

	public static function basic_array( array $input, bool $strip_shortcodes = true ) : array {
		$output = array();

		foreach ( $input as $key => $value ) {
			$output[ $key ] = Sanitize::basic( $value, $strip_shortcodes );
		}

		return $output;
	}

	public static function key_array( array $input ) : array {
		$output = array();

		foreach ( $input as $key => $value ) {
			$output[ $key ] = Sanitize::key( $value );
		}

		return $output;
	}

	public static function ids_list( $ids, $map = 'absint' ) : array {
		if ( empty( $ids ) ) {
			return array();
		}

		$ids = (array) $ids;

		$ids = array_map( $map, $ids );
		$ids = array_unique( $ids );

		return array_filter( $ids );
	}

	public static function file_path( $filename ) : string {
		$filename_raw = $filename;

		$special_chars = apply_filters( __NAMESPACE__ . '\sanitize\file_path_chars', array(
			"?",
			"[",
			"]",
			"/",
			"\\",
			"=",
			"<",
			">",
			":",
			";",
			",",
			"'",
			"\"",
			"&",
			"$",
			"#",
			"*",
			"(",
			")",
			"|",
			"~",
			"`",
			"!",
			"{",
			"}",
			"%",
			"+",
			chr( 0 )
		), $filename_raw );

		$filename = preg_replace( "#\x{00a0}#siu", ' ', $filename );
		$filename = str_replace( $special_chars, '', $filename );
		$filename = str_replace( array( '%20', '+' ), '-', $filename );
		$filename = preg_replace( '/[\r\n\t -]+/', '-', $filename );
		$filename = trim( $filename, '.-_' );

		return apply_filters( __NAMESPACE__ . '\sanitize\file_path', $filename, $filename_raw );
	}

	public static function _get_slug( $name, $default ) {
		return ! empty( $_GET[ $name ] ) ? Sanitize::slug( $_GET[ $name ] ) : $default;
	}

	public static function _get_basic( $name, $default ) {
		return ! empty( $_GET[ $name ] ) ? Sanitize::basic( $_GET[ $name ] ) : $default;
	}

	public static function _get_absint( $name, $default ) {
		return ! empty( $_GET[ $name ] ) ? Sanitize::absint( $_GET[ $name ] ) : $default;
	}
}
