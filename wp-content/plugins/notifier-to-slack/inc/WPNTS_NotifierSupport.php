<?php
/**
 * Admin Chat Box Activator
 *
 * This class is used to builds all of the tables when the plugin is activated
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use \WPNTS\Inc\WPNTS_Activate;
use \WPNTS\Inc\WPNTS_Deactivate;
use \WPNTS\Inc\WPNTS_SlackAttachment;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Admin dashboard created
 *
 * @since 1.0.0
 */
class WPNTS_NotifierSupport {

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
		add_action( 'wpnts_corn_hook', [ $this, 'wpnts_support_tickets' ]);
	}

	/**
	 * Corn setup time interval
	 *
	 * @since 1.0.0
	 */
	public function wpnts_add_cron_interval() {

		$schedules_int = get_option( 'wpnts_schedules_interval');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_time = $schedules_interval->interval ?? '250';

		$schedules['added_schedules_interval'] = [
			'interval' => isset($wpnts_time) ? $wpnts_time : 25,
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

		$schedules_int = get_option( 'wpnts_schedules_interval');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_time = $schedules_interval->interval ?? '250';
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
					$schedules_int = get_option( 'wpnts_schedules_interval');
					$schedules_interval = json_decode($schedules_int);
					$wpnts_review_days = $schedules_interval->reviewDays;

					$body = wp_remote_retrieve_body( $response );
					$xml = simplexml_load_string( $body );
					$unresolved_tickets = [];
					// Flag variable to check if any unresolved tickets have been found.
					$all_resolved = true;

					// Now check last 7 days unresolved ticket.
					$one_week_ago = strtotime($wpnts_review_days . ' days');

					$plugin_name = strtolower(explode('/',$url)[5]);

					foreach ( $xml->channel->item as $item ) {
						$pubDate = strtotime($item->pubDate);
						$title = (string) $item->title;
						$link = (string) $item->link;

						if ( strpos( $title, '[resolved]' ) === false && strpos( $title, 'class="resolved"' ) === false && $pubDate >= $one_week_ago && $pubDate <= time() ) {

							$unresolved_tickets[] = [
								'title' => $title,
								'link' => $link,
								'pubDate' => $pubDate,
							];

							$all_resolved = false;
						}
					}
				}

				/**
				 * Send data to slack.
				 */
				$schedules_int = get_option( 'wpnts_schedules_interval');
				$schedules_interval = json_decode($schedules_int);
				$wpnts_webhook = $schedules_interval->webhook;

				$webhook_url = $wpnts_webhook;

				$attachmentHandler = new WPNTS_SlackAttachment();

				foreach ( $unresolved_tickets as $ticket ) {
					$ticket_title = substr($ticket['title'], strpos($ticket['title'], ']') + 1);
					$ticket_link = $ticket['link'];
					$ticket_date = gmdate('F j, Y', $ticket['pubDate']);

					// Handaler.
					$attachmentHandler->addAttachment($ticket_title, $ticket_link, $ticket_date, '#ff0000', ':cry:');
				}

				$message = $attachmentHandler->getMessage();

				wp_remote_post( $webhook_url, [
					'body' => json_encode( $message ),
					'headers' => [
						'Content-Type' => 'application/json',
					],
				] );

			}
			update_option('wpnts_last_sent_time', time());
		}
	}

}