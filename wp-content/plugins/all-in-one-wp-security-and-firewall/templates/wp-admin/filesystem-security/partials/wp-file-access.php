<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Prevent access to default WP files', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box">
			<?php
				$info_msg = sprintf(__('This feature allows you to prevent access to files such as %s, %s and %s which are delivered with all WP installations.', 'all-in-one-wp-security-and-firewall'), 'readme.html', 'license.txt', 'wp-config-sample.php');
				echo '<p>'.$info_msg.'</p>'.'<p>'.__('By preventing access to these files you are hiding some key pieces of information (such as WordPress version info) from potential hackers.', 'all-in-one-wp-security-and-firewall').'</p>';
			?>
		</div>
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("block-wp-files-access");
		?>  
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Prevent access to WP default install files', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Check this if you want to prevent access to readme.html, license.txt and wp-config-sample.php.', 'all-in-one-wp-security-and-firewall'), 'aiowps_prevent_default_wp_file_access', '1' == $aio_wp_security->configs->get_value('aiowps_prevent_default_wp_file_access')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e('Delete readme.html and wp-config-sample.php:', 'all-in-one-wp-security-and-firewall'); ?>
					</th>
					<td>
						<div class="aiowps_switch_container">
							<input style="margin-right: 15px" type="submit" name="aiowps_delete_default_wp_files" value="<?php _e('Delete', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Automatically delete the files after a WP core update.', 'all-in-one-wp-security-and-firewall'), 'aiowps_auto_delete_default_wp_files', '1' == $aio_wp_security->configs->get_value('aiowps_auto_delete_default_wp_files')); ?>
						</div>
					</td>
				</tr>
			</table>
	</div>
</div>