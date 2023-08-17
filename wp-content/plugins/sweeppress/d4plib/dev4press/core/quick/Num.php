<?php

/*
Name:    Dev4Press\v42\Core\Quick\Num
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

class Num {
	public static function is_odd( $number ) : bool {
		return $number % 2 == 0;
	}

	public static function is_divisible( $number, $by_number ) : bool {
		return $number % $by_number == 0;
	}
}
