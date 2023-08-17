<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<h3 class="wpo-first-child"><?php esc_html_e('Preload now', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup">
	<p>
		<input id="wp_optimize_run_cache_preload" class="button button-primary" type="submit" name="wp_optimize_run_cache_preload" value="<?php echo $is_running ? esc_attr__('Cancel', 'wp-optimize') : esc_attr__('Run now', 'wp-optimize'); ?>" <?php echo $is_running ? 'data-running="1"' : ''; ?>>
		<span id="wp_optimize_preload_cache_status"><?php
			echo esc_html($status_message);
		?></span>
	</p>
	<span>
		<?php esc_html_e('This action will trigger WP-Optimize to cache the site by visiting pages to preload them (so that they are ready the first time a human visitor wants them).', 'wp-optimize'); ?>
		<?php esc_html_e('If a sitemap is available, then it will be used to determine which content gets cached.', 'wp-optimize'); ?>
	</span>
</div>

<h3 class="wpo-first-child"><?php esc_html_e('Schedule preloader', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup">
	<p>
		<label>
			<input name="enable_schedule_preload" id="enable_schedule_preload" class="cache-settings" type="checkbox" value="true" <?php checked($wpo_cache_options['enable_schedule_preload']); ?>>
			<?php esc_html_e('Activate scheduled cache preloading', 'wp-optimize'); ?>
		</label>
		<p>
			<?php esc_html_e('The scheduled preloading will run automatically in your chosen time period.', 'wp-optimize'); ?>
		</p>
	</p>

	<label for="preload_schedule_type"><?php esc_html_e('Select schedule type', 'wp-optimize'); ?></label><br>

	<select id="preload_schedule_type" class="cache-settings" name="preload_schedule_type" disabled>

		<?php

		foreach ($schedule_options as $opt_id => $opt_description) {
			?>
			<option value="<?php echo esc_attr($opt_id); ?>" <?php selected($wpo_cache_options['preload_schedule_type'], $opt_id); ?> <?php if ('wpo_use_cache_lifespan' == $opt_id && $wpo_cache_options['page_cache_length_value'] <= 0) disabled(true); ?>><?php echo esc_html($opt_description); ?></option>
			<?php
		}

		?>

	</select>

</div>

<input id="wp-optimize-save-cache-preload-settings" class="button button-primary" type="submit" name="wp-optimize-save-cache-preload-settings" value="<?php esc_attr_e('Save changes', 'wp-optimize');?>">

<img class="wpo_spinner" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="...">

<span class="save-done dashicons dashicons-yes display-none"></span>
