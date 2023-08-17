<?php

/*
Name:    Dev4Press\v42\Services\GEOIP\Location
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

namespace Dev4Press\v42\Service\GEOIP;

use Dev4Press\v42\Library;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Location {
	public $status = 'invalid';

	public $ip = '';
	public $country_code = '';
	public $country_name = '';
	public $region_code = '';
	public $region_name = '';
	public $city = '';
	public $zip_code = '';
	public $time_zone = '';
	public $latitude = '';
	public $longitude = '';

	public $continent_code = '';

	public function __construct( $input ) {
		foreach ( (array) $input as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

	public function location() : string {
		$location = '';

		if ( $this->status == 'active' && ! empty( $this->country_name ) ) {
			$location .= $this->country_name;

			if ( ! empty( $this->city ) ) {
				$location .= ', ' . $this->city;
			}
		}

		return $location;
	}

	public function flag( $not_found = 'image' ) : string {
		$_base = Library::instance()->url() . 'resources/libraries/flags/img/flag_placeholder.png';

		if ( $this->status == 'active' ) {
			if ( $this->country_code != '' ) {
				return '<img src="' . $_base . '" class="flag flag-' . strtolower( $this->country_code ) . '" title="' . $this->location() . '" alt="' . $this->location() . '" />';
			}
		} else if ( $this->status == 'private' ) {
			return '<img src="' . $_base . '" class="flag" title="' . __( "Localhost or Private IP", "d4plib" ) . '" alt="' . __( "Localhost or Private IP", "d4plib" ) . '" />';
		}

		if ( $not_found == 'image' ) {
			return '<img src="' . $_base . '" class="flag" title="' . __( "IP can't be located.", "d4plib" ) . '" alt="' . __( "IP can't be located.", "d4plib" ) . '" />';
		} else {
			return '';
		}
	}

	public function serialize() {
		return json_encode( (array) $this );
	}
}
