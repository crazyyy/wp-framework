<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div id="aios-firewall-setup-notice" class="notice notice-information">

	<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
		<?php wp_nonce_field('aiowpsec-firewall-setup'); ?>
		<input type="hidden" name="action" value="aiowps_firewall_setup">
		<p>
			<strong><?php _e('All In One WP Security and Firewall', 'all-in-one-wp-security-and-firewall'); ?></strong>
		</p>
		<p>
			<?php echo __('Our PHP-based firewall has been created to give you even greater protection.', 'all-in-one-wp-security-and-firewall').' '.
				__('To ensure the PHP-based firewall runs before any potentially vulnerable code in your WordPress site can be reached, it will need to be set up.', 'all-in-one-wp-security-and-firewall');
			?>
		</p>
		<p>
			<?php _e('If you already have our .htaccess-based firewall enabled, you will still need to set up the PHP-based firewall to benefit from its protection.', 'all-in-one-wp-security-and-firewall'); ?>
		</p>
		<p>
			<?php _e('To set up the PHP-based firewall, press the \'Set up now\' button below:', 'all-in-one-wp-security-and-firewall'); ?>
		</p>
		<div style='padding-bottom: 10px; padding-top:10px;'>
			<input class="button button-primary" type="submit" name="btn_setup_now" value="<?php _e('Set up now', 'all-in-one-wp-security-and-firewall'); ?>">
	</form>
	<?php if ($show_dismiss) { ?>
		<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" style='display:inline;'>
			<?php wp_nonce_field('aiowpsec-firewall-setup-dismiss'); ?>
			<input type="hidden" name="action" value="aiowps_firewall_setup_dismiss">
			<input class="button button-secondary" type="submit" name="btn_dismiss_setup_now" value="<?php _e('Dismiss', 'all-in-one-wp-security-and-firewall'); ?>">
		</form>
	<?php } ?>
</div>
</div>