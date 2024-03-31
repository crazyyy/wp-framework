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
class NotifierReview {

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
		$wpnts_activereview = $schedules_interval->activereview ?? 'false';
		$active_review_hiked = $schedules_interval->active_review_hiked ?? 'false';
		$activeinstallation = $schedules_interval->activeinstallation ?? 'false';
		$plugin_detail_info = $schedules_interval->plugin_detail_info ?? 'false';

		if ( true === $wpnts_activereview ) {
			add_action( 'wpnts_corn_hook', [ $this, 'wpnts_review_tickets' ]);
		}

		if ( true === $active_review_hiked ) {
			add_action('wpnts_corn_hook', [ $this, 'wpnts_display_rating_change' ]);
		}

		if ( true === $activeinstallation ) {
			add_action('wpnts_corn_hook', [ $this, 'wpnts_display_active_installation_change' ]);
		}
		if ( true === $plugin_detail_info ) {
			add_action('wpnts_corn_hook', [ $this, 'wpnts_display_plugin_info' ]);
		}
	}
	/**
	 * Corn setup time interval.
	 *
	 * @since 1.0.0
	 */
	public function wpnts_add_cron_interval() {
		// regular
		$schedules_int = get_option( 'wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$globalSettings = $schedules_interval->globalSettings ?? 'false';

		// global
		$interval = get_option( 'wpnts_global_api_settings');
		$schedules_global_interval = json_decode($interval);
		$api_active = $schedules_global_interval->api_active ?? false;

		// initial value set
		$wpnts_time = 250;

		if ( $globalSettings === true && $api_active === true ) {
			$wpnts_time = isset($schedules_global_interval->global_interval) ? (int) $schedules_global_interval->global_interval : 250;

		} else {
			$wpnts_time = isset($schedules_interval->interval_review) ? (int) $schedules_interval->interval_review : 250;
		}

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

		$schedules_int = get_option( 'wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$globalSettings = $schedules_interval->globalSettings ?? 'false';

		// global
		$interval = get_option( 'wpnts_global_api_settings');
		$schedules_global_interval = json_decode($interval);
		$api_active = $schedules_global_interval->api_active ?? false;

		// initial value set
		$wpnts_time = 250;

		if ( $globalSettings === true && $api_active === true ) {
			$wpnts_time = isset($schedules_global_interval->global_interval) ? (int) $schedules_global_interval->global_interval : 250;

		} else {
			$wpnts_time = isset($schedules_interval->interval_review) ? (int) $schedules_interval->interval_review : 250;
		}

		$activereview = $schedules_interval->activereview ?? 'false';

		if ( true === $activereview && isset($last_sent_time) && ( $current_time - $last_sent_time ) >= $wpnts_time ) {

			foreach ( $urls as $url ) {

				$args = [
					'timeout' => 10,
				];
				$response = wp_remote_get($url, $args);

				$recent_reviews = [];

				if ( is_wp_error($response) ) {
					$error_message = $response->get_error_message();
					echo esc_attr( $error_message );
				} else {
					$body = wp_remote_retrieve_body($response);
					$xml = simplexml_load_string($body);

					$schedules_int = get_option( 'wpnts_default_interval');
					$schedules_interval = json_decode($schedules_int);
					$wpnts_review_days = $schedules_interval->reviewDays;

					$plugin_name = ucfirst(strtolower(explode('/', $url)[5])) . ' Plugin';

					// Loop through the reviews and retrieve the ones posted in the last 7 days.
					foreach ( $xml->channel->item as $item ) {

						$pubDate = strtotime($item->pubDate);
						$description = strtotime($item->description);
						$one_week_ago = strtotime($wpnts_review_days . ' days');

						if ( $pubDate >= $one_week_ago && $pubDate <= time() ) {
							$title = (string) $item->title;
							$link = (string) $item->link;
							$description = (string) $item->description;

							$rating_match = [];
							preg_match('/rating: (\d+)/i', $description, $rating_match);
							$rating = ! empty($rating_match) ? $rating_match[1] : null;

							$recent_reviews[] = [
								'plugin_name' => $plugin_name,
								'title' => $title,
								'link' => $link,
								'pubDate' => $pubDate,
								'description' => $description,
								'rating' => $rating,
							];
						}
					}
				}

				// regular
				$schedules_int = get_option( 'wpnts_default_interval');
				$schedules_interval = json_decode($schedules_int);
				$globalSettings = $schedules_interval->globalSettings ?? 'false';

				// global
				$interval = get_option( 'wpnts_global_api_settings');
				$schedules_global_interval = json_decode($interval);
				$api_active = $schedules_global_interval->api_active ?? false;

				// Default value, adjust as needed
				$wpnts_webhook = '';

				if ( $globalSettings === true && $api_active === true ) {
					$wpnts_webhook = $schedules_global_interval->global_webhook;
				} else {
					$wpnts_webhook = $schedules_interval->webhook;
				}

				$webhook_url = $wpnts_webhook;

				$attachmentHandler = new SlackAttachment();
				foreach ( $recent_reviews as $ticket ) {

					$plugin_name = $ticket['plugin_name'];
					$ticket_title = substr($ticket['title'], strpos($ticket['title'], ']'));
					$ticket_link = $ticket['link'];
					$ticket_date = gmdate('F j, Y', $ticket['pubDate']);
					$ticket_rating = $ticket['rating'];
					// Remove the first two <p> elements "Replies: 0 Rating: 5 stars" from the description
					$ticket_description = preg_replace('/<p[^>]*>Replies:\s*\d+<\/p>\s*<p[^>]*>Rating:\s*\d+\s*stars<\/p>/i', '', $ticket['description']);

					// Extract the first 50 words from the modified description
					$ticket_description = wp_trim_words($ticket_description, 50, '...');

					// Handaler.
					$attachmentHandler->addAttachment($plugin_name, $ticket_title, $ticket_description, $ticket_link, $ticket_date, '#FFFF00', ':tada:', $ticket_rating);

				}

				// Send reviews ratings to Slack.
				$message = $attachmentHandler->getMessage();

				wp_remote_post($webhook_url, [
					'body' => is_array($message) ? json_encode($message) : $message,
					'headers' => [
						'Content-Type' => 'application/json',
					],
				]);

			}
			update_option('wpnts_review_last_sent_time', time());
		}
	}


	/**
	 * Display rating change based on the reviews feed.
	 *
	 * @since 1.0.0
	 */
	public function wpnts_display_rating_change() {

		$last_sent_time = get_option('wpnts_review_hicked_last_sent_time', 250);
		$current_time = time();

		$schedules_int = get_option( 'wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$globalSettings = $schedules_interval->globalSettings ?? 'false';

		// global
		$interval = get_option( 'wpnts_global_api_settings');
		$schedules_global_interval = json_decode($interval);
		$api_active = $schedules_global_interval->api_active ?? false;

		// initial value set
		$wpnts_time = 1080;

		$active_review_hiked = $schedules_interval->active_review_hiked ?? 'false';

		if ( true === $active_review_hiked && isset($last_sent_time) && ( $current_time - $last_sent_time ) >= $wpnts_time ) {

			$get_plugin = get_option('wpnts_plugin_list');
			$add_pluginName = json_decode($get_plugin);

			if ( ! is_array($add_pluginName) ) {
				return; // No plugins to check
			}

			foreach ( $add_pluginName as $plugin ) {
				if ( isset($plugin->content) ) {
					$plugin_slug = $plugin->content;
					// Retrieve plugin data from WordPress.org API
					$api_url = "https://api.wordpress.org/plugins/info/1.0/{$plugin_slug}.json";
					$response = wp_remote_get($api_url);

					if ( ! is_wp_error($response) ) {
						$body = wp_remote_retrieve_body($response);
						$plugin_data = json_decode($body);

						if ( $plugin_data ) {
							// Prepare the message with detailed plugin information
							$plugin_name = $plugin_data->name;
							$slug = $plugin_data->slug;
							$rating = $plugin_data->rating; // Percentage between 100

							$prev_average_rating = get_option('wpnts_review_prev_rating_' . $slug, 0);

							// if ($rating !== $prev_average_rating) { // Need type casting here as prev_average_rating is strings
							if ( (int) $rating !== (int) $prev_average_rating ) {

								// Default value, adjust as needed
								$wpnts_webhook = '';

								if ( $globalSettings === true && $api_active === true ) {
									$wpnts_webhook = $schedules_global_interval->global_webhook;
								} else {
									$wpnts_webhook = $schedules_interval->webhook;
								}

								$webhook_url = $wpnts_webhook;

								// Prepare the message with the rating change
								$plugin_name = ucfirst(strtolower($plugin_slug)) . ' Plugin';

								if ( $rating > $prev_average_rating ) {
									$message = "Congrats! :partying_face: The rating for {$plugin_name} hiked from {$prev_average_rating} to {$rating}!";
								} else {
									$message = "Sadly! :slightly_frowning_face: The rating for {$plugin_name} downgraded from {$prev_average_rating} to {$rating}!";
								}

								update_option('wpnts_review_prev_rating_' . $slug, $rating);

								// Send the message to Slack
								wp_remote_post($webhook_url, [
									'body' => json_encode([ 'text' => $message ]),
									'headers' => [ 'Content-Type' => 'application/json' ],
								]);
							}
						}
					}
				}
			}

			update_option('wpnts_review_hicked_last_sent_time', time());
		}
	}

	/**
	 * Download and installation
	 */
	public function wpnts_display_active_installation_change() {
		$last_sent_time = get_option('wpnts_installation_change_last_sent_time', 250);
		$current_time = time();

		$schedules_int = get_option('wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$globalSettings = $schedules_interval->globalSettings ?? 'false';

		// global
		$interval = get_option('wpnts_global_api_settings');
		$schedules_global_interval = json_decode($interval);
		$api_active = $schedules_global_interval->api_active ?? false;

		// initial value set
		$wpnts_time = 1080;

		// $active_installation_hiked = true;
		$active_installation_hiked = $schedules_interval->activeinstallation ?? false;

		if ( true === $active_installation_hiked && isset($last_sent_time) && ( $current_time - $last_sent_time ) >= $wpnts_time ) {
			$get_plugin = get_option('wpnts_plugin_list');
			$add_pluginName = json_decode($get_plugin);

			if ( ! is_array($add_pluginName) ) {
				return; // No plugins to check
			}

			foreach ( $add_pluginName as $plugin ) {
				if ( isset($plugin->content) ) {
					$plugin_slug = $plugin->content;
					// Retrieve plugin data from WordPress.org API
					$api_url = "https://api.wordpress.org/plugins/info/1.0/{$plugin_slug}.json";
					$response = wp_remote_get($api_url);

					if ( ! is_wp_error($response) ) {
						$body = wp_remote_retrieve_body($response);
						$plugin_data = json_decode($body);

						if ( $plugin_data ) {
							// Prepare the message with detailed plugin information
							$plugin_name = $plugin_data->name;
							$slug = $plugin_data->slug;
							$downloads = $plugin_data->downloaded; // Number of downloads

							$prev_downloads = get_option('wpnts_downloads_prev_' . $slug, 0);

							// Compare downloads to check for both increases and decreases
							if ( (int) $downloads !== (int) $prev_downloads ) {

								// Default value, adjust as needed
								$wpnts_webhook = '';

								if ( $globalSettings === true && $api_active === true ) {
									$wpnts_webhook = $schedules_global_interval->global_webhook;
								} else {
									$wpnts_webhook = $schedules_interval->webhook;
								}

								$webhook_url = $wpnts_webhook;

								// Prepare the message with the installation change
								$plugin_name = ucfirst(strtolower($plugin_slug)) . ' Plugin';

								if ( $downloads > $prev_downloads ) {
									/* $message = "Hooray! :partying_face: Active installations for {$plugin_name} raised from {$prev_downloads} to {$downloads}!"; */

									$message = "Hooray! :partying_face: Total downloads for {$plugin_name}: {$downloads}";

								} else {
									$message = "Oops! :slightly_frowning_face: Active installations for {$plugin_name} decreased from {$prev_downloads} to {$downloads}!";
								}

								update_option('wpnts_downloads_prev_' . $slug, $downloads);

								// Send the message to Slack
								wp_remote_post($webhook_url, [
									'body' => json_encode([ 'text' => $message ]),
									'headers' => [ 'Content-Type' => 'application/json' ],
								]);
							}
						}
					}
				}
			}

			update_option('wpnts_installation_change_last_sent_time', time());
		}
	}



	/**
	 * Get plugin weekly information
	 * Name, Slug, version, author, link last update, rating, total rating, support thread, how many solved, total download
	 */
	public function wpnts_display_plugin_info() {

		$last_sent_time = get_option('wpnts_plugin_info_last_sent_time', 250);
		$current_time = time();

		$schedules_int = get_option( 'wpnts_default_interval');
		$schedules_interval = json_decode($schedules_int);
		$globalSettings = $schedules_interval->globalSettings ?? 'false';

		// global
		$interval = get_option( 'wpnts_global_api_settings');
		$schedules_global_interval = json_decode($interval);
		$api_active = $schedules_global_interval->api_active ?? false;

		// initial value set
		$days = '7';
		$send_interval = $days * 24 * 60 * 60; // 7 days in seconds.

		$plugin_detail_info = $schedules_interval->plugin_detail_info ?? 'false';

		if ( true === $plugin_detail_info && isset($last_sent_time) && ( $current_time - $last_sent_time ) >= $send_interval ) {

			$get_plugin = get_option('wpnts_plugin_list');
			$add_pluginName = json_decode($get_plugin);

			if ( ! is_array($add_pluginName) ) {
				return; // No plugins to check
			}

			foreach ( $add_pluginName as $plugin ) {
				if ( isset($plugin->content) ) {
					$plugin_slug = $plugin->content;
					// Retrieve plugin data from WordPress.org API
					$api_url = "https://api.wordpress.org/plugins/info/1.0/{$plugin_slug}.json";
					$response = wp_remote_get($api_url);

					if ( ! is_wp_error($response) ) {
						$body = wp_remote_retrieve_body($response);
						$plugin_data = json_decode($body);
						// Check if the plugin data is valid
						if ( $plugin_data ) {
							// Prepare the message with detailed plugin information
							$plugin_name = $plugin_data->name;
							$slug = $plugin_data->slug;
							$version = $plugin_data->version;
							$plugin_author = $plugin_data->author;
							$plugin_link = $plugin_data->homepage;
							$last_updated = $plugin_data->last_updated;
							$rating = $plugin_data->rating; // Percentage between 100
							$num_ratings = $plugin_data->num_ratings; // total ratting added
							$support_threads = $plugin_data->support_threads; // total support_threads added
							$support_threads_resolved = $plugin_data->support_threads_resolved;
							$downloaded = $plugin_data->downloaded;

							$wpnts_webhook = '';

							if ( $globalSettings === true && $api_active === true ) {
								$wpnts_webhook = $schedules_global_interval->global_webhook;
							} else {
								$wpnts_webhook = $schedules_interval->webhook;
							}

							$webhook_url = $wpnts_webhook;

							// Prepare the message with detailed plugin information
							$message = "Detailed Information for {$plugin_name} Plugin:\n"
								. "- version: {$version}\n"
								. "- slug: {$slug}\n"
								. "- Author: {$plugin_author}\n"
								. "- Plugin Link: {$plugin_link}\n"
								. "- Last Updated: {$last_updated}\n"
								. "- Total Ratings: {$num_ratings}\n"
								. "- Ratings Percentage: {$rating}\n"
								. "- Total Support case: {$support_threads}\n"
								. "- Total Solved case: {$support_threads_resolved}\n"
								. "- Total downloaded: {$downloaded}\n";

							// Send the message to Slack
							$response = wp_remote_post($webhook_url, [
								'body' => json_encode([ 'text' => $message ]),
								'headers' => [ 'Content-Type' => 'application/json' ],
							]);

							// Check for errors
							if ( is_wp_error($response) ) {
								error_log('Error posting to Slack: ' . $response->get_error_message());
							} else {
								$response_body = wp_remote_retrieve_body($response);
							}
						}
					} else {
						error_log( 'No response: ' . print_r( $response, true ) );
					}
				}
			}

			update_option('wpnts_plugin_info_last_sent_time', time());
		}
	}
}
