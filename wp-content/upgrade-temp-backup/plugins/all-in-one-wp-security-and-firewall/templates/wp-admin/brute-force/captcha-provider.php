<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('CAPTCHA provider', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside aiowps-settings">
		<?php if ($aio_wp_security->is_login_lockdown_by_const()) { ?>
			<div class="aio_red_box">
				<p>
					<?php
					echo __('CAPTCHA will not work because you have disabled login lockout by activating the AIOS_DISABLE_LOGIN_LOCKOUT constant value in a configuration file.', 'all-in-one-wp-security-and-firewall').'
					<br>'.__('To enable it, define AIOS_DISABLE_LOGIN_LOCKOUT constant value as false, or remove it.', 'all-in-one-wp-security-and-firewall');
					?>
				</p>
			</div>
		<?php } ?>
		<?php
		$turnstile_link = '<a href="https://developers.cloudflare.com/turnstile/get-started/" target="_blank">Cloudflare Turnstile</a>';
		$recaptcha_link = '<a href="https://www.google.com/recaptcha" target="_blank">Google reCAPTCHA v2</a>';
		echo sprintf('<p>' . __('This feature allows you to add a CAPTCHA form on various WordPress login pages and forms.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Adding a CAPTCHA form on a login page or form is another effective yet simple "Brute Force" prevention technique.', 'all-in-one-wp-security-and-firewall') .
		'<br>' . __('You have the option of using either %s, %s or a plain maths CAPTCHA form.', 'all-in-one-wp-security-and-firewall') . '</p>', $turnstile_link, $recaptcha_link);
		echo sprintf('<p>' . __('We recommend %s as a more privacy-respecting option than %s', 'all-in-one-wp-security-and-firewall') . '</p>', '<a href="https://blog.cloudflare.com/turnstile-private-captcha-alternative/" target="_blank">Cloudflare Turnstile</a>', 'Google reCAPTCHA');
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Default CAPTCHA', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<select name="aiowps_default_captcha" id="aiowps_default_captcha">
						<?php
						$output = '';
						foreach ($supported_captchas as $key => $value) {
							$output .= "<option value=\"".esc_attr($key)."\" ";
							if ($key == $default_captcha) $output .= 'selected="selected"';
							$output .= ">".htmlspecialchars($value) ."</option>\n";
						}
						echo $output;
						?>
					</select>
				</td>
			</tr>
		</table>
		<div id="aios-cloudflare-turnstile" class="aio_grey_box captcha_settings <?php if ('cloudflare-turnstile' !== $default_captcha) echo 'aio_hidden'; ?>">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_turnstile_site_key"><?php _e('Site key', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_turnstile_site_key" type="text" size="50" name="aiowps_turnstile_site_key" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_turnstile_site_key')); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_turnstile_secret_key"><?php _e('Secret key', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<input id="aiowps_turnstile_secret_key" type="text" size="50" name="aiowps_turnstile_secret_key" value="<?php echo esc_attr(AIOWPSecurity_Utility::mask_string($aio_wp_security->configs->get_value('aiowps_turnstile_secret_key'))); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_turnstile_theme"><?php _e('Theme', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<select name="aiowps_turnstile_theme" id="aiowps_turnstile_theme">
							<?php
							$output = '';
							foreach ($captcha_themes as $key => $value) {
								$output .= "<option value=\"".esc_attr($key)."\" ";
								if ($key == $captcha_theme) $output .= 'selected="selected"';
								$output .= ">".htmlspecialchars($value) ."</option>\n";
							}
							echo $output;
							?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div id="aios-google-recaptcha-v2" class="aio_grey_box captcha_settings <?php if ('google-recaptcha-v2' !== $default_captcha) echo 'aio_hidden'; ?>">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_recaptcha_site_key"><?php _e('Site key', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_recaptcha_site_key" type="text" size="50" name="aiowps_recaptcha_site_key" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_recaptcha_site_key')); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_recaptcha_secret_key"><?php _e('Secret key', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<input id="aiowps_recaptcha_secret_key" type="text" size="50" name="aiowps_recaptcha_secret_key" value="<?php echo esc_attr(AIOWPSecurity_Utility::mask_string($aio_wp_security->configs->get_value('aiowps_recaptcha_secret_key'))); ?>">
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
