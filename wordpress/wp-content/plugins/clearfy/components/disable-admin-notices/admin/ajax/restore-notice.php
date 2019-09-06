<?php
	/**
	 * Restore notice
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 12.01.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	function wbcr_dan_ajax_restore_notice()
	{
		check_ajax_referer(WDN_Plugin::app()->getPluginName() . '_ajax_restore_notice_nonce', 'security');

		if( current_user_can('manage_options') || current_user_can('manage_network') ) {
			$notice_id = WDN_Plugin::app()->request->post('notice_id', null, true);

			if( empty($notice_id) ) {
				wp_send_json_error(array('error_message' => __('Undefinded notice id.', 'disable-admin-notices')));
			}

			$current_user_id = get_current_user_id();
			$get_hidden_notices = get_user_meta($current_user_id, WDN_Plugin::app()->getOptionName('hidden_notices'), true);

			if( !empty($get_hidden_notices) && isset($get_hidden_notices[$notice_id]) ) {
				unset($get_hidden_notices[$notice_id]);
			}

			update_user_meta($current_user_id, WDN_Plugin::app()->getOptionName('hidden_notices'), $get_hidden_notices);

			wp_send_json_success();
		} else {
			wp_send_json_error(array('error_message' => __('You don\'t have enough capability to edit this information.', 'disable-admin-notices')));
		}
	}

	add_action('wp_ajax_wbcr-dan-restore-notice', 'wbcr_dan_ajax_restore_notice');
