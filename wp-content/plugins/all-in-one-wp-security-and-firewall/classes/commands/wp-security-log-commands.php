<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Log_Commands_Trait')) return;

trait AIOWPSecurity_Log_Commands_Trait {

	/**
	 * Deletes an audit log.
	 *
	 * @param array $data Contains the ID of the log to be deleted.
	 *
	 * @return array
	 */
	public function delete_audit_log($data) {

		if (!isset($data['id'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No audit log ID provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		include_once AIO_WP_SECURITY_PATH.'/admin/wp-security-list-audit.php';
		$audit_log_list = new AIOWPSecurity_List_Audit_Log();

		return array(
			'status' => 'success',
			'message' => $audit_log_list->delete_audit_event_records($data['id']),
		);
	}

	/**
	 * Deletes an IP lockout record.
	 *
	 * @param array $data Contains the ID of the entry in the AIOWPSEC_TBL_LOGIN_LOCKOUT table.
	 *
	 * @return array
	 */
	public function delete_locked_ip_record($data) {

		if (!isset($data['id'])) {
			return array('status' => 'error', 'message' => AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No locked IP record ID provided.', 'all-in-one-wp-security-and-firewall'), true));
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

	/**
	 * Renders the audit log tab content.
	 *
	 * This function handles the rendering of the audit log tab content based on the
	 * provided data via AJAX request. The data is used to filter the audit log or perform actions
	 *
	 * @access public
	 * @return void
	 */
	public function render_audit_log_tab() {

		if (empty($_POST['data'])) return;

		$data = stripslashes_deep($_POST['data']);

		// Needed for rendering the audit log table
		include_once(AIO_WP_SECURITY_PATH.'/admin/wp-security-list-audit.php');
		$audit_log_list = new AIOWPSecurity_List_Audit_Log($data);
		$audit_log_list->ajax_response();
	}
}
