<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<?php

			//show a warning message if xmlrpc has been completely disabled
			if ($aio_wp_security->configs->get_value('aiowps_enable_pingback_firewall') == '1') {
			?>
		<div class="aio_orange_box">
			<p>
			<?php
			echo '<p>'.__('Attention:', 'all-in-one-wp-security-and-firewall').' '.__('You have enabled the "Completely Block Access To XMLRPC" checkbox which means all XMLRPC functionality will be blocked.', 'all-in-one-wp-security-and-firewall').'</p>';
			echo '<p>'.__('By leaving this feature enabled you will prevent Jetpack or Wordpress iOS or other apps which need XMLRPC from working correctly on your site.', 'all-in-one-wp-security-and-firewall').'</p>';
			echo '<p>'.__('If you still need XMLRPC then uncheck the "Completely Block Access To XMLRPC" checkbox and enable only the "Disable Pingback Functionality From XMLRPC" checkbox.', 'all-in-one-wp-security-and-firewall').'</p>';
			?>
			</p>
		</div>
			<?php
			}
