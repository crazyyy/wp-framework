<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<p>
	<?php printf(__('%s (Have I Been Pwned?) is a website that allows people to check if their email or password has shown up in a data breach.', 'all-in-one-wp-security-and-firewall'), '<a href="https://haveibeenpwned.com/Passwords" target="_blank">' . __('HIBP', 'all-in-one-wp-security-and-firewall') . '</a>'); ?>
	</p>
</div>
<div class="postbox">
	<h3 class="hndle"><?php _e('HIBP password settings', 'all-in-one-wp-security-and-firewall'); ?></h3>
	<div class="inside">
		<form action="" method="POST" id="aios-hibp-password-settings-form">
			<div id="hibp-badge">
			<?php $aiowps_feature_mgr->output_feature_details_badge('hibp'); ?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enforce on profile update', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to enforce passwords not being in the HIBP database when updating user profiles.', 'all-in-one-wp-security-and-firewall'), 'aiowps_hibp_user_profile_update', '1' == $aio_wp_security->configs->get_value('aiowps_hibp_user_profile_update')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Enforce on password reset', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to enforce passwords not being in the HIBP database when resetting passwords.', 'all-in-one-wp-security-and-firewall'), 'aiowps_http_password_reset', '1' == $aio_wp_security->configs->get_value('aiowps_http_password_reset')); ?>
						</div>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary'); ?>
		</form>
	</div>
</div>