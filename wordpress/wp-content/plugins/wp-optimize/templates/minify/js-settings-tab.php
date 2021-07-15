<?php if (!defined('WPO_VERSION'))  die('No direct access allowed'); ?>
<div class="wpo_section wpo_group<?php echo (!$wpo_minify_options['enable_js']) ? ' wpo-feature-is-disabled' : ''; ?>">
	<div id="wpo_settings_warnings"></div>
		
	<div class="wpo-fieldgroup wpo-show">
		<div class="wpo-fieldgroup__subgroup wpo_min_enable_minify">
			<div class="switch-container">
				<label class="switch">
					<input
						name="enable_js"
						id="wpo_min_enable_minify_js"
						class="wpo-save-setting"
						type="checkbox"
						value="true"
						<?php checked($wpo_minify_options['enable_js']);?>
					>
					<span class="slider round"></span>
				</label>
				<label for="wpo_min_enable_minify_js">
					<?php _e('Enable Minify for JavaScript files', 'wp-optimize'); ?>
					<b tabindex="0" data-tooltip="<?php esc_attr_e('The JavaScript files will be combined and minified to lower the number and size of requests.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </b>
				</label>
			</div>
		</div>
	</div>

	<form>
		<h3><?php _e('JavaScript options', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label for="enable_js_minification">
					<input
						name="enable_js_minification"
						type="checkbox"
						id="enable_js_minification"
						value="1"
						<?php echo checked($wpo_minify_options['enable_js_minification']); ?>
					>
					<?php _e('Enable minification of JavaScript files', 'wp-optimize'); ?>
					<b tabindex="0" data-tooltip="<?php esc_attr_e('If disabled, the JavaScript files will be merged but not minified', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </b>
				</label>
			</fieldset>
		</div>
		<h3><?php _e('Exclude JavaScript from processing', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label for="exclude_js">
					<?php _e('Any JavaScript files that match the paths below will be completely ignored', 'wp-optmize'); ?>
					<b tabindex="0" data-tooltip="<?php esc_attr_e('Use this if you are having issues with a certain JavaScript file.', 'wp-optmize'); ?> <?php esc_attr_e('Any file present here will be loaded normally by WordPress', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></b>
				</label>
				<textarea
					name="exclude_js"
					rows="7" cols="50"
					id="exclude_js"
					class="large-text code"
					placeholder="ex: /wp-includes/js/jquery/jquery.js"
				><?php echo esc_textarea($wpo_minify_options['exclude_js']);?></textarea>
				<br>
				<?php _e('Some files known for causing issues when combined / minified are excluded by default.', 'wp-optimize'); ?> <?php _e('You can see / edit them in the Advanced tab.', 'wp-optimize'); ?>
			</fieldset>
		</div>

		<?php if (WP_OPTIMIZE_SHOW_MINIFY_ADVANCED) : ?>
			<h3><?php _e('Render-blocking JavaScript', 'wp-optimize'); ?></h3>
			<div class="wpo-fieldgroup">
				<p class="wpo_min-bold-green wpo_min-rowintro">
					<?php _e('Some themes and plugins "need" render blocking scripts to work, so please take a look at the dev console for errors.', 'wp-optimize'); ?>
				</p>
				<fieldset>
					<legend class="screen-reader-text">
						<?php _e('Render-blocking', 'wp-optimize'); ?>
					</legend>
					<label for="enable_defer_js">
						<input
							name="enable_defer_js"
							type="checkbox"
							id="enable_defer_js"
							value="1"
							<?php echo checked($wpo_minify_options['enable_defer_js']); ?>
						>
						<?php _e('Enable defer on processed JavaScript files', 'wp-optimize'); ?>
						<b tabindex="0" data-tooltip="<?php _e('Not all browsers, themes or plugins support this. Beware of broken functionality and design', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></b>
					</label>
					<label for="exclude_defer_login">
						<input
							name="exclude_defer_login"
							type="checkbox"
							id="exclude_defer_login"
							value="1"
							<?php echo checked($wpo_minify_options['exclude_defer_login']); ?>
						>
						<?php _e('Skip deferring JavaScript on the login page', 'wp-optimize'); ?>
						<b tabindex="0" data-tooltip="<?php _e('If selected, it will disable JavaScript deferring on your login page', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></b>
						</span>
					</label>
					<label for="defer_for_pagespeed">
						<input
							name="defer_for_pagespeed"
							type="checkbox" 
							id="defer_for_pagespeed"
							value="1"
							<?php echo checked($wpo_minify_options['defer_for_pagespeed']); ?>
						>
						<?php _e('Load all JavaScript files asynchronously apart from Jquery', 'wp-optimize'); ?>
						<b tabindex="0" data-tooltip="<?php esc_attr_e('As jQuery is a common dependancy, it is loaded synchronously to stop \'jquery undefined\' errors', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></b>
					</label>
				</fieldset>
			</div>
		<?php endif; ?>

		<h3><?php _e('Load JavaScript asynchronously', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label for="async_js">
					<?php _e('Any JavaScript files that match the paths below will be loaded asynchronously.', 'wp-optmize'); ?>
					<br/>
					<?php _e('Use this if you have a completely independent script or would like to exclude scripts from page speed tests (PageSpeed Insights, GTMetrix...)', 'wp-optmize'); ?>
					<b tabindex="0" data-tooltip="<?php esc_attr_e('Independent scripts are for example \'analytics\' or \'pixel\' scripts. They are not required for the website to work', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></b>
				</label>
				<textarea
					name="async_js"
					rows="7"
					cols="50"
					id="async_js"
					class="large-text code"
					placeholder="ex: /js/main.js"
				><?php echo $wpo_minify_options['async_js']; ?></textarea>
			</fieldset>
		</div>

		<p class="submit">
			<input
				class="wp-optimize-save-minify-settings button button-primary"
				type="submit"
				value="<?php esc_attr_e('Save settings', 'wp-optimize'); ?>"
			>
			<img class="wpo_spinner" src="<?php echo esc_attr(admin_url('images/spinner-2x.gif')); ?>" alt="...">
			<span class="save-done dashicons dashicons-yes display-none"></span>
		</p>
	</form>
</div>
