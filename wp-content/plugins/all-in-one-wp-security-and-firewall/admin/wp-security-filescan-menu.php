<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * AIOWPSecurity_Filescan_Menu class for scanning file changes, maleware and available updates.
 *
 * @access public
 */
class AIOWPSecurity_Filescan_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * File scan menu slug
	 *
	 * @var string 
	 */
	protected $menu_page_slug = AIOWPSEC_FILESCAN_MENU_SLUG;

	/**
	 * Constructor adds menu for Scanner
	 */
	public function __construct() {
		parent::__construct(__('Scanner', 'all-in-one-wp-security-and-firewall'));
	}
	
	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'file-change-detect' => array(
				'title' => __('File change detection', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_file_change_detect'),
			),
			'malware-scan' => array(
				'title' => __('Malware scan', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_malware_scan'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * File change detection on your system files.
	 *
	 * @global $wpdb
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 */
	protected function render_file_change_detect() {
		global $wpdb, $aio_wp_security, $aiowps_feature_mgr;
		if (isset($_POST['fcd_scan_info'])) {
			// Display scan file change info and clear the global alert variable

			// Clear the global variable
			$aio_wp_security->configs->set_value('aiowps_fcds_change_detected', false, true);

			//Display the last scan results
			$this->display_last_scan_results();
		}

		if (isset($_POST['aiowps_view_last_fcd_results'])) {
			// Display the last scan results
			if (!$this->display_last_scan_results()) {
				$this->show_msg_updated(__('There have been no file changes since the last scan.', 'all-in-one-wp-security-and-firewall'));
			}
		}

		if (isset($_POST['aiowps_manual_fcd_scan'])) {
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-fcd-manual-scan-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for manual file change detection scan operation.", 4);
				die('Nonce check failed for manual file change detection scan operation.');
			}

			$result = $aio_wp_security->scan_obj->execute_file_change_detection_scan();
			if (false === $result) {
				// error case
				$this->show_msg_error(__('There was an error during the file change detection scan. Please check the AIOS logs.', 'all-in-one-wp-security-and-firewall'));
			}
			
			// If this is first scan display special message
			if (1 == $result['initial_scan']) {
				$this->show_msg_updated(__('The plugin has detected that this is your first file change detection scan. The file details from this scan will be used to detect file changes for future scans.', 'all-in-one-wp-security-and-firewall'));
			} elseif (!$aio_wp_security->configs->get_value('aiowps_fcds_change_detected')) {
				$this->show_msg_updated(__('Scan Complete - There were no file changes detected.', 'all-in-one-wp-security-and-firewall'));
			}
		}

		if (isset($_POST['aiowps_schedule_fcd_scan'])) { // Do form submission tasks
			$error = '';
			$reset_scan_data = FALSE;
			$file_types = '';
			$files = '';

			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-scheduled-fcd-scan-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for file change detection scan options save.", 4);
				die("Nonce check failed for file change detection scan options save.");
			}

			$fcd_scan_frequency = sanitize_text_field($_POST['aiowps_fcd_scan_frequency']);
			if (!is_numeric($fcd_scan_frequency)) {
				$error .= '<br>' . __('You entered a non numeric value for the "backup time interval" field. It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$fcd_scan_frequency = '4'; // Set it to the default value for this field
			}
			
			if (!empty($_POST['aiowps_fcd_exclude_filetypes'])) {
				$file_types = trim($_POST['aiowps_fcd_exclude_filetypes']);
				// $file_types_array = preg_split( '/\r\n|\r|\n/', $file_types );

				// Get the currently saved config value and check if this has changed. If so do another scan to reset the scan data so it omits these filetypes
				if ($file_types != $aio_wp_security->configs->get_value('aiowps_fcd_exclude_filetypes')) {
					$reset_scan_data = TRUE;
				}
			}
			
			if (!empty($_POST['aiowps_fcd_exclude_files'])) {
				$files = trim($_POST['aiowps_fcd_exclude_files']);
				//Get the currently saved config value and check if this has changed. If so do another scan to reset the scan data so it omits these files/dirs
				if ($files != $aio_wp_security->configs->get_value('aiowps_fcd_exclude_files')) {
					$reset_scan_data = TRUE;
				}
			}

			// Explode by end-of-line character, then trim and filter empty lines
			$email_list_array = array_filter(array_map('trim', explode("\n", $_POST['aiowps_fcd_scan_email_address'])), 'strlen');
			$errors = array();
			foreach ($email_list_array as $key => $value) {
				$email_sane = sanitize_email($value);
				if (!is_email($email_sane)) {
					$errors[] = __('The following address was removed because it is not a valid email address: ', 'all-in-one-wp-security-and-firewall')
						. htmlspecialchars($value);
					unset($email_list_array[$key]);
				}
			}
			$email_address = implode("\n", $email_list_array);
			if (!empty($errors)) {
				$this->show_msg_error(__('Attention:', 'all-in-one-wp-security-and-firewall') . '<br>' . implode('<br>', $errors));
			}

			// Save all the form values to the options
			$aio_wp_security->configs->set_value('aiowps_enable_automated_fcd_scan', isset($_POST["aiowps_enable_automated_fcd_scan"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_fcd_scan_frequency', absint($fcd_scan_frequency));
			$aio_wp_security->configs->set_value('aiowps_fcd_scan_interval', $_POST["aiowps_fcd_scan_interval"]);
			$aio_wp_security->configs->set_value('aiowps_fcd_exclude_filetypes', $file_types);
			$aio_wp_security->configs->set_value('aiowps_fcd_exclude_files', $files);
			$aio_wp_security->configs->set_value('aiowps_send_fcd_scan_email', isset($_POST["aiowps_send_fcd_scan_email"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_fcd_scan_email_address', $email_address);
			$aio_wp_security->configs->save_config();

			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
			$this->show_msg_settings_updated();
			
			// Let's check if backup interval was set to less than 24 hours
			if (isset($_POST["aiowps_enable_automated_fcd_scan"]) && ($fcd_scan_frequency < 24) && 0 == $_POST["aiowps_fcd_scan_interval"]) {
				$this->show_msg_updated(__('Attention: You have configured your file change detection scan to occur at least once daily.', 'all-in-one-wp-security-and-firewall') . ' ' . __('For most websites we recommended that you choose a less frequent schedule such as once every few days, once a week or once a month.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Choosing a less frequent schedule will also help reduce your server load.', 'all-in-one-wp-security-and-firewall'));
			}
			
			if ($reset_scan_data) {
				// Clear old scan row and ask user to perform a fresh scan to reset the data
				$aiowps_global_meta_tbl_name = AIOWPSEC_TBL_GLOBAL_META_DATA;
				$where = array('meta_key1' => 'file_change_detection', 'meta_value1' => 'file_scan_data');
				$wpdb->delete($aiowps_global_meta_tbl_name, $where);
				$result = $aio_wp_security->scan_obj->execute_file_change_detection_scan();
				$new_scan_alert = __('New scan completed: The plugin has detected that you have made changes to the "File Types To Ignore" or "Files To Ignore" fields.', 'all-in-one-wp-security-and-firewall').' '.__('In order to ensure that future scan results are accurate, the old scan data has been refreshed.', 'all-in-one-wp-security-and-firewall');
				$this->show_msg_updated($new_scan_alert);
			}
		}
		
		// Display an alert warning message if a file change was detected
		if ($aio_wp_security->configs->get_value('aiowps_fcds_change_detected')) {
			$error_msg = __('All In One WP Security & Firewall has detected that there was a change in your host\'s files.', 'all-in-one-wp-security-and-firewall');
			
			$button = '<div><form action="" method="POST"><input type="submit" name="fcd_scan_info" value="' . __('View scan details and clear this message', 'all-in-one-wp-security-and-firewall') . '" class="button-secondary" /></form></div>';
			$error_msg .= $button;
			$this->show_msg_error($error_msg);
		}
		
		$aio_wp_security->include_template('wp-admin/scanner/file-change-detect.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}
	
	/**
	 * Malware code scan on your system files.
	 *
	 * @return void
	 */
	protected function render_malware_scan() {
		global $aio_wp_security;
		
		$aio_wp_security->include_template('wp-admin/scanner/malware-scan.php', false, array());
	}
	
	/**
	 * Outputs the last scan results in a postbox
	 *
	 * @return void
	 */
	private function display_last_scan_results() {
		$fcd_data = AIOWPSecurity_Scan::get_fcd_data();
		if (!$fcd_data || !isset($fcd_data['last_scan_result'])) {
			// no fcd data found
			return false;
		}
		?>
		<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Latest file change scan results', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		$files_added_output = "";
		$files_removed_output = "";
		$files_changed_output = "";
		$last_scan_results = $fcd_data['last_scan_result'];
		if (!empty($last_scan_results['files_added'])) {
			// Output table of files added
			echo '<div class="aio_info_with_icon aio_spacer_10_tb">' . __('The following files were added to your host.', 'all-in-one-wp-security-and-firewall') . '</div>';
			$files_added_output .= '<table class="widefat">';
			$files_added_output .= '<tr>';
			$files_added_output .= '<th>' . __('File','all-in-one-wp-security-and-firewall') . '</th>';
			$files_added_output .= '<th>' . __('File size','all-in-one-wp-security-and-firewall') . '</th>';
			$files_added_output .= '<th>' . __('File modified','all-in-one-wp-security-and-firewall') . '</th>';
			$files_added_output .= '</tr>';
			foreach ($last_scan_results['files_added'] as $key => $value) {
				$files_added_output .= '<tr>';
				$files_added_output .= '<td>' . $key . '</td>';
				$files_added_output .= '<td>' . $value['filesize'] . '</td>';
				$files_added_output .= '<td>' . date('Y-m-d H:i:s', $value['last_modified']) . '</td>';
				$files_added_output .= '</tr>';
			}
			$files_added_output .= '</table>';
			echo $files_added_output;
		}
		echo '<div class="aio_spacer_15"></div>';
		if (!empty($last_scan_results['files_removed'])) {
			// Output table of files removed
			echo '<div class="aio_info_with_icon aio_spacer_10_tb">' . __('The following files were removed from your host.', 'all-in-one-wp-security-and-firewall') . '</div>';
			$files_removed_output .= '<table class="widefat">';
			$files_removed_output .= '<tr>';
			$files_removed_output .= '<th>'.__('File', 'all-in-one-wp-security-and-firewall').'</th>';
			$files_removed_output .= '<th>'.__('File size', 'all-in-one-wp-security-and-firewall').'</th>';
			$files_removed_output .= '<th>'.__('File modified', 'all-in-one-wp-security-and-firewall').'</th>';
			$files_removed_output .= '</tr>';
			foreach ($last_scan_results['files_removed'] as $key => $value) {
				$files_removed_output .= '<tr>';
				$files_removed_output .= '<td>' . $key . '</td>';
				$files_removed_output .= '<td>' . $value['filesize'] . '</td>';
				$files_removed_output .= '<td>' . date('Y-m-d H:i:s', $value['last_modified']) . '</td>';
				$files_removed_output .= '</tr>';
			}
			$files_removed_output .= '</table>';
			echo $files_removed_output;
		}

		echo '<div class="aio_spacer_15"></div>';

		if (!empty($last_scan_results['files_changed'])) {
			// Output table of files changed
			echo '<div class="aio_info_with_icon aio_spacer_10_tb">' . __('The following files were changed on your host.', 'all-in-one-wp-security-and-firewall') . '</div>';
			$files_changed_output .= '<table class="widefat">';
			$files_changed_output .= '<tr>';
			$files_changed_output .= '<th>' . __('File', 'all-in-one-wp-security-and-firewall') . '</th>';
			$files_changed_output .= '<th>' . __('File size', 'all-in-one-wp-security-and-firewall') . '</th>';
			$files_changed_output .= '<th>' . __('File modified', 'all-in-one-wp-security-and-firewall') . '</th>';
			$files_changed_output .= '</tr>';
			foreach ($last_scan_results['files_changed'] as $key => $value) {
				$files_changed_output .= '<tr>';
				$files_changed_output .= '<td>' . $key . '</td>';
				$files_changed_output .= '<td>' . $value['filesize'] . '</td>';
				$files_changed_output .= '<td>' . date('Y-m-d H:i:s', $value['last_modified']) . '</td>';
				$files_changed_output .= '</tr>';
			}
			$files_changed_output .= '</table>';
			echo $files_changed_output;
		}
		
		?>
		</div></div>
		<?php
	}
} //end class
