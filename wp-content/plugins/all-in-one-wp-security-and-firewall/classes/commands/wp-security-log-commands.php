<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Log_Commands_Trait')) return;

trait AIOWPSecurity_Log_Commands_Trait {

	/**
	 * Delete audit logs
	 *
	 * @param array $data - the request data contains the ID of the audit
	 *
	 * @return array
	 */
	public function delete_audit_log($data) {

		if (!isset($data['id'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Invalid audit log ID provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		include_once AIO_WP_SECURITY_PATH.'/admin/wp-security-list-audit.php';
		$audit_log_list = new AIOWPSecurity_List_Audit_Log();
		$message = $audit_log_list->delete_audit_event_records($data['id']);
		return array(
			'message' => $message,
			'status' => 'success'
		);
	}
		
	/**
	 * Clear debug logs
	 *
	 * @return array
	 */
	public function clear_debug_logs() {
		global $aio_wp_security;

		$ret = $aio_wp_security->debug_logger->clear_logs();
		
		if (is_wp_error($ret)) {
			return array(
				'status' => 'error',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(esc_html($ret->get_error_message()).'<p>'.esc_html($ret->get_error_data()).'</p>', true)
			);
		} else {
			return array(
				'status' => 'success',
				'message' => AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The debug logs have been cleared.', 'all-in-one-wp-security-and-firewall'), true)
			);
		}
	}
}
