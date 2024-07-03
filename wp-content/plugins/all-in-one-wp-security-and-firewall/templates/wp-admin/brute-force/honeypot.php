<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
<?php
	echo '<p>' . __('This feature allows you to add a special hidden "honeypot" field on WordPress login and registration pages.', 'all-in-one-wp-security-and-firewall'). ' ' . __('This will only be visible to robots and not humans.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('Since robots usually fill in every input field on a form, they will also submit a value for the special hidden honeypot field.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('The way honeypots work is that a hidden field is placed somewhere inside a form which only robots will submit.', 'all-in-one-wp-security-and-firewall') . ' ' .  __('If that field contains a value when the form is submitted then a robot has most likely submitted the form and it is consequently dealt with.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('Therefore, if the plugin detects that this field has a value when the form is submitted, then the robot which is attempting to submit the form on your site will be redirected to its localhost address - http://127.0.0.1.', 'all-in-one-wp-security-and-firewall') . '</p>';
?>
</div>
<form action="" method="POST">
	<?php wp_nonce_field('aiowpsec-honeypot-settings-nonce'); ?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Login form honeypot settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("login-honeypot");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable honeypot on login page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want the honeypot feature for the login page', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_login_honeypot', '1' == $aio_wp_security->configs->get_value('aiowps_enable_login_honeypot')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Registration form honeypot settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("registration-honeypot");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable honeypot on registration page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want the honeypot feature for the registration page', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_registration_honeypot', '1' == $aio_wp_security->configs->get_value('aiowps_enable_registration_honeypot')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_honeypot_settings');?>
</form>
