<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="notice wpo-introduction-notice is-dismissible below-h2">

	<?php if ($is_new_install) : ?>

		<h3><?php esc_html_e('Thank you for installing WP-Optimize!', 'wp-optimize'); ?></h3>
		<p><?php esc_html_e('The team at WP-Optimize is working hard to make your site fast and efficient.', 'wp-optimize'); ?></p>
		<p>
			<?php printf(esc_html_x('The plugin settings are split into three parts: %sclean%s the database, %scompress%s images and %scaching%s.', '%s will be replaced by a "strong" tag', 'wp-optimize'), '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>'); ?>
		</p>
		<p><?php printf(esc_html__('If you are unsure what settings to use, please take a look at the %sdocumentation%s.', 'wp-optimize'), '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/support/')).'" target="_blank">', '</a>'); ?></p>
		<p>
			<?php printf(esc_html_x('We also recently added the ability to %scombine and minify%s CSS, JavaScript and HTML, for an increased performance boost.', '%s will be replaced by a "strong" tag', 'wp-optimize'), '<strong>', '</strong>'); ?>
			<?php printf(esc_html_x('Read more about this feature %son our website%s.', '%s will be replaced by a link tag', 'wp-optimize'), '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/faqs/category/minification/')).'" target="_blank">', '</a>'); ?>
		</p>
		<?php if (!$is_updraftplus_installed) : ?>
			<p>
				<?php printf(esc_html__('But first, we strongly recommend you backup your site with %sUpdraftPlus%s.', 'wp-optimize'), '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://updraftplus.com/')).'" target="_blank">', '</a>'); ?>
				<?php esc_html_e('WP-Optimize can trigger UpdraftPlus to automatically back up right before any optimization takes place, so you can undo any changes you make.', 'wp-optimize'); ?>
			</p>
		<?php endif; ?>
		<?php if (!$is_premium) : ?>
			<p><?php printf(esc_html__('Finally, please take a look at our %spremium version%s, which is packed full of additional speed enhancements to make your site go even faster!', 'wp-optimize'), '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/buy/')).'" target="_blank">', '</a>'); ?></p>
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
			<?php printf(esc_html_x('This new version includes a new major feature: the ability to %s minify your scripts and stylesheets.%s', '%s will be replaced by a "strong" tag', 'wp-optimize'), '<strong>', '</strong>'); ?>
			<?php esc_html_e("This highly requested feature adds an extra layer of optimization to your website, lowering the number of requests sent to your server by combining and minifying the JavaScript and CSS files.", 'wp-optimize'); ?>
			<a href="#" class="js--wpo-goto" data-page="wpo_minify" data-tab="status"><?php esc_html_e('Go to minify settings.', 'wp-optimize'); ?></a>
		</p>
		<p><?php esc_html_e("If you already have plugins for minifying, don't worry - WP-Optimize won't interfere unless you turn these options on.", 'wp-optimize'); ?></p>
		<p><?php printf(esc_html_x('Read more about this feature %son our website%s.', '%s will be replaced by a link tag', 'wp-optimize'), '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/faqs/category/minification/')).'" target="_blank">', '</a>'); ?></p>
		<?php if (!$is_premium) : ?>
			<p class="wpo-introduction-notice__footer-links--premium"><?php printf(esc_html_x('PS - check out our new improved Premium version %shere%s.', '%s is replaced by a link tag', 'wp-optimize'), '<a href="'.esc_url('https://getwpo.com/buy/').'" target="_blank">', '</a>'); ?></p>
		<?php endif; ?>
		<div class="wpo-introduction-notice__footer">
			<p class="wpo-introduction-notice__footer-links font-size__normal">
				<button type="button" class="button button-primary close"><?php esc_html_e('Dismiss', 'wp-optimize'); ?></button>
				<?php if ($is_premium) : ?>
					<?php printf(esc_html__('%sRead the full WP-Optimize documentation%s, or if you have any questions, please ask %sPremium support%s', 'wp-optimize'), '<a target="_blank" href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/faqs/')).'">', '</a>', '<a href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/premium-support/')).'" target="_blank">', '</a>'); ?>
				<?php else : ?>
					<?php WP_Optimize()->wp_optimize_url('https://getwpo.com/faqs/', __('Read the documentation', 'wp-optimize')); ?>
					| <?php WP_Optimize()->wp_optimize_url('https://wordpress.org/support/plugin/wp-optimize/', __('Support', 'wp-optimize')); ?>
				<?php endif; ?>
			</p>
		</div>

	<?php endif; ?>

</div>
