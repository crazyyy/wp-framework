<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('File protection', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		$info_msg = __('These features allow you to protect your files and assets.', 'all-in-one-wp-security-and-firewall');
		echo '<p>'.$info_msg.' '.__('By protecting your files and assets, you can help prevent nefarious users gain key information and protect your server\'s resources.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div id="aios-file-protection-settings-message" ></div>
<form action="" method="POST" id="aios-file-protection-settings-form">
	<?php
	$templates = array(
		'wp-file-access' => array(
			'title' => __('Delete default WP files', 'all-in-one-wp-security-and-firewall')
		),
		'prevent-hotlinks' => array(
			'title' => __('Prevent hotlinking', 'all-in-one-wp-security-and-firewall')
		),
		'php-file-editing' => array(
			'title' => __('Disable PHP file editing', 'all-in-one-wp-security-and-firewall')
		),
	);
	$templates = apply_filters('aiowps_modify_file_protection_template', $templates);
	$subtab = isset($_GET['subtab']) ? sanitize_text_field($_GET['subtab']) : '';
	?>
	<div class="aiowps-postbox-container">
		<div class="aiowps-rules">
			<h3 class="hndle"><?php _e('Settings', 'all-in-one-wp-security-and-firewall'); ?></h3>
			<div id="aiowps-rule-search">
				<span class="dashicons dashicons-search"></span>
				<input type="text" placeholder="<?php _e('Search', 'all-in-one-wp-security-and-firewall'); ?>" class="aiowps-search">
				<span class="dashicons dashicons-no-alt clear-search"></span>
			</div>
			<ul class="aiowps-rule-list">
				<?php
				if (empty($templates)) return;
				$first_template = reset($templates);
				$first_title = $first_template['title'];
				foreach ($templates as $key => $template) {
					// Check if the current title is the first title
					$is_active = ($key === $subtab || $template['title'] === $first_title) ? 'class="aiowps-active"' : '';
					$title = $template['title'];
					echo '<li data-template="' . esc_attr($key) . '" ' . $is_active . '><span class="aiowps-rule-title">' . esc_html($title) . '</span></li>';
				}
				?>
			</ul>
		</div>
		<div class="aiowps-settings">
			<?php
			foreach ($templates as $key => $template) {
				$aio_wp_security->include_template('wp-admin/filesystem-security/partials/' . $key . '.php', false, array('show_disallow_file_edit_warning' => $show_disallow_file_edit_warning));
			}
			?>
		</div>
	</div>
	<div class="aiowps-actions">
		<input type="submit" name="aiowps_save_file_protection" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
	</div>
</form>

