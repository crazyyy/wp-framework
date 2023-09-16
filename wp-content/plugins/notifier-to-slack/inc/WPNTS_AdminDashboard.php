<?php
/**
 * Admin Chat Box Activator
 *
 * This class is used to builds all of the tables when the plugin is activated
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Admin dashboard created
 *
 * @since 1.0.0
 */
class WPNTS_AdminDashboard {

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
			'read',
			'wpnts_notifier',
			[ $this, 'notifier_pages' ],
			$icon,
			90 );
		add_submenu_page(
			'wpnts_notifier', 'Dashboard', 'Dashboard', 'read', 'wpnts_notifier',
			[ $this, 'notifier_pages' ]
		);
		add_submenu_page(
			'wpnts_notifier', 'Author', 'Author', 'read', 'wpnts_notifier_authors',
			[ $this, 'notifier_author_pages' ]
		);
		add_submenu_page(
			'wpnts_notifier', 'Settings', 'Settings', 'manage_options', 'wpnts_notifier_setting',
			[ $this, 'notifier_setting' ]
		);
	}

	/**
	 * Dashboard page
	 *
	 * @since 1.0.0
	 */
	public function notifier_pages() {
		require_once plugin_dir_path(__FILE__) . '../template/WPNTS_Dashboard.php';
	}
	/**
	 * Author page
	 *
	 * @since 1.0.0
	 */
	public function notifier_author_pages() {
		 require_once plugin_dir_path(__FILE__) . '../template/WPNTS_Author.php';
	}
	/**
	 * Setting page
	 *
	 * @since 1.0.0
	 */
	public function notifier_setting() {
		 require_once plugin_dir_path(__FILE__) . '../template/WPNTS_Setting.php';
	}

}
