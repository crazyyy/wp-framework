<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Advanced character string filter', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		//Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("firewall-advanced-character-string-filter");
		?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable advanced character string filter', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_advanced_char_string_filter" name="aiowps_advanced_char_string_filter" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_advanced_char_string_filter')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_advanced_char_string_filter" class="description"><?php _e('This will block bad character matches from XSS.', 'all-in-one-wp-security-and-firewall'); ?></label>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
					<p class="description">
						<?php
						_e('This is an advanced character string filter to prevent malicious string attacks on your site coming from Cross Site Scripting (XSS).', 'all-in-one-wp-security-and-firewall');
						echo '<br />'.__('This setting matches for common malicious string patterns and exploits and will produce a 403 error for the hacker attempting the query.', 'all-in-one-wp-security-and-firewall');
						echo '<br />'.__('NOTE: Some strings for this setting might break some functionality.', 'all-in-one-wp-security-and-firewall');
						echo '<br /><strong>'.__('You are therefore strongly advised to take a backup of your active .htaccess file before applying this feature.', 'all-in-one-wp-security-and-firewall').'<strong>';
						?>
					</p>
				</div>
				</td>
			</tr>
		</table>
		</div></div>
