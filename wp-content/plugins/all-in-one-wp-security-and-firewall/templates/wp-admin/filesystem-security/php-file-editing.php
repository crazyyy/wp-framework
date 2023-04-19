<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('File editing', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		echo '<p>'.__('The WordPress Dashboard by default allows administrators to edit PHP files, such as plugin and theme files.', 'all-in-one-wp-security-and-firewall').'<br />'.__('This is often the first tool an attacker will use if able to login, since it allows code execution.', 'all-in-one-wp-security-and-firewall').'<br />'.__('This feature will disable the ability for people to edit PHP files via the dashboard.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Disable PHP file editing', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("filesystem-file-editing");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-disable-file-edit-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Disable ability to edit PHP files', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_disable_file_editing" name="aiowps_disable_file_editing" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_disable_file_editing')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_disable_file_editing" class="description"><?php _e('Check this if you want to remove the ability for people to edit PHP files via the WP dashboard', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_disable_file_edit" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>