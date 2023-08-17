<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<li id="<?php echo esc_attr($file['uid']); ?>">
	<span class="filename"><a href="<?php echo esc_url($file['file_url']); ?>" target="_blank"><?php echo esc_html($file['filename']); ?></a> (<?php echo esc_html($file['fsize']); ?>)</span>
	<a href="#" class="log"><?php esc_html_e('Show information', 'wp-optimize'); ?></a>
	<a href="#" class="delete-file" data-filename='<?php echo esc_attr($file['filename']); ?>'><?php esc_html_e('Delete', 'wp-optimize'); ?></a>
	<div class="hidden save_notice">
		<p><?php esc_html_e('The file was added to the list', 'wp-optimize'); ?></p>
		<p><button class="button button-primary save-exclusions"><?php esc_html_e('Save the changes', 'wp-optimize'); ?></button></p>
	</div>
	<div class="hidden wpo_min_log"><?php
	if ($file['log']) {
		WP_Optimize()->include_template(
			'minify/cached-file-log.php',
			false,
			array(
				'log' => $file['log'],
				'minify_config' => $minify_config,
			)
		);
	}
	?></div>
</li>