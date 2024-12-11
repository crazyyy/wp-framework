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
			return $this->handle_response(false, AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No audit log ID provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		include_once AIO_WP_SECURITY_PATH.'/admin/wp-security-list-audit.php';
		$audit_log_list = new AIOWPSecurity_List_Audit_Log();

		return $this->handle_response(true, $audit_log_list->delete_audit_event_records($data['id']));
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
			return $this->handle_response(false, AIOWPSecurity_Admin_Menu::show_msg_error_st(__('No locked IP record ID provided.', 'all-in-one-wp-security-and-firewall'), true));
		}

		include_once AIO_WP_SECURITY_PATH . '/admin/wp-security-list-locked-ip.php';

		$locked_ip_list = new AIOWPSecurity_List_Locked_IP();
		$result = $locked_ip_list->delete_lockout_records($data['id']);
		return $this->handle_response(true, $result);
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
			return $this->handle_response(false, AIOWPSecurity_Admin_Menu::show_msg_error_st(esc_html($ret->get_error_message()).'<p>'.esc_html($ret->get_error_data()).'</p>', true));
		} else {
			return $this->handle_response(true, AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The debug logs have been cleared.', 'all-in-one-wp-security-and-firewall'), true));
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

	/**
	 * Exports the audit logs as a CSV file and sends the data as an AJAX response.
	 *
	 * This function retrieves audit log data, prepares it for export, and generates a CSV string.
	 * The CSV data is then sent back as part of an AJAX response, along with the filename for the CSV file.
	 *
	 * @return array
	 */
	public function export_audit_logs() {

		// Needed for rendering the audit log table
		include_once(AIO_WP_SECURITY_PATH.'/admin/wp-security-list-audit.php');
		$audit_log_list = new AIOWPSecurity_List_Audit_Log();

		$audit_log_list->prepare_items(true);
		$export_keys = array(
			'id' => 'ID',
			'created' => __('Date and time', 'all-in-one-wp-security-and-firewall'),
			'level' => __('Level', 'all-in-one-wp-security-and-firewall'),
			'network_id' => __('Network ID', 'all-in-one-wp-security-and-firewall'),
			'site_id' => __('Site ID', 'all-in-one-wp-security-and-firewall'),
			'username' => __('Username', 'all-in-one-wp-security-and-firewall'),
			'ip' => __('IP', 'all-in-one-wp-security-and-firewall'),
			'event_type' => __('Event', 'all-in-one-wp-security-and-firewall'),
			'details' => __('Details', 'all-in-one-wp-security-and-firewall'),
			'stacktrace' => __('Stack trace', 'all-in-one-wp-security-and-firewall')
		);

		$title = 'audit_event_logs.csv';
		ob_start();
		AIOWPSecurity_Admin_Init::aiowps_output_csv($audit_log_list->items, $export_keys, $title);

		$data = ob_get_clean();

		return array(
			'title' => $title,
			'data' => $data
		);
	}
}
