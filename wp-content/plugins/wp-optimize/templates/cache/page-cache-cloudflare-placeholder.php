<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h3 class="wpo-cloudflare-cache-options purge-cache"> <?php esc_html_e('Cloudflare settings', 'wp-optimize'); ?></h3>
<div class="wpo-fieldgroup cache-options wpo-cloudflare-cache-options purge-cache">
	<p>
		<input id="purge_cloudflare_cache" disabled type="checkbox" name="purge_cloudflare_cache" class="cache-settings">
		<label for="purge_cloudflare_cache">
			<?php esc_html_e('Purge Cloudflare cached pages when the WP-Optimize cache is purged', 'wp-optimize'); ?>
			<em><?php
				// translators: %s is a link to WP Optimize Premium
				echo wp_kses_post(sprintf(__('(This feature requires %s)', 'wp-optimize'), '<a target="_blank" href="'.esc_url(WP_Optimize()->maybe_add_affiliate_params('https://teamupdraft.com/wp-optimize/pricing/')).'">WP Optimize Premium</a>'));
				?>
			</em>
		</label>
		
	</p>
</div>
