<?php

/*
Name:    Dev4Press\v42\Core\Helpers\Errors
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

use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Error extends WP_Error {
	public function has_errors() : bool {
		return ! empty( $this->errors );
	}

	public function merge_errors( $errors ) {
		$this->errors = array_merge( $this->errors, $errors );
	}

	public function merge_errors_data( $error_data ) {
		$this->error_data = array_merge( $this->error_data, $error_data );
	}
}
