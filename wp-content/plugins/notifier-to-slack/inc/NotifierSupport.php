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
class NotifierSupport {

	/**
	 * $unresolved_tickets Holds the path of the root directory.
	 *
	 * @var Admin
	 * @since 1.0.0
	 */
	public $unresolved_tickets = [];


	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'cron_schedules', [ $this, 'wpnts_add_cron_interval' ]);

		$schedules_int = get_option( 'wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_activesupport = $schedules_interval->activesupport ?? 'false';

		if ( true === $wpnts_activesupport ) {
			add_action( 'wpnts_corn_hook', [ $this, 'wpnts_support_tickets' ]);
		}
	}

	/**
	 * Corn setup time interval
	 *
	 * @since 1.0.0
	 */
	public function wpnts_add_cron_interval() {

		$schedules_int = get_option( 'wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$globalSettings = $schedules_interval->globalSettings ?? 'false';

		// global
		$interval = get_option( 'wpnts_global_api_settings');
		$schedules_global_interval = json_decode($interval);
		$api_active = $schedules_global_interval->api_active ?? false;

		// initial value set
		// $wpnts_time = '250';
		$wpnts_time = 250;

		if ( $globalSettings === true && $api_active === true ) {
			// $wpnts_time = $schedules_global_interval->global_interval ?? 250;
			$wpnts_time = isset($schedules_global_interval->global_interval) ? (int) $schedules_global_interval->global_interval : 250;

		} else {
			// $wpnts_time = $schedules_interval->interval ?? 250;
			$wpnts_time = isset($schedules_interval->interval) ? (int) $schedules_interval->interval : 250;
		}

		$schedules['added_schedules_interval'] = [
			'interval' => isset($wpnts_time) ? $wpnts_time : 30,
			'display'  => esc_html__( 'Assigned Time' ),
		];
		return $schedules;
	}

	/**
	 * Admin Menu pages
	 *
	 * @since 1.0.0
	 */
	public function wpnts_support_tickets() {

		$schedules_int = get_option( 'wpnts_plugin_list');
		$schedules_pluginName = json_decode($schedules_int);

		$pluginName = [];

		if ( is_array($schedules_pluginName) ) {
			foreach ( $schedules_pluginName as $obj ) {

				if ( isset($obj->content) ) {
					$pluginName[] = 'https://wordpress.org/support/plugin/' . $obj->content . '/feed/';
				}
			}
		}

		$urls = $pluginName;

		$last_sent_time = get_option('wpnts_last_sent_time', 3);
		$current_time = time();

		$schedules_int = get_option( 'wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$globalSettings = $schedules_interval->globalSettings ?? 'false';

		// global
		$interval = get_option( 'wpnts_global_api_settings');
		$schedules_global_interval = json_decode($interval);
		$api_active = $schedules_global_interval->api_active ?? false;

		// $wpnts_time = $schedules_interval->interval ?? '250';

		// initial value set
		$wpnts_time = 250;

		/*
		 if($globalSettings === true && $api_active === true){
			$wpnts_time = $schedules_global_interval->global_interval ?? 250;
		}else{
			$wpnts_time = $schedules_interval->interval ?? 250;
		} */

		if ( $globalSettings === true && $api_active === true ) {
			// $wpnts_time = $schedules_global_interval->global_interval ?? 250;
			$wpnts_time = isset($schedules_global_interval->global_interval) ? (int) $schedules_global_interval->global_interval : 250;

		} else {
			// $wpnts_time = $schedules_interval->interval ?? 250;
			$wpnts_time = isset($schedules_interval->interval) ? (int) $schedules_interval->interval : 250;
		}

		$activesupport = $schedules_interval->activesupport ?? 'false';

		if ( true === $activesupport && isset($last_sent_time) && ( $current_time - $last_sent_time ) >= $wpnts_time ) {

			foreach ( $urls as $url ) {
				$args = [
					'timeout' => 10,
				];
				$response = wp_remote_get( $url, $args );

				if ( is_wp_error( $response ) ) {
					$error_message = $response->get_error_message();
					echo esc_attr( $error_message );
				} else {
					$schedules_int = get_option( 'wpnts_default_interval');
					$schedules_interval = json_decode($schedules_int);
					$wpnts_review_days = $schedules_interval->reviewDays;

					$body = wp_remote_retrieve_body( $response );
					$xml = simplexml_load_string( $body );
					$unresolved_tickets = [];
					// Flag variable to check if any unresolved tickets have been found.
					$all_resolved = true;

					// Now check last 7 days unresolved ticket.
					$one_week_ago = strtotime($wpnts_review_days . ' days');

					// $plugin_name = strtolower(explode('/',$url)[5]);
					$plugin_name = ucfirst(strtolower(explode('/', $url)[5])) . ' Plugin';

					foreach ( $xml->channel->item as $item ) {

						$pubDate = strtotime($item->pubDate);
						$title = (string) $item->title;
						$link = (string) $item->link;
						$description = (string) $item->description;

						if ( strpos( $title, '[resolved]' ) === false && strpos( $title, 'class="resolved"' ) === false && $pubDate >= $one_week_ago && $pubDate <= time() ) {

							$unresolved_tickets[] = [
								'plugin_name' => $plugin_name,
								'title' => $title,
								'link' => $link,
								'pubDate' => $pubDate,
								'description' => $description,
							];

							$all_resolved = false;
						}
					}
				}

				/**
				 * Send data to slack.
				 */
				$schedules_int = get_option( 'wpnts_default_interval');
				$schedules_interval = json_decode($schedules_int);
				$globalSettings = $schedules_interval->globalSettings ?? 'false';

				// global
				$interval = get_option( 'wpnts_global_api_settings');
				$schedules_global_interval = json_decode($interval);
				$api_active = $schedules_global_interval->api_active ?? false;

				// $wpnts_webhook = $schedules_interval->webhook;
				// Default value, adjust as needed
				$wpnts_webhook = '';

				if ( $globalSettings === true && $api_active === true ) {
					$wpnts_webhook = $schedules_global_interval->global_webhook;
				} else {
					$wpnts_webhook = $schedules_interval->webhook;
				}

				$webhook_url = $wpnts_webhook;

				$attachmentHandler = new SlackAttachment();

				foreach ( $unresolved_tickets as $ticket ) {

					$plugin_name = $ticket['plugin_name'];
					$ticket_title = substr($ticket['title'], strpos($ticket['title'], ']'));
					$ticket_link = $ticket['link'];
					$ticket_date = gmdate('F j, Y', $ticket['pubDate']);

					// Remove the first <p> element in the description
					$ticket_description = preg_replace('/<p[^>]*>Replies:\s*\d+<\/p>/i', '', $ticket['description']);

					// Extract the first 50 words from the modified description
					$ticket_description = wp_trim_words($ticket_description, 50, '...');

					// Handaler.
					$attachmentHandler->addAttachment($plugin_name, $ticket_title, $ticket_description, $ticket_link, $ticket_date, '#ff0000', ':cry:');
				}

				$message = $attachmentHandler->getMessage();

				if ( is_array($message) && array_key_exists('attachments', $message) ) {
					$attachments = $message['attachments'];

					// Check if "attachments" is either empty or false.
					if ( ! empty($attachments) && $attachments !== false ) {
						$support_message = json_encode($message);

						if ( ! empty($support_message) ) {
							wp_remote_post($webhook_url, [
								'body' => $support_message,
								'headers' => [
									'Content-Type' => 'application/json',
								],
							]);
						}
					}
				}
			}
			update_option('wpnts_last_sent_time', time());
		}
	}
}
