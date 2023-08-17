<?php

/*
Name:    Dev4Press\v42\Core\Options\Process
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

use Dev4Press\v42\Core\Quick\Arr;
use Dev4Press\v42\Core\Quick\Sanitize;
use Dev4Press\v42\Core\Quick\Str;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Process {
	public $bool_values = array( true, false );

	public $base = 'd4pvalue';
	public $prefix = 'd4p';
	public $settings;

	public function __construct( $base, $prefix = 'd4p' ) {
		$this->base   = $base;
		$this->prefix = $prefix;
	}

	public static function instance( $base = 'd4pvalue', $prefix = 'd4p' ) : Process {
		static $process = array();

		if ( ! isset( $process[ $base ] ) ) {
			$process[ $base ] = new Process( $base, $prefix );
		}

		return $process[ $base ];
	}

	public function prepare( $settings ) : Process {
		$this->settings = $settings;

		return $this;
	}

	public function process( $request = false ) : array {
		$list = array();

		if ( $request === false ) {
			$request = $_REQUEST;
		}

		foreach ( $this->settings as $setting ) {
			if ( $setting->type != '_' ) {
				$post = $request[ $this->base ][ $setting->type ] ?? array();

				$list[ $setting->type ][ $setting->name ] = $this->process_single( $setting, $post );
			}
		}

		return $list;
	}

	public function slug_slashes( $key ) {
		$key = strtolower( $key );

		return preg_replace( '/[^a-z0-9.\/_\-]/', '', $key );
	}

	public function process_single( $setting, $post ) {
		$input = $setting->input;
		$key   = $setting->name;
		$value = null;

		switch ( $input ) {
			default:
				$value = apply_filters( $this->prefix . '_process_option_call_back_for_' . $input, $value, $post[ $key ], $setting );

				if ( is_null( $value ) ) {
					$value = Sanitize::basic( (string) $post[ $key ] );
				}
				break;
			case 'skip':
			case 'info':
			case 'hr':
			case 'custom':
				$value = null;
				break;
			case 'expandable_raw':
				$value = array();

				foreach ( $post[ $key ] as $id => $data ) {
					if ( $id > 0 ) {
						$_val = trim( stripslashes( $data[ 'value' ] ) );

						if ( $_val != '' ) {
							$value[] = $_val;
						}
					}
				}
				break;
			case 'expandable_text':
				$value = array();

				foreach ( $post[ $key ] as $id => $data ) {
					if ( $id > 0 ) {
						$_val = Sanitize::basic( $data[ 'value' ] );

						if ( ! empty( $_val ) ) {
							$value[] = $_val;
						}
					}
				}
				break;
			case 'expandable_pairs':
				$value = array();

				foreach ( $post[ $key ] as $id => $data ) {
					if ( $id > 0 ) {
						$_key = Sanitize::basic( $data[ 'key' ] );
						$_val = Sanitize::basic( $data[ 'value' ] );

						if ( ! empty( $_key ) && ! empty( $_val ) ) {
							$value[ $_key ] = $_val;
						}
					}
				}
				break;
			case 'range_integer':
				$value = intval( $post[ $key ][ 'a' ] ) . '=>' . intval( $post[ $key ][ 'b' ] );
				break;
			case 'range_absint':
				$value = absint( $post[ $key ][ 'a' ] ) . '=>' . absint( $post[ $key ][ 'b' ] );
				break;
			case 'x_by_y':
				$value = Sanitize::basic( $post[ $key ][ 'x' ] ) . 'x' . Sanitize::basic( $post[ $key ][ 'y' ] );
				break;
			case 'html':
			case 'code':
			case 'text_html':
			case 'text_rich':
				$value = Sanitize::html( $post[ $key ] );
				break;
			case 'bool':
				$value = isset( $post[ $key ] ) ? $this->bool_values[ 0 ] : $this->bool_values[ 1 ];
				break;
			case 'number':
				$value = floatval( $post[ $key ] );
				break;
			case 'integer':
				$value = intval( $post[ $key ] );
				break;
			case 'image':
			case 'absint':
			case 'dropdown_pages':
			case 'dropdown_categories':
				$value = absint( $post[ $key ] );
				break;
			case 'images':
				if ( ! isset( $post[ $key ] ) ) {
					$value = array();
				} else {
					$value = (array) $post[ $key ];
					$value = array_map( 'intval', $value );
					$value = array_filter( $value );
				}
				break;
			case 'listing':
				$value = Str::split_to_list( stripslashes( $post[ $key ] ) );
				break;
			case 'media':
				$value = 0;
				if ( $post[ $key ] != '' ) {
					$value = absint( substr( $post[ $key ], 3 ) );
				}
				break;
			case 'checkboxes':
			case 'checkboxes_hierarchy':
			case 'select_multi':
			case 'group_multi':
				if ( ! isset( $post[ $key ] ) ) {
					$value = array();
				} else {
					$value = (array) $post[ $key ];
					$value = array_map( '\Dev4Press\v42\Core\Quick\Sanitize::basic', $value );
				}
				break;
			case 'css_size':
				$sizes = Arr::get_css_size_units();

				$value = Sanitize::basic( $post[ $key ][ 'val' ] );
				$unit  = strtolower( Sanitize::basic( $post[ $key ][ 'unit' ] ) );

				if ( ! isset( $sizes[ $unit ] ) ) {
					$unit = 'px';
				}

				$value = $value . $unit;
				break;
			case 'slug':
				$value = Sanitize::slug( $post[ $key ] );
				break;
			case 'slug_ext':
				$value = Sanitize::key( $post[ $key ] );
				break;
			case 'slug_slash':
				$value = $this->slug_slashes( $post[ $key ] );
				break;
			case 'email':
				$value = sanitize_email( $post[ $key ] );
				break;
			case 'date':
				$value = Sanitize::date( $post[ $key ] );
				break;
			case 'time':
				$value = Sanitize::time( $post[ $key ] );
				break;
			case 'datetime':
				$value = Sanitize::date( $post[ $key ], 'Y-m-d H:i:s' );
				break;
			case 'month':
				$value = Sanitize::month( $post[ $key ] );
				break;
			case 'text':
			case 'textarea':
			case 'password':
			case 'group':
			case 'link':
			case 'color':
			case 'block':
			case 'hidden':
			case 'select':
			case 'radios':
			case 'radios_hierarchy':
				$value = Sanitize::basic( $post[ $key ] );
				break;
		}

		return $value;
	}
}
