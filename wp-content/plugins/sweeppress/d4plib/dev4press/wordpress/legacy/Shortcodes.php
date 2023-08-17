<?php

/*
Name:    Dev4Press\v42\WordPress\Legacy\Widget
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

namespace Dev4Press\v42\WordPress\Legacy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Shortcodes {
	public $prefix = 'd4p';
	public $shortcodes = array();
	public $registered = array();

	public function __construct() {
		$this->init();

		$this->_register();
	}

	abstract public function init();

	protected function _real_code( $code ) : string {
		return ! empty( $this->prefix ) ? $this->prefix . '_' . $code : $code;
	}

	protected function _wrapper( $content, $name, $extra_class = '', $tag = 'div' ) : string {
		$classes = array(
			$this->prefix . '-shortcode-wrapper',
			$this->prefix . '-shortcode-' . str_replace( '_', '-', $name )
		);

		if ( ! empty( $extra_class ) ) {
			$classes[] = $extra_class;
		}

		$wrapper = '<' . $tag . ' class="' . join( ' ', $classes ) . '">';
		$wrapper .= $content;
		$wrapper .= '</' . $tag . '>';

		return $wrapper;
	}

	protected function _register() {
		$list = array_keys( $this->shortcodes );

		foreach ( $list as $shortcode ) {
			$name = $this->_real_code( $shortcode );

			add_shortcode( $name, array( $this, 'shortcode_' . $shortcode ) );

			$this->registered[ $name ] = $shortcode;
		}
	}

	protected function _args( $code ) : array {
		return $this->shortcodes[ $code ][ 'args' ] ?? array();
	}

	protected function _atts( $code, $atts = array() ) : array {
		$real_code = $this->_real_code( $code );

		if ( isset( $atts[ 0 ] ) ) {
			$atts[ $real_code ] = substr( $atts[ 0 ], 1 );
			unset( $atts[ 0 ] );
		}

		$default               = $this->shortcodes[ $code ][ 'atts' ];
		$default[ $real_code ] = '';

		$atts = shortcode_atts( $default, $atts );
		$bool = $this->shortcodes[ $code ][ 'bool' ] ?? array();
		$list = $this->shortcodes[ $code ][ 'list' ] ?? array();
		$int  = $this->shortcodes[ $code ][ 'int' ] ?? array();

		foreach ( $bool as $key ) {
			if ( ! is_bool( $atts[ $key ] ) ) {
				$atts[ $key ] = $this->_convert_bool( $atts[ $key ] );
			}
		}

		foreach ( $list as $key ) {
			if ( is_string( $atts[ $key ] ) && ! empty( $atts[ $key ] ) ) {
				$atts[ $key ] = $this->_split_array( $atts[ $key ] );
			}
		}

		foreach ( $int as $key ) {
			if ( ! empty( $atts[ $key ] ) ) {
				$atts[ $key ] = intval( $atts[ $key ] );
			}
		}

		return $atts;
	}

	protected function _content( $content, $raw = false ) : string {
		if ( $raw ) {
			return $content;
		} else {
			return do_shortcode( $content );
		}
	}

	private function _convert_bool( $value ) : bool {
		return $value === 1 || $value === '1' || $value === 'on' || $value === 'yes' || $value === 'true';
	}

	private function _split_array( $value, $sep = ',' ) : array {
		$value = explode( $sep, $value );
		$value = array_map( 'trim', $value );
		$value = array_unique( $value );

		return array_filter( $value );
	}
}
