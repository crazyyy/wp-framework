<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Login lockout configuration', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	$brute_force_login_feature_link = '<a href="admin.php?page=' . AIOWPSEC_BRUTE_FORCE_MENU_SLUG . '&tab=cookie-based-brute-force-prevention">' . __('Cookie-based brute force login prevention', 'all-in-one-wp-security-and-firewall').'</a>';
	echo '<p>' . __('One of the ways hackers try to compromise sites is via a ', 'all-in-one-wp-security-and-firewall') . '<strong>' . __('Brute force login attack', 'all-in-one-wp-security-and-firewall') . '</strong>. ' . __('This is where attackers use repeated login attempts until they guess the password.', 'all-in-one-wp-security-and-firewall').'
	<br />' . __('Apart from choosing strong passwords, monitoring and blocking IP addresses which are involved in repeated login failures in a short period of time is a very effective way to stop these types of attacks.', 'all-in-one-wp-security-and-firewall').
	'<p>' . sprintf(esc_html(__('You may also want to checkout our %s feature for another secure way to protect against these types of attacks.', 'all-in-one-wp-security-and-firewall')), $brute_force_login_feature_link) . '</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Login lockout options', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("user-login-login-lockdown");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-login-lockdown-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable login lockout feature', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_login_lockdown" name="aiowps_enable_login_lockdown" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_login_lockdown'), '1'); ?> value="1"/>
					<label for="aiowps_enable_login_lockdown" class="description"><?php _e('Check this if you want to enable the login lockout feature and apply the settings below', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Allow unlock requests', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_allow_unlock_requests" name="aiowps_allow_unlock_requests" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_allow_unlock_requests'), '1'); ?> value="1"/>
					<label for="aiowps_allow_unlock_requests" class="description"><?php _e('Check this if you want to allow users to generate an automated unlock request link which will unlock their account', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_max_login_attempts"><?php _e('Max login attempts', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_max_login_attempts" type="text" size="5" name="aiowps_max_login_attempts" value="<?php echo esc_html($aio_wp_security->configs->get_value('aiowps_max_login_attempts')); ?>" />
					<span class="description"><?php _e('Set the value for the maximum login retries before IP address is locked out', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td> 
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_retry_time_period"><?php _e('Login retry time period (min)', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_retry_time_period" type="text" size="5" name="aiowps_retry_time_period" value="<?php echo esc_html($aio_wp_security->configs->get_value('aiowps_retry_time_period')); ?>" />
					<span class="description"><?php _e('If the maximum number of failed login attempts for a particular IP address occur within this time period the plugin will lock out that address', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_lockout_time_length"><?php _e('Minimum lockout time length', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
					<input type="text" size="5" name="aiowps_lockout_time_length" id="aiowps_lockout_time_length" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_lockout_time_length')); ?>" />
					<span class="description">
						<?php
						echo __('Set the minimum time period in minutes of lockout.', 'all-in-one-wp-security-and-firewall') . ' ' . __('This failed login lockout time will be tripled on each failed login.', 'all-in-one-wp-security-and-firewall');
						?>
					</span>
					</td> 
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_max_lockout_time_length"><?php _e('Maximum lockout time length', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td><input type="text" size="5" name="aiowps_max_lockout_time_length" id="aiowps_max_lockout_time_length" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_max_lockout_time_length')); ?>" />
					<span class="description">
						<?php
						echo __('Set the maximum time period in minutes of lockout.', 'all-in-one-wp-security-and-firewall') . ' ' . __('No IP address will be blocked for more than this time period after making a failed login attempt.', 'all-in-one-wp-security-and-firewall')
						?>
					</span>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Display generic error message', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_set_generic_login_msg" name="aiowps_set_generic_login_msg" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_set_generic_login_msg'), '1'); ?> value="1"/>
					<label for="aiowps_set_generic_login_msg" class="description"><?php _e('Check this if you want to show a generic error message when a login attempt fails', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Instantly lockout invalid usernames', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_invalid_username_lockdown" name="aiowps_enable_invalid_username_lockdown" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_invalid_username_lockdown'), '1'); ?> value="1"/>
					<label for="aiowps_enable_invalid_username_lockdown" class="description"><?php _e('Check this if you want to instantly lockout login attempts with usernames which do not exist on your system', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_instantly_lockout_specific_usernames"><?php _e('Instantly lockout specific usernames', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<?php
						$instant_lockout_users_list = $aio_wp_security->configs->get_value('aiowps_instantly_lockout_specific_usernames');
						if (empty($instant_lockout_users_list)) {
							$instant_lockout_users_list = array();
						}
						?>
						<textarea id="aiowps_instantly_lockout_specific_usernames" name="aiowps_instantly_lockout_specific_usernames" cols="50" rows="5"><?php echo esc_textarea(implode("\n", $instant_lockout_users_list)); ?></textarea><br>
						<span class="description"><?php _e('Insert one username per line. Existing usernames are not blocked even if present in the list.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_email_address"><?php _e('Notify by email', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<input id="aiowps_enable_email_notify" name="aiowps_enable_email_notify" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_email_notify'), '1'); ?> value="1"/>
						<label for="aiowps_enable_email_notify" class="description"><?php _e('Check this if you want to receive an email when someone has been locked out due to maximum failed login attempts', 'all-in-one-wp-security-and-firewall'); ?></span></label>
						<br />
						<textarea id="aiowps_email_address" name="aiowps_email_address" cols="50" rows="5"><?php echo esc_textarea(AIOWPSecurity_Utility::get_textarea_str_val($aio_wp_security->configs->get_value('aiowps_email_address'))); ?></textarea><br>
						<span class="description"><?php _e('Fill in one email address per line.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.__('Each email address must be on a new line.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('If a valid email address has not been filled in, it will not be saved.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('The valid email address format is userid@example.com', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.sprintf(__('Example: %s', 'all-in-one-wp-security-and-firewall'), 'rick@wordpress.org').'</p>';
								?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e('Enable PHP backtrace in email', 'all-in-one-wp-security-and-firewall'); ?>:
					</th>
					<td>
						<input name="aiowps_enable_php_backtrace_in_email" id="aiowps_enable_php_backtrace_in_email" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_php_backtrace_in_email'), '1'); ?> value="1"/>
						<label for="aiowps_enable_php_backtrace_in_email"><?php _e('Check this if you want to include the PHP backtrace in notification emails.', 'all-in-one-wp-security-and-firewall'); ?> <?php _e('This is internal coding information which makes it easier to investigate where an issued occurred.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<?php
				submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_login_lockdown');
			?>
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Currently locked out IP address ranges', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box aio_width_80">
			<?php
			$locked_ips_link = '<a href="admin.php?page='.AIOWPSEC_MAIN_MENU_SLUG.'&tab=locked-ip">Locked IP addresses</a>';
			echo '<p>'.sprintf(__('To see a list of all locked IP addresses and ranges go to the %s tab in the dashboard menu.', 'all-in-one-wp-security-and-firewall'), $locked_ips_link).'</p>';
			?>
		</div>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Login lockout IP whitelist settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
		<?php wp_nonce_field('aiowpsec-lockdown-whitelist-settings-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_lockdown_enable_whitelisting"><?php _e('Enable login lockout IP whitelist', 'all-in-one-wp-security-and-firewall'); ?></label>:</th>
					<td>
					<input id="aiowps_lockdown_enable_whitelisting" name="aiowps_lockdown_enable_whitelisting" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_lockdown_enable_whitelisting'), '1'); ?> value="1"/>
					<span class="description"><?php _e('Check this if you want to enable the whitelisting of selected IP addresses specified in the settings below', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_lockdown_allowed_ip_addresses"><?php _e('Enter whitelisted IP addresses:', 'all-in-one-wp-security-and-firewall'); ?></label></th>
					<td>
						<textarea id="aiowps_lockdown_allowed_ip_addresses" name="aiowps_lockdown_allowed_ip_addresses" rows="5" cols="50"><?php echo esc_textarea(wp_unslash(-1 == $result ? stripslashes($_POST['aiowps_lockdown_allowed_ip_addresses']) : $aio_wp_security->configs->get_value('aiowps_lockdown_allowed_ip_addresses'))); ?></textarea>
						<br />
						<span class="description"><?php echo __('Enter one or more IP addresses or IP ranges you wish to include in your whitelist.', 'all-in-one-wp-security-and-firewall') . ' ' . __('The addresses specified here will never be blocked by the login lockout feature.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<?php $aio_wp_security->include_template('info/ip-address-ip-range-info.php');?>
					</td>
				</tr>
			</table>
			<?php
				submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_lockdown_whitelist_settings');
			?>
		</form>
	</div>
</div>