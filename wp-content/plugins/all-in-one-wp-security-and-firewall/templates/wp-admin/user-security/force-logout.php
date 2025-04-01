<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>'.esc_html__('Setting an expiry period for your administration session is a simple way to protect against unauthorized access to your site from your computer.', 'all-in-one-wp-security-and-firewall').'
		<br />'.esc_html__('This feature allows you to specify a time period in minutes after which the admin session will expire and the user will be forced to log back in.', 'all-in-one-wp-security-and-firewall').'
		</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Force user logout options', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="user-login-force-logout-badge">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("user-login-force-logout");
			?>
		</div>
		<form action="" method="POST" id="aios-force-user-logout-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Enable force user logout', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to force a user to be logged out after a configured amount of time', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_forced_logout', '1' == $aio_wp_security->configs->get_value('aiowps_enable_forced_logout')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_logout_time_period"><?php esc_html_e('Logout the user after X minutes', 'all-in-one-wp-security-and-firewall'); ?></label>:</th>
					<td><input id="aiowps_logout_time_period" type="text" size="5" name="aiowps_logout_time_period" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_logout_time_period')); ?>" />
					<span class="description"><?php esc_html_e('(Minutes) The user will be forced to log back in after this time period has elapased.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td> 
				</tr>
			</table>
			<?php
				submit_button(esc_html__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_force_logout_settings');
			?>
		</form>
	</div>
</div>