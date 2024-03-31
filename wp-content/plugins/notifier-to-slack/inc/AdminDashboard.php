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

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Admin dashboard created
 *
 * @since 1.0.0
 */
class AdminDashboard {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action('admin_menu', [ $this, 'add_notifier_pages' ]);
	}
	/**
	 * Admin Menu pages
	 *
	 * @since 1.0.0
	 */
	public function add_notifier_pages() {
		$icon = plugin_dir_url(__FILE__) . '../assets/logo.png';
		add_menu_page(
			__( 'Notifier', 'wpnts' ),
			__( 'Notifier', 'wpnts' ),
			'manage_options',
			'wpnts_notifier',
			[ $this, 'notifier_pages' ],
			$icon,
			90 );

		if ( current_user_can( 'manage_options' ) ) {
			global $submenu;

			$submenu['wpnts_notifier'][] = [ __( 'Dashboard', 'wpnts_notifier' ), 'manage_options', 'admin.php?page=wpnts_notifier#/' ]; // phpcs:ignore

			$submenu['wpnts_notifier'][] = [ __( 'Author', 'wpnts_notifier' ), 'manage_options', 'admin.php?page=wpnts_notifier#/author' ]; // phpcs:ignore

			$submenu['wpnts_notifier'][] = [ __( 'Settings', 'wpnts_notifier' ), 'manage_options', 'admin.php?page=wpnts_notifier#/settings' ]; // phpcs:ignore

			$submenu['wpnts_notifier'][] = [ __( 'Get started', 'wpnts_notifier' ), 'manage_options', 'admin.php?page=wpnts_notifier#/doc' ]; // phpcs:ignore

		}
	}

	/**
	 * Dashboard page
	 *
	 * @since 1.0.0
	 */
	public function notifier_pages() {
		echo '<div id="wpcts_dashboard"></div>';
		echo '<div id="wpcts_portal"></div>';
	}
}
