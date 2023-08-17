<?php

/*
Name:    Dev4Press\v42\Core\Cache\Store
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

class Store {
	protected $global_groups = array();

	private $cache = array();

	private $blog_prefix;
	private $multisite;

	public $cache_hits = 0;
	public $cache_misses = 0;

	public function __construct() {
		$this->multisite   = is_multisite();
		$this->blog_prefix = $this->multisite ? get_current_blog_id() . ':' : '';
	}

	public static function instance() : Store {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new Store();
		}

		return $instance;
	}

	protected function _exists( $key, $group ) : bool {
		return isset( $this->cache[ $group ] ) && ( isset( $this->cache[ $group ][ $key ] ) || array_key_exists( $key, $this->cache[ $group ] ) );
	}

	private function _group( $group = '' ) : string {
		if ( empty( $group ) ) {
			$group = 'default';
		}

		return $group;
	}

	private function _key( $key, $group ) : string {
		if ( $this->multisite && ! isset( $this->global_groups[ $group ] ) ) {
			$key = $this->blog_prefix . $key;
		}

		return $key;
	}

	public function add_global_groups( $groups ) {
		$groups = (array) $groups;

		$groups              = array_fill_keys( $groups, true );
		$this->global_groups = array_merge( $this->global_groups, $groups );
	}

	public function add( $key, $data, $group = 'default' ) : bool {
		$original_key = $key;

		$group = $this->_group( $group );
		$key   = $this->_key( $key, $group );

		if ( $this->_exists( $key, $group ) ) {
			return false;
		}

		return $this->set( $original_key, $data, $group );
	}

	public function delete( $key, $group = 'default' ) : bool {
		$group = $this->_group( $group );
		$key   = $this->_key( $key, $group );

		if ( ! $this->_exists( $key, $group ) ) {
			return false;
		}

		unset( $this->cache[ $group ][ $key ] );

		return true;
	}

	public function get( $key, $group = 'default', $force = false, &$found = null ) {
		$group = $this->_group( $group );
		$key   = $this->_key( $key, $group );

		if ( $this->_exists( $key, $group ) ) {
			$found = true;
			$this->cache_hits ++;

			if ( is_object( $this->cache[ $group ][ $key ] ) ) {
				return clone $this->cache[ $group ][ $key ];
			} else {
				return $this->cache[ $group ][ $key ];
			}
		}

		$found = false;
		$this->cache_misses ++;

		return $force;
	}

	public function replace( $key, $data, $group = 'default' ) : bool {
		$group = $this->_group( $group );
		$key   = $this->_key( $key, $group );

		if ( ! $this->_exists( $key, $group ) ) {
			return false;
		}

		return $this->set( $key, $data, $group );
	}

	public function set( $key, $data, $group = 'default' ) : bool {
		$group = $this->_group( $group );
		$key   = $this->_key( $key, $group );

		if ( is_object( $data ) ) {
			$data = clone $data;
		}

		$this->cache[ $group ][ $key ] = $data;

		return true;
	}

	public function in( $key, $group = 'default' ) : bool {
		$group = $this->_group( $group );
		$key   = $this->_key( $key, $group );

		return $this->_exists( $key, $group );
	}

	public function flush( $group = null ) : bool {
		if ( is_null( $group ) ) {
			$this->cache = array();
		} else {
			$group                 = $this->_group( $group );
			$this->cache[ $group ] = array();
		}

		return true;
	}

	public function get_group( $group ) : array {
		if ( isset( $this->cache[ $group ] ) ) {
			return $this->cache[ $group ];
		}

		return array();
	}

	public function stats() {
		echo "<p>";
		echo "<strong>Cache Hits:</strong> " . esc_html( $this->cache_hits ) . "<br />";
		echo "<strong>Cache Misses:</strong> " . esc_html( $this->cache_misses ) . "<br />";
		echo "</p>";
		echo "<ul>";
		foreach ( $this->cache as $group => $cache ) {
			echo "<li><strong>Group:</strong> $group - ( " . number_format( strlen( serialize( $cache ) ) / KB_IN_BYTES, 2 ) . 'k )</li>';
		}
		echo "</ul>";
	}

	public function switch_to_blog( $blog_id ) {
		$blog_id           = (int) $blog_id;
		$this->blog_prefix = $this->multisite ? $blog_id . ':' : '';
	}

	public function cache() : array {
		return $this->cache;
	}
}
