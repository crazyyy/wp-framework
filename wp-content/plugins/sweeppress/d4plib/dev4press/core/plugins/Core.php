<?php

/*
Name:    Dev4Press\v42\Core\Plugins\Core
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

use Dev4Press\v42\API\Four;
use Dev4Press\v42\Core\DateTime;
use Dev4Press\v42\Core\Quick\BBP;
use Dev4Press\v42\Library;
use Dev4Press\v42\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Core {
	public $is_debug = false;

	public $widgets = false;
	public $enqueue = false;
	public $features = false;

	public $cap = 'activate_plugins';
	public $svg_icon = '';
	public $plugin = '';
	public $url = '';

	private $_datetime;
	private $_system_requirements = array();
	private $_widget_instance = array();

	public function __construct() {
		$this->_datetime = new DateTime();

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
	}

	/** @return static */
	public static function instance() {
		static $instance = array();

		if ( ! isset( $instance[ static::class ] ) ) {
			$instance[ static::class ] = new static();
		}

		return $instance[ static::class ];
	}

	public function datetime() : DateTime {
		return $this->_datetime;
	}

	public function plugins_loaded() {
		$this->is_debug = WordPress::instance()->is_script_debug();

		if ( $this->widgets === true || ! empty( $this->widgets ) ) {
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		}

		if ( $this->enqueue ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		$this->load_textdomain();

		$this->_system_requirements = $this->check_system_requirements();

		if ( ! empty( $this->_system_requirements ) ) {
			if ( is_admin() ) {
				add_action( 'admin_notices', array( $this, 'system_requirements_notices' ) );
			} else {
				$this->deactivate();
			}
		} else {
			$this->init_capabilities();
			$this->run();
		}
	}

	public function load_textdomain() {
		load_plugin_textdomain( $this->plugin, false, $this->plugin . '/languages' );
		load_plugin_textdomain( 'd4plib', false, $this->plugin . '/d4plib/languages' );
	}

	public function init_capabilities() {
		$role = get_role( 'administrator' );

		if ( ! is_null( $role ) ) {
			$role->add_cap( $this->cap );
		} else {
			$this->cap = 'activate_plugins';
		}
	}

	public function plugin_name() : string {
		return $this->plugin . '/' . $this->plugin . '.php';
	}

	public function deactivate() {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins( $this->plugin_name() );
	}

	public function recommend( $panel = 'update' ) : string {
		$four = Four::instance( 'plugin', $this->plugin, $this->s()->i()->version, $this->s()->i()->build );
		$four->ad();

		return $four->ad_render( $panel );
	}

	public function after_setup_theme() {
	}

	public function widgets_init() {
	}

	public function enqueue_scripts() {
	}

	public function system_requirements_notices() {
		$plugin   = $this->s()->i()->name();
		$versions = array();

		foreach ( $this->_system_requirements as $req ) {
			if ( $req[ 1 ] == 0 ) {
				$versions[] = sprintf( _x( "%s version %s (%s is not active on your website)", "System requirement version", "d4plib" ), $req[ 0 ], '<strong>' . $req[ 2 ] . '</strong>', '<strong style="color: #900;">' . $req[ 0 ] . '</strong>' );
			} else {
				$versions[] = sprintf( _x( "%s version %s (your system runs version %s)", "System requirement version", "d4plib" ), $req[ 0 ], '<strong>' . $req[ 2 ] . '</strong>', '<strong style="color: #900;">' . $req[ 1 ] . '</strong>' );
			}
		}

		$render = '<div class="notice notice-error"><p>';
		$render .= sprintf( _x( "System requirements check for %s failed. This plugin requires %s. The plugin will now be disabled.", "System requirement notice", "d4plib" ), '<strong>' . $plugin . '</strong>', join( ', ', $versions ) );
		$render .= '</p></div>';

		echo $render;

		$this->deactivate();
	}

	public function store_widget_instance( $instance ) {
		$this->_widget_instance = (array) $instance;
	}

	public function widget_instance() : array {
		return $this->_widget_instance;
	}

	protected function check_system_requirements() : array {
		if ( defined( 'DEV4PRESS_NO_SYSREQ_CHECK' ) && DEV4PRESS_NO_SYSREQ_CHECK ) {
			return array();
		}

		global $wpdb;

		$list = array();

		$cms = $this->s()->i()->requirement_version( WordPress::instance()->cms() );

		if ( WordPress::instance()->is_version_equal_or_higher( $cms ) === false ) {
			$list[] = array( WordPress::instance()->cms_title(), WordPress::instance()->version(), $cms );
		}

		$php = $this->s()->i()->requirement_version( 'php' );

		if ( version_compare( Library::instance()->php_version(), $php, '>=' ) === false ) {
			$list[] = array( 'PHP', Library::instance()->php_version(), $php );
		}

		$mysql = $this->s()->i()->requirement_version( 'mysql' );

		if ( version_compare( $wpdb->db_version(), $mysql, '>=' ) === false ) {
			$list[] = array( 'MySQL', $wpdb->db_version(), $mysql );
		}

		$bbpress = $this->s()->i()->requirement_version( 'bbpress' );

		if ( $bbpress !== false ) {
			if ( BBP::is_active() ) {
				$installed = bbp_get_version();

				if ( version_compare( $installed, $bbpress, '>=' ) === false ) {
					$list[] = array( 'bbPress', $installed, $bbpress );
				}
			} else {
				$list[] = array( 'bbPress', 0, $bbpress );
			}
		}

		return $list;
	}

	abstract public function run();

	/** @return \Dev4Press\v42\Core\Plugins\Settings */
	abstract public function s();

	/** @return NULL|\Dev4Press\v42\Core\Features\Load */
	abstract public function f();
}
