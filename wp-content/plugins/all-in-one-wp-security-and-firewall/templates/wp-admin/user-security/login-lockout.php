<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php esc_html_e('Login lockout configuration', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	$brute_force_login_feature_link = '<a href="admin.php?page=' . AIOWPSEC_BRUTE_FORCE_MENU_SLUG . '&tab=cookie-based-brute-force-prevention">' . esc_html__('Cookie-based brute force login prevention', 'all-in-one-wp-security-and-firewall').'</a>';
	echo '<p>' . esc_html__('One of the ways hackers try to compromise sites is via a', 'all-in-one-wp-security-and-firewall') . ' ' .'<strong>' . esc_html__('Brute force login attack', 'all-in-one-wp-security-and-firewall') . '</strong>. ' . esc_html__('This is where attackers use repeated login attempts until they guess the password.', 'all-in-one-wp-security-and-firewall').'
	<br />' . esc_html__('Apart from choosing strong passwords, monitoring and blocking IP addresses which are involved in repeated login failures in a short period of time is a very effective way to stop these types of attacks.', 'all-in-one-wp-security-and-firewall').
	/* translators: %s: Brute force feature link. */
	'<p>' . sprintf(esc_html__('You may also want to checkout our %s feature for another secure way to protect against these types of attacks.', 'all-in-one-wp-security-and-firewall'), $brute_force_login_feature_link) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Link already escaped.
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Login lockout options', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="user-login-login-lockdown-badge">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("user-login-login-lockdown");
			?>
		</div>
		<form action="" method="POST" id="aios-user-login-lockdown-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Enable login lockout feature', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this to turn on the login lockout feature', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_login_lockdown', '1' == $aio_wp_security->configs->get_value('aiowps_enable_login_lockdown')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Allow unlock requests', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to allow users to generate an automated unlock request link which will unlock their account', 'all-in-one-wp-security-and-firewall'), 'aiowps_allow_unlock_requests', '1' == $aio_wp_security->configs->get_value('aiowps_allow_unlock_requests')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_max_login_attempts"><?php esc_html_e('Max login attempts', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_max_login_attempts" type="text" size="5" name="aiowps_max_login_attempts" value="<?php echo esc_html($aio_wp_security->configs->get_value('aiowps_max_login_attempts')); ?>" />
					<span class="description"><?php esc_html_e('Set the value for the maximum login retries before IP address is locked out', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_retry_time_period"><?php esc_html_e('Login retry time period (min)', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_retry_time_period" type="text" size="5" name="aiowps_retry_time_period" value="<?php echo esc_html($aio_wp_security->configs->get_value('aiowps_retry_time_period')); ?>" />
					<span class="description"><?php esc_html_e('If the maximum number of failed login attempts for a particular IP address occur within this time period the plugin will lock out that address', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_lockout_time_length"><?php esc_html_e('Minimum lockout time length', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
					<input type="text" size="5" name="aiowps_lockout_time_length" id="aiowps_lockout_time_length" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_lockout_time_length')); ?>" />
					<span class="description">
						<?php
						echo esc_html__('Set the minimum time period in minutes of lockout.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('This failed login lockout time will be tripled on each failed login.', 'all-in-one-wp-security-and-firewall');
						?>
					</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_max_lockout_time_length"><?php esc_html_e('Maximum lockout time length', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td><input type="text" size="5" name="aiowps_max_lockout_time_length" id="aiowps_max_lockout_time_length" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_max_lockout_time_length')); ?>" />
					<span class="description">
						<?php
						echo esc_html__('Set the maximum time period in minutes of lockout.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('No IP address will be blocked for more than this time period after making a failed login attempt.', 'all-in-one-wp-security-and-firewall')
						?>
					</span>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Display generic error message', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to show a generic error message when a login attempt fails', 'all-in-one-wp-security-and-firewall'), 'aiowps_set_generic_login_msg', '1' == $aio_wp_security->configs->get_value('aiowps_set_generic_login_msg')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Instantly lockout invalid usernames', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to instantly lockout login attempts with usernames which do not exist on your system', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_invalid_username_lockdown', '1' == $aio_wp_security->configs->get_value('aiowps_enable_invalid_username_lockdown')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_instantly_lockout_specific_usernames"><?php esc_html_e('Instantly lockout specific usernames', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<?php
						$instant_lockout_users_list = $aio_wp_security->configs->get_value('aiowps_instantly_lockout_specific_usernames');
						if (empty($instant_lockout_users_list)) {
							$instant_lockout_users_list = array();
						}
						?>
						<textarea id="aiowps_instantly_lockout_specific_usernames" name="aiowps_instantly_lockout_specific_usernames" cols="50" rows="5"><?php echo esc_textarea(implode("\n", $instant_lockout_users_list)); ?></textarea><br>
						<span class="description"><?php echo esc_html__('Insert one username per line.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Existing usernames are not blocked even if present in the list.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_email_address"><?php esc_html_e('Notify by email', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to receive an email when someone has been locked out due to maximum failed login attempts', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_email_notify', '1' == $aio_wp_security->configs->get_value('aiowps_enable_email_notify')); ?>
						</div>
						<br />
						<textarea id="aiowps_email_address" name="aiowps_email_address" cols="50" rows="5"><?php echo esc_textarea(AIOWPSecurity_Utility::get_textarea_str_val($aio_wp_security->configs->get_value('aiowps_email_address'))); ?></textarea><br>
						<span class="description"><?php esc_html_e('Fill in one email address per line.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">' . esc_html__('Each email address must be on a new line.', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . esc_html__('If a valid email address has not been filled in, it will not be saved.', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . esc_html__('The valid email address format is userid@example.com', 'all-in-one-wp-security-and-firewall') . '</p>';
								/* translators: %s: Email example. */
								echo '<p class="description">' . sprintf(esc_html__('Example: %s', 'all-in-one-wp-security-and-firewall'), 'rick@wordpress.org') . '</p>';
								?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php esc_html_e('Enable PHP backtrace in email', 'all-in-one-wp-security-and-firewall'); ?>:
					</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to include the PHP backtrace in notification emails.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_php_backtrace_in_email', '1' == $aio_wp_security->configs->get_value('aiowps_enable_php_backtrace_in_email')); ?>
						</div>
					</td>
				</tr>
			</table>
			<?php
				submit_button(esc_html__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_login_lockdown');
			?>
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Currently locked out IP address ranges', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box aio_width_80">
			<?php
			$locked_ips_link = '<a href="admin.php?page=' . AIOWPSEC_MAIN_MENU_SLUG . '&tab=locked-ip">Locked IP addresses</a>';
			/* translators: %s: Locked IP link. */
			echo '<p>' . sprintf(esc_html__('To see a list of all locked IP addresses and ranges go to the %s tab in the dashboard menu.', 'all-in-one-wp-security-and-firewall'), $locked_ips_link) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Link already escaped.
			?>
		</div>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Login lockout IP whitelist settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="user-login-lockout-ip-whitelisting-badge">
			<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("user-login-lockout-ip-whitelisting");
			?>
		</div>
		<form action="" method="POST" id="aios-user-login-lockout-whitelist-settings-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_lockdown_enable_whitelisting"><?php esc_html_e('Enable login lockout IP whitelist', 'all-in-one-wp-security-and-firewall'); ?></label>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want the whitelisting of selected IP addresses specified in the settings below', 'all-in-one-wp-security-and-firewall'), 'aiowps_lockdown_enable_whitelisting', '1' == $aio_wp_security->configs->get_value('aiowps_lockdown_enable_whitelisting')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<?php
					AIOWPSecurity_Utility_UI::ip_input_textarea(__('Enter whitelisted IP addresses:', 'all-in-one-wp-security-and-firewall'), 'aiowps_lockdown_allowed_ip_addresses', $aiowps_lockdown_allowed_ip_addresses, __('Enter one or more IP addresses or IP ranges you wish to include in your whitelist.', 'all-in-one-wp-security-and-firewall') . ' ' . __('The addresses specified here will never be blocked by the login lockout feature.', 'all-in-one-wp-security-and-firewall'));
					?>
				</tr>
			</table>
			<?php
				submit_button(esc_html__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_lockdown_whitelist_settings');
			?>
		</form>
	</div>
</div>