<?php

/*
Name:    Dev4Press\v42\Core\Cache\UserTransient
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

namespace Dev4Press\v42\Core\Cache;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UserTransient {
	public function __construct() {
	}

	public static function instance() : UserTransient {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new UserTransient();
		}

		return $instance;
	}

	public function delete( $user_id, $transient ) {
		$transient_option  = '_transient_' . $transient;
		$transient_timeout = '_transient_timeout_' . $transient;

		delete_user_meta( $user_id, $transient_option );
		delete_user_meta( $user_id, $transient_timeout );
	}

	public function get( $user_id, $transient ) {
		$transient_option  = '_transient_' . $transient;
		$transient_timeout = '_transient_timeout_' . $transient;

		if ( get_user_meta( $user_id, $transient_timeout, true ) < time() ) {
			delete_user_meta( $user_id, $transient_option );
			delete_user_meta( $user_id, $transient_timeout );

			return false;
		}

		return get_user_meta( $user_id, $transient_option, true );
	}

	public function set( $user_id, $transient, $value, $expiration = 86400 ) {
		$transient_option  = '_transient_' . $transient;
		$transient_timeout = '_transient_timeout_' . $transient;

		if ( get_user_meta( $user_id, $transient_option, true ) != '' ) {
			delete_user_meta( $user_id, $transient_option );
			delete_user_meta( $user_id, $transient_timeout );
		}

		add_user_meta( $user_id, $transient_timeout, time() + $expiration, true );
		add_user_meta( $user_id, $transient_option, $value, true );
	}
}
