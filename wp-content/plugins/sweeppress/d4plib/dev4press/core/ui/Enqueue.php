<?php

/*
Name:    Dev4Press\v42\Core\UI\Enqueue
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

namespace Dev4Press\v42\Core\UI;

use Dev4Press\v42\Core\Shared\Resources;
use Dev4Press\v42\Library;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Enqueue {
	private $_version;
	private $_enqueue_prefix = 'd4plib3-';
	private $_library = 'd4plib';
	private $_debug;
	private $_url;
	private $_rtl = false;

	/** @var \Dev4Press\v42\Core\Admin\Plugin|\Dev4Press\v42\Core\Admin\Menu\Plugin|\Dev4Press\v42\Core\Admin\Submenu\Plugin */
	private $_admin;

	private $_loaded = array(
		'js'  => array(),
		'css' => array()
	);
	private $_libraries = array(
		'js'  => array(),
		'css' => array()
	);

	/**
	 * @param $admin \Dev4Press\v42\Core\Admin\Plugin|\Dev4Press\v42\Core\Admin\Menu\Plugin|\Dev4Press\v42\Core\Admin\Submenu\Plugin
	 */
	public function __construct( $admin ) {
		$this->_libraries[ 'js' ]  = Resources::instance()->ui_js() + Resources::instance()->shared_js();
		$this->_libraries[ 'css' ] = Resources::instance()->ui_css() + Resources::instance()->shared_css();

		$this->_url     = $admin->url;
		$this->_admin   = $admin;
		$this->_version = Library::instance()->version();

		add_action( 'admin_init', array( $this, 'start' ), 15 );
	}

	/**
	 * @param $admin \Dev4Press\v42\Core\Admin\Plugin|\Dev4Press\v42\Core\Admin\Menu\Plugin|\Dev4Press\v42\Core\Admin\Submenu\Plugin
	 *
	 * @return \Dev4Press\v42\Core\UI\Enqueue
	 */
	public static function instance( $admin ) : Enqueue {
		static $_d4p_lib_loader = array();

		$base = $admin->plugin;

		if ( ! isset( $_d4p_lib_loader[ $base ] ) ) {
			$_d4p_lib_loader[ $base ] = new Enqueue( $admin );
		}

		return $_d4p_lib_loader[ $base ];
	}

	public function is_rtl() : bool {
		return $this->_rtl;
	}

	public function start() {
		$this->_rtl   = is_rtl();
		$this->_debug = $this->_admin->is_debug;
	}

	public function register( $type, $name, $args = array() ) : Enqueue {
		$this->_libraries[ $type ][ $name ] = $args;

		return $this;
	}

	public function js( $name ) : Enqueue {
		$this->add( 'js', $name );

		return $this;
	}

	public function css( $name ) : Enqueue {
		$this->add( 'css', $name );

		return $this;
	}

	public function flatpickr( $plugins = array() ) : Enqueue {
		$this->add( 'js', 'flatpickr' );
		$this->add( 'css', 'flatpickr' );

		if ( ! empty( $plugins ) ) {
			foreach ( $plugins as $plug ) {
				$this->add( 'js', 'flatpickr-' . $plug );
				$this->add( 'css', 'flatpickr-' . $plug );
			}
		}

		return $this;
	}

	public function wp( $includes ) : Enqueue {
		$default  = $includes === true;
		$defaults = array(
			'dialog'       => $default,
			'color_picker' => $default,
			'media'        => $default,
			'sortable'     => $default
		);
		$includes = ! is_array( $includes ) ? array() : $includes;
		$includes = shortcode_atts( $defaults, $includes );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );

		if ( $includes[ 'dialog' ] === true ) {
			wp_enqueue_script( 'wpdialogs' );
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
		}

		if ( $includes[ 'color_picker' ] === true ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
		}

		if ( $includes[ 'sortable' ] === true ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		if ( $includes[ 'media' ] === true ) {
			wp_enqueue_media();
		}

		return $this;
	}

	public function prefix() : string {
		return $this->_enqueue_prefix;
	}

	public function locale() {
		return apply_filters( 'plugin_locale', determine_locale(), 'd4plib' );
	}

	public function locale_js_code( $script ) {
		$locale = $this->locale();

		if ( ! empty( $locale ) && isset( $this->_libraries[ 'js' ][ $script ][ 'locales' ] ) ) {
			$code = strtolower( substr( $locale, 0, 2 ) );

			if ( in_array( $code, $this->_libraries[ 'js' ][ $script ][ 'locales' ] ) ) {
				return $code;
			}
		}

		return false;
	}

	private function add( $type, $name ) {
		if ( isset( $this->_libraries[ $type ][ $name ] ) ) {
			if ( ! $this->is_added( $type, $name ) ) {
				$obj = $this->_libraries[ $type ][ $name ];
				$req = $obj[ 'req' ] ?? array();

				if ( ! empty( $obj[ 'int' ] ) ) {
					foreach ( $obj[ 'int' ] as $lib ) {
						$req[] = $this->prefix() . $lib;

						if ( ! $this->is_added( $type, $lib ) ) {
							$this->add( $type, $lib );
						}
					}
				}

				$handle = $this->prefix() . $name;
				$ver    = $obj[ 'ver' ] ?? $this->_version;
				$footer = $obj[ 'footer' ] ?? true;

				$this->enqueue( $type, $handle, $this->url( $obj ), $req, $ver, $footer );

				$this->_loaded[ $type ][] = $name;

				if ( isset( $obj[ 'locales' ] ) ) {
					$_locale = $this->locale_js_code( $name );

					if ( $_locale !== false ) {
						$this->enqueue( $type, $handle . '-' . $_locale, $this->url( $obj, $_locale ), array( $handle ), $ver, $footer );
					}
				}

				if ( $name == 'admin' ) {
					$this->localize_admin();
				}

				if ( $name == 'meta' ) {
					$this->localize_meta();
				}

				if ( $name == 'media' ) {
					$this->localize_media();
				}
			}
		}
	}

	private function url( $obj, $locale = null ) : string {
		$plugin = isset( $obj[ 'src' ] ) && $obj[ 'src' ] == 'plugin';
		$path   = $plugin ? trailingslashit( $obj[ 'path' ] ) : trailingslashit( 'resources/' . $obj[ 'path' ] );
		$base   = $this->_url;

		if ( ! $plugin ) {
			$dir  = isset( $obj[ 'lib' ] ) && $obj[ 'lib' ] === true ? 'resources/libraries/' : 'resources/';
			$path = trailingslashit( $dir . $obj[ 'path' ] );
		}

		if ( is_null( $locale ) ) {
			$min  = $obj[ 'min' ];
			$path .= $obj[ 'file' ];
		} else {
			$min  = $obj[ 'min_locale' ];
			$path .= 'l10n/' . $locale;
		}

		if ( $min && ! $this->_debug ) {
			$path .= '.min';
		}

		$path .= '.' . $obj[ 'ext' ];

		if ( ! $plugin ) {
			$base .= $this->_library . '/';
		}

		return $base . $path;
	}

	private function is_added( $type, $name ) : bool {
		return in_array( $name, $this->_loaded[ $type ] );
	}

	private function enqueue( $type, $handle, $url, $req, $version, $footer = true ) {
		if ( $type == 'js' ) {
			wp_enqueue_script( $handle, $url, $req, $version, $footer );
		} else if ( $type == 'css' ) {
			wp_enqueue_style( $handle, $url, $req, $version );
		}
	}

	private function localize_admin() {
		wp_localize_script( $this->prefix() . 'admin', 'd4plib_admin_data',
			array(
				'plugin'  => array(
					'name'   => $this->_admin->plugin,
					'prefix' => $this->_admin->plugin_prefix
				),
				'page'    => array(
					'panel'    => $this->_admin->panel,
					'subpanel' => $this->_admin->subpanel
				),
				'content' => array(
					'nonce' => wp_create_nonce( $this->_admin->plugin_prefix . '-admin-internal' )
				)
			) + $this->localize_shared_args() );
	}

	private function localize_meta() {
		wp_localize_script( $this->prefix() . 'meta', 'd4plib_meta_data',
			$this->localize_shared_args()
		);
	}

	private function localize_media() {
		wp_localize_script( $this->prefix() . 'media', 'd4plib_media_data', array(
			'strings' => array(
				'image_remove'       => __( "Remove", "d4plib" ),
				'image_preview'      => __( "Preview", "d4plib" ),
				'image_title'        => __( "Select Image", "d4plib" ),
				'image_button'       => __( "Use Selected Image", "d4plib" ),
				'image_not_selected' => __( "Image not selected.", "d4plib" ),
				'are_you_sure'       => __( "Are you sure you want to do this?", "d4plib" )
			),
			'icons'   => array(
				'remove'  => "<i aria-hidden='true' class='d4p-icon d4p-ui-ban d4p-icon-fw'></i>",
				'preview' => "<i aria-hidden='true' class='d4p-icon d4p-ui-search d4p-icon-fw'></i>"
			)
		) );
	}

	private function localize_shared_args() : array {
		return array(
			'lib' => array(
				'flatpickr' => $this->locale_js_code( 'flatpickr' )
			),
			'ui'  => array(
				'icons'    => array(
					'spinner' => '<i class="d4p-icon d4p-ui-spinner d4p-icon-fw d4p-icon-spin"></i>',
					'ok'      => '<i class="d4p-icon d4p-ui-check d4p-icon-fw" aria-hidden="true"></i> ',
					'send'    => '<i class="d4p-icon d4p-ui-paper-plane d4p-icon-fw" aria-hidden="true"></i> ',
					'cancel'  => '<i class="d4p-icon d4p-ui-cancel d4p-icon-fw" aria-hidden="true"></i> ',
					'delete'  => '<i class="d4p-icon d4p-ui-trash d4p-icon-fw" aria-hidden="true"></i> ',
					'disable' => '<i class="d4p-icon d4p-ui-times d4p-icon-fw" aria-hidden="true"></i> ',
					'empty'   => '<i class="d4p-icon d4p-ui-eraser d4p-icon-fw" aria-hidden="true"></i> ',
				),
				'buttons'  => array(
					'ok'      => __( "OK", "d4plib" ),
					'cancel'  => __( "Cancel", "d4plib" ),
					'delete'  => __( "Delete", "d4plib" ),
					'disable' => __( "Disable", "d4plib" ),
					'empty'   => __( "Empty", "d4plib" ),
					'send'    => __( "Send", "d4plib" ),
					'start'   => __( "Start", "d4plib" ),
					'stop'    => __( "Stop", "d4plib" ),
					'wait'    => __( "Wait", "d4plib" )
				),
				'messages' => array(
					'areyousure' => __( "Are you sure you want to do this?", "d4plib" ),
					'pleasewait' => __( "Please Wait...", "d4plib" )
				)
			)
		);
	}
}
