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
 * Security used to rest route created
 *
 * @since 1.0.0
 */
class SlackAttachment {
	private $attachments = [];

	/**
	 * For ratting review and support
	 */
	public function addAttachment( $plugin_name, $title, $ticket_description, $link, $date, $color, $emoji, $rating = null ) {

		$fields = [
			[
				'title' => "Name: $plugin_name",
				'short' => false,
			],
			[
				'title' => "Title: $title $emoji",
				'short' => false,
			],
			[
				'value' => "Description: $ticket_description",
				'short' => false,
			],
			[
				'value' => "Link: <{$link}|view>",
				'short' => false,
			],
			[
				'value' => "Date: $date",
				'short' => false,
			],
		];

		if ( $rating !== null ) {
			$fields[] = [
				'value' => str_repeat(':star:', $rating),
				'short' => false,
			];
		}

		$attachment = [
			'fallback' => $title,
			'color' => $color,
			'fields' => $fields,
		];

		$this->attachments[] = $attachment;
	}



	/**
	 * For attatchment call of ratting and review.
	 */
	public function getMessage() {
		return [
			'attachments' => $this->attachments,
		];
	}


	/**
	 * For Plugin Update notification
	 */

	public function addPluginUpdateNotification( $plugin_name, $new_version, $emoji = ':clap:', $color = '#00FF00' ) {
		$message = "$emoji A new version of the $plugin_name plugin is available for update ($new_version).";

		$fields = [
			[
				'title' => $message,
				'short' => false,
			],
		];

		$attachment = [
			'fallback' => $message,
			'color' => $color,
			'fields' => $fields,
		];

		$this->attachments[] = $attachment;
	}


	/**
	 * Add function to send notification via email
	 */
	public function sendEmailNotification( $to, $subject, $notification_message ) {
		$timestamp = current_time('mysql');

		// Customize the email message as needed
		$message = '<html><body style="background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;">';
		$message .= '<div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">';

		// Include the date
		$message .= '<h3 style="color: #666; text-align: center;">Site Notification: ' . esc_html($timestamp) . '</h3>';
		$message .= '<p style="color: #666;">Time: ' . esc_html($timestamp) . '</p>';

		// Include the activation details
		$message .= '<h5>' . esc_html($notification_message) . ' </h5><br>';

		$message .= '<p style="color: #666;">Powered by <a href="https://wordpress.org/plugins/notifier-to-slack/" target="_blank">WP Notifier To Slack</a>.</p>';
		$message .= '</div></body></html>';

		// Email headers
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		// Send the email
		wp_mail($to, $subject, $message, $headers);
	}
}
