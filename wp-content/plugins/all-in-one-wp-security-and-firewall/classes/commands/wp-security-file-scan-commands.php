<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_File_Scan_Commands_Trait')) return;

trait AIOWPSecurity_File_Scan_Commands_Trait {

	/**
	 * Perform the operation to save file change detection settings.
	 *
	 * @param array $data The data containing the file change detection settings.
	 *
	 * @return array An array containing the status of the operation, any relevant messages,
	 *               and updated content.
	 */
	public function perform_save_file_detection_change_settings($data) {
		global $aio_wp_security;

		$info = array();
		$content = array();
		$options = array();
		$errors = array();
		$reset_scan_data = false;
		$file_types = '';
		$files = '';

		$fcd_scan_frequency = sanitize_text_field($data['aiowps_fcd_scan_frequency']);

		if (!is_numeric($fcd_scan_frequency)) {
			$errors[] = __('You entered a non numeric value for the "backup time interval" field, it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
			$fcd_scan_frequency = '4'; // Set it to the default value for this field
		}

		if (!empty($data['aiowps_fcd_exclude_filetypes'])) {
			$file_types = sanitize_textarea_field(trim($data['aiowps_fcd_exclude_filetypes']));

			// Get the currently saved config value and check if this has changed. If so do another scan to reset the scan data so it omits these filetypes
			if ($file_types != $aio_wp_security->configs->get_value('aiowps_fcd_exclude_filetypes')) {
				$reset_scan_data = true;
			}
		}

		if (!empty($data['aiowps_fcd_exclude_files'])) {
			$files = sanitize_textarea_field(trim($data['aiowps_fcd_exclude_files']));
			// Get the currently saved config value and check if this has changed. If so do another scan to reset the scan data so it omits these files/dirs
			if ($files != $aio_wp_security->configs->get_value('aiowps_fcd_exclude_files')) {
				$reset_scan_data = true;
			}
		}

		// Explode by end-of-line character, then trim and filter empty lines
		$email_list_array = array_filter(array_map('trim', explode("\n", $data['aiowps_fcd_scan_email_address'])), 'strlen');
		foreach ($email_list_array as $key => $value) {
			$email_sane = sanitize_email($value);
			if (!is_email($email_sane)) {
				$errors[] = __('The following address was removed because it is not a valid email address:', 'all-in-one-wp-security-and-firewall') . ' ' . htmlspecialchars($value);
				unset($email_list_array[$key]);
			}
		}
		$email_address = implode("\n", $email_list_array);
		if (!empty($errors)) {
			$info[] = implode('<br>', $errors);
		}

		// Save all the form values to the options
		$options['aiowps_enable_automated_fcd_scan'] = isset($data["aiowps_enable_automated_fcd_scan"]) ? '1' : '';
		$options['aiowps_fcd_scan_frequency'] = absint($fcd_scan_frequency);
		$options['aiowps_fcd_scan_interval'] = sanitize_text_field($data["aiowps_fcd_scan_interval"]);
		$options['aiowps_fcd_exclude_filetypes'] = $file_types;
		$options['aiowps_fcd_exclude_files'] = $files;
		$options['aiowps_send_fcd_scan_email'] = isset($data["aiowps_send_fcd_scan_email"]) ? '1' : '';
		$options['aiowps_fcd_scan_email_address'] = $email_address;
		$this->save_settings($options);

		$content['aios-file-change-info-box'] = '';
		// Let's check if backup interval was set to less than 24 hours
		if (isset($data["aiowps_enable_automated_fcd_scan"]) && ($fcd_scan_frequency < 24) && 0 == $data["aiowps_fcd_scan_interval"]) {
			$content['aios-file-change-info-box'] = '<div class="aio_yellow_box">';
			$content['aios-file-change-info-box'] .= '<p>' . __('You have configured your file change detection scan to occur at least once daily.', 'all-in-one-wp-security-and-firewall') . '</p>';
			$content['aios-file-change-info-box'] .= '<p>' . __('For most websites we recommended that you choose a less frequent schedule such as once every few days, once a week or once a month.', 'all-in-one-wp-security-and-firewall') . '</p>';
			$content['aios-file-change-info-box'] .= '<p>' . __('Choosing a less frequent schedule will also help reduce your server load.', 'all-in-one-wp-security-and-firewall') . '</p>';
			$content['aios-file-change-info-box'] .= '</div>';
		}

		if ($reset_scan_data) {
			$aio_wp_security->scan_obj->execute_file_change_detection_scan();
			$new_scan_alert = __('New scan completed: The plugin has detected that you have made changes to the "File Types To Ignore" or "Files To Ignore" fields.', 'all-in-one-wp-security-and-firewall').' '.__('In order to ensure that future scan results are accurate, the old scan data has been refreshed.', 'all-in-one-wp-security-and-firewall');
			$info[] = $new_scan_alert;
		}

		$next_fcd_scan_time = AIOWPSecurity_Scan::get_next_scheduled_scan();

		if (false == $next_fcd_scan_time) {
			$next_scheduled_scan = '<span>' . __('Nothing is currently scheduled', 'all-in-one-wp-security-and-firewall') . '</span>';
		} else {
			$scan_time = AIOWPSecurity_Utility::convert_timestamp($next_fcd_scan_time, 'D, F j, Y H:i');
			$next_scheduled_scan = '<span class="aiowps_next_scheduled_date_time">' . $scan_time . '</span>';
		}

		$content['aiowps-next-files-scan-inner'] = $next_scheduled_scan;
		$values = array('aiowps_fcd_scan_frequency' => absint($fcd_scan_frequency));
		$badges = array('scan-file-change-detection');

		$args = array(
			'content' => $content,
			'values' => $values,
			'badges' => $badges,
			'info' => $info
		);

		return $this->handle_response(true, '', $args);
	}


	/**
	 * Gets the last file scan result and returns the scan result HTML template
	 *
	 * @param array $data - the request data
	 *
	 * @return array
	 */
	public function get_last_scan_results($data) {
		global $aio_wp_security;

		if ($data['reset_change_detected']) $aio_wp_security->configs->set_value('aiowps_fcds_change_detected', false, true);

		$fcd_data = AIOWPSecurity_Scan::get_fcd_data();

		if (!$fcd_data || !isset($fcd_data['last_scan_result'])) {
			// no fcd data found
			$message = __('No previous scan data was found; either run a manual scan or schedule regular file scans', 'all-in-one-wp-security-and-firewall');
			return $this->handle_response(false, $message);
		}

		$content = array('aiowps_previous_scan_wrapper' => $aio_wp_security->include_template('wp-admin/scanner/scan-result.php', true, array('fcd_data' => $fcd_data)));

		return $this->handle_response(true, false, array('content' => $content));
	}

	/**
	 * Performs a file scan and returns the scan result
	 *
	 * @return array
	 */
	public function perform_file_scan() {
		global $aio_wp_security;

		$content = array();
		$extra_args = array();

		$result = $aio_wp_security->scan_obj->execute_file_change_detection_scan();

		if (false === $result) {
			// error case
			$message = __('There was an error during the file change detection scan.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Please check the plugin debug logs.', 'all-in-one-wp-security-and-firewall');
			return $this->handle_response(false, $message);
		}

		// If this is first scan display special message
		if (1 == $result['initial_scan']) {
			$extra_args['result'] = __('This is your first file change detection scan.', 'all-in-one-wp-security-and-firewall').' '.__('The details from this scan will be used for future scans.', 'all-in-one-wp-security-and-firewall'). ' <a href="#" class="aiowps_view_last_fcd_results">' . __('View the file scan results', 'all-in-one-wp-security-and-firewall') . '</a>';
			$content['aiowps-previous-files-scan-inner'] = '<a href="#" class="aiowps_view_last_fcd_results">' . __('View last file scan results', 'all-in-one-wp-security-and-firewall') . '</a>';
		} elseif (!$aio_wp_security->configs->get_value('aiowps_fcds_change_detected')) {
			$extra_args['result'] = __('The scan is complete - There were no file changes detected.', 'all-in-one-wp-security-and-firewall');
		} elseif ($aio_wp_security->configs->get_value('aiowps_fcds_change_detected')) {
			$extra_args['result'] = __('The scan has detected that there was a change in your website\'s files.', 'all-in-one-wp-security-and-firewall'). ' <a href="#" class="aiowps_view_last_fcd_results">' . __('View the file scan results', 'all-in-one-wp-security-and-firewall') . '</a>';
		}

		$args = array(
			'extra_args' => $extra_args,
			'content' => $content
		);

		return $this->handle_response(true, false, $args);
	}
}
