<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Ban IPs or user agents', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>' . __('The All In One WP Security Blacklist feature gives you the option of banning certain host IP addresses or ranges and also user agents.', 'all-in-one-wp-security-and-firewall').'
	<br />' . __('This feature will deny total site access for users which have IP addresses or user agents matching those which you have configured in the settings below.', 'all-in-one-wp-security-and-firewall').'
	<br />' . __('Black-listed visitors will be blocked as soon as WordPress loads, preventing them from gaining any further access.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<?php
if (!defined('AIOWPSECURITY_NOADS_B') || !AIOWPSECURITY_NOADS_B) {
?>
	<div class="aio_grey_box">
		<?php
			$premium_plugin_link = '<strong><a href="https://aiosplugin.com/" target="_blank">' . htmlspecialchars(__('All In One WP Security & Firewall Premium', 'all-in-one-wp-security-and-firewall')) . '</a></strong>';
			$info_msg = sprintf(__('You may also be interested in %s.', 'all-in-one-wp-security-and-firewall'), $premium_plugin_link);
			$info_msg2 = sprintf(__('This plugin adds a number of extra features including %s and %s.', 'all-in-one-wp-security-and-firewall'), '<strong>' . __('smart 404 blocking', 'all-in-one-wp-security-and-firewall') . '</strong>', '<strong>' . __('country IP blocking', 'all-in-one-wp-security-and-firewall') . '</strong>');
			echo '<p>' . $info_msg . '<br />' . $info_msg2 . '</p>';
		?>
	</div>
<?php
}
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('IP hosts and user agent blacklist settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="blacklist-manager-ip-user-agent-blacklisting-badge">
			<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("blacklist-manager-ip-user-agent-blacklisting");
			?>
		</div>
		<form action="" id="aios-blacklist-settings-form">
			<div class="aio_orange_box">
				<p>
					<?php
						$read_link = '<a href="https://aiosplugin.com/important-note-on-intermediate-and-advanced-features" target="_blank">' . __('must read this message', 'all-in-one-wp-security-and-firewall') . '</a>';
						echo __('This feature can lock you out of admin if it doesn\'t work correctly on your site.', 'all-in-one-wp-security-and-firewall'). ' ' . sprintf(__('You %s before activating this feature.', 'all-in-one-wp-security-and-firewall'), $read_link);
					?>
				</p>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable IP or user agent blacklisting', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want the banning (or blacklisting) of selected IP addresses and/or user agents specified in the settings below', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_blacklisting', '1' == $aio_wp_security->configs->get_value('aiowps_enable_blacklisting')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_banned_ip_addresses"><?php _e('Enter IP addresses:', 'all-in-one-wp-security-and-firewall'); ?></label></th>
					<td>
						<textarea id="aiowps_banned_ip_addresses" name="aiowps_banned_ip_addresses" rows="5" cols="50"><?php echo (-1 == $result) ? esc_textarea($aiowps_banned_ip_addresses) : esc_textarea($aio_wp_security->configs->get_value('aiowps_banned_ip_addresses')); ?></textarea>
						<br />
						<span class="description"><?php _e('Enter one or more IP addresses or IP ranges.', 'all-in-one-wp-security-and-firewall');?></span>
						<?php $aio_wp_security->include_template('info/ip-address-ip-range-info.php');?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_banned_user_agents"><?php _e('Enter user agents:', 'all-in-one-wp-security-and-firewall'); ?></label></th>
					<td>
						<textarea id="aiowps_banned_user_agents" name="aiowps_banned_user_agents" rows="5" cols="50"><?php echo (-1 == $result) ? esc_textarea($aiowps_banned_user_agents) : esc_textarea($aio_wp_security->configs->get_value('aiowps_banned_user_agents')); ?></textarea>
						<br />
						<span class="description">
						<?php _e('Enter one or more user agent strings.', 'all-in-one-wp-security-and-firewall');?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More Info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
								echo '<p class="description">' . __('The user agent string will be checked in a case-insensitive manner.', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . __('Each user agent string must be on a new line.', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . __('Example 1 - A single user agent string to block:', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">SquigglebotBot</p>';
								echo '<p class="description">' . __('Example 2 - A list of more than 1 user agent strings to block', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">baiduspider<br />SquigglebotBot<br />SurveyBot<br />VoidEYE<br />webcrawl.net<br />YottaShopping_Bot</p>';
							?>
						</div>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_blacklist_settings');?>
		</form>
	</div>
</div>
