<?php

	/**
	 * Helpers functions
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package clearfy
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('WbcrFactoryClearfy206_Helpers') ) {
		class WbcrFactoryClearfy206_Helpers {

			/**
			 * Ссылка по умолчанию (анг)
			 */
			const WEBCRAFTIC_SITE_URL = 'https://clearfy.pro';

			/**
			 * Русская локализация сайта
			 */
			const WEBCRAFTIC_RU_SITE_URL = 'https://ru.clearfy.pro';
			/**
			 * Украинская локализация сайта
			 */
			const WEBCRAFTIC_UA_SITE_URL = 'https://ua.clearfy.pro';
			/**
			 * Испанская
			 */
			const WEBCRAFTIC_ES_SITE_URL = 'https://es.clearfy.pro';
			/**
			 * Французкая
			 */
			const WEBCRAFTIC_DE_SITE_URL = 'https://de.clearfy.pro';

			/**
			 * @since 2.0.5
			 * @param int $price
			 * @return int
			 */
			public static function getClearfyBusinessPrice($price = 19)
			{
				return (int)apply_filters('wbcr/clearfy/business_price', $price);
			}

			/**
			 * @since 2.0.5
			 * @param int $price
			 * @return int
			 */
			public static function getClearfyBusinessRevPrice($price = 69)
			{
				return (int)apply_filters('wbcr/clearfy/business_rev_price', $price);
			}

			/**
			 * Get a link to the official website of the developer
			 *
			 * @return string|null
			 */
			public static function getWebcrafticSiteUrl()
			{
				if( get_locale() == 'ru_RU' ) {
					return self::WEBCRAFTIC_RU_SITE_URL;
				}

				return self::WEBCRAFTIC_SITE_URL;
			}

			/**
			 * /**
			 * Get a link to the official website of the developer
			 *
			 * @since 2.0.5
			 * @param string $plugin_name
			 * @param string $page - page address
			 * @param string $utm_content - from which page or part of the plugin user moved to the site
			 * @param string $urm_source
			 * @return string
			 */
			public static function getWebcrafticSitePageUrl($plugin_name, $page, $utm_content = null, $urm_source = 'wordpress.org')
			{
				$args = array('utm_source' => $urm_source);

				if( !empty($plugin_name) ) {
					$args['utm_campaign'] = $plugin_name;
				}

				if( !empty($utm_content) ) {
					$args['utm_content'] = $utm_content;
				}

				$raw_url = add_query_arg($args, self::getWebcrafticSiteUrl() . '/' . $page . '/');
				$url = esc_url($raw_url);

				/**
				 * @param string $url
				 * @param string $raw_url
				 * @param string $plugin_name
				 * @param string $page - page address
				 * @param string $utm_content - from which page or part of the plugin user moved to the site
				 * @param string $urm_source
				 */

				return apply_filters('wbcr/clearfy/webcraftic_site_page_url', $url, $raw_url, $plugin_name, $page, $utm_content, $urm_source);
			}

			/**
			 * Recursive sanitation for an array
			 *
			 * @param $array
			 * @since 2.0.5
			 * @return mixed
			 */
			public static function recursiveSanitizeArray($array, $function)
			{
				foreach($array as $key => &$value) {
					if( is_array($value) ) {
						$value = self::recursiveSanitizeArray($value, $function);
					} else {
						if( function_exists($function) ) {
							$value = $function($value);
						}
					}
				}

				return $array;
			}

			/**
			 * Is permalink enabled?
			 * @global WP_Rewrite $wp_rewrite
			 * @since 1.0.0
			 * @return bool
			 */
			public static function isPermalink()
			{
				global $wp_rewrite;

				if( !isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks() ) {
					return false;
				}

				return true;
			}

			/**
			 * Display 404 page to bump bots and bad guys
			 *
			 * @param bool $simple If true force displaying basic 404 page
			 */
			public static function setError404()
			{
				global $wp_query;

				if( function_exists('status_header') ) {
					status_header('404');
					nocache_headers();
				}

				if( $wp_query && is_object($wp_query) ) {
					$wp_query->set_404();
					get_template_part(404);
				} else {
					global $pagenow;

					$pagenow = 'index.php';

					if( !defined('WP_USE_THEMES') ) {
						define('WP_USE_THEMES', true);
					}

					wp();

					$_SERVER['REQUEST_URI'] = self::userTrailingslashit('/hmwp_404');

					require_once(ABSPATH . WPINC . '/template-loader.php');
				}

				exit();
			}

			public static function useTrailingSlashes()
			{
				return ('/' === substr(get_option('permalink_structure'), -1, 1));
			}

			public static function userTrailingslashit($string)
			{
				return self::useTrailingSlashes() ? trailingslashit($string) : untrailingslashit($string);
			}

			/**
			 * Returns true if a needle can be found in a haystack
			 *
			 * @param string $string
			 * @param string $find
			 * @param bool $case_sensitive
			 * @return bool
			 */
			public static function strContains($string, $find, $case_sensitive = true)
			{
				if( empty($string) || empty($find) ) {
					return false;
				}

				$pos = $case_sensitive ? strpos($string, $find) : stripos($string, $find);

				return !($pos === false);
			}

			/**
			 * Tests if a text starts with an given string.
			 *
			 * @param string $string
			 * @param string $find
			 * @param bool $case_sensitive
			 * @return bool
			 */
			public static function strStartsWith($string, $find, $case_sensitive = true)
			{
				if( $case_sensitive ) {
					return strpos($string, $find) === 0;
				}

				return stripos($string, $find) === 0;
			}

			/**
			 * Tests if a text ends with an given string.
			 *
			 * @param $string
			 * @param $find
			 * @param bool $case_sensitive
			 * @return bool
			 */
			public static function strEndsWith($string, $find, $case_sensitive = true)
			{
				$expected_position = strlen($string) - strlen($find);

				if( $case_sensitive ) {
					return strrpos($string, $find, 0) === $expected_position;
				}

				return strripos($string, $find, 0) === $expected_position;
			}

			public static function arrayMergeInsert(array $arr, array $inserted, $position = 'bottom', $key = null)
			{
				if( $position == 'top' ) {
					return array_merge($inserted, $arr);
				}
				$key_position = ($key === null) ? false : array_search($key, array_keys($arr));
				if( $key_position === false OR ($position != 'before' AND $position != 'after') ) {
					return array_merge($arr, $inserted);
				}
				if( $position == 'after' ) {
					$key_position++;
				}

				return array_merge(array_slice($arr, 0, $key_position, true), $inserted, array_slice($arr, $key_position, null, true));
			}

			public static function maybeGetPostJson($name)
			{
				if( isset($_POST[$name]) AND is_string($_POST[$name]) ) {
					$result = json_decode(stripslashes($_POST[$name]), true);
					if( !is_array($result) ) {
						$result = array();
					}

					return $result;
				} else {
					return array();
				}
			}

			public static function getEscapeJson(array $data)
			{
				return htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
			}

			/**
			 * Replace url for multisite
			 *
			 * @param $string
			 *
			 * @return string
			 */
			public static function replaceMsUrl($string)
			{
				if( is_multisite() && BLOG_ID_CURRENT_SITE != get_current_blog_id() ) {
					return str_replace(get_site_url(BLOG_ID_CURRENT_SITE), get_site_url(get_current_blog_id()), $string);
				}

				return $string;
			}

			/*
			 * Flushes as many page cache plugin's caches as possible.
			 *
			 * @return void
			 */
			public static function flushPageCache()
			{
				if( function_exists('wp_cache_clear_cache') ) {
					if( is_multisite() ) {
						$blog_id = get_current_blog_id();
						wp_cache_clear_cache($blog_id);
					} else {
						wp_cache_clear_cache();
					}
				} elseif( has_action('cachify_flush_cache') ) {
					do_action('cachify_flush_cache');
				} elseif( function_exists('w3tc_pgcache_flush') ) {
					w3tc_pgcache_flush();
				} elseif( function_exists('wp_fast_cache_bulk_delete_all') ) {
					wp_fast_cache_bulk_delete_all();
				} elseif( class_exists('WpFastestCache') ) {
					$wpfc = new WpFastestCache();
					$wpfc->deleteCache();
				} elseif( class_exists('c_ws_plugin__qcache_purging_routines') ) {
					c_ws_plugin__qcache_purging_routines::purge_cache_dir(); // quick cache
				} elseif( class_exists('zencache') ) {
					zencache::clear();
				} elseif( class_exists('comet_cache') ) {
					comet_cache::clear();
				} elseif( class_exists('WpeCommon') ) {
					// WPEngine cache purge/flush methods to call by default
					$wpe_methods = array(
						'purge_varnish_cache',
					);

					// More agressive clear/flush/purge behind a filter
					if( apply_filters('wbcr/factory/flush_wpengine_aggressive', false) ) {
						$wpe_methods = array_merge($wpe_methods, array('purge_memcached', 'clear_maxcdn_cache'));
					}

					// Filtering the entire list of WpeCommon methods to be called (for advanced usage + easier testing)
					$wpe_methods = apply_filters('wbcr/factory/wpengine_methods', $wpe_methods);

					foreach($wpe_methods as $wpe_method) {
						if( method_exists('WpeCommon', $wpe_method) ) {
							WpeCommon::$wpe_method();
						}
					}
				} elseif( function_exists('sg_cachepress_purge_cache') ) {
					sg_cachepress_purge_cache();
				} elseif( file_exists(WP_CONTENT_DIR . '/wp-cache-config.php') && function_exists('prune_super_cache') ) {
					// fallback for WP-Super-Cache
					global $cache_path;
					if( is_multisite() ) {
						$blog_id = get_current_blog_id();
						prune_super_cache(get_supercache_dir($blog_id), true);
						prune_super_cache($cache_path . 'blogs/', true);
					} else {
						prune_super_cache($cache_path . 'supercache/', true);
						prune_super_cache($cache_path, true);
					}
				}
			}
		}
	}