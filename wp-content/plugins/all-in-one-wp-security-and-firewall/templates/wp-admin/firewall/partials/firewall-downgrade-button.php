<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" style="display: inline;">
	<?php wp_nonce_field('aiowpsec-firewall-downgrade'); ?>
	<input type="hidden" name="action" value="aiowps_firewall_downgrade">
	<input class="button button-primary" type="submit" name="btn_downgrade_protection" value="<?php _e('Downgrade firewall', 'all-in-one-wp-security-and-firewall'); ?>">
</form>
