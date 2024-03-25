<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div class="wpo_col wpo_half_width wpo_feature_cont">
	<header>
		<h2><?php esc_html_e("WP-Optimize free / premium comparison", 'wp-optimize');?></h2>
		
		<p>
		
			<?php $wp_optimize->wp_optimize_url('https://getwpo.com/faqs/', __('FAQs', 'wp-optimize')); ?> |
			
			<?php $wp_optimize->wp_optimize_url('https://getwpo.com/ask-pre-sales-question/', __('Ask a pre-sales question', 'wp-optimize')); ?>
			
		</p>
	</header>
	<table class="wpo_feat_table">
		<tbody>
		<tr>
			<td></td>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/notices/wp_optimize_logo.png');?>" alt="WP-Optimize" width="80" height="80">
				<br>
				<?php esc_html_e('Free', 'wp-optimize');?>
			</td>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/notices/wp_optimize_logo.png');?>" alt="<?php esc_attr_e('WP-Optimize Premium', 'wp-optimize');?>" width="80" height="80">
				<br>
				<?php esc_html_e('Premium', 'wp-optimize');?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p><?php esc_html_e('Installed', 'wp-optimize');?></p>
			</td>
			<td>
				<p><a href="<?php echo esc_url(apply_filters('wpo_premium_buy_url', 'https://getwpo.com/buy/'));?>" target="_blank"><?php esc_html_e('Upgrade now', 'wp-optimize');?></a></p>
			</td>
		</tr>
		<tr class="wpo-main-feature-row">
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/database-optimization-vehicle-64x64.png');?>" alt="<?php esc_attr_e('Database cleaning', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Database cleaning', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Clears out unnecessary data, cleans up your tables and retrieves space lost to data fragmentation.', 'wp-optimize'); ?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr class="wpo-main-feature-row">
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/image-compression-vehicle-64x64.png');?>" alt="<?php esc_attr_e('Image compression', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Image compression', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Compress your images for a much faster page load.', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr class="wpo-main-feature-row">
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/cache-vehicle-64x64.png');?>" alt="<?php esc_attr_e('Caching', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Caching', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Cache your page and post for even more speed.', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/multisite-support.png');?>" alt="<?php esc_attr_e('Multisite support', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Multisite support', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Optimize any site (or combination of sites) on your WordPress Multisite or network', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/optimize-individual.png');?>" alt="<?php esc_attr_e('Optimize individual tables', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Optimize individual tables', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Perform optimizations on single tables', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/remove-unwanted-img.png');?>" alt="<?php esc_attr_e('Remove unwanted images', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Remove unwanted images', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Remove images that have been orphaned or are no longer in use', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/scheduling.png');?>" alt="<?php esc_attr_e('Multisite support', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Sophisticated scheduling', 'wp-optimize');?></h4>
				<p><?php esc_html_e('A more advanced scheduling system to make regular routine optimizations whenever you prefer', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/wp-cli.png');?>" alt="<?php esc_attr_e('Control with WP-CLI', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Control with WP-CLI', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Save time managing multiple sites from the WP command line', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/lazy-load.png');?>" alt="<?php esc_attr_e('Lazy Loading', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Lazy Loading', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Make your site run faster by only loading parts of a web-page when it is visible to the user', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/optimization-preview.png');?>" alt="<?php esc_attr_e('Optimization Preview', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Optimization Preview', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Preview, select and remove data and records available for optimization from the database', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/logging-n-reporting.png');?>" alt="<?php esc_attr_e('Enhanced logging and reporting', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Enhanced logging and reporting', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Send log messages to three additional locations: Slack, Syslog and Simple History', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/choice-n-flexibility.png');?>" alt="<?php esc_attr_e('More choice and flexibility', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('More choice and flexibility', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Choose from a number of advanced options, like the ability to optimize individual DB tables', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/geolocation.png');?>" alt="<?php esc_attr_e('Geolocation for WooCommerce', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Geolocation and tax country for WooCommerce', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Anyone running an international WooCommerce store needs this: serve country specific content to your customers, appropriate VAT, pricing, all cached for great performance', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/more-settings.png');?>" alt="<?php esc_attr_e('Multilingual and multi-currency compatible', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Multilingual and multi-currency compatible', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Cache supports WPML multilingual plugin and multiple currencies for WooCommerce', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/choice-n-flexibility.png');?>" alt="<?php esc_attr_e('More caching options', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('More caching options', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Exclude posts and pages from the cache, straight from the post edit screen.', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/lazy-load.png');?>" alt="<?php esc_attr_e('Preload key requests', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Preload key requests', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Preload assets such as web fonts and icon fonts, as recommended by Google PageSpeed Insights', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/advanced.png');?>" alt="<?php esc_attr_e('Power tweaks', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Power tweaks', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Catered towards more advanced users, the power tweaks will enable you to improve performance by targeting specific weak points, either in WordPress Core, or in popular plugins', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo esc_url(WPO_PLUGIN_URL.'images/features/premium-support.png');?>" alt="<?php esc_attr_e('Premium support', 'wp-optimize');?>" class="wpo-premium-image">
				<h4><?php esc_html_e('Premium support', 'wp-optimize');?></h4>
				<p><?php esc_html_e('Get your specific queries addressed directly by our experts', 'wp-optimize');?></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-no-alt" aria-label="<?php esc_attr_e('No', 'wp-optimize');?>"></span></p>
			</td>
			<td>
				<p><span class="dashicons dashicons-yes" aria-label="<?php esc_attr_e('Yes', 'wp-optimize');?>"></span></p>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p><?php esc_html_e('Installed', 'wp-optimize');?></p>
			</td>
			<td>
				<p><a href="<?php echo esc_url(apply_filters('wpo_premium_buy_url', 'https://getwpo.com/buy/'));?>" target="_blank"><?php esc_html_e('Upgrade now', 'wp-optimize');?></a></p>
			</td>
		</tr>
		</tbody>
	</table>
</div>
<div class="wpo_col  wpo_half_width wpo_plugin_family_cont wpo-plugin-family__free">
	<header>
		<h2><?php esc_html_e("Our other plugins", 'wp-optimize');?></h2>
		<p>
			<?php $wp_optimize->wp_optimize_url('https://updraftplus.com/', 'UpdraftPlus'); ?> |
			
			<?php $wp_optimize->wp_optimize_url('https://updraftplus.com/updraftcentral/', 'UpdraftCentral'); ?> |
		</p>
	</header>
	<div class="wpo-plugin-family__plugins">
		<div class="wpo-plugin-family__plugin">
			<?php
			$wp_optimize->wp_optimize_url('https://updraftplus.com/', null, '<img class="addons" alt="'. esc_attr__("UpdraftPlus", 'wp-optimize').'" src="'. esc_url(WPO_PLUGIN_URL.'images/features/updraftplus_logo.png') .'">');
			$wp_optimize->wp_optimize_url('https://updraftplus.com/', null, '<h3>'. esc_html__('UpdraftPlus – the ultimate protection for your site, hard work and business', 'wp-optimize').'</h3>', 'class="other-plugin-title"');
			?>
			<p>
				<?php esc_html_e("If you’ve got a WordPress website, you need a backup.", 'wp-optimize');?>
			</p>
			<p>
				<?php
					esc_html_e('Hacking, server crashes, dodgy updates or simple user error can ruin everything.', 'wp-optimize');
				?>
			</p>
			<p>
				<?php
					$message = __("With UpdraftPlus, you can rest assured that if the worst does happen, it's no big deal.", 'wp-optimize');
					$message .= ' ';
					$message .= __("Rather than losing everything, you can simply restore the backup and be up and running again in no time at all.", 'wp-optimize');
					echo esc_html($message);
				?>
			</p>
			<p>
				<?php esc_html_e("You can also migrate your website with few clicks without hassle.", 'wp-optimize');?>
			</p>
			<p>
				<?php esc_html_e("With a long-standing reputation for excellence and outstanding reviews, it’s no wonder that UpdraftPlus is the world’s most popular WordPress backup plugin.", 'wp-optimize');?>
			</p>
			<?php $wp_optimize->wp_optimize_url('https://updraftplus.com/', null, esc_html__('Try for free', 'wp-optimize')); ?>
		</div>
		<div class="wpo-plugin-family__plugin">
			<?php
			$wp_optimize->wp_optimize_url('https://updraftplus.com/updraftcentral/', null, '<img class="addons" alt="'. esc_attr__('UpdraftCentral Dashboard', 'wp-optimize').'" src="'. esc_url(WPO_PLUGIN_URL.'images/features/updraftcentral_logo.png') .'">');
			$wp_optimize->wp_optimize_url('https://updraftplus.com/', null, '<h3>'. esc_html__('UpdraftCentral – save hours managing multiple WP sites from one place', 'wp-optimize').'</h3>', 'class="other-plugin-title"');
			?>
			<p>
				<?php esc_html_e("If you manage a few WordPress sites, you need UpdraftCentral.", 'wp-optimize');?>
			</p>
			<p>
				<?php
					$message = __("UpdraftCentral is a powerful tool that allows you to efficiently manage, update, backup and even restore multiple websites from just one location.", 'wp-optimize');
					$message .= ' ';
					$message .= __("You can also manage users and comments on all the sites at once, and through its central login feature, you can access each WP-dashboard with a single click.", 'wp-optimize');
					echo esc_html($message);
				?>
			</p>
			<p>
				<?php esc_html_e("With a wide range of useful features, including automated backup schedules and sophisticated one click updates, UpdraftCentral is sure to boost to your productivity and save you time.", 'wp-optimize');?>
			</p>
			<?php $wp_optimize->wp_optimize_url('https://updraftplus.com/updraftcentral/', null, esc_html__('Try for free', 'wp-optimize')); ?>
		</div>
	</div><!-- END wpo-plugin-family__plugins -->
</div>
<div class="clear"></div>