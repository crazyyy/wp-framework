<?php
/**
 * Admin Chat Box Rest Route
 *
 * This class is used to response and all rest route works
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use WPNTS\Inc\nts_fs;
use WPNTS\Inc\Activate;
use WPNTS\Inc\Deactivate;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Update used to rest route created
 *
 * @since 1.0.0
 */
class WPUpdate {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_wpnotification = $schedules_interval->wpnotification ?? 'false';

		add_filter( 'cron_schedules', [ $this, 'wpnts_add_cron_interval' ]);

		if ( true === $wpnts_wpnotification ) {
			add_action( 'wpnts_corn_hook', [ $this, 'wpnts_wordpress_core_update' ]);
		}
	}

	/**
	 * Corn setup time interval.
	 *
	 * @since 1.0.0
	 */
	public function wpnts_add_cron_interval() {

		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);
		// $wpnts_time = $schedules_interval->interval_plugin_update ?? 120;
		$wpnts_time = isset($schedules_interval->interval_plugin_update) ? (int) $schedules_interval->interval_plugin_update : 120;

		$schedules['added_schedules_interval'] = [
			'interval' => isset($wpnts_time) ? $wpnts_time : 30,
			'display'  => esc_html__( 'Assigned Time' ),
		];
		return $schedules;
	}

	/**
	 * WordPress core update.
	 *
	 * @since 1.0.0
	 */
	public function wpnts_wordpress_core_update() {
		require_once ABSPATH . '/wp-admin/includes/update.php';

		$last_updates = get_option( 'wpnts_last_wordpress_core_updates', 3 );
		$current_time = time();

		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);

		// $wpnts_time = isset($schedules_interval->interval_plugin_update) ? (int)$schedules_interval->interval_plugin_update : 120;

		/*
		 if ( isset($schedules_interval->interval_plugin_update) ) {
			$wpnts_time = $schedules_interval->interval_plugin_update ?? 120;
		} */

		$wpnts_time = isset($schedules_interval->interval_plugin_update) ? (int) $schedules_interval->interval_plugin_update : 120;

		$wpnotification = $schedules_interval->wpnotification ?? 'false';

		if ( true === $wpnotification && isset($last_updates) && ( $current_time - $last_updates ) >= $wpnts_time ) {

			$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
			$schedules_interval = json_decode($schedules_int);
			$wpnts_webhook = $schedules_interval->webhook;

			$slack_webhook_url = $wpnts_webhook;

			$wp_version = get_bloginfo( 'version' );
			$core_updates = get_core_updates();

			if ( ! empty( $core_updates ) && version_compare( $wp_version, $core_updates[0]->current, '<' ) ) {

					$message = 'A new WordPress version (' . $core_updates[0]->current . ' -> ' . $core_updates[0]->response . ') is available for update.';
					$payload = json_encode( [ 'text' => $message ] );
					$args = [
						'body'        => $payload,
						'headers'     => [ 'Content-Type' => 'application/json' ],
						'timeout'     => '5',
						'sslverify'   => false,
					];
					wp_remote_post( $slack_webhook_url, $args );

			}

			update_option( 'wpnts_last_wordpress_core_updates', time() );
		}
	}
}
