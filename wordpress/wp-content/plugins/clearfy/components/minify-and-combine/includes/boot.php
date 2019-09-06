<?php
	/**
	 * Global boot
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 01.07.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	function wbcr_mac_clear_cache()
	{
		if( isset($_GET['wbcr_mac_clear_cache']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'clear_all_cache') ) {
			$page = isset($_GET['page']) ? $_GET['page'] : 'minify_and_combine-' . WMAC_Plugin::app()->getPluginName();

			if( is_network_admin() ) {
				WMAC_PluginCache::clearAllMultisite();
				$base_url = network_admin_url('settings.php') . '?page=' . $page;
			} else {
				WMAC_PluginCache::clearAll();
				$base_url = admin_url('options-general.php') . '?page=' . $page;
			}

			wp_safe_redirect(add_query_arg(array('wbcr_mac_clear_cache_success' => 1), $base_url));
		}
	}

	add_action('init', 'wbcr_mac_clear_cache');

	/**
	 * Добавляем кнопку сброса кеша в админ бар
	 *
	 * @param $wp_admin_bar
	 */
	function wbcr_mac_admin_bar_menu($wp_admin_bar)
	{
		if( !current_user_can('manage_options') ) {
			return;
		}
		$current_url = wp_nonce_url(add_query_arg(array('wbcr_mac_clear_cache' => 1)), 'clear_all_cache');
		$percent = '';
		if( !is_network_admin() ) {
			$get_used_cache = WMAC_PluginCache::getUsedCache();
			$percent = ' (' . $get_used_cache['percent'] . '%)';
		}

		$args = array(
			'id' => 'clear-cache-btn',
			'title' => __('Clear cache', 'minify-and-combine') . $percent,
			'href' => $current_url
		);
		$wp_admin_bar->add_menu($args);
	}

	/**
	 * Добавляем кнопку сброса кеша в Clearfy меню
	 */
	function wbcr_mac_clearfy_admin_bar_menu($menu_items)
	{
		$current_url = wp_nonce_url(add_query_arg(array('wbcr_mac_clear_cache' => 1)), 'clear_all_cache');
		$percent = '';
		if( !is_network_admin() ) {
			$get_used_cache = WMAC_PluginCache::getUsedCache();
			$percent = ' (' . $get_used_cache['percent'] . '%)';
		}

		$menu_items['mac-clear-cache'] = array(
			'title' => '<span class="dashicons dashicons-image-rotate"></span> ' . __('Clear cache', 'minify-and-combine') . $percent,
			'href' => $current_url
		);

		return $menu_items;
	}

	if( defined('LOADING_MINIFY_AND_COMBINE_AS_ADDON') ) {
		add_action('wbcr/clearfy/adminbar_menu_items', 'wbcr_mac_clearfy_admin_bar_menu');
	} else {
		add_action('admin_bar_menu', 'wbcr_mac_admin_bar_menu');
	}