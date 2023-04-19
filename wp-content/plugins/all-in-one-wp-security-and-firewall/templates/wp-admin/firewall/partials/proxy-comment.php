<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Proxy comment posting', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		global $aiowps_firewall_config;
		//Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("firewall-forbid-proxy-comments");
		?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Forbid proxy comment posting', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_forbid_proxy_comments" name="aiowps_forbid_proxy_comments" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_forbid_proxy_comments')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_forbid_proxy_comments" class="description"><?php _e('Check this if you want to forbid proxy comment posting.', 'all-in-one-wp-security-and-firewall'); ?></label>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
					<p class="description">
						<?php
						_e('This setting will deny any requests that use a proxy server when posting comments.', 'all-in-one-wp-security-and-firewall');
						echo '<br>'.__('By forbidding proxy comments you are in effect eliminating some spam and other proxy requests.', 'all-in-one-wp-security-and-firewall');
						?>
					</p>
				</div>
				</td>
			</tr>
		</table>
		</div></div>
