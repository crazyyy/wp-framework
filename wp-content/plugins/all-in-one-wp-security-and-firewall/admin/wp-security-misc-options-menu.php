<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Misc_Options_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Miscellaneous menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_MISC_MENU_SLUG;
	
	/**
	 * Constructor adds menu for Miscellaneous
	 */
	public function __construct() {
		parent::__construct(__('Miscellaneous', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'copy-protection' => array(
				'title' => __('Copy protection', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_copy_protection'),
			),
			'frames' => array(
				'title' => __('Frames', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_frames'),
			),
			'user-enumeration' => array(
				'title' => __('User enumeration', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_user_enumeration'),
			),
			'wp-rest-api' => array(
				'title' => __('WP REST API', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_wp_rest_api'),
			),
			'salt' => array(
				'title' => __('Salt', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_salt_tab'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Renders the submenu's copy protection tab
	 *
	 * @return Void
	 */
	protected function render_copy_protection() {
		global $aio_wp_security;
		$maint_msg = '';
		if (isset($_POST['aiowpsec_save_copy_protection'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-copy-protection')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on copy protection feature settings save!",4);
				die("Nonce check failed on copy protection feature settings save!");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_copy_protection', isset($_POST["aiowps_copy_protection"]) ? '1' : '', true);

			$this->show_msg_updated(__('Copy Protection feature settings saved!', 'all-in-one-wp-security-and-firewall'));

		}

		$aio_wp_security->include_template('wp-admin/miscellaneous/copy-protection.php', false, array());
	}

	/**
	 * Renders the submenu's render frames tab
	 *
	 * @return Void
	 */
	protected function render_frames() {
		global $aio_wp_security;
		$maint_msg = '';
		if (isset($_POST['aiowpsec_save_frame_display_prevent'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-prevent-display-frame')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on prevent display inside frame feature settings save!",4);
				die("Nonce check failed on prevent display inside frame feature settings save!");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_prevent_site_display_inside_frame', isset($_POST["aiowps_prevent_site_display_inside_frame"]) ? '1' : '', true);

			$this->show_msg_updated(__('Frame Display Prevention feature settings saved!', 'all-in-one-wp-security-and-firewall'));

		}

		$aio_wp_security->include_template('wp-admin/miscellaneous/frames.php', false, array());
	}

	/**
	 * Renders the submenu's user enumeration tab
	 *
	 * @return Void
	 */
	protected function render_user_enumeration() {
		global $aio_wp_security;
		$maint_msg = '';
		if (isset($_POST['aiowpsec_save_users_enumeration'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-users-enumeration')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on prevent user enumeration feature settings save!",4);
				die("Nonce check failed on prevent user enumeration feature settings save!");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_prevent_users_enumeration', isset($_POST["aiowps_prevent_users_enumeration"]) ? '1' : '', true);

			$this->show_msg_updated(__('User Enumeration Prevention feature settings saved!', 'all-in-one-wp-security-and-firewall'));

		}

		$aio_wp_security->include_template('wp-admin/miscellaneous/user-enumeration.php', false, array());
	}

	/**
	 * Renders the submenu's WP REST API tab
	 *
	 * @return Void
	 */
	protected function render_wp_rest_api() {
		global $aio_wp_security;
		$maint_msg = '';
		if (isset($_POST['aiowpsec_save_rest_settings'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-rest-settings')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on REST API security feature settings save!",4);
				die("Nonce check failed on REST API security feature settings save!");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_disallow_unauthorized_rest_requests', isset($_POST["aiowps_disallow_unauthorized_rest_requests"]) ? '1' : '', true);

			$this->show_msg_updated(__('WP REST API Security feature settings saved!', 'all-in-one-wp-security-and-firewall'));

		}

		$aio_wp_security->include_template('wp-admin/miscellaneous/wp-rest-api.php', false, array());
	}

	/**
	 * Renders the submenu's salt tab
	 *
	 * @return Void
	 */
	protected function render_salt_tab() {
		global $aio_wp_security;

		if (isset($_POST['aios_save_salt_postfix_settings'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aios-salt-postfix-settings')) {
				$error_msg = 'Nonce check failed on salt postfix feature settings save.';
				$aio_wp_security->debug_logger->log_debug($error_msg, 4);
				die($error_msg);
			}

			//Save settings
			$aiowps_enable_salt_postfix = isset($_POST['aiowps_enable_salt_postfix']) ? '1' : '';
			if ($aiowps_enable_salt_postfix == $aio_wp_security->configs->get_value('aiowps_enable_salt_postfix')) {
				$is_setting_changed = true;
			} else {
				$is_setting_changed = false;
			}

			$aio_wp_security->configs->set_value('aiowps_enable_salt_postfix', $aiowps_enable_salt_postfix, true);
			$ret_schedule = $this->schedule_change_auth_keys_and_salt();

			if ('1' == $aiowps_enable_salt_postfix && $is_setting_changed) {
				AIOWPSecurity_Utility::change_salt_postfixes();
			}

			$this->show_msg_updated(__('Salt postfix feature settings saved.', 'all-in-one-wp-security-and-firewall'));
		}

		$aio_wp_security->include_template('wp-admin/miscellaneous/salt.php');
	}

	/**
	 * Schedule weekly aios_change_auth_keys_and_salt cron event.
	 *
	 * @return Boolean|WP_Error  True if event successfully scheduled. False or WP_Error on failure.
	 */
	private function schedule_change_auth_keys_and_salt() {
		$previous_time = wp_next_scheduled('aios_change_auth_keys_and_salt');

		if (false !== $previous_time) {
			// Clear schedule so that we don't stack up scheduled backups
			wp_clear_scheduled_hook('aios_change_auth_keys_and_salt');
		}

		$gmt_offset_in_seconds = floatval(get_option('gmt_offset')) * 3600;
		$first_time = strtotime('next Sunday '.apply_filters('aios_salt_change_schedule_time', '3:00 am')) + $gmt_offset_in_seconds;
		return wp_schedule_event($first_time, 'weekly', 'aios_change_auth_keys_and_salt');
	}
} //end class
