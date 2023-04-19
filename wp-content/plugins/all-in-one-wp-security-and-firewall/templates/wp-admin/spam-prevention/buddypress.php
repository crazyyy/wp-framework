<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('BuddyPress spam settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" method="POST">
	<?php wp_nonce_field('aiowpsec-bp-spam-settings-nonce'); ?>            
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Add CAPTCHA to BuddyPress registration form', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature will add a simple math CAPTCHA field in the BuddyPress registration form.', 'all-in-one-wp-security-and-firewall').'<br>'.__('Adding a CAPTCHA field in the registration form is a simple way of greatly reducing spam signups from bots without using .htaccess rules.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<?php
				if (defined('BP_VERSION')) {
					// Display security info badge
					$aiowps_feature_mgr->output_feature_details_badge("bp-register-captcha");
			?>
			<?php AIOWPSecurity_Captcha::warning_captcha_settings_notset(); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_enable_bp_register_captcha"><?php _e('Enable CAPTCHA on BuddyPress registration form', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
					<input id="aiowps_enable_bp_register_captcha" name="aiowps_enable_bp_register_captcha" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_bp_register_captcha')) echo ' checked="checked"'; ?> value="1">
					<label for="aiowps_enable_bp_register_captcha"><?php _e('Check this if you want to insert a CAPTCHA field on the BuddyPress registration forms.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<input type="submit" name="aiowps_save_bp_spam_settings" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>
<?php
				} else {
					$AIOWPSecurity_Spam_Menu->show_msg_error(__('BuddyPress is not active! In order to use this feature you will need to have BuddyPress installed and activated.', 'all-in-one-wp-security-and-firewall'));
				}