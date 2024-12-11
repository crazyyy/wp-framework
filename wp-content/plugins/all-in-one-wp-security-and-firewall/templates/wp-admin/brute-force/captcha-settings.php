<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<form action="" method="POST">
	<?php
	$templates = array(
		'wordpress-forms' => array(
			'title' => __('Wordpress forms', 'all-in-one-wp-security-and-firewall'),
		),
		'woo-captcha' => array(
			'title' => __('Woocommerce forms', 'all-in-one-wp-security-and-firewall'),
			'display_condition_callback' => array('AIOWPSecurity_Utility', 'is_woocommerce_plugin_active'),
		),
		'other-plugins' => array(
			'title' => __('Other forms', 'all-in-one-wp-security-and-firewall'),
			'display_condition_callback' => array('AIOWPSecurity_Utility', 'is_other_form_plugins_active'),
		),
	);
	wp_nonce_field('aiowpsec-captcha-settings-nonce');
	$aio_wp_security->include_template('wp-admin/brute-force/captcha-provider.php', false, array('default_captcha' => $default_captcha, 'supported_captchas' => $supported_captchas, 'captcha_themes' => $captcha_themes, 'captcha_theme' => $captcha_theme));

	$templates = apply_filters('aiowps_modify_captcha_settings_template', $templates);
	$subtab = isset($_GET['subtab']) ? sanitize_text_field($_GET['subtab']) : '';
	?>
	<div id="aios-captcha-options" <?php if ('none' === $default_captcha) echo 'class="aio_hidden"'; ?>>
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
						$title = $template['title'];
						$class = 'class="aiowps-template-list-item';
						$class .= ($key === $subtab || $title === $first_title) ? " aiowps-active" : '';
						$class .= '"';

						echo '<li data-template="' . esc_attr($key) . '" ' . $class . '><span class="aiowps-rule-title">' . esc_html($title) . '</span></li>';
					}
					?>
				</ul>
			</div>
			<div class="aiowps-settings">
				<?php
				foreach ($templates as $key => $template) {
					$aio_wp_security->include_template('wp-admin/brute-force/partials/' . esc_attr($key) . '.php');
				}
				?>
			</div>
		</div>
	</div>
	<div class="aiowps-actions">
		<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowpsec_save_captcha_settings');?>
	</div>
</form>