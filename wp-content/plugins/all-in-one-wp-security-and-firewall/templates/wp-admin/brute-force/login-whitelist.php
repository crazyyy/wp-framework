<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php esc_html_e('Login whitelist', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		echo '<p>' . esc_html__('The All-In-One Security whitelist feature gives you the option of only allowing certain IP addresses or ranges to have access to your WordPress login page.', 'all-in-one-wp-security-and-firewall') . '<br>' . esc_html__('This feature will deny login access for all IP addresses which are not in your whitelist as configured in the settings below.', 'all-in-one-wp-security-and-firewall') . '<br>' . esc_html__('By allowing/blocking IP addresses, you are using the most secure first line of defence because login access will only be granted to whitelisted IP addresses and other addresses will be blocked as soon as they try to access your login page.', 'all-in-one-wp-security-and-firewall') .'</p>';
	?>
</div>
<div class="aio_grey_box">
	<?php
		/* translators: %s: AIOS Constant. */
		echo '<p>' . sprintf(esc_html__('If you are locked out by the login whitelist feature and you do not have a static IP address, define the following constant %s in wp-config.php to disable the feature.', 'all-in-one-wp-security-and-firewall'), '<strong>define(\'AIOS_DISABLE_LOGIN_WHITELIST\', true);</strong>') . '</p>';
	?>
</div>
<div class="aio_yellow_box">
	<?php
		$brute_force_login_feature_link = '<a href="admin.php?page='.AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=cookie-based-brute-force-prevention" target="_blank">' . esc_html__('Cookie-Based brute force login prevention', 'all-in-one-wp-security-and-firewall') . '</a>';
		$rename_login_feature_link = '<a href="admin.php?page='.AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=rename-login" target="_blank">' . esc_html__('Rename login page', 'all-in-one-wp-security-and-firewall') . '</a>';
		/* translators: 1: Brute force link, 2: Rename login link 3: Open strong tag, 4: Close strong tag. */
		echo '<p>' . sprintf(esc_html__('Attention: If in addition to enabling the white list feature, you also have one of the %1$s or %2$s features enabled, %3$s you will still need to use your secret word or special slug in the URL when trying to access your WordPress login page %4$s', 'all-in-one-wp-security-and-firewall'), $brute_force_login_feature_link, $rename_login_feature_link, '<strong>', '</strong>') . '</p><p>' . esc_html__('These features are NOT functionally related.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Having both of them enabled on your site means you are creating 2 layers of security.', 'all-in-one-wp-security-and-firewall') . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Variables already escaped.
	?>
</div>
<?php
	if (defined('AIOS_DISABLE_LOGIN_WHITELIST') && AIOS_DISABLE_LOGIN_WHITELIST) {
	$aio_wp_security->include_template('notices/disable-login-whitelist.php');
	}
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Login IP whitelist settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="whitelist-manager-ip-login-whitelisting-badge">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("whitelist-manager-ip-login-whitelisting");
			?>
		</div>
		<form action="" id="aios-login-whitelist-settings-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Enable IP whitelisting', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want the whitelisting of selected IP addresses specified in the settings below', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_whitelisting', '1' == $aio_wp_security->configs->get_value('aiowps_enable_whitelisting')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_user_ip"><?php esc_html_e('Your current IP address', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
					<input id="aiowps_user_ip" class="copy-to-clipboard" size="40" name="aiowps_user_ip" type="text" value="<?php echo esc_attr($your_ip_address); ?>" readonly>
					<br />
					<span id="aios-ipify-ip-address"></span>
					<input id="aios_user_ip_maybe_also" class="copy-to-clipboard aio_hidden" size="40" name="aios_user_ip_maybe_also" type="text" value=""  ip_maybe="<?php echo (true == $ip_v4) ? 'v6' : 'v4'; ?>" getting_text="<?php esc_html_e('getting...', 'all-in-one-wp-security-and-firewall'); ?>" readonly>
					<br />
					<span class="description"><?php esc_html_e('You can copy and paste the above address(es) in the text box below if you want to include it in your login whitelist.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<?php
					AIOWPSecurity_Utility_UI::ip_input_textarea(__('Enter whitelisted IP addresses:', 'all-in-one-wp-security-and-firewall'), 'aiowps_allowed_ip_addresses', $aiowps_allowed_ip_addresses, __('Enter one or more IP addresses or IP ranges you wish to include in your whitelist.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Only the addresses specified here will have access to the WordPress login page.', 'all-in-one-wp-security-and-firewall'));
					?>
				</tr>
			</table>
			<?php submit_button(esc_html__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_whitelist_settings');?>
		</form>
	</div>
</div>