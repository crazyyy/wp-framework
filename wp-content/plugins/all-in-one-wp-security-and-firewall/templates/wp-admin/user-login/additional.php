<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>'.__('WordPress 5.6 introduced a new feature called "Application passwords".', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('This allows you to create a token from the WordPress dashboard which then can be used in the authorization header.', 'all-in-one-wp-security-and-firewall').'<br /><br />'.__('This feature allows you to disable application passwords as they can leave your site vulnerable to social engineering and phishing scams.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Additional settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php
				$aiowps_feature_mgr->output_feature_details_badge("disable-application-password");
			?>

			<?php wp_nonce_field('aiowpsec-additonal-settings-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Disable application password', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input name="aiowps_disable_application_password" id="aiowps_disable_application_password" type="checkbox" <?php checked($aio_wp_security->configs->get_value('aiowps_disable_application_password'), '1'); ?> value="1"/>
					<label for="aiowps_disable_application_password"><?php _e('Check this if you want to disable the application password.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<?php
				submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_additonal_settings');
			?>
		</form>
	</div>
</div>