<?php
/**
 * Hides notifications
 *
 * Github: https://github.com/alexkovalevv
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wbcr_dan_ajax_hide_notices() {
	check_ajax_referer( WDN_Plugin::app()->getPluginName() . '_ajax_hide_notices_nonce', 'security' );

	if ( current_user_can( 'manage_options' ) || current_user_can( 'manage_network' ) ) {
		$notice_id   = WDN_Plugin::app()->request->post( 'notice_id', null, true );
		$notice_html = WDN_Plugin::app()->request->post( 'notice_html', null );
		$hide_target = WDN_Plugin::app()->request->post( 'target', 'user' );
		//$notice_text = wp_kses( $notice_html, [] );

		if ( empty( $notice_id ) ) {
			wp_send_json_error( [ 'error_message' => __( 'Undefinded notice id.', 'disable-admin-notices' ) ] );
		}

		switch ( $hide_target ) {
			case 'all':
				$get_hidden_notices = WDN_Plugin::app()->getPopulateOption( 'hidden_notices', [] );

				if ( ! is_array( $get_hidden_notices ) ) {
					$get_hidden_notices = [];
				}

				$get_hidden_notices[ $notice_id ] = rtrim( trim( $notice_html ) );

				WDN_Plugin::app()->updatePopulateOption( 'hidden_notices', $get_hidden_notices );
				break;
			case 'user':
			default:
				$current_user_id    = get_current_user_id();
				$get_hidden_notices = get_user_meta( $current_user_id, WDN_Plugin::app()->getOptionName( 'hidden_notices' ), true );

				if ( ! is_array( $get_hidden_notices ) ) {
					$get_hidden_notices = [];
				}

				$get_hidden_notices[ $notice_id ] = rtrim( trim( $notice_html ) );

				update_user_meta( $current_user_id, WDN_Plugin::app()->getOptionName( 'hidden_notices' ), $get_hidden_notices );
				break;
		}

		wp_send_json_success();
	} else {
		wp_send_json_error( [ 'error_message' => __( 'You don\'t have enough capability to edit this information.', 'disable-admin-notices' ) ] );
	}
}

add_action( 'wp_ajax_wbcr-dan-hide-notices', 'wbcr_dan_ajax_hide_notices' );
