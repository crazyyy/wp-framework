<?php

/*
Name:    Dev4Press\v42\Core\Helpers\Download
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

class Download {
	private $_file_path;
	private $_file_name;

	public function __construct( $file_path, $file_name = null ) {
		$this->_file_path = $file_path;
		$this->_file_name = $file_name;

		if ( empty( $this->_file_name ) || ! is_string( $this->_file_name ) ) {
			$this->_file_name = basename( $this->_file_path );
		}
	}

	public static function instance( $file_path, $file_name = null ) : Download {
		static $_download = array();

		$key = $file_path . '-' . $file_name;

		if ( ! isset( $_download[ $key ] ) ) {
			$_download[ $key ] = new Download( $file_path, $file_name );
		}

		return $_download[ $key ];
	}

	public static function file_simple( $file_path, $file_name = null, $gdr_readfile = true ) {
		Download::instance( $file_path, $file_name )->simple( ! $gdr_readfile );
	}

	public static function file_resume( $file_path, $file_name = null ) {
		Download::instance( $file_path, $file_name )->resume();
	}

	public static function file_read( $file_path, $part_size_mb = 2, $return_size = true ) {
		return Download::instance( $file_path )->read_file( $part_size_mb, $return_size );
	}

	public function read_file( $part_size_mb = 2, $return_size = true ) {
		$counter   = 0;
		$part_size = $part_size_mb * 1024 * 1024;

		$handle = fopen( $this->_file_path, 'rb' );
		if ( $handle === false ) {
			return false;
		}

		@set_time_limit( 0 );
		while ( ! feof( $handle ) ) {
			$buffer = fread( $handle, $part_size );
			echo $buffer;
			flush();

			if ( $return_size ) {
				$counter += strlen( $buffer );
			}
		}

		$status = fclose( $handle );

		if ( $return_size && $status ) {
			return $counter;
		} else {
			return $status;
		}
	}

	public function simple( $system = false ) {
		header( "Pragma: public" );
		header( "Expires: 0" );
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header( "Content-Type: application/force-download" );
		header( "Content-Type: application/octet-stream" );
		header( "Content-Type: application/download" );
		header( "Content-Disposition: attachment; filename=" . $this->_file_name . ";" );
		header( "Content-Transfer-Encoding: binary" );
		header( "Content-Length: " . filesize( $this->_file_path ) );

		if ( $system ) {
			readfile( $this->_file_path );
		} else {
			$this->read_file();
		}
	}

	public function resume() {
		$fp = @fopen( $this->_file_path, 'rb' );

		$size   = filesize( $this->_file_path );
		$length = $size;
		$start  = 0;
		$end    = $size - 1;

		header( "Pragma: public" );
		header( "Expires: 0" );
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header( "Content-Type: application/force-download" );
		header( "Content-Type: application/octet-stream" );
		header( "Content-Type: application/download" );
		header( "Content-Disposition: attachment; filename=" . $this->_file_name . ";" );
		header( "Content-Transfer-Encoding: binary" );
		header( "Accept-Ranges: 0-$length" );

		if ( isset( $_SERVER[ 'HTTP_RANGE' ] ) ) {
			$c_end = $end;

			list( , $range ) = explode( '=', $_SERVER[ 'HTTP_RANGE' ], 2 );
			if ( strpos( $range, ',' ) !== false ) {
				header( "HTTP/1.1 416 Requested Range Not Satisfiable" );
				header( "Content-Range: bytes $start-$end/$size" );
				exit;
			}

			if ( $range[ 0 ] == '-' ) {
				$c_start = $size - substr( $range, 1 );
			} else {
				$range   = explode( '-', $range );
				$c_start = $range[ 0 ];
				$c_end   = ( isset( $range[ 1 ] ) && is_numeric( $range[ 1 ] ) ) ? $range[ 1 ] : $size;
			}

			$c_end = ( $c_end > $end ) ? $end : $c_end;
			if ( $c_start > $c_end || $c_start > $size - 1 || $c_end >= $size ) {
				header( "HTTP/1.1 416 Requested Range Not Satisfiable" );
				header( "Content-Range: bytes $start-$end/$size" );
				exit;
			}

			$start  = $c_start;
			$end    = $c_end;
			$length = $end - $start + 1;
			fseek( $fp, $start );
			header( 'HTTP/1.1 206 Partial Content' );

			header( "Content-Range: bytes $start-$end/$size;" );
		}

		header( "Content-Length: " . $length );

		$buffer = 1024 * 8;
		while ( ! feof( $fp ) && ( $p = ftell( $fp ) ) <= $end ) {
			if ( $p + $buffer > $end ) {
				$buffer = $end - $p + 1;
			}

			set_time_limit( 0 );
			echo fread( $fp, $buffer );
			flush();
		}

		fclose( $fp );
	}
}
