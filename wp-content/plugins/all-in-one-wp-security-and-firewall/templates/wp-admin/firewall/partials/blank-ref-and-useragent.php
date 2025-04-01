<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox">
<h3 class="hndle"><label for="title"><?php esc_html_e('Blank HTTP headers', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
<div class="inside">
	<div id="firewall-ban-post-blank-headers-badge">
		<?php
		// Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("firewall-ban-post-blank-headers");
		?>
	</div>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php esc_html_e('Ban POST requests that have a blank user-agent and referer', 'all-in-one-wp-security-and-firewall'); ?>:</th>
		<td>
			<div class="aiowps_switch_container">
				<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to ban POST requests that have a blank user-agent and referer.', 'all-in-one-wp-security-and-firewall'), 'aiowps_ban_post_blank_headers', $aiowps_firewall_config->get_value('aiowps_ban_post_blank_headers')); ?>
				<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
				<div class="aiowps_more_info_body">
						<?php
						echo '<p class="description">'.esc_html__('This feature will check whether the user-agent and referer HTTP headers are blank.', 'all-in-one-wp-security-and-firewall').'</p>';
						echo '<p class="description">'.esc_html__('If they are both blank, the IP address associated with the request will be added to your permanent block list.', 'all-in-one-wp-security-and-firewall').'</p>';
						?>
				</div>
			</div>
		</td>
	</tr>
</table>
</div></div>