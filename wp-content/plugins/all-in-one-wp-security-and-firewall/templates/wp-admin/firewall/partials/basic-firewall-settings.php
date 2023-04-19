<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Basic firewall settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		//Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("firewall-basic-rules");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable basic firewall protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_enable_basic_firewall" name="aiowps_enable_basic_firewall" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_enable_basic_firewall')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_enable_basic_firewall" class="description"><?php _e('Check this if you want to apply basic firewall protection to your site.', 'all-in-one-wp-security-and-firewall'); ?></label>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
						<?php
						echo '<p class="description">'.__('This setting will implement the following basic firewall protection mechanisms on your site:', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.__('1) Protect your htaccess file by denying access to it.', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.__('2) Disable the server signature.', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.sprintf(__('3) Limit file upload size (%sMB).', 'all-in-one-wp-security-and-firewall'), AIOS_FIREWALL_MAX_FILE_UPLOAD_LIMIT_MB).'</p>';
						echo '<p class="description">'.__('4) Protect your wp-config.php file by denying access to it.', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.__('The above firewall features will be applied via your .htaccess file and should not affect your site\'s overall functionality.', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.__('You are still advised to take a backup of your active .htaccess file just in case.', 'all-in-one-wp-security-and-firewall').'</p>';
						?>
				</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="aiowps_max_file_upload_size"><?php _e('Max file upload size (MB)', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
				<td><input id="aiowps_max_file_upload_size" type="number" min="0" step="1" name="aiowps_max_file_upload_size" value="<?php echo esc_html($aio_wp_security->configs->get_value('aiowps_max_file_upload_size')); ?>" />
				<span class="description"><?php echo sprintf(__('The value for the maximum file upload size used in the .htaccess file. (Defaults to %sMB if left blank)', 'all-in-one-wp-security-and-firewall'), AIOS_FIREWALL_MAX_FILE_UPLOAD_LIMIT_MB); ?></span>
				</td>
			</tr>

		</table>
		</div></div>
