<?php
/**
 * Admin Chat Box Datatable
 *
 * This class is used to builds all of the tables
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use \WPNTS\Inc\WPNTS_Notify;
use \WPNTS\Inc\WPNTS_WPUpdate;
use \WPNTS\Inc\WPNTS_PluginUpdate;
use \WPNTS\Inc\WPNTS_NotifierReview;
use \WPNTS\Inc\WPNTS_NotifierSupport;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * WPNTS_Deactivate Class fire on deactivation of the plugin.
 *
 * @since 1.0.0
 */
class WPNTS_Deactivate {
	/**
	 * WPNTS_deactivate Instance.
	 *
	 * @since  1.0.0
	 */
	public static function wpnts_deactivate() {
		wp_clear_scheduled_hook( 'wpnts_corn_hook' );
		flush_rewrite_rules();
	}
}
