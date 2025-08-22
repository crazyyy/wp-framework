<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>'.esc_html__('WordPress 5.6 introduced a new feature called "Application passwords".', 'all-in-one-wp-security-and-firewall').'
		<br />'.esc_html__('This allows you to create a token from the WordPress dashboard which then can be used in the authorization header.', 'all-in-one-wp-security-and-firewall').'<br /><br />'.esc_html__('This feature allows you to disable application passwords as they can leave your site vulnerable to social engineering and phishing scams.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Additional settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST" id="aios-disable-application-password-form">
			<div id="disable-application-password-badge">
			<?php
				$aiowps_feature_mgr->output_feature_details_badge("disable-application-password");
			?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Disable application password', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to disable the application password.', 'all-in-one-wp-security-and-firewall'), 'aiowps_disable_application_password', '1' == $aio_wp_security->configs->get_value('aiowps_disable_application_password')); ?>
						</div>
					</td>
				</tr>
			</table>
			<?php
				submit_button(esc_html__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_additonal_settings');
			?>
		</form>
	</div>
</div>