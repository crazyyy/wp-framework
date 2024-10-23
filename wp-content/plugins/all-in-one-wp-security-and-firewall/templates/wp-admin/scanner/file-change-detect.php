<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<?php
	// Display an alert warning message if a file change was detected
	if ($aio_wp_security->configs->get_value('aiowps_fcds_change_detected')) {
		echo '<div id="aiowps_fcds_change_detected" class="error"><p><strong>' . __('The scan has detected that there was a change in your website\'s files.', 'all-in-one-wp-security-and-firewall') .' <a href="#" data-reset_change_detected="1" class="aiowps_view_last_fcd_results" >'.__('View the scan results and clear this message', 'all-in-one-wp-security-and-firewall').'</a></strong></p></div>';
	}
?>
<div class="aio_blue_box">
	<?php
		echo '<p>' . __('If given an opportunity hackers can insert their code or files into your system which they can then use to carry out malicious acts on your site.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('Being informed of any changes in your files can be a good way to quickly prevent a hacker from causing damage to your website.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('In general, WordPress core and plugin files and file types such as ".php" or ".js" should not change often and when they do, it is important that you are made aware when a change occurs and which file was affected.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('The "File Change Detection Feature" will notify you of any file change which occurs on your system, including the addition and deletion of files by performing a regular automated or manual scan of your system\'s files.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('This feature also allows you to exclude certain files or folders from the scan in cases where you know that they change often as part of their normal operation. (For example log files and certain caching plugin files may change often and hence you may choose to exclude such files from the file change detection scan)', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<div class="postbox aiowps_next_scheduled_scan_wrapper">
	<div class="schedule">
		<div class="aiowps_next_scheduled_entity">
			<div class="aiowps_next_scheduled_heading">
				<strong><?php echo __('Next file scan', 'all-in-one-wp-security-and-firewall').':';?></strong>
			</div>
			<div id="aiowps-next-files-scan-inner">
				<?php
					echo $next_scheduled_scan;
				?>
			</div>
		</div>
		<div class="aiowps_next_scheduled_entity">
			<div class="aiowps_next_scheduled_heading">
				<strong><?php echo __('Previous file scan results', 'all-in-one-wp-security-and-firewall').':';?></strong>
			</div>
			<div id="aiowps-previous-files-scan-inner">
				<span>
				<?php
					if ($previous_scan) {
						echo '<a href="#" class="aiowps_view_last_fcd_results">' . __('View the last file scan results', 'all-in-one-wp-security-and-firewall') . '</a>';
					} else {
						_e('No previous scan results', 'all-in-one-wp-security-and-firewall');
					}
				?>
				</span>
			</div>
		</div>
		<div class="aiowps_time_now_wrapper">
			<?php
			// wp_date() is WP 5.3+, but performs translation into the site locale
			$current_time = AIOWPSecurity_Utility::convert_timestamp(null, 'D, F j, Y H:i');
			?>
			<span class="aiowps_time_now_label"><?php echo __('Time now', 'all-in-one-wp-security-and-firewall').': ';?></span>
			<span class="aiowps_time_now"><?php echo $current_time;?></span>
		</div>
	</div>
	<div class="aiowps_scan_btn_wrapper">
		<button id="aiowps_manual_fcd_scan" type="button" class="button button-primary button-large button-hero"><?php _e('Scan now', 'all-in-one-wp-security-and-firewall'); ?></button>
		<p><?php echo __('or schedule regular file scans below.', 'all-in-one-wp-security-and-firewall');?></p>
	</div>
	<div id="aiowps_activejobs_table">
		
	</div>
	<div id="aiowps_previous_scan_wrapper">
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('File change detection settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="scan-file-change-detection-badge">
			<?php
				$aiowps_feature_mgr->output_feature_details_badge('scan-file-change-detection');
			?>
		</div>
		<div id="aios-file-change-info-box"></div>
		<form action="" method="POST" id="aiowpsec-scheduled-fcd-scan-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable automated file change detection scan', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want the system to automatically and periodically scan your files to check for file changes based on the settings below', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_automated_fcd_scan', '1' == $aio_wp_security->configs->get_value('aiowps_enable_automated_fcd_scan')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_fcd_scan_frequency"><?php _e('Scan time interval', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_fcd_scan_frequency" type="text" size="5" name="aiowps_fcd_scan_frequency" value="<?php echo $aio_wp_security->configs->get_value('aiowps_fcd_scan_frequency'); ?>" />
						<select id="backup_interval" name="aiowps_fcd_scan_interval">
							<option value="0" <?php selected($aio_wp_security->configs->get_value('aiowps_fcd_scan_interval'), '0'); ?>><?php _e('Hours', 'all-in-one-wp-security-and-firewall'); ?></option>
							<option value="1" <?php selected($aio_wp_security->configs->get_value('aiowps_fcd_scan_interval'), '1'); ?>><?php _e('Days', 'all-in-one-wp-security-and-firewall'); ?></option>
							<option value="2" <?php selected($aio_wp_security->configs->get_value('aiowps_fcd_scan_interval'), '2'); ?>><?php _e('Weeks', 'all-in-one-wp-security-and-firewall'); ?></option>
						</select>
					<span class="description"><?php _e('Set the value for how often you would like a scan to occur', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td> 
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_fcd_exclude_filetypes"><?php _e('File types to ignore', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<textarea id="aiowps_fcd_exclude_filetypes" name="aiowps_fcd_exclude_filetypes" rows="5" cols="50"><?php echo htmlspecialchars($aio_wp_security->configs->get_value('aiowps_fcd_exclude_filetypes')); ?></textarea>
						<br>
						<span class="description"><?php _e('Enter each file type or extension on a new line which you wish to exclude from the file change detection scan.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
								echo '<p class="description">' . __('You can exclude file types from the scan which would not normally pose any security threat if they were changed.', 'all-in-one-wp-security-and-firewall') . ' ' . __('These can include things such as image files.', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . sprintf(__('Example: If you want the scanner to ignore files of type %s, %s, and %s, then you would enter the following:', 'all-in-one-wp-security-and-firewall'), 'jpg', 'png', 'bmp'). '</p>';
								echo '<p class="description">' . 'jpg' . '</p>';
								echo '<p class="description">' . 'png' . '</p>';
								echo '<p class="description">' . 'bmp' . '</p>';
							?>
						</div>
					</td> 
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_fcd_exclude_files"><?php _e('Files/Directories to ignore', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<textarea id="aiowps_fcd_exclude_files" name="aiowps_fcd_exclude_files" rows="5" cols="50"><?php echo htmlspecialchars($aio_wp_security->configs->get_value('aiowps_fcd_exclude_files')); ?></textarea>
						<br>
						<span class="description"><?php _e('Enter each file or directory on a new line which you wish to exclude from the file change detection scan.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
								echo '<p class="description">' . __('You can exclude specific files/directories from the scan which would not normally pose any security threat if they were changed.', 'all-in-one-wp-security-and-firewall') . ' ' . __('These can include things such as log files.', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . __('Example: If you want the scanner to ignore certain files in different directories or whole directories, then you would enter the following:', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . 'cache/config/master.php' . '</p>';
								echo '<p class="description">' . __('somedirectory', 'all-in-one-wp-security-and-firewall') . '</p>';
							?>
						</div>
					</td> 
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_fcd_scan_email_address"><?php _e('Send email when change detected', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want the system to email you if a file change was detected', 'all-in-one-wp-security-and-firewall'), 'aiowps_send_fcd_scan_email', '1' == $aio_wp_security->configs->get_value('aiowps_send_fcd_scan_email')); ?>
						</div>
						<br>
							<textarea name="aiowps_fcd_scan_email_address" id="aiowps_fcd_scan_email_address" rows="5" cols="50"><?php echo esc_textarea(wp_unslash(AIOWPSecurity_Utility::get_textarea_str_val($aio_wp_security->configs->get_value('aiowps_fcd_scan_email_address')))); ?></textarea>
						<br>
						<span class="description"><?php _e('Enter one or more email addresses on a new line.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_schedule_fcd_scan" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary" />
		</form>
	</div>
</div>