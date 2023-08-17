<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('.htaccess file operations', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('Your ".htaccess" file is a key component of your website\'s security and it can be modified to implement various levels of protection mechanisms.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('This feature allows you to backup and save your currently active .htaccess file should you need to re-use the the backed up file in the future.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('You can also restore your site\'s .htaccess settings using a backed up .htaccess file.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Save the current .htaccess file', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-save-htaccess-nonce'); ?>
			<p class="description"><?php _e('Press the button below to backup and save the currently active .htaccess file.', 'all-in-one-wp-security-and-firewall'); ?></p>
			<input type="submit" name="aiowps_save_htaccess" value="<?php _e('Backup .htaccess file', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Restore from a backed up .htaccess file', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form id="aiowps_restore_htaccess_form" action="" method="POST">
			<?php wp_nonce_field('aiowpsec-restore-htaccess-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_restore_htaccess_button"><?php _e('.htaccess file to restore from', 'all-in-one-wp-security-and-firewall'); ?></label>:</th>
					<td>
						<input type="submit" name="aiowps_restore_htaccess_button" class="button button-primary" value="<?php _e('Restore your .htaccess file', 'all-in-one-wp-security-and-firewall'); ?>">
						<input name="aiowps_restore_htaccess" type="hidden" value="1">
						<input name="aiowps_htaccess_file" type="file" id="aiowps_htaccess_file">
						<input name="aiowps_htaccess_file_contents" type="hidden" id="aiowps_htaccess_file_contents">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>