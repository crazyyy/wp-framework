<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="notice wpo-introduction-notice is-dismissible below-h2">

	<?php if ($is_new_install) : ?>
		
		<?php if ($is_premium) : ?>
			<h3><?php esc_html_e('Thank you for installing WP-Optimize Premium!', 'wp-optimize'); ?></h3>
		<?php else : ?>
			<h3><?php esc_html_e('Thank you for installing WP-Optimize!', 'wp-optimize'); ?></h3>
		<?php endif; ?>
		<p>
			<?php
			esc_html_e('To really turbo boost the performance of your WordPress website, check out WP-Optimize Premium or get more rated plugins below:', 'wp-optimize');
			?>
		</p>
		<ul>
			<?php if (!$is_premium) : ?>
			<li>
				<a href="<?php echo esc_url('https://getwpo.com/buy/?utm_medium=software&utm_source=wpo&utm_content=wpo-introduction-notice&utm_term=try-now-wpo&utm_campaign=ad'); ?>" target="_blank">
					<strong><?php esc_html_e('WP-Optimize Premium:', 'wp-optimize'); ?></strong>
				</a>
				<?php echo esc_html__('Unlock new ways to speed up your WordPress website.', 'wp-optimize') . ' ' . esc_html__('Optimize from the WP-CLI, cache multilingual and multicurrency websites, get premium support and more.', 'wp-optimize'); ?>
			</li>
			<?php endif; ?>
			<?php if (!$is_updraftplus_installed) : ?>
			<li>
				<a href="<?php echo esc_url('https://updraftplus.com/?utm_medium=software&utm_source=wpo&utm_content=wpo-introduction-notice&utm_term=try-now-udp&utm_campaign=ad'); ?>" target="_blank">
					<strong><?php esc_html_e('UpdraftPlus:', 'wp-optimize'); ?></strong>
				</a>
				<?php echo esc_html__('Back up your website with the world’s leading backup and migration plugin.', 'wp-optimize') . ' ' . esc_html__('Actively installed on more than 3 million WordPress websites!', 'wp-optimize');
				?>
			</li>
			<?php endif; ?>
			<?php if (!$is_aios_prem_installed) : ?>
			<li>
				<a href="<?php echo esc_url('https://aiosplugin.com/?utm_medium=software&utm_source=wpo&utm_content=wpo-introduction-notice&utm_term=try-now-aios&utm_campaign=ad'); ?>" target="_blank">
					<strong><?php esc_html_e('All-In-One Security (AIOS):', 'wp-optimize'); ?></strong>
				</a>
				<?php echo esc_html__('Still on the fence? Secure your WordPress website with AIOS.', 'wp-optimize') . ' ' . esc_html__('Comprehensive, cost-effective, 5* rated and easy to use.', 'wp-optimize'); ?>
			</li>
			<?php endif; ?>
			<?php if (!$is_ilj_installed) : ?>
			<li>
				<a href="<?php echo esc_url('https://www.internallinkjuicer.com/?utm_medium=software&utm_source=wpo&utm_content=ilj-mayalso-like-tab&utm_term=try-now-ilj&utm_campaign=ad'); ?>" target="_blank">
					<strong><?php esc_html_e('Internal Link Juicer:', 'wp-optimize'); ?></strong>
				</a>
				<?php echo esc_html__('Automate the building of internal links on your WordPress website.', 'wp-optimize') . ' ' . esc_html__('Save time and boost SEO!', 'wp-optimize') . ' ' . esc_html__('You don’t need to be an SEO expert to use this plugin.', 'wp-optimize');?>
			</li>
			<?php endif; ?>
			<li>
				<a href="<?php echo esc_url('https://wpovernight.com/?utm_medium=software&utm_source=wpo&utm_content=wpo-introduction-notice&utm_term=try-now-wp-overnight&utm_campaign=ad'); ?>" target="_blank">
					<strong><?php esc_html_e('WP Overnight:', 'wp-optimize'); ?></strong>
				</a>
				<?php echo esc_html__('Quality add-ons for WooCommerce.', 'wp-optimize') . ' ' . esc_html__('Designed to optimize your store, enhance user experience and increase revenue!', 'wp-optimize');?>
			</li>
		</ul>
		<?php if (!$is_premium) : ?>
			<p>
			<?php
				// translators: %1$s is an opening anchor tag, %2$s is a closing anchor tag
				printf(esc_html__('Finally, please take a look at our %1$spremium version%2$s, which is packed full of additional speed enhancements to make your site go even faster!', 'wp-optimize'), '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/buy/')).'" target="_blank">', '</a>');
			?>
			</p>
		<?php endif; ?>
		<div class="wpo-introduction-notice__footer">
			<p class="wpo-introduction-notice__footer-links font-size__normal">
				<button type="button" class="button button-primary close"><?php esc_html_e('Dismiss', 'wp-optimize'); ?></button>
			</p>
		</div>

	<?php else : ?>

		<h3><?php esc_html_e('Thank you for updating WP-Optimize!', 'wp-optimize'); ?></h3>
		<p><?php esc_html_e('The team at WP-Optimize is working hard to make your site fast and efficient.', 'wp-optimize'); ?></p>
		<p>
			<?php
				// translators: %1$s is an opening strong tag, %2$s is a closing strong tag
				printf(esc_html_x('This new version includes a new major feature: the ability to %1$s minify your scripts and stylesheets.%2$s', '%s will be replaced by a "strong" tag', 'wp-optimize'), '<strong>', '</strong>');
				esc_html_e("This highly requested feature adds an extra layer of optimization to your website, lowering the number of requests sent to your server by combining and minifying the JavaScript and CSS files.", 'wp-optimize');
			?>
			<a href="#" class="js--wpo-goto" data-page="wpo_minify" data-tab="status"><?php esc_html_e('Go to minify settings.', 'wp-optimize'); ?></a>
		</p>
		<p><?php esc_html_e("If you already have plugins for minifying, don't worry - WP-Optimize won't interfere unless you turn these options on.", 'wp-optimize'); ?></p>
		<p>
		<?php
			// translators: %1$s is an opening anchor tag, %2$s is a closing anchor tag
			printf(esc_html_x('Read more about this feature %1$son our website%2$s.', '%s will be replaced by a link tag', 'wp-optimize'), '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/faqs/category/minification/')).'" target="_blank">', '</a>');
		?>
		</p>
		<?php if (!$is_premium) : ?>
			<p class="wpo-introduction-notice__footer-links--premium">
				<?php
					// translators: %1$s is opening anchor tag, %2$s is closing anchor tag
					printf(esc_html_x('PS - check out our new improved Premium version %1$shere%2$s.', '%s is replaced by a link tag', 'wp-optimize'), '<a href="'.esc_url('https://getwpo.com/buy/').'" target="_blank">', '</a>');
				?>
			</p>
		<?php endif; ?>
		<div class="wpo-introduction-notice__footer">
			<p class="wpo-introduction-notice__footer-links font-size__normal">
				<button type="button" class="button button-primary close"><?php esc_html_e('Dismiss', 'wp-optimize'); ?></button>
				<?php
					if ($is_premium) :
						// translators: %1$s is an opening anchor tag, %2$s is a closing anchor tag, %3$s is an opening anchor tag, %4$s is a closing anchor tag
						printf(esc_html__('%1$sRead the full WP-Optimize documentation%2$s, or if you have any questions, please ask %3$sPremium support%4$s', 'wp-optimize'), '<a target="_blank" href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/faqs/')).'">', '</a>', '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/premium-support/')).'" target="_blank">', '</a>');
					else :
						WP_Optimize()->wp_optimize_url('https://getwpo.com/faqs/', __('Read the documentation', 'wp-optimize'));
						echo ' | ';
						WP_Optimize()->wp_optimize_url('https://wordpress.org/support/plugin/wp-optimize/', __('Support', 'wp-optimize'));
					endif;
				?>
			</p>
		</div>

	<?php endif; ?>

</div>