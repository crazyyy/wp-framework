<?php
if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed');

if (!AIOWPSecurity_Utility::is_apache_server()) {
	?>
	<div class="aio_red_box">
		<p>
			<?php
			echo '<strong>' . esc_html__('Attention:', 'all-in-one-wp-security-and-firewall') . '</strong> ' . esc_html__('This feature works only on the Apache server.', 'all-in-one-wp-security-and-firewall') . ' ';
			/* translators: %s: Server software */
			echo sprintf(esc_html__("You are using the non-apache server %s, so this feature won't work on your site.", 'all-in-one-wp-security-and-firewall'), esc_html(AIOWPSecurity_Utility::get_server_software()));
			?>
		</p>
	</div>
	<?php
}