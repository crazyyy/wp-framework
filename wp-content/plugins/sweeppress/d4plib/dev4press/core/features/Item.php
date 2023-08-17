<?php

/*
Name:    Dev4Press\v42\Core\Features\Item
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

namespace Dev4Press\v42\Core\Features;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @method bool is_active()
 * @method bool is_enabled()
 * @method bool is_early()
 * @method bool is_always_on()
 * @method bool has_settings()
 * @method bool has_menu()
 * @method bool has_meta_tab()
 * @method string get_scope()
 * @property string $feature_name
 */
abstract class Item {
	public $name = '';
	public $settings = array();

	public function __construct() {
		if ( $this->has_settings() ) {
			$this->settings = $this->f()->s()->feature_get( $this->name );
		}
	}

	/** @return static */
	public static function instance() {
		static $instance = array();

		if ( ! isset( $instance[ static::class ] ) ) {
			$instance[ static::class ] = new static();
		}

		return $instance[ static::class ];
	}

	abstract public function f();

	public function __call( $name, $arguments ) {
		return $this->f()->attribute( $name, $this->name );
	}

	public function __get( $name ) {
		return $name == 'feature_name' ? $this->name : ( $this->settings[ $name ] ?? '' );
	}

	public function get( $name, $default = '' ) {
		return $this->settings[ $name ] ?? $default;
	}
}
