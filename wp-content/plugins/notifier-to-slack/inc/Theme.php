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
use WPNTS\Inc\Database\DB;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Update used to rest route created
 *
 * @since 1.0.0
 */
class Theme {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$wpnts_db_instance = new DB();
		$is_active = $wpnts_db_instance->is_pro_active();
		$schedules_int = get_option( 'wpntswebhook_theme_settings');
		$schedules_interval = json_decode($schedules_int);

		$themeactivation = $schedules_interval->themeactivation ?? 'false';
		$themedeletion = $schedules_interval->themedeletion ?? 'false';
		$themeupdate = $schedules_interval->themeupdate ?? 'false';
		$generalsettingspage = $schedules_interval->generalsettingspage ?? 'false';

		// Hook into theme activation
		if ( true === $themeactivation ) {
			add_action('switch_theme', [ $this, 'wpnts_theme_activated' ], 10, 2);
		}

		 // Hook into the theme update process who updated the theme
		if ( true === $themeupdate ) {
			add_action('admin_init', [ $this, 'check_newly_installed_themes' ]);
		}

		// Hook into theme deletion
		if ( true === $themedeletion ) {
			add_action('delete_theme', [ $this, 'wpnts_theme_deleted' ]);
		}

		 // Hook into option updates Settings => General
		if ( true === $generalsettingspage ) {
			add_action('update_option', [ $this, 'wpnts_option_updated' ], 10, 3);
		}
	}

	/**
	 * Theme activation
	 */
	public function wpnts_theme_activated( $new_name, $new_theme ) {
		$activated_by = wp_get_current_user()->display_name;
		$this->wpnts_notify_slack("Theme '{$new_name}' activated by {$activated_by}.", ':art:');
	}

	/**
	 * Theme update
	 */
	public function check_newly_installed_themes() {
		$previously_installed_themes = get_option('previously_installed_themes', []);
		$current_installed_themes = wp_get_themes();

		if ( empty($previously_installed_themes) ) {
			// First time the function is called
			$message = 'Your site has the following themes installed:';
			foreach ( $current_installed_themes as $theme_slug => $theme_info ) {
				$message .= "\n- {$theme_info->get('Name')}";
			}
			$message .= "\nI will send a notification if any new themes are installed.";

			// Send an informational message
			$this->wpnts_notify_slack($message, ':information_source:');
		} else {
			// Detect newly installed themes
			$newly_installed_themes = array_diff_key($current_installed_themes, $previously_installed_themes);

			if ( ! empty($newly_installed_themes) ) {
				foreach ( $newly_installed_themes as $theme_slug => $theme_info ) {
					$installed_by = wp_get_current_user()->display_name;
					$this->wpnts_notify_slack("New theme '{$theme_info->get('Name')}' installed by {$installed_by}.", ':art:');
				}
			}
		}

		// Update the stored list of installed themes
		update_option('previously_installed_themes', $current_installed_themes);
	}



	/**
	 * Theme delete
	 */

	public function wpnts_theme_deleted( $stylesheet ) {
		$deleted_by = wp_get_current_user()->display_name;
		$this->wpnts_notify_slack("Theme '{$stylesheet}' deleted by {$deleted_by}.", ':wastebasket:');

		// Get the stored list of installed themes
		$previously_installed_themes = get_option('previously_installed_themes', []);

		// Remove the deleted theme from the list
		unset($previously_installed_themes[ $stylesheet ]);

		// Update the stored list of installed themes without the deleted theme
		update_option('previously_installed_themes', $previously_installed_themes);
	}



	/**
	 * General Settings page
	 */
	public function wpnts_option_updated( $option, $old_value, $value ) {
		$tracked_options = [ 'blogname', 'blogdescription', 'siteurl', 'home', 'admin_email', 'WPLANG', 'timezone_string', 'date_format', 'time_format' ];

		if ( in_array($option, $tracked_options) ) {
			$updated_by = wp_get_current_user()->display_name;
			$this->wpnts_notify_slack("Option '{$option}' updated by {$updated_by}. Old Value: '{$old_value}', New Value: '{$value}'.", ':gear:');
		}
	}


	/**
	 * Send to Slack
	 */
	private function wpnts_notify_slack( $message, $emoji = '' ) {
		$schedules_int = get_option( 'wpntswebhook_theme_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;
		$slack_webhook_url = $wpnts_webhook;

		$message = $emoji . ' ' . $message;
		$payload = json_encode([ 'text' => $message ]);
		$args = [
			'body'      => $payload,
			'headers'   => [ 'Content-Type' => 'application/json' ],
			'timeout'   => '5',
			'sslverify' => false,
		];
		$response = wp_remote_post($slack_webhook_url, $args);
	}
}
