<?php

/*
Name:    Dev4Press\v42\Core\Helpers\Debug
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

use ReflectionFunction;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Debug {
	public static function error_log( $log, $title = '' ) {
		if ( true === WP_DEBUG ) {
			$print = '';

			if ( $title != '' ) {
				$print .= '<<<< ' . $title . "\r\n";
			}

			$print .= print_r( $log, true );

			error_log( $print );
		}
	}

	public static function print_r( $obj, $pre = true, $title = '', $before = '', $after = '' ) {
		echo $before . D4P_EOL;

		if ( $pre ) {
			echo '<pre style="padding: 5px; font-size: 12px; background: #fff; border: 1px solid #000; color: #000;">';

			if ( $title != '' ) {
				echo '&gt;&gt;&gt;&gt;&nbsp;<strong>' . esc_html( $title ) . '</strong>&nbsp;&lt;&lt;&lt;&lt;&lt;<br/><br/>';
			}
		} else {
			if ( $title != '' ) {
				echo "<<<< " . esc_html( $title ) . " >>>>\r\n\r\n";
			}
		}

		print_r( $obj );

		if ( $pre ) {
			echo '</pre>';
		}

		echo $after . D4P_EOL;
	}

	public static function print_hooks( $filter = false, $destination = 'print' ) {
		global $wp_filter;

		$skip = empty( $filter );

		foreach ( $wp_filter as $tag => $hook ) {
			if ( $skip || false !== strpos( $tag, $filter ) ) {
				self::print_hook( $tag, $hook, $destination );
			}
		}
	}

	public static function print_hook( $tag, $hook, $destination = 'print' ) {
		ksort( $hook );

		$print = array();

		foreach ( $hook as $priority => $functions ) {
			foreach ( $functions as $function ) {
				$line = $priority . ' : ';

				$callback = $function[ 'function' ];

				if ( is_string( $callback ) ) {
					$line .= $callback;
				} else if ( is_a( $callback, 'Closure' ) ) {
					$closure = new ReflectionFunction( $callback );
					$line    .= 'closure from ' . $closure->getFileName() . '::' . $closure->getStartLine();
				} else if ( is_string( $callback[ 0 ] ) ) {
					$line .= $callback[ 0 ] . '::' . $callback[ 1 ];
				} else if ( is_object( $callback[ 0 ] ) ) {
					$line .= get_class( $callback[ 0 ] ) . '->' . $callback[ 1 ];
				}

				if ( $function[ 'accepted_args' ] == 1 ) {
					$line .= " ({$function['accepted_args']})";
				}

				$print[] = $line;
			}
		}

		if ( $destination == 'log' ) {
			self::error_log( $print, $tag );
		} else {
			self::print_r( $print, true, $tag );
		}
	}

	public static function print_page_summary() {
		global $wpdb;

		echo D4P_EOL;
		echo '<!-- ' . esc_html__( "SQL Queries", "d4plib" ) . '           : ';
		echo $wpdb->num_queries;
		echo ' -->' . D4P_EOL;
		echo '<!-- ' . esc_html__( "Total Page Time", "d4plib" ) . '       : ';
		echo timer_stop( 0, 6 ) . ' ' . esc_html__( "seconds", "d4plib" );
		echo ' -->' . D4P_EOL;

		if ( function_exists( 'memory_get_peak_usage' ) ) {
			echo '<!-- ' . esc_html__( "PHP Memory Peak", "d4plib" ) . '       : ';
			echo round( memory_get_peak_usage() / 1024 / 1024, 2 ) . ' MB';
			echo ' -->' . D4P_EOL;
		}

		if ( function_exists( 'memory_get_usage' ) ) {
			echo '<!-- ' . esc_html__( "PHP Memory Final", "d4plib" ) . '      : ';
			echo round( memory_get_usage() / 1024 / 1024, 2 ) . ' MB';
			echo ' -->' . D4P_EOL;
		}

		echo D4P_EOL;
	}

	public static function print_query_conditions() {
		global $wp_query;

		echo D4P_EOL;

		$true = $false = '';

		foreach ( $wp_query as $key => $value ) {
			if ( substr( $key, 0, 3 ) == 'is_' ) {
				$line = '<!-- ' . $key . ': ' . ( $value ? 'true' : 'false' ) . ' -->' . D4P_EOL;

				if ( $value ) {
					$true .= $line;
				} else {
					$false .= $line;
				}
			}
		}

		foreach ( array( 'is_front_page' ) as $key ) {
			$value = $wp_query->$key();

			$line = '<!-- ' . $key . ': ' . ( $value ? 'true' : 'false' ) . ' -->' . D4P_EOL;

			if ( $value ) {
				$true .= $line;
			} else {
				$false .= $line;
			}
		}

		echo $true . D4P_EOL . $false;

		echo D4P_EOL;
	}

	public static function print_page_request() {
		global $wp, $template;

		echo D4P_EOL;
		echo '<!-- ' . esc_html__( "Request", "d4plib" ) . '               : ';
		echo empty( $wp->request ) ? esc_html__( "None", "d4plib" ) : esc_html( $wp->request );
		echo ' -->' . D4P_EOL;
		echo '<!-- ' . esc_html__( "Matched Rewrite Rule", "d4plib" ) . '  : ';
		echo empty( $wp->matched_rule ) ? esc_html__( "None", "d4plib" ) : esc_html( $wp->matched_rule );
		echo ' -->' . D4P_EOL;
		echo '<!-- ' . esc_html__( "Matched Rewrite Query", "d4plib" ) . ' : ';
		echo empty( $wp->matched_query ) ? esc_html__( "None", "d4plib" ) : esc_html( $wp->matched_query );
		echo ' -->' . D4P_EOL;
		echo '<!-- ' . esc_html__( "Loaded Template", "d4plib" ) . '       : ';
		echo basename( $template );
		echo ' -->' . D4P_EOL;
	}
}
