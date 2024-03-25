<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<div class="wpo-unused-images-section">
	<h3 class="wpo-first-child"><?php esc_html_e('Unused images', 'wp-optimize');?></h3>
	<div id="wpo_unused_images">
		<?php for ($i=0; $i < 10; $i++) : ?>
			<div class="wpo_unused_image">
				<label class="wpo_unused_image_thumb_label">
					<div class="thumbnail">
						<span class="dashicons dashicons-format-image"></span>
					</div>
				</label>
			</div>
		<?php endfor; ?>
		<div class="wpo-unused-images__premium-mask">
			<a class="wpo-unused-images__premium-link" href="<?php echo esc_url($wp_optimize->premium_version_link); ?>" target="_blank"><?php esc_html_e('Manage unused images with WP-Optimize Premium.', 'wp-optimize'); ?></a>
		</div>
	</div>
</div>

<div class="wpo-image-sizes-section">
	<h3><?php esc_html_e('Image sizes', 'wp-optimize'); ?></h3>
	<div class="wpo-fieldgroup premium-only">
		<h3><?php esc_html_e('Registered image sizes', 'wp-optimize'); ?></h3>
		<?php
			$message = __('This feature is for experienced users.', 'wp-optimize');
			$message .= ' ';
			$message .= __("Don't remove registered image sizes if you are not sure that images with selected sizes are not used on your site.", 'wp-optimize');
		?>
		<p class="red"><?php echo esc_html($message); ?></p>
		<div id="registered_image_sizes">
			<label class="unused-image-sizes__label">
				<input type="checkbox" class="unused-image-sizes">registered-image-size (42.2 KB - Total: 3)<br>
			</label>
			<label class="unused-image-sizes__label">
				<input type="checkbox" class="unused-image-sizes">registered-image-size (42.2 KB - Total: 3)<br>
			</label>
			<label class="unused-image-sizes__label">
				<input type="checkbox" class="unused-image-sizes">registered-image-size (42.2 KB - Total: 3)<br>
			</label>
		</div>
		<h3><?php esc_html_e('Unused image sizes', 'wp-optimize');?></h3>
		<p class="hide_on_empty">
			<?php esc_html_e('These image sizes were used by some of the themes or plugins installed previously and they remain within your database.', 'wp-optimize'); ?>
			<?php $wp_optimize->wp_optimize_url('https://codex.wordpress.org/Post_Thumbnails#Add_New_Post_Thumbnail_Sizes', __('Read more about custom image sizes here.', 'wp-optimize')); ?>
		</p>
		<div id="unused_image_sizes">
			<label class="unused-image-sizes__label">
				<input type="checkbox" class="unused-image-sizes">unused-image-size (42.2 KB - Total: 3)<br>
			</label>
			<label class="unused-image-sizes__label">
				<input type="checkbox" class="unused-image-sizes">unused-image-size (42.2 KB - Total: 3)<br>
			</label>
			<label class="unused-image-sizes__label">
				<input type="checkbox" class="unused-image-sizes">unused-image-size (42.2 KB - Total: 3)<br>
			</label>
		</div>
		<div class="wpo_remove_selected_sizes_btn__container">
			<button type="button" class="button button-primary" disabled="disabled"><?php esc_html_e('Remove selected sizes', 'wp-optimize'); ?></button>
		</div>
		<div class="wpo-unused-image-sizes__premium-mask">
			<a class="wpo-unused-images__premium-link" href="<?php echo esc_url($wp_optimize->premium_version_link); ?>" target="_blank"><?php esc_html_e('Take control of WordPress image sizes with WP-Optimize Premium.', 'wp-optimize'); ?></a>
		</div>
	</div>
</div>
