<?php
/**
 * Admin Chat Box Rest Route
 *
 * This class is used to response and all rest route works
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use \WPNTS\Inc\WPNTS_Activate;
use \WPNTS\Inc\WPNTS_Deactivate;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * WPNTS_Security used to rest route created
 *
 * @since 1.0.0
 */
class WPNTS_Security {

	private $last_modified_times = [];
	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// wpnts_webhook_site_settings
		$wpnts_webhook_site_settings = get_option( 'wpnts_webhook_site_settings');
		$schedules_interval = json_decode($wpnts_webhook_site_settings);
		$intervalDays = $schedules_interval->intervalDays ?? '-2';
		$sitessecurityissuesInterval = $schedules_interval->sitessecurityissuesInterval ?? '150';
		$htaccessmodification = $schedules_interval->htaccessmodification ?? 'false';
		$wpconfigmodification = $schedules_interval->wpconfigmodification ?? 'false';

		if ( true === $htaccessmodification ) {
			add_action( 'wp_loaded', [ $this, 'wpnts_file_monitor_htaccess_file' ], 10, 1 );
		}
		if ( true === $wpconfigmodification ) {
			add_action( 'wp_loaded', [ $this, 'wpnts_file_monitor_config_file' ], 10, 1 );
		}
	}
	/**
	 * Plugin activation notification.
	 *
	 * @since 1.0.0
	 */

	public function wpnts_file_monitor_htaccess_file( $wp_customize ) {
		$htaccess_file = ABSPATH . '.htaccess';

		if ( file_exists( $htaccess_file ) ) {
			$last_modified_time = get_option('htaccess_modified_time');
			if ( empty($last_modified_time) ) {
				$last_modified_time = filemtime($htaccess_file);
				update_option('htaccess_modified_time', $last_modified_time);
			}

			add_action('shutdown', function() use ( $htaccess_file, &$last_modified_time ) {
				if ( file_exists( $htaccess_file ) ) {
					clearstatcache(true, $htaccess_file);
					$current_modified_time = filemtime($htaccess_file);

					if ( $current_modified_time > $last_modified_time ) {

						$message = 'The .htaccess file has been modified- Take action as earliest possible.';

						$schedules_int = get_option( 'wpnts_webhook_site_settings');
						$schedules_interval = json_decode($schedules_int);
						$wpnts_webhook = $schedules_interval->webhook;

						$slack_webhook_url = $wpnts_webhook;

						$payload = json_encode([ 'text' => $message ]);
						$args = [
							'body'        => $payload,
							'headers'     => [ 'Content-Type' => 'application/json' ],
							'timeout'     => '5',
							'sslverify'   => false,
						];
						wp_remote_post($slack_webhook_url, $args);

						// Update the last modified time
						update_option('htaccess_modified_time', $current_modified_time);

					}
				}
			});
		}
	}


	 /**
	  * WP Config file modification alert
	  */

	public function wpnts_file_monitor_config_file( $wp_customize ) {
		$htaccess_file = ABSPATH . 'wp-config.php';

		$last_modified_time = get_option('wp_config_modified_time');
		if ( empty($last_modified_time) ) {
			$last_modified_time = filemtime($htaccess_file);
			update_option('wp_config_modified_time', $last_modified_time);
		}

		add_action('shutdown', function() use ( $htaccess_file, &$last_modified_time ) {
			clearstatcache(true, $htaccess_file);
			$current_modified_time = filemtime($htaccess_file);

			if ( $current_modified_time > $last_modified_time ) {

				$message = 'The wp-config.php file has been modified- Take action as earliest possible.';
				$schedules_int = get_option( 'wpnts_webhook_site_settings');
				$schedules_interval = json_decode($schedules_int);
				$wpnts_webhook = $schedules_interval->webhook;

				$slack_webhook_url = $wpnts_webhook;
				$payload = json_encode([ 'text' => $message ]);
				$args = [
					'body'        => $payload,
					'headers'     => [ 'Content-Type' => 'application/json' ],
					'timeout'     => '5',
					'sslverify'   => false,
				];
				wp_remote_post($slack_webhook_url, $args);

				// Update the last modified time
				update_option('wp_config_modified_time', $current_modified_time);

			}
		});
	}


}