<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
			<h3 class="hndle"><?php _e('Disable WordPress RSS and ATOM feeds', 'all-in-one-wp-security-and-firewall'); ?></h3>
			<div class="inside">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Disable RSS and ATOM feeds:', 'all-in-one-wp-security-and-firewall'); ?></th>
						<td>
							<input id="aiowps_disable_rss_and_atom_feeds" name="aiowps_disable_rss_and_atom_feeds" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_disable_rss_and_atom_feeds'), '1'); ?> value="1">
							<label for="aiowps_disable_rss_and_atom_feeds" class="description"><?php echo __('Check this if you do not want users using feeds.', 'all-in-one-wp-security-and-firewall').' '.__('RSS and ATOM feeds are used to read content from your site.', 'all-in-one-wp-security-and-firewall').' '.__('Most users will want to share their site content widely, but some may prefer to prevent automated site scraping.', 'all-in-one-wp-security-and-firewall').' '.sprintf(__('For more information, check the %s', 'all-in-one-wp-security-and-firewall'), '<a target="_blank" href="https://aiosplugin.com/should-i-turn-the-disable-rss-and-atom-feeds-feature-on/">'.__('FAQs', 'all-in-one-wp-security-and-firewall').'</a>'); ?></label>
						</td>
					</tr>
				</table>
			</div>
		</div>
