<?php
/**
 * Ajax plugin check licensing
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Обработчик ajax запросов для проверки, активации, деактивации лицензионного ключа
 *
 * @since 1.4.0
 */
function wbcr_clearfy_check_license() {
	
	check_admin_referer( 'license' );
	
	$action = WCL_Plugin::app()->request->post( 'license_action', false, true );
	$license_key = WCL_Plugin::app()->request->post( 'licensekey', null );
	
	if ( empty( $action ) || ! in_array( $action, array( 'activate', 'deactivate', 'sync', 'unsubscribe' ) ) ) {
		wp_send_json_error( array( 'error_message' => __( 'Licensing action not passed or this action is prohibited!', 'clearfy' ) ) );
		die();
	}
	
	$licensing = WCL_Licensing::instance();
	
	$result = null;
	$success_message = '';
	
	try {
		switch ( $action ) {
			case 'activate':
				if ( empty( $license_key ) || strlen( $license_key ) > 32 ) {
					wp_send_json_error( array( 'error_message' => __( 'License key is empty or license key too long (license key is 32 characters long)', 'clearfy' ) ) );
				} else {
					$licensing->activate( $license_key );
					
					$success_message = __( 'Your license has been successfully activated', 'clearfy' );
				}
				break;
			case 'deactivate':
				$licensing->uninstall();
				$success_message = __( 'The license is deactivated', 'clearfy' );
				break;
			case 'sync':
				$licensing->sync();
				$success_message = __( 'The license has been updated', 'clearfy' );
				break;
			case 'unsubscribe':
				$licensing->unsubscribe();
				$success_message = __( 'Subscription success cancelled', 'clearfy' );
				break;
		}
	} catch( WCL\LicenseException $e ) {
		/**
		 * Экшен выполняет, когда проверка лицензии вернула ошибку
		 *
		 * @param string $action
		 * @param string $license_key
		 *
		 * @since 1.4.0
		 */
		add_action( 'wbcr/clearfy/check_license_error', $action, $license_key );
		
		wp_send_json_error( array( 'error_message' => $e->getMessage(), 'code' => $e->getCode() ) );
	}
	
	/**
	 * Экшен выполняет, когда проверка лицензии успешно завершена
	 *
	 * @param string $action
	 * @param string $license_key
	 *
	 * @since 1.4.0
	 */
	add_action( 'wbcr/clearfy/check_license_success', $action, $license_key );
	
	wp_send_json_success( array( 'message' => $success_message ) );
	
	die();
}

add_action( 'wp_ajax_wbcr-clearfy-check-license', 'wbcr_clearfy_check_license' );

