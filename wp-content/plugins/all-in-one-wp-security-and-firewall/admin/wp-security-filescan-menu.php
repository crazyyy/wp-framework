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
		global $aio_wp_security, $aiowps_feature_mgr;

		$fcd_data = AIOWPSecurity_Scan::get_fcd_data();
		$previous_scan = isset($fcd_data['last_scan_result']);

		if (isset($_POST['aiowps_schedule_fcd_scan'])) { // Do form submission tasks
			$errors = array();
			$reset_scan_data = false;
			$file_types = '';
			$files = '';

			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-scheduled-fcd-scan-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for file change detection scan options save.", 4);
				die("Nonce check failed for file change detection scan options save.");
			}

			$fcd_scan_frequency = sanitize_text_field($_POST['aiowps_fcd_scan_frequency']);
			if (!is_numeric($fcd_scan_frequency)) {
				$errors[] = __('You entered a non numeric value for the "backup time interval" field, it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$fcd_scan_frequency = '4'; // Set it to the default value for this field
			}
			
			if (!empty($_POST['aiowps_fcd_exclude_filetypes'])) {
				$file_types = trim($_POST['aiowps_fcd_exclude_filetypes']);
				// $file_types_array = preg_split( '/\r\n|\r|\n/', $file_types );

				// Get the currently saved config value and check if this has changed. If so do another scan to reset the scan data so it omits these filetypes
				if ($file_types != $aio_wp_security->configs->get_value('aiowps_fcd_exclude_filetypes')) {
					$reset_scan_data = true;
				}
			}
			
			if (!empty($_POST['aiowps_fcd_exclude_files'])) {
				$files = trim($_POST['aiowps_fcd_exclude_files']);
				//Get the currently saved config value and check if this has changed. If so do another scan to reset the scan data so it omits these files/dirs
				if ($files != $aio_wp_security->configs->get_value('aiowps_fcd_exclude_files')) {
					$reset_scan_data = true;
				}
			}

			// Explode by end-of-line character, then trim and filter empty lines
			$email_list_array = array_filter(array_map('trim', explode("\n", $_POST['aiowps_fcd_scan_email_address'])), 'strlen');
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
				$aio_wp_security->scan_obj->execute_file_change_detection_scan();
				$new_scan_alert = __('New scan completed: The plugin has detected that you have made changes to the "File Types To Ignore" or "Files To Ignore" fields.', 'all-in-one-wp-security-and-firewall').' '.__('In order to ensure that future scan results are accurate, the old scan data has been refreshed.', 'all-in-one-wp-security-and-firewall');
				$this->show_msg_updated($new_scan_alert);
			}
		}

		$next_fcd_scan_time = AIOWPSecurity_Scan::get_next_scheduled_scan();

		if (false == $next_fcd_scan_time) {
			$next_scheduled_scan = '<span>' . __('Nothing is currently scheduled', 'all-in-one-wp-security-and-firewall') . '</span>';
		} else {
			$scan_time = AIOWPSecurity_Utility::convert_timestamp($next_fcd_scan_time, 'D, F j, Y H:i');
			$next_scheduled_scan = '<span class="aiowps_next_scheduled_date_time">' . $scan_time . '</span>';
		}
		
		$aio_wp_security->include_template('wp-admin/scanner/file-change-detect.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'previous_scan' => $previous_scan, 'next_scheduled_scan' => $next_scheduled_scan));
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
}
