<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('Firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
		<div class="aio_blue_box">
			<?php
			$info_msg = '<p>'.sprintf(__('This feature allows you to activate the %s (or legacy %s) firewall security protection rules designed and produced by %s.', 'all-in-one-wp-security-and-firewall'), '<a href="http://perishablepress.com/6g/" target="_blank">6G</a>', '<a href="http://perishablepress.com/5g-blacklist-2013/" target="_blank">5G</a>', '<a href="http://perishablepress.com/" target="_blank">Perishable Press</a>').'</p>';
			$info_msg .= '<p>'.__('The 6G Blacklist is an updated and improved version of the 5G Blacklist that is PHP-based and doesn\'t use a .htaccess file. If you have the 5G Blacklist active, you might consider activating the 6G Blacklist instead.', 'all-in-one-wp-security-and-firewall').'</p>';
			$info_msg .= '<p>'.__('The 6G Blacklist is a simple, flexible blacklist that helps reduce the number of malicious URL requests that hit your website.', 'all-in-one-wp-security-and-firewall').'</p>';
			$info_msg .= '<p>'.__('The added advantage of applying the 6G firewall to your site is that it has been tested and confirmed by the people at PerishablePress.com to be an optimal and least disruptive set of security rules for general WP sites.', 'all-in-one-wp-security-and-firewall').'</p>';
			echo $info_msg;
			?>
		</div>

		<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('6G blacklist/firewall settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		//Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("firewall-enable-5g-6g-blacklist");
		?>

		<form action="" method="POST">
		<?php wp_nonce_field('aiowpsec-enable-5g-6g-firewall-nonce'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable 6G firewall protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_enable_6g_firewall" name="aiowps_enable_6g_firewall" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_enable_6g_firewall')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_enable_6g_firewall" class="description"><?php _e('Check this if you want to apply the 6G Blacklist firewall protection from perishablepress.com to your site.', 'all-in-one-wp-security-and-firewall'); ?></label>
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
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Enable legacy 5G firewall protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_enable_5g_firewall" name="aiowps_enable_5g_firewall" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_enable_5g_firewall')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_enable_5g_firewall" class="description"><?php _e('Check this if you want to apply the 5G Blacklist firewall protection from perishablepress.com to your site.', 'all-in-one-wp-security-and-firewall'); ?></label>
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
				</td>
			</tr>
		</table>
		<input type="submit" name="aiowps_apply_5g_6g_firewall_settings" value="<?php _e('Save 5G/6G firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
		</div></div>

		
		<form action="" method="POST">
		<?php wp_nonce_field('aiowpsec-6g-block-request-methods-nonce'); ?>
			<div class="postbox">
			<h3 class="hndle"><label for="title"><?php _e('6G block request methods', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
				<div class="inside">
					<div class="aio_blue_box">
						<?php
							echo '<p>' . __('HTTP Request methods are used by browsers and clients to communicate with servers to get responses.', 'all-in-one-wp-security-and-firewall') . '</p>';
							echo '<p>' . __('GET and POST are the most commonly used methods to request and submit data for specified resources of the server.', 'all-in-one-wp-security-and-firewall') . '</p>';
						?>
					</div>
					<table class="form-table">
						<?php foreach ($block_request_methods as $block_request_method) {?>
							<tr>
							<th><?php printf(__('Block %s method', 'all-in-one-wp-security-and-firewall'), strtoupper($block_request_method));?>:</th>
							<td>
								<input id="<?php echo esc_attr("aiowps_block_request_method_{$block_request_method}");?>" name="<?php echo esc_attr("aiowps_block_request_method_{$block_request_method}");?>" type="checkbox"<?php checked(in_array(strtoupper($block_request_method), $methods));?>>
								<label for="<?php echo esc_attr("aiowps_block_request_method_{$block_request_method}");?>" class="description"><?php printf(__('Check this to block the %s request method', 'all-in-one-wp-security-and-firewall'), strtoupper($block_request_method));?></label>
								<?php if ('put' == $block_request_method) {?>
								<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
								<div class="aiowps_more_info_body">
									<?php
									echo '<p class="description">' . __('Some WooCommerce extensions use the PUT request method in addition to GET and POST.', 'all-in-one-wp-security-and-firewall') . ' ' . __("This means WooCommerce users shouldn't block the PUT request method.", 'all-in-one-wp-security-and-firewall') . '</p>';
									echo '<p class="description">' . __('A few REST requests use the PUT request method.', 'all-in-one-wp-security-and-firewall') . ' ' . __('If your site is communicated by the WP REST API, you should not block the PUT request method.', 'all-in-one-wp-security-and-firewall') . '</p>';
									?>
								</div>
								<?php } ?>
							</td>
							</tr>
						<?php } ?>
					</table>
				<input type="submit" name="aiowps_apply_6g_block_request_methods_settings" value="<?php esc_attr_e('Save request methods settings', 'all-in-one-wp-security-and-firewall');?>" class="button-primary"<?php disabled(empty($aiowps_firewall_config)); ?>/>
				</div></div>
			</form>

		
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-other-6g-settings-nonce'); ?>
			<div class="postbox">
				<h3 class="hndle"><label for="title"><?php _e('6G other settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
				<div class="inside">
					<table class="form-table">
						<tr>
							<th><?php _e('Block query strings', 'all-in-one-wp-security-and-firewall');?>:</th>
							<td>
								<input  id="aiowps_block_query" name="aiowps_block_query" type="checkbox"<?php checked($blocked_query);?>>
								<label for="aiowps_block_query" class="description"><?php _e('Check this to block all query strings recommended by 6G', 'all-in-one-wp-security-and-firewall');?></label>
							</td>
						</tr>
						<tr>
							<th><?php _e('Block request strings', 'all-in-one-wp-security-and-firewall');?>:</th>
							<td>
								<input  id="aiowps_block_request" name="aiowps_block_request" type="checkbox"<?php checked($blocked_request);?>>
								<label for="aiowps_block_request" class="description"><?php _e('Check this to block all request strings recommended by 6G', 'all-in-one-wp-security-and-firewall');?></label>
							</td>
						</tr>
						<tr>
							<th><?php _e('Block referrers', 'all-in-one-wp-security-and-firewall');?>:</th>
							<td>
								<input  id="aiowps_block_refs" name="aiowps_block_refs" type="checkbox"<?php checked($blocked_referrers);?>>
								<label for="aiowps_block_refs" class="description"><?php _e('Check this to block all referrers recommended by 6G', 'all-in-one-wp-security-and-firewall');?></label>
							</td>
						</tr>
						<tr>
						<th><?php _e('Block user-agents', 'all-in-one-wp-security-and-firewall');?>:</th>
						<td>
							<input  id="aiowps_block_agents" name="aiowps_block_agents" type="checkbox"<?php checked($blocked_agents);?>>
							<label for="aiowps_block_agents" class="description"><?php _e('Check this to block all user-agents recommended by 6G', 'all-in-one-wp-security-and-firewall');?></label>
						</td>
						</tr>
					</table>
					<input type="submit" name="aiowps_apply_6g_other_settings"<?php disabled(empty($aiowps_firewall_config));?> value="<?php _e('Save other settings', 'all-in-one-wp-security-and-firewall');?>" class="button-primary" />
				</div>
			</div>
		</form>
