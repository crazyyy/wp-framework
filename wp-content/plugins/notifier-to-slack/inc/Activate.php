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
use WPNTS\Inc\Notify;
use WPNTS\Inc\WPUpdate;
use WPNTS\Inc\PluginUpdate;
use WPNTS\Inc\NotifierReview;
use WPNTS\Inc\NotifierSupport;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Activator Class.
 *
 * @since 1.0.0
 */
class Activate {

	/**
	 * Activate function, Seed initial settings.
	 *
	 * @since 1.0.0
	 */
	public static function wpnts_activate() {
		// Make it static so I can call it direct on a function.

		if ( ! wp_next_scheduled('wpnts_corn_hook') ) {
			wp_schedule_event(time(), 'added_schedules_interval', 'wpnts_corn_hook');
		}
		flush_rewrite_rules();
	}
}
