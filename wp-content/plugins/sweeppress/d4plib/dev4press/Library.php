<?php

/*
Name:    Dev4Press\v42\Library
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

namespace Dev4Press\v42;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Library {
	/**
	 * @var string
	 */
	private $_version = '4.2';
	/**
	 * @var string
	 */
	private $_build = '4200';
	/**
	 * @var string
	 */
	private $_php_version;
	/**
	 * @var int
	 */
	private $_php_code;
	/**
	 * @var string
	 */
	private $_library_url;
	/**
	 * @var string
	 */
	private $_library_path;
	/**
	 * @var string
	 */
	private $_cacert_path;

	public function __construct() {
		$this->_php_version  = (string) phpversion();
		$this->_php_code     = absint( substr( str_replace( '.', '', $this->_php_version ), 0, 2 ) );
		$this->_library_url  = str_replace( '/d4plib/dev4press/', '/d4plib/', plugins_url( '/', __FILE__ ) );
		$this->_library_path = wp_normalize_path( trailingslashit( dirname( __FILE__, 2 ) ) );
		$this->_cacert_path  = wp_normalize_path( $this->_library_path . 'resources/curl/cacert.pem' );
	}

	public static function instance() : Library {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Library();
		}

		return $instance;
	}

	public function charset() {
		return get_option( 'blog_charset' );
	}

	public function version() : string {
		return $this->_version;
	}

	public function build() : string {
		return $this->_build;
	}

	public function php_version() : string {
		return $this->_php_version;
	}

	public function php_code() : int {
		return $this->_php_code;
	}

	public function path() : string {
		return $this->_library_path;
	}

	public function url() : string {
		return $this->_library_url;
	}

	public function cacert_path() : string {
		return $this->_cacert_path;
	}
}
