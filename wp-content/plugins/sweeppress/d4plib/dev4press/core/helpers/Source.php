<?php

/*
Name:    Dev4Press\v42\Core\Helpers\ObjectsSort
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

use Dev4Press\v42\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Source {
	private $paths = array();
	private $origins = array();

	public function __construct() {
		foreach (
			array(
				'plugin'      => WP_PLUGIN_DIR,
				'mu-plugin'   => WPMU_PLUGIN_DIR,
				'stylesheet'  => get_stylesheet_directory(),
				'template'    => get_template_directory(),
				'uploads'     => WordPress::instance()->uploads_directory(),
				'wp-content'  => WP_CONTENT_DIR,
				'wp-includes' => ABSPATH . 'wp-includes',
				'wp-admin'    => ABSPATH . 'wp-admin',
				'wp-core'     => ABSPATH,
				'unknown'     => null
			) as $key => $path
		) {
			if ( is_null( $path ) ) {
				continue;
			}

			$this->paths[ $key ] = wp_normalize_path( $path );
		}
	}

	public static function instance() : Source {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new Source();
		}

		return $instance;
	}

	public function origin( string $file, $strip_abspath = true ) : array {
		$file = wp_normalize_path( $file );

		if ( isset( $this->origins[ $file ] ) ) {
			return $this->origins[ $file ];
		}

		$scope = '';
		$value = '';

		foreach ( $this->paths as $scope => $dir ) {
			if ( $dir && ( strpos( $file, trailingslashit( $dir ) ) === 0 ) ) {
				break;
			}
		}

		switch ( $scope ) {
			case 'plugin':
			case 'mu-plugin':
				$plugin = plugin_basename( $file );

				if ( strpos( $plugin, '/' ) ) {
					$plugin = explode( '/', $plugin );
					$plugin = reset( $plugin );
				} else {
					$plugin = basename( $plugin );
				}

				$plugin = sanitize_file_name( $plugin );
				$value  = strtolower( $plugin );
				break;
			case 'stylesheet':
				$value = get_stylesheet();
				break;
			case 'template':
				$value = get_template();
				break;
		}

		$input = $file;

		if ( $strip_abspath ) {
			$abspath = wp_normalize_path( ABSPATH );

			if ( strpos( $file, $abspath ) === 0 ) {
				$input = '/' . substr( $file, strlen( $abspath ) );
			}
		}

		$result = array(
			'file'  => $input,
			'scope' => empty( $scope ) ? 'unknown' : $scope
		);

		if ( ! empty( $value ) ) {
			$result[ 'value' ] = $value;
		}

		$this->origins[ $file ] = $result;

		return $this->origins[ $file ];
	}
}
