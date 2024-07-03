<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Ip_Commands_Trait')) return;

trait AIOWPSecurity_Ip_Commands_Trait {

	/**
	 * Unlocks an IP.
	 *
	 * @param array $data Contains the IP address to be unlocked.
	 *
	 * @return array
	 */
	public function unlock_ip($data) {

		if (!isset($data['ip'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		if (!AIOWPSecurity_Utility::unlock_ip($data['ip'])) {
			return array(
				'status' => 'error',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Failed to unlock the selected IP address.', 'all-in-one-wp-security-and-firewall'), true)
			);
		} else {
			return array(
				'status' => 'success',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP address was unlocked successfully.', 'all-in-one-wp-security-and-firewall'), true)
			);
		}
	}

	/**
	 * Unblacklists an IP.
	 *
	 * @param array $data Contains the IP address to be unblacklisted.
	 *
	 * @return array
	 */
	public function unblacklist_ip($data) {

		if (!isset($data['ip'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		if (!AIOWPSecurity_Utility::unblacklist_ip($data['ip'])) {
			return array(
				'status' => 'error',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Failed to unblacklist the selected IP address.', 'all-in-one-wp-security-and-firewall'), true)
			);
		} else {
			return array(
				'status' => 'success',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP address was unblacklisted successfully.', 'all-in-one-wp-security-and-firewall'), true)
			);
		}
	}

	/**
	 * Unblocks an IP by permanent block record ID.
	 *
	 * @param array $data Contains the ID of the entry in the AIOWPSEC_TBL_PERM_BLOCK table.
	 *
	 * @return array
	 */
	public function blocked_ip_list_unblock_ip($data) {

		if (!isset($data['id'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid blocked IP ID provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		include_once AIO_WP_SECURITY_PATH . '/admin/wp-security-list-permanent-blocked-ip.php'; // For rendering the AIOWPSecurity_List_Table
		$blocked_ip_list = new AIOWPSecurity_List_Blocked_IP(); // For rendering the AIOWPSecurity_List_Table
		$result = $blocked_ip_list->unblock_ip_address($data['id']);

		return array(
			'message' => $result,
			'status' => 'success'
		);
	}

	/**
	 * Locks an IP.
	 *
	 * @param array $data Contains the IP address to be locked.
	 *
	 * @return array
	 */
	public function lock_ip($data) {

		if (!isset($data['ip'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		if (!isset($data['lock_reason'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No lockout reason provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		AIOWPSecurity_Utility::lock_ip($data['ip'], $data['lock_reason']);

		return array(
			'status' => 'success',
			'message' => AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP address is now temporarily locked.', 'all-in-one-wp-security-and-firewall'), true)
		);
	}

	/**
	 * Blacklists an IP.
	 *
	 * @param array $data Contains the IP address to be blacklisted.
	 *
	 * @return array
	 */
	public function blacklist_ip($data) {

		if (!isset($data['ip'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		$result = AIOWPSecurity_Utility::blacklist_ip($data['ip']);

		if (is_wp_error($result)) {
			return array(
				'status' => 'error',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(nl2br($result->get_error_message()), true)
			);
		} else {
			return array(
				'status' => 'success',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP address has been added to the blacklist.', 'all-in-one-wp-security-and-firewall'), true)
			);
		}
	}
}
