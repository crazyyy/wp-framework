<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Manage delete plugin tasks', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-delete-plugin-settings'); ?>

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Delete database tables', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_on_uninstall_delete_db_tables" name="aiowps_on_uninstall_delete_db_tables" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_on_uninstall_delete_db_tables')=='1') echo ' checked="checked"'; ?> value="1"/>
					<label for="aiowps_on_uninstall_delete_db_tables" class="description"><?php _e('Check this if you want to remove database tables when the plugin is uninstalled.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Delete settings', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_on_uninstall_delete_configs" name="aiowps_on_uninstall_delete_configs" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_on_uninstall_delete_configs'), '1'); ?> value="1"/>
						<label for="aiowps_on_uninstall_delete_configs" class="description"><?php echo __('Check this if you want to remove all plugin settings when uninstalling the plugin.', 'all-in-one-wp-security-and-firewall').' '.__('It will also remove all custom htaccess rules that were added by this plugin.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_delete_plugin_settings" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>