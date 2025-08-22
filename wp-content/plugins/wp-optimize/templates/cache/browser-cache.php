<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<div class="wpo_section wpo_group">

	<h3 class="wpo-first-child"><?php esc_html_e('Browser static file caching settings (via headers)', 'wp-optimize');?></h3>
	<p>
		<?php echo esc_html__("Browser static file caching uses HTTP response headers to advise a visitor's browser to cache non-changing files for a while, so that it doesn't attempt to retrieve them upon every visit.", 'wp-optimize').' '.sprintf('<a href="%s" target="_blank">%s</a>', esc_url($info_link), esc_html__('Follow this link to get more information.', 'wp-optimize')); ?>
	</p>

	<div class="wpo-fieldgroup">
		<?php if ($is_cloudflare_site) : ?>
		<p class="wpo-enabled"><span class="dashicons dashicons-yes"></span>
			<em><?php esc_html_e('Your website seems to use Cloudflare, which handles the browser caching rules.', 'wp-optimize'); ?></em>
		</p>

		<?php else : ?>

		<div id="wpo_browser_cache_status" class="<?php echo esc_attr($class_name); ?>">
			<span class="wpo-enabled"><span class="dashicons dashicons-yes"></span>
				<?php
					// translators: %s is the word "enabled" in bold
					echo wp_kses_post(sprintf(__('Browser static file caching headers are currently %s.', 'wp-optimize'), '<strong>'.esc_html__('enabled', 'wp-optimize').'</strong>'));
				?>
			</span>
			<span class="wpo-disabled">
				<?php
					// translators: %s is the word "disabled" in bold
					echo wp_kses_post(sprintf(__('Browser static file caching headers are currently %s.', 'wp-optimize'), '<strong>'.esc_html__('disabled', 'wp-optimize').'</strong>'));
				?>
			</span>
		</div>

		<br>

		<?php

		// add browser cache control section only if browser cache disabled or we added cache settings to .htaccess.
		if (false == $wpo_browser_cache_enabled || $wpo_browser_cache_settings_added || is_wp_error($wpo_browser_cache_enabled)) {
			if (is_wp_error($wpo_browser_cache_enabled)) {
				?>
				<div id="wpo_browser_cache_error_message" class="notice error below-h2">
					<p>
						<b><?php esc_html_e('Error: Unable to Check browser cache.', 'wp-optimize'); ?></b>
						<?php esc_html_e('We encountered a problem while checking if browser cache is enabled.', 'wp-optimize'); ?>
					</p>
					<p><?php echo wp_kses_post($wpo_browser_cache_enabled->get_error_message()); ?></p>
				</div>
				<?php
			} else {
				if ($wp_optimize->is_apache_server()) {
					$button_text = $wpo_browser_cache_enabled ? __('Update', 'wp-optimize') : __('Enable', 'wp-optimize');
					?>
					<form>
						<input type="hidden" id="wpo_enable_browser_cache" class="cache-settings" name="enable_browser_cache" value="<?php echo $wpo_browser_cache_enabled ? 'true' : 'false'; ?>" />
						<label><?php esc_html_e('Expiration time:', 'wp-optimize'); ?></label>
						<input id="wpo_browser_cache_expire_days" class="cache-settings" type="number" min="0" step="1" name="browser_cache_expire_days" value="<?php echo esc_attr($wpo_browser_cache_expire_days); ?>">
						<label for="wpo_browser_cache_expire_days"><?php esc_html_e('day(s)', 'wp-optimize'); ?></label>
						<input id="wpo_browser_cache_expire_hours" class="cache-settings" type="number" min="0" step="1" name="browser_cache_expire_hours" value="<?php echo esc_attr($wpo_browser_cache_expire_hours); ?>">
						<label for="wpo_browser_cache_expire_hours"><?php esc_html_e('hour(s)', 'wp-optimize'); ?></label>
						<button class="button-primary" type="button" id="wp_optimize_browser_cache_enable"><?php echo esc_html($button_text); ?></button>
						<img class="wpo_spinner display-none" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- N/A ?>"
							width="20" height="20" alt="...">
						<p><?php esc_html_e('Empty or 0 values disable the headers.', 'wp-optimize'); ?></p>
					</form>
				<?php
				} else {
					printf('<a href="%s" target="_blank">%s</a>', esc_url($faq_link), esc_html__('Follow this link to read the article about how to enable browser cache with your server software.', 'wp-optimize'));
				}
			
			?>

			<div id="wpo_browser_cache_message"><?php
				if (false == $wpo_browser_cache_enabled && $wpo_browser_cache_settings_added) {
			?>
				<div class="notice notice-error">
					<p>
						<?php
						$message = esc_html__('The .htaccess file already contains browser static caching settings, but browser caching is not functioning as expected.', 'wp-optimize');
						$message .= ' ';
						$message .= esc_html__('This indicates that your webserver does not support .htaccess browser caching rules.', 'wp-optimize');
						$message .= ' ';
						$message .= esc_html__('To further investigate this, you must contact your web hosting provider.', 'wp-optimize');
						echo $message; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
						?>
					</p>
				</div>
			<?php
				}
			?></div>
			<pre id="wpo_browser_cache_output" style="display: none;"></pre>
			<?php
			}
		}

		endif;
		?>
	</div><!-- END .wpo-fieldgroup -->
</div><!-- END .wpo_section -->
