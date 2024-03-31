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
use WPNTS\Inc\SlackAttachment;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Notify used to rest route created
 *
 * @since 1.0.0
 */
class Notify {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$wpnts_db_instance = new DB();
		$is_active = $wpnts_db_instance->is_pro_active();
		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_pluginactivation = $schedules_interval->pluginactivation ?? 'false';
		$wpnts_plugindeactivation = $schedules_interval->plugindeactivation ?? 'false';
		$wpnts_loginandout = $schedules_interval->loginandout ?? 'false';
		$wpnts_sitehelgth = $schedules_interval->sitehelgth ?? 'false';
		$wpnts_registration = $schedules_interval->registration ?? 'false';
		$rolechangenotification = $schedules_interval->rolechangenotification ?? 'false';
		$lostpassreset = $schedules_interval->lostpassreset ?? 'false';
		$accountpassreset = $schedules_interval->accountpassreset ?? 'false';

		// Action hook for plugin activated.
		if ( true === $wpnts_pluginactivation ) {
			add_action( 'activated_plugin', [ $this, 'wpnts_plugin_activation' ], 10, 2 );
		}

		// Action hook for plugin deactivation.
		if ( true === $wpnts_plugindeactivation ) {
			add_action( 'deactivated_plugin', [ $this, 'wpnts_plugin_deactivated' ], 10, 2 );
		}

		// Site Helgth.
		if ( true === $wpnts_sitehelgth ) {
			 add_action( 'wpnts_corn_hook', [ $this, 'wpnts_site_health_status_notification' ] );
		}

		// Login and Logout.
		if ( true === $wpnts_loginandout ) {
			add_action( 'wp_login',[ $this, 'wpnts_user_activity_notification_login' ], 10, 2 );
			add_action( 'wp_login',[ $this, 'wpnts_user_login_total_count' ], 10, 2 );

			add_action( 'wp_logout',[ $this, 'wpnts_user_activity_notification_logout' ] );
			add_action('wp_login_failed', array( $this, 'wpnts_user_track_failed_login' ));

		}
		// New registration.
		if ( true === $wpnts_registration ) {
			add_action( 'user_register',[ $this, 'wpnts_new_user_notification' ], 10, 1 );
		}
	}

	/**
	 * Plugin activation notification.
	 *
	 * @since 1.0.0
	 */

	public function wpnts_plugin_activation( $plugin, $network_wide ) {
		$current_user = wp_get_current_user();
		$current_user_name = $current_user->display_name;

		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings' );
		$schedules_interval = json_decode( $schedules_int );
		$wpnts_webhook = $schedules_interval->webhook;
		$authorPaneltoMail = $schedules_interval->authorPaneltoMail ?? false;

		$slack_webhook_url = $wpnts_webhook;

		$message = ':face_with_peeking_eye: Plugin ' . $plugin . ' has been *activated* by :arrow_right: ' . $current_user_name;
		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );

		// Send In Mail
		if ( $authorPaneltoMail === true ) {
			$this->sendEmailNotificationPluginActiveDeactive($plugin, $current_user_name, 'activated');
		}
		// END

		// Update for Dashboard.
		$activated_plugins = get_option( 'wpnts_activated_plugins', [] );
		$current_time = current_time( 'timestamp', false );

		// Check if more than 24 hours have passed since the last update.
		if ( empty( $activated_plugins ) || ( $current_time - $activated_plugins['last_updated'] ) >= 86400 ) {
			// Reset the entire array if 24 hours have passed.
			$activated_plugins = [
				'plugins'      => [],
				'last_updated' => $current_time,
			];
		}

		$plugin_key = $plugin . ' by ' . $current_user_name;

		if ( ! in_array( $plugin_key, $activated_plugins['plugins'] ) ) {
			$activated_plugins['plugins'][] = $plugin_key;
			$activated_plugins['last_updated'] = $current_time;
		}

		// Update the option in the database.
		update_option( 'wpnts_activated_plugins', $activated_plugins );
	}


	/**
	 * Plugin deactive notification.
	 */
	public function wpnts_plugin_deactivated( $plugin, $network_deactivating ) {

		$current_user = wp_get_current_user();
		$current_user_name = $current_user->display_name;

		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;
		$authorPaneltoMail = $schedules_interval->authorPaneltoMail ?? false;

		$slack_webhook_url = $wpnts_webhook;

		$message = ':face_with_raised_eyebrow: Plugin ' . $plugin . ' has been *deactivated* by :arrow_right: ' . $current_user_name;
		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );

		// Send In Mail
		if ( $authorPaneltoMail === true ) {
			// Send email notification.
			$this->sendEmailNotificationPluginActiveDeactive($plugin, $current_user_name, 'deactivated');
		}
		// END

		// Update for Dashboard.
		$deactivated_plugins = get_option( 'wpnts_deactivated_plugins', [] );
		$current_time = current_time( 'timestamp', false );

		// Check if more than 24 hours have passed since the last update.
		if ( empty( $deactivated_plugins ) || ( $current_time - $deactivated_plugins['last_updated'] ) >= 86400 ) {
			// Reset the entire array if 24 hours have passed.
			$deactivated_plugins = [
				'plugins'      => [],
				'last_updated' => $current_time,
			];
		}

		$plugin_key = $plugin . ' by ' . $current_user_name;

		if ( ! in_array( $plugin_key, $deactivated_plugins['plugins'] ) ) {
			$deactivated_plugins['plugins'][] = $plugin_key;
			$deactivated_plugins['last_updated'] = $current_time;
		}

		// Update the option in the database.
		update_option( 'wpnts_deactivated_plugins', $deactivated_plugins );
	}

	/**
	 * Plugin active and deactive mail notification
	 */
	private function sendEmailNotificationPluginActiveDeactive( $plugin, $current_user_name, $action ) {
		$global_api_settings = get_option('wpnts_global_api_settings');
		$wpnts_global_api = json_decode($global_api_settings);

		$mailconfig = $wpnts_global_api->mailconfig ?? false;
		$recipiantmail = $wpnts_global_api->recipiantmail ?? '';

		$attachmentHandler = new SlackAttachment();

		// Check if mail configuration is enabled and recipient email is not empty
		if ( $mailconfig === true && ! empty($recipiantmail) ) {

			$email_message = 'Plugin ' . esc_html($plugin) . " has been $action by 👉 " . esc_html($current_user_name);
			$subject = "Plugin $action Notification";
			$attachmentHandler->sendEmailNotification($recipiantmail, $subject, $email_message);

		}
	}



	/**
	 * Site Health notification
	 */
	public function wpnts_site_health_status_notification() {

		$last_updates = get_option( 'wpnts_last_sitestatus_updates' );
		$current_time = time();

		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);

		// $wpnts_time = $schedules_interval->interval_sitehelgth_update ?? 10;
		$wpnts_time = isset($schedules_interval->interval_sitehelgth_update) ? (int) $schedules_interval->interval_sitehelgth_update : 10;

		$wpnts_webhook = $schedules_interval->webhook;
		$sitehelgth = $schedules_interval->sitehelgth ?? 'false';
		$authorPaneltoMail = $schedules_interval->authorPaneltoMail ?? false;

		if ( true === $sitehelgth && isset($last_updates) && ( $current_time - $last_updates ) >= $wpnts_time ) {

			$slack_webhook_url = $wpnts_webhook;

			$site_status_transient = get_transient( 'health-check-site-status-result' );
			$site_status = json_decode( $site_status_transient, true );

			// print_r($site_status);

			// Format the site health status as a string
			$status_message = ':fire: Site Health Status: Good=' . $site_status['good'] . ', Recommended=' . $site_status['recommended'] . ', Critical=' . $site_status['critical'] . "\n";
			$status_message .= ':arrow_right: ' . '<' . get_bloginfo('url') . '/wp-admin/site-health.php|View details>';

			$payload = json_encode( [ 'text' => $status_message ] );
			$args = [
				'body'        => $payload,
				'headers'     => [ 'Content-Type' => 'application/json' ],
				'timeout'     => '5',
				'sslverify'   => false,
			];
			$response = wp_remote_post( $slack_webhook_url, $args );

			// Send In Mail
			if ( $authorPaneltoMail === true ) {
				// Send email notification.
				$this->sendEmailNotificationSiteHelgth($site_status['good'], $site_status['recommended'], $site_status['critical'], get_bloginfo('url') );
			}

			update_option( 'wpnts_last_sitestatus_updates', time() );
		}
	}


	private function sendEmailNotificationSiteHelgth( $good, $recommended, $critical, $blogURL ) {
		$global_api_settings = get_option('wpnts_global_api_settings');
		$wpnts_global_api = json_decode($global_api_settings);

		$mailconfig = $wpnts_global_api->mailconfig ?? false;
		$recipiantmail = $wpnts_global_api->recipiantmail ?? '';

		$attachmentHandler = new SlackAttachment();

		// Check if mail configuration is enabled and recipient email is not empty
		if ( $mailconfig === true && ! empty($recipiantmail) ) {

			$viewDetailsLink = '<a href="' . esc_url($blogURL . '/wp-admin/site-health.php') . '">View details</a>';
			$status_message = 'Site Health Status: Good=' . $good . ', Recommended=' . $recommended . ', Critical=' . $critical . "\n";
			$status_message .= '👉 ' . $viewDetailsLink;

			$subject = 'Site Health Status';
			$attachmentHandler->sendEmailNotification($recipiantmail, $subject, $status_message);

		}
	}


	/**
	 * Login and logout
	 */

	public function wpnts_user_activity_notification_login( $user_login, $user ) {
		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings' );
		$schedules_interval = json_decode( $schedules_int );
		$wpnts_webhook = $schedules_interval->webhook;

		$authorPaneltoMail = $schedules_interval->authorPaneltoMail ?? false;

		$slack_webhook_url = $wpnts_webhook;

		$message = ":yawning_face: User $user_login has logged in.";
		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'      => $payload,
			'headers'   => [ 'Content-Type' => 'application/json' ],
			'timeout'   => '5',
			'sslverify' => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );

		if ( $authorPaneltoMail === true ) {
			// Send email notification.
			$this->sendEmailNotificationSigninout('Login Notification', "User 👉 $user_login has logged in.");
		}

		session_start();
		$_SESSION['wpnts_user_display_name'] = $user->display_name;

		// Add user login information to option table
		$user_login_info = get_option( 'wpnts_user_login_info', [] );
		$current_time = current_time( 'timestamp', false );

		// Remove users from the login info array if 24 hours have passed since their login
		foreach ( $user_login_info as $key => $login ) {
			if ( ( $current_time - $login['timestamp'] ) >= 86400 ) {
				unset( $user_login_info[ $key ] );
			}
		}

		// Add the new login information
		$user_login_info[] = [
			'user'      => $user_login,
			'action'    => 'login',
			'timestamp' => $current_time,
		];

		// Update the option in the database
		update_option( 'wpnts_user_login_info', array_values( $user_login_info ) );
	}

	/**
	 * Login Count
	 */

	public function wpnts_user_login_total_count( $user_login, $user ) {
		$_SESSION['wpnts_user_display_name'] = $user->display_name;

		// Add user login information to option table
		$user_login_info = get_option( 'wpnts_user_daily_login_info', [] );

		if ( is_array( $user_login_info ) ) {
			$current_time = current_time( 'timestamp', false );
			$current_day = date('l', $current_time); // Get the current day of the week

			// Define the day to reset the count (e.g., Saturday)
			$reset_day = 'Saturday';

			$first_saturday_reset_done = get_option('wpnts_first_saturday_reset_done', 'false');

			// Check if it's a new week and reset the daily login count for all users
			if ( $current_day === $reset_day && $first_saturday_reset_done === 'false' ) {
				$user_login_info = []; // Reset the entire array
				update_option('wpnts_first_saturday_reset_done', 'true');
			}

			// Check if the user has logged in before
			$user_found = false;
			foreach ( $user_login_info as &$login ) {
				if ( $login['user'] === $user_login ) {

					// Check if it's a new day
					if ( $current_day !== $login['last_reset_day'] ) {
						// Reset the daily login count for a new day
						$login['daily_login_count'] = 1;
						$login['last_reset_day'] = $current_day;
					} else {
						// If it's the same day, increment the daily login count for the current day
						$login['daily_login_count']++;
					}

					// Update the timestamp to the current login time
					$login['timestamp'] = $current_time;

					$user_found = true;
					break;
				}
			}

			if ( ! $user_found ) {
				// Add the new login information for a new user
				$user_login_info[] = [
					'user'             => $user_login,
					'action'           => 'login',
					'timestamp'        => $current_time,
					'daily_login_count' => 1,
					'last_reset_day'   => $current_day,
				];
			}

			// Update the option in the database
			update_option( 'wpnts_user_daily_login_info', array_values( $user_login_info ) );
		}
	}



	/**
	 * wpnts_user_track_failed_login
	 */

	public function wpnts_user_track_failed_login( $username ) {
		$log_data = get_option('wpnts_user_track_failed_login', array()); // Get existing data

		// Get the current date
		$current_date = gmdate('l');

		// Initialize the daily login count for the user
		$daily_failed_count = 1; // Default to 1 for a new day

		// Flag to check if a matching entry was found
		$entry_found = false;

		// Check if there are existing log entries for the user
		foreach ( $log_data as &$log_entry ) {
			if ( $log_entry['user'] === $username && $log_entry['last_reset_day'] === $current_date ) {
				// If a log entry exists for the same user on the same day, increment the count
				$log_entry['daily_failed_count']++;
				$entry_found = true;
				break; // Exit the loop since we found a matching entry
			}
		}

		// If no matching entry was found, create a new log entry
		if ( ! $entry_found ) {
			// Log failed login attempt
			$log_entry = array(
				'user' => $username,
				'timestamp' => time(),
				'last_reset_day' => $current_date, // Initialize or update 'last_reset_day'
				'daily_failed_count' => $daily_failed_count,
				'action' => 'failed',
			);

			$log_data[] = $log_entry;
		}

		// Update the option in the database
		update_option('wpnts_user_track_failed_login', $log_data);
	}



	/**
	 * Logout Notification
	 */
	public function wpnts_user_activity_notification_logout() {
		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;
		$authorPaneltoMail = $schedules_interval->authorPaneltoMail ?? false;

		$slack_webhook_url = $wpnts_webhook;

		session_start();
		$user_display_name = isset( $_SESSION['wpnts_user_display_name'] ) ? $_SESSION['wpnts_user_display_name'] : '';

		$message = ":smiling_face_with_tear: User $user_display_name has logged out.";

		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );

		if ( $authorPaneltoMail === true ) {
			// Send email notification.
			$this->sendEmailNotificationSigninout('Logout Notification', "User 👉 $user_display_name has logged out.");
		}

		// Add user logout information to option table
		$user_logout_info = get_option( 'wpnts_user_login_info', [] );
		$current_time = current_time( 'timestamp', false );

		// Remove users from the login info array if 24 hours have passed since their login
		foreach ( $user_logout_info as $key => $login ) {
			if ( ( $current_time - $login['timestamp'] ) >= 86400 ) {
				unset( $user_logout_info[ $key ] );
			}
		}

		// Add the new login information
		$user_logout_info[] = [
			'user'      => $user_display_name,
			'action'    => 'logout',
			'timestamp' => $current_time,
		];

		// Update the option in the database
		update_option( 'wpnts_user_login_info', array_values( $user_logout_info ) );
	}

	/**
	 * New user register to my site Notifications to Slack.
	 */
	public function wpnts_new_user_notification( $user_id ) {
		$user = get_userdata( $user_id );
		$schedules_int = get_option( 'wpnts_schedules_interval_site_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;
		$authorPaneltoMail = $schedules_interval->authorPaneltoMail ?? false;

		$slack_webhook_url = $wpnts_webhook;

		$message = "New user registered on your site:\n\nUsername: " . $user->user_login . "\nEmail: " . $user->user_email;
		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );

		if ( $authorPaneltoMail === true ) {
			// Send email notification.
			$this->sendEmailNotificationSigninout('New User Notification', $message);
		}
	}


	 /**
	  * SignUP and new account all notification
	  */
	private function sendEmailNotificationSigninout( $subject, $status_message = '' ) {
		$global_api_settings = get_option('wpnts_global_api_settings');
		$wpnts_global_api = json_decode($global_api_settings);

		$mailconfig = $wpnts_global_api->mailconfig ?? false;
		$recipiantmail = $wpnts_global_api->recipiantmail ?? '';

		$attachmentHandler = new SlackAttachment();

		// Check if mail configuration is enabled and recipient email is not empty
		if ( $mailconfig === true && ! empty($recipiantmail) ) {
			$attachmentHandler->sendEmailNotification($recipiantmail, $subject, $status_message);
		}
	}
}
