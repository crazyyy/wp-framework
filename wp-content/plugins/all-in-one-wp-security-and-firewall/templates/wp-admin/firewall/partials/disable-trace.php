<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Trace and track', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		//Display security info badge
		global $aiowps_feature_mgr;
		$aiowps_feature_mgr->output_feature_details_badge("firewall-disable-trace-track");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Disable trace and track', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_disable_trace_and_track" name="aiowps_disable_trace_and_track" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_disable_trace_and_track')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_disable_trace_and_track" class="description"><?php _e('Check this if you want to disable trace and track.', 'all-in-one-wp-security-and-firewall'); ?></label>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
					<p class="description">
						<?php
						_e('HTTP Trace attack (XST) can be used to return header requests and grab cookies and other information.', 'all-in-one-wp-security-and-firewall');
						echo '<br />';
						_e('This hacking technique is usually used together with cross site scripting attacks (XSS).', 'all-in-one-wp-security-and-firewall');
						echo '<br />';
						_e('Disabling trace and track on your site will help prevent HTTP Trace attacks.', 'all-in-one-wp-security-and-firewall');
						?>
					</p>
				</div>
				</td>
			</tr>
		</table>
		</div></div>
