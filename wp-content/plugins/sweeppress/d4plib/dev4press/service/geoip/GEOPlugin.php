<?php

/*
Name:    Dev4Press\v42\Services\GEOIP\GEOPlugin
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GEOPlugin extends Locator {
	private $_location_convert = array(
		'ip'            => 'ip',
		'countryCode'   => 'country_code',
		'countryName'   => 'country_name',
		'regionCode'    => 'region_code',
		'regionName'    => 'region_name',
		'city'          => 'city',
		'latitude'      => 'latitude',
		'longitude'     => 'longitude',
		'continentCode' => 'continent_code'
	);

	protected $_url = 'http://www.geoplugin.net/json.gp?ip=';

	protected function url( $ips ) : string {
		return $this->_url . $ips;
	}

	protected function process( $raw ) : Location {
		$code = array(
			'status' => 'active'
		);

		foreach ( $raw as $key => $value ) {
			$ck = substr( $key, 10 );

			if ( isset( $this->_location_convert[ $ck ] ) ) {
				$code[ $this->_location_convert[ $ck ] ] = $value;
			}
		}

		return new Location( $code );
	}
}
