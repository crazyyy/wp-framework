<?php if (!defined('WPO_PLUGIN_MAIN_PATH')) die('No direct access allowed'); ?>

<div id="wp-optimize-dashnotice" class="updated">

	<div style="float: right;">
		<a href="#" onclick="jQuery('#wp-optimize-dashnotice').slideUp(); jQuery.post(ajaxurl, {action: 'wp_optimize_ajax', subaction: 'dismiss_dash_notice_until', nonce: '<?php echo esc_js(wp_create_nonce('wp-optimize-ajax-nonce')); ?>'});">
			<?php
				// translators: %s is number of months
				printf(esc_html__('Dismiss (for %s months)', 'wp-optimize'), 12);
			?>
		</a>
	</div>
	
<?php if ($is_premium) : ?>
	<h3><?php esc_html_e('Thank you for installing WP-Optimize Premium.', 'wp-optimize'); ?></h3>	
<?php else : ?>
	<h3><?php esc_html_e('Thank you for installing WP-Optimize.', 'wp-optimize'); ?></h3>
<?php endif; ?>

	<a href="https://getwpo.com" target="_blank"><img style="border: 0px; float: right; width: 150px; margin-right: 40px;" alt="WP-Optimize" title="WP-Optimize" src="<?php echo esc_url(WPO_PLUGIN_URL.'images/logo/wpo_logo_small.png'); // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- N/A ?>"></a>

	<div id="wp-optimize-dashnotice-wrapper" style="max-width: 800px;">
	
	<?php if ($is_premium) : ?>
		<p>
			<?php
				$message = '<strong>' . esc_html__('If you like WP-Optimize, you\'ll love our other plugins.', 'wp-optimize') . '</strong>';
				$message .= ' ';
				$message .= esc_html__('All 5* rated and actively installed on millions of WordPress websites:', 'wp-optimize');
				echo $message; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
			?>
		</p>
		
	<?php else : ?>
		<p>
			<?php
				esc_html_e('To really turbo boost the performance of your WordPress website, check out WP-Optimize Premium or get more 5* rated plugins below:', 'wp-optimize');
			?>
		</p>
		
		<p>
			<?php
				$message = $wp_optimize->wp_optimize_url('https://getwpo.com/buy/', '', '<strong>WP-Optimize Premium:</strong>', '', true);
				$message .= ' ';
				$message .= esc_html__('Unlock new ways to speed up your WordPress website.', 'wp-optimize');
				$message .= ' ';
				$message .= sprintf(
					// translators: %s is a link
					esc_html__('Optimize from the WP-CLI, cache multilingual and multicurrency websites, get premium support and %s.', 'wp-optimize'),
					sprintf(
						'<a href="%s" target="_blank">%s</a>',
						esc_url('https://getwpo.com/buy/'),
						esc_html__('more', 'wp-optimize')
					)
				);
				echo $message; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
			?>
		</p>
	<?php endif; ?>
	
		<p>
			<?php
				$message = $wp_optimize->wp_optimize_url('https://updraftplus.com/comparison-updraftplus-free-updraftplus-premium/', '', '<strong>UpdraftPlus:</strong>', '', true);
				$message .= ' ';
				$message .= esc_html__('Backup your website with the world\'s leading backup and migration plugin.', 'wp-optimize');
				$message .= ' ';
				$message .= esc_html__('Actively installed on more than 3 million WordPress websites', 'wp-optimize');
				echo $message;  // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
				?>
		</p>

		<p>
		<?php
			$message = $wp_optimize->wp_optimize_url('https://aiosplugin.com/', '', '<strong>All-In-One Security (AIOS):</strong>', '', true);
			$message .= ' ';
			$message .= esc_html__('Still on the fence? Secure your WordPress website with AIOS.', 'wp-optimize');
			$message .= ' ';
			$message .= esc_html__('Comprehensive, cost-effective, 5* rated and easy to use.', 'wp-optimize');
			echo $message; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
		?>
		</p>
		
		<p>
		<?php
			$message = $wp_optimize->wp_optimize_url('https://www.internallinkjuicer.com/', '', '<strong>Internal Link Juicer:</strong>', '', true);
			$message .= ' ';
			$message .= esc_html__('Automate the building of internal links on your WordPress website.', 'wp-optimize');
			$message .= ' ';
			$message .= esc_html__('Save time and boost SEO.', 'wp-optimize');
			$message .= ' ';
			$message .= esc_html__('You don\'t need to be an SEO expert to use this plugin.', 'wp-optimize');
			echo $message; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
		?>
		</p>
		
		<p>
		<?php
			$message = $wp_optimize->wp_optimize_url('https://wpovernight.com/', '', '<strong>WP Overnight:</strong>', '', true);
			$message .= ' ';
			$message .= esc_html__('Quality add-ons for WooCommerce.', 'wp-optimize');
			$message .= ' ';
			$message .= esc_html__('Designed to optimize your store, enhance user experience and increase revenue.', 'wp-optimize');
			echo $message; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
		?>
		</p>
		<p>
			<strong><?php esc_html_e('More quality plugins', 'wp-optimize'); ?>: </strong>
			<?php
				$wp_optimize->wp_optimize_url('https://www.simbahosting.co.uk/s3/shop/', esc_html__('Premium WooCommerce plugins', 'wp-optimize'), '', '', false);
			?>
		</p>
		<p>&nbsp;</p>
	</div>
</div>
