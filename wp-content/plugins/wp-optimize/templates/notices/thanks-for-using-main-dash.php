<?php if (!defined('WPO_PLUGIN_MAIN_PATH')) die('No direct access allowed'); ?>

<div id="wp-optimize-dashnotice" class="updated">

	<div style="float: right;"><a href="#" onclick="jQuery('#wp-optimize-dashnotice').slideUp(); jQuery.post(ajaxurl, {action: 'wp_optimize_ajax', subaction: 'dismiss_dash_notice_until', nonce: '<?php echo wp_create_nonce('wp-optimize-ajax-nonce'); ?>'});"><?php printf(__('Dismiss (for %s months)', 'wp-optimize'), 12); ?></a></div>

	<h3><?php _e('Thank you for installing WP-Optimize!', 'wp-optimize'); ?></h3>

	<a href="https://getwpo.com"><img style="border: 0px; float: right; width: 150px; margin-right: 40px;" alt="WP-Optimize" title="WP-Optimize" src="<?php echo WPO_PLUGIN_URL.'/images/logo/wpo_logo_small.png'; ?>"></a>

	<div id="wp-optimize-dashnotice-wrapper" style="max-width: 800px;">

		<p>
			<?php _e('Super-charge and secure your WordPress site even more with our other top plugins:', 'wp-optimize'); ?>
		</p>

		<p>
			<?php printf(__('%s offers powerful extra features and flexibility, and WordPress multisite support.', 'wp-optimize'), '<strong>'.$wp_optimize->wp_optimize_url('https://getwpo.com', __('WP-Optimize Premium:', 'wp-optimize'), '', 'target="_blank"', true).'</strong>'); ?>
		</p>

		<p>
			<?php printf(__('%s simplifies backups and restoration. It is the world\'s highest ranking and most popular scheduled backup plugin, with over three million currently-active installs.', 'wp-optimize'), '<strong>'.$wp_optimize->wp_optimize_url('https://wordpress.org/plugins/updraftplus/', 'UpdraftPlus', '', 'target="_blank"', true).'</strong>'); ?>
		</p>

		<p>
			<?php printf(__('%s is a highly efficient way to manage, optimize, update and backup multiple websites from one place.', 'wp-optimize'), '<strong>'.$wp_optimize->wp_optimize_url('https://updraftcentral.com', 'UpdraftCentral', '', 'target="_blank"', true).'</strong>'); ?>
		</p>

		<p>
			<?php echo '<strong>'.__('More quality plugins', 'wp-optimize').': </strong>'.$wp_optimize->wp_optimize_url('https://www.simbahosting.co.uk/s3/shop/', __('Premium WooCommerce plugins', 'wp-optimize'), '', 'target="_blank"', true); ?>
		</p>

	</div>
	<p>&nbsp;</p>
</div>
