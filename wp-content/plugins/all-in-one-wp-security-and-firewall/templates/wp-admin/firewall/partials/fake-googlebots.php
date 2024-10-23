<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
<h3 class="hndle"><label for="title"><?php _e('Block fake Googlebots', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
<div class="inside">

<div class="aio_blue_box">
	<?php
	$info_msg = '';
	$info_msg .= '<p>'. __('This feature allows you to block bots which are impersonating as a Googlebot but actually aren\'t. (In other words they are fake Google bots)', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg .= '<p>'.__('Googlebots have a unique identity which cannot easily be forged and this feature will identify any fake Google bots and block them from reading your site\'s pages.', 'all-in-one-wp-security-and-firewall').'</p>';
	echo $info_msg;
	?>
</div>
<div class="aio_yellow_box">
	<?php
	$info_msg_2 = '<p><strong>'. __('Attention', 'all-in-one-wp-security-and-firewall').'</strong>: '.__('Sometimes non-malicious Internet organizations might have bots which impersonate as a "Googlebot".', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg_2 .= '<p>'.__('Just be aware that if you activate this feature the plugin will block all bots which use the "Googlebot" string in their User Agent information but are NOT officially from Google (irrespective whether they are malicious or not).', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg_2 .= '<p>'.__('All other bots from other organizations such as "Yahoo", "Bing" etc will not be affected by this feature.', 'all-in-one-wp-security-and-firewall').'</p>';
	echo $info_msg_2;
	?>
</div>
<div id="firewall-block-fake-googlebots-badge">
	<?php
	//Display security info badge
	$aiowps_feature_mgr->output_feature_details_badge("firewall-block-fake-googlebots");
	?>
</div>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php _e('Block fake Googlebots', 'all-in-one-wp-security-and-firewall'); ?>:</th>
		<td>
			<div class="aiowps_switch_container">
				<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to block all fake Googlebots.', 'all-in-one-wp-security-and-firewall'), 'aiowps_block_fake_googlebots', $aiowps_firewall_config->get_value('aiowps_block_fake_googlebots')); ?>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
					<?php
					echo '<p class="description">'.__('This feature will check if the User Agent information of a bot contains the string "Googlebot".', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p class="description">'.__('It will then perform a few tests to verify if the bot is legitimately from Google and if so it will allow the bot to proceed.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p class="description">'.__('If the bot fails the checks then the plugin will mark it as being a fake Googlebot and it will block it', 'all-in-one-wp-security-and-firewall').'</p>';
					?>
				</div>
			</div>
		</td>
	</tr>
</table>
</div></div>