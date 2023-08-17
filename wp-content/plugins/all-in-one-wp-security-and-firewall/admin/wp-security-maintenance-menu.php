<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Maintenance_Menu extends AIOWPSecurity_Admin_Menu {
	
	/**
	 * Maintenance menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_MAINTENANCE_MENU_SLUG;
	
	/**
	 * Constructor adds menu for Maintenance
	 */
	public function __construct() {
		parent::__construct(__('Maintenance', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'visitor-lockout' => array(
				'title' => __('Visitor lockout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_visitor_lockout'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Renders the submenu's visitor lockout tab
	 *
	 * @return void
	 */
	protected function render_visitor_lockout() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/general/moved.php', false, array('key' => 'visitor-lockout'));
	}
} //end class