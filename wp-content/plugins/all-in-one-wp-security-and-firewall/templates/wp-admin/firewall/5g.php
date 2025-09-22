<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php esc_html_e('Firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" id="aios-5g-firewall-settings-form">
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php esc_html_e('5G firewall settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="dep-warning">
			<span class="dashicons dashicons-warning"></span>
			<span class="dep-warning-text"><?php esc_html_e('This feature is marked for deprecation and will be removed in a future version of the plugin.', 'all-in-one-wp-security-and-firewall'); ?></span>
		</div>
		<div class="inside">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Enable legacy 5G firewall protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this to apply the 5G firewall protection from perishablepress.com to your site.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_5g_firewall', '1' == $aio_wp_security->configs->get_value('aiowps_enable_5g_firewall')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.esc_html__('This setting will implement the 5G security firewall protection mechanisms on your site which include the following things:', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.esc_html__('1) Block forbidden characters commonly used in exploitative attacks.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.esc_html__('2) Block malicious encoded URL characters such as the ".css(" string.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.esc_html__('3) Guard against the common patterns and specific exploits in the root portion of targeted URLs.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.esc_html__('4) Stop attackers from manipulating query strings by disallowing illicit characters.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.esc_html__('....and much more.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<input type="submit" name="aiowps_apply_5g_firewall_settings" value="<?php esc_attr_e('Save 5G firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>
