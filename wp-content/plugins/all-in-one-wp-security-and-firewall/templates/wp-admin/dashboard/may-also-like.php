<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div class="aiowps_col aiowps_half_width aiowps_feature_cont">
	<header>
		<h3><?php echo esc_html__('All-In-One Security Free vs Premium Comparison Chart', 'all-in-one-wp-security-and-firewall'); ?></h3>
		<p>
			<a target="_blank" href="https://teamupdraft.com/documentation/all-in-one-security/faqs/?utm_source=aios_plugin&utm_medium=plugin&utm_content=premium_upgrade_tab&utm_term=faqs"><?php esc_html_e('FAQs', 'all-in-one-wp-security-and-firewall'); ?></a>
			|
			<a target="_blank" href="https://teamupdraft.com/contact/?utm_source=aios_plugin&utm_medium=plugin&utm_content=premium_upgrade_tab&utm_term=contact_us"><?php esc_html_e('Ask a pre-sales question', 'all-in-one-wp-security-and-firewall'); ?></a>
		</p>
	</header>
	<table class="aiowps_feat_table">
		<tbody>
		<tr>
			<td></td>
			<td>
			<?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- Hard coded image. ?>
				<img src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/aios_logo_wide.svg'; ?>" alt="<?php esc_attr_e('All-In-One Security Free', 'all-in-one-wp-security-and-firewall'); ?>" width="auto" height="80">
				<p class="aio_bold"><?php esc_html_e('Free', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
			<?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- Hard coded image. ?>
				<img src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/aios_logo_wide.svg'; ?>" alt="<?php esc_attr_e('All-In-One Security Premium', 'all-in-one-wp-security-and-firewall'); ?>" width="auto" height="80">
				<p class="aio_bold"><?php esc_html_e('Premium', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p><?php esc_html_e('Installed', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
			<a class="button button-primary" href="https://teamupdraft.com/all-in-one-security/pricing/?utm_source=aios_plugin&utm_medium=plugin&utm_content=premium_upgrade_tab&utm_term=upgrade_now" target="_blank"><?php esc_html_e('Upgrade', 'all-in-one-wp-security-and-firewall'); ?></a>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text">
				<h4><?php _e('Login security feature suite', 'all-in-one-wp-security-and-firewall'); ?></h4>
				<p><?php echo __('Upgrade your WordPress security and protect against brute-force attacks with login and user security features.', 'all-in-one-wp-security-and-firewall').' '.__('Limit login attempts, rename the login page to hide it from bots, add CAPTCHA and more.', 'all-in-one-wp-security-and-firewall'); ?></p>
				<br>
				<?php /* translators: %s: Features URL */ ?>
				<p><?php echo sprintf(esc_html__('%s', 'all-in-one-wp-security-and-firewall'), '<a href="https://teamupdraft.com/all-in-one-security/features/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=premium-upgrade-login-security-features&utm_creative_format=text" target="_blank">' . esc_html__('See all login security features', 'all-in-one-wp-security-and-firewall') . '.</a>'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text" colspan="3">
				<h4><?php esc_html_e('Two-factor authentication (TFA)', 'all-in-one-wp-security-and-firewall'); ?></h4>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Supports Google Authenticator, Microsoft Authenticator, Authy and more.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Configure TFA by user role.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Control how often TFA is required on trusted devices.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Adjust the TFA design to match your brand.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Generate one-time use emergency codes to regain access if you lose your TFA device.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('TFA works consistently in subsites of WordPress multisite networks.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Integrate TFA with third party login forms without additional coding.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p><?php esc_html_e('Installed', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<a class="button button-primary" href="https://teamupdraft.com/all-in-one-security/pricing/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=premium-upgrade-tab-upgrade-link-tfa&utm_creative_format=text" target="_blank"><?php esc_html_e('Upgrade', 'all-in-one-wp-security-and-firewall'); ?></a>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text">
				<h4><?php esc_html_e('Firewall', 'all-in-one-wp-security-and-firewall'); ?></h4>
				<p><?php echo esc_html__('Get PHP, .htaccess and 6G firewall rules.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Spot and block fake Google Bots and more!', 'all-in-one-wp-security-and-firewall'); ?></p>
				<br>
				<?php /* translators: %s: Features URL */ ?>
				<p><?php echo sprintf(esc_html__('%s', 'all-in-one-wp-security-and-firewall'), '<a href="https://teamupdraft.com/all-in-one-security/features/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=premium-upgrade-firewall-features&utm_creative_format=text" target="_blank">' . esc_html__('See all firewall features', 'all-in-one-wp-security-and-firewall') . '.</a>'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text">
				<h4><?php esc_html_e('File and database security', 'all-in-one-wp-security-and-firewall'); ?></h4>
				<p><?php echo esc_html__('Block access to files like readme.html to hide key information from hackers.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Hide your WordPress database, scan critical folders and files to spot and fix insecure file permissions and more.', 'all-in-one-wp-security-and-firewall'); ?></p>
				<br>
				<?php /* translators: %s: Features URL */ ?>
				<p><?php echo sprintf(esc_html__('%s', 'all-in-one-wp-security-and-firewall'), '<a href="https://teamupdraft.com/all-in-one-security/features/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=premium-upgrade-database-security-features&utm_creative_format=text" target="_blank">' . esc_html__('See all file and database security features', 'all-in-one-wp-security-and-firewall') . '.</a>'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text">
				<h4><?php esc_html_e('Spam prevention', 'all-in-one-wp-security-and-firewall'); ?></h4>
				<p><?php echo esc_html__('Prevent annoying spam comments and reduce unnecessary server load.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Automatically and permanently block IP addresses that exceed a set number of spam comments.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text" colspan="3">
				<h4><?php esc_html_e('Site Scanner', 'all-in-one-wp-security-and-firewall'); ?></h4>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php esc_html_e('Monitors and alerts you to file changes outside of normal operations.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php esc_html_e('Monitors and alerts you to infection by malware', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php esc_html_e('Monitors and alerts you to blacklisting by search engines.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Monitors and alerts you to downtime.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td class="aiowps-feature-text">
				<p><?php echo esc_html__('Monitors and alerts you to response time issues.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p><?php esc_html_e('Installed', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<a class="button button-primary" href="https://teamupdraft.com/all-in-one-security/pricing/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=premium-upgrade-tab-upgrade-link-site-scanner&utm_creative_format=text" target="_blank"><?php esc_html_e('Upgrade', 'all-in-one-wp-security-and-firewall'); ?></a>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text">
				<h4><?php esc_html_e('Smart 404 blocking', 'all-in-one-wp-security-and-firewall'); ?></h4>
				<p><?php echo esc_html__('Automatically block IP addresses based on how many 404 errors they generate.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Handy charts show how many 404s have occurred and where they’re coming from.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text">
				<h4><?php esc_html_e('Country blocking', 'all-in-one-wp-security-and-firewall'); ?></h4>
				<p><?php echo esc_html__('Most attacks come from a handful of countries.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Prevent most of them by blocking traffic based on country of origin to 99.5% accuracy.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr class="aiowps-main-feature-row">
			<td class="aiowps-feature-text">
				<h4><?php esc_html_e('Premium support', 'all-in-one-wp-security-and-firewall'); ?></h4>
				<p><?php echo esc_html__('We can do more to support you via our own support channels than is allowed in the WordPress forums.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('90% of tickets are responded to within 24 hours.', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'all-in-one-wp-security-and-firewall'); ?>"></span></p>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p><?php esc_html_e('Installed', 'all-in-one-wp-security-and-firewall'); ?></p>
			</td>
			<td>
				<a class="button button-primary" href="https://teamupdraft.com/all-in-one-security/pricing/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=premium-upgrade-tab-upgrade-link-premium-support&utm_creative_format=text" target="_blank"><?php esc_html_e('Upgrade', 'all-in-one-wp-security-and-firewall'); ?></a>
			</td>
		</tr>
		</tbody>
	</table>
</div>
<div class="aiowps_col  aiowps_half_width aiowps_plugin_family_cont aiowps-plugin-family__free">
	<header>
		<h3><?php esc_html_e('Our other plugins', 'all-in-one-wp-security-and-firewall'); ?></h3>
		<p>
			<a href="https://teamupdraft.com/updraftplus/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><?php echo 'UpdraftPlus'; ?></a>
			|
			<a href="https://teamupdraft.com/wp-optimize/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><?php echo 'WP-Optimize'; ?></a>
			|
			<a href="https://teamupdraft.com/updraftcentral/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=udc-cta-on-premium-updrade-tab&utm_creative_format=text"><?php echo 'UpdraftCentral'; ?></a>
			|
			<a href="https://easyupdatesmanager.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-eum&utm_campaign=ad"><?php echo 'Easy Updates Manager'; ?></a>
			|
			<a href="https://www.internallinkjuicer.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-ilj&utm_campaign=ad"><?php echo 'Internal Link Juicer'; ?></a>
			|
			<a href="https://wpovernight.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wp-overnight&utm_campaign=ad"><?php echo 'WP Overnight'; ?></a>
			|
			<a href="https://wpgetapi.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wpgetapi&utm_campaign=ad"><?php echo 'WPGetAPI'; ?></a>
		</p>
	</header>
	<div class="aiowps-plugin-family__plugins">
		<div class="aiowps-plugin-family__plugin">
			<a href="https://teamupdraft.com/updraftplus/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><img class="addons" alt="UpdraftPlus" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/updraftplus_logo.svg'; ?>"></a>
			<a class="other-plugin-title" href="https://teamupdraft.com/updraftplus/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><h3><?php esc_html_e('UpdraftPlus – the ultimate protection for your site, hard work and business', 'all-in-one-wp-security-and-firewall'); ?></h3></a>
			<p><?php echo esc_html__('Simplifies backups and restoration.', 'all-in-one-wp-security-and-firewall').' '.__('It is the world\'s highest ranking and most popular scheduled backup plugin, with over three million currently-active installs.', 'all-in-one-wp-security-and-firewall'); ?></p>
			<a href="https://teamupdraft.com/updraftplus/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><?php esc_html_e('Learn more about UpdraftPlus', 'all-in-one-wp-security-and-firewall'); ?></a>
		</div>
		<div class="aiowps-plugin-family__plugin">
			<a href="https://teamupdraft.com/wp-optimize/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><img class="addons" alt="WP-Optimize" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/wp-optimize.svg'; ?>"></a>
			<a class="other-plugin-title" href="https://teamupdraft.com/wp-optimize/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><h3><?php esc_html_e('WP-Optimize – keep your database fast and efficient', 'all-in-one-wp-security-and-firewall'); ?></h3></a>
			<p><?php echo esc_html__('Makes your site fast and efficient.', 'all-in-one-wp-security-and-firewall').' '.__('It cleans the database, compresses images and caches pages for ultimate speed.', 'all-in-one-wp-security-and-firewall'); ?></p>
			<a href="https://teamupdraft.com/wp-optimize/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=cta-on-premium-updrade-tab&utm_creative_format=text"><?php esc_html_e('Learn more about WP-Optimize', 'all-in-one-wp-security-and-firewall'); ?></a>
		</div>
		<div class="aiowps-plugin-family__plugin">
			<a href="https://teamupdraft.com/updraftcentral/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=udc-cta-on-premium-updrade-tab&utm_creative_format=text"><img class="addons" alt="UpdraftCentral" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/updraftcentral-logo.svg'; ?>"></a>
			<a class="other-plugin-title" href="https://teamupdraft.com/updraftcentral/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=udc-cta-on-premium-updrade-tab&utm_creative_format=text"><h3><?php esc_html_e('UpdraftCentral – save hours managing multiple WP sites from one place', 'all-in-one-wp-security-and-firewall'); ?></h3></a>
			<p><?php esc_html_e('Highly efficient way to manage, optimize, update and backup multiple websites from one place.', 'all-in-one-wp-security-and-firewall'); ?></p>
			<a href="https://teamupdraft.com/updraftcentral/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=udc-cta-on-premium-updrade-tab&utm_creative_format=text"><?php esc_html_e('Learn more about UpdraftCentral', 'all-in-one-wp-security-and-firewall'); ?></a>
		</div>
		<div class="aiowps-plugin-family__plugin">
			<a href="https://easyupdatesmanager.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-eum&utm_campaign=ad"><img class="addons" alt="Easy Updates Manager" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/easy-updates-manager-logo.svg'; ?>"></a>
			<a class="other-plugin-title" href="https://easyupdatesmanager.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-eum&utm_campaign=ad"><h3><?php esc_html_e('Easy Updates Manager - keep your WordPress site up to date and bug free', 'all-in-one-wp-security-and-firewall'); ?></h3></a>
			<p>
				<?php
					echo esc_html__("A light yet powerful plugin that allows you to manage all kinds of updates.", 'all-in-one-wp-security-and-firewall') . "&nbsp;" .
						esc_html__("With a huge number of settings for endless customization.", 'all-in-one-wp-security-and-firewall') . "&nbsp;" .
						esc_html__("Easy Updates Manager is an obvious choice for anyone wanting to take control of their website updates.", 'all-in-one-wp-security-and-firewall');
				?>
	
			</p>
			<a href="https://easyupdatesmanager.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-eum&utm_campaign=ad"><?php esc_html_e('Try for free', 'all-in-one-wp-security-and-firewall'); ?></a>
		</div>
		<div class="aiowps-plugin-family__plugin">
			<?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- Hard coded image. ?>
			<a href="https://www.internallinkjuicer.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-ilj&utm_campaign=ad"><img class="addons" alt="Internal Link Juicer" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/internal-link-juicer-logo-sm.svg'; ?>"></a>
			<a class="other-plugin-title" href="https://www.internallinkjuicer.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-ilj&utm_campaign=ad"><h3><?php esc_html_e('Internal Link Juicer - a five-star rated internal linking plugin for WordPress', 'all-in-one-wp-security-and-firewall'); ?></h3></a>
			
			<p>
				<?php
				echo esc_html__("This five-star rated plugin automates internal linking.", 'all-in-one-wp-security-and-firewall') . "&nbsp;" .
					esc_html__("It strategically places relevant links within your content.", 'all-in-one-wp-security-and-firewall');
				?>
			</p>
			<p>
				<?php esc_html_e("Improve your SEO with just a few clicks.", 'all-in-one-wp-security-and-firewall');?>
			</p>
			<a href="https://www.internallinkjuicer.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-ilj&utm_campaign=ad"><?php esc_html_e('Try for free', 'all-in-one-wp-security-and-firewall'); ?></a>
		</div>
		<div class="aiowps-plugin-family__plugin">
			<a href="https://wpovernight.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wp-overnight&utm_campaign=ad"><img class="addons" alt="WP Overnight" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/wp-overnight-sm.png'; ?>"></a>
			<a class="other-plugin-title" href="https://wpovernight.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wp-overnight&utm_campaign=ad"><h3><?php esc_html_e('WP Overnight - quality plugins for your WooCommerce store. 5 star rated invoicing, order and product management tools', 'all-in-one-wp-security-and-firewall'); ?></h3></a>
			<p>
				<?php
					echo esc_html__("WP Overnight is an independent plugin shop with a range of WooCommerce plugins.", 'all-in-one-wp-security-and-firewall') . "&nbsp;" .
						esc_html__("Our range of plugins have over 7,500,000 downloads and thousands of loyal customers.", 'all-in-one-wp-security-and-firewall');
				?>
			</p>
			<p>
				<?php esc_html_e("Create PDF invoices, automations, barcodes, reports and so much more.", 'all-in-one-wp-security-and-firewall');?>
				<?php esc_html_e("Create PDF invoices, automations, barcodes, reports and so much more.", 'all-in-one-wp-security-and-firewall');?>
			</p>
			<a href="https://wpovernight.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wp-overnight&utm_campaign=ad"><?php esc_html_e('Try for free', 'all-in-one-wp-security-and-firewall'); ?></a>
		</div>
		<div class="aiowps-plugin-family__plugin">
			<a href="https://wpgetapi.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wpgetapi&utm_campaign=ad"><img class="addons" alt="WP Get API" src="<?php echo AIO_WP_SECURITY_URL.'/images/plugin-logos/wpgetapi-sm.png'; ?>"></a>
			<a class="other-plugin-title" href="https://wpgetapi.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wpgetapi&utm_campaign=ad"><h3><?php esc_html_e('WPGetAPI - connect WordPress to APIs without a developer', 'all-in-one-wp-security-and-firewall'); ?></h3></a>
			
			<p>
				<?php
					echo esc_html__("The easiest way to connect your WordPress website to an external API.", 'all-in-one-wp-security-and-firewall') . "&nbsp;" .
						esc_html__("WPGetAPI is free, powerful and easy to use.", 'all-in-one-wp-security-and-firewall') . "&nbsp;" .
						esc_html__("Connect to virtually any REST API and retrieve data without writing a line of code.", 'all-in-one-wp-security-and-firewall');
				?>
			</p>
			<a href="https://wpgetapi.com/?utm_medium=software&utm_source=aios&utm_content=aios-mayalso-like-tab&utm_term=try-now-wpgetapi&utm_campaign=ad"><?php esc_html_e('Try for free', 'all-in-one-wp-security-and-firewall'); ?></a>
		</div>
	</div><!-- END aiowps-plugin-family__plugins -->
</div>
<div class="clear"></div>