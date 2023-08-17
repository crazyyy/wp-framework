<?php

/*
Name:    Dev4Press\v42\Core\Plugins\DB
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

use stdClass;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class DB extends DBLite {
	public $db_site = array();
	public $db;

	public $_prefix = '';
	public $_tables = array();
	public $_network_tables = array();
	public $_metas = array();

	protected $_meta_translate = array();

	public function __construct() {
		parent::__construct();

		if ( ! empty( $this->_tables ) ) {
			$this->init();

			add_action( 'switch_blog', array( $this, 'init' ) );
		}
	}

	/** @global \wpdb $wpdb */
	public function init() {
		global $wpdb;

		$plugin        = new stdClass();
		$this->db      = new stdClass();
		$this->db_site = array();

		foreach ( $this->_tables as $name ) {
			$prefix = in_array( $name, $this->_network_tables ) ? $wpdb->base_prefix : $wpdb->prefix;

			$wpdb_name = $this->_prefix . '_' . $name;
			$real_name = $prefix . $wpdb_name;

			$plugin->$name   = $real_name;
			$this->db->$name = $real_name;

			$wpdb->$wpdb_name = $real_name;

			if ( ! in_array( $name, $this->_network_tables ) ) {
				$this->db_site[] = $real_name;
			}
		}

		$wpdb->{$this->_prefix} = $plugin;

		if ( ! empty( $this->_prefix ) && ! empty( $this->_metas ) ) {
			foreach ( $this->_metas as $key => $id ) {
				$this->_meta_translate[ $this->_prefix . '_' . $key . '_id' ] = $id;
			}

			add_filter( 'sanitize_key', array( $this, 'sanitize_meta' ) );
		}
	}

	public function __get( $name ) {
		if ( isset( $this->db->$name ) ) {
			return $this->db->$name;
		} else if ( property_exists( $this->wpdb(), $name ) || isset( $this->wpdb()->$name ) ) {
			return $this->wpdb()->$name;
		}

		return false;
	}

	public function sanitize_meta( $key ) {
		if ( isset( $this->_meta_translate[ $key ] ) ) {
			return $this->_meta_translate[ $key ];
		}

		return $key;
	}

	public function update_meta( $meta_type, $object_id, $meta_key, $meta_value, $prev_value = '' ) {
		return update_metadata( $this->_prefix . '_' . $meta_type, $object_id, $meta_key, $meta_value, $prev_value );
	}

	public function add_meta( $meta_type, $object_id, $meta_key, $meta_value, $unique = false ) {
		return add_metadata( $this->_prefix . '_' . $meta_type, $object_id, $meta_key, $meta_value, $unique );
	}

	public function get_meta( $meta_type, $object_id, $meta_key, $single = false ) {
		return get_metadata( $this->_prefix . '_' . $meta_type, $object_id, $meta_key, $single );
	}

	public function delete_meta( $meta_type, $object_id, $meta_key, $delete_all = false ) : bool {
		return delete_metadata( $this->_prefix . '_' . $meta_type, $object_id, $meta_key, $delete_all );
	}
}
