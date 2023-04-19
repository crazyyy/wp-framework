<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('bbPress spam settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" method="POST">
	<?php wp_nonce_field('aiowpsec-bbp-spam-settings-nonce'); ?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Add CAPTCHA to bbPress new topic form', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature will add a simple math CAPTCHA field in the bbPress new topic form.', 'all-in-one-wp-security-and-firewall').'<br>'.__('Adding a CAPTCHA field in this form is a simple way of greatly reducing spam submitted from bots.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<?php
			if (class_exists('bbPress')) {
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("bbp-new-topic-captcha");
			?>
			<?php AIOWPSecurity_Captcha::warning_captcha_settings_notset(); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_enable_bbp_new_topic_captcha"><?php _e('Enable CAPTCHA on bbPress new topic form', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<input id="aiowps_enable_bbp_new_topic_captcha" name="aiowps_enable_bbp_new_topic_captcha" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_enable_bbp_new_topic_captcha') == '1') echo ' checked="checked"'; ?> value="1">
						<label for="aiowps_enable_bbp_new_topic_captcha"><?php _e('Check this if you want to insert a CAPTCHA field on the bbPress new topic forms.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<input type="submit" name="aiowps_save_bbp_spam_settings" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>
			<?php
			} else {
				$AIOWPSecurity_Spam_Menu->show_msg_error(__('bbPress is not active. In order to use this feature you will need to have bbPress installed and activated.', 'all-in-one-wp-security-and-firewall'));
			}