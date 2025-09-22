<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
	<div class="aio_blue_box">
		<?php
		$info_msg = '<p>' . esc_html__('This feature allows you to block bots which are impersonating as a Googlebot but actually aren\'t. (In other words they are fake Google bots)', 'all-in-one-wp-security-and-firewall') . '</p>';
		$info_msg .= '<p>'. esc_html__('Googlebots have a unique identity which cannot easily be forged and this feature will identify any fake Google bots and block them from reading your site\'s pages.', 'all-in-one-wp-security-and-firewall').'</p>';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Variable already escaped.
		echo $info_msg;
		?>
	</div>
	<div class="aio_yellow_box">
		<?php
		$info_msg_2 = '<p><strong>'. esc_html__('Attention', 'all-in-one-wp-security-and-firewall').'</strong>: '.__('Sometimes non-malicious Internet organizations might have bots which impersonate as a "Googlebot".', 'all-in-one-wp-security-and-firewall').'</p>';
		$info_msg_2 .= '<p>'.esc_html__('Just be aware that if you activate this feature the plugin will block all bots which use the "Googlebot" string in their User Agent information but are NOT officially from Google (irrespective of whether they are malicious or not).', 'all-in-one-wp-security-and-firewall').'</p>';
		$info_msg_2 .= '<p>'.esc_html__('All other bots from other organizations such as "Yahoo", "Bing" etc will not be affected by this feature.', 'all-in-one-wp-security-and-firewall').'</p>';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Variable already escaped.
		echo $info_msg_2;
		?>
	</div>
	<table class="form-table">
		<tr valign="top">
			<div id="firewall-block-fake-googlebots-badge">
				<?php
				//Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("firewall-block-fake-googlebots");
				?>
			</div>
		</tr>
		<tr valign="top">
			<th scope="row"><?php esc_html_e('Block fake Googlebots', 'all-in-one-wp-security-and-firewall'); ?>:</th>
			<td>
				<div class="aiowps_switch_container">
					<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to block all fake Googlebots.', 'all-in-one-wp-security-and-firewall'), 'aiowps_block_fake_googlebots', $aiowps_firewall_config->get_value('aiowps_block_fake_googlebots')); ?>
					<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
					<div class="aiowps_more_info_body">
						<?php
						echo '<p class="description">'.esc_html__('This feature will check if the User Agent information of a bot contains the string "Googlebot".', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.esc_html__('It will then perform a few tests to verify if the bot is legitimately from Google and if so it will allow the bot to proceed.', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.esc_html__('If the bot fails the checks then the plugin will mark it as being a fake Googlebot and it will block it', 'all-in-one-wp-security-and-firewall').'</p>';
						?>
					</div>
				</div>
			</td>
		</tr>
	</table>
