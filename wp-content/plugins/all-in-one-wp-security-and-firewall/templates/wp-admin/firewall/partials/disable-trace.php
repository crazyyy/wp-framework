<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php esc_html_e('Trace and track', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<div id="firewall-disable-trace-track-badge">
				<?php
				//Display security info badge
				global $aiowps_feature_mgr;
				$aiowps_feature_mgr->output_feature_details_badge("firewall-disable-trace-track");
				?>
			</div>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php esc_html_e('Disable trace and track', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to disable trace and track.', 'all-in-one-wp-security-and-firewall'), 'aiowps_disable_trace_and_track', '1' == $aio_wp_security->configs->get_value('aiowps_disable_trace_and_track')); ?>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<p class="description">
								<?php
								esc_html_e('HTTP Trace attack (XST) can be used to return header requests and grab cookies and other information.', 'all-in-one-wp-security-and-firewall');
								echo '<br />';
								esc_html_e('This hacking technique is usually used together with cross site scripting attacks (XSS).', 'all-in-one-wp-security-and-firewall');
								echo '<br />';
								esc_html_e('Disabling trace and track on your site will help prevent HTTP Trace attacks.', 'all-in-one-wp-security-and-firewall');
								?>
							</p>
						</div>
					</div>
				</td>
			</tr>
		</table>
		</div></div>
