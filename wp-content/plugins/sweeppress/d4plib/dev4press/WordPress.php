<?php

/*
Name:    Dev4Press\v42\WordPress
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

namespace Dev4Press\v42;

use Dev4Press\v42\Core\Quick\WPR;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @method bool is_admin()
 * @method bool is_cli()
 * @method bool is_ajax()
 * @method bool is_cron()
 * @method bool is_rest()
 * @method bool is_debug()
 * @method bool is_script_debug()
 * @method bool is_async_upload()
 * @method bool is_wordpress()
 * @method bool is_classicpress()
 */
class WordPress {
	private $_versions;
	private $_switches;

	public function __construct() {
		global $wp_version;

		$this->_versions = array(
			'wp' => $wp_version
		);

		$this->_switches = array(
			'wordpress'    => true,
			'classicpress' => false,
			'rest'         => false,
			'context'      => false,
			'cli'          => defined( 'WP_CLI' ) && defined( 'WP_CLI_VERSION' ) && defined( 'WP_CLI_START_MICROTIME' ) && WP_CLI,
			'admin'        => defined( 'WP_ADMIN' ) && WP_ADMIN,
			'ajax'         => defined( 'DOING_AJAX' ) && DOING_AJAX,
			'cron'         => defined( 'DOING_CRON' ) && DOING_CRON,
			'debug'        => defined( 'WP_DEBUG' ) && WP_DEBUG,
			'script_debug' => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG,
			'async_upload' => defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST[ 'action' ] ) && 'upload-attachment' === $_REQUEST[ 'action' ]
		);

		if ( WPR::is_classicpress() ) {
			$this->_switches[ 'wordpress' ]    = false;
			$this->_switches[ 'classicpress' ] = true;
			$this->_versions[ 'cp' ]           = function_exists( 'classicpress_version' ) ? classicpress_version() : '1.0';
		}

		$this->_versions[ 'cms' ] = $this->_versions[ 'cp' ] ?? $this->_versions[ 'wp' ];

		add_action( 'rest_api_init', array( $this, 'rest_api' ) );
	}

	public function __call( $name, $arguments ) {
		if ( substr( $name, 0, 3 ) === 'is_' ) {
			$switch = substr( $name, 3 );

			if ( isset( $this->_switches[ $switch ] ) ) {
				return $this->_switches[ $switch ];
			}
		}

		return false;
	}

	public static function instance() : WordPress {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new WordPress();
		}

		return $instance;
	}

	public function cms() : string {
		return $this->is_classicpress() ? 'classicpress' : 'wordpress';
	}

	public function cms_title() : string {
		return $this->is_classicpress() ? 'ClassicPress' : 'WordPress';
	}

	public function uploads_directory() {
		$uploads = wp_upload_dir();

		return $uploads[ 'basedir' ];
	}

	public function major_version( $key = 'cms' ) : string {
		$version = $this->version( $key );

		return substr( $version, 0, 3 );
	}

	public function version( $key = 'cms' ) : string {
		return $this->_versions[ $key ] ?? '0.0.0';
	}

	public function is_version_equal_or_higher( string $version = '', string $key = 'cms' ) : bool {
		return version_compare( $this->version( $key ), $version, '>=' );
	}

	public function is_version_lower( string $version = '', string $key = 'cms' ) : bool {
		return version_compare( $this->version( $key ), $version, '<' );
	}

	public function rest_api() {
		$this->_switches[ 'rest' ] = defined( 'REST_REQUEST' ) && REST_REQUEST;
	}

	public function context() : string {
		if ( $this->_switches[ 'context' ] === false ) {
			if ( $this->_switches[ 'cli' ] ) {
				$this->_switches[ 'context' ] = 'CLI';
			} else if ( $this->_switches[ 'cron' ] ) {
				$this->_switches[ 'context' ] = 'CRON';
			} else if ( $this->_switches[ 'ajax' ] ) {
				$this->_switches[ 'context' ] = 'AJAX';
			} else if ( $this->_switches[ 'rest' ] ) {
				$this->_switches[ 'context' ] = 'REST';
			} else {
				$this->_switches[ 'context' ] = '';
			}
		}

		return $this->_switches[ 'context' ];
	}
}
