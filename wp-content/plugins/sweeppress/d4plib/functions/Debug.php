<?php

/*
Name:    Base Library Functions: Debug
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

use Dev4Press\v42\Core\Helpers\Debug;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'd4p_error_log' ) ) {
	function d4p_error_log( $log, $title = '' ) {
		Debug::error_log( $log, $title );
	}
}

if ( ! function_exists( 'd4p_print_r' ) ) {
	function d4p_print_r( $obj, $pre = true, $title = '', $before = '', $after = '' ) {
		Debug::print_r( $obj, $pre, $title, $before, $after );
	}
}

if ( ! function_exists( 'd4p_print_hooks' ) ) {
	function d4p_print_hooks( $filter = false, $destination = 'print' ) {
		Debug::print_hooks( $filter, $destination );
	}
}

if ( ! function_exists( 'd4p_debug_print_page_summary' ) ) {
	function d4p_debug_print_page_summary() {
		Debug::print_page_summary();
	}
}

if ( ! function_exists( 'd4p_debug_print_query_conditions' ) ) {
	function d4p_debug_print_query_conditions() {
		Debug::print_query_conditions();
	}
}

if ( ! function_exists( 'd4p_debug_print_page_request' ) ) {
	function d4p_debug_print_page_request() {
		Debug::print_page_request();
	}
}
