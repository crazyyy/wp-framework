<?php if (!defined('ABSPATH')) die('Access denied.'); ?>

<h2><?php _e('PHP firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" id="aios-php-firewall-settings-form">
	<?php

	$aio_wp_security->include_template('wp-admin/firewall/partials/xmlrpc-warning-notice.php');

	$templates = array(
		'xmlrpc-pingback-protection' => __('Security enhancements', 'all-in-one-wp-security-and-firewall'),
		'disable-rss-atom' => __('Feed control', 'all-in-one-wp-security-and-firewall'),
		'proxy-comment' => __('Comment protection', 'all-in-one-wp-security-and-firewall'),
		'bad-query-strings' => __('URL security', 'all-in-one-wp-security-and-firewall'),
		'advanced-character-filter' => __('String filtering', 'all-in-one-wp-security-and-firewall'),
	);

	$templates = apply_filters('aiowps_modify_php_firewall_rules_template', $templates);

	$subtab = isset($_GET['subtab']) ? sanitize_text_field($_GET['subtab']) : '';
	?>
	<div class="aiowps-postbox-container">
		<div class="aiowps-rules">
			<h3 class="hndle"><?php _e('Rules', 'all-in-one-wp-security-and-firewall'); ?></h3>
			<div id="aiowps-rule-search">
				<span class="dashicons dashicons-search"></span>
				<input type="text" placeholder="<?php _e('Search', 'all-in-one-wp-security-and-firewall'); ?>" class="aiowps-search">
				<span class="dashicons dashicons-no-alt clear-search"></span>
			</div>
			<ul class="aiowps-rule-list">
				<?php
				$first_title = reset($templates);
				
				foreach ($templates as $template => $title) {
					// Check if the current title is the first title
					$is_active = ($template === $subtab || $title === $first_title) ? 'class="aiowps-active"' : '';
					
					echo '<li data-template="' . esc_attr($template) . '" ' . $is_active . '><span class="aiowps-rule-title">' . esc_attr($title) . '</span></li>';
				}
				?>
			</ul>
		</div>
		<div class="aiowps-settings">
			<?php
			foreach ($templates as $template => $title) {
				$aio_wp_security->include_template('wp-admin/firewall/partials/' . $template . '.php');
			}
			?>
		</div>
	</div>
	<div class="aiowps-actions">
		<input type="submit" name="aiowps_apply_php_firewall_settings" value="<?php _e('Save PHP firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
	</div>
</form>
