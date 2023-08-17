<?php

/*
Name:    Dev4Press\v42\Core\DateTime
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

namespace Dev4Press\v42\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DateTime {
	protected $_mysql_format = 'Y-m-d H:i:s';

	public function __construct() {
	}

	public static function instance() : DateTime {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new DateTime();
		}

		return $instance;
	}

	public function offset() {
		$offset = get_option( 'gmt_offset' );

		if ( empty( $offset ) ) {
			$offset = wp_timezone_override_offset();
		}

		return $offset === false ? 0 : $offset;
	}

	public function formatted_offset( $offset = null ) : string {
		if ( is_null( $offset ) ) {
			$offset = $this->offset();
		}

		$hours   = intval( $offset );
		$minutes = absint( ( $offset - floor( $offset ) ) * 60 );

		return sprintf( '%+03d:%02d', $hours, $minutes );
	}

	public function timestamp_local_to_gmt( $local ) {
		return $local - $this->offset() * HOUR_IN_SECONDS;
	}

	public function timestamp_gmt_to_local( $gmt ) {
		return $gmt + $this->offset() * HOUR_IN_SECONDS;
	}

	public function timestamp( $gmt = true ) {
		return $gmt ? time() : $this->timestamp_gmt_to_local( time() );
	}

	public function date( $format, $gmt = true ) {
		return $gmt ? gmdate( $format ) : gmdate( $format, $this->timestamp_gmt_to_local( time() ) );
	}

	public function mysql_format() : string {
		return $this->_mysql_format;
	}

	public function mysql_date( $gmt = true ) {
		return $this->date( $this->mysql_format(), $gmt );
	}
}
