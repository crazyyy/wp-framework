<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<?php
$lazyload_options = $options->get_option('lazyload', array(
	'images' => false,
	'iframes' => false,
	'skip_classes' => '',
));

$read_more_link = 'https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/';

?>

<div id="wpo_lazy_load_settings">
	<h3 class="wpo-first-child"><?php esc_html_e('Lazy-load images', 'wp-optimize'); ?></h3>
	<div class="wpo-fieldgroup premium-only">
		<p>
			<?php
				$message = __('Lazy-loading is a technique that defers loading of non-critical resources (images, video) at page load time.', 'wp-optimize');
				$message .= ' ';
				$message .= __('Instead, these non-critical resources are loaded at the point they are needed (e.g. the user scrolls down to them).', 'wp-optimize');
				echo esc_html($message);
			?>
			<br>
			<?php $wp_optimize->wp_optimize_url($read_more_link, __('Follow this link to read more about lazy-loading images and video', 'wp-optimize')); ?>
		</p>
		<ul>
			<li><label><input type="checkbox" name="lazyload[images]" <?php checked($lazyload_options['images']); ?> disabled /><?php esc_html_e('Images', 'wp-optimize'); ?></label></li>
			<li><label><input type="checkbox" name="lazyload[iframes]" <?php checked($lazyload_options['iframes']); ?> disabled /><?php esc_html_e('Iframes and Videos', 'wp-optimize'); ?></label></li>
		</ul>

		<p>
			<?php esc_html_e('Skip image classes', 'wp-optimize');?><br>
			<input type="text" name="lazyload[skip_classes]" id="wpo_lazyload_skip_classes" value="<?php echo esc_attr($lazyload_options['skip_classes']); ?>" disabled readonly /><br>
			<?php
				$message = __('Enter the image class or classes comma-separated.', 'wp-optimize');
				$message .= ' ';
				$message .= __('Supports wildcards.', 'wp-optimize');
				$message .= ' ';
				$message .= __('Example: image-class1, image-class2, thumbnail*, ...', 'wp-optimize');
			?>
			<small><?php echo esc_html($message); ?></small>
		</p>

		<div class="wpo-unused-image-sizes__premium-mask">
			<a class="wpo-unused-images__premium-link" href="<?php echo esc_url($wp_optimize->premium_version_link); ?>" target="_blank"><?php esc_html_e('Enable Lazy-loading with WP-Optimize Premium.', 'wp-optimize'); ?></a>
		</div>
	</div>
</div>
