<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_User_Security_Commands_Trait')) return;

trait AIOWPSecurity_User_Security_Commands_Trait {

	/**
	 * Performs the action to save the user enumeration prevention feature settings.
	 *
	 * @param array $data An array containing the data to be saved.
	 *                    The array may contain the following key:
	 *                    - 'aiowps_prevent_users_enumeration': A boolean indicating whether to enable user enumeration prevention.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               a message indicating the result of the operation,
	 *               and a badge representing the updated feature details.
	 */
	public function perform_save_user_enumeration($data) {
		global $aio_wp_security;

		$response = array(
			'status' => 'success'
		);

		// Save settings
		$aio_wp_security->configs->set_value('aiowps_prevent_users_enumeration', isset($data["aiowps_prevent_users_enumeration"]) ? '1' : '', true);

		$response['message'] = __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall');
		$response['badges'] = $this->get_features_id_and_html(array('disable-users-enumeration'));

		return $response;
	}

	/**
	 * Performs the action to change the admin username.
	 *
	 * @param array $data An array containing the data for changing the admin username.
	 *                    The array may contain the following keys:
	 *                    - 'aiowps_new_user_name': The new username to be set for the admin.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               and a message indicating the result of the operation.
	 *               If the operation is successful, it also includes a badge representing the updated feature details.
	 */
	public function perform_change_admin_username($data) {
		global $wpdb, $aio_wp_security;

		$response = array(
			'status' => 'success',
			'content' => array()
		);

		$error = '';
		if (!empty($data['aiowps_new_user_name'])) {
			$new_username = sanitize_text_field($data['aiowps_new_user_name']);
			if (validate_username($new_username)) {
				if (AIOWPSecurity_Utility::check_user_exists($new_username)) {
					$response['status'] = 'error';
					$error = sprintf(__('Username: %s already exists, please enter another value.', 'all-in-one-wp-security-and-firewall'), $new_username);
				} else {
					// let's check if currently logged in username is 'admin'
					$user = wp_get_current_user();
					$user_login = $user->user_login;
					if ('admin' == strtolower($user_login)) {
						$username_is_admin = true;
					} else {
						$username_is_admin = false;
					}
					// Now let's change the username
					$sql = $wpdb->prepare("UPDATE `" . $wpdb->users . "` SET user_login = '" . esc_sql($new_username) . "' WHERE user_login=%s", "admin");
					$result = $wpdb->query($sql);
					if (false === $result) {
						// There was an error updating the users table
						$user_update_error = __('The database update operation of the user account failed.', 'all-in-one-wp-security-and-firewall');
						$response['status'] = 'error';
						$response['message'] = $user_update_error;
						$aio_wp_security->debug_logger->log_debug($user_update_error . ' ' . $wpdb->last_error, 4);
						return $response;
					}

					// multisite considerations
					if (is_multisite()) { // process sitemeta if we're in a multi-site situation
						$oldAdmins = $wpdb->get_var("SELECT meta_value FROM `" . $wpdb->sitemeta . "` WHERE meta_key = 'site_admins'");
						$newAdmins = str_replace('5:"admin"', strlen($new_username) . ':"' . esc_sql($new_username) . '"', $oldAdmins);
						$wpdb->query("UPDATE `" . $wpdb->sitemeta . "` SET meta_value = '" . esc_sql($newAdmins) . "' WHERE meta_key = 'site_admins'");
					}

					// If user is logged in with username "admin" then log user out and send to login page so they can login again
					if ($username_is_admin) {
						// Lets logout the user
						$aio_wp_security->debug_logger->log_debug("Logging user out with login ".$user_login. " because they changed their username.");
						$after_logout_url = AIOWPSecurity_Utility::get_current_page_url();
						$after_logout_payload = array('redirect_to' => $after_logout_url, 'msg' => $aio_wp_security->user_login_obj->key_login_msg.'=admin_user_changed');
						//Save some of the logout redirect data to a transient
						is_multisite() ? set_site_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60) : set_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60);

						$logout_url = AIOWPSEC_WP_URL.'?aiowpsec_do_log_out=1';
						$logout_url = AIOWPSecurity_Utility::add_query_data_to_url($logout_url, 'al_additional_data', '1');

						$response['logout_user'] = true;
						$response['logout_url'] = $logout_url;
					}
				}
			} else { // An invalid username was entered
				$error = __('You entered an invalid username, please enter another value.', 'all-in-one-wp-security-and-firewall');
			}
		} else { // No username value was entered
			$response['status'] = 'error';
			$error = __('Please enter a value for your username.', 'all-in-one-wp-security-and-firewall');
		}

		if (!empty($error)) { // We have some validation or other error
			$response['message'] = $error;
		} else {
			$response['message'] = __('The username has been successfully changed.', 'all-in-one-wp-security-and-firewall');
			$response['badges'] = $this->get_features_id_and_html(array('user-accounts-change-admin-user'));
			$response['content']['change-admin-username-content'] = $aio_wp_security->include_template('wp-admin/user-security/partials/wp-username-content.php', true);
		}

		return $response;
	}

	/**
	 * Performs the action to save the login lockout settings.
	 *
	 * @param array $data An array containing the data to be saved.
	 *
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               a message indicating the result of the operation,
	 *               and a badge representing the updated feature details.
	 */
	public function perform_save_login_lockout_settings($data) {

		$response = array(
			'status' => 'success',
			'values' => array(),
			'info' => array()
		);

		$invalid_fields = array();

		$max_login_attempt_val = sanitize_text_field($data['aiowps_max_login_attempts']);
		if (!is_numeric($max_login_attempt_val) || 1 > $max_login_attempt_val) {
			$invalid_fields[] = 'max login attempts';
			$max_login_attempt_val = '3'; // Set it to the default value for this field
		}

		$login_retry_time_period = sanitize_text_field($data['aiowps_retry_time_period']);
		if (!is_numeric($login_retry_time_period) || 1 > $login_retry_time_period) {
			$invalid_fields[] = 'login retry time period';
			$login_retry_time_period = '5'; // Set it to the default value for this field
		}

		$lockout_time_length = sanitize_text_field($data['aiowps_lockout_time_length']);
		if (!is_numeric($lockout_time_length) || 1 > $lockout_time_length) {
			$invalid_fields[] = 'minimum lockout time length';
			$lockout_time_length = '5'; // Set it to the default value for this field
		}

		$max_lockout_time_length = sanitize_text_field($data['aiowps_max_lockout_time_length']);
		if (!is_numeric($max_lockout_time_length) || 1 > $max_lockout_time_length) {
			$invalid_fields[] = 'maximum lockout time length';
			$max_lockout_time_length = '60'; // Set it to the default value for this field
		}

		if ($lockout_time_length >= $max_lockout_time_length) {
			$invalid_fields[] = 'minimum lockout time length';
			$lockout_time_length = '5'; // Set it to the default value for this field
			$max_lockout_time_length = '60'; // Set it to the default value for this field
		}

		$email_addresses = isset($data['aiowps_email_address']) ? stripslashes($data['aiowps_email_address']) : get_bloginfo('admin_email');
		$email_addresses_trimmed = AIOWPSecurity_Utility::explode_trim_filter_empty($email_addresses, "\n");
		// Read into array, sanitize, filter empty and keep only unique usernames.
		$email_address_list = array_unique(
			array_filter(
				array_map(
					'sanitize_email',
					$email_addresses_trimmed
				),
				'is_email'
			)
		);

		if (isset($data['aiowps_enable_email_notify']) && 1 == $data['aiowps_enable_email_notify'] && 0 == count($email_addresses_trimmed)) {
			$invalid_fields[] = 'email addresses';
		} elseif (isset($data['aiowps_enable_email_notify']) && 1 == $data['aiowps_enable_email_notify'] && (0 == count($email_address_list) || count($email_address_list) != count($email_addresses_trimmed))) {
			$invalid_fields[] = 'email addresses';
		}
		if (isset($data['aiowps_enable_email_notify']) && 0 == count($email_address_list)) {
			$email_address_list[] = get_bloginfo('admin_email');
		}

		// Instantly lockout specific usernames
		$instantly_lockout_specific_usernames = isset($data['aiowps_instantly_lockout_specific_usernames']) ? $data['aiowps_instantly_lockout_specific_usernames'] : '';
		// Read into array, sanitize, filter empty and keep only unique usernames.
		$instantly_lockout_specific_usernames = array_unique(
			array_filter(
				array_map(
					'sanitize_user',
					AIOWPSecurity_Utility::explode_trim_filter_empty($instantly_lockout_specific_usernames)
				),
				'strlen'
			)
		);

		$response['message'] = __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall');

		if (!empty($invalid_fields)) {
			$invalid_fields = array_unique($invalid_fields);
			$invalid_fields = implode(", ", $invalid_fields);
			$response['info'][] = sprintf(__('The following options had invalid values and have been set to the defaults: %s', 'all-in-one-wp-security-and-firewall'), $invalid_fields);
		}

		$options = array();

		// Save all the form values to the options
		$random_20_digit_string = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(20); // Generate random 20 char string for use during CAPTCHA encode/decode
		$options['aiowps_unlock_request_secret_key'] = $random_20_digit_string;

		$options['aiowps_enable_login_lockdown'] = isset($data["aiowps_enable_login_lockdown"]) ? '1' : '';
		$options['aiowps_allow_unlock_requests'] = isset($data["aiowps_allow_unlock_requests"]) ? '1' : '';
		$options['aiowps_max_login_attempts'] = absint($max_login_attempt_val);
		$options['aiowps_retry_time_period'] = absint($login_retry_time_period);
		$options['aiowps_lockout_time_length'] = absint($lockout_time_length);
		$options['aiowps_max_lockout_time_length'] = absint($max_lockout_time_length);
		$options['aiowps_set_generic_login_msg'] = isset($data["aiowps_set_generic_login_msg"]) ? '1' : '';
		$options['aiowps_enable_invalid_username_lockdown']= isset($data["aiowps_enable_invalid_username_lockdown"]) ? '1' : '';
		$options['aiowps_instantly_lockout_specific_usernames'] = $instantly_lockout_specific_usernames;
		$options['aiowps_enable_email_notify'] = isset($data["aiowps_enable_email_notify"]) ? '1' : '';
		$options['aiowps_enable_php_backtrace_in_email'] = isset($data['aiowps_enable_php_backtrace_in_email']) ? '1' : '';
		$options['aiowps_email_address'] = $email_address_list;
		$this->save_settings($options);

		$response['values']['aiowps_max_login_attempts'] = absint($max_login_attempt_val);
		$response['values']['aiowps_retry_time_period'] = absint($login_retry_time_period);
		$response['values']['aiowps_lockout_time_length'] = absint($lockout_time_length);
		$response['values']['aiowps_max_lockout_time_length'] = absint($max_lockout_time_length);
		$response['values']['aiowps_email_address'] = implode("\n", $email_address_list);

		$response['badges'] = $this->get_features_id_and_html(array('user-login-login-lockdown'));

		return $response;
	}

	/**
	 * Performs the action to save the login lockout whitelist settings.
	 *
	 * @param array $data An array containing the data to be saved.
	 *                    The array may contain the following keys:
	 *                    - 'aiowps_lockdown_enable_whitelisting': A boolean indicating whether whitelisting is enabled.
	 *                    - 'aiowps_lockdown_allowed_ip_addresses': The allowed IP addresses for whitelisting.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               a message indicating the result of the operation,
	 *               and a badge representing the updated feature details.
	 */
	public function perform_save_login_lockout_whitelist_settings($data) {
		global $aio_wp_security;

		$response = array(
			'status' => 'success'
		);

		$options = array();
		$result = 1;

		if (!empty($data['aiowps_lockdown_allowed_ip_addresses'])) {
			$ip_addresses = sanitize_textarea_field(wp_unslash($data['aiowps_lockdown_allowed_ip_addresses']));
			$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ip_addresses);
			$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'whitelist');
			if (is_wp_error($validated_ip_list_array)) {
				$result = -1;
				$response['status'] = 'error';
				$response['message'] = AIOWPSecurity_Admin_Menu::show_msg_error_st(nl2br($validated_ip_list_array->get_error_message()), true);
			} else {
				$allowed_ip_data = implode("\n", $validated_ip_list_array);
				$options['aiowps_lockdown_allowed_ip_addresses'] = $allowed_ip_data;
			}
		} else {
			$options['aiowps_lockdown_allowed_ip_addresses'] = ''; //Clear the IP address config value
		}

		if (1 == $result) {
			$aio_wp_security->configs->set_value('aiowps_lockdown_enable_whitelisting', isset($data["aiowps_lockdown_enable_whitelisting"]) ? '1' : '', true);
			$response['message'] = __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall');
			$response['badges'] = $this->get_features_id_and_html(array('user-login-lockout-ip-whitelisting'));
		}

		$this->save_settings($options);

		return $response;
	}

	/**
	 * Performs the action to force logout users.
	 *
	 * @param array $data An array containing the data to be saved.
	 *                    The array may contain the following keys:
	 *                    - 'aiowps_logout_time_period': The time period (in minutes) for logout.
	 *                    - 'aiowps_enable_forced_logout': A boolean indicating whether forced logout is enabled.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               an array of messages indicating the result of the operation,
	 *               the content representing the logout time period,
	 *               and a badge representing the updated feature details.
	 */
	public function perform_force_logout($data) {
		global $aio_wp_security;
		$response = array(
			'status' => 'success',
			'info' => array(),
			'values' => array()
		);

		$options = array();


		$logout_time_period = sanitize_text_field($data['aiowps_logout_time_period']);
		if (isset($data["aiowps_enable_forced_logout"]) && (!is_numeric($logout_time_period) || $logout_time_period < 1)) {
			$response['info'][] = __('You entered a non numeric or negative value for the logout time period field, it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
			$logout_time_period = '60'; // Set it to the default value for this field
		}

		// Save all the form values to the options
		$options['aiowps_logout_time_period'] = absint($logout_time_period);
		$options['aiowps_enable_forced_logout'] = isset($data["aiowps_enable_forced_logout"]) ? '1' : '';
		$this->save_settings($options);

		$response['values']['aiowps_logout_time_period'] = absint($logout_time_period);
		$response['badges'] = $this->get_features_id_and_html(array('user-login-force-logout'));
		$response['message'] = __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall');

		if ('1' === $options['aiowps_enable_forced_logout']) {
			$response['logout_user'] = $this->check_logout_user();
			$response['logout_url'] = $aio_wp_security->user_login_obj->aiowps_force_logout_action_handler(true);
		}

		return $response;
	}

	/**
	 * Performs the action to disable application password.
	 *
	 * @param array $data An array containing the data to be saved.
	 *                    The array may contain the following key:
	 *                    - 'aiowps_disable_application_password': A boolean indicating whether application password is disabled.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               a message indicating the result of the operation,
	 *               and a badge representing the updated feature details.
	 */
	public function perform_disable_application_password($data) {
		global $aio_wp_security;

		// Save all the form values to the options
		$aio_wp_security->configs->set_value('aiowps_disable_application_password', isset($data['aiowps_disable_application_password']) ? '1' : '', true);

		return array(
			'status' => 'success',
			'message' => __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall'),
			'badges' => $this->get_features_id_and_html(array('disable-application-password'))
		);
	}

	/**
	 * Performs the action to add salt postfix.
	 *
	 * @param array $data An array containing the data to be saved.
	 *                    The array may contain the following key:
	 *                    - 'aiowps_enable_salt_postfix': A boolean indicating whether salt postfix is enabled.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               a message indicating the result of the operation,
	 *               and a badge representing the updated feature details.
	 */
	public function perform_add_salt_postfix($data) {
		global $aio_wp_security;

		$response = array(
			'status' => 'success'
		);

		// Save settings
		$aiowps_enable_salt_postfix = isset($data['aiowps_enable_salt_postfix']) ? '1' : '';
		if ($aiowps_enable_salt_postfix == $aio_wp_security->configs->get_value('aiowps_enable_salt_postfix')) {
			$is_setting_changed = true;
		} else {
			$is_setting_changed = false;
		}

		$aio_wp_security->configs->set_value('aiowps_enable_salt_postfix', $aiowps_enable_salt_postfix, true);
		$ret_schedule = $this->schedule_change_auth_keys_and_salt();

		if (is_wp_error($ret_schedule)) {
			$aio_wp_security->debug_logger->log_debug($ret_schedule->get_error_message(), 4);
		}

		if ('1' == $aiowps_enable_salt_postfix && $is_setting_changed) {
			AIOWPSecurity_Utility::change_salt_postfixes();
		}

		$response['message'] = __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall');
		$response['badges'] = $this->get_features_id_and_html(array('enable-salt-postfix'));

		return $response;
	}

	/**
	 * Performs actions on logged-in users.
	 *
	 * @param array $data An array containing the data for the action to be performed.
	 *                    The array may contain the following keys:
	 *                    - 'action': The action to be performed on logged-in users (e.g., 'force_user_logout').
	 *                    - 'logged_in_id': The ID of the logged-in user on which the action will be performed.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               and a message indicating the result of the operation.
	 */
	public function perform_logged_in_user_action($data) {
		global $aio_wp_security;
		include_once AIO_WP_SECURITY_PATH.'/admin/wp-security-list-logged-in-users.php'; // For rendering the AIOWPSecurity_List_Table
		$user_list = new AIOWPSecurity_List_Logged_In_Users();
		$response = array(
			'status' => 'success'
		);

		if (empty($data['action']) || !in_array($data['action'], array('force_user_logout'))) { // more actions can be added
			return array(
				'status' => 'error',
				'message' => __('Invalid action provided for logged in user.', 'all-in-one-wp-security-and-firewall')
			);
		}

		if ('force_user_logout' == $data['action']) {
			if (empty($data['logged_in_id'])) {
				return array(
					'status' => 'error',
					'message' => __('No user ID was provided', 'all-in-one-wp-security-and-firewall')
				);
			}
			$user_id = strip_tags($data['logged_in_id']);

			if (!is_numeric($user_id)) {
				$error = __("Invalid user ID provided.", 'all-in-one-wp-security-and-firewall');
			} elseif (get_current_user_id() == $user_id) {
				$error = __("You cannot log yourself out", 'all-in-one-wp-security-and-firewall');
			} elseif (is_super_admin($user_id)) {
				$error = __("Super admins cannot be logged out.", 'all-in-one-wp-security-and-firewall');
			} elseif (!AIOWPSecurity_Utility::is_user_member_of_blog($user_id)) {
				$error = __("You cannot log out a user from a different subsite.", 'all-in-one-wp-security-and-firewall');
			}
			if ($error) {
				return array(
					'message' => $error,
					'status' => 'error'
				);
			}

			$users = esc_sql($user_id);
			$result = $aio_wp_security->user_login_obj->delete_logged_in_user($users);

			if ($result) {
				$user_list->logout_user($users);
				$response['message'] = __('The selected user has been logged out successfully.', 'all-in-one-wp-security-and-firewall');
			} else {
				$response['message']  = __('Failed to log out the selected user.', 'all-in-one-wp-security-and-firewall');
				$response['status'] = 'error';
			}

		}

		return $response;
	}

	/**
	 * Performs the action to configure manual registration approval settings.
	 *
	 * @param array $data An array containing the data to be saved.
	 *                    The array may contain the following key:
	 *                    - 'aiowps_enable_manual_registration_approval': A boolean indicating whether manual registration approval is enabled.
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               a message indicating the result of the operation,
	 *               and a badge representing the updated feature details.
	 */
	public function perform_manual_approval_settings($data) {
		global $aio_wp_security;

		// Save settings
		$aio_wp_security->configs->set_value('aiowps_enable_manual_registration_approval', isset($data["aiowps_enable_manual_registration_approval"]) ? '1' : '', true);

		return array(
			'status' => 'success',
			'message' => __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall'),
			'badges' => $this->get_features_id_and_html(array('manually-approve-registrations'))
		);
	}

	/**
	 * Performs actions on manual approval items (e.g., approve account, delete account, block IP).
	 *
	 * @param array $data An array containing the data for the action to be performed.
	 *                    The array may contain the following keys:
	 *                    - 'action': The action to be performed on the manual approval item (e.g., 'approve_acct', 'delete_acct', 'block_ip').
	 *                    - 'user_id': The ID of the user for whom the action will be performed (applicable for 'approve_acct' and 'delete_acct' actions).
	 *                    - 'ip_address': The IP address to be blocked (applicable for 'block_ip' action).
	 * @return array Returns an array containing the status of the operation ('success' or 'error'),
	 *               and a message indicating the result of the operation.
	 */
	public function perform_manual_approval_item_action($data) {
		global $aio_wp_security;

		include_once AIO_WP_SECURITY_PATH.'/admin/wp-security-list-registered-users.php'; // For rendering the AIOWPSecurity_List_Table
		$user_list = new AIOWPSecurity_List_Registered_Users();
		$status = 'error';

		$valid_actions = array('approve_acct', 'delete_acct', 'block_ip');
		if (empty($data['action']) || !in_array($data['action'], $valid_actions)) { // more actions can be added
			return array(
				'status' => 'error',
				'message' => __('Invalid action provided for registered user.', 'all-in-one-wp-security-and-firewall')
			);
		}

		switch ($data['action']) {
			case 'approve_acct':
				if (empty($data['user_id'])) {
					return array(
						'status' => 'error',
						'message' => __('No valid user ID was provided', 'all-in-one-wp-security-and-firewall')
					);
				}
				$user_id = esc_sql(strip_tags($data['user_id']));
				$meta_key = 'aiowps_account_status';
				$meta_value = 'approved'; // set account status

				// Approve single account
				$result = update_user_meta($user_id, $meta_key, $meta_value);
				if ($result) {
					$user = get_user_by('id', $user_id);
					$user_list->send_email_upon_account_activation($user);
					$message = __('The selected account was approved successfully.', 'all-in-one-wp-security-and-firewall');
					$status = 'success';
				} elseif (false === $result) {
					$aio_wp_security->debug_logger->log_debug("could not approve account ID: $user_id", 4);
					$message = __('The selected account could not be approved.', 'all-in-one-wp-security-and-firewall');
				}
				break;
			case 'delete_acct':
				if (empty($data['user_id'])) {
					return array(
						'status' => 'error',
						'message' => __('No valid user ID was provided', 'all-in-one-wp-security-and-firewall')
					);
				}

				$user_id = esc_sql(strip_tags($data['user_id']));
				// Delete single account
				$result = wp_delete_user($user_id);
				if (true === $result) {
					$message = __('The selected account was deleted successfully.', 'all-in-one-wp-security-and-firewall');
					$status = 'success';
				} else {
					$aio_wp_security->debug_logger->log_debug("could not delete account ID: $user_id", 4);
					$message = __('The selected account could not be deleted.', 'all-in-one-wp-security-and-firewall');
				}
				break;
			case 'block_ip':
				if (empty($data['ip_address'])) {
					return array(
						'status' => 'error',
						'message' => __('No valid IP address was provided', 'all-in-one-wp-security-and-firewall')
					);
				}

				$ip = esc_sql(strip_tags($data['ip_address']));

				if (AIOWPSecurity_Utility_IP::get_user_ip_address() == $ip) {
					$message = __('You cannot block your own IP address:', 'all-in-one-wp-security-and-firewall') . ' ' . $ip;
					break;
				}

				// Block single IP
				$result = AIOWPSecurity_Blocking::add_ip_to_block_list($ip, 'registration_spam');
				if (true === $result) {
					$message = __('The selected IP was successfully added to the permanent block list.', 'all-in-one-wp-security-and-firewall');
					$message .= ' <a href="admin.php?page='.AIOWPSEC_MAIN_MENU_SLUG.'&tab=permanent-block" target="_blank">'.__('View Blocked IPs', 'all-in-one-wp-security-and-firewall').'</a>';
					$status = 'success';
				} else {
					$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_List_Registered_Users::block_selected_ips() - could not block IP: $ip", 4);
					$message = __('The selected IP could not be added to the permanent block list.', 'all-in-one-wp-security-and-firewall');
				}
				break;
		}

		return array(
			'status' => $status,
			'message' => $message
		);
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

	/**
	 * Checks if the current user should be automatically logged out based on last login time.
	 *
	 * This method compares the current time with the last login time of the user and determines
	 * if the user should be logged out based on a configured logout time period.
	 *
	 * @return bool Returns true if the user should be logged out, false otherwise.
	 */
	private function check_logout_user() {
		global $aio_wp_security;

		// Get the current user
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		// Get the current and last login times
		$current_time = current_time('mysql', true);
		$login_time = $aio_wp_security->user_login_obj->get_wp_user_aiowps_last_login_time($user_id);

		// Return false if login time is empty (no last login recorded)
		if (empty($login_time)) {
			return false;
		}

		// Calculate the time difference between current time and last login time
		$diff = strtotime($current_time) - strtotime($login_time);

		// Get the configured logout time period in seconds
		$logout_time_interval_value = $aio_wp_security->configs->get_value('aiowps_logout_time_period');
		$logout_time_interval_val_seconds = $logout_time_interval_value * 60;

		// Return true if the time difference exceeds the logout time interval, indicating the user should be logged out
		return $diff > $logout_time_interval_val_seconds;
	}

}
