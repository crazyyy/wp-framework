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
			return $this->handle_response(false, __('No IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return $this->handle_response(false, __('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		if (!AIOWPSecurity_Utility::unlock_ip($data['ip'])) {
			return $this->handle_response(false, __('Failed to unlock the selected IP address.', 'all-in-one-wp-security-and-firewall'));
		} else {
			return $this->handle_response(true, __('The selected IP address was unlocked successfully.', 'all-in-one-wp-security-and-firewall'));
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
			return $this->handle_response(false, __('No IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return $this->handle_response(false, __('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		if (!AIOWPSecurity_Utility::unblacklist_ip($data['ip'])) {
			return $this->handle_response(false, __('Failed to unblacklist the selected IP address.', 'all-in-one-wp-security-and-firewall'));
		} else {
			return $this->handle_response(true, __('The selected IP address was unblacklisted successfully.', 'all-in-one-wp-security-and-firewall'));
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
			return $this->handle_response(false, __('Invalid blocked IP ID provided.', 'all-in-one-wp-security-and-firewall'));
		}

		include_once AIO_WP_SECURITY_PATH . '/admin/wp-security-list-permanent-blocked-ip.php'; // For rendering the AIOWPSecurity_List_Table
		$blocked_ip_list = new AIOWPSecurity_List_Blocked_IP(); // For rendering the AIOWPSecurity_List_Table
		$result = $blocked_ip_list->unblock_ip_address($data['id']);

		if (false === $result) {
			$message = __('Failed to unblock and delete the selected record(s).', 'all-in-one-wp-security-and-firewall');
		} else {
			$message = __('Successfully unblocked and deleted the selected record(s).', 'all-in-one-wp-security-and-firewall');
		}
		return $this->handle_response(true, $message);
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
			return $this->handle_response(false, __('No IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return $this->handle_response(false, __('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		if (!isset($data['lock_reason'])) {
			return $this->handle_response(false, __('No lockout reason provided.', 'all-in-one-wp-security-and-firewall'));
		}

		AIOWPSecurity_Utility::lock_ip($data['ip'], $data['lock_reason']);

		return $this->handle_response(true, __('The selected IP address is now temporarily locked.', 'all-in-one-wp-security-and-firewall'));
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
			return $this->handle_response(false, __('No IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
			return $this->handle_response(false, __('Invalid IP provided.', 'all-in-one-wp-security-and-firewall'));
		}

		$result = AIOWPSecurity_Utility::blacklist_ip($data['ip']);

		if (is_wp_error($result)) {
			return $this->handle_response(false, nl2br($result->get_error_message()));
		} else {
			return $this->handle_response(true, __('The selected IP address has been added to the blacklist.', 'all-in-one-wp-security-and-firewall'));
		}
	}
}
