<?php
	/**
	 * Ajax plugin configuration
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2017 Webraftic Ltd
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * Ajax действите, выполняется для получения всех доступных опций для экспорта.
	 */
	function wbcr_clearfy_import_settings()
	{
		global $wpdb;

		check_ajax_referer('wbcr_clearfy_import_options');

		if( !WCL_Plugin::app()->currentUserCan() ) {
			wp_send_json_error(array('error_message' => __('You don\'t have enough capability to edit this information.', 'clearfy')));
			die();
		}

		$settings = WCL_Helper::maybeGetPostJson('settings');

		/**
		 * Используется для фильтрации импортируемых настроек,
		 * обычно это может пригодиться для компонентов, которым нужно выполнить дополнительные дествия к опциям,
		 * прежде чем продолжить импорт
		 *
		 * wbcr/clearfy/filter_import_options
		 * @since 1.4.0
		 */
		$settings = apply_filters('wbcr/clearfy/filter_import_options', $settings);

		$network_id = get_current_network_id();

		if( empty($settings) || !is_array($settings) ) {
			wp_send_json_error(array('error_message' => __('Settings are not defined or do not exist.', 'clearfy')));
			die();
		}

		$values = array();
		$place_holders = array();

		if( WCL_Plugin::app()->isNetworkActive() ) {
			$query = "INSERT INTO {$wpdb->sitemeta} (site_id, meta_key, meta_value) VALUES ";
		} else {
			$query = "INSERT INTO {$wpdb->options} (option_name, option_value) VALUES ";
		}

		foreach($settings as $option_name => $option_value) {
			$option_name = sanitize_text_field($option_name);
			$raw_option_value = $option_value;

			if( is_serialized($option_value) ) {
				$option_value = unserialize($option_value);
			}

			if( is_array($option_value) || is_object($option_value) ) {
				$option_value = WbcrFactoryClearfy206_Helpers::recursiveSanitizeArray($option_value, 'wp_kses_post');
				$option_value = maybe_serialize($option_value);
			} else {
				$option_value = wp_kses_post($option_value);
			}

			/**
			 * Используется для фильтрации импортируемых значений,
			 * обычно это может пригодиться для компонентов, которым нужно подменять домены, пути или какие-то правила
			 * при переносе с одного сайта на другой
			 *
			 * wbcr/clearfy/filter_import_values
			 * @since 1.4.0
			 */
			$option_value = apply_filters('wbcr/clearfy/filter_import_values', $option_value, $option_name, $raw_option_value);

			// todo: Вынести в отдельный файл и привязать к хуку
			if( WCL_Plugin::app()->getOptionName('robots_txt_text') == $option_name ) {
				$site_url = get_home_url();
				$dir_host_without_scheme = preg_replace("(^https?://)", "", $site_url);
				$dir_host = $dir_host_without_scheme;

				if( is_ssl() ) {
					$dir_host = 'https://' . $dir_host_without_scheme;
				}

				$replace_host_value = preg_replace('/(Host:\s?)(.*)/', '$1' . $dir_host, $option_value);

				if( !empty($replace_host_value) ) {
					$option_value = $replace_host_value;
				}

				if( preg_match('/Sitemap:\s?(.*)/', $option_value, $matches) ) {
					$site_map_url = $matches[1];

					if( filter_var($site_map_url, FILTER_VALIDATE_URL) ) {
						$url_parts = parse_url($site_map_url);
						$replace_sitemap_value = preg_replace('/(Sitemap:\s?)(.*)/', '$1' . $url_parts['scheme'] . '://' . $dir_host_without_scheme . $url_parts['path'] . PHP_EOL, $option_value);

						if( !empty($replace_sitemap_value) ) {
							$option_value = $replace_sitemap_value;
						}
					}
				}
			}

			if( WCL_Plugin::app()->isNetworkActive() ) {
				array_push($values, $network_id, $option_name, $option_value);
				$place_holders[] = "('%d', '%s', '%s')";/* In my case, i know they will always be integers */
			} else {
				array_push($values, $option_name, $option_value);
				$place_holders[] = "('%s', '%s')";/* In my case, i know they will always be integers */
			}
		}

		$query .= implode(', ', $place_holders);

		// Удаляем все опции
		$all_options = WCL_Option::getAllOptions();

		if( !empty($all_options) ) {
			foreach($all_options as $option) {
				WCL_Plugin::app()->deletePopulateOption($option->getName());
			}
		}

		// Сбрасываем кеш опций
		WCL_Plugin::app()->flushOptionsCache();

		// Импортируем опции
		$wpdb->query($wpdb->prepare("$query ", $values));

		$send_data = array('status' => 'success');
		
		$package_plugin = WCL_Package::instance();
		$send_data['update_notice'] = $package_plugin->getUpdateNotice();

		// Сбрасываем кеш для кеширующих плагинов
		WbcrFactoryClearfy206_Helpers::flushPageCache();

		do_action('wbcr_clearfy_imported_settings');

		wp_send_json_success($send_data);
		die();
	}

	add_action('wp_ajax_wbcr-clearfy-import-settings', 'wbcr_clearfy_import_settings');

