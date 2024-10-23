<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<form action="" method="POST">
	<?php wp_nonce_field('aiowpsec-captcha-settings-nonce'); ?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
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
	<div id="aios-captcha-options" <?php if ('none' === $default_captcha) echo 'class="aio_hidden"'; ?>>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Login form CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("user-login-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on login page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to insert a CAPTCHA form on the login page.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_login_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_login_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Registration page CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("user-registration-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on registration page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to insert a CAPTCHA form on the WordPress user registration page (if you allow user registration).', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_registration_page_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_registration_page_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Lost password form CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
			//Display security info badge
			global $aiowps_feature_mgr;
			$aiowps_feature_mgr->output_feature_details_badge("lost-password-captcha");
			?>

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on lost password page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to insert a CAPTCHA form on the lost password page.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_lost_password_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_lost_password_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Custom login form CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
			//Display security info badge
			global $aiowps_feature_mgr;
			$aiowps_feature_mgr->output_feature_details_badge("custom-login-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on custom login form', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert CAPTCHA on a custom login form generated by the following WP function: %s', 'all-in-one-wp-security-and-firewall'), 'wp_login_form()'), 'aiowps_enable_custom_login_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_custom_login_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Add CAPTCHA to comments form', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("comment-form-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on comment forms', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to insert a CAPTCHA field on the comment forms.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_comment_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_comment_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Add CAPTCHA to password protected pages/posts', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("password_protected-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on password protected pages/posts', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to insert a CAPTCHA field on password-protected posts and pages.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_password_protected_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_password_protected_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	// Only display BuddyPress CAPTCHA settings if buddypress is active
	if (AIOWPSecurity_Utility::is_buddypress_plugin_active()) {
	?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Add CAPTCHA to BuddyPress registration form', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("bp-register-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on BuddyPress registration form', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA field on the %s registration forms.', 'all-in-one-wp-security-and-firewall'), 'BuddyPress'), 'aiowps_enable_bp_register_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_bp_register_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	}
	?>
	<?php
	// Only display bbPress CAPTCHA settings if bbPress is active
	if (AIOWPSecurity_Utility::is_bbpress_plugin_active()) {
	?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Add CAPTCHA to bbPress new topic form', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("bbp-new-topic-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on bbPress new topic form', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA field on the %s new topic forms.', 'all-in-one-wp-security-and-firewall'), 'bbPress'), 'aiowps_enable_bbp_new_topic_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_bbp_new_topic_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	}

	// Only display WooCommerce CAPTCHA settings if woo is active
	if (AIOWPSecurity_Utility::is_woocommerce_plugin_active()) {
	?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('WooCommerce forms CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
			//Display security info badge
			global $aiowps_feature_mgr;
			$aiowps_feature_mgr->output_feature_details_badge("woo-login-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on WooCommerce login form', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert CAPTCHA on a %s login form.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_login_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_login_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
			<hr>
			<?php
			$aiowps_feature_mgr->output_feature_details_badge("woo-lostpassword-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on WooCommerce lost password form', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert CAPTCHA on a %s lost password form.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_lostpassword_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_lostpassword_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
			<hr>
			<?php
			$aiowps_feature_mgr->output_feature_details_badge("woo-register-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on WooCommerce registration form', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert CAPTCHA on a %s registration form.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_register_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_register_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
			<hr>
			<?php
			$aiowps_feature_mgr->output_feature_details_badge("woo-checkout-captcha");
			?>
			<table class="form-table">
				<?php $is_enanled_guest_checkout = ('yes' == get_option('woocommerce_enable_guest_checkout')) ? 1 : 0; ?>
				<div class="<?php echo $is_enanled_guest_checkout ? "aio_blue_box" : "aio_red_box"; ?>">
					<p>
					<?php
					if (!$is_enanled_guest_checkout) {
						echo __('Guest checkout is not enabled in your WooCommerce settings.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Therefore, the setting below is not relevant.', 'all-in-one-wp-security-and-firewall');
						$checkout_checkbox_attributes = array('disabled' => 'disabled');
					} else {
						echo __('Guest checkout allows a customer to place an order without an account or being logged in.', 'all-in-one-wp-security-and-firewall');
						$checkout_checkbox_attributes = array();
					}
					?>	
					</p>
				</div>
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on WooCommerce the checkout page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA on the %s checkout page when a guest places an order.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_checkout_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_checkout_captcha'), $checkout_checkbox_attributes); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	}
	if (AIOWPSecurity_Utility::is_contact_form_7_plugin_active()) {
	?>
		<div class="postbox">
			<h3 class="hndle"><label for="title"><?php echo sprintf(__('Add CAPTCHA to %s', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7'); ?></label></h3>
			<div class="inside">
				<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("contact-form-7-captcha");
				?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php echo sprintf(__('Enable CAPTCHA on %s', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7'); ?>:</label></th>
						<td>
							<div class="aiowps_switch_container">
								<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA field on %s forms.', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7'), 'aiowps_enable_contact_form_7_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_contact_form_7_captcha')); ?>
								<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
								<div class="aiowps_more_info_body">
									<?php
										echo '<p class="description">'. sprintf(__('%s will automatically try to insert a CAPTCHA field before the form\'s submit button', 'all-in-one-wp-security-and-firewall'), 'AIOS') .'</p>';
										echo '<p class="description">'. sprintf(__('For the exact placement of the CAPTCHA you can use the following shortcode in your %s template', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7') .'</p>';
										echo '<pre>[' . AIOWPSEC_CAPTCHA_SHORTCODE .']</pre>';
										echo '<p class="description">'. sprintf(__('This feature requires %s version %s or greater', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7', '5.0') .'</p>';
										echo '<p class="description">'. sprintf(__('The validation message will be displayed only when using %s version %s or greater', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7', '5.6') .'</p>';
									?>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php
	}
	?>
	</div>
	<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_captcha_settings');?>
</form>