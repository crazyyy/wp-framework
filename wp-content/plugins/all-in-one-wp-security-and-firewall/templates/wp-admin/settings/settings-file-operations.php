<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Export or import your AIOS settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.htmlspecialchars(__('This section allows you to export or import your All In One WP Security & Firewall settings.', 'all-in-one-wp-security-and-firewall'));
	echo '<br />'.__('This can be handy if you wanted to save time by applying the settings from one site to another site.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('NOTE: Before importing, it is your responsibility to know what settings you are trying to import.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Importing settings blindly can cause you to be locked out of your site.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('For Example: If a settings item relies on the domain URL then it may not work correctly when imported into a site with a different domain.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Export AIOS settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST" id="aiowpsec-export-settings-form">
			<table class="form-table">
				<tr valign="top">
					<span class="description"><?php echo htmlspecialchars(__('To export your All In One WP Security & Firewall settings press the button below.', 'all-in-one-wp-security-and-firewall')); ?></span>
				</tr>
			</table>
			<input type="submit" name="aiowps_export_settings" value="<?php _e('Export AIOS settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Import AIOS settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form id="aiowps_restore_settings_form" action="" method="POST">
			<table class="form-table">
				<tr valign="top">
					<span class="description"><?php echo htmlspecialchars(__('Use this section to import your All In One WP Security & Firewall settings from a file.', 'all-in-one-wp-security-and-firewall')); ?></span>
					<th scope="row">
						<label for="aiowps_import_settings_file_button"><?php _e('Settings file to restore from', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<input type="submit" id="aiowps_import_settings_file_button" name="aiowps_import_settings_file_button" class="button button-primary" value="<?php _e('Select your import settings file', 'all-in-one-wp-security-and-firewall'); ?>">
						<input name="aiowps_import_settings" type="hidden" value="1">
						<input name="aiowps_import_settings_file" type="file" id="aiowps_import_settings_file">
						<input name="aiowps_import_settings_file_contents" type="hidden" id="aiowps_import_settings_file_contents">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>