<?php
/**
 * Restore notice
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

function wbcr_dan_ajax_restore_notice() {
	check_ajax_referer( WDN_Plugin::app()->getPluginName() . '_ajax_restore_notice_nonce', 'security' );

	if ( current_user_can( 'manage_options' ) || current_user_can( 'manage_network' ) ) {
		$notice_id = WDN_Plugin::app()->request->post( 'notice_id', null, true );

		if ( empty( $notice_id ) ) {
			wp_send_json_error( [ 'error_message' => __( 'Undefinded notice id.', 'disable-admin-notices' ) ] );
		}

		//Users notices
		$current_user_id    = get_current_user_id();
		$get_hidden_notices = get_user_meta( $current_user_id, WDN_Plugin::app()->getOptionName( 'hidden_notices' ), true );
		if ( ! empty( $get_hidden_notices ) && isset( $get_hidden_notices[ $notice_id ] ) ) {
			unset( $get_hidden_notices[ $notice_id ] );
			update_user_meta( $current_user_id, WDN_Plugin::app()->getOptionName( 'hidden_notices' ), $get_hidden_notices );
		}

		//All notices
		$get_hidden_notices_all = WDN_Plugin::app()->getPopulateOption( 'hidden_notices', [] );
		if ( ! empty( $get_hidden_notices_all ) && isset( $get_hidden_notices_all[ $notice_id ] ) ) {
			unset( $get_hidden_notices_all[ $notice_id ] );
			WDN_Plugin::app()->updatePopulateOption( 'hidden_notices', $get_hidden_notices_all );
		}


		wp_send_json_success();
	} else {
		wp_send_json_error( [ 'error_message' => __( 'You don\'t have enough capability to edit this information.', 'disable-admin-notices' ) ] );
	}
}

add_action( 'wp_ajax_wbcr-dan-restore-notice', 'wbcr_dan_ajax_restore_notice' );
