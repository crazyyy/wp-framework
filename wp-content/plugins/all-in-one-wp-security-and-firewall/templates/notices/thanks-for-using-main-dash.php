<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div id="aiowps-dashnotice" class="updated">
	<?php /* translators: %s: Number of months */ ?>
	<div style="float: right;"><a href="#" onclick="jQuery('#aiowps-dashnotice').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: 'dismissdashnotice'}});"><?php printf(esc_html__('Dismiss (for %s months)', 'all-in-one-wp-security-and-firewall'), 12); ?></a></div>
	<h3>
		<?php
		if (AIOWPSecurity_Utility_Permissions::is_premium_installed()) {
			esc_html_e('Thank you for using All-In-One Security Premium!', 'all-in-one-wp-security-and-firewall');
		} else {
			esc_html_e('Thank you for using All-In-One Security!', 'all-in-one-wp-security-and-firewall');
		}
		?>
	</h3>

	<?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- Image does not have an attachment number. Cannot use image attachment API. ?>
	<a href="https://teamupdraft.com/all-in-one-security/"><img id="aiowps-notice-logo" alt="All-In-One Security" src="<?php echo esc_url(AIO_WP_SECURITY_URL) . '/images/plugin-logos/aios_logo_wide.svg'; ?>"></a>

	<div id="aiowps-dashnotice_wrapper" style="max-width: 800px;">
		<p>
			<?php
			esc_html_e('Protect your investment with the ultimate in WordPress website security.', 'all-in-one-wp-security-and-firewall');
			echo '&nbsp;';
			if (!AIOWPSecurity_Utility_Permissions::is_premium_installed()) {
				printf(
					/* translators: %s 'AIOS Premium' URL */
					esc_html__('Get malware scanning, country blocking, premium support and more advanced security features with %s.', 'all-in-one-wp-security-and-firewall'),
					'<a href="https://teamupdraft.com/all-in-one-security/pricing/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=aios-premium&utm_creative_format=advert" target="_blank">' . esc_html__('AIOS Premium', 'all-in-one-wp-security-and-firewall') . '</a>'
				);
			}
			?>
		</p>
		<p><?php esc_html_e('Explore more top-rated plugins', 'all-in-one-wp-security-and-firewall'); ?> :</p>
		<ul>
			<li>
				<a href="https://teamupdraft.com/wp-optimize/pricing/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=wp-optimize-premium&utm_creative_format=advert" target="_blank">
					<strong><?php esc_html_e('WP-Optimize Premium:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
				esc_html_e('Unlock new ways to speed up your WordPress website.', 'all-in-one-wp-security-and-firewall');
				echo '&nbsp;';
				esc_html_e('Optimize from the WP-CLI, cache multilingual and multi currency websites and more.', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
			<li>
				<a href="https://teamupdraft.com/updraftplus/pricing/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=updraftplus-premium&utm_creative_format=advert" target="_blank">
					<strong><?php esc_html_e('UpdraftPlus Premium:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
					esc_html_e('Schedule automatic backups, run backups before updates, and restore with ease.', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
			<li>
				<a href="https://burst-statistics.com/pricing/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=burst-statistics&utm_creative_format=advert" target="_blank">
					<strong><?php esc_html_e('Burst Statistics:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
					esc_html_e('Privacy-friendly analytics that lets you track traffic without collecting personal data.', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
			<li>
				<a href="https://www.internallinkjuicer.com/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=internal-link-juicer&utm_creative_format=advert" target="_blank">
					<strong><?php esc_html_e('Internal Link Juicer:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
				esc_html_e('Automatically build internal links to save time and boost SEO.', 'all-in-one-wp-security-and-firewall');
				echo '&nbsp;';
				esc_html_e('You don’t have to be an SEO expert to use this plugin!', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
			<li>
				<a href="https://wpovernight.com/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=wp-overnight&utm_creative_format=advert" target="_blank">
					<strong><?php esc_html_e('WP Overnight:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
				esc_html_e('Premium WooCommerce add-ons built to optimize your store, improve UX, and increase revenue.', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
		</ul>
		<p>
			<?php echo '<strong>' . esc_html__('Browse more', 'all-in-one-wp-security-and-firewall') . ' </strong>' . '<a href="https://www.simbahosting.co.uk/s3/shop/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=premium-woocommerce-plugins&utm_creative_format=advert" target="_blank">' . esc_html__('Premium WooCommerce plugins', 'all-in-one-wp-security-and-firewall') . '</a>'; ?>
		</p>
	</div>
</div>