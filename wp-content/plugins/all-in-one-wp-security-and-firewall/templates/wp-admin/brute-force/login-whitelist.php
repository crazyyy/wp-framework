<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Login whitelist', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		echo '<p>' . __('The All In One WP Security Whitelist feature gives you the option of only allowing certain IP addresses or ranges to have access to your WordPress login page.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('This feature will deny login access for all IP addresses which are not in your whitelist as configured in the settings below.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('By allowing/blocking IP addresses, you are using the most secure first line of defence because login access will only be granted to whitelisted IP addresses and other addresses will be blocked as soon as they try to access your login page.', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<div class="aio_yellow_box">
	<?php
		$brute_force_login_feature_link = '<a href="admin.php?page='.AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=cookie-based-brute-force-prevention" target="_blank">' . __('Cookie-Based brute force login prevention', 'all-in-one-wp-security-and-firewall') . '</a>';
		$rename_login_feature_link = '<a href="admin.php?page='.AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=rename-login" target="_blank">' . __('Rename login page', 'all-in-one-wp-security-and-firewall') . '</a>';
		echo '<p>' . sprintf(__('Attention: If in addition to enabling the white list feature, you also have one of the %s or %s features enabled, <strong>you will still need to use your secret word or special slug in the URL when trying to access your WordPress login page</strong>.', 'all-in-one-wp-security-and-firewall'), $brute_force_login_feature_link, $rename_login_feature_link) . '</p><p>' . __('These features are NOT functionally related. Having both of them enabled on your site means you are creating 2 layers of security.', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<?php
	if (defined('AIOS_DISABLE_LOGIN_WHITELIST') && AIOS_DISABLE_LOGIN_WHITELIST) {
		$aio_wp_security->include_template('notices/disable-login-whitelist.php');
	}
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Login IP whitelist settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("whitelist-manager-ip-login-whitelisting");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-whitelist-settings-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable IP whitelisting', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_whitelisting" name="aiowps_enable_whitelisting" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_whitelisting')) echo ' checked="checked"'; ?> value="1"/>
					<label for="aiowps_enable_whitelisting" class="description"><?php _e('Check this if you want to enable the whitelisting of selected IP addresses specified in the settings below', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_user_ip"><?php _e('Your current IP address', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
					<input id="aiowps_user_ip" class="copy-to-clipboard" size="40" name="aiowps_user_ip" type="text" value="<?php echo esc_attr($your_ip_address); ?>" readonly>
					<span class="description"><?php _e('You can copy and paste this address in the text box below if you want to include it in your login whitelist.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_allowed_ip_addresses"><?php _e('Enter whitelisted IP addresses:', 'all-in-one-wp-security-and-firewall'); ?></label></th>
					<td>
						<textarea id="aiowps_allowed_ip_addresses" name="aiowps_allowed_ip_addresses" rows="5" cols="50"><?php echo esc_textarea(wp_unslash(-1 == $result ? $_POST['aiowps_allowed_ip_addresses'] : $aio_wp_security->configs->get_value('aiowps_allowed_ip_addresses'))); ?></textarea>
						<br>
						<span class="description"><?php echo __('Enter one or more IP addresses or IP ranges you wish to include in your whitelist.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Only the addresses specified here will have access to the WordPress login page.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<?php $aio_wp_security->include_template('info/ip-address-ip-range-info.php'); ?>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_whitelist_settings');?>
		</form>
	</div>
</div>