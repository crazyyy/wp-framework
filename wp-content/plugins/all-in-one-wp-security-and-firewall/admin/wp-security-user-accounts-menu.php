<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_User_Accounts_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * User accounts menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_USER_ACCOUNTS_MENU_SLUG;

	/**
	 * Constructor adds menu for User accounts
	 */
	public function __construct() {
		parent::__construct(__('User accounts', 'all-in-one-wp-security-and-firewall'));
		
		// Add the JS library for password tool - make sure we are on our password tab
		if (isset($_GET['page']) && strpos($_GET['page'], AIOWPSEC_USER_ACCOUNTS_MENU_SLUG) !== false) {
			if (isset($_GET['tab']) && $_GET['tab'] == 'password-tool') {
				wp_enqueue_script('aiowpsec-pw-tool-js');
			}
		}
	}
	
	/**
	 * Populates $menu_tabs array.
	 *
	 * @return Void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'wp-username' => array(
				'title' => __('WP username', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_wp_username'),
			),
			'display-name' => array(
				'title' => __('Display name', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_display_name'),
			),
			'password-tool' => array(
				'title' => __('Password tool', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_password_tool'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's WP Username tab
	 *
	 * @return Void
	 */
	protected function render_wp_username() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowps_change_admin_username'])) { // Do form submission tasks
			echo $this->validate_change_username_form();
		}
		
		$user_accounts = '';
		
		if (is_multisite()) { // Multi-site: get admin accounts for current site
			$blog_id = get_current_blog_id();
			$user_accounts = $this->get_all_admin_accounts($blog_id);
		} else {
			$user_accounts = $this->get_all_admin_accounts();
		}
		
		$aio_wp_security->include_template('wp-admin/user-accounts/wp-username.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'user_accounts' => $user_accounts, 'AIOWPSecurity_User_Accounts_Menu' => $this));
	}
	
	/**
	 * Renders the submenu's display name tab
	 *
	 * @return Void
	 */
	protected function render_display_name() {
		global $aio_wp_security, $aiowps_feature_mgr;
		
		$aio_wp_security->include_template('wp-admin/user-accounts/display-name.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}
	
	/**
	 * Renders the submenu's password tool tab
	 *
	 * @return Void
	 */
	protected function render_password_tool() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/user-accounts/password-tool.php', false, array());
	}

	/**
	 * This function will validate the new username before changing it
	 *
	 * @return string - the html result
	 */
	private function validate_change_username_form() {
		global $wpdb;
		global $aio_wp_security;
		$errors = '';
		$nonce=$_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($nonce, 'aiowpsec-change-admin-nonce')) {
			$aio_wp_security->debug_logger->log_debug("Nonce check failed on admin username change operation.", 4);
			die('Nonce check failed on admin username change operation.');
		}
		if (!empty($_POST['aiowps_new_user_name'])) {
			$new_username = sanitize_text_field($_POST['aiowps_new_user_name']);
			if (validate_username($new_username)) {
				if (AIOWPSecurity_Utility::check_user_exists($new_username)) {
					$errors .= __('Username ', 'all-in-one-wp-security-and-firewall').$new_username.__(' already exists. Please enter another value. ', 'all-in-one-wp-security-and-firewall');
				} else {
					// let's check if currently logged in username is 'admin'
					$user = wp_get_current_user();
					$user_login = $user->user_login;
					if (strtolower($user_login) == 'admin') {
						$username_is_admin = TRUE;
					} else {
						$username_is_admin = FALSE;
					}
					// Now let's change the username
					$sql = $wpdb->prepare( "UPDATE `" . $wpdb->users . "` SET user_login = '" . esc_sql($new_username) . "' WHERE user_login=%s", "admin" );
					$result = $wpdb->query($sql);
					if (!$result) {
						// There was an error updating the users table
						$user_update_error = __('The database update operation of the user account failed!', 'all-in-one-wp-security-and-firewall');
						// TODO## - add error logging here
						$return_msg = '<div id="message" class="updated fade"><p>'.$user_update_error.'</p></div>';
						return $return_msg;
					}

					// multisite considerations
					if ( is_multisite() ) { // process sitemeta if we're in a multi-site situation
						$oldAdmins = $wpdb->get_var( "SELECT meta_value FROM `" . $wpdb->sitemeta . "` WHERE meta_key = 'site_admins'" );
						$newAdmins = str_replace( '5:"admin"', strlen( $new_username ) . ':"' . esc_sql( $new_username ) . '"', $oldAdmins );
						$wpdb->query( "UPDATE `" . $wpdb->sitemeta . "` SET meta_value = '" . esc_sql( $newAdmins ) . "' WHERE meta_key = 'site_admins'" );
					}

					// If user is logged in with username "admin" then log user out and send to login page so they can login again
					if ($username_is_admin) {
						// Lets logout the user
						$aio_wp_security->debug_logger->log_debug("Logging User Out with login ".$user_login. " because they changed their username.");
						$after_logout_url = AIOWPSecurity_Utility::get_current_page_url();
						$after_logout_payload = array('redirect_to'=>$after_logout_url, 'msg'=>$aio_wp_security->user_login_obj->key_login_msg.'=admin_user_changed', );
						//Save some of the logout redirect data to a transient
						is_multisite() ? set_site_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60) : set_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60);
						
						$logout_url = AIOWPSEC_WP_URL.'?aiowpsec_do_log_out=1';
						$logout_url = AIOWPSecurity_Utility::add_query_data_to_url($logout_url, 'al_additional_data', '1');
						AIOWPSecurity_Utility::redirect_to_url($logout_url);
					}
				}
			} else { // An invalid username was entered
				$errors .= __('You entered an invalid username. Please enter another value. ', 'all-in-one-wp-security-and-firewall');
			}
		} else { // No username value was entered
			$errors .= __('Please enter a value for your username. ', 'all-in-one-wp-security-and-firewall');
		}

		if (strlen($errors)> 0) { // We have some validation or other error
			$return_msg = '<div id="message" class="error"><p>' . $errors . '</p></div>';
		} else {
			$return_msg = '<div id="message" class="updated fade"><p>'.__('Username successfully changed.', 'all-in-one-wp-security-and-firewall').'</p></div>';
		}
		return $return_msg;
	}
	
	/**
	 * This function will retrieve all user accounts which have 'administrator' role and will return html code with results in a table
	 *
	 * @param string $blog_id - the blog we want to get the user account information from
	 *
	 * @return string - the html from the result
	 */
	private function get_all_admin_accounts($blog_id='') {
		// TODO: Have included the "blog_id" variable for future use for cases where people want to search particular blog (eg, multi-site)
		if ($blog_id) {
			$admin_users = get_users('blog_id='.$blog_id.'&orderby=login&role=administrator');
		} else {
			$admin_users = get_users('orderby=login&role=administrator');
		}
		// now let's put the results in an HTML table
		$account_output = "";
		if ($admin_users != NULL) {
			$account_output .= '<table>';
			$account_output .= '<tr><th>'.__('Account login name', 'all-in-one-wp-security-and-firewall').'</th></tr>';
			foreach ($admin_users as $entry) {
				$account_output .= '<tr>';
				if (strtolower($entry->user_login) == 'admin') {
					$account_output .= '<td style="color:red; font-weight: bold;">'.$entry->user_login.'</td>';
				}else {
					$account_output .= '<td>'.$entry->user_login.'</td>';
				}
				$user_acct_edit_link = admin_url('user-edit.php?user_id=' . $entry->ID);
				$account_output .= '<td><a href="'.$user_acct_edit_link.'" target="_blank">'.__('Edit user', 'all-in-one-wp-security-and-firewall').'</a></td>';
				$account_output .= '</tr>';
			}
			$account_output .= '</table>';
		}
		return $account_output;
	}
} //end class
