<?php
/**
 * Settings Page Markup
 */
?>

<div class="wrap">

	<div id="icon-upload" class="icon32"></div>
	<h2><?php esc_html_e( 'SVG Support Settings and Usage', 'svg-support' ); ?><span class="svgs-version">Version <?php echo esc_attr(BODHI_SVGS_VERSION); ?></span></h2>

	<div id="poststuff">

		<div class="meta-box-sortables ui-sortable">

			<div class="postbox">

				<h3><span><?php esc_html_e( 'Introduction', 'svg-support' ); ?></span></h3>
				<div class="inside">

				<p>
					<?php esc_html_e( 'When using SVG images on your WordPress site, it can be hard to style elements within the SVG using CSS.', 'svg-support' ); ?>
					<strong><?php esc_html_e( 'Now you can, easily!', 'svg-support' ); ?></strong>
				</p>
				<p>
					<?php esc_html_e( 'When you enable advanced mode, this plugin not only provides SVG Support like the name says, it also allows you to easily embed your full SVG file\'s code using a simple IMG tag. By adding the class', 'svg-support' ); ?>
					<code><?php esc_html_e( 'style-svg', 'svg-support' ); ?></code>
					<?php esc_html_e( 'to your IMG elements, this plugin dynamically replaces any IMG elements containing the', 'svg-support' ); ?>
					<code><?php esc_html_e( 'style-svg', 'svg-support' ); ?></code>
					<?php esc_html_e( 'class with your complete SVG.', 'svg-support' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'The main purpose of this is to allow styling of SVG elements. Usually your styling options are restricted when using', 'svg-support' ); ?>
					<code><?php esc_html_e( 'embed', 'svg-support' ); ?></code>,
					<code><?php esc_html_e( 'object', 'svg-support' ); ?></code>,
					<?php esc_html_e( 'or', 'svg-support' ); ?>
					<code><?php esc_html_e( 'img', 'svg-support' ); ?></code>
					<?php esc_html_e( 'tags alone.', 'svg-support' ); ?>
				</p>
				<p>
					<strong><?php esc_html_e( 'For help and more information, please check the help tab (top right of your screen).', 'svg-support' ); ?></strong>
				</p>

				</div> <!-- .inside -->

			</div> <!-- .postbox -->

		</div> <!-- .meta-box-sortables .ui-sortable -->

		<div class="meta-box-sortables ui-sortable">

			<div class="postbox">

				<h3><span><?php esc_html_e( 'Send Some Love', 'svg-support' ); ?></span></h3>
				<div class="inside">

					<p><?php esc_html_e( 'SVG Support has grown to be installed on 1,000,000+ active websites. That\'s insane! It\'s developed and maintained by one person alone. If you find it useful, please consider donating to help keep it going. I truly appreciate any contribution.', 'svg-support' ); ?></p>
					<p><strong>
						<?php esc_html_e( 'BTC: 1qF8r2HkTLifND7WLGfWmvxfXc9ze55DZ', 'svg-support' ); ?><br/>
						<?php esc_html_e( 'ETH: 0x599695Eb51aFe2e5a0DAD60aD9c89Bc8f10B54f4', 'svg-support' ); ?>
					</strong></p>
					<p><?php esc_html_e( 'You can also', 'svg-support' ); ?> <a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z9R7JERS82EQQ&source=url"><?php esc_html_e( 'Donate using PayPal', 'svg-support' ); ?></a></p>

				</div> <!-- .inside -->

			</div> <!-- .postbox -->

		</div> <!-- .meta-box-sortables .ui-sortable -->

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h3><span><?php esc_html_e( 'Settings', 'svg-support' ); ?></span></h3>
						<div class="inside">

							<form name="bodhi_svgs_settings_form" method="post" action="options.php">

								<?php settings_fields('bodhi_svgs_settings_group'); ?>

								<table class="form-table svg-settings">

									<tr valign="top">
										<th scope="row">
											<strong><?php esc_html_e( 'Restrict SVG Uploads to?', 'svg-support' ); ?></strong>
										</th>
										<td>
											<div class="upload_allowed_roles">
												<?php $allowed_roles_array = $bodhi_svgs_options['restrict']; ?>
												<select style="display:none" name="bodhi_svgs_settings[restrict][]" multiple>
												<?php
													global $wp_roles;
													$all_roles = $wp_roles->roles;
													foreach ($all_roles as $role => $details) {
														$user_role_slug = esc_attr($role);
														$user_role_name = translate_user_role($details['name']);
														$role_selected = in_array($user_role_slug, $allowed_roles_array) ? 'selected' : '';
													?>
													<option value="<?php echo esc_attr($user_role_slug); ?>" <?php echo esc_attr($role_selected); ?>><?php echo esc_html($user_role_name); ?></option>
												<?php } ?>
												</select>
											</div>
											<small class="description"><?php esc_html_e('Select the user roles that are allowed to upload SVG files.', 'svg-support' ); ?></small>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row">
											<strong><?php esc_html_e( 'Do not sanitize for these roles', 'svg-support' ); ?></strong>
										</th>
										<td>
											<div class="sanitize_on_upload_roles">
												<?php
													global $wp_roles;
													$all_roles = $wp_roles->roles;  // Fetch all available roles
													$sanitize_roles_array = $bodhi_svgs_options['sanitize_on_upload_roles'];
												?>
												<select name="bodhi_svgs_settings[sanitize_on_upload_roles][]" multiple>
												<?php
													foreach ($all_roles as $role => $details) {
														$user_role_slug = esc_attr($role);
														$user_role_name = translate_user_role($details['name']);
														$role_selected = in_array($user_role_slug, $sanitize_roles_array) ? 'selected' : '';
												?>
													<option value="<?php echo esc_attr($user_role_slug); ?>" <?php echo esc_attr($role_selected); ?>><?php echo esc_html($user_role_name); ?></option>
												<?php } ?>
												</select>
											</div>
											<small class="description"><?php esc_html_e('Select the user roles that should bypass SVG sanitization.', 'svg-support' ); ?></small>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row">
											<strong><?php esc_html_e( 'Sanitize SVG on Front-end', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[sanitize_svg_front_end]">
												<input id="bodhi_svgs_settings[sanitize_svg_front_end]" name="bodhi_svgs_settings[sanitize_svg_front_end]" type="checkbox" <?php checked( $bodhi_svgs_options['sanitize_svg_front_end'], 'on' ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('Enhance security by sanitizing svg images on Front-end. This will help to prevent XSS and Injection attacks.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row">
											<label for="bodhi_svgs_settings[minify_svg]"><strong><?php esc_html_e( 'Minify SVG', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[minify_svg]">
												<input id="bodhi_svgs_settings[minify_svg]" name="bodhi_svgs_settings[minify_svg]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['minify_svg'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('Enabling this option will auto-minify all svg uploads.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row">
											<strong><?php esc_html_e( 'Load frontend CSS?', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[frontend_css]">
												<input id="bodhi_svgs_settings[frontend_css]" name="bodhi_svgs_settings[frontend_css]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['frontend_css'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('A very small piece of code that helps with displaying SVGs on the frontend in some cases.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row">
											<strong><?php esc_html_e( 'Enable Advanced Mode?', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[advanced_mode]">
												<input id="bodhi_svgs_settings[advanced_mode]" name="bodhi_svgs_settings[advanced_mode]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['advanced_mode'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('You don\'t need to enable this to simply use SVG files as images. Enabling this will trigger advanced options and SVG functionality such as inline rendering.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<h3 class="inner-title"><?php esc_html_e( 'Advanced', 'svg-support' ); ?></h3>
										</th>
										<td>
											<hr>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<strong><?php esc_html_e( 'CSS Class to target', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[css_target]">
												<input id="bodhi_svgs_settings[css_target]" class="all-options code" name="bodhi_svgs_settings[css_target]" type="text" value="<?php echo isset( $bodhi_svgs_options['css_target'] ) ? esc_attr($bodhi_svgs_options['css_target']) : ''; ?>"><br />
												<small class="description">
													<?php esc_html_e( 'The default target class is', 'svg-support' ); ?>
													<code><?php echo esc_html( 'style-svg' ); ?></code>.
													<?php esc_html_e( 'You can change it to your own class such as', 'svg-support' ); ?>
													<code><?php echo esc_html( 'my-class' ); ?></code>
													<?php esc_html_e( 'by typing it here. Leave blank to use the default class.', 'svg-support' ); ?>
													<br>
													<em><?php esc_html_e( 'Plugin can now go any level down to find your SVG! It will keep looking as long as the element with the target class has children. If it finds any IMG tags with .svg in the src URL, it will replace the IMG tag with your SVG code.', 'svg-support' ); ?></em>
												</small>
											</label>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<strong><?php esc_html_e( 'Skip Nested SVGs', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[skip_nested_svg]">
												<input id="bodhi_svgs_settings[skip_nested_svg]" name="bodhi_svgs_settings[skip_nested_svg]" type="checkbox" value="1" <?php checked( isset( $bodhi_svgs_options['skip_nested_svg'] ) && $bodhi_svgs_options['skip_nested_svg'] == 1 ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?>
												<br><small class="description"><?php esc_html_e( 'When enabled, only the first SVG in a .style-svg container will be inlined. Useful for Gutenberg Cover blocks with nested SVG images.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<strong><?php esc_html_e( 'Output JS in Footer?', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[js_foot_choice]">
												<input id="bodhi_svgs_settings[js_foot_choice]" name="bodhi_svgs_settings[js_foot_choice]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['js_foot_choice'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('Normally, scripts are placed in head of the HTML document. If "Yes" is selected, the script is placed before the closing body tag. This requires the theme to have the wp_footer() template tag in the appropriate place.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<strong><?php esc_html_e( 'Use Vanilla JS?', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[use_vanilla_js]">
												<input id="bodhi_svgs_settings[use_vanilla_js]" name="bodhi_svgs_settings[use_vanilla_js]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['use_vanilla_js'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('Checking this will use vanilla JS file instead of the jQuery.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<strong><?php esc_html_e( 'Use Expanded JS?', 'svg-support' ); ?></strong>
										</th>
										<td>
											<label for="bodhi_svgs_settings[use_expanded_js]">
												<input id="bodhi_svgs_settings[use_expanded_js]" name="bodhi_svgs_settings[use_expanded_js]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['use_expanded_js'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('Checking this will use the expanded JS file instead of the minified JS file. Useful if you want to minify this externally using a caching plugin or similar.', 'svg-support' ); ?></small>
											</label>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<h3 class="inner-title"><?php esc_html_e( 'Legacy Settings', 'svg-support' ); ?></h3>
										</th>
										<td>
											<hr>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<strong><?php esc_html_e( 'Force Inline SVG?', 'svg-support' ); ?></strong></label>
										</th>
										<td>
											<label for="bodhi_svgs_settings[force_inline_svg]">
												<input id="bodhi_svgs_settings[force_inline_svg]" name="bodhi_svgs_settings[force_inline_svg]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['force_inline_svg'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br />
												<small class="description">
													<strong><?php esc_html_e( 'Use with caution!', 'svg-support' ); ?></strong>
													<?php esc_html_e( 'Checking this will automatically add the SVG class to ALL image tags containing SVG file sources in the rendered HTML via javascript and will therefore render all of your SVG files inline.', 'svg-support' ); ?>
													<br />
													<em><?php esc_html_e( 'Use case scenario: When using a visual builder such as in the Divi Theme or The Divi Builder, the class is not automatically added with the "Automatically insert class?" option selected or the builder module doesn\'t give you the option to manually add a CSS class directly to your image.', 'svg-support' ); ?></em>
												</small>
											</label>
										</td>
									</tr>

									<tr valign="top" class="svgs-advanced">
										<th scope="row">
											<strong><?php esc_html_e( 'Automatically insert class?', 'svg-support' ); ?></strong></label>
										</th>
										<td>
											<label for="bodhi_svgs_settings[auto_insert_class]">
												<input id="bodhi_svgs_settings[auto_insert_class]" name="bodhi_svgs_settings[auto_insert_class]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['auto_insert_class'] ), true ); ?> />
												<?php esc_html_e( 'Yes', 'svg-support' ); ?><br />
												<small class="description">
													<?php esc_html_e('(Classic Editor Only) Checking this will make sure that either the default class or the custom one you set in "CSS Class to target" option will be inserted into the style attributes of img tags when you insert SVG images into a post. Additionally, it will remove all of the default WordPress classes. It will leave normal image types as default and only affect SVG files.', 'svg-support' ); ?>
												</small>
											</label>
										</td>
									</tr>

								</table>

								<div class="postbox">
									<h3><span><?php esc_html_e( 'Danger Zone', 'svg-support' ); ?></span></h3>
									<div class="inside">
										<table class="form-table">
											<tr valign="top">
												<th scope="row">
													<label for="bodhi_svgs_settings[del_plugin_data]"><strong><?php esc_html_e( 'Delete Plugin Data', 'svg-support' ); ?></strong></label>
												</th>
												<td>
													<label for="bodhi_svgs_settings[del_plugin_data]">
														<input id="bodhi_svgs_settings[del_plugin_data]" name="bodhi_svgs_settings[del_plugin_data]" type="checkbox" <?php checked( isset( $bodhi_svgs_options['del_plugin_data'] ), true ); ?> />
														<?php esc_html_e( 'Yes', 'svg-support' ); ?><br /><small class="description"><?php esc_html_e('Delete all plugin\'s data during uninstallation process.', 'svg-support' ); ?></small>
													</label>
												</td>
											</tr>
										</table>
									</div>
								</div>

								<p>
									<input class="button-primary" type="submit" name="bodhi_svgs_settings_submit" value="<?php esc_html_e( 'Save Changes', 'svg-support' ); ?>" />
								</p>

							</form>

						</div> <!-- .inside -->

					</div> <!-- .postbox -->

					<div class="postbox">

						<?php

						if ( empty( $bodhi_svgs_options['advanced_mode'] ) ) {
							echo '<h3><span>';
							esc_html_e( 'Usage', 'svg-support' );
							echo '</span></h3>';
						} else {
							echo '<h3><span>';
							 esc_html_e( 'Advanced Usage', 'svg-support' );
							 echo '</span></h3>';
						}

						?>

						<div class="inside">

							<p><?php esc_html_e( 'You can simply upload SVG files to your media library like any other image. Make sure to select "Restrict to Administrators" if you only want to allow admins to upload SVG files.', 'svg-support' ); ?></p>

							<div class="svgs-advanced">
								<p>
									<?php
									esc_html_e( 'Now, embed your SVG image like a standard image with the addition of adding the class', 'svg-support' );
									?>
									<code><?php echo esc_html( 'style-svg' ); ?></code>
									<?php
									esc_html_e( '(or your custom class from above) to any IMG tags that you want this plugin to swap out with your actual SVG code.', 'svg-support' );
									?>
									<br />
									<?php esc_html_e( 'You can even use the class on an outer container and it will traverse all child elements to find all of the IMG tags with SVG files in the src and replace them.', 'svg-support' ); ?>
								</p>

								<p>
									<?php esc_html_e( 'For example:', 'svg-support' ); ?>
									<pre><code>&lt;img class="style-svg" alt="alt-text" src="image-source.svg" /&gt;</code></pre>
									<?php esc_html_e( 'or', 'svg-support' ); ?>
									<pre><code>&lt;img class="your-custom-class" alt="alt-text" src="image-source.svg" /&gt;</code></pre>
								</p>

								<p>
									<?php esc_html_e( 'The whole IMG tag element will now be dynamically replaced by the actual code of your SVG, making the inner content targetable.', 'svg-support' ); ?><br />
									<?php esc_html_e( 'This allows you to target elements within your SVG using CSS.', 'svg-support' ); ?>
								</p>

								<p><em><?php esc_html_e( 'Please Note:', 'svg-support' ); ?></em>
								<br><em><?php esc_html_e( '- You will need to set your own height and width in your CSS for SVG files to display correctly.', 'svg-support' ); ?></em>
								<br><em><?php esc_html_e( '- Your uploaded image needs to be an SVG file for this plugin to replace the img tag with the inline SVG code. It will not create SVG files for you.', 'svg-support' ); ?></em>
								<br><em><?php esc_html_e( '- You can set this target class on any element and the script will traverse all children of that target element looking for IMG tags with SVG in the src to replace.', 'svg-support' ); ?></em></p>
							</div>

						</div> <!-- .inside -->

					</div> <!-- .postbox -->

					<div class="postbox">
						<h3><span><?php esc_html_e( 'Compress and Optimize Images with ShortPixel', 'svg-support' ); ?></span></h3>
						<div class="inside">
							<?php
							printf(
								'<a target="_blank" class="shortpixel-logo" href="https://shortpixel.com/h/af/OLKMLXE207471"><img src="%s" alt="%s" /></a>',
								esc_url(plugins_url('admin/img/shortpixel.png', BODHI_SVGS_PLUGIN_FILE)),
								esc_attr__('ShortPixel logo', 'svg-support')
							);
							?>
							<p><?php esc_html_e( 'Now that you\'ve set up SVG Support on your site, it\'s time to look at optimizing your existing images (jpg & png).', 'svg-support' ); ?></p>
							<p><?php esc_html_e( 'ShortPixel improves website performance by reducing the size of your images. The results are no different in quality from the original, plus your originals are stored in a backup folder for you.', 'svg-support' ); ?></p>
							<p><?php esc_html_e( 'If you upgrade to a paid plan, I\'ll receive a small commission... And that\'s really nice!', 'svg-support' ); ?></p>
							<p><a class="shortpixel-button button-primary" href="https://shortpixel.com/h/af/OLKMLXE207471"><?php esc_html_e( 'Try ShortPixel WordPress Plugin for FREE', 'svg-support' ); ?></a></p>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->

					<div class="postbox">
						<h3><span><?php esc_html_e( 'Animate and Optimize your SVG files using these open source projects', 'svg-support' ); ?></span></h3>
						<div class="inside">
							<p><a href="https://maxwellito.github.io/vivus-instant/" target="_blank">Vivus Instant for SVG animation</a> <?php esc_html_e( 'Upload your SVG files and use the tools provided to animate strokes.', 'svg-support' ); ?></p>
							<p><a href="https://jakearchibald.github.io/svgomg/" target="_blank">SVGOMG for SVG optimisation</a> <?php esc_html_e( 'An online tool to optimize your SVG files.', 'svg-support' ); ?></p>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->

				</div> <!-- .meta-box-sortables .ui-sortable -->

			</div> <!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">
						<h3><span><?php esc_html_e( 'Ratings & Reviews', 'svg-support' ); ?></span></h3>
						<div class="inside">
							<p>
								<?php esc_html_e( 'If you like', 'svg-support' ); ?>
								<strong><?php esc_html_e( 'SVG Support', 'svg-support' ); ?></strong>
								<?php esc_html_e( 'please consider leaving a', 'svg-support' ); ?>
								<a href="https://wordpress.org/support/view/plugin-reviews/svg-support?filter=5#postform" target="_blank" class="svgs-rating-link">&#9733;&#9733;&#9733;&#9733;&#9733;</a>
								<?php esc_html_e( 'rating.', 'svg-support' ); ?>
								<br />
								<?php esc_html_e( 'A huge thanks in advance!', 'svg-support' ); ?>
							</p>
							<p><a href="https://wordpress.org/support/view/plugin-reviews/svg-support?filter=5#postform" target="_blank" class="button-primary">Leave a rating</a></p>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->

					<div class="postbox">
						<h3><span><?php esc_html_e( 'Having Issues?', 'svg-support' ); ?></span></h3>
						<div class="inside">
							<p><?php esc_html_e( 'I\'m always happy to help out!', 'svg-support' ); ?>
								<br><?php esc_html_e( 'Support is handled exclusively through WordPress.org by my one man team - me.', 'svg-support' ); ?></p>
							<p><a href="https://wordpress.org/support/plugin/svg-support/" target="_blank" class="button-primary"><?php esc_html_e('Get Support', 'svg-support'); ?></a></p>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->

					<div class="postbox">
						<h3><span><?php esc_html_e( 'SVG Support Features', 'svg-support' ); ?></span></h3>
						<div class="inside">
							<ul>
								<li><strong><?php esc_html_e( 'Basic Use', 'svg-support' ); ?></strong></li>
								<li><?php esc_html_e( 'SVG Support for your media library', 'svg-support' ); ?></li>
								<li><?php esc_html_e( 'Restrict to Administrators only', 'svg-support' ); ?></li>
								<hr>
								<li><strong><?php esc_html_e( 'Advanced Mode', 'svg-support' ); ?></strong></li>
								<li><?php esc_html_e( 'Sanitize SVG files on upload', 'svg-support' ); ?></li>
								<li><?php esc_html_e( 'Style SVG elements using CSS', 'svg-support' ); ?></li>
								<li><?php esc_html_e( 'Animate SVG using CSS or JS', 'svg-support' ); ?></li>
								<li><?php esc_html_e( 'Include multiple URLs inside single SVG', 'svg-support' ); ?></li>
								<li><?php esc_html_e( 'Use odd shapes as links', 'svg-support' ); ?></li>
								<li><?php esc_html_e( 'Inline SVG featured image support', 'svg-support' ); ?></li>
								<li><?php esc_html_e( 'Force all SVG files to be rendered inline', 'svg-support' ); ?></li>
							</ul>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->

					<div class="postbox">
						<h3><span><?php esc_html_e( 'About The Plugin', 'svg-support' ); ?></span></h3>
						<div class="inside">
							<p><?php esc_html_e( 'Learn more about SVG Support on:', 'svg-support' ); ?><br/><a target="_blank" href="http://wordpress.org/plugins/svg-support/"><?php esc_html_e( 'The WordPress Plugin Repository', 'svg-support' ); ?></a></p>
							<p><?php esc_html_e( 'Need help?', 'svg-support' ); ?><br/><a target="_blank" href="http://wordpress.org/support/plugin/svg-support"><?php esc_html_e( 'Visit The Support Forum', 'svg-support' ); ?></a></p>
							<p>
								<?php esc_html_e( 'Follow', 'svg-support' ); ?>
								<a target="_blank" href="https://twitter.com/svgsupport"><?php esc_html_e( '@SVGSupport', 'svg-support' ); ?></a>
								<?php esc_html_e( 'on Twitter', 'svg-support' ); ?>
							</p>
							<p>
								<?php esc_html_e( 'Follow Benbodhi on:', 'svg-support' ); ?><br/>
								<a target="_blank" href="https://twitter.com/benbodhi"><?php esc_html_e( 'Twitter', 'svg-support' ); ?></a> | 
								<a target="_blank" href="https://warpcast.com/benbodhi"><?php esc_html_e( 'Warpcast', 'svg-support' ); ?></a>
							</p>
							<p>&copy; <?php esc_html_e( 'Benbodhi', 'svg-support' ); ?> | <a target="_blank" href="https://benbodhi.com/">Benbodhi.com</a></p>
							<p>
								<?php esc_html_e( 'Thanks for your support, please consider donating.', 'svg-support' ); ?><br/>
								<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z9R7JERS82EQQ&source=url"><?php esc_html_e( 'Donate using PayPal', 'svg-support' ); ?></a>
							</p>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->

				</div> <!-- .meta-box-sortables -->

			</div> <!-- #postbox-container-1 .postbox-container -->

		</div> <!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div> <!-- #poststuff -->

</div> <!-- .wrap -->
