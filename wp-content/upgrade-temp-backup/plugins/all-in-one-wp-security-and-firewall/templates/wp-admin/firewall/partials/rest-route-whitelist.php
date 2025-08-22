<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="aio_yellow_box">
	<p><?php echo sprintf(esc_html__('%s this REST route allows websites to display core content, such as posts, pages, and other WordPress data.', 'all-in-one-wp-security-and-firewall'), '<strong>wp:</strong>') . ' ' . esc_html__('This route is essential for the WordPress block editor and API integrations.', 'all-in-one-wp-security-and-firewall') . ' ' .esc_html__('Disabling it may break plugins and themes.', 'all-in-one-wp-security-and-firewall');?></p>
	<p><?php echo sprintf(esc_html__('%s this REST route enables embedding content from your site on external platforms (e.g., Twitter, Facebook, and WordPress embeds).', 'all-in-one-wp-security-and-firewall'), '<strong>oembed:</strong>') . ' ' .  esc_html__('Disabling this may prevent your site\'s content from being embedded in social media and other platforms.', 'all-in-one-wp-security-and-firewall');?></p>
</div>
<br>
<table class="form-table">
	<?php if (!empty($route_namespaces)) { ?>
	<tr valign="top">
		<th scope="row"><?php _e('Whitelist REST routes', 'all-in-one-wp-security-and-firewall'); ?>:</th>
		<td>
			<?php foreach ($route_namespaces as $route_namespace) { ?>
			<div class="aiowps_switch_container">
			<?php AIOWPSecurity_Utility_UI::setting_checkbox($route_namespace, 'aios_whitelisted_rest_routes_'.str_replace('-', '_', $route_namespace), in_array($route_namespace, $aio_wp_security->configs->get_value('aios_whitelisted_rest_routes'))); ?>
			</div>
			<br>
			<?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>
