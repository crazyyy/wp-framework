<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Manage delete plugin tasks', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" id="aiowpsec-delete-plugin-settings-form">
			<div class="aio_yellow_box">
				<p>
				<?php echo esc_html__('NOTE: Even if these options are disabled, the plugin settings will still be inactive when the plugin is uninstalled, but they will be remembered for the next time the plugin is installed and activated.', 'all-in-one-wp-security-and-firewall'); ?>
				</p>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Delete database tables', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this to remove all database tables for this site when uninstalling the plugin.', 'all-in-one-wp-security-and-firewall'), 'aiowps_on_uninstall_delete_db_tables', '1' == $aio_wp_security->configs->get_value('aiowps_on_uninstall_delete_db_tables')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Delete settings', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<?php
						$delete_configs_description = esc_html__('Enable this to remove all plugin settings for this site when uninstalling the plugin.', 'all-in-one-wp-security-and-firewall');

						if (is_main_site()) {
							$delete_configs_description .= ' ' . esc_html__('It will also remove all firewall rules that were added by this plugin.', 'all-in-one-wp-security-and-firewall');
						}
						?>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox($delete_configs_description, 'aiowps_on_uninstall_delete_configs', '1' == $aio_wp_security->configs->get_value('aiowps_on_uninstall_delete_configs')); ?>
						</div>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_delete_plugin_settings" value="<?php esc_html_e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>