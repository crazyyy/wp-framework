<?php
if (!defined('ABSPATH')) {
	exit; // Prevent direct access to file
}
class AIOWPSecurity_Filesystem_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Filesystem menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_FILESYSTEM_MENU_SLUG;
	
	/**
	 * Constructor adds menu for Filesystem security
	 */
	public function __construct() {
		parent::__construct(__('File security', 'all-in-one-wp-security-and-firewall'));
		add_action('admin_footer', array($this, 'filesystem_menu_footer_code'));
	}
	
	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'file-permissions' => array(
				'title' => __('File permissions', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_file_permissions'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'file-protection' => array(
				'title' => __('File protection', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_file_protection'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'host-system-logs' => array(
				'title' => __('Host system logs', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_host_system_logs'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'copy-protection' => array(
				'title' => __('Copy protection', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_copy_protection'),
			),
			'frames' => array(
				'title' => __('Frames', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_frames'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's file permissions tab
	 *
	 * @return Void
	 */
	protected function render_file_permissions() {
		// if this is the case there is no need to display a "fix permissions" button
		global $aio_wp_security, $aiowps_feature_mgr;
		
		$util = new AIOWPSecurity_Utility_File;
		$files_dirs_to_check = $util->files_and_dirs_to_check;

		if (isset($_POST['aiowps_fix_permissions'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-fix-permissions-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for file permission change operation.", 4);
				die('Nonce check failed for file permission change operation.');
			}
			if (isset($_POST['aiowps_permission_chg_file'])) {
				$file_found = false;
				$folder_or_file = stripslashes($_POST['aiowps_permission_chg_file']);
				foreach ($files_dirs_to_check as $file_or_dir) {
					if ($folder_or_file == $file_or_dir['path']) $file_found = true;
				}
				if ($file_found) {
					$rec_perm_oct_string = $_POST['aiowps_recommended_permissions']; // Convert the octal string to dec so the chmod func will accept it
					$rec_perm_dec = octdec($rec_perm_oct_string); // Convert the octal string to dec so the chmod func will accept it
					$perm_result = @chmod($folder_or_file, $rec_perm_dec);
					if (true === $perm_result) {
						$msg = sprintf(__('The permissions for %s were successfully changed to %s', 'all-in-one-wp-security-and-firewall'), htmlspecialchars($folder_or_file), htmlspecialchars($rec_perm_oct_string));
						$this->show_msg_updated($msg);
					} elseif (false === $perm_result) {
						$msg = sprintf(__('Unable to change permissions for %s', 'all-in-one-wp-security-and-firewall'), htmlspecialchars($folder_or_file));
						$this->show_msg_error($msg);
					}
				} else {
					$msg = sprintf(__('Unable to change permissions for %s : not in list of valid files', 'all-in-one-wp-security-and-firewall'), htmlspecialchars($folder_or_file));
					$this->show_msg_error($msg);
				}
			}
		}
		$aio_wp_security->include_template('wp-admin/filesystem-security/file-permissions.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'files_dirs_to_check' => $files_dirs_to_check, 'filesystem_menu' => $this));
	}


	/**
	 * Renders the submenu's 'File protection' tab
	 *
	 * @return void
	 */
	protected function render_file_protection() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowps_save_file_protection'])) { // Do form submission tasks.
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aios-firewall-file-protection-nonce');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}
			
			// Update settings for access to WP default install files
			$aio_wp_security->configs->set_value('aiowps_prevent_default_wp_file_access', isset($_POST['aiowps_prevent_default_wp_file_access']) ? '1' : '');

			// Update settings for delete readme.html and wp-config-sample.php.
			$aio_wp_security->configs->set_value('aiowps_auto_delete_default_wp_files', isset($_POST['aiowps_auto_delete_default_wp_files']) ? '1' : '');

			// Update settings for prevent hotlinking.
			$aio_wp_security->configs->set_value('aiowps_prevent_hotlinking', isset($_POST['aiowps_prevent_hotlinking']) ? '1' : '');

			// Update settings for php file editing
			$disable_file_editing = isset($_POST["aiowps_disable_file_editing"]) ? '1' : '';
			$disable_file_editing_status = $disable_file_editing ? AIOWPSecurity_Utility::disable_file_edits() : AIOWPSecurity_Utility::enable_file_edits();
			if ($disable_file_editing_status) {
				// Save settings if no errors
				$aio_wp_security->configs->set_value('aiowps_disable_file_editing', $disable_file_editing, true);
			} else {
				$this->show_msg_error(__('Disable PHP file editing failed, unable to modify or make a backup of wp-config.php file.', 'all-in-one-wp-security-and-firewall'));
			}

			// Commit the config settings.
			$aio_wp_security->configs->save_config();

			// Recalculate points after the feature status/options have been altered.
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			// Now let's write the applicable rules to the .htaccess file
			$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();

			if ($res) {
				$this->show_msg_updated(__('You have successfully saved the file protection settings.', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->show_msg_error(__('Could not write to the .htaccess file, please check the file permissions.', 'all-in-one-wp-security-and-firewall'));
			}
		}

		if (isset($_POST['aiowps_delete_default_wp_files'])) { // Do form submission tasks.
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aios-firewall-file-protection-nonce');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}

			AIOWPSecurity_Utility::delete_unneeded_default_files(true);
		}

		$aio_wp_security->include_template('wp-admin/filesystem-security/file-protection.php');
	}

	/**
	 * Renders the submenu's copy protection tab
	 *
	 * @return Void
	 */
	protected function render_copy_protection() {
		global $aio_wp_security, $aiowps_feature_mgr;
		if (isset($_POST['aiowpsec_save_copy_protection'])) {
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aiowpsec-copy-protection');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_copy_protection', isset($_POST["aiowps_copy_protection"]) ? '1' : '', true);

			$this->show_msg_updated(__('Copy Protection feature settings saved!', 'all-in-one-wp-security-and-firewall'));

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

		}

		$aio_wp_security->include_template('wp-admin/filesystem-security/copy-protection.php', false, array());
	}

	/**
	 * Renders the submenu's render frames tab
	 *
	 * @return Void
	 */
	protected function render_frames() {
		global $aio_wp_security, $aiowps_feature_mgr;
		if (isset($_POST['aiowpsec_save_frame_display_prevent'])) {
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aiowpsec-prevent-display-frame');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}
			
			// Save settings
			$aio_wp_security->configs->set_value('aiowps_prevent_site_display_inside_frame', isset($_POST["aiowps_prevent_site_display_inside_frame"]) ? '1' : '', true);

			$this->show_msg_updated(__('Frame Display Prevention feature settings saved!', 'all-in-one-wp-security-and-firewall'));

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
		}

		$aio_wp_security->include_template('wp-admin/filesystem-security/frames.php', false, array());
	}

	/**
	 * Renders the submenu's host system logs tab
	 *
	 * @return Void
	 */
	protected function render_host_system_logs() {
		global $aio_wp_security;
		
		if (isset($_POST['aiowps_system_log_file'])) {
			if ('' != $_POST['aiowps_system_log_file']) {
				$sys_log_file = basename(stripslashes($_POST['aiowps_system_log_file']));
			} else {
				$sys_log_file = 'error_log';
			}
			$aio_wp_security->configs->set_value('aiowps_system_log_file', $sys_log_file);
			$aio_wp_security->configs->save_config();
		} else {
			$sys_log_file = basename($aio_wp_security->configs->get_value('aiowps_system_log_file'));
		}
		
		$aio_wp_security->include_template('wp-admin/filesystem-security/host-system-logs.php', false, array('sys_log_file' => $sys_log_file));
		
		?>
		<?php
		if (isset($_POST['aiowps_search_error_files'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-view-system-logs-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on view system log operation.", 4);
				die("Nonce check failed on view system log operation.");
			}
			
			$logResults = AIOWPSecurity_Utility_File::recursive_file_search($sys_log_file, 0, ABSPATH);
			if (empty($logResults) || '' == $logResults) {
				$this->show_msg_updated(__('No system logs were found.', 'all-in-one-wp-security-and-firewall'));
			} else {
				foreach ($logResults as $file) {
					$this->display_system_logs_in_table($file);
				}
			}
		}
	}
	
	/**
	 * Scans WP key core files and directory permissions and populates a wp wide_fat table
	 * Displays a red background entry with a "Fix" button for permissions which are "777"
	 * Displays a yellow background entry with a "Fix" button for permissions which are less secure than the recommended
	 * Displays a green entry for permissions which are as secure or better than the recommended
	 *
	 * @param string $name        - file name
	 * @param string $path        - file path
	 * @param string $recommended - file permission
	 *
	 * @return void
	 */
	public function show_wp_filesystem_permission_status($name, $path, $recommended) {
		$fix = false;
		$configmod = AIOWPSecurity_Utility_File::get_file_permission($path);
		if ("0777" == $configmod) {
			$trclass = "aio_table_row_red"; // Display a red background if permissions are set as least secure ("777")
			$fix = true;
		} elseif ($configmod != $recommended) {
			// $res = $this->is_file_permission_secure($recommended, $configmod);
			$res = AIOWPSecurity_Utility_File::is_file_permission_secure($recommended, $configmod);
			if ($res) {
				$trclass = "aio_table_row_green"; //If the current permissions are even tighter than recommended then display a green row
			} else {
				$trclass = "aio_table_row_yellow"; // Display a yellow background if permissions are set to something different than recommended
				$fix = true;
			}
		} else {
			$trclass = "aio_table_row_green";
		}
		echo "<tr class=".$trclass.">";
			echo '<td>' . $name . "</td>";
			echo '<td>'. $path ."</td>";
			echo '<td>' . $configmod . '</td>';
			echo '<td>' . $recommended . '</td>';
			if ($fix) {
				echo '<td>
					<input type="submit" onclick="return set_file_permission_tochange(\'' . esc_js($path) . '\', \'' . esc_js($recommended) . '\')" name="aiowps_fix_permissions" value="' . esc_attr(__('Set recommended permissions', 'all-in-one-wp-security-and-firewall')) . '" class="button-secondary">
					</td>';
			} else {
				echo '<td>'.__('No action required', 'all-in-one-wp-security-and-firewall').'</td>';
			}
		echo "</tr>";
	}
	
	/**
	 * Called via filter admin_footer, this adds the needed javascript to page
	 *
	 * @return void
	 */
	public function filesystem_menu_footer_code() {
		?>
		<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(function($) {
					loading_span = $('.aiowps_loading_1');
					loading_span.hide(); //hide the spinner gif after page has successfully loaded
					$('.search-error-files').on("click",function(){
						loading_span.show();
					});
			});
			
			function set_file_permission_tochange(path, recommended) {
				jQuery('#aiowps_permission_chg_file').val(path);
				jQuery('#aiowps_recommended_permissions').val(recommended);
				return true;
			}
			/* ]]> */
		</script>
		 <?php
	}
	
	/**
	 * This function will get the contents of a file and display them on page
	 *
	 * @param string $filepath - the path to the file
	 *
	 * @return void
	 */
	private function display_system_logs_in_table($filepath) {
		global $aio_wp_security;
		// Get contents of the error_log file
		$error_file_contents = file($filepath);
		if (!$error_file_contents) {
			//TODO - error could not read file, display notice???
			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Filesystem_Menu - Unable to read file: ".$filepath, 4);
		}
		$last_50_entries = array_slice($error_file_contents, -50); // extract the last 50 entries
		?>
		<table class="widefat file_permission_table">
			<thead>
				<tr>
					<th><?php echo sprintf(__('Showing latest entries for file: %s', 'all-in-one-wp-security-and-firewall'), '<strong>'.$filepath.'</strong>'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($last_50_entries as $entry) {
					echo "<tr>";
					echo '<td>' . esc_html($entry) . "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
		<?php

	}
}
