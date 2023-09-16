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
class WPNTS_SlackAttachment {
	private $attachments = [];

	/**
	 * For ratting review and support
	 */
	public function addAttachment( $title, $link, $date, $color, $emoji, $rating = null ) {
		$fields = [
			[
				'title' => "Title: $title $emoji",
				'short' => false,
			],
			[
				'value' => $link,
				'short' => false,
			],
			[
				'title' => "Date: $date",
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
			'color' => $color, // Change the color as needed
			'fields' => $fields,
		];

		$this->attachments[] = $attachment;
	}



}
