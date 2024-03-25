<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Ip_Commands_Trait')) return;

trait AIOWPSecurity_Ip_Commands_Trait {

	/**
	 * Delete locked ip
	 *
	 * @param array $data - the request data contains the ID of the locked ip
	 *
	 * @return array
	 */
	public function delete_locked_ip($data) {
		
		if (!isset($data['id'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid locked IP ID provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		include_once AIO_WP_SECURITY_PATH . '/admin/wp-security-list-locked-ip.php';
		
		$locked_ip_list = new AIOWPSecurity_List_Locked_IP();
		$result = $locked_ip_list->delete_lockout_records($data['id']);
		return array(
			'message' => $result,
			'status' => 'success'
		);
	}

	/**
	 * Unlocked ip
	 *
	 * @param array $data - the request data contains the ID of the locked ip
	 *
	 * @return array
	 */
	public function unlocked_ip($data) {

		if (!isset($data['id'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid locked IP ID provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		include_once AIO_WP_SECURITY_PATH . '/admin/wp-security-list-locked-ip.php';
		$locked_ip_list = new AIOWPSecurity_List_Locked_IP();
		$result = $locked_ip_list->unlock_ip_range($data['id']);
		return array(
			'message' => $result,
			'status' => 'success'
		);
	}

	/**
	 * Unblock ip
	 *
	 * @param array $data - the request data contains the ID of the blocked ip
	 *
	 * @return array
	 */
	public function unblock_ip($data) {
		
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
}
