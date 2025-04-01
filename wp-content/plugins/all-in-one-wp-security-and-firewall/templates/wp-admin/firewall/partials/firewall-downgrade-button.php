<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<form method="POST" style="display: inline;" id="aiowps-firewall-downgrade-form">
	<input type="hidden" name="action" value="aiowps_firewall_downgrade">
	<input class="button button-primary" type="submit" name="btn_downgrade_protection" value="<?php esc_html_e('Downgrade firewall', 'all-in-one-wp-security-and-firewall'); ?>">
</form>
