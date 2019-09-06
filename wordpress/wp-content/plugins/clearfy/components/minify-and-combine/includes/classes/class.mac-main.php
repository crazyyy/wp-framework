<?php
	/**
	 * Main class
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2018 Webraftic Ltd
	 * @version 1.0
	 */

	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * Class WMAC_PluginMain
	 */
	class WMAC_PluginMain {

		const INIT_EARLIER_PRIORITY = -1;
		const DEFAULT_HOOK_PRIORITY = 2;

		/**
		 * Constructor.
		 */
		public function __construct()
		{
		}

		/**
		 * Start processing
		 */
		public function start()
		{
			$this->setup();
			$this->run();
			$this->check();
			$this->clear();
		}

		/**
		 * Runs cache size checker
		 */
		public function check()
		{
			$checker = new WMAC_PluginCacheChecker();
			$checker->run();
		}

		/**
		 * Setting the parameters
		 */
		public function setup()
		{
			// Do we gzip in php when caching or is the webserver doing it?
			if( !defined('WMAC_CACHE_NOGZIP') ) {
				define('WMAC_CACHE_NOGZIP', true /*(bool) get_option( 'wmac_cache_nogzip' )*/);
			}

			// These can be overridden by specifying them in wp-config.php or such.
			if( !defined('WMAC_WP_CONTENT_NAME') ) {
				define('WMAC_WP_CONTENT_NAME', '/' . wp_basename(WP_CONTENT_DIR));
			}

			if( !defined('WMAC_CACHE_CHILD_DIR') ) {
				define('WMAC_CACHE_CHILD_DIR', '/cache/wmac/');
			}

			if( !defined('WMAC_CACHEFILE_PREFIX') ) {
				define('WMAC_CACHEFILE_PREFIX', 'wmac_');
			}

			if( !defined('WMAC_ROOT_DIR') ) {
				define('WMAC_ROOT_DIR', substr(WP_CONTENT_DIR, 0, strlen(WP_CONTENT_DIR) - strlen(WMAC_WP_CONTENT_NAME)));
			}

			if( !defined('WMAC_WP_ROOT_URL') ) {
				define('WMAC_WP_ROOT_URL', str_replace(WMAC_WP_CONTENT_NAME, '', self::getContentUrl()));
			}

			if( !defined('WMAC_HASH') ) {
				define('WMAC_HASH', wp_hash(WMAC_PluginCache::getCacheUrl()));
			}

			// Multibyte-capable string replacements are available with a filter.
			// Also requires 'mbstring' extension.
			$with_mbstring = apply_filters( 'wbcr/mac/main_use_mbstring', false );
			if ( $with_mbstring ) {
				WMAC_PluginHelper::mbstringAvailable( \extensions_loaded( 'mbstring' ) );
	        } else {
				WMAC_PluginHelper::mbstringAvailable( false );
	        }
		}

		/**
		 * Run
		 */
		public function run()
		{
			if( WMAC_PluginCache::cacheAvail() ) {

				if( WMAC_Plugin::app()->getPopulateOption('js_optimize') || WMAC_Plugin::app()->getPopulateOption('css_optimize')
				) {
					// Hook into WordPress frontend.
					if( defined('WMAC_INIT_EARLIER') ) {
						add_action('init', array($this, 'startBuffering'), self::INIT_EARLIER_PRIORITY);
					} else {
						if( !defined('WMAC_HOOK_INTO') ) {
							define('WMAC_HOOK_INTO', 'template_redirect');
						}
						add_action(constant('WMAC_HOOK_INTO'), array(
								$this,
								'startBuffering'
							), self::DEFAULT_HOOK_PRIORITY);
					}
				}
			} else {
				add_action('admin_notices', 'WMAC_PluginMain::noticeCacheUnavailable');
			}
		}

		/**
		 * Clear cache
		 */
		public function clear()
		{
			// hook into a collection of page cache purge actions if filter allows.
			if( apply_filters('wmac_filter_main_hookpagecachepurge', true) ) {
				$page_cache_purge_actions = array(
					'after_rocket_clean_domain', // exists.
					'hyper_cache_purged', // Stefano confirmed this will be added.
					'w3tc_flush_posts', // exits.
					'w3tc_flush_all', // exists.
					'ce_action_cache_cleared', // Sven confirmed this will be added.
					'comet_cache_wipe_cache', // still to be confirmed by Raam.
					'wp_cache_cleared', // cfr. https://github.com/Automattic/wp-super-cache/pull/537.
					'wpfc_delete_cache', // Emre confirmed this will be added this.
					'swift_performance_after_clear_all_cache', // swift perf. yeah!
				);
				$page_cache_purge_actions = apply_filters('wmac_filter_main_pagecachepurgeactions', $page_cache_purge_actions);
				foreach($page_cache_purge_actions as $purge_action) {
					add_action($purge_action, 'WMAC_PluginCache::clearAllActionless');
				}
			}
		}

		/**
		 * Setup output buffering if needed.
		 *
		 * @return void
		 */
		public function startBuffering()
		{
			if( $this->shouldBuffer() ) {

				// Load speedupper conditionally (true by default).
				if( apply_filters('wmac_filter_extend', true) ) {
					$this->extend();
				}

				if( WMAC_Plugin::app()->getPopulateOption('js_optimize') ) {
					if( !defined('CONCATENATE_SCRIPTS') ) {
						define('CONCATENATE_SCRIPTS', false);
					}
					if( !defined('COMPRESS_SCRIPTS') ) {
						define('COMPRESS_SCRIPTS', false);
					}
				}

				if( WMAC_Plugin::app()->getPopulateOption('css_optimize') ) {
					if( !defined('COMPRESS_CSS') ) {
						define('COMPRESS_CSS', false);
					}
				}

				if( apply_filters('wmac_filter_obkiller', false) ) {
					while( ob_get_level() > 0 ) {
						ob_end_clean();
					}
				}

				// Now, start the real thing!
				ob_start(array($this, 'endBuffering'));
			}
		}

		/**
		 * Returns true if all the conditions to start output buffering are satisfied.
		 *
		 * @param bool $doing_tests Allows overriding the optimization of only
		 *                          deciding once per request (for use in tests).
		 * @return bool
		 */
		public function shouldBuffer($doing_tests = false)
		{
			static $do_buffering = null;

			// Only check once in case we're called multiple times by others but
			// still allows multiple calls when doing tests.
			if( null === $do_buffering || $doing_tests ) {
				$wmac_noptimize = false;

				// Checking for DONOTMINIFY constant as used by e.g. WooCommerce POS.
				if( defined('DONOTMINIFY') && (constant('DONOTMINIFY') === true || constant('DONOTMINIFY') === 'true')
				) {
					$wmac_noptimize = true;
				}

				// Skip checking query strings if they're disabled.
				if( apply_filters('wmac_filter_honor_qs_noptimize', true) ) {
					// Check for `wmac_noptimize` (and other) keys in the query string
					// to get non-optimized page for debugging.
					$keys = array(
						'wmac_noptimize',
						'wmac_noptirocket',
					);
					foreach($keys as $key) {
						if( array_key_exists($key, $_GET) && '1' === $_GET[$key] ) {
							$wmac_noptimize = true;
							break;
						}
					}
				}

				// Allows blocking of auto optimization on your own terms regardless of above decisions.
				$wmac_noptimize = (bool)apply_filters('wmac_filter_noptimize', $wmac_noptimize);

				// Check for site being previewed in the Customizer (available since WP 4.0).
				$is_customize_preview = false;
				if( function_exists('is_customize_preview') && is_customize_preview() ) {
					$is_customize_preview = is_customize_preview();
				}

				/**
				 * We only buffer the frontend requests (and then only if not a feed
				 * and not turned off explicitly and not when being previewed in Customizer)!
				 * NOTE: Tests throw a notice here due to is_feed() being called
				 * while the main query hasn't been ran yet. Thats why we use
				 * WMAC_INIT_EARLIER in tests.
				 */
				$do_buffering = (!is_admin() && !is_feed() && !$wmac_noptimize && !$is_customize_preview);
			}

			return $do_buffering;
		}

		/**
		 * Returns true if given markup is considered valid/processable/optimizable.
		 *
		 * @param string $content Markup.
		 *
		 * @return bool
		 */
		public function isValidBuffer($content)
		{
			// Defaults to true.
			$valid = true;

			$has_no_html_tag = (false === stripos($content, '<html'));
			$has_xsl_stylesheet = (false !== stripos($content, '<xsl:stylesheet'));
			$has_html5_doctype = (preg_match('/^<!DOCTYPE.+html>/i', $content) > 0);

			if( $has_no_html_tag ) {
				// Can't be valid amp markup without an html tag preceding it.
				$is_amp_markup = false;
			} else {
				$is_amp_markup = self::isAmpMarkup($content);
			}

			// If it's not html, or if it's amp or contains xsl stylesheets we don't touch it.
			if( $has_no_html_tag && !$has_html5_doctype || $is_amp_markup || $has_xsl_stylesheet ) {
				$valid = false;
			}

			return $valid;
		}

		/**
		 * Returns true if given $content is considered to be AMP markup.
		 * This is far from actual validation against AMP spec, but it'll do for now.
		 *
		 * @param string $content Markup to check.
		 *
		 * @return bool
		 */
		public static function isAmpMarkup($content)
		{
			$is_amp_markup = preg_match('/<html[^>]*(?:amp|⚡)/i', $content);

			return (bool)$is_amp_markup;
		}

		/**
		 * Processes/optimizes the output-buffered content and returns it.
		 * If the content is not processable, it is returned unmodified.
		 *
		 * @param string $content Buffered content.
		 *
		 * @return string
		 */
		public function endBuffering($content)
		{
			// Bail early without modifying anything if we can't handle the content.
			if( !$this->isValidBuffer($content) ) {
				return $content;
			}

			// Determine what needs to be ran.
			$classes = array();
			if( WMAC_Plugin::app()->getPopulateOption('js_optimize') ) {
				$classes[] = 'WMAC_PluginScripts';
			}
			if( WMAC_Plugin::app()->getPopulateOption('css_optimize') ) {
				$classes[] = 'WMAC_PluginStyles';
			}

			$classoptions = array(
				'WMAC_PluginScripts' => array(
					'aggregate' => WMAC_Plugin::app()->getPopulateOption('js_aggregate'),
					'forcehead' => WMAC_Plugin::app()->getPopulateOption('js_forcehead'),
					'trycatch' => WMAC_Plugin::app()->getPopulateOption('js_trycatch'),
					'js_exclude' => WMAC_Plugin::app()->getPopulateOption('js_exclude'),
					'include_inline' => WMAC_Plugin::app()->getPopulateOption('js_include_inline'),
				),
				'WMAC_PluginStyles' => array(
					'aggregate' => WMAC_Plugin::app()->getPopulateOption('css_aggregate'),
					'datauris' => WMAC_Plugin::app()->getPopulateOption('css_datauris'),
					'defer' => WMAC_Plugin::app()->getPopulateOption('css_defer'),
					'inline' => WMAC_Plugin::app()->getPopulateOption('css_inline'),
					'css_exclude' => WMAC_Plugin::app()->getPopulateOption('css_exclude'),
					'include_inline' => WMAC_Plugin::app()->getPopulateOption('css_include_inline'),
				),
			);

			$content = apply_filters('wmac_filter_html_before_minify', $content);

			// Run the classes!
			foreach($classes as $name) {
				$instance = new $name($content);
				if( $instance->read($classoptions[$name]) ) {
					$instance->minify();
					$instance->cache();
					$content = $instance->getContent();
				}
				unset($instance);
			}

			$content = apply_filters('wmac_html_after_minify', $content);

			return $content;
		}

		/**
		 * Extended functional
		 */
		public function extend()
		{
			if( apply_filters('wmac_js_do_minify', true) ) {
				add_filter('wmac_js_individual_script', array($this, 'jsSnippetcacher'), 10, 2);
				add_filter('wmac_js_after_minify', array($this, 'jsCleanup'), 10, 1);
			}
		}

		/**
		 * @param $jsin
		 * @param $jsfilename
		 *
		 * @return false|mixed|string
		 */
		public function jsSnippetcacher($jsin, $jsfilename)
		{
			$md5hash = 'snippet_' . md5($jsin);
			$ccheck = new WMAC_PluginCache($md5hash, 'js');
			if( $ccheck->check() ) {
				$scriptsrc = $ccheck->retrieve();
			} else {
				if( false === (strpos($jsfilename, 'min.js')) && (false === strpos($jsfilename, 'js/jquery/jquery.js')) && (str_replace(apply_filters('wmac_filter_js_consider_minified', false), '', $jsfilename) === $jsfilename)
				) {
					$tmp_jscode = trim(WMAC\JSMin::minify($jsin));
					if( !empty($tmp_jscode) ) {
						$scriptsrc = $tmp_jscode;
						unset($tmp_jscode);
					} else {
						$scriptsrc = $jsin;
					}
				} else {
					// Removing comments, linebreaks and stuff!
					$scriptsrc = preg_replace('#^\s*\/\/.*$#Um', '', $jsin);
					$scriptsrc = preg_replace('#^\s*\/\*[^!].*\*\/\s?#Us', '', $scriptsrc);
					$scriptsrc = preg_replace("#(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+#", "\n", $scriptsrc);
				}

				$last_char = substr($scriptsrc, -1, 1);
				if( ';' !== $last_char && '}' !== $last_char ) {
					$scriptsrc .= ';';
				}

				if( !empty($jsfilename) && str_replace(apply_filters('wmac_filter_js_speedup_cache', false), '', $jsfilename) === $jsfilename
				) {
					// Don't cache inline CSS or if filter says no!
					$ccheck->cache($scriptsrc, 'text/javascript');
				}
			}
			unset($ccheck);

			return $scriptsrc;
		}

		/**
		 * JS cleanup
		 *
		 * @param $jsin
		 *
		 * @return string
		 */
		public function jsCleanup($jsin)
		{
			return trim($jsin);
		}

		/**
		 * Notice
		 */
		public static function noticeCacheUnavailable()
		{
			echo '<div class="error"><p>';
			// Translators: %s is the cache directory location.
			printf(__('Мinify And Combine cannot write to the cache directory (%s), please fix to enable CSS/ JS optimization!', 'minify-and-combine'), WMAC_PluginCache::getCacheDir());
			echo '</p></div>';
		}

		/**
		 * Get site url
		 *
		 * @return string
		 */
		public static function getSiteUrl()
		{
			if( function_exists('domain_mapping_siteurl') ) {
				return domain_mapping_siteurl(get_current_blog_id());
			} else {
				return site_url();
			}
		}

		/**
		 * Get content url
		 *
		 * @return string
		 */
		public static function getContentUrl()
		{
			if( function_exists('get_original_url') ) {
				$site_url = self::getSiteUrl();

				return str_replace(get_original_url($site_url), $site_url, content_url());
			} else {
				return content_url();
			}
		}
	}
