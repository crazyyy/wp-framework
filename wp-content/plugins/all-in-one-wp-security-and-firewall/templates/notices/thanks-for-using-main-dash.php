<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div id="aiowps-dashnotice" class="updated">
	<div style="float: right;"><a href="#" onclick="jQuery('#aiowps-dashnotice').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo wp_create_nonce('wp-security-ajax-nonce'); ?>', data: { notice: 'dismissdashnotice'}});"><?php printf(__('Dismiss (for %s months)', 'all-in-one-wp-security-and-firewall'), 12); ?></a></div>
	<h3>
		<?php
		if (AIOWPSecurity_Utility_Permissions::is_premium_installed()) {
			esc_html_e('Thank you for using All-In-One Security (AIOS) Premium!', 'all-in-one-wp-security-and-firewall');
		} else {
			esc_html_e('Thank you for using All-In-One Security (AIOS)!', 'all-in-one-wp-security-and-firewall');
		}
		?>
	</h3>

	<a href="https://aiosplugin.com/"><img id="aiowps-notice-logo" alt="All-In-One Security (AIOS)" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/aios_logo_wide.png'; ?>"></a>

	<div id="aiowps-dashnotice_wrapper" style="max-width: 800px;">
		<p>
			<?php
				esc_html_e('Protect your investment with the ultimate in WordPress website security, AIOS Premium or get more rated plugins below:', 'all-in-one-wp-security-and-firewall');
			?>
		</p>
		<ul>
			<?php if (!AIOWPSecurity_Utility_Permissions::is_premium_installed()) : ?>
			<li>
				<a href="https://aiosplugin.com/?utm_medium=software&utm_source=aios&utm_content=aios-introduction-notice&utm_term=try-now-aios&utm_campaign=ad" target="_blank">
					<strong><?php esc_html_e('All-In-One Security (AIOS):', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
				printf(
					__('Get malware scanning, country blocking, premium support and %s.', 'all-in-one-wp-security-and-firewall'),
					'<a href="https://aiosplugin.com/features/" target="_blank">' . esc_html__('more', 'all-in-one-wp-security-and-firewall') . '</a>'
				);
				?>
			</li>
			<?php endif;?>
			<li>
				<a href="https://getwpo.com/buy/?utm_medium=software&utm_source=aios&utm_content=aios-introduction-notice&utm_term=try-now-wpo&utm_campaign=ad" target="_blank">
					<strong><?php esc_html_e('WP-Optimize Premium:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
				esc_html_e('Unlock new ways to speed up your WordPress website.', 'all-in-one-wp-security-and-firewall');
				echo '&nbsp;';
				esc_html_e('Optimize from the WP-CLI, cache multilingual and multicurrency websites, get premium support and more.', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
			<li>
				<a href="https://updraftplus.com/?utm_medium=software&utm_source=aios&utm_content=aios-introduction-notice&utm_term=try-now-udp&utm_campaign=ad" target="_blank">
					<strong><?php esc_html_e('UpdraftPlus:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
					esc_html_e('Back up your website with the world’s leading backup and migration plugin.', 'all-in-one-wp-security-and-firewall');
					echo '&nbsp;';
					esc_html_e('Actively installed on more than 3 million WordPress websites!', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
			<li>
				<a href="https://www.internallinkjuicer.com/?utm_medium=software&utm_source=aios&utm_content=ilj-mayalso-like-tab&utm_term=try-now-ilj&utm_campaign=ad" target="_blank">
					<strong><?php esc_html_e('Internal Link Juicer:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
				esc_html_e('Automate the building of internal links on your WordPress website.', 'all-in-one-wp-security-and-firewall');
				echo '&nbsp;';
				esc_html_e('Save time and boost SEO! You don’t need to be an SEO expert to use this plugin.', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
			<li>
				<a href="https://wpovernight.com/?utm_medium=software&utm_source=aios&utm_content=aios-introduction-notice&utm_term=try-now-wp-overnight&utm_campaign=ad" target="_blank">
					<strong><?php esc_html_e('WP Overnight:', 'all-in-one-wp-security-and-firewall'); ?></strong>
				</a>
				<?php
					esc_html_e('Quality add-ons for WooCommerce.', 'all-in-one-wp-security-and-firewall');
					echo '&nbsp;';
					esc_html_e('Designed to optimize your store, enhance user experience and increase revenue!', 'all-in-one-wp-security-and-firewall');
				?>
			</li>
		</ul>
		<p>
			<?php echo '<strong>'.__('More quality plugins', 'all-in-one-wp-security-and-firewall').': </strong>'.'<a href="https://www.simbahosting.co.uk/s3/shop/" target="_blank">'.__('Premium WooCommerce plugins', 'all-in-one-wp-security-and-firewall').'</a>'; ?>
		</p>
	</div>
	<p>&nbsp;</p>
</div>