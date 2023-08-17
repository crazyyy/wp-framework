<?php

/*
Name:    Dev4Press\v42\Core\Options\Settings
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

namespace Dev4Press\v42\Core\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Settings {
	protected $settings;

	public function __construct() {
		$this->init();
	}

	/** @return static */
	public static function instance() {
		static $instance = array();

		if ( ! isset( $instance[ static::class ] ) ) {
			$instance[ static::class ] = new static();
		}

		return $instance[ static::class ];
	}

	public function i( string $type, string $name, string $title, string $notice, string $input ) : Element {
		return Element::i( $type, $name, $title, $notice, $input, $this->value( $name, $type ) );
	}

	public function info( string $title, string $notice ) : Element {
		return Element::info( $title, $notice );
	}

	public function all() {
		return $this->settings;
	}

	public function get( $panel, $group = '' ) {
		if ( $group == '' ) {
			return $this->settings[ $panel ];
		} else {
			return $this->settings[ $panel ][ $group ];
		}
	}

	public function settings( $panel ) : array {
		$list = array();

		if ( in_array( $panel, array( 'index', 'full' ) ) ) {
			foreach ( $this->settings as $panel ) {
				foreach ( $panel as $obj ) {
					$list = array_merge( $list, $this->settings_from_panel( $obj ) );
				}
			}
		} else {
			foreach ( $this->settings[ $panel ] as $obj ) {
				$list = array_merge( $list, $this->settings_from_panel( $obj ) );
			}
		}

		return $list;
	}

	public function settings_from_panel( $obj ) : array {
		$list = array();

		if ( isset( $obj[ 'settings' ] ) ) {
			$obj[ 'sections' ] = array( 'label' => '', 'name' => '', 'class' => '', 'settings' => $obj[ 'settings' ] );
			unset( $obj[ 'settings' ] );
		}

		foreach ( $obj[ 'sections' ] as $s ) {
			foreach ( $s[ 'settings' ] as $o ) {
				if ( ! empty( $o->type ) ) {
					$list[] = $o;
				}
			}
		}

		return $list;
	}

	abstract protected function init();

	abstract protected function value( $name, $group = 'settings', $default = null );
}
