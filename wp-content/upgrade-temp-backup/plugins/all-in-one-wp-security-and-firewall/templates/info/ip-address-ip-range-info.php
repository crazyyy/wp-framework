<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>
<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
	<div class="aiowps_more_info_body">
	<?php
		echo '<p class="description">' . esc_html__('Each IP address must be on a new line.', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__("You can add comments to the IP entries by placing a '#' at the start of a line.", 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('This can be useful for annotating each IP address with notes (e.g., identifying the individual or system associated with the IP).', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('To specify an IPv4 range use a wildcard "*" character, acceptable ways to use wildcards is shown in the examples below:', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('Example 1: 195.47.89.*', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('Example 2: 195.47.*.*', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('Example 3: 195.*.*.*', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('To specify an IPv6 range use CIDR format as shown in the examples below:', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('Example 4: 2401:4900:54c3:af15:2:2:5dc0:0/112', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '<p class="description">' . esc_html__('Example 5: 2001:db8:1263::/48', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>