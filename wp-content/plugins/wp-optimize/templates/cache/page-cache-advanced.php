<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<h3 class="wpo-first-child"><?php esc_html_e('URLs to exclude from caching', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup">

	<p>
		<label for="cache_exception_urls"><?php echo strip_tags(sprintf(__('List paths (e.g. %s) that should not be cached (one per line)', 'wp-optimize'), '<code>'.esc_html_x('/product/green-beans', 'an example path', 'wp-optimize').'</code>'), '<code>'); ?> </label>
		<textarea name="cache_exception_urls" id="cache_exception_urls" class="cache-settings" placeholder="/members/*"><?php echo esc_html($cache_exception_urls); ?></textarea>
	</p>

	<span>
		<?php esc_html_e('Use the wildcard * to exclude child URLs.', 'wp-optimize'); ?> <?php echo strip_tags(sprintf(_x('e.g. %s or %s', '%s are examples of path using the wildcard *', 'wp-optimize'), '<code>'.esc_html_x('/shop/*', 'an example path with the wildcard (*)', 'wp-optimize').'</code>', '<code>'.esc_html_x('*sample-path*', 'a second example path using the wildcard (*) twice', 'wp-optimize').'</code>'), '<code>'); ?>
	</span>

	<?php do_action('wpo_after_cache_exception_urls'); ?>

</div>

<?php do_action('wpo_after_cache_exception_urls_fieldgroup'); ?>

<h3 class="wpo-first-child"><?php esc_html_e('Cookies which, if present, will prevent caching (one per line)', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup">

	<p>
		<label for="cache_exception_cookies"><?php esc_html_e('List of cookies that will prevent caching when set.', 'wp-optimize'); ?></label>
		<textarea name="cache_exception_cookies" id="cache_exception_cookies" class="cache-settings" placeholder="wordpress_*"><?php echo esc_textarea($cache_exception_cookies); ?></textarea>
	</p>
</div>

<h3 class="wpo-first-child"><?php esc_html_e('Conditional tags to exclude from caching', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup">

	<p>
		<label for="cache_exception_conditional_tags">
		<?php
			echo strip_tags(sprintf(__('List conditional tags (e.g. %s) that should not be cached (one per line).', 'wp-optimize'), '<code>is_single</code>'), '<code>');
			echo '&nbsp;';
			echo strip_tags(sprintf(__('You can find more details about conditional tags from %1$shere%2$s', 'wp-optimize'), '<a href="https://codex.wordpress.org/Conditional_Tags" target="_blank">', '</a>'), '<a>');
		?>
		</label>
		<textarea name="cache_exception_conditional_tags" id="cache_exception_conditional_tags" class="cache-settings" placeholder="is_single"><?php echo esc_textarea($cache_exception_conditional_tags); ?></textarea>
	</p>

	<?php do_action('wpo_after_cache_conditional_tags'); ?>

</div>

<h3 class="wpo-first-child"><?php esc_html_e('List of browser agent strings which, if detected, will prevent caching', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup">

	<p>
		<label for="cache_exception_browser_agents"><?php esc_html_e('List of browser agents strings or substrings that should not be served cached files (one per line)', 'wp-optimize'); ?></label>
		<textarea name="cache_exception_browser_agents" id="cache_exception_browser_agents" class="cache-settings" placeholder="AppleWebKit/*"><?php echo esc_textarea($cache_exception_browser_agents); ?></textarea>
	</p>

	<span><?php esc_html_e('If any of the above strings is found in the User-Agent HTTP header, then the requested page will not be cached.', 'wp-optimize'); ?> </span>
</div>

<?php do_action('wpo_page_cache_advanced_settings', $wpo_cache_options); ?>

<input id="wp-optimize-save-cache-advanced-rules" class="button button-primary" type="submit" name="wp-optimize-save-cache-advanced-rules" value="Save changes">

<img class="wpo_spinner" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="...">

<span class="save-done dashicons dashicons-yes display-none"></span>
