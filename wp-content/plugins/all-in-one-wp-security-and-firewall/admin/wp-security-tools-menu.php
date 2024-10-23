<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Tools_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Tools menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_TOOLS_MENU_SLUG;

	/**
	 * Constructor adds menu for Tools
	 */
	public function __construct() {
		parent::__construct(__('Tools', 'all-in-one-wp-security-and-firewall'));
	}


	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'password-tool' => array(
				'title' => __('Password tool', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_password_tool'),
			),
			'whois-lookup' => array(
				'title' => __('WHOIS lookup', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_whois_lookup_tab'),
			),
			'custom-rules' => array(
				'title' => __('Custom .htaccess rules', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_custom_rules'),
				'display_condition_callback' => array('AIOWPSecurity_Utility', 'allow_to_write_to_htaccess'),
			),
			'visitor-lockout' => array(
				'title' => __('Visitor lockout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_visitor_lockout'),
			),
		);
		
		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Render the 'Custom (htaccess) rules' tab
	 *
	 * @return void
	 */
	protected function render_custom_rules() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/tools/custom-htaccess.php');
	}

	/**
	 * Renders the submenu's password tool tab
	 *
	 * @return Void
	 */
	protected function render_password_tool() {
		global $aio_wp_security;

		wp_enqueue_script('aiowpsec-pw-tool-js');
		$aio_wp_security->include_template('wp-admin/tools/password-tool.php');
	}

	/**
	 * Renders the submenu's whois-lookup tab body.
	 *
	 * @return Void
	 */
	protected function render_whois_lookup_tab() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/tools/whois-lookup.php', false, array());
	}

	/**
	 * Renders the submenu's visitor lockout tab
	 *
	 * @return void
	 */
	protected function render_visitor_lockout() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/tools/visitor-lockout.php', false, array());
	}

} // End of class
