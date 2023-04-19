<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Bad query strings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		global $aiowps_firewall_config;
		//Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("firewall-deny-bad-queries");
		?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Deny bad query strings', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_deny_bad_query_strings" name="aiowps_deny_bad_query_strings" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_deny_bad_query_strings')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_deny_bad_query_strings" class="description"><?php _e('This will help protect you against malicious queries via XSS.', 'all-in-one-wp-security-and-firewall'); ?></label>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
					<p class="description">
						<?php
						_e('This feature will write rules in your .htaccess file to prevent malicious string attacks on your site using XSS.', 'all-in-one-wp-security-and-firewall');
						echo '<br />'.__('NOTE: Some of these strings might be used for plugins or themes and hence this might break some functionality.', 'all-in-one-wp-security-and-firewall');
						echo '<br /><strong>'.__('You are therefore strongly advised to take a backup of your active .htaccess file before applying this feature.', 'all-in-one-wp-security-and-firewall').'<strong>';
						?>
					</p>
				</div>
				</td>
			</tr>
		</table>
		</div></div>
