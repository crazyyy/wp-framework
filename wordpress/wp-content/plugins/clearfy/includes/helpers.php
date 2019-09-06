<?php

	/**
	 * Helpers functions
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2017 Webraftic Ltd
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WCL_Helper {

		/**
		 * Allows you to get the base path to the plugin in the directory wp-content/plugins/
		 *
		 * @param $slug - slug for example "clearfy", "hide-login-page"
		 * @return int|null|string - "clearfy/clearfy.php"
		 */
		public static function getPluginBasePathBySlug($slug)
		{
			// Check if the function get_plugins() is registered. It is necessary for the front-end
			// usually get_plugins() only works in the admin panel.
			if( !function_exists('get_plugins') ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugins = get_plugins();

			foreach($plugins as $base_path => $plugin) {
				if( strpos($base_path, rtrim(trim($slug))) !== false ) {
					return $base_path;
				}
			}

			return null;
		}

		/**
		 * Static method will check whether the plugin is activated or not. You can check whether the plugin exists
		 * by using its slug or the base path.
		 *
		 * @param string $slug - slug for example "clearfy", "hide-login-page" or base path "clearfy/clearfy.php"
		 * @return bool
		 */
		public static function isPluginActivated($slug)
		{
			if( strpos(rtrim(trim($slug)), '/') === false ) {
				$plugin_base_path = self::getPluginBasePathBySlug($slug);

				if( empty($plugin_base_path) ) {
					return false;
				}
			} else {
				$plugin_base_path = $slug;
			}

			require_once ABSPATH . '/wp-admin/includes/plugin.php';

			return is_plugin_active($plugin_base_path);
		}

		/**
		 * Static method will check whether the plugin is installed or not. You can check whether the plugin exists
		 * by using its slug or the base path.
		 *
		 * @param string $slug - slug "clearfy" or base_path "clearfy/clearfy.php"
		 * @return bool
		 */
		public static function isPluginInstalled($slug)
		{
			if( strpos(rtrim(trim($slug)), '/') === false ) {
				$plugin_base_path = self::getPluginBasePathBySlug($slug);

				if( !empty($plugin_base_path) ) {
					return true;
				}
			} else {

				// Check if the function get_plugins() is registered. It is necessary for the front-end
				// usually get_plugins() only works in the admin panel.
				if( !function_exists('get_plugins') ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}

				$plugins = get_plugins();

				if( isset($plugins[$slug]) ) {
					return true;
				}
			}

			return false;
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
		 * Получает и возвращает все опции разрешенные для экспорта
		 *
		 * @param string $return
		 * @return array|string
		 */
		public static function getExportOptions($return = 'json')
		{
			global $wpdb;

			$export_options = array();

			$options = WCL_Option::getAllOptions();

			$allow_export_options = array();

			foreach((array)$options as $option_class) {
				$option_name = $option_class->getName();
				$allow_export_options[] = WCL_Plugin::app()->getOptionName($option_name);
			}

			if( WCL_Plugin::app()->isNetworkActive() ) {
				$network_id = get_current_network_id();

				$request = $wpdb->get_results($wpdb->prepare("
					SELECT meta_key, meta_value
					FROM {$wpdb->sitemeta}
					WHERE site_id = '%d' AND meta_key
					LIKE '%s'", $network_id, WCL_Plugin::app()->getPrefix() . "%"));
			} else {
				$request = $wpdb->get_results($wpdb->prepare("
					SELECT option_name, option_value
					FROM {$wpdb->options}
					WHERE option_name
					LIKE '%s'", WCL_Plugin::app()->getPrefix() . "_%"));
			}

			if( !empty($request) && !empty($allow_export_options) ) {
				foreach($request as $option) {
					if( WCL_Plugin::app()->isNetworkActive() ) {
						$option_name = $option->meta_key;
						$option_value = $option->meta_value;
					} else {
						$option_name = $option->option_name;
						$option_value = $option->option_value;
					}
					if( in_array($option_name, $allow_export_options) ) {
						$export_options[$option_name] = $option_value;
					}
				}
			}

			if( $return == 'array' ) {
				return $export_options;
			}

			return WCL_Helper::getEscapeJson($export_options);
		}

		/**
		 * Try to get variable from JSON-encoded post variable
		 *
		 * Note: we pass some params via json-encoded variables, as via pure post some data (ex empty array) will be absent
		 *
		 * @param string $name $_POST's variable name
		 *
		 * @return array
		 */
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

		/**
		 * Escape json data
		 * @param  array $data
		 * @return string escaped json string
		 */
		public static function getEscapeJson(array $data)
		{
			return htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
		}

		/**
		 * Componate content for robot.txt
		 * @return string
		 */
		public static function getRightRobotTxt()
		{
			$cache_output = WCL_Plugin::app()->getPopulateOption('robots_txt_text_cache');

			if( $cache_output ) {
				return $cache_output;
			}
			
			$site_url = get_home_url();
			$dir_host = preg_replace("(^https?://)", "", $site_url);

			if( is_ssl() ) {
				$dir_host = 'https://' . $dir_host;
			}

			$file_path = WCL_PLUGIN_DIR . '/templates/robots.txt';
			$file = fopen($file_path, 'r');
			$robot_default_content = fread($file, filesize($file_path));
			fclose($file);

			$output = $robot_default_content;
			$output .= 'Host: ' . $dir_host . PHP_EOL;

			$headers = @get_headers($site_url . '/sitemap.xml', 1);

			if( strpos($headers[0], '200 OK') !== false ) {
				$output .= 'Sitemap: ' . $site_url . '/sitemap.xml' . PHP_EOL;
			} else if( isset($headers['Location']) && !empty($headers['Location']) ) {
				$output .= 'Sitemap: ' . $headers['Location'] . PHP_EOL;
			}

			WCL_Plugin::app()->updatePopulateOption('robots_txt_text_cache', $output);

			return $output;
		}
	}
