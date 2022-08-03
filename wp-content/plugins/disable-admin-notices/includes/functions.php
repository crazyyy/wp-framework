<?php
/**
 * Helper functions
 * @author Webcraftic <alex.kovalevv@gmail.com>
 * @copyright (c) 05.07.2020, Webcraftic
 * @version 1.0
 */

/**
 * Access to global variable $wp_filter in WP core.
 * Migration from WP 4.2 to 4.9
 *
 * @see https://codex.wordpress.org/Version_4.7 WP 4.7 changelog (WP_Hook)
 *
 * @param $key string filter name
 *
 * @return array callbacks array by link
 */
function &wdan_get_wp_filter( $key ) {
	global $wp_filter;

	$default = [];

	if ( 'admin_notices' === $key && is_multisite() && is_network_admin() ) {
		$key = 'network_admin_notices';
	}

	if ( ! isset( $wp_filter[ $key ] ) ) {
		return $default;
	}

	return $wp_filter[ $key ]->callbacks;
}

/**
 * @param $key
 *
 * @return array
 */
function wdan_collect_notices( $key ) {
	$wp_filter = &wdan_get_wp_filter( $key );

	$content = [];

	if ( ! empty( $wp_filter ) ) {
		foreach ( (array) $wp_filter as $filters ) {
			foreach ( $filters as $callback_name => $callback ) {

				if ( 'usof_hide_admin_notices_start' == $callback_name || 'usof_hide_admin_notices_end' == $callback_name ) {
					continue;
				}

				ob_start();

				// #CLRF-140 fix bug for php7
				// when the developers forgot to delete the argument in the function of implementing the notification.
				$args          = [];
				$accepted_args = isset( $callback['accepted_args'] ) && ! empty( $callback['accepted_args'] ) ? $callback['accepted_args'] : 0;

				if ( $accepted_args > 0 ) {
					for ( $i = 0; $i < (int) $accepted_args; $i ++ ) {
						$args[] = null;
					}
				}
				//===========

				call_user_func_array( $callback['function'], $args );
				$cont = ob_get_clean();

				if ( ! empty( $cont ) ) {
					$salt     = is_multisite() ? get_current_blog_id() : '';
					$uniq_id1 = md5( $cont . $salt );
					$uniq_id2 = md5( $callback_name . $salt );

					if ( is_array( $callback['function'] ) && sizeof( $callback['function'] ) == 2 ) {
						$class = $callback['function'][0];
						if ( is_object( $class ) ) {
							$class_name  = get_class( $class );
							$method_name = $callback['function'][1];
							$uniq_id2    = md5( $class_name . ':' . $method_name );
						}
					}

					$content[ $uniq_id1 . "_" . $uniq_id2 ] = $cont;
				}
			}
		}
	}

	return $content;
}

/**
 * @param $key
 * @param array $excluded_classes
 * @param array $excluded_callback_names
 */
function wdan_clear_all_notices( $key, $excluded_classes = [], $excluded_callback_names = [] ) {
	$wp_filter = &wdan_get_wp_filter( $key );

	if ( ! empty( $wp_filter ) ) {
		foreach ( (array) $wp_filter as $f_key => $f ) {
			foreach ( $f as $c_name => $clback ) {
				if ( is_array( $clback['function'] ) && sizeof( $clback['function'] ) == 2 ) {
					$class = $clback['function'][0];
					if ( is_object( $class ) ) {
						$class_name = get_class( $class );

						if ( in_array( $class_name, $excluded_classes ) ) {
							continue;
						}
					}
				}

				if ( in_array( $c_name, $excluded_callback_names ) ) {
					continue;
				}
				unset( $wp_filter[ $f_key ][ $c_name ] );
			}
		}
	}
}