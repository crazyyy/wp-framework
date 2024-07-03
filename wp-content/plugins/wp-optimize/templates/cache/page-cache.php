<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<?php if ($does_server_handles_cache) : ?>
<div class="wpo-info highlight-dashicons">
	<h3><?php esc_html_e('Your web hosting company/server handles: ', 'wp-optimize'); ?></h3>
	<p><?php esc_html_e('Page caching', 'wp-optimize'); ?><span class="dashicons dashicons-saved"></span></p>
	<p><?php esc_html_e('Gzip compression', 'wp-optimize'); ?><span class="dashicons dashicons-saved"></span></p>
	<p><?php esc_html_e('Browser static file caching (via headers)', 'wp-optimize'); ?><span class="dashicons dashicons-saved"></span></p>	
</div>
<?php else : ?>
<div class="wpo-info">
	<a class="wpo-info__trigger" href="#"><span class="dashicons dashicons-sos"></span> <?php esc_html_e('How to use the cache feature', 'wp-optimize'); ?> <span class="wpo-info__close"><?php esc_html_e('Close', 'wp-optimize'); ?></span></a>
	<div class="wpo-info__content">
		<p><strong><?php esc_html_e('Not sure how to use the cache feature?', 'wp-optimize'); ?></strong> <br><?php esc_html_e('Watch our how-to video below.', 'wp-optimize'); ?></p>
		<div class="wpo-video-preview">
			<a href="https://vimeo.com/337247770" data-embed="https://player.vimeo.com/video/337247770?color=df6926&title=0&byline=0&portrait=0" target="_blank"><img src="<?php echo esc_url(trailingslashit(WPO_PLUGIN_URL) . 'images/notices/cache-video-preview.png'); ?>" alt="<?php esc_attr_e('Cache video preview', 'wp-optimize');?>" /></a>
		</div>
		<small>(<?php esc_html_e('Loads a video hosted on vimeo.com', 'wp-optimize'); ?>) - <?php $wp_optimize->wp_optimize_url('https://vimeo.com/337247770', __('Open the video in a new window', 'wp-optimize')); ?></small>
	</div>
</div>
<div class="wpo-fieldgroup wpo-first-child cache-options">
	<div class="notice notice-warning below-h2 wpo-warnings__enabling-cache wpo_hidden"><p></p><ul></ul></div>
	<div class="notice error below-h2 wpo-error wpo-error__enabling-cache <?php echo empty($error) ? 'wpo_hidden' : ''; ?>"><p><?php echo htmlentities($error); ?></p></div>

	<pre id="wpo_advanced_cache_output" style="display: none;"></pre>

	<div class="switch-container">
		<label class="switch">
			<input name="enable_page_caching" id="enable_page_caching" class="cache-settings" type="checkbox" value="true" <?php checked($wpo_cache_options['enable_page_caching'] || $wpo_cache->is_enabled()); ?>>
			<span class="slider round"></span>
		</label>
		<label for="enable_page_caching">
			<?php esc_html_e('Enable page caching', 'wp-optimize'); ?>
		</label>
	</div>
	<p>
		<?php echo esc_html__("This is all that's needed for caching to work.", 'wp-optimize').' '.esc_html__('WP-Optimize will automatically detect and configure itself optimally for your site.', 'wp-optimize').' '.esc_html__('You can tweak the settings below and in the advanced settings tab, if needed.', 'wp-optimize'); ?>
	</p>

	<?php if (!empty($active_cache_plugins)) { ?>
	<p class="wpo-error">
		<?php
			$message = sprintf(__('It looks like you already have an active caching plugin (%s) installed.', 'wp-optimize'), implode(', ', $active_cache_plugins));
			$message .= ' ';
			$message .=  __('Having more than one active page cache might cause unexpected results.', 'wp-optimize');
			echo esc_html($message);
		?>
	</p>
	<?php } ?>

</div>

<h3 class="purge-cache" style="<?php echo esc_attr($display); ?>"> <?php esc_html_e('Purge the cache', 'wp-optimize'); ?></h3>
<div class="wpo-fieldgroup cache-options purge-cache" style="<?php echo esc_attr($display); ?>" >
	<p class="wpo-button-wrap">
		<input id="wp-optimize-purge-cache" class="button button-primary <?php echo $can_purge_the_cache ? '' : 'disabled'; ?>" type="submit" value="<?php esc_attr_e('Purge cache', 'wp-optimize'); ?>" <?php echo $can_purge_the_cache ? '' : 'disabled'; ?>>
		<img class="wpo_spinner" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="...">
		<span class="save-done dashicons dashicons-yes display-none"></span>
	</p>
	<p>
		<?php esc_html_e('Deletes the entire cache contents but keeps the page cache enabled.', 'wp-optimize'); ?>
	</p>
	<p>
		<span id="wpo_current_cache_size_information"><?php esc_html_e('Current cache size:', 'wp-optimize'); ?> <?php echo esc_html(WP_Optimize()->format_size($cache_size['size'])); ?></span>
		<br><span id="wpo_current_cache_file_count"><?php esc_html_e('Number of files:', 'wp-optimize'); ?> <?php echo esc_html($cache_size['file_count']); ?></span>
	</p>
</div>

<h3><?php esc_html_e('Cache settings', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup cache-options">

	<div class="wpo-fieldgroup__subgroup">
		<label for="enable_mobile_caching">
			<input name="enable_mobile_caching" id="enable_mobile_caching" class="cache-settings" type="checkbox" value="true" <?php checked($wpo_cache_options['enable_mobile_caching'], 1); ?>>
			<?php esc_html_e('Generate separate files for mobile devices', 'wp-optimize'); ?>
		</label>
		<span tabindex="0" data-tooltip="<?php esc_attr_e('Useful if your website has mobile-specific content.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
	</div>

	<div class="wpo-fieldgroup__subgroup">
		<label for="enable_user_caching">
			<input name="enable_user_caching" id="enable_user_caching" class="cache-settings wpo-select-group" type="checkbox" value="true" <?php checked($wpo_cache_options['enable_user_caching']); ?>>
			<?php esc_html_e('Serve cached pages to logged in users', 'wp-optimize'); ?>
		</label>
		<span tabindex="0" data-tooltip="<?php esc_attr_e('Enable this option if you do not have user-specific or restricted content on your website (this works only when the cache is preloaded).', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
	</div>

	<?php do_action('wpo_after_cache_settings'); ?>

	<div class="wpo-fieldgroup__subgroup">
		<label for="page_cache_length_value"><?php esc_html_e('Cache lifespan', 'wp-optimize'); ?></label>
		<p>
			<input name="page_cache_length_value" id="page_cache_length_value" class="cache-settings" type="number" value="<?php echo esc_attr($wpo_cache_options['page_cache_length_value']); ?>">
			<select name="page_cache_length_unit" id="page_cache_length_unit" class="cache-settings">
				<option value="hours" <?php selected('hours', $wpo_cache_options['page_cache_length_unit']); ?>><?php esc_html_e('Hours', 'wp-optimize'); ?></option>
				<option value="days" <?php selected('days', $wpo_cache_options['page_cache_length_unit']); ?>><?php esc_html_e('Days', 'wp-optimize'); ?></option>
				<option value="months" <?php selected('months', $wpo_cache_options['page_cache_length_unit']); ?>><?php esc_html_e('Months', 'wp-optimize'); ?></option>
			</select>
		</p>
		<span>
			<?php esc_html_e('Time after which a new cached version will be generated (0 = only when the cache is emptied)', 'wp-optimize'); ?>
		</span>
	</div>

	<?php do_action('wpo_page_cache_settings_after', $wpo_cache_options); ?>

</div>

<input id="wp-optimize-save-cache-settings" class="button button-primary" type="submit" name="wp-optimize-save-cache-settings" value="<?php esc_attr_e('Save changes', 'wp-optimize'); ?>">

<img class="wpo_spinner" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="....">

<span class="save-done dashicons dashicons-yes display-none"></span>
<?php endif;
