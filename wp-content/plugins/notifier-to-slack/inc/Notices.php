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
use WPNTS\Inc\BaseController;
use WPNTS\Inc\Database\DB;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Admin dashboard created
 *
 * @since 1.0.0
 */
class Notices {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		if ( \is_plugin_active( plugin_basename( WP_NOTIFIER_TO_SLACK__FILE__ ) ) ) {
			$this->review_notice_by_condition();
			$this->review_upgrade_notice_by_condition();
		}
		
	}


	/**
	 * Loads review notice based on condition.
	 *
	 * @since 2.12.15
	 */
	public function review_notice_by_condition() {
		$gswpts_review_notice = get_option('NotifierReviewNotice');
		if ( time() >= intval( get_option( 'DefaultNTReviewNoticeInterval' ) ) ) {
			if ( false === $gswpts_review_notice || empty($gswpts_review_notice) ) {
				add_action( 'admin_notices', [ $this, 'show_review_notice' ] );
			}
		}
	}


	/**
	 * Load Upgrade notice condition.
	 *
	 * @since 2.12.15
	 */
	public function review_upgrade_notice_by_condition() {
		$wpnts_db_instance = new DB();
		$check_pro_plugin_exists = $wpnts_db_instance->check_pro_plugin_exists();
		$is_pro_active = $wpnts_db_instance->is_pro_active();

		if ( ! $check_pro_plugin_exists || ! $is_pro_active ) {
			$upgrade_notice = get_option('NotifierUpgradeNotice');
			if ( time() >= intval( get_option( 'DefaultNTUpgradeInterval' ) ) ) {
				if ( false === $upgrade_notice || empty($upgrade_notice) ) {
					add_action( 'admin_notices', [ $this, 'show_upgrade_notice' ] );
				}
			}
		}
	}


	/**
	 * Display plugin review notice.
	 *
	 * @return void
	 */
	public function show_review_notice() {
		load_template( WP_NOTIFIER_TO_SLACK_DIR_PATH . 'templates/parts/review_notice.php' );
	}

	/**
	 * Displays plugin Influencer notice.
	 *
	 * @return void
	 */
	public function show_upgrade_notice() {
		load_template( WP_NOTIFIER_TO_SLACK_DIR_PATH . 'templates/parts/plugin_upgrade_notice.php' );
	}



	
}
