<?php

/*
Name:    Dev4Press\v42\Services\GEOIP\Locator
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

class GEOJSIO extends Locator {
	private $_location_convert = array(
		'ip'             => 'ip',
		'continent_code' => 'continent_code',
		'country_code'   => 'country_code',
		'country'        => 'country_name',
		'region'         => 'region_name',
		'city'           => 'city',
		'latitude'       => 'latitude',
		'longitude'      => 'longitude',
		'timezone'       => 'time_zone'
	);

	protected $_multi_ip_call = true;
	protected $_url = 'https://get.geojs.io/v1/ip/geo.json?ip=';

	protected function url( $ips ) : string {
		$ips = (array) $ips;

		return $this->_url . join( ',', $ips );
	}

	protected function process( $raw ) : Location {
		$code = array(
			'status' => 'active'
		);

		foreach ( $raw as $key => $value ) {
			if ( isset( $this->_location_convert[ $key ] ) ) {
				$code[ $this->_location_convert[ $key ] ] = $value;
			}
		}

		return new Location( $code );
	}
}
