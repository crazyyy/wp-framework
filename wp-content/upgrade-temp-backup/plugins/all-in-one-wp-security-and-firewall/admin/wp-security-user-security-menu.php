<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_User_Security_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * User Security menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_USER_SECURITY_MENU_SLUG;

	/**
	 * Constructor adds menu for User Security
	 */
	public function __construct() {
		parent::__construct(__('User Security', 'all-in-one-wp-security-and-firewall'));
	}
	
	/**
	 * Populates $menu_tabs array.
	 *
	 * @return Void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'wp-user_accounts' => array(
				'title' => __('User accounts', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_wp_user_account'),
			),
			'login-lockout' => array(
				'title' => __('Login lockout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_login_lockout'),
			),
			'force-logout' => array(
				'title' => __('Force logout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_force_logout'),
			),
			'logged-in-users' => array(
				'title' => __('Logged in users', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_logged_in_users'),
			),
			'manual-approval' => array(
				'title' => __('Manual approval', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_manual_approval'),
			),
			'salt' => array(
				'title' => __('Salt', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_salt_tab'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'http-authentication' => array(
				'title' => __('HTTP authentication', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_http_authentication'),
			),
			'additional' => array(
				'title' => __('Additional settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_additional'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's WP User Account tab
	 *
	 * @return Void
	 */
	protected function render_wp_user_account() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (is_multisite()) { // Multi-site: get admin accounts for current site
			$blog_id = get_current_blog_id();
			$user_accounts = $this->get_all_admin_accounts($blog_id);
		} else {
			$user_accounts = $this->get_all_admin_accounts();
		}
		
		$aio_wp_security->include_template('wp-admin/user-security/wp-username.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'user_accounts' => $user_accounts, 'AIOWPSecurity_User_Security_Menu' => $this));
		
		$aio_wp_security->include_template('wp-admin/user-security/display-name.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));

		$aio_wp_security->include_template('wp-admin/user-security/user-enumeration.php', false, array());
	}

	
	/**
	 * This function will retrieve all user accounts which have 'administrator' role and will return html code with results in a table
	 *
	 * @param string $blog_id - the blog we want to get the user account information from
	 *
	 * @return string - the html from the result
	 */
	private function get_all_admin_accounts($blog_id = '') {
		// TODO: Have included the "blog_id" variable for future use for cases where people want to search particular blog (eg, multi-site)
		if ($blog_id) {
			$admin_users = get_users('blog_id='.$blog_id.'&orderby=login&role=administrator');
		} else {
			$admin_users = get_users('orderby=login&role=administrator');
		}
		// now let's put the results in an HTML table
		$account_output = "";
		if (!empty($admin_users)) {
			$account_output .= '<table>';
			$account_output .= '<tr><th>'.esc_html(__('Account login name', 'all-in-one-wp-security-and-firewall')).'</th></tr>';
			foreach ($admin_users as $entry) {
				$account_output .= '<tr>';
				if (strtolower($entry->user_login) == 'admin') {
					$account_output .= '<td style="color:red; font-weight: bold;">'.esc_html($entry->user_login).'</td>';
				} else {
					$account_output .= '<td>'.esc_html($entry->user_login).'</td>';
				}
				$user_acct_edit_link = admin_url('user-edit.php?user_id=' . $entry->ID);
				$account_output .= '<td><a href="'.esc_url($user_acct_edit_link).'" target="_blank">'.esc_html(__('Edit user', 'all-in-one-wp-security-and-firewall')).'</a></td>';
				$account_output .= '</tr>';
			}
			$account_output .= '</table>';
		}
		return $account_output;
	}

	/**
	 * Login Lockout configuration to set.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @global AIOWPSecurity_Feature_Item_Manager $aiowps_feature_mgr
	 *
	 * @return Void
	 */
	protected function render_login_lockout() {
		global $aio_wp_security, $aiowps_feature_mgr;

		include_once 'wp-security-list-locked-ip.php'; // For rendering the AIOWPSecurity_List_Table in tab1
		$locked_ip_list = new AIOWPSecurity_List_Locked_IP(); // For rendering the AIOWPSecurity_List_Table in tab1

		$aiowps_lockdown_allowed_ip_addresses = $aio_wp_security->configs->get_value('aiowps_lockdown_allowed_ip_addresses');

		$aio_wp_security->include_template('wp-admin/user-security/login-lockout.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'locked_ip_list' => $locked_ip_list, "aiowps_lockdown_allowed_ip_addresses" => $aiowps_lockdown_allowed_ip_addresses));
	}

	/**
	 * Force logged user to logout after x minutes.
	 *
	 * @global AIO_WP_Security                    $aio_wp_security
	 * @global AIOWPSecurity_Feature_Item_Manager $aiowps_feature_mgr
	 * @return void
	 */
	protected function render_force_logout() {
		global $aio_wp_security, $aiowps_feature_mgr;

		$aio_wp_security->include_template('wp-admin/user-security/force-logout.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

	/**
	 * Logged in users list.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @return void
	 */
	protected function render_logged_in_users() {
		global $aio_wp_security;

		include_once 'wp-security-list-logged-in-users.php'; // For rendering the AIOWPSecurity_List_Table
		$user_list = new AIOWPSecurity_List_Logged_In_Users();

		$aio_wp_security->include_template('wp-admin/user-security/logged-in-users.php', false, array('user_list' => $user_list));
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

		$aio_wp_security->include_template('wp-admin/user-security/manual-approval.php', false, array('user_list' => $user_list, 'aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

	/**
	 * Renders the submenu's salt tab
	 *
	 * @return Void
	 */
	protected function render_salt_tab() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/user-security/salt.php');
	}

	/**
	 * Renders the submenu's http authentication tab.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 *
	 * @return void
	 */
	protected function render_http_authentication() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowps_save_http_authentication_settings'])) {
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aiowpsec-http-authentication-settings-nonce');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}

			$error = false;

			$aio_wp_security->configs->set_value('aiowps_http_authentication_admin', '');

			if (isset($_POST['aiowps_http_authentication_admin'])) {
				if (!is_ssl()) {
					$this->show_msg_error(__('Failed to save \'Enable for WordPress dashboard\'.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Your site is currently not using https.', 'all-in-one-wp-security-and-firewall'));
					$error = true;
				} else {
					$aio_wp_security->configs->set_value('aiowps_http_authentication_admin', '1');
				}
			}

			$aio_wp_security->configs->set_value('aiowps_http_authentication_frontend', '');

			if (isset($_POST['aiowps_http_authentication_frontend'])) {
				if (!is_ssl()) {
					$this->show_msg_error(__('Failed to save \'Enable for frontend\'.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Your site is currently not using https.', 'all-in-one-wp-security-and-firewall'));
					$error = true;
				} else {
					$aio_wp_security->configs->set_value('aiowps_http_authentication_frontend', '1');
				}
			}

			if (empty($_POST['aiowps_http_authentication_username'])) {
				$this->show_msg_error(__('Failed to save \'Username\'.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Please enter a value for the HTTP authentication username.', 'all-in-one-wp-security-and-firewall'));
				$error = true;
			} else {
				$aio_wp_security->configs->set_value('aiowps_http_authentication_username', sanitize_text_field($_POST['aiowps_http_authentication_username']));
			}

			if (empty($_POST['aiowps_http_authentication_password'])) {
				$this->show_msg_error(__('Failed to save \'Password\'.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Please enter a value for the HTTP authentication password.', 'all-in-one-wp-security-and-firewall'));
				$error = true;
			} else {
				$aio_wp_security->configs->set_value('aiowps_http_authentication_password', sanitize_text_field($_POST['aiowps_http_authentication_password']));
			}

			$aio_wp_security->configs->set_value('aiowps_http_authentication_failure_message', htmlentities(stripslashes($_POST['aiowps_http_authentication_failure_message']), ENT_COMPAT, 'UTF-8'));

			$aio_wp_security->configs->save_config();

			// Recalculate points after the feature status/options have been altered.
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			if (!$error) {
				$this->show_msg_settings_updated();
			}
		}

		wp_enqueue_script('aiowpsec-pw-tool-js');

		$aio_wp_security->include_template('wp-admin/user-security/http-authentication.php');
	}

	/**
	 * Shows additional tab and field for the disable application password and saves on submit.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @global AIOWPSecurity_Feature_Item_Manager $aiowps_feature_mgr
	 * @return void
	 */
	protected function render_additional() {
		global $aio_wp_security, $aiowps_feature_mgr;

		$aio_wp_security->include_template('wp-admin/user-security/additional.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}
}
