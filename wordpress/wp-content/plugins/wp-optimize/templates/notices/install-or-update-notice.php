<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="notice wpo-introduction-notice is-dismissible below-h2">

	<?php if ($is_new_install) : ?>

		<h3><?php _e('Thank you for installing WP-Optimize!', 'wp-optimize'); ?></h3>
		<p><?php _e('The team at WP-Optimize is working hard to make your site fast & efficient.', 'wp-optimize'); ?></p>
		<p>
			<?php printf(_x('The plugin settings are split into three parts: %sclean%s the database, %scompress%s images and %scaching%s.', '%s will be replaced by a "strong" tag', 'wp-optimize'), '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>'); ?>
		</p>
		<p><?php printf(__('If you are unsure what settings to use, please take a look at the %sdocumentation%s.', 'wp-optimize'), '<a href="'.WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/support/').'">', '</a>'); ?></p>
		<?php if (!$is_updraftplus_installed) : ?>
			<p>
				<?php printf(__('But first, we strongly recommend you backup your site with %sUpdraftPlus%s.', 'wp-optimize'), '<a href="'.WP_Optimize()->maybe_add_affiliate_params('https://updraftplus.com/').'">', '</a>'); ?> 
				<?php _e('WP-Optimize can trigger UpdraftPlus to automatically back up right before any optimization takes place so you can undo any changes you make.', 'wp-optimize'); ?>
			</p>
		<?php endif; ?>
		<?php if (!$is_premium) : ?>
			<p><?php printf(__('Finally, please take a look at our %spremium version%s, which is packed full of additional speed enhancements to make your site go even faster!', 'wp-optimize'), '<a href="'.WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/buy/').'">', '</a>'); ?></p>
		<?php endif; ?>
		<div class="wpo-introduction-notice__footer">
			<p class="wpo-introduction-notice__footer-links font-size__normal">
				<button type="button" class="button button-primary close"><?php _e('Dismiss', 'wp-optimize'); ?></button>
			</p>
		</div>

	<?php else : ?>

		<h3><?php _e('Thank you for updating WP-Optimize!', 'wp-optimize'); ?></h3>
		<p><?php _e('The team at WP-Optimize is working hard to make your site fast & efficient.', 'wp-optimize'); ?></p>
		<p>
			<?php printf(_x('This new version includes the ability to %s cache your site.%s', '%s will be replaced by a "strong" tag', 'wp-optimize'), '<strong>', '</strong>'); ?>
			<?php _e("We've built this around the most powerful caching technology we know and subjected it to many months of highly intensive testing.", 'wp-optimize'); ?>
		</p>
		<p><?php _e("If you already have plugins for images and caching, don't worry - WP-Optimize won't interfere unless you turn these options on.", 'wp-optimize'); ?></p>
		<p><?php printf(_x("However, %s tests by us%s and early adopters show WP-Optimize's cache feature alone can make your site faster than every other caching plugin we've tested, and it's simpler too. So we encourage you to give it a go!", '%s will be replaced by a link', 'wp-optimize'), '<a target="_blank" href="'.WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/benchmark/').'">', '</a>'); ?></p>
		<?php if (!$is_premium) : ?>
			<p class="wpo-introduction-notice__footer-links--premium"><?php printf(_x('PS - check out our new improved Premium version %shere%s.', '%s is replaced by a link tag', 'wp-optimize'), '<a href="'.'https://getwpo.com/buy/'.'" target="_blank">', '</a>'); ?></p>
		<?php endif; ?>
		<div class="wpo-introduction-notice__footer">
			<p class="wpo-introduction-notice__footer-links font-size__normal">
				<button type="button" class="button button-primary close"><?php _e('Dismiss', 'wp-optimize'); ?></button>
				<?php if ($is_premium) : ?>
					<?php printf(__('%sRead the documentation%s or if you have any questions, please ask %sPremium support%s', 'wp-optimize'), '<a target="_blank" href="'.WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/faqs/').'">', '</a>', '<a target="_blank" href="'.WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/premium-support/').'">', '</a>'); ?>
				<?php else : ?>
					<?php WP_Optimize()->wp_optimize_url('https://getwpo.com/faqs/', __('Read the documentation', 'wp-optimize')); ?>
					| <?php WP_Optimize()->wp_optimize_url('https://wordpress.org/support/plugin/wp-optimize/', __('Support', 'wp-optimize')); ?>
				<?php endif; ?>
			</p>
		</div>

	<?php endif; ?>

</div>