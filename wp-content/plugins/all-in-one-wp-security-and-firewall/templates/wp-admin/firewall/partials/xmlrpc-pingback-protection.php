<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox aio_hidden" data-template="xmlrpc-pingback-protection">
		<h3 class="hndle"><label for="title"><?php _e('WordPress XMLRPC and pingback vulnerability protection', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<div id="firewall-pingback-rules-badge">
				<?php
				global $aiowps_firewall_config;
				//Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("firewall-pingback-rules");
				?>
			</div>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Completely block access to XMLRPC', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you are not using the WP XML-RPC functionality and you want to completely block external access to XMLRPC.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_pingback_firewall', $aiowps_firewall_config->get_value('aiowps_enable_pingback_firewall')); ?>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.__('This setting will disable access to the WordPress xmlrpc.php file which is responsible for the XML-RPC functionality in WordPress.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('Hackers can exploit various vulnerabilities in the WordPress XML-RPC API in a number of ways such as:', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('1) Denial of Service (DoS) attacks', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('2) Hacking internal routers.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('3) Scanning ports in internal networks to get info from various hosts.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('Apart from the security protection benefit, this feature may also help reduce load on your server, particularly if your site currently has a lot of unwanted traffic hitting the XML-RPC API on your installation.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('NOTE: You should only enable this feature if you are not currently using the XML-RPC functionality on your WordPress installation.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('Leave this feature disabled and use the feature below if you want pingback protection but you still need XMLRPC.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
						</div>
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Disable pingback functionality from XMLRPC', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('If you use Jetpack or WP iOS or other apps which need WP XML-RPC functionality then check this.', 'all-in-one-wp-security-and-firewall') . ' ' . __('This will enable protection against WordPress pingback vulnerabilities.', 'all-in-one-wp-security-and-firewall'), 'aiowps_disable_xmlrpc_pingback_methods', '1' == $aio_wp_security->configs->get_value('aiowps_disable_xmlrpc_pingback_methods')); ?>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.__('NOTE: If you use Jetpack or the Wordpress iOS or other apps then you should enable this feature but leave the "Completely Block Access To XMLRPC" checkbox unchecked.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('The feature will still allow XMLRPC functionality on your site but will disable the pingback methods.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('This feature will also remove the "X-Pingback" header if it is present.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
						</div>
					</div>
				</td>
			</tr>
		</table>
		</div></div>
