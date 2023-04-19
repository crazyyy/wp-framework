<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Block access to debug log file', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		//Display security info badge
		global $aiowps_feature_mgr;
		$aiowps_feature_mgr->output_feature_details_badge("firewall-block-debug-file-access");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Block access to debug.log file', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_block_debug_log_file_access" name="aiowps_block_debug_log_file_access" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_block_debug_log_file_access')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_block_debug_log_file_access" class="description"><?php _e('Check this if you want to block access to the debug.log file that WordPress creates when debug logging is enabled.', 'all-in-one-wp-security-and-firewall'); ?></label>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
					<?php
					echo '<p class="description">'.__('WordPress has an option to turn on the debug logging to a file located in wp-content/debug.log. This file may contain sensitive information.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p class="description">'.__('Using this option will block external access to this file.', 'all-in-one-wp-security-and-firewall').' '.__('You can still access this file by logging into your site via FTP.', 'all-in-one-wp-security-and-firewall').'</p>';
					?>
				</div>
				</td>
			</tr>
		</table>
		</div></div>
		