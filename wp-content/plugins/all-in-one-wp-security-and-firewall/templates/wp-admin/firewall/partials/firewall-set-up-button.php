<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST"  style="display: inline;">
	<?php wp_nonce_field('aiowpsec-firewall-setup'); ?>
	<input type="hidden" name="action" value="aiowps_firewall_setup">
	<input class="button button-primary" type="submit" name="btn_try_again" value="<?php _e('Set up firewall', 'all-in-one-wp-security-and-firewall'); ?>">
</form>
