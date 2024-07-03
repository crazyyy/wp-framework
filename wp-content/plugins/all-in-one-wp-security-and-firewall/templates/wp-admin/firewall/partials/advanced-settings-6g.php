<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h3><?php _e('Block request methods', 'all-in-one-wp-security-and-firewall'); ?></h3>
<span data-tooltip="<?php echo esc_attr__('HTTP request methods are used by browsers and clients to communicate with servers to get responses.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_attr__('The below request methods are not necessary for every site to function and you may disable all HTTP request methods that are not essential for your site to function.', 'all-in-one-wp-security-and-firewall'); ?>">
	<span class="dashicons dashicons-editor-help"></span>
</span>
<div class="options">
	<table class="form-table">
		<?php foreach ($block_request_methods as $block_request_method) {?>
			<tr>
				<th><?php printf(__('Block %s method', 'all-in-one-wp-security-and-firewall'), strtoupper($block_request_method));?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Check this to block the %s request method', 'all-in-one-wp-security-and-firewall'), strtoupper($block_request_method)), "aiowps_block_request_method_{$block_request_method}", in_array(strtoupper($block_request_method), $methods)); ?>
						<?php if ('put' == $block_request_method) {?>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
								echo '<p class="description">' . __('Some WooCommerce extensions use the PUT request method in addition to GET and POST.', 'all-in-one-wp-security-and-firewall') . ' ' . __("This means WooCommerce users shouldn't block the PUT request method.", 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . __('A few REST requests use the PUT request method.', 'all-in-one-wp-security-and-firewall') . ' ' . __('If your site is communicated by the WP REST API, you should not block the PUT request method.', 'all-in-one-wp-security-and-firewall') . '</p>';
							?>
						</div>
					</div>
						<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</table>
</div>
<h3><?php _e('Other settings', 'all-in-one-wp-security-and-firewall'); ?></h3>
<span data-tooltip="<?php esc_attr_e('The 6G firewall provides other settings for blocking malicious query strings, request strings, referers and user-agents; you can configure their settings below.', 'all-in-one-wp-security-and-firewall'); ?>">
	<span class="dashicons dashicons-editor-help"></span>
</span>
<div class="options">
	<table class="form-table">
		<tr>
			<th><?php _e('Block query strings', 'all-in-one-wp-security-and-firewall');?>:</th>
			<td>
				<div class="aiowps_switch_container">
					<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to block all query strings recommended by 6G', 'all-in-one-wp-security-and-firewall'), 'aiowps_block_query', $blocked_query); ?>
				</div>
			</td>
		</tr>
		<tr>
			<th><?php _e('Block request strings', 'all-in-one-wp-security-and-firewall');?>:</th>
			<td>
				<div class="aiowps_switch_container">
					<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to block all request strings recommended by 6G', 'all-in-one-wp-security-and-firewall'), 'aiowps_block_request', $blocked_request); ?>
				</div>
			</td>
		</tr>
		<tr>
			<th><?php _e('Block referers', 'all-in-one-wp-security-and-firewall');?>:</th>
			<td>
				<div class="aiowps_switch_container">
					<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to block all referers recommended by 6G', 'all-in-one-wp-security-and-firewall'), 'aiowps_block_refs', $blocked_referrers); ?>
				</div>
			</td>
		</tr>
		<tr>
			<th><?php _e('Block user-agents', 'all-in-one-wp-security-and-firewall');?>:</th>
			<td>
				<div class="aiowps_switch_container">
					<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to block all user-agents recommended by 6G', 'all-in-one-wp-security-and-firewall'), 'aiowps_block_agents', $blocked_agents); ?>
				</div>
			</td>
		</tr>
	</table>
</div>
