<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div class="wpo_section wpo_group">

<form id="analytics-form">
	<div id="wpo_settings_warnings"></div>
	<div class="wpo-fieldgroup wpo-show">
		<p class="wpo-description-show-links">
			<?php esc_html_e('Reduce the performance impact caused by analytics scripts.', 'wp-optimize'); ?>
			<?php esc_html_e('Serve Google Analytics (GA) scripts locally by selecting Gtag.js or choose a lightweight alternative to GA by selecting Minimal Analytics.', 'wp-optimize'); ?>
			<a href="<?php echo esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/faqs/category/Google-Analytics/')); ?>" target="_blank"><?php esc_html_e('More information about the Google Analytics feature here', 'wp-optimize'); ?></a>
		</p>
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
				<?php esc_html_e('Enable Google Analytics', 'wp-optimize');?>
			</label>
		</div>
		<div id="wpo-analytics-hidden-content" style="display:block">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="tracking_id"><?php esc_html_e('Tracking ID', 'wp-optimize');?></label></th>
						<td>
							<input name="tracking_id" id="tracking_id" type="text" value="<?php echo esc_attr($id); ?>" disabled="disabled">
							<p class="description"><a href="https://support.google.com/analytics/answer/9539598" target="_blank"><?php esc_html_e('Where to find Google Analytics tracking ID?', 'wp-optimize'); ?></a></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="analytics_method"><?php esc_html_e('Analytics Script', 'wp-optimize');?></label></th>
						<td>
							<select name="analytics_method" id="analytics_method" disabled="disabled">
								<option value="gtagv4" <?php selected($method, 'gtagv4'); ?>><?php esc_html_e('Gtag.js v4 (~52KB GZipped)', 'wp-optimize');?></option>
								<option value="minimal-analytics" <?php selected($method, 'minimal-analytics'); ?>><?php esc_html_e('Minimal Analytics.js (~3KB GZipped)', 'wp-optimize');?></option>
							</select>
							<p class="description"><a href="https://getwpo.com/faqs/category/Google-Analytics/#Which-one-should-I-use-Google-Analytics-or-Minimal-Analytics-" target="_blank"><?php esc_html_e('Which analytics script should I use?', 'wp-optimize'); ?></a></p>
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
