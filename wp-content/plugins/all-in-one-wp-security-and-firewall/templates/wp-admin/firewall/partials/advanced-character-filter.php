<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox aio_hidden" data-template="advanced-character-filter">
		<h3 class="hndle"><label for="title"><?php _e('Advanced character string filter', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<div id="firewall-advanced-character-string-filter-badge">
			<?php
			$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);
			//Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("firewall-advanced-character-string-filter");
			?>
		</div>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable advanced character string filter', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('This will block character sequences which resemble XSS attacks.', 'all-in-one-wp-security-and-firewall'), 'aiowps_advanced_char_string_filter', $aiowps_firewall_config->get_value('aiowps_advanced_char_string_filter')); ?>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<p class="description">
								<?php
								_e('This is an advanced character string filter to prevent malicious string attacks on your site coming from Cross Site Scripting (XSS).', 'all-in-one-wp-security-and-firewall');
								echo '<br />'.__('This setting matches for common malicious string patterns and exploits and will produce a 403 error for the hacker attempting the query.', 'all-in-one-wp-security-and-firewall');
								echo '<br />'.__('NOTE: Some strings for this setting might break some functionality.', 'all-in-one-wp-security-and-firewall');
								?>
							</p>
						</div>
					</div>
				</td>
			</tr>
		</table>
		</div></div>
