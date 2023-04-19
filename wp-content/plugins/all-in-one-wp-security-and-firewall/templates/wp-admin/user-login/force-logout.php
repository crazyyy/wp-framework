<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>'.__('Setting an expiry period for your WP administration session is a simple way to protect against unauthorized access to your site from your computer.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('This feature allows you to specify a time period in minutes after which the admin session will expire and the user will be forced to log back in.', 'all-in-one-wp-security-and-firewall').'
		</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Force user logout options', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("user-login-force-logout");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-force-logout-settings-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable force WP user logout', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_forced_logout" name="aiowps_enable_forced_logout" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_forced_logout'), '1'); ?> value="1"/>
					<label for="aiowps_enable_forced_logout" class="description"><?php _e('Check this if you want to force a wp user to be logged out after a configured amount of time', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_logout_time_period"><?php _e('Logout the WP user after XX minutes', 'all-in-one-wp-security-and-firewall'); ?></label>:</th>
					<td><input id="aiowps_logout_time_period" type="text" size="5" name="aiowps_logout_time_period" value="<?php echo $aio_wp_security->configs->get_value('aiowps_logout_time_period'); ?>" />
					<span class="description"><?php _e('(Minutes) The user will be forced to log back in after this time period has elapased.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td> 
				</tr>
			</table>
			<?php
				submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_force_logout_settings');
			?>
		</form>
	</div>
</div>