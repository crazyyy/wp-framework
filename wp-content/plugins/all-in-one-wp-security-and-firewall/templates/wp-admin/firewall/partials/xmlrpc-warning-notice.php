<?php if (!defined('ABSPATH')) die('Access denied.'); ?>

<div class="xmlrpc_warning_box aio_orange_box <?php if (!$aiowps_firewall_config->get_value('aiowps_enable_pingback_firewall')) echo ' aio_hidden';?>">
	<p>
		<?php
		echo '<p>'.esc_html__('Attention:', 'all-in-one-wp-security-and-firewall').' '.esc_html__('You have enabled the "Completely Block Access To XMLRPC" checkbox which means all XMLRPC functionality will be blocked.', 'all-in-one-wp-security-and-firewall').'</p>';
		echo '<p>'.esc_html__('By leaving this feature enabled you will prevent Jetpack or Wordpress iOS or other apps which need XMLRPC from working correctly on your site.', 'all-in-one-wp-security-and-firewall').'</p>';
		echo '<p>'.esc_html__('If you still need XMLRPC then uncheck the "Completely Block Access To XMLRPC" checkbox and enable only the "Disable Pingback Functionality From XMLRPC" checkbox.', 'all-in-one-wp-security-and-firewall').'</p>';
		?>
	</p>
</div>