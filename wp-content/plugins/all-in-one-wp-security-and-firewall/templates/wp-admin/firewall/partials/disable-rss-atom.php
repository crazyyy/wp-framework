<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox aio_hidden" data-template="disable-rss-atom">
			<h3 class="hndle"><?php _e('Disable WordPress RSS and ATOM feeds', 'all-in-one-wp-security-and-firewall'); ?></h3>
			<div class="inside">
				<div id="firewall-disable-rss-and-atom-badge">
					<?php
					//Display security info badge
					$aiowps_feature_mgr->output_feature_details_badge("firewall-disable-rss-and-atom");
					?>
				</div>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Disable RSS and ATOM feeds:', 'all-in-one-wp-security-and-firewall'); ?></th>
						<td>
							<div class="aiowps_switch_container">
								<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you do not want users using feeds.', 'all-in-one-wp-security-and-firewall') . ' ' .__('RSS and ATOM feeds are used to read content from your site.', 'all-in-one-wp-security-and-firewall'), 'aiowps_disable_rss_and_atom_feeds', '1' == $aio_wp_security->configs->get_value('aiowps_disable_rss_and_atom_feeds')); ?>
								<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
								<div class="aiowps_more_info_body">
									<?php
									echo '<p class="description">'.__('Most users will want to share their site content widely, but some may prefer to prevent automated site scraping.', 'all-in-one-wp-security-and-firewall').'</p>';
									echo '<p class="description">'.sprintf(__('For more information, check the %s', 'all-in-one-wp-security-and-firewall'), '<a target="_blank" href="https://aiosplugin.com/should-i-turn-the-disable-rss-and-atom-feeds-feature-on/">'.__('FAQs', 'all-in-one-wp-security-and-firewall').'</a>').'</p>';
									?>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
