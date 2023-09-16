<?php

/*
Plugin Name: Error Notify Slack
Description: Send WP errors to Slack channel
Version: 1
Author: zenithtech
Author URI: https://github.com/zenithtech
Text Domain: error-notify-slack
*/

/**
 * @copyright Copyright (c) 2017. All rights reserved.
 *
 * @license   Released under the GPL license http://www.opensource.org/licenses/gpl-license.php
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 *
 */

if(!function_exists('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

define( 'ERROR_NOTIFY_SLACK_VERSION', '1' );

if( ! class_exists( 'Error_Notify_Slack' ) ) {

	final class Error_Notify_Slack {

		/** Singleton *************************************************************/

		/**
		 * @var Error_Notify_Slack
		 * @since 1.0
		 */
		private static $instance;


		/**
		 * Main Error_Notify_Slack Instance
		 *
		 * Insures that only one instance of Error_Notify_Slack exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0
		 * @static
		 * @staticvar array $instance
		 * @return Error_Notify_Slack
		 */

		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Error_Notify_Slack ) ) {

				self::$instance = new Error_Notify_Slack;
				self::$instance->setup_constants();
				self::$instance->includes();

			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @access protected
		 * @return void
		 */

		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'error-notify-slack' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @access protected
		 * @return void
		 */

		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'error-notify-slack' ), '1.0' );
		}

		/**
		 * Setup plugin constants
		 *
		 * @access private
		 * @return void
		 */

		private function setup_constants() {

			if(!defined('ERROR_NOTIFY_SLACK_DIR_PATH')) {
				define('ERROR_NOTIFY_SLACK_DIR_PATH', plugin_dir_path(__FILE__));
			}

			if(!defined('ERROR_NOTIFY_SLACK_PLUGIN_PATH')) {
				define('ERROR_NOTIFY_SLACK_PLUGIN_PATH', plugin_basename(__FILE__));
			}

			if(!defined('ERROR_NOTIFY_SLACK_DIR_URL')) {
				define('ERROR_NOTIFY_SLACK_DIR_URL', plugin_dir_url(__FILE__));
			}

		}

		/**
		 * Include required files
		 *
		 * @access private
		 * @return void
		 */

		private function includes() {

			require_once ERROR_NOTIFY_SLACK_DIR_PATH .'includes/admin/class-admin.php';
			require_once ERROR_NOTIFY_SLACK_DIR_PATH .'includes/class-public.php';

		}

		/**
		 * Map error code to error string
		 *
		 * @return void
		*/

		public function map_error_code_to_type( $code ) {

			switch($code) { 
			    case E_ERROR: // 1 // 
			        return 'E_ERROR'; 
			    case E_WARNING: // 2 // 
			        return 'E_WARNING'; 
			    case E_PARSE: // 4 // 
			        return 'E_PARSE'; 
			    case E_NOTICE: // 8 // 
			        return 'E_NOTICE'; 
			    case E_CORE_ERROR: // 16 // 
			        return 'E_CORE_ERROR'; 
			    case E_CORE_WARNING: // 32 // 
			        return 'E_CORE_WARNING'; 
			    case E_COMPILE_ERROR: // 64 // 
			        return 'E_COMPILE_ERROR'; 
			    case E_COMPILE_WARNING: // 128 // 
			        return 'E_COMPILE_WARNING'; 
			    case E_USER_ERROR: // 256 // 
			        return 'E_USER_ERROR'; 
			    case E_USER_WARNING: // 512 // 
			        return 'E_USER_WARNING'; 
			    case E_USER_NOTICE: // 1024 // 
			        return 'E_USER_NOTICE'; 
			    case E_STRICT: // 2048 // 
			        return 'E_STRICT'; 
			    case E_RECOVERABLE_ERROR: // 4096 // 
			        return 'E_RECOVERABLE_ERROR'; 
			    case E_DEPRECATED: // 8192 // 
			        return 'E_DEPRECATED'; 
			    case E_USER_DEPRECATED: // 16384 // 
			        return 'E_USER_DEPRECATED'; 
			} 

		}


	}

}

function error_notify_slack() {
	return Error_Notify_Slack::instance();
}

error_notify_slack();

?>
