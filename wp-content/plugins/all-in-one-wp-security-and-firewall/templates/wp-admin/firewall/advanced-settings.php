<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('Advanced settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
			<div class="postbox">
				<h3 class="hndle"><label for="title"><?php _e('Firewall setup', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
				<div class="inside">
				<div class="aio_blue_box">
					<p>
						<?php _e('This option allows you to set up or downgrade the firewall.', 'all-in-one-wp-security-and-firewall'); ?><br>
						<?php _e('We recommend you set up the firewall for greater protection, but if for whatever reason you wish to downgrade the firewall, then you can do so here.', 'all-in-one-wp-security-and-firewall'); ?><br>
					</p>
				</div>
				<table class="form-table">
					<tr valign="row">
							<th scope="row"><?php _e('Firewall', 'all-in-one-wp-security-and-firewall'); ?>:</th>
							<td>
								<?php AIOWPSecurity_Utility_Firewall::is_firewall_setup() ? $aio_wp_security->include_template('wp-admin/firewall/partials/firewall-downgrade-button.php') : $aio_wp_security->include_template('wp-admin/firewall/partials/firewall-set-up-button.php'); ?>
								<span style='margin-top: 5px;' class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
								<div class="aiowps_more_info_body">
									<p class="description"><strong><?php _e('Set up firewall', 'all-in-one-wp-security-and-firewall');?>: </strong><?php _e('This will attempt to set up the firewall in order to give you the highest level of protection it has to offer.', 'all-in-one-wp-security-and-firewall');?><p>

									<p class="description"><strong><?php _e('Downgrade firewall', 'all-in-one-wp-security-and-firewall');?>: </strong><?php _e('This will undo the changes performed by the set-up mechanism.', 'all-in-one-wp-security-and-firewall');?><p>

									<p class="description"><?php _e('The firewall will still be active if it is downgraded or not set up, but you will have reduced protection.', 'all-in-one-wp-security-and-firewall');?><p>
								</div>
							</td>  
					</tr>
				</table>
	   
				</div>
				
			</div>
