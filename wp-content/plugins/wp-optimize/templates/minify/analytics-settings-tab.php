<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div class="wpo_section wpo_group">
<form id="analytics-form">
	<div id="wpo_settings_warnings"></div>
	<div class="wpo-fieldgroup wpo-show">
		<div class="switch-container">
			<label class="switch">
				<input
					name="enable_analytics"
					id="wpo_enable_analytics"
					class="wpo-save-setting"
					type="checkbox"
					value="1"
					<?php echo checked($is_enabled); ?>
					disabled="disabled"
				>
				<span class="slider round"></span>
			</label>
			<label for="wpo_enable_analytics">
				<?php esc_html_e('Enable Analytics', 'wp-optimize');?>
			</label>
		</div>
		<div id="wpo-analytics-hidden-content" style="display:block">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="tracking_id"><?php esc_html_e('Google Analytics Tracking ID', 'wp-optimize');?></label></th>
						<td>
							<input name="tracking_id" id="tracking_id" type="text" value="<?php echo esc_attr($id); ?>" disabled="disabled">
							<p class="description"><a href="https://support.google.com/analytics/answer/9539598" target="_blank"><?php esc_html_e('Where to find tracking ID?', 'wp-optimize'); ?></a></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="analytics_method"><?php esc_html_e('JavaScript method', 'wp-optimize');?></label></th>
						<td>
							<select name="analytics_method" id="analytics_method" disabled="disabled">
								<option value="gtagv4" <?php selected($method, 'gtagv4'); ?>><?php esc_html_e('Gtag.js v4 (91KB)', 'wp-optimize');?></option>
								<option value="minimal-analytics" <?php selected($method, 'minimal-analytics'); ?>><?php esc_html_e('Minimal Analytics.js (1.4KB)', 'wp-optimize');?></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="wpo-analytics__premium-mask">
		<a class="wpo-analytics__premium-link" href="<?php echo esc_url($wp_optimize->premium_version_link); ?>" target="_blank"><?php esc_html_e('Upgrade to WP-Optimize Premium to unlock advanced analytics feature.', 'wp-optimize'); ?></a>
	</div>
</form>
</div>
