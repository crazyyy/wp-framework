<?php

/*
Name:    Dev4Press\v42\Core\Quick\WP
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

namespace Dev4Press\v42\Core\Quick;

use Dev4Press\v42\Core\Helpers\Error;
use WP_Error;
use WP_Query;
use WP_Term;
use wpdb;
use function add_action;
use function add_filter;
use function get_term;
use function get_term_by;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPR {
	public static function is_plugin_active( $plugin ) : bool {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) || WPR::is_plugin_active_for_network( $plugin );
	}

	public static function is_plugin_active_for_network( $plugin ) : bool {
		if ( ! is_multisite() ) {
			return false;
		}

		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[ $plugin ] ) ) {
			return true;
		}

		return false;
	}

	public static function is_classicpress() : bool {
		return function_exists( 'classicpress_version' ) &&
		       function_exists( 'classicpress_version_short' );
	}

	public static function is_wp_error( $thing ) : bool {
		return ( $thing instanceof WP_Error ) || ( $thing instanceof Error );
	}

	public static function is_login_page() : bool {
		return isset( $GLOBALS[ 'pagenow' ] ) && $GLOBALS[ 'pagenow' ] === 'wp-login.php';
	}

	public static function is_signup_page() : bool {
		return isset( $GLOBALS[ 'pagenow' ] ) && $GLOBALS[ 'pagenow' ] === 'wp-signup.php';
	}

	public static function is_activate_page() : bool {
		return isset( $GLOBALS[ 'pagenow' ] ) && $GLOBALS[ 'pagenow' ] == 'wp-activate.php';
	}

	public static function is_login_page_action( $action = '' ) : bool {
		$login_page = isset( $GLOBALS[ 'pagenow' ] ) && in_array( $GLOBALS[ 'pagenow' ], array(
				'wp-login.php',
				'wp-register.php'
			) );

		if ( $login_page ) {
			if ( $action != '' ) {
				$real_action = isset( $_REQUEST[ 'action' ] ) ? sanitize_text_field( $_REQUEST[ 'action' ] ) : 'login';

				return $real_action == $action;
			}

			return true;
		} else {
			return false;
		}
	}

	public static function is_posts_page() : bool {
		global $wp_query;

		return $wp_query->is_posts_page;
	}

	public static function is_any_tax() : bool {
		return is_tag() ||
		       is_tax() ||
		       is_category();
	}

	public static function is_bbpress() : bool {
		if ( class_exists( 'bbPress' ) && function_exists( 'is_bbpress' ) ) {
			return is_bbpress();
		} else {
			return false;
		}
	}

	public static function is_oembed_link( $url ) : bool {
		require_once( ABSPATH . WPINC . '/class-oembed.php' );

		$oembed = _wp_oembed_get_object();
		$result = $oembed->get_html( $url );

		return ! ( $result === false );
	}

	public static function is_user_allowed( $super_admin, $user_roles, $visitor ) : bool {
		if ( is_super_admin() ) {
			return $super_admin;
		} else if ( is_user_logged_in() ) {
			$allowed = $user_roles;

			if ( $allowed === true || is_null( $allowed ) ) {
				return true;
			} else if ( is_array( $allowed ) && empty( $allowed ) ) {
				return false;
			} else if ( is_array( $allowed ) && ! empty( $allowed ) ) {
				global $current_user;

				if ( is_array( $current_user->roles ) ) {
					$matched = array_intersect( $current_user->roles, $allowed );

					return ! empty( $matched );
				}
			}
		} else {
			return $visitor;
		}

		return false;
	}

	public static function is_permalinks_enabled() : bool {
		return ! empty( get_option( 'permalink_structure' ) );
	}

	public static function is_current_user_admin() : bool {
		return WPR::is_current_user_roles( 'administrator' );
	}

	public static function is_current_user_roles( $roles = array() ) : bool {
		$current = WPR::current_user_roles();
		$roles   = (array) $roles;

		if ( is_array( $current ) && ! empty( $roles ) ) {
			$match = array_intersect( $roles, $current );

			return ! empty( $match );
		} else {
			return false;
		}
	}

	public static function current_user_roles() : array {
		if ( is_user_logged_in() ) {
			global $current_user;

			return (array) $current_user->roles;
		} else {
			return array();
		}
	}

	public static function add_action( $tags, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		$tags = (array) $tags;

		foreach ( $tags as $tag ) {
			add_action( $tag, $function_to_add, $priority, $accepted_args );
		}
	}

	public static function add_filter( $tags, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		$tags = (array) $tags;

		foreach ( $tags as $tag ) {
			add_filter( $tag, $function_to_add, $priority, $accepted_args );
		}
	}

	/**
	 * @param bool  $cache
	 * @param bool  $queries
	 *
	 * @global wpdb $wpdb
	 */
	public static function cache_flush( bool $cache = true, bool $queries = true ) {
		if ( $cache ) {
			wp_cache_flush();
		}

		if ( $queries ) {
			global $wpdb;

			if ( is_array( $wpdb->queries ) && ! empty( $wpdb->queries ) ) {
				unset( $wpdb->queries );
				$wpdb->queries = array();
			}
		}
	}

	public static function flush_rewrite_rules() {
		global $wp_rewrite;

		$wp_rewrite->flush_rules();
	}

	public static function redirect_self() {
		wp_redirect( $_SERVER[ 'REQUEST_URI' ] );
	}

	public static function redirect_referer() {
		wp_redirect( wp_get_referer() );
	}

	public static function get_the_slug( $post = null ) {
		$post = get_post( $post );

		return ! empty( $post ) ? $post->post_name : false;
	}

	public static function get_post_excerpt( $post, $word_limit = 50, $append = '...' ) : string {
		$content = $post->post_excerpt == '' ? $post->post_content : $post->post_excerpt;

		$content = strip_shortcodes( $content );
		$content = str_replace( array( "\r", "\n", "  " ), ' ', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = strip_tags( $content );

		$words = explode( ' ', $content, $word_limit + 1 );

		if ( count( $words ) > $word_limit ) {
			array_pop( $words );
			$content = implode( ' ', $words );
			$content .= $append;
		}

		return $content;
	}

	public static function get_post_content( $post ) {
		$content = $post->post_content;

		if ( post_password_required( $post ) ) {
			$content = get_the_password_form( $post );
		}

		$content = apply_filters( 'the_content', $content );

		return str_replace( ']]>', ']]&gt;', $content );
	}

	public static function get_thumbnail_url( $post_id, $size = 'full' ) : string {
		if ( has_post_thumbnail( $post_id ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

			return $image[ 0 ];
		} else {
			return '';
		}
	}

	/*
	 * Function by Micah Wood
	 * https://wpscholar.com/blog/get-attachment-id-from-wp-image-url/
	 */
	public static function get_attachment_id_from_url( $url ) : int {
		$attachment_id = 0;
		$dir           = wp_upload_dir();

		if ( false !== strpos( $url, $dir[ 'baseurl' ] . '/' ) ) {
			$file       = basename( $url );
			$query_args = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'fields'      => 'ids',
				'meta_query'  => array(
					array(
						'value'   => $file,
						'compare' => 'LIKE',
						'key'     => '_wp_attachment_metadata'
					)
				)
			);

			$query = new WP_Query( $query_args );

			if ( $query->have_posts() ) {
				foreach ( $query->posts as $post_id ) {
					$meta = wp_get_attachment_metadata( $post_id );

					$original_file       = basename( $meta[ 'file' ] );
					$cropped_image_files = wp_list_pluck( $meta[ 'sizes' ], 'file' );

					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
						$attachment_id = $post_id;
						break;
					}
				}
			}
		}

		return $attachment_id;
	}

	public static function switch_to_default_theme() {
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	}

	public static function kses_expanded_list_of_tags() : array {
		return array(
			'a'          => array(
				'class'    => true,
				'href'     => true,
				'title'    => true,
				'rel'      => true,
				'style'    => true,
				'download' => true,
				'target'   => true
			),
			'abbr'       => array(),
			'blockquote' => array(
				'class' => true,
				'style' => true,
				'cite'  => true
			),
			'div'        => array(
				'class' => true,
				'style' => true
			),
			'span'       => array(
				'class' => true,
				'style' => true
			),
			'code'       => array(
				'class' => true,
				'style' => true
			),
			'p'          => array(
				'class' => true,
				'style' => true
			),
			'pre'        => array(
				'class' => true,
				'style' => true
			),
			'em'         => array(
				'class' => true,
				'style' => true
			),
			'i'          => array(
				'class' => true,
				'style' => true
			),
			'b'          => array(
				'class' => true,
				'style' => true
			),
			'strong'     => array(
				'class' => true,
				'style' => true
			),
			'del'        => array(
				'datetime' => true,
				'class'    => true,
				'style'    => true
			),
			'h1'         => array(
				'align' => true,
				'class' => true,
				'style' => true
			),
			'h2'         => array(
				'align' => true,
				'class' => true,
				'style' => true
			),
			'h3'         => array(
				'align' => true,
				'class' => true,
				'style' => true
			),
			'h4'         => array(
				'align' => true,
				'class' => true,
				'style' => true
			),
			'h5'         => array(
				'align' => true,
				'class' => true,
				'style' => true
			),
			'h6'         => array(
				'align' => true,
				'class' => true,
				'style' => true
			),
			'ul'         => array(
				'class' => true,
				'style' => true
			),
			'ol'         => array(
				'class' => true,
				'style' => true,
				'start' => true
			),
			'li'         => array(
				'class' => true,
				'style' => true
			),
			'img'        => array(
				'class'  => true,
				'style'  => true,
				'src'    => true,
				'border' => true,
				'alt'    => true,
				'height' => true,
				'width'  => true
			),
			'table'      => array(
				'align'   => true,
				'bgcolor' => true,
				'border'  => true,
				'class'   => true,
				'style'   => true
			),
			'tbody'      => array(
				'align'  => true,
				'valign' => true,
				'class'  => true,
				'style'  => true
			),
			'td'         => array(
				'align'  => true,
				'valign' => true,
				'class'  => true,
				'style'  => true
			),
			'tfoot'      => array(
				'align'  => true,
				'valign' => true,
				'class'  => true,
				'style'  => true
			),
			'th'         => array(
				'align'  => true,
				'valign' => true,
				'class'  => true,
				'style'  => true
			),
			'thead'      => array(
				'align'  => true,
				'valign' => true,
				'class'  => true,
				'style'  => true
			),
			'tr'         => array(
				'align'  => true,
				'valign' => true,
				'class'  => true,
				'style'  => true
			)
		);
	}

	public static function list_post_types( $args = array() ) : array {
		$list       = array();
		$post_types = get_post_types( $args, 'objects' );

		foreach ( $post_types as $cpt => $obj ) {
			$list[ $cpt ] = $obj->labels->name;
		}

		return $list;
	}

	public static function list_taxonomies( $args = array() ) : array {
		$list       = array();
		$taxonomies = get_taxonomies( $args, 'objects' );

		foreach ( $taxonomies as $tax => $obj ) {
			$list[ $tax ] = $obj->labels->name;
		}

		return $list;
	}

	public static function list_user_roles() : array {
		$roles = array();

		foreach ( wp_roles()->roles as $role => $details ) {
			$roles[ $role ] = translate_user_role( $details[ 'name' ] );
		}

		return $roles;
	}

	public static function get_gmt_offset() {
		$offset = get_option( 'gmt_offset' );

		if ( empty( $offset ) ) {
			$offset = wp_timezone_override_offset();
		}

		return $offset === false ? 0 : $offset;
	}

	public static function html_excerpt( $text, $limit, $more = null ) : string {
		return wp_html_excerpt( strip_shortcodes( $text ), $limit, $more );
	}

	public static function check_ajax_referer( $action, $nonce, $die = true ) {
		$result = wp_verify_nonce( $nonce, $action );

		if ( $die && false === $result ) {
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				wp_die( - 1 );
			} else {
				die( '-1' );
			}
		}

		do_action( 'check_ajax_referer', $action, $result );

		return $result;
	}

	public static function post_type_has_archive( $post_type ) : bool {
		if ( post_type_exists( $post_type ) ) {
			$cpt = get_post_type_object( $post_type );

			return $cpt->has_archive !== false;
		} else {
			return false;
		}
	}

	public static function json_die( $data, $response = null ) {
		if ( ! headers_sent() ) {
			header( 'Content-Type: application/json; charset=utf-8' );

			if ( null !== $response ) {
				status_header( $response );
			}

			nocache_headers();
		}

		die( wp_json_encode( $data ) );
	}

	public static function next_scheduled( $hook, $args = null ) {
		if ( ! is_null( $args ) ) {
			return wp_next_scheduled( $hook, $args );
		} else {
			$crons = _get_cron_array();

			if ( empty( $crons ) ) {
				return false;
			}

			$t = - 1;
			foreach ( $crons as $timestamp => $cron ) {
				if ( isset( $cron[ $hook ] ) ) {
					if ( $t == - 1 || $timestamp < $t ) {
						$t = $timestamp;
					}
				}
			}

			return $t == - 1 ? false : $t;
		}
	}

	public static function delete_cron_job( $timestamp, $hook, $hash ) {
		$crons = _get_cron_array();

		if ( ! empty( $crons ) ) {
			$save = false;

			if ( is_array( $hash ) || is_object( $hash ) ) {
				$hash = md5( serialize( $hash ) );
			}

			if ( isset( $crons[ $timestamp ][ $hook ][ $hash ] ) ) {
				unset( $crons[ $timestamp ][ $hook ][ $hash ] );
				$save = true;

				if ( empty( $crons[ $timestamp ][ $hook ] ) ) {
					unset( $crons[ $timestamp ][ $hook ] );

					if ( empty( $crons[ $timestamp ] ) ) {
						unset( $crons[ $timestamp ] );
					}
				}
			}

			if ( $save ) {
				_set_cron_array( $crons );
			}
		}
	}

	public static function remove_cron( $hook ) {
		$crons = _get_cron_array();

		if ( ! empty( $crons ) ) {
			$save = false;

			foreach ( $crons as $timestamp => $cron ) {
				if ( isset( $cron[ $hook ] ) ) {
					unset( $crons[ $timestamp ][ $hook ] );
					$save = true;

					if ( empty( $crons[ $timestamp ] ) ) {
						unset( $crons[ $timestamp ] );
					}
				}
			}

			if ( $save ) {
				_set_cron_array( $crons );
			}
		}
	}

	public static function get_term( $term, $taxonomy = '', $output = OBJECT, $filter = 'raw' ) {
		if ( $term instanceof WP_Term || is_numeric( $term ) ) {
			return get_term( $term, $taxonomy, $output, $filter );
		} else if ( is_string( $term ) ) {
			return get_term_by( 'slug', $term, $taxonomy, $output, $filter );
		}

		return false;
	}

	public static function has_gravatar( $email ) : bool {
		$hash = md5( strtolower( trim( $email ) ) );

		$url     = 'https://www.gravatar.com/avatar/' . $hash . '?d=404';
		$headers = get_headers( $url );

		return preg_match( "/200/", $headers[ 0 ] ) === 1;
	}

	public static function get_user_display_name( $user_id = 0 ) : string {
		if ( $user_id == 0 ) {
			$user_id = get_current_user_id();
		}

		if ( $user_id > 0 ) {
			$author_name = get_the_author_meta( 'display_name', $user_id );

			if ( empty( $author_name ) ) {
				$author_name = get_the_author_meta( 'user_login', $user_id );
			}

			return $author_name;
		}

		return '';
	}
}
