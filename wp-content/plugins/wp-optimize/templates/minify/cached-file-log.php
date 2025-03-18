<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<?php
if (isset($log->error)) {
	?>
	<div class="wpo_min_file_error"><?php echo wp_kses_post($log->error); ?></div>
	<?php
	return;
}
?>

<h5><?php echo esc_html($log->header); ?></h5>
<ul><?php
foreach ((array) $log->files as $handle => $file) {
	$file_path = untrailingslashit(get_home_path()) . $file->url;
	$file_size = file_exists($file_path) ? ' (' . WP_Optimize()->format_size(@filesize($file_path)) . ')' : ''; // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress warning in case of file permission issues

	echo '<li'.($file->success ? '' : ' class="failed"').'><span class="wpo_min_file_url"><a href="'.esc_url(get_home_url().$file->url).'" target="_blank">'.esc_html($file->url).'</a>'.esc_html($file_size).'</span>';
	if (property_exists($file, 'debug')) echo '<span class="wpo_min_file_debug">'.esc_html($file->debug).'</span>';
	echo ' <span class="wrapper">';
	printf(' <a href="#" data-url="%1$s" class="exclude">%2$s</a>', esc_attr($file->url), esc_html__('Exclude', 'wp-optimize'));

	if (preg_match('/\.js$/i', $file->url, $matches)) {
		if ('individual' === $minify_config['enable_defer_js'] && (property_exists($file, 'uses_loading_strategy') && !$file->uses_loading_strategy)) {
			printf(' | <a href="#" data-url="%1$s" class="defer">%2$s</a>', esc_attr($file->url), esc_html__('Defer loading', 'wp-optimize'));
		}
	} elseif (preg_match('/\.css$/i', $file->url, $matches)) {
		printf(' | <a href="#" data-url="%1$s" class="async">%2$s</a>', esc_attr($file->url), esc_html__('Load asynchronously', 'wp-optimize'));
	}
	echo '</span></li>';
}
?>
</ul>
