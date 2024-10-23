<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<?php
$fcp_link = 'https://getwpo.com/first-contentful-paint/';
$cls_link = 'https://getwpo.com/cumulative-layout-shift/';
?>

<div class="wpo-fieldgroup wpo-first-child dimensions-options">
	<div class="wpo-images-dimensions__premium-mask">
		<a class="wpo-images-dimensions__premium-link" href="<?php echo esc_url($wp_optimize->premium_version_link); ?>" target="_blank"><?php esc_html_e('Auto add images dimensions with WP-Optimize Premium.', 'wp-optimize'); ?></a>
	</div>
	<p class="wpo-images-dimension-show-links"><?php
	printf(esc_html__('WP-Optimize will automatically detect images with missing width or height, and add those attributes for improving %s and %s.', 'wp-optimize'),
		$wp_optimize->wp_optimize_url($fcp_link, __('First Contentful Paint time', 'wp-optimize'), '', '', true),
		$wp_optimize->wp_optimize_url($cls_link, __('Cumulative Layout Shift', 'wp-optimize'), '', '', true));
	?></p>
	<div class="switch-container">
		<label class="switch">
			<input name="images_dimensions" id="images_dimensions" class="dimensions-settings" type="checkbox">
			<span class="slider round"></span>
		</label>
		<label for="images_dimensions">
			<?php esc_html_e('Enable images dimensions', 'wp-optimize'); ?>
		</label>
	</div>
	<div>
		<p><?php esc_html_e('Skip image CSS classes', 'wp-optimize'); ?></p>
		<input type="text" name="image_dimensions_ignore_classes" id="image_dimensions_ignore_classes" value="<?php echo esc_attr($ignore_classes); ?>">
		<p><small><?php
		esc_html_e('Enter the image class or classes comma-separated.', 'wp-optimize');
		echo ' ';
		esc_html_e('Supports wildcards.', 'wp-optimize');
		echo ' ';
		esc_html_e('Example: image-class1, image-class2, thumbnail*, ...', 'wp-optimize');
		?>
		</small></p>
		
	</div>
	<p>
		<small><?php esc_html_e("For advanced users: use `data-no-image-dimensions` in image tags to bypass this feature.", 'wp-optimize'); ?></small>
	</p>
</div>