<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Listing of directory contents', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		//Display security info badge
		global $aiowps_feature_mgr;
		$aiowps_feature_mgr->output_feature_details_badge("firewall-disable-index-views");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Disable index views', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_disable_index_views" name="aiowps_disable_index_views" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_disable_index_views')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_disable_index_views" class="description"><?php _e('Check this if you want to disable directory and file listing.', 'all-in-one-wp-security-and-firewall'); ?></label>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
					<p class="description">
						<?php
						_e('By default, an Apache server will allow the listing of the contents of a directory if it doesn\'t contain an index.php file.', 'all-in-one-wp-security-and-firewall');
						echo '<br />';
						_e('This feature will prevent the listing of contents for all directories.', 'all-in-one-wp-security-and-firewall');
						echo '<br />';
						_e('NOTE: In order for this feature to work "AllowOverride" of the Indexes directive must be enabled in your httpd.conf file. Ask your hosting provider to check this if you don\'t have access to httpd.conf', 'all-in-one-wp-security-and-firewall');
						?>
					</p>
				</div>
				</td>
			</tr>
		</table>
		</div></div>
