<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Enforce strong password', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="enforce-strong-password-badge">
			<?php
			//Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("enforce-strong-password");
			?>
		</div>
		<div class="aio_blue_box">
			<?php
			echo '<p>'.esc_html__('This feature allows you to enforce the use of strong user passwords', 'all-in-one-wp-security-and-firewall').'</p>';
			echo '<p>'.esc_html__('When enabled, this feature will hide the "confirm weak password" checkbox on forms.', 'all-in-one-wp-security-and-firewall').'</p>';
			?>
		</div>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php esc_html_e('Enforce strong password', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to force your users to use a strong password.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enforce_strong_password', '1' == $aio_wp_security->configs->get_value('aiowps_enforce_strong_password')); ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>