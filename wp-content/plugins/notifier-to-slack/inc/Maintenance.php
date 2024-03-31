<?php
/**
 * Admin Chat Box Activator
 *
 * This class is used to builds all of the tables when the plugin is activated
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use WPNTS\Inc\nts_fs;
use WPNTS\Inc\Activate;
use WPNTS\Inc\Deactivate;
use WPNTS\Inc\SlackAttachment;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Admin dashboard created
 *
 * @since 1.0.0
 */
class Maintenance {


	private $lastLoggedTimestamp;

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$schedules_int = get_option('wpnts_schedules_maintenannotice_settings');
		$schedules_interval = json_decode($schedules_int);
		$maintenance_mode = $schedules_interval->maintenance_mode ?? 'false';

		// Sales Notifications to Slack.
		if ( true === $maintenance_mode ) {
			// Add action hook
			add_action('wp', [ $this, 'wpnts_enforce_maintenance_mode' ]);
		}
	}


	private function is_maintenance_mode_enabled() {
		$schedules_int = get_option('wpnts_schedules_maintenannotice_settings');
		$schedules_interval = json_decode($schedules_int);
		$maintenance_mode = $schedules_interval->maintenance_mode ?? 'false';

		return $maintenance_mode;
	}



	/**
	 * WordPress sales notification.
	 *
	 * @since 1.0.0
	 */

	public function wpnts_enforce_maintenance_mode() {

		if ( $this->is_maintenance_mode_enabled() && ! current_user_can('manage_options') ) {
			// wp_die('This site is currently in maintenance mode. Please check back later.');

			$maintenance_template_path = WP_NOTIFIER_TO_SLACK_DIR_PATH . 'templates/maintenance-mode-template.php';

			if ( file_exists($maintenance_template_path) ) {
				// Use the custom maintenance mode template from the plugin
				include $maintenance_template_path;
				exit();
			} else {
				// If the template file is not found, show a default message
				wp_die('Maintenance mode template not found. Please check your plugin setup.');
			}
		}
	}
}
