<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<form method="POST"  style="display: inline;" id="aiowpsec-firewall-setup-form">
	<input type="hidden" name="action" value="aiowps_firewall_setup">
	<input class="button button-primary" type="submit" name="btn_try_again" value="<?php esc_html_e('Set up firewall', 'all-in-one-wp-security-and-firewall'); ?>">
</form>
