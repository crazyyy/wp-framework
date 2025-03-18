<?php if (!defined('WPO_VERSION'))  die('No direct access allowed'); ?>
<div id='wpo_section_js' class="wpo_section wpo_group">
	<div id="wpo_settings_warnings"></div>
	<form>
		<h3><?php esc_html_e('JavaScript options', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label for="enable_js_minification">
					<input
						name="enable_js_minification"
						type="checkbox"
						id="enable_js_minification"
						value="1"
						<?php checked($wpo_minify_options['enable_js_minification']); ?>
					>
					<?php esc_html_e('Enable minification of JavaScript files', 'wp-optimize'); ?>
				</label>
				<label for="enable_merging_of_js">
					<input
						name="enable_merging_of_js"
						type="checkbox"
						id="enable_merging_of_js"
						value="1"
						<?php checked($wpo_minify_options['enable_merging_of_js']); ?>
					>
					<?php esc_html_e('Enable merging of JavaScript files', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('If some functionality is breaking on the frontend, disabling merging of JavaScript might fix the issues.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
				<label for="enable_js_trycatch">
					<input
						name="enable_js_trycatch"
						type="checkbox"
						id="enable_js_trycatch"
						value="1"
						<?php checked($wpo_minify_options['enable_js_trycatch']); ?>
					>
					<?php esc_html_e('Contain each included file in its own block', 'wp-optimize'); ?>
					<em><?php esc_html_e('(enable if trying to isolate a JavaScript error introduced by minifying or merging)', 'wp-optimize'); ?></em>
					<?php
						$message = __('When enabled, the content of each JavaScript file that is combined will be wrapped in its own "try / catch" statement.', 'wp-optimize');
						$message .= ' ';
						$message .= __('This means that if one file has an error, it should not impede execution of other, independent files.', 'wp-optimize');
					?>
					<span tabindex="0" data-tooltip="<?php echo esc_attr($message); ?>"><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
			</fieldset>
		</div>
		<h3><?php esc_html_e('Exclude JavaScript from processing', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label for="exclude_js">
					<?php esc_html_e('Any JavaScript files that match the paths below will be completely ignored', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('Use this if you are having issues with a certain JavaScript file.', 'wp-optimize'); ?> <?php esc_attr_e('Any file present here will be loaded normally by WordPress', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
				</label>
				<textarea
					name="exclude_js"
					rows="7" cols="50"
					id="exclude_js"
					class="large-text code"
					placeholder="<?php esc_attr_e('e.g.: /wp-includes/js/jquery/jquery.js', 'wp-optimize'); ?>"
				><?php echo esc_textarea($wpo_minify_options['exclude_js']);?></textarea>
				<br>
				<?php esc_html_e('Some files known for causing issues when combined / minified are excluded by default.', 'wp-optimize'); ?> <?php esc_html_e('You can see / edit them in the Advanced tab.', 'wp-optimize'); ?>
			</fieldset>
		</div>

		<h3><?php esc_html_e('Defer JavaScript', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset class="async-js-manual-list">
				<h4><label>
					<input
						name="enable_defer_js"
						type="radio" 
						value="individual"
						<?php checked($wpo_minify_options['enable_defer_js'], 'individual'); ?>
					>
					<?php esc_html_e('Asynchronously load selected JavaScript files', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('The files in the list will be loaded asynchronously, and will not be minified or merged.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
				</label>
				</h4>
				<div class="defer-js-settings">
					<label for="async_js">
						<?php esc_html_e('Any JavaScript files that match the paths below will be loaded asynchronously.', 'wp-optimize'); ?>
						<br>
						<?php esc_html_e('Use this if you have a completely independent script', 'wp-optimize'); ?>
						<?php
							$message = __('Independent scripts are for example \'analytics\' or \'pixel\' scripts.', 'wp-optimize');
							$message .= ' ';
							$message .= __('They are not required for the website to work', 'wp-optimize');
						?>
						<span tabindex="0" data-tooltip="<?php echo esc_attr($message);?>"><span class="dashicons dashicons-editor-help"></span></span>
					</label>
					<textarea
						name="async_js"
						rows="7"
						cols="50"
						id="async_js"
						class="large-text code"
						placeholder="<?php esc_attr_e('e.g.: /js/main.js', 'wp-optimize'); ?>"
					><?php echo esc_textarea($wpo_minify_options['async_js']); ?></textarea>
					<label for="exclude_js_from_page_speed_tools">
						<input
								name="exclude_js_from_page_speed_tools"
								type="checkbox"
								id="exclude_js_from_page_speed_tools"
								value="1"
								<?php checked($wpo_minify_options['exclude_js_from_page_speed_tools']); ?>
						>
						<?php esc_html_e('Exclude scripts from page speed tests (PageSpeed Insights, GTMetrix...)', 'wp-optimize'); ?>
						<span tabindex="0" data-tooltip="<?php esc_attr_e('Use this only for testing purpose to find out which scripts are slowing down your site.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
					</label>
				</div>
			</fieldset>
			
			<fieldset>
				<h4>
					<label>
						<input
							name="enable_defer_js"
							type="radio" 
							value="all"
							<?php checked($wpo_minify_options['enable_defer_js'], 'all'); ?>
						>
						<?php esc_html_e('Defer all the JavaScript files', 'wp-optimize'); ?>
						<span tabindex="0" data-tooltip="<?php esc_attr_e('All files - including the ones processed by WP-Optimize - will be deferred, except the ones in the exclusion list above.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
					</label>
				</h4>
				<div class="defer-js-settings">
					<div class="notice notice-warning below-h2">
						<p class="wpo_min-bold-green wpo_min-rowintro">
							<?php esc_html_e('Some themes and plugins need render blocking scripts to work.', 'wp-optimize'); ?> <?php esc_html_e('Please check the browser console for any eventual JavaScript errors caused by deferring the scripts.', 'wp-optimize'); ?>
						</p>
					</div>
					<h4><?php esc_html_e('Defer method:', 'wp-optimize'); ?></h4>
					<label>
						<input
							name="defer_js_type"
							type="radio" 
							value="defer"
							<?php checked($wpo_minify_options['defer_js_type'], 'defer'); ?>
						>
						<?php esc_html_e('Use the "defer" html attribute', 'wp-optimize'); ?>
						<span tabindex="0" data-tooltip="<?php esc_attr_e('Supported by all modern browsers.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
					</label>
					<label>
						<input
							name="defer_js_type"
							type="radio" 
							value="async_using_js"
							<?php checked($wpo_minify_options['defer_js_type'], 'async_using_js'); ?>
						>
						<?php esc_html_e('Defer using JavaScript', 'wp-optimize'); ?>
						<em>
							<?php
							   $message = '(';
							   $message .= esc_html__('Asynchronous loading.', 'wp-optimize');
							   $message .= ' ';
							   // translators: %1$s is a opening anchor tag, %2$s is a closing anchor tag
							   $message .= sprintf(esc_html__('Use this method if you require support for %1$solder browsers%2$s.', 'wp-optimize'), '<a href="https://www.w3schools.com/tags/att_script_defer.asp" target="_blank">', '</a>');
							   $message .= ')';
							   echo wp_kses_post($message);
							?>
						</em>
					</label>
					<label for="defer_jquery">
						<input
							name="defer_jquery"
							type="checkbox"
							id="defer_jquery"
							value="1"
							<?php checked($wpo_minify_options['defer_jquery']); ?>
						>
						<?php esc_html_e('Defer jQuery', 'wp-optimize'); ?> <em><?php esc_html_e('(Note that as jQuery is a common dependency, it probably needs to be loaded synchronously).', 'wp-optimize'); ?></em>
						<span tabindex="0" data-tooltip="<?php esc_attr_e('Disable this setting if you have an error \'jQuery undefined\'.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
					</label>
				</div>
			</fieldset>
		</div>

		<h3><?php esc_html_e('Delay JavaScript', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<h4><label>
					<input
						name="enable_delay_js"
						type="checkbox" 
						value="true"
						<?php checked($wpo_minify_options['enable_delay_js'], true); ?>
					>
					<?php esc_html_e('Delay JS', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('Delays JavaScript file loading until the user interacts with the page (e.g., mouse movement, scrolling, or touch), thereby improving page load performance', 'wp-optimize'); ?>"><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
				</h4>

				<h4><label>
					<input
						name="enable_preload_js"
						type="checkbox" 
						value="true"
						<?php checked($wpo_minify_options['enable_preload_js'], true); ?>
					>
					<?php esc_html_e('Preload JavaScript files', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('Preloads JavaScript files in parallel with other resources ahead of time, ensuring they are ready for faster execution without impacting the overall page load time', 'wp-optimize'); ?>"><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
				</h4>

				<label for="exclude_delay_js">
					<?php esc_html_e('Any JavaScript files that match the paths below will be completely ignored.', 'wp-optimize'); ?>
					<?php esc_html_e('It is also possible to exclude scripts by adding the "data-no-delay-js" attribute.', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('Use this if you are having issues with a specific JavaScript file.', 'wp-optimize'); ?> <?php esc_attr_e('Any file present here will be loaded normally by WordPress', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
				</label>
				<textarea
					name="exclude_delay_js"
					rows="7" cols="50"
					id="exclude_delay_js"
					class="large-text code"
					placeholder="<?php esc_attr_e('e.g.: /wp-includes/js/jquery/jquery.js', 'wp-optimize'); ?>"
				><?php echo esc_textarea($wpo_minify_options['exclude_delay_js']);?></textarea>
				<span>
					<?php
						esc_html_e('Use the wildcard * to similar JavaScript files.', 'wp-optimize');
						echo ' ';
						// translators: %1$s and %2$s are examples of path using the wildcards
						printf(esc_html_x('e.g. %1$s or %2$s', '%s are examples of path using the wildcard *', 'wp-optimize'), '<code>/js/*</code>', '<code>/jquery*.js</code>');
					?>
				</span>
			</fieldset>
		</div>

		<p class="submit">
			<input
				class="wp-optimize-save-minify-settings button button-primary"
				type="submit"
				value="<?php esc_attr_e('Save settings', 'wp-optimize'); ?>"
			>
			<img class="wpo_spinner" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- N/A ?>" alt="...">
			<span class="save-done dashicons dashicons-yes display-none"></span>
		</p>
	</form>
</div>
