<?php

/*
Name:    Dev4Press\v42\Core\Quick\URL
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

class URL {
	public static function domain_name( $url ) {
		return parse_url( $url, PHP_URL_HOST );
	}

	public static function current_request_path() {
		$uri = $_SERVER[ 'REQUEST_URI' ];

		return parse_url( $uri, PHP_URL_PATH );
	}

	public static function current_url_request() : string {
		$path_info = $_SERVER[ 'PATH_INFO' ] ?? '';
		list( $path_info ) = explode( '?', $path_info );
		$path_info = str_replace( '%', '%25', $path_info );

		$request         = explode( '?', $_SERVER[ 'REQUEST_URI' ] );
		$req_uri         = $request[ 0 ];
		$req_query       = $request[ 1 ] ?? false;
		$home_path       = parse_url( home_url(), PHP_URL_PATH );
		$home_path       = $home_path ? trim( $home_path, '/' ) : '';
		$home_path_regex = sprintf( '|^%s|i', preg_quote( $home_path, '|' ) );

		$req_uri = str_replace( $path_info, '', $req_uri );
		$req_uri = ltrim( $req_uri, '/' );
		$req_uri = preg_replace( $home_path_regex, '', $req_uri );
		$req_uri = ltrim( $req_uri, '/' );

		$url_request = $req_uri;

		if ( $req_query !== false ) {
			$url_request .= '?' . $req_query;
		}

		return $url_request;
	}

	public static function current_url( $use_wp = true ) : string {
		if ( $use_wp ) {
			return home_url( URL::current_url_request() );
		} else {
			$s        = empty( $_SERVER[ 'HTTPS' ] ) ? '' : ( $_SERVER[ 'HTTPS' ] == 'on' ? 's' : '' );
			$protocol = Str::left( strtolower( $_SERVER[ 'SERVER_PROTOCOL' ] ), '/' ) . $s;
			$port     = $_SERVER[ 'SERVER_PORT' ] == '80' || $_SERVER[ 'SERVER_PORT' ] == '443' ? '' : ':' . $_SERVER[ 'SERVER_PORT' ];

			return $protocol . '://' . $_SERVER[ 'SERVER_NAME' ] . $port . $_SERVER[ 'REQUEST_URI' ];
		}
	}

	public static function add_campaign_tracking( $url, $campaign = '', $medium = '', $content = '', $term = '', $source = null ) : string {
		if ( ! empty( $campaign ) ) {
			$url = add_query_arg( 'utm_campaign', $campaign, $url );
		}

		if ( ! empty( $medium ) ) {
			$url = add_query_arg( 'utm_medium', $medium, $url );
		}

		if ( ! empty( $content ) ) {
			$url = add_query_arg( 'utm_content', $content, $url );
		}

		if ( ! empty( $term ) ) {
			$url = add_query_arg( 'utm_term', $term, $url );
		}

		if ( is_null( $source ) ) {
			$source = parse_url( get_bloginfo( 'url' ), PHP_URL_HOST );
		}

		if ( ! empty( $source ) ) {
			$url = add_query_arg( 'utm_source', $source, $url );
		}

		return $url;
	}
}
