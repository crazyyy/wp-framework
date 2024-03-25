<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('PHP firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" method="POST">
	<?php
	wp_nonce_field('aiowpsec-php-firewall-nonce');

	$aio_wp_security->include_template('wp-admin/firewall/partials/xmlrpc-warning-notice.php');

	$aio_wp_security->include_template('wp-admin/firewall/partials/xmlrpc-pingback-protection.php');
	$aio_wp_security->include_template('wp-admin/firewall/partials/disable-rss-atom.php');
	$aio_wp_security->include_template('wp-admin/firewall/partials/proxy-comment.php');
	$aio_wp_security->include_template('wp-admin/firewall/partials/bad-query-strings.php');
	$aio_wp_security->include_template('wp-admin/firewall/partials/advanced-character-filter.php');
	?>

	<input type="submit" name="aiowps_apply_php_firewall_settings" value="<?php _e('Save PHP firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>
