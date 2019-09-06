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

	function wbcr_clearfy_configurate_plugin()
	{
		check_ajax_referer('wbcr_clearfy_ajax_quick_start_nonce', 'security');

		if( !WCL_Plugin::app()->currentUserCan() ) {
			wp_send_json(array('error' => __('You don\'t have enough capability to edit this information.', 'clearfy')));
		}

		$mode_name = WCL_Plugin::app()->request->post('mode', false, true);
		$flush_redirect = WCL_Plugin::app()->request->post('flush_redirect', false, true);

		if( empty($mode_name) ) {
			wp_send_json(array('error' => __('Undefinded mode.', 'clearfy')));
		}

		if( $mode_name != 'reset' ) {
			$group = WCL_Group::getInstance($mode_name);
			$mode_options = $group->getOptions();

			if( empty($mode_options) ) {
				wp_send_json(array('error' => __('Undefinded mode.', 'clearfy')));
			}

			foreach($mode_options as $option) {
				$set_value = 1;

				$option_name = $option->getName();
				$option_value = $option->getValue($mode_name);

				if( !empty($option_value) ) {
					$set_value = $option_value;
				}

				WCL_Plugin::app()->updatePopulateOption($option_name, $set_value);
			}
		} else {
			$all_options = WCL_Option::getAllOptions();

			if( !empty($all_options) ) {
				foreach($all_options as $option) {
					WCL_Plugin::app()->deletePopulateOption($option->getName());
				}
			}
		}

		if( !$flush_redirect ) {
			WbcrFactoryClearfy206_Helpers::flushPageCache();
		}

		do_action('wbcr_clearfy_configurated_quick_mode', $mode_name);

		// wbcr_clearfy/configurate_quick_mode_success_args
		// @since 1.3.188
		wp_send_json(apply_filters('wbcr_clearfy/configurate_quick_mode_success_args', array(
			'status' => 'success',
			'export_options' => WCL_Helper::getExportOptions()
		), $mode_name));
	}

	add_action('wp_ajax_wbcr_clearfy_configurate', 'wbcr_clearfy_configurate_plugin');

