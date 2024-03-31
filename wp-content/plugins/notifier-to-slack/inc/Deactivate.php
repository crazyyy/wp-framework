<?php
/**
 * Admin Chat Box Datatable
 *
 * This class is used to builds all of the tables
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
 * Deactivate Class fire on deactivation of the plugin.
 *
 * @since 1.0.0
 */
class Deactivate {
	/**
	 * deactivate Instance.
	 *
	 * @since  1.0.0
	 */
	public static function wpnts_deactivate() {
		wp_clear_scheduled_hook( 'wpnts_corn_hook' );
		flush_rewrite_rules();
	}
}
