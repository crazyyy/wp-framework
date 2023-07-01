<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div id="aiowps-dashnotice" class="updated">
	<div style="float: right;"><a href="#" onclick="jQuery('#aiowps-dashnotice').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo wp_create_nonce('wp-security-ajax-nonce'); ?>', data: { notice: 'dismissdashnotice'}});"><?php printf(__('Dismiss (for %s months)', 'all-in-one-wp-security-and-firewall'), 12); ?></a></div>
	<h3><?php printf(htmlspecialchars(__('Thank you for using %s!', 'all-in-one-wp-security-and-firewall')), 'All-In-One Security (AIOS)'); ?></h3>

	<a href="https://aiosplugin.com/"><img style="border: 0px; float: right; width: 250px; margin-right: 40px; margin-top: 40px;" alt="All-In-One Security (AIOS)" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/aios_logo_wide.png'; ?>"></a>

	<div id="aiowps-dashnotice_wrapper" style="max-width: 800px;">

		<p>
			<?php _e('Super-charge and secure your WordPress site even more with our other top plugins:', 'all-in-one-wp-security-and-firewall'); ?>
		</p>

		<p>
			<?php printf(__('%s makes your site fast and efficient. It cleans the database, compresses images and caches pages for ultimate speed.', 'all-in-one-wp-security-and-firewall'), '<strong><a href="https://getwpo.com" target="_blank">WP-Optimize</a></strong>'); ?>
		</p>

		<p>
			<?php printf(__('%s simplifies backups and restoration. It is the world\'s highest ranking and most popular scheduled backup plugin, with over three million currently-active installs.', 'all-in-one-wp-security-and-firewall'), '<strong><a href="https://wordpress.org/plugins/updraftplus/" target="_blank">UpdraftPlus</a></strong>'); ?>
		</p>

		<p>
			<?php printf(__('%s is a highly efficient way to manage, optimize, update and backup multiple websites from one place.', 'all-in-one-wp-security-and-firewall'), '<strong><a href="https://updraftplus.com/updraftcentral/" target="_blank">UpdraftCentral</a></strong>'); ?>
		</p>

		<p>
			<?php printf(__('%s is a WordPress subscription extension for WooCommerce store owners.', 'all-in-one-wp-security-and-firewall'), '<strong><a href="https://subscribenplugin.com" target="_blank">Subscriben</a></strong>'); ?>
		</p>

		<p>
			<?php echo '<strong>'.__('More quality plugins', 'all-in-one-wp-security-and-firewall').': </strong>'.'<a href="https://www.simbahosting.co.uk/s3/shop/" target="_blank">'.__('Premium WooCommerce plugins', 'all-in-one-wp-security-and-firewall').'</a>'; ?>
		</p>
	</div>
	<p>&nbsp;</p>
</div>
