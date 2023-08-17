<?php

/*
Name:    Dev4Press\v42\Core\Quick\Str
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
use Dev4Press\v42\Library;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Str {
	public static function is_valid_datetime( string $date, string $format = 'Y-m-d H:i:s' ) : bool {
		$d = DateTime::createFromFormat( $format, $date );

		return $d && $d->format( $format ) == $date;
	}

	public static function is_regex_valid( string $regex ) {
		if ( preg_match( '/' . $regex . '/i', 'dev4press' ) !== false ) {
			return true;
		}

		return preg_last_error();
	}

	public static function is_valid_md5( string $hash = '' ) : bool {
		return strlen( $hash ) == 32 && ctype_xdigit( $hash );
	}

	public static function is_json( $input, $allow_scalar = true ) : bool {
		if ( empty( trim( $input ) ) ) {
			return false;
		}

		if ( $allow_scalar && is_numeric( $input ) ) {
			return true;
		}

		if ( ! is_string( $input ) ) {
			return false;
		}

		if ( strlen( $input ) < 2 ) {
			return false;
		}

		if ( $allow_scalar ) {
			if ( $input === 'null' || $input === 'true' || $input === 'false' || $input === 'NULL' || $input === 'TRUE' || $input === 'FALSE' ) {
				return true;
			}

			if ( $input[ 0 ] === '"' && $input[ strlen( $input ) - 1 ] === '"' ) {
				return true;
			}
		}

		if ( '{' != $input[ 0 ] && '[' != $input[ 0 ] ) {
			return false;
		}

		if ( '{' == $input[ 0 ] && '}' != $input[ strlen( $input ) - 1 ] ) {
			return false;
		}

		if ( '[' == $input[ 0 ] && ']' != $input[ strlen( $input ) - 1 ] ) {
			return false;
		}

		return null !== json_decode( $input );
	}

	public static function starts_with( string $haystack, string $needle ) : bool {
		$length = strlen( $needle );

		return ! ( $length === 0 ) && substr( $haystack, 0, $length ) === $needle;
	}

	public static function ends_with( string $haystack, string $needle ) : bool {
		$length = strlen( $needle );

		return ! ( $length === 0 ) && substr( $haystack, - $length ) === $needle;
	}

	public static function left( string $s1, string $s2 ) {
		return substr( $s1, 0, strpos( $s1, $s2 ) );
	}

	public static function replace_first( string $search, string $replace, string $subject ) {
		$pos = strpos( $subject, $search );

		if ( $pos !== false ) {
			$subject = substr_replace( $subject, $replace, $pos, strlen( $search ) );
		}

		return $subject;
	}

	public static function slug_to_name( string $code, string $sep = '_' ) : string {
		$exp  = explode( $sep, $code );
		$name = strtolower( join( ' ', $exp ) );

		return ucwords( $name );
	}

	public static function to_ids( string $input, string $delimiter = ',', string $map = 'absint' ) : array {
		$ids = strip_tags( stripslashes( $input ) );

		$ids = explode( $delimiter, $ids );
		$ids = array_map( 'trim', $ids );
		$ids = array_map( $map, $ids );

		return array_filter( $ids );
	}

	public static function replace_tags( string $content, array $tags, string $before = '%', string $after = '%' ) : string {
		foreach ( $tags as $tag => $replace ) {
			$_tag = $before . $tag . $after;

			if ( strpos( $content, $_tag ) !== false ) {
				$content = str_replace( $_tag, $replace, $content );
			}
		}

		return $content;
	}

	public static function split_to_list( string $value, bool $empty_lines = false ) {
		$elements = preg_split( "/[\n\r]/", $value );

		if ( ! $empty_lines ) {
			$results = array();

			foreach ( $elements as $el ) {
				if ( trim( $el ) != '' ) {
					$results[] = $el;
				}
			}

			return $results;
		} else {
			return $elements;
		}
	}

	public static function to_length( string $text, int $length = 200, string $append = '&hellip;' ) : string {
		$text_length = function_exists( 'mb_strlen' )
			?
			mb_strlen( $text )
			:
			strlen( $text );

		if ( ! empty( $length ) && ( $text_length > $length ) ) {

			$text = function_exists( 'mb_substr' )
				?
				mb_substr( $text, 0, $length - 1 )
				:
				substr( $text, 0, $length - 1 );
			$text .= $append;
		}

		return $text;
	}

	public static function entity_decode( string $content, $quote_style = null, $charset = null ) : string {
		if ( null === $quote_style ) {
			$quote_style = ENT_QUOTES;
		}

		if ( null === $charset ) {
			$charset = Library::instance()->charset();
		}

		return html_entity_decode( $content, $quote_style, $charset );
	}

	public static function extract_images_urls( string $search, int $limit = 0 ) {
		$images  = array();
		$matches = array();

		if ( preg_match_all( "/<img(.+?)>/", $search, $matches ) ) {
			foreach ( $matches[ 1 ] as $image ) {
				$match = array();

				if ( preg_match( '/src=(["\'])(.*?)\1/', $image, $match ) ) {
					$images[] = $match[ 2 ];
				}
			}
		}

		if ( $limit > 0 && ! empty( $images ) ) {
			$images = array_slice( $images, 0, $limit );
		}

		if ( $limit == 1 ) {
			return count( $images ) > 0 ? $images[ 0 ] : '';
		} else {
			return $images;
		}
	}
}
