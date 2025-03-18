<?php if (!defined('WPO_VERSION'))  die('No direct access allowed'); ?>
<div id='wpo_section_css' class="wpo_section wpo_group">
	<div id="wpo_settings_warnings"></div>
	<form>
		<h3><?php esc_html_e('CSS options', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label for="enable_css_minification">
					<input
						name="enable_css_minification"
						type="checkbox"
						id="enable_css_minification"
						value="1"
						<?php echo checked($wpo_minify_options['enable_css_minification']); ?>
					>
					<?php esc_html_e('Enable minification of CSS files', 'wp-optimize'); ?>
				</label>
				<label for="enable_merging_of_css">
					<input
						name="enable_merging_of_css"
						type="checkbox"
						id="enable_merging_of_css"
						value="1"
						<?php echo checked($wpo_minify_options['enable_merging_of_css']); ?>
					>
					<?php esc_html_e('Enable merging of CSS files', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('If some of the design is breaking on the frontend, disabling merging of CSS might fix the issues.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
				<label for="inline_css">
					<input
						name="inline_css"
						type="checkbox"
						id="inline_css"
						value="1"
						<?php echo checked($wpo_minify_options['inline_css']); ?>
					>
					<?php esc_html_e('Inline CSS', 'wp-optimize'); ?> - <?php esc_html_e('Recommended if the CSS files are small enough.', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('When enabled, small CSS files will be inlined.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
				<label for="remove_print_mediatypes">
					<input
						name="remove_print_mediatypes"
						type="checkbox"
						id="remove_print_mediatypes"
						value="1"
						<?php echo checked($wpo_minify_options['remove_print_mediatypes']); ?>
					>
					<?php esc_html_e('Strip the "print" related stylesheets', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip='<?php esc_attr_e('When selected, any CSS files with the media type "print" will be removed.', 'wp-optimize');?> <?php esc_html_e('Enable if your site does not need specific print styles.', 'wp-optimize');?>'><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
				<?php if (WP_OPTIMIZE_SHOW_MINIFY_ADVANCED) : ?>
					<label for="remove_css">
						<input
							name="remove_css"
							type="checkbox"
							id="remove_css"
							value="1"
							<?php echo checked($wpo_minify_options['remove_css']); ?>
						>
						<?php esc_html_e('Dequeue all CSS files', 'wp-optimize'); ?>
						<span tabindex="0" data-tooltip="<?php esc_attr_e('This is useful if you want to test your critical path CSS', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
					</label>
				<?php endif; ?>
			</fieldset>
		</div>

		<h3><?php esc_html_e('Exclude the following CSS files from processing', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label class="wpo-label__bold" for="exclude_css">
					<?php esc_html_e('Any CSS files that match the paths below will be completely ignored.', 'wp-optimize'); ?>
					<br><?php esc_html_e('Use this if you are having issues with a specific CSS file', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('Any file present here will be loaded normally by WordPress', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
				</label>
				<textarea
					name="exclude_css"
					rows="7" cols="50"
					id="exclude_css"
					class="large-text code"
					placeholder="<?php esc_attr_e('e.g.: /bootstrap.css', 'wp-optimize'); ?>"
				><?php echo esc_textarea($wpo_minify_options['exclude_css']);?></textarea>
				<br>
				<?php esc_html_e('Some files known for causing issues when combined / minified are excluded by default.', 'wp-optimize'); ?> <?php esc_html_e('You can see / edit them in the Advanced tab.', 'wp-optimize'); ?>
			</fieldset>
		</div>

		<h3><?php esc_html_e('Load the following CSS files asynchronously', 'wp-optimize'); ?></h3>
		<div class="wpo-fieldgroup">
			<fieldset>
				<label class="wpo-label__bold" for="async_css">
					<?php esc_html_e('Any CSS files that match the paths below will be loaded asynchronously.', 'wp-optimize'); ?><br>
					<?php esc_html_e('Use this if you have a completely independent stylesheet', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e("e.g. You may want to exclude 'fontawesome' or other libraries from the initial load", 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
				</label>
				<textarea
					name="async_css"
					rows="7"
					cols="50"
					id="async_css"
					class="large-text code"
					placeholder="<?php esc_attr_e('e.g.: /wp-content/themes/my-theme/css/custom-font.css', 'wp-optimize'); ?>"
				><?php echo esc_textarea($wpo_minify_options['async_css']); ?></textarea>
				<label for="exclude_css_from_page_speed_tools">
					<input
							name="exclude_css_from_page_speed_tools"
							type="checkbox"
							id="exclude_css_from_page_speed_tools"
							value="1"
						<?php echo checked($wpo_minify_options['exclude_css_from_page_speed_tools']); ?>
					>
					<?php esc_html_e('Exclude stylesheets from page speed tests (PageSpeed Insights, GTMetrix...)', 'wp-optimize'); ?>
					<span tabindex="0" data-tooltip="<?php esc_attr_e('Use this only for testing purpose to find out which stylesheets are slowing down your site.', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span>
				</label>
			</fieldset>
		</div>

		<?php if (WP_OPTIMIZE_SHOW_MINIFY_ADVANCED) : ?>
			<h3><?php esc_html_e('Enable asynchronous CSS', 'wp-optimize'); ?></h3>
			<div class="wpo-fieldgroup">
				<fieldset>
					<label for="loadcss">
						<input
							name="loadcss"
							type="checkbox"
							id="loadcss"
							value="1"
							<?php echo checked($wpo_minify_options['loadcss']); ?>
						>
						<?php esc_html_e('Load all CSS files asynchronously', 'wp-optimize'); ?>
						<span tabindex="0" data-tooltip="<?php esc_attr_e('Note that inline CSS won\'t work if this is active', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
					</label>
					<p>
						<?php esc_html_e('If you have multiple css files per media type, they may load out of order and break your design when loaded asynchronously.', 'wp-optimize'); ?>
					</p>
				</fieldset>
			</div>
		<?php endif; ?>

		<?php if (WP_OPTIMIZE_SHOW_MINIFY_ADVANCED) : ?>
			<h3>
				<?php esc_html_e('Critical path CSS', 'wp-optimize'); ?>
			</h3>
			<div class="wpo-fieldgroup">
				<fieldset>
					<label class="wpo-label__bold" for="critical_path_css"><?php esc_html_e('Fallback CSS', 'wp-optimize'); ?></label>
					<textarea
						name="critical_path_css"
						rows="7"
						cols="50"
						id="critical_path_css" class="large-text code"
						placeholder=".css-code { display: block; }"
					><?php echo esc_textarea($wpo_minify_options['critical_path_css']); ?></textarea>
				</fieldset>

				<fieldset>
					<label class="wpo-label__bold" for="critical_path_css_is_front_page"><?php esc_html_e('is_front_page (conditional)', 'wp-optimize'); ?> <span tabindex="0" data-tooltip="<?php esc_attr_e('This will be inlined after the above if your page matches the WP conditional is_front_page()', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span></span></label>
					<textarea
						name="critical_path_css_is_front_page"
						rows="7"
						cols="50"
						id="critical_path_css_is_front_page"
						class="large-text code" 
						placeholder=".css-code { display: block; }"
					><?php echo esc_textarea($wpo_minify_options['critical_path_css_is_front_page']); ?></textarea>
				</fieldset>
			</div>
		<?php endif; ?>
		
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
