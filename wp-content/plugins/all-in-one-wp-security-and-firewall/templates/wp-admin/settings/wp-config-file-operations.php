<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('wp-config.php file operations', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('Your "wp-config.php" file is one of the most important files in your WordPress installation.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It is a primary configuration file and contains crucial things such as details of your database and other critical components.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('This feature allows you to backup and save your currently active wp-config.php file should you need to re-use the the backed up file in the future.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('You can also restore your site\'s wp-config.php settings using a backed up wp-config.php file.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Save the current wp-config.php file', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST" id="aiowpsec-save-wp-config-form">
			<p class="description"><?php _e('Press the button below to backup and download the contents of the currently active wp-config.php file.', 'all-in-one-wp-security-and-firewall'); ?></p>
			<input type="submit" name="aiowps_save_wp_config" value="<?php _e('Backup wp-config.php file', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Restore from a backed up wp-config file', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form id="aiowps_restore_wp_config_form" action="" method="POST">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_restore_wp_config_button"><?php _e('wp-config file to restore from', 'all-in-one-wp-security-and-firewall'); ?></label>:</th>
					<td>
						<input type="submit" name="aiowps_restore_wp_config_button" class="button button-primary" value="<?php _e('Restore your wp-config file', 'all-in-one-wp-security-and-firewall'); ?>">
						<input name="aiowps_restore_wp_config" type="hidden" value="1">
						<input name="aiowps_wp_config_file" type="file" id="aiowps_wp_config_file">
						<input name="aiowps_wp_config_file_contents" type="hidden" id="aiowps_wp_config_file_contents">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
	<!-- <div class="postbox">
		<h3 class="hndle"><label for="title"><?php // _e('View Contents of the currently active wp-config.php file', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
<?php
		// $wp_config_file = AIOWPSecurity_Utility_File::get_wp_config_file_path();
		// $wp_config_contents = AIOWPSecurity_Utility_File::get_file_contents($wp_config_file); -->
?>
			<textarea class="aio_text_area_file_output aio_width_80 aio_spacer_10_tb" rows="20" readonly><?php // echo $wp_config_contents; ?></textarea>
		</div>
	</div> -->