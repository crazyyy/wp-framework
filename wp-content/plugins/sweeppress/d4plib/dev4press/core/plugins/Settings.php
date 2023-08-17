<?php

/*
Name:    Dev4Press\v42\Core\Plugins\Settings
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

namespace Dev4Press\v42\Core\Plugins;

use Dev4Press\v42\Core\DateTime;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Settings {
	public $base = 'd4p';

	public $info;
	public $scope = 'blog';
	public $has_db = false;

	public $current = array();
	public $settings = array();
	public $legacy = array();
	public $temp = array();
	public $changed = array();

	public $skip_update = array();

	public function __construct() {
		$this->constructor();
	}

	/** @return static */
	public static function instance() {
		static $instance = array();

		if ( ! isset( $instance[ static::class ] ) ) {
			$instance[ static::class ] = new static();
		}

		return $instance[ static::class ];
	}

	/** @return Information */
	public function i() {
		return $this->info;
	}

	public function __get( $name ) {
		$get = explode( '_', $name, 2 );

		return $this->get( $get[ 1 ], $get[ 0 ] );
	}

	public function init() {
		$this->current[ 'info' ] = $this->_settings_get( 'info' );

		do_action( $this->base . '_settings_init' );
		do_action( $this->base . '_' . $this->scope . '_settings_init' );

		$installed = is_array( $this->current[ 'info' ] ) && isset( $this->current[ 'info' ][ 'build' ] );

		if ( ! $installed ) {
			$this->_install();
		} else {
			$update = $this->current[ 'info' ][ 'build' ] != $this->info->build;

			if ( $update ) {
				$this->_update();
			} else {
				$groups = $this->_groups();

				foreach ( $groups as $key ) {
					$this->current[ $key ] = $this->_settings_get( $key );

					if ( ! is_array( $this->current[ $key ] ) ) {
						$data = $this->group( $key );

						if ( ! is_null( $data ) ) {
							$this->current[ $key ] = $data;

							$this->_settings_update( $key, $data );
						}
					}
				}
			}
		}

		do_action( $this->base . '_' . $this->scope . '_settings_loaded' );
		do_action( $this->base . '_settings_loaded' );
	}

	public function group( $group ) {
		return $this->settings[ $group ] ?? null;
	}

	public function exists( $name, $group = 'settings' ) : bool {
		if ( isset( $this->current[ $group ][ $name ] ) ) {
			return true;
		} else if ( isset( $this->settings[ $group ][ $name ] ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function storage_get( $name, $get_defaults = false ) : array {
		return $this->prefix_get( $name . '__', 'storage', $get_defaults );
	}

	public function feature_get( $name, $get_defaults = false ) : array {
		return $this->prefix_get( $name . '__', 'features', $get_defaults );
	}

	public function prefix_get( $prefix, $group = 'settings', $get_defaults = false ) : array {
		$settings = array_merge( array_keys( $this->settings[ $group ] ), array_keys( $this->current[ $group ] ) );

		$results = array();

		foreach ( $settings as $key ) {
			if ( substr( $key, 0, strlen( $prefix ) ) == $prefix ) {
				$new = substr( $key, strlen( $prefix ) );

				$results[ $new ] = $get_defaults ? $this->get_default( $key, $group ) : $this->get( $key, $group );
			}
		}

		return $results;
	}

	public function group_get( $group, $get_defaults = false ) {
		if ( $get_defaults ) {
			return $this->settings[ $group ];
		}

		$default = $this->settings[ $group ];
		$current = $this->current[ $group ];

		return wp_parse_args( $current, $default );
	}

	public function register_group( $group ) {
		$this->settings[ $group ] = array();
	}

	public function register( $group, $name, $value ) {
		$this->settings[ $group ][ $name ] = $value;
	}

	public function get_default( $name, $group = 'settings', $default = null ) {
		return $this->settings[ $group ][ $name ] ?? $default;
	}

	public function raw_get( $name, $group = 'settings', $default = null ) {
		return $this->current[ $group ][ $name ] ?? ( $this->settings[ $group ][ $name ] ?? $default );
	}

	public function get( $name, $group = 'settings', $default = null ) {
		return apply_filters( $this->base . '_' . $this->scope . '_settings_get', $this->raw_get( $name, $group, $default ), $name, $group );
	}

	public function set( $name, $value, $group = 'settings', $save = false ) {
		$old = $this->current[ $group ][ $name ] ?? null;

		$this->current[ $group ][ $name ] = $value;

		if ( $old != $value ) {
			do_action( $this->base . '_settings_value_changed', $name, $group, $old, $value );

			if ( ! isset( $this->changed[ $group ] ) ) {
				$this->changed[ $group ] = array();
			}

			$this->changed[ $group ][ $name ] = array( 'old' => $old, 'new' => $value );
		}

		if ( $save ) {
			$this->save( $group );
		}
	}

	public function save( $group ) {
		$this->_settings_update( $group, $this->current[ $group ] );

		do_action( $this->base . '_settings_saved_to_db', $this->changed[ $group ] ?? array() );
	}

	public function is_install() : bool {
		return (bool) $this->get( 'install', 'info' );
	}

	public function is_update() : bool {
		return (bool) $this->get( 'update', 'info' );
	}

	public function mark_for_update() {
		$this->current[ 'info' ][ 'update' ] = true;

		$this->save( 'info' );
	}

	public function remove_by_prefix( $prefix, $group, $save = true ) {
		$keys = array_keys( $this->current[ $group ] );

		foreach ( $keys as $key ) {
			if ( substr( $key, 0, strlen( $prefix ) ) == $prefix ) {
				unset( $this->current[ $group ][ $key ] );
			}
		}

		if ( $save ) {
			$this->save( $group );
		}
	}

	public function remove_plugin_settings() {
		$this->_settings_delete( 'info' );

		foreach ( $this->_groups() as $group ) {
			$this->_settings_delete( $group );
		}
	}

	public function remove_plugin_settings_by_group( $group ) {
		$this->_settings_delete( $group );
	}

	public function import_from_object( $import, $list = array() ) {
		if ( empty( $list ) ) {
			$list = $this->_groups();
		}

		$import = (array) $import;

		foreach ( $import as $key => $data ) {
			if ( in_array( $key, $list ) ) {
				$this->current[ $key ] = (array) $data;

				$this->save( $key );
			}
		}
	}

	public function import_from_secure_json( $import ) : bool {
		$name = $import[ 'name' ] ?? false;
		$ctrl = $import[ 'ctrl' ] ?? false;
		$raw  = $import[ 'data' ] ?? false;

		$data = gzuncompress( base64_decode( urldecode( $raw ) ) );

		if ( $ctrl && $data && strlen( $ctrl ) == 64 ) {
			$ctrl        = substr( $ctrl, 8, 32 );
			$size_import = mb_strlen( $data );
			$ctrl_import = $name === false ? md5( $data . $size_import ) : md5( $data . $this->i()->code . $size_import );

			if ( $ctrl_import === $ctrl ) {
				$data = json_decode( $data, true );
				$this->import_from_object( $data );

				return true;
			}
		}

		return false;
	}

	public function export_to_json( $list = array() ) {
		return json_encode( $this->_settings_to_array( $list ) );
	}

	public function export_to_secure_json( $list = array() ) {
		$export = $this->_settings_to_array( $list );

		$encoded = json_encode( $export );

		if ( $encoded === false ) {
			return false;
		}

		$size = mb_strlen( $encoded );
		$name = $this->i()->code;

		$export = array(
			'name' => $name,
			'ctrl' => strtolower( wp_generate_password( 8, false ) ) . md5( $encoded . $name . $size ) . strtolower( wp_generate_password( 24, false ) ),
			'data' => urlencode( base64_encode( gzcompress( $encoded, 9 ) ) )
		);

		return json_encode( $export, JSON_PRETTY_PRINT );
	}

	public function file_version() : string {
		return $this->i()->version . '.' . $this->i()->build;
	}

	public function plugin_version() : string {
		return 'v' . $this->i()->version . '_b' . $this->i()->build;
	}

	public function reset_feature( $name ) : bool {
		$defaults = $this->feature_get( $name, true );

		if ( ! empty( $defaults ) ) {
			foreach ( $defaults as $key => $value ) {
				$this->set( $name . '__' . $key, $value, 'features' );
			}

			$this->save( 'features' );

			return true;
		}

		return false;
	}

	public function get_installed_db_version() {
		return $this->current[ 'core' ][ 'db_version' ] ?? 0;
	}

	public function updated_db_version( $version ) {
		$this->set( 'db_version', $version, 'core', true );
	}

	protected function _name( $name ) : string {
		return 'd4p_' . $this->scope . '_' . $this->info->code . '_' . $name;
	}

	protected function _install() {
		$this->current = $this->_merge();

		$this->current[ 'info' ] = $this->info->to_array();

		$this->current[ 'info' ][ 'install' ] = true;
		$this->current[ 'info' ][ 'update' ]  = false;

		if ( isset( $this->current[ 'core' ] ) ) {
			$this->current[ 'core' ][ 'installed' ] = DateTime::instance()->mysql_date();
		}

		foreach ( $this->current as $key => $data ) {
			$this->_settings_update( $key, $data );
		}

		if ( $this->has_db ) {
			$this->_db();
		}
	}

	protected function _update() {
		$old_build = $this->current[ 'info' ][ 'build' ];

		$this->current[ 'info' ] = $this->info->to_array();

		$this->current[ 'info' ][ 'install' ]  = false;
		$this->current[ 'info' ][ 'update' ]   = true;
		$this->current[ 'info' ][ 'previous' ] = $old_build;

		$this->_settings_update( 'info', $this->current[ 'info' ] );

		$settings = $this->_merge();

		foreach ( $this->legacy as $key ) {
			$settings[ $key ] = array();
		}

		foreach ( $settings as $key => $data ) {
			$now = $this->_settings_get( $key );

			if ( $now !== false && is_array( $now ) ) {
				$this->temp[ $key ] = $now;
			}

			if ( ! in_array( $key, $this->legacy ) ) {
				if ( ! is_array( $now ) ) {
					$now = $data;
				} else if ( ! in_array( $key, $this->skip_update ) ) {
					$now = $this->_upgrade( $now, $data );
				}

				$this->current[ $key ] = $now;

				if ( $key == 'core' ) {
					$this->current[ 'core' ][ 'updated' ] = DateTime::instance()->mysql_date();
				}

				$this->_settings_update( $key, $now );
			} else {
				$this->_settings_delete( $key );
			}
		}

		if ( $this->has_db ) {
			$this->_db();
		}

		$this->_migrate();
	}

	protected function _db() {
		$installed_version = $this->get_installed_db_version();
		$current_version   = $this->_install_db()->current_version();

		if ( $current_version > $installed_version ) {
			$this->_install_db()->install();

			$this->updated_db_version( $current_version );
		}
	}

	protected function _install_db() {
	}

	protected function _migrate() {
	}

	protected function _upgrade( $old, $new ) {
		foreach ( $new as $key => $value ) {
			if ( ! array_key_exists( $key, $old ) ) {
				$old[ $key ] = $value;
			}
		}

		$unset = array();
		foreach ( $old as $key => $value ) {
			if ( ! array_key_exists( $key, $new ) ) {
				$unset[] = $key;
			}
		}

		if ( ! empty( $unset ) ) {
			foreach ( $unset as $key ) {
				unset( $old[ $key ] );
			}
		}

		return $old;
	}

	protected function _groups() : array {
		return array_keys( $this->settings );
	}

	protected function _merge() : array {
		return $this->settings;
	}

	protected function _settings_get( $name ) {
		if ( $this->scope == 'network' ) {
			return get_site_option( $this->_name( $name ) );
		} else {
			return get_option( $this->_name( $name ) );
		}
	}

	protected function _settings_delete( $name ) {
		if ( $this->scope == 'network' ) {
			delete_site_option( $this->_name( $name ) );
		} else {
			delete_option( $this->_name( $name ) );
		}
	}

	protected function _settings_update( $name, $data ) {
		if ( $this->scope == 'network' ) {
			update_site_option( $this->_name( $name ), $data );
		} else {
			update_option( $this->_name( $name ), $data );
		}
	}

	protected function _settings_to_array( $list = array() ) : array {
		if ( empty( $list ) ) {
			$list = $this->_groups();
		}

		$data = array(
			'info' => $this->current[ 'info' ]
		);

		foreach ( $list as $name ) {
			$data[ $name ] = $this->current[ $name ];
		}

		return $data;
	}

	abstract protected function constructor();
}
