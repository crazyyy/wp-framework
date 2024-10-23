<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Disable PHP file editing', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box">
		<?php
			echo '<p>'.__('The WordPress Dashboard by default allows administrators to edit PHP files, such as plugin and theme files.', 'all-in-one-wp-security-and-firewall').'<br>'.__('This is often the first tool an attacker will use if able to login, since it allows code execution.', 'all-in-one-wp-security-and-firewall').'<br>'.__('This feature will disable the ability for people to edit PHP files via the dashboard.', 'all-in-one-wp-security-and-firewall').'</p>';
		?>
		</div>
		<div id="filesystem-file-editing-badge">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("filesystem-file-editing");

				if ($show_disallow_file_edit_warning) {
					echo '<div class="aio_red_box"><p>' . __('The DISALLOW_FILE_EDIT constant has already been defined, please remove it before enabling this feature.', 'all-in-one-wp-security-and-firewall') . '<br />' . __('The constant is likely already defined in your wp-config.php file.', 'all-in-one-wp-security-and-firewall') . '</p></div>';
				}
			?>
		</div>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Disable ability to edit PHP files', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to remove the ability for people to edit PHP files via the WP dashboard', 'all-in-one-wp-security-and-firewall'), 'aiowps_disable_file_editing', '1' == $aio_wp_security->configs->get_value('aiowps_disable_file_editing')); ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
