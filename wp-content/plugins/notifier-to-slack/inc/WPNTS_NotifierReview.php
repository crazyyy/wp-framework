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
class WPNTS_NotifierReview {

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
		add_action( 'wpnts_corn_hook', [ $this, 'wpnts_review_tickets' ]);
	}
	/**
	 * Corn setup time interval.
	 *
	 * @since 1.0.0
	 */
	public function wpnts_add_cron_interval() {

		$schedules_int = get_option( 'wpnts_schedules_interval');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_time = $schedules_interval->interval_review ?? '250';

		$schedules['added_schedules_interval'] = [
			'interval' => isset($wpnts_time) ? $wpnts_time : 30,
			'display'  => esc_html__( 'Assigned Time' ),
		];
		return $schedules;

	}

	/**
	 * Review ticket get from the ORG and sendback to slack.
	 *
	 * @since 1.0.0
	 */
	public function wpnts_review_tickets() {

		$get_plugin = get_option( 'wpnts_plugin_list');
		$add_pluginName = json_decode($get_plugin);

		$pluginName = [];

		if ( is_array($add_pluginName) ) {
			foreach ( $add_pluginName as $obj ) {
				if ( isset($obj->content) ) {
					$pluginName[] = 'https://wordpress.org/support/plugin/' . $obj->content . '/reviews/feed/';
				}
			}
		}

		$urls = $pluginName;

		$last_sent_time = get_option('wpnts_review_last_sent_time', 3);
		$current_time = time();

		$schedules_int = get_option( 'wpnts_schedules_interval');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_time = $schedules_interval->interval_review ?? '250';
		$activereview = $schedules_interval->activereview ?? 'false';

		if ( true === $activereview && isset($last_sent_time) && ( $current_time - $last_sent_time ) >= $wpnts_time ) {

			foreach ( $urls as $url ) {

				$args = [
					'timeout' => 10,
				];
				$response = wp_remote_get($url, $args);

				if ( is_wp_error($response) ) {
					$error_message = $response->get_error_message();
					echo esc_attr( $error_message );
				} else {
					$body = wp_remote_retrieve_body($response);
					$xml = simplexml_load_string($body);
					$recent_reviews = [];

					$schedules_int = get_option( 'wpnts_schedules_interval');
					$schedules_interval = json_decode($schedules_int);
					$wpnts_review_days = $schedules_interval->reviewDays;

					$plugin_name = strtolower(explode('/',$url)[5]);

					// Loop through the reviews and retrieve the ones posted in the last 7 days.
					foreach ( $xml->channel->item as $item ) {

						$pubDate = strtotime($item->pubDate);
						$one_week_ago = strtotime($wpnts_review_days . ' days');

						if ( $pubDate >= $one_week_ago && $pubDate <= time() ) {
							$title = (string) $item->title;
							$link = (string) $item->link;
							$description = (string) $item->description;

							$rating_match = [];
							preg_match('/rating: (\d+)/i', $description, $rating_match);
							$rating = ! empty($rating_match) ? $rating_match[1] : null;

							$recent_reviews[] = [
								'title' => $title,
								'link' => $link,
								'pubDate' => $pubDate,
								'rating' => $rating,
							];
						}
					}
				}

				// Send to slack.

				$schedules_int = get_option( 'wpnts_schedules_interval');
				$schedules_interval = json_decode($schedules_int);
				$wpnts_webhook = $schedules_interval->webhook;

				$webhook_url = $wpnts_webhook;

				$attachmentHandler = new WPNTS_SlackAttachment();
				foreach ( $recent_reviews as $ticket ) {
					$ticket_title = substr($ticket['title'], strpos($ticket['title'], ']'));
					$ticket_link = $ticket['link'];
					$ticket_date = gmdate('F j, Y', $ticket['pubDate']);
					$ticket_rating = $ticket['rating'];

					// Handaler.
					$attachmentHandler->addAttachment($ticket_title, $ticket_link, $ticket_date, '#FFFF00', ':tada:', $ticket_rating);

				}

				// Send reviews ratings to Slack.
				$message = $attachmentHandler->getMessage();

				wp_remote_post($webhook_url, [
					'body' => json_encode($message),
					'headers' => [
						'Content-Type' => 'application/json',
					],
					// 'timeout'     => '5',
				]);

			}
			update_option('wpnts_review_last_sent_time', time());
		}
	}
}