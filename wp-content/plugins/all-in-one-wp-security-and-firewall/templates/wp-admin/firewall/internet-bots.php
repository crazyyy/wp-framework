<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('Internet bot settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" method="POST">
<?php wp_nonce_field('aiowpsec-save-internet-bot-settings-nonce'); ?>
<div class="aio_blue_box">
	<?php
	$info_msg = '';
	$wiki_link = '<a href="http://en.wikipedia.org/wiki/Internet_bot" target="_blank">'.__('What is an Internet Bot', 'all-in-one-wp-security-and-firewall').'</a>';
	$info_msg .= '<p><strong>'.sprintf(__('%s?', 'all-in-one-wp-security-and-firewall'), $wiki_link).'</strong></p>';

	$info_msg .= '<p>'. __('A bot is a piece of software which runs on the Internet and performs automatic tasks. For example when Google indexes your pages it uses automatic bots to achieve this task.', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg .= '<p>'. __('A lot of bots are legitimate and non-malicous but not all bots are good and often you will find some which try to impersonate legitimate bots such as "Googlebot" but in reality they have nohing to do with Google at all.', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg .= '<p>'. __('Although most of the bots out there are relatively harmless sometimes website owners want to have more control over which bots they allow into their site.', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg .= '<p>'. __('This feature allows you to block bots which are impersonating as a Googlebot but actually aren\'t. (In other words they are fake Google bots)', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg .= '<p>'.__('Googlebots have a unique indentity which cannot easily be forged and this feature will indentify any fake Google bots and block them from reading your site\'s pages.', 'all-in-one-wp-security-and-firewall').'</p>';
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

<div class="postbox">
<h3 class="hndle"><label for="title"><?php _e('Block fake Googlebots', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
<div class="inside">
<?php
//Display security info badge
$aiowps_feature_mgr->output_feature_details_badge("firewall-block-fake-googlebots");
?>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php _e('Block fake Googlebots', 'all-in-one-wp-security-and-firewall'); ?>:</th>
		<td>
		<input id="aiowps_block_fake_googlebots" name="aiowps_block_fake_googlebots" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_block_fake_googlebots')=='1') echo ' checked="checked"'; ?> value="1"/>
		<label for="aiowps_block_fake_googlebots" class="description"><?php _e('Check this if you want to block all fake Googlebots.', 'all-in-one-wp-security-and-firewall'); ?></label>
		<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
		<div class="aiowps_more_info_body">
				<?php
				echo '<p class="description">'.__('This feature will check if the User Agent information of a bot contains the string "Googlebot".', 'all-in-one-wp-security-and-firewall').'</p>';
				echo '<p class="description">'.__('It will then perform a few tests to verify if the bot is legitimately from Google and if so it will allow the bot to proceed.', 'all-in-one-wp-security-and-firewall').'</p>';
				echo '<p class="description">'.__('If the bot fails the checks then the plugin will mark it as being a fake Googlebot and it will block it', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
		</div>
		</td>
	</tr>
</table>
</div></div>
<input type="submit" name="aiowps_save_internet_bot_settings" value="<?php _e('Save internet bot settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>
