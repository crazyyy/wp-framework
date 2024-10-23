<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<p><?php echo __('The HTTP authentication feature gives you a way to add a login username and password to your site through the use of the WWW-Authenticate header.', 'all-in-one-wp-security-and-firewall').' '.__('Only enable this feature for the frontend of your site if you don\'t want your site to be public.', 'all-in-one-wp-security-and-firewall'); ?></p>
	<p>
		<?php echo __('The username and password will only be secure if you\'re enforcing the use of TLS(https) on your site.', 'all-in-one-wp-security-and-firewall'); ?>
		<?php if (is_ssl()) { ?>
			<span class="aio_green_box"><?php echo __('Your site is currently using https.', 'all-in-one-wp-security-and-firewall'); ?></span>
		<?php } else { ?>
			<span class="aio_red_box"><?php echo __('Your site is currently not using https.', 'all-in-one-wp-security-and-firewall'); ?></span>
		<?php } ?>
	</p>
</div>
<?php if (!$aio_wp_security->configs->get_value('aiowps_http_authentication_admin') && !$aio_wp_security->configs->get_value('aiowps_http_authentication_frontend')) { ?>
	<?php if ((isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] != $aio_wp_security->configs->get_value('aiowps_http_authentication_username')) || (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] != $aio_wp_security->configs->get_value('aiowps_http_authentication_password'))) { ?>
		<div class="aio_orange_box">
			<p><?php echo __('Your web browser is already sending a username/password.', 'all-in-one-wp-security-and-firewall') . ' ' . __('If this is because you previously activated this feature then no action is required.', 'all-in-one-wp-security-and-firewall'); ?></p>
			<p><?php echo __('However, if this is because you have HTTP authentication set up elsewhere, such as another plugin or at the webserver level, then this feature either shouldn\'t be activated, or should only be activated with the same username/password.', 'all-in-one-wp-security-and-firewall'); ?></p>
		</div>
	<?php } ?>
<?php } ?>
<form method="post" action="">
	<?php wp_nonce_field('aiowpsec-http-authentication-settings-nonce'); ?>
	<div class="postbox">
		<h3 class="hndle"><?php _e('HTTP authentication for WordPress dashboard and frontend', 'all-in-one-wp-security-and-firewall'); ?></h3>
		<div class="inside">
			<?php
				// Display security info badge.
				$aiowps_feature_mgr->output_feature_details_badge('http-authentication-admin-frontend');
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_http_authentication_admin"><?php _e('Enable for WordPress dashboard:', 'all-in-one-wp-security-and-firewall'); ?></label>
					</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Check this if you want to protect the WordPress dashboard area of your site with HTTP authentication.', 'all-in-one-wp-security-and-firewall'), 'aiowps_http_authentication_admin', '1' == $aio_wp_security->configs->get_value('aiowps_http_authentication_admin')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_http_authentication_frontend"><?php _e('Enable for frontend:', 'all-in-one-wp-security-and-firewall'); ?></label>
					</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Check this if you want to protect the frontend of your site with HTTP authentication.', 'all-in-one-wp-security-and-firewall'), 'aiowps_http_authentication_frontend', '1' == $aio_wp_security->configs->get_value('aiowps_http_authentication_frontend')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_http_authentication_username"><?php _e('Username:', 'all-in-one-wp-security-and-firewall'); ?></label>
					</th>
					<td>
						<input id="aiowps_http_authentication_username" type="text" name="aiowps_http_authentication_username" value="<?php echo $aio_wp_security->configs->get_value('aiowps_http_authentication_username'); ?>" size="15">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_password_test"><?php _e('Password:', 'all-in-one-wp-security-and-firewall'); ?></label>
					</th>
					<td>
						<input id="aiowps_password_test" type="text" name="aiowps_http_authentication_password" value="<?php echo $aio_wp_security->configs->get_value('aiowps_http_authentication_password'); ?>" size="15">
						<br>
						<?php
						$crack_time = '<span id="aiowps_password_crack_time_calculation" style="all: initial; display: inline-block; padding-top: 7px; color: #3c434a;"></span>';
						$password_tool_link = $rename_login_feature_link = '<a href="admin.php?page=' . AIOWPSEC_TOOLS_MENU_SLUG . '&tab=password-tool" target="_blank">' . __('Password tool', 'all-in-one-wp-security-and-firewall') . '</a>';
						echo sprintf(__('%s to crack by a desktop PC according to the %s', 'all-in-one-wp-security-and-firewall'), $crack_time . '<span id="aiowps_http_authentication_password_crack_time_explanation">', $password_tool_link . '.</span>');
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Failure message:', 'all-in-one-wp-security-and-firewall'); ?></label>
					</th>
					<td>
						<?php
						$aiowps_failure_message = $aio_wp_security->configs->get_value('aiowps_http_authentication_failure_message');
						$aiowps_failure_message_raw = html_entity_decode($aiowps_failure_message, ENT_COMPAT, 'UTF-8');
						wp_editor($aiowps_failure_message_raw, 'aiowps_http_authentication_failure_message');
						?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_http_authentication_settings'); ?>
</form>