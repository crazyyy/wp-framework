<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
<?php
	echo '<p>' . __('This feature allows you to add a special hidden "honeypot" field on the WordPress login page. This will only be visible to robots and not humans.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('Since robots usually fill in every input field from a login form, they will also submit a value for the special hidden honeypot field.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('The way honeypots work is that a hidden field is placed somewhere inside a form which only robots will submit. If that field contains a value when the form is submitted then a robot has most likely submitted the form and it is consequently dealt with.', 'all-in-one-wp-security-and-firewall') . '<br>' . __('Therefore, if the plugin detects that this field has a value when the login form is submitted, then the robot which is attempting to login to your site will be redirected to its localhost address - http://127.0.0.1.', 'all-in-one-wp-security-and-firewall') . '</p>';
?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Login form honeypot settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("login-honeypot");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-honeypot-settings-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable honeypot on login page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_login_honeypot" name="aiowps_enable_login_honeypot" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_login_honeypot'), '1'); ?> value="1"/>
					<label for="aiowps_enable_login_honeypot" class="description"><?php _e('Check this if you want to enable the honeypot feature for the login page', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_honeypot_settings');?>
		</form>
	</div>
</div>
