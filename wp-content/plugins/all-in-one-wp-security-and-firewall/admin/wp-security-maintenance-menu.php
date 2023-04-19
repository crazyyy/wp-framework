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
		$maint_msg = '';
		if (isset($_POST['aiowpsec_save_site_lockout'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-site-lockout')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on site lockout feature settings save!",4);
				die("Nonce check failed on site lockout feature settings save!");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_site_lockout', isset($_POST["aiowps_site_lockout"]) ? '1' : '');
			$maint_msg = htmlentities(stripslashes($_POST['aiowps_site_lockout_msg']), ENT_COMPAT, "UTF-8");
			$aio_wp_security->configs->set_value('aiowps_site_lockout_msg',$maint_msg); // Text area/msg box
			$aio_wp_security->configs->save_config();

			$this->show_msg_updated(__('Site lockout feature settings saved!', 'all-in-one-wp-security-and-firewall'));

			do_action('aiowps_site_lockout_settings_saved'); // Trigger action hook.

		}

		$aio_wp_security->include_template('wp-admin/maintenance/visitor-lockout.php', false, array());
	}
} //end class