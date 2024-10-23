<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('.htaccess firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" id="aios-htaccess-firewall-settings-form">
	<?php
	$aio_wp_security->include_template('wp-admin/firewall/partials/basic-firewall-settings.php');
	$aio_wp_security->include_template('wp-admin/firewall/partials/block-debug-log.php');
	$aio_wp_security->include_template('wp-admin/firewall/partials/listing-directory-contents.php');
	$aio_wp_security->include_template('wp-admin/firewall/partials/disable-trace.php');
	?>

	<input type="submit" name="aiowps_apply_htaccess_firewall_settings" value="<?php _e('Save .htaccess firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>