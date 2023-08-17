<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_User_Registration_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * User registration menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_USER_REGISTRATION_MENU_SLUG;
	
	/**
	 * Constructor adds menu for User registration
	 */
	public function __construct() {
		parent::__construct(__('User registration', 'all-in-one-wp-security-and-firewall'));
	}
	
	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'manual-approval' => array(
				'title' => __('Manual approval', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_manual_approval'),
			),
			'registration-captcha' => array(
				'title' => __('Registration CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_registration_captcha'),
			),
			'registration-honeypot' => array(
				'title' => __('Registration honeypot', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_registration_honeypot'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's manual approval tab
	 *
	 * @return Void
	 */
	protected function render_manual_approval() {
		global $aio_wp_security, $aiowps_feature_mgr;

		include_once 'wp-security-list-registered-users.php'; // For rendering the AIOWPSecurity_List_Table
		$user_list = new AIOWPSecurity_List_Registered_Users();

		if (isset($_POST['aiowps_save_user_registration_settings'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-user-registration-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on save user registration settings!",4);
				die("Nonce check failed on save user registration settings!");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_enable_manual_registration_approval', isset($_POST["aiowps_enable_manual_registration_approval"]) ? '1' : '', true);

			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_updated(__('Settings were successfully saved', 'all-in-one-wp-security-and-firewall'));
		}

		if (isset($_REQUEST['action'])) { // Do list table form row action tasks
			if ($_REQUEST['action'] == 'approve_acct') { // Approve link was clicked for a row in list table
				$nonce = isset($_REQUEST['aiowps_nonce']) ? $_REQUEST['aiowps_nonce'] : '';
				if (!isset($nonce) ||!wp_verify_nonce($nonce, 'approve_user_acct')) {
					$aio_wp_security->debug_logger->log_debug("Nonce check failed for approve registered user account operation.", 4);
					die(__('Nonce check failed for approve registered user account operation.','all-in-one-wp-security-and-firewall'));
				}
				$user_list->approve_selected_accounts(strip_tags($_REQUEST['user_id']));
			}

			if ($_REQUEST['action'] == 'delete_acct') { // Delete link was clicked for a row in list table
				$nonce = isset($_REQUEST['aiowps_nonce']) ? $_REQUEST['aiowps_nonce'] : '';
				if (!wp_verify_nonce($nonce, 'delete_user_acct')) {
					$aio_wp_security->debug_logger->log_debug("Nonce check failed for delete registered user account operation.", 4);
					die(__('Nonce check failed for delete registered user account operation.','all-in-one-wp-security-and-firewall'));
				}
				$user_list->delete_selected_accounts(strip_tags($_REQUEST['user_id']));
			}

			if ($_REQUEST['action'] == 'block_ip') { // Block IP link was clicked for a row in list table
				$nonce = isset($_REQUEST['aiowps_nonce']) ? $_REQUEST['aiowps_nonce'] : '';
				if (!isset($nonce) || !wp_verify_nonce($nonce, 'block_ip')) {
					$aio_wp_security->debug_logger->log_debug("Nonce check failed for block IP operation of registered user!", 4);
					die(__('Nonce check failed for block IP operation of registered user!','all-in-one-wp-security-and-firewall'));
				}
				$user_list->block_selected_ips(strip_tags($_REQUEST['ip_address']));
			}
		}

		$page = $_REQUEST['page'];
		$tab = isset($_REQUEST["tab"]) ? $_REQUEST["tab"] : '';

		$aio_wp_security->include_template('wp-admin/user-registration/manual-approval.php', false, array('user_list' => $user_list, 'aiowps_feature_mgr' => $aiowps_feature_mgr, 'page' => $page, 'tab' => $tab));
	}
	
	/**
	 * Renders the submenu's registration captcha tab
	 *
	 * @return Void
	 */
	protected function render_registration_captcha() {
		global $aio_wp_security;
		
		$aio_wp_security->include_template('wp-admin/general/moved.php', false, array('key' => 'registration-captcha'));
	}

	/**
	 * Renders the submenu's registration honeypot tab
	 *
	 * @return Void
	 */
	protected function render_registration_honeypot() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/general/moved.php', false, array('key' => 'registration-honeypot'));
	}
} //end class
