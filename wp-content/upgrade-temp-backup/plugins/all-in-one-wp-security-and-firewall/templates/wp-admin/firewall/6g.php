<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('Firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
		<?php
		$info_msg = '<p>'.sprintf(__('This feature allows you to activate the %s (or legacy %s) firewall security protection rules designed and produced by %s.', 'all-in-one-wp-security-and-firewall'), '<a href="http://perishablepress.com/6g/" target="_blank">6G</a>', '<a href="http://perishablepress.com/5g-blacklist-2013/" target="_blank">5G</a>', '<a href="http://perishablepress.com/" target="_blank">Perishable Press</a>').'</p>';
		$info_msg .= '<p>'.__('The 6G firewall is an updated and improved version of the 5G firewall that is PHP-based and doesn\'t use a .htaccess file.', 'all-in-one-wp-security-and-firewall') . ' ' . __('If you have the 5G firewall active, you might consider activating the 6G firewall instead.', 'all-in-one-wp-security-and-firewall').'</p>';
		$info_msg .= '<p>'.__('The 6G firewall is a simple, flexible blacklist that helps reduce the number of malicious URL requests that hit your website.', 'all-in-one-wp-security-and-firewall').'</p>';
		$info_msg .= '<p>'.__('The added advantage of applying the 6G firewall to your site is that it has been tested and confirmed by the people at PerishablePress.com to be an optimal and least disruptive set of security rules for general WP sites.', 'all-in-one-wp-security-and-firewall').'</p>';
		echo $info_msg;
		?>
	</div>
<div id="aios-6g-firewall-settings-container">
	<form action="" id="aios-6g-firewall-settings-form">
		<div class="postbox">
			<h3 class="hndle"><label for="title"><?php _e('6G firewall settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
			<div class="inside">
				<div id="firewall-enable-6g-badge">
					<?php
					// Display security info badge
					$aiowps_feature_mgr->output_feature_details_badge("firewall-enable-6g");
					?>
					</div>
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable 6G firewall protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to apply the recommended 6G firewall protection.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_6g_firewall', '1' == $aio_wp_security->configs->get_value('aiowps_enable_6g_firewall')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.__('This setting will implement the 6G security firewall protection mechanisms on your site which include the following things:', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('1) Block forbidden characters commonly used in exploitative attacks.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('2) Block malicious encoded URL characters such as the ".css(" string.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('3) Guard against the common patterns and specific exploits in the root portion of targeted URLs.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('4) Stop attackers from manipulating query strings by disallowing illicit characters.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('....and much more.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
							</div>
						</div>
					</td>
				</tr>
			</table>

				<button type="button" class="button button-link aios-toggle-advanced-options<?php if ($advanced_options_disabled) echo ' advanced-options-disabled';?>">
					<span class="text">
						<span class="dashicons dashicons-arrow-down-alt2"></span>
						<span class="aios-toggle-advanced-options__text-show"><?php _e('Show advanced options', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aios-toggle-advanced-options__text-hide"><?php _e('Hide advanced options', 'all-in-one-wp-security-and-firewall'); ?></span>
					</span>
				</button>

				<div class="aios-advanced-options-panel">
					<?php $aio_wp_security->include_template('wp-admin/firewall/partials/advanced-settings-6g.php', false, compact('methods', 'blocked_query', 'blocked_request', 'blocked_referrers', 'blocked_agents', 'block_request_methods')); ?>
				</div>
			</div>
		</div>
		<div class="postbox">
			<h3 class="hndle"><label for="title"><?php _e('5G firewall settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
			<div class="dep-warning">
				<span class="dashicons dashicons-warning"></span>
				<span class="dep-warning-text"><?php _e('This feature is marked for deprecation and will be removed in a future version of the plugin.', 'all-in-one-wp-security-and-firewall'); ?></span>
			</div>
			<div class="inside">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Enable legacy 5G firewall protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
						<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to apply the 5G firewall protection from perishablepress.com to your site.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_5g_firewall', '1' == $aio_wp_security->configs->get_value('aiowps_enable_5g_firewall')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.__('This setting will implement the 5G security firewall protection mechanisms on your site which include the following things:', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('1) Block forbidden characters commonly used in exploitative attacks.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('2) Block malicious encoded URL characters such as the ".css(" string.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('3) Guard against the common patterns and specific exploits in the root portion of targeted URLs.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('4) Stop attackers from manipulating query strings by disallowing illicit characters.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('....and much more.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
							</div>
						</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<input type="submit" name="aiowps_apply_5g_6g_firewall_settings" value="<?php esc_attr_e('Save firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
	</form>
</div>
