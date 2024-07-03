<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div id="wpo_smush_settings">
	<div class="wpo-info">
		<a class="wpo-info__trigger" href="#"><span class="dashicons dashicons-sos"></span> <?php esc_html_e('How to use the image compression feature', 'wp-optimize'); ?> <span class="wpo-info__close"><?php esc_html_e('Close', 'wp-optimize'); ?></span></a>
		<div class="wpo-info__content">
			<p><strong><?php esc_html_e('Not sure how to use the image compression feature?', 'wp-optimize'); ?></strong> <br><?php esc_html_e('Watch our howto video below.', 'wp-optimize'); ?></p>
			<div class="wpo-video-preview">
				<a href="https://vimeo.com/333938451" data-embed="https://player.vimeo.com/video/333938451?color=df6926&title=0&byline=0&portrait=0" target="_blank"><img src="<?php echo esc_url(trailingslashit(WPO_PLUGIN_URL) . 'images/notices/image-compression-video-preview.png'); ?>" alt="<?php esc_attr_e('Video preview', 'wp-optimize'); ?>" /></a>
			</div>
			<small>(<?php esc_html_e('Loads a video hosted on vimeo.com', 'wp-optimize'); ?>) - <?php $wp_optimize->wp_optimize_url('https://vimeo.com/333938451', __('Open the video in a new window', 'wp-optimize')); ?></small>
		</div>
	</div>
	<p>
		<?php
			printf(__('Note: Image optimization feature is offered via %s free API', 'wp-optimize'), '<a href="https://resmush.it/" target="_blank">reSmush.it</a>');
		?>
	</p>
	<div class="wpo-fieldgroup">
		<div class="autosmush wpo-fieldgroup__subgroup<?php echo $smush_options['autosmush'] ? ' active' : ''; ?>">
			<label class="switch" for="smush-automatically">
				<input type="checkbox" id="smush-automatically" <?php checked($smush_options['autosmush']); ?> >
				<span class="slider round"></span>
			</label>
			<label for="smush-automatically"><?php esc_html_e('Automatically compress newly-added images', 'wp-optimize');?>
				<span tabindex="0" data-tooltip="<?php echo esc_attr__('The images will be added to a background queue, which will start automatically within the next hour.', 'wp-optimize').' '.esc_attr__('This prevents the site from being slowed down during media uploads.', 'wp-optimize').' '.esc_attr__('The time taken to complete the compression will depend upon the size and quantity of the images.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
			</label>
		</div>

		<div class="wpo-fieldgroup__subgroup">
			<label class="switch">
				<input type="checkbox" id="smush-show-metabox" class="smush-options" <?php checked($smush_options['show_smush_metabox']); ?> > 
				<span class="slider round"></span>
			</label>
			<label for="smush-show-metabox" class="smush-options">
				<?php
					esc_html_e('Show compression meta-box on an image\'s dashboard media page.', 'wp-optimize');
					$message = __('The image compression metabox allows you to compress specific images from the media library.', 'wp-optimize');
					$message .= ' ';
					$message .= __('But if you are using a solution other than WP-Optimize to compress your images, you can hide these metaboxes by disabling this switch.', 'wp-optimize')
				?>
				<span tabindex="0" data-tooltip="<?php echo esc_attr($message);?>"><span class="dashicons dashicons-editor-help"></span> </span>
			</label>
		</div>

		<div class="compression_options">
			<h3><?php esc_html_e('Compression options', 'wp-optimize');?></h3>
			<input type="radio" id="enable_lossy_compression" name="compression_level" <?php checked($smush_options['image_quality'], 60); ?> class="smush-options compression_level"> 
			<label for="enable_lossy_compression"><?php esc_html_e('Prioritize maximum compression', 'wp-optimize');?></label>
			<?php
				$message = __('Uses lossy compression to ensure maximum savings per image.', 'wp-optimize');
				$message .= ' ';
				$message .= __('The resulting images are of a slightly lower quality', 'wp-optimize');
			?>
			<span tabindex="0" data-tooltip="<?php echo esc_attr($message); ?>"><span class="dashicons dashicons-editor-help"></span> </span>
			<br>
			<input type="radio" id="enable_lossless_compression" <?php checked($smush_options['image_quality'], 92); ?>name="compression_level" class="smush-options compression_level">
			<label for="enable_lossless_compression"><?php esc_html_e('Prioritize retention of detail', 'wp-optimize');?></label>
			<span tabindex="0" data-tooltip="<?php esc_attr_e('Uses lossless compression, which results in much better image quality but lower file size savings per image', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
			<br>
			<input id="enable_custom_compression" <?php checked($custom); ?> type="radio" name="compression_level" class="smush-options compression_level"> 
			<label for="enable_custom_compression"><?php esc_html_e('Custom', 'wp-optimize');?></label>
			<br>
			<div class="smush-options custom_compression" <?php if (!$custom) echo 'style="display:none;"';?> >
				<span class="slider-start"><?php esc_html_e('Maximum compression', 'wp-optimize');?></span>
				<input id="custom_compression_slider" class="compression_level" data-max="<?php esc_attr_e('Maximum Compression', 'wp-optimize'); ?>"  type="range" step="5" value="<?php echo esc_attr($smush_options['image_quality']); ?>" min="65" max="90" list="number" />
				<datalist id="number">
					<option value="65"/>
					<option value="70"/>
					<option value="75"/>
					<option value="80"/>
					<option value="85"/>
					<option value="90"/>
				</datalist>
				<span class="slider-end"><?php esc_html_e('Best image quality', 'wp-optimize');?></span>
			</div>
			<p><?php esc_html_e('Not sure what to choose?', 'wp-optimize'); ?> <?php $wp_optimize->wp_optimize_url('https://getwpo.com/lossy-vs-lossless-image-compression-a-guide-to-the-trade-off-between-image-size-and-quality/', __('Read our article "Lossy vs Lossless image compression"', 'wp-optimize')); ?></p>

			<?php if (WPO_USE_WEBP_CONVERSION) : ?>
				<h3><?php esc_html_e('WebP conversion', 'wp-optimize');?></h3>

				<?php if ($does_server_allows_local_webp_conversion) : ?>
					<input type="checkbox" id="enable_webp_conversion" name="webp_conversion" <?php checked($smush_options['webp_conversion']); ?> class="smush-options webp_conversion">
					<label for="enable_webp_conversion"><?php esc_html_e('Create WebP version of image', 'wp-optimize');?></label>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('Creates WebP image format and serves it whenever possible.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
					<br>

					<?php
						$converters = WP_Optimize()->get_options()->get_option('webp_converters', false);
						if ($smush_options['webp_conversion'] && !empty($converters)) {
							printf('<p>%1$s <strong>%2$s</strong></p>', esc_html__('Available WebP conversion tools:', 'wp-optimize'),  esc_html(implode(', ', $converters)));
						}
					?>
				<?php else: ?>
					<?php printf('<p>%1$s</p>', esc_html__('Note: Local WebP conversion tools are not allowed on your server.', 'wp-optimize')); ?>
				<?php endif; ?>

			<?php endif; ?>
		</div>
		<button type="button" class="button button-link wpo-toggle-advanced-options"><span class="text"><span class="dashicons dashicons-arrow-down-alt2"></span> <span class="wpo-toggle-advanced-options__text-show"><?php esc_html_e('Show advanced options', 'wp-optimize');?></span><span class="wpo-toggle-advanced-options__text-hide"><?php esc_html_e('Hide advanced options', 'wp-optimize');?></span></span></button>
		<div class="smush-advanced wpo-advanced-options">
			<?php if ($does_server_allows_local_webp_conversion && !empty($converters)) : ?>
			<button type="button" id="wpo_reset_webp_serving_method" class="wpo_primary_small button"><?php esc_html_e('Reset WebP serving method', 'wp-optimize'); ?></button>
			<span id="wpo_reset_webp_serving_method_done" class="display-none"><span class="dashicons dashicons-yes"></span> <?php esc_html_e('The WebP serving method has been reset', 'wp-optimize');?></span>
			<?php endif; ?>
			<div class="compression_server">
				<h3><?php esc_html_e('Compression service', 'wp-optimize');?></h3>
				<div> <input type="radio" name="compression_server" id="resmushit" value="resmushit" <?php checked($smush_options['compression_server'], 'resmushit'); ?> >			  
				<label for="resmushit">
					<h4><?php esc_html_e('reSmush.it', 'wp-optimize');?></h4>
					<p><?php esc_html_e('Can keep EXIF data', 'wp-optimize');?></p>
					<small><?php esc_html_e('Service provided by reSmush.it', 'wp-optimize'); ?></small>
				  </label>
				</div>
			</div>
			<br>
			<h3><?php esc_html_e('More options', 'wp-optimize');?></h3>
			<div class="image_options">
				<input type="checkbox" id="smush-preserve-exif" class="smush-options preserve_exif" <?php checked($smush_options['preserve_exif']); ?> >
				<label for="smush-preserve-exif" class="smush-options preserve_exif"><?php esc_html_e('Preserve EXIF data', 'wp-optimize');?></label>
				<br>
				<input type="checkbox" id="smush-backup-original" class="smush-options" <?php checked($smush_options['back_up_original']); ?> > 
				<label for="smush-backup-original"><?php esc_html_e('Backup original images', 'wp-optimize');?></label>
				<span tabindex="0" data-tooltip="<?php esc_attr_e('The original images are stored alongside the compressed images, you can visit the edit screen of the individual images in the Media Library to restore them.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
				<br>
				<input type="checkbox" id="smush-backup-delete" class="smush-options" <?php checked($smush_options['back_up_delete_after']); ?> >
				<label for="smush-backup-delete"><?php esc_html_e('Automatically delete image backups after', 'wp-optimize');?><input id="smush-backup-delete-days" type="number" min="1" value="<?php echo (0 !== intval($smush_options['back_up_delete_after_days'])) ? intval($smush_options['back_up_delete_after_days']) : 50; ?>"><?php esc_html_e('days', 'wp-optimize');?></label><label> — <?php esc_html_e('or', 'wp-optimize'); ?></label> <button type="button" id="wpo_smush_delete_backup_btn" class="wpo_primary_small button"><?php esc_html_e('Delete all backup images now', 'wp-optimize'); ?></button>
				<img id="wpo_smush_delete_backup_spinner" class="display-none" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="...">
				<span id="wpo_smush_delete_backup_done" class="dashicons dashicons-yes display-none save-done"></span>
				<br>
				<button type="button" id="wpo_smush_mark_all_as_uncompressed_btn" class="wpo_primary_small button"><?php esc_html_e('Mark all images as uncompressed', 'wp-optimize'); ?></button>
				<br>
				<br>
				<button type="button" id="wpo_smush_restore_all_compressed_images_btn" class="wpo_primary_small button"><?php esc_html_e('Restore all compressed images', 'wp-optimize'); ?></button>
				<?php
					$message = __('Only the original image will be restored.', 'wp-optimize');
					$message .= ' ';
					$message .= __('In order to restore the other sizes, you should use a plugin such as "Regenerate Thumbnails".', 'wp-optimize');
				?>
					<span tabindex="0" data-tooltip="<?php echo esc_attr($message);?>"><span class="dashicons dashicons-editor-help"></span> </span>
			</div>
		</div>
		<div class="save-options">
			<img id="wpo_smush_images_save_options_spinner" class="display-none" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="...">
			<span id="wpo_smush_images_save_options_done" class="display-none"><span class="dashicons dashicons-yes"></span> <?php esc_html_e('Saved options', 'wp-optimize');?></span>
			<span id="wpo_smush_images_save_options_fail" class="display-none"><span class="dashicons dashicons-no"></span> <?php esc_html_e('Failed to save options', 'wp-optimize');?></span>
		</div>
	</div>

	<div class="uncompressed-images">
		<h3><?php esc_html_e('Uncompressed images', 'wp-optimize');?></h3>
		<?php if (is_multisite()) : ?>
			<div id="wpo_uncompressed_images_sites_select_container">
				<label for="wpo_uncompressed_images_sites_select"><?php esc_html_e('Select site', 'wp-optimize');?> </label>
				<select id="wpo_uncompressed_images_sites_select">
					<?php foreach ($sites as $site) : ?>
					<option value="<?php echo esc_attr($site->blog_id); ?>"><?php echo esc_html($site->domain . $site->path); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>
		<div class="wpo_smush_images_buttons_wrap">
			<div class="smush-select-actions. align-left">
				<a href="javascript:;" id="wpo_smush_images_select_all"><?php esc_html_e('Select all', 'wp-optimize');?></a> /
				<a href="javascript:;" id="wpo_smush_images_select_none"><?php esc_html_e('Select none', 'wp-optimize');?></a>
			</div>
			<div class="smush-refresh-icon align-right">
				<a href="javascript:;" id="wpo_smush_images_refresh" class="wpo-refresh-button"><?php esc_html_e('Refresh image list', 'wp-optimize');?> 
					<span class="dashicons dashicons-image-rotate"></span>
				</a>
				<img class="wpo_smush_images_loader" width="16" height="16" src="<?php echo esc_url(admin_url('/images/spinner-2x.gif')); ?>" />
			</div>
		</div>
		<div id="wpo_smush_images_grid"></div>
		<div class="smush-actions">
			<input type="button" id="wpo_smush_images_btn" class="wpo_primary_small button-primary align-left" value="<?php esc_attr_e('Compress the selected images', 'wp-optimize'); ?>" />
			<input type="button" id="wpo_smush_mark_as_compressed" class="wpo_primary_small button align-left" value="<?php esc_attr_e('Mark as already compressed', 'wp-optimize'); ?>" />
			<input type="button" id="wpo_smush_get_logs" class="wpo_smush_get_logs wpo_primary_small button-primary align-right" value="<?php esc_attr_e('View logs', 'wp-optimize'); ?>" />
		</div>
	</div>
</div>
