<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>' . __('If given an opportunity hackers can insert their code or files into your system which they can then use to carry out malicious acts on your site.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('Being informed of any changes in your files can be a good way to quickly prevent a hacker from causing damage to your website.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('In general, WordPress core and plugin files and file types such as ".php" or ".js" should not change often and when they do, it is important that you are made aware when a change occurs and which file was affected.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('The "File Change Detection Feature" will notify you of any file change which occurs on your system, including the addition and deletion of files by performing a regular automated or manual scan of your system\'s files.', 'all-in-one-wp-security-and-firewall') .'<br>' . __('This feature also allows you to exclude certain files or folders from the scan in cases where you know that they change often as part of their normal operation. (For example log files and certain caching plugin files may change often and hence you may choose to exclude such files from the file change detection scan)', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Manual file change detection scan', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-fcd-manual-scan-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
				<span class="description"><?php _e('To perform a manual file change detection scan press on the button below.', 'all-in-one-wp-security-and-firewall'); ?></span>
				</tr>
			</table>
			<input type="submit" name="aiowps_manual_fcd_scan" value="<?php _e('Perform scan now', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('View last saved file change results', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-view-last-fcd-results-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
				<span class="description"><?php _e('Press the button below to view the saved file change results from the last scan.', 'all-in-one-wp-security-and-firewall'); ?></span>
				</tr>
			</table>
			<input type="submit" name="aiowps_view_last_fcd_results" value="<?php _e('View last file change', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary" />
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('File change detection settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			$aiowps_feature_mgr->output_feature_details_badge('scan-file-change-detection');
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-scheduled-fcd-scan-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable automated file change detection scan', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_automated_fcd_scan" name="aiowps_enable_automated_fcd_scan" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_automated_fcd_scan')) echo ' checked="checked"'; ?> value="1"/>
					<label for="aiowps_enable_automated_fcd_scan" class="description"><?php _e('Check this if you want the system to automatically/periodically scan your files to check for file changes based on the settings below', 'all-in-one-wp-security-and-firewall'); ?></label>
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
								echo '<p class="description">' . __('You can exclude file types from the scan which would not normally pose any security threat if they were changed. These can include things such as image files.', 'all-in-one-wp-security-and-firewall') . '</p>';
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
								echo '<p class="description">' . __('You can exclude specific files/directories from the scan which would not normally pose any security threat if they were changed. These can include things such as log files.', 'all-in-one-wp-security-and-firewall') . '</p>';
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
						<input id="aiowps_send_fcd_scan_email" name="aiowps_send_fcd_scan_email" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_send_fcd_scan_email')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_send_fcd_scan_email" class="description"><?php _e('Check this if you want the system to email you if a file change was detected', 'all-in-one-wp-security-and-firewall'); ?></label>
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