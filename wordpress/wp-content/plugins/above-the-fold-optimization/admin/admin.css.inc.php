<?php

?><form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_css_update'); ?>" class="clearfix" enctype="multipart/form-data">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e('CSS Optimization', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">

<?php

    /**
     * Get version of local loadCSS
     */
    $loadcss_version = '';
    $loadcss_package = WPABTF_PATH . 'public/js/src/loadcss_package.json';
    if (!file_exists($loadcss_package)) {
        ?>
	<h1 style="color:red;">WARNING: PLUGIN INSTALLATION NOT COMPLETE, MISSING public/js/src/loadcss_package.json</h1>
<?php

    } else {
        $package = @json_decode(file_get_contents($loadcss_package), true);
        if (!is_array($package)) {
            ?>
	<h1 style="color:red;">failed to parse public/js/src/loadcss_package.json</h1>
<?php

        } else {

            // set version
            $loadcss_version = $package['version'];
        }
    }

    if (empty($loadcss_version)) {
        $loadcss_version = '(unknown)';
    }

?>
							<table class="form-table">
								<tr valign="top">
									<th scope="row">Optimize CSS Delivery</th>
									<td>
										<label><input type="checkbox" name="abovethefold[cssdelivery]" value="1"<?php if (!isset($options['cssdelivery']) || intval($options['cssdelivery']) === 1) {
    print ' checked';
} ?> onchange="if (jQuery(this).is(':checked')) { jQuery('.cssdeliveryoptions').show(); } else { jQuery('.cssdeliveryoptions').hide(); }"> Enabled</label>
										<p class="description">When enabled, CSS files are loaded asynchronously via <a href="https://github.com/filamentgroup/loadCSS" target="_blank">loadCSS</a> (v<?php print $loadcss_version;?>).  <a href="https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery?hl=<?php print $lgcode;?>" target="_blank">Click here</a> for the recommendations by Google.</p>
									</td>
								</tr>
								<tr valign="top" class="cssdeliveryoptions" style="<?php if (isset($options['cssdelivery']) && intval($options['cssdelivery']) !== 1) {
    print 'display:none;';
} ?>">
									<td colspan="2" style="padding-top:0px;">

										<div class="abtf-inner-table">

											<h3 class="h"><span>CSS Delivery Optimization</span></h3>
											<div class="inside">
												<table class="form-table">
													<tr valign="top">
														<th scope="row">Enhanced loadCSS</th>
														<td>
															<label><input type="checkbox" name="abovethefold[loadcss_enhanced]" value="1" onchange="if (jQuery(this).is(':checked')) { jQuery('.enhancedloadcssoptions').show(); } else { jQuery('.enhancedloadcssoptions').hide(); }"<?php if (!isset($options['loadcss_enhanced']) || intval($options['loadcss_enhanced']) === 1) {
    print ' checked';
} ?>> Enabled</label>
															<p class="description">When enabled, a customized version of loadCSS is used to make use of the <code>requestAnimationFrame</code> API following the <a href="https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery?hl=<?php print $lgcode;?>" target="_blank">recommendations by Google</a>.</p>
														</td>
													</tr>
													<tr valign="top" class="enhancedloadcssoptions" style="<?php if (isset($options['loadcss_enhanced']) && intval($options['loadcss_enhanced']) !== 1) {
    print 'display:none;';
} ?>">
														<th scope="row">CSS render delay</th>
														<td>
															<table cellpadding="0" cellspacing="0" border="0">
																<tr>
																	<td valign="top" style="padding:0px;vertical-align:top;"><input type="number" min="0" max="3000" step="1" name="abovethefold[cssdelivery_renderdelay]" size="10" value="<?php print((empty($options['cssdelivery_renderdelay']) || $options['cssdelivery_renderdelay'] === 0) ? '' : htmlentities($options['cssdelivery_renderdelay'], ENT_COMPAT, 'utf-8')); ?>" onkeyup="if (jQuery(this).val() !== '' && jQuery(this).val() !== '0') { jQuery('#warnrenderdelay').show(); } else { jQuery('#warnrenderdelay').hide(); }" onchange="if (jQuery(this).val() === '0') { jQuery(this).val(''); } if (jQuery(this).val() !== '' && jQuery(this).val() !== '0') { jQuery('#warnrenderdelay').show(); } else { jQuery('#warnrenderdelay').hide(); }" placeholder="0 ms" /></td>
																	<td valign="top" style="padding:0px;vertical-align:top;padding-left:10px;font-size:11px;"><div id="warnrenderdelay" style="padding:0px;margin:0px;<?php print((empty($options['cssdelivery_renderdelay']) || $options['cssdelivery_renderdelay'] === 0 || trim($options['cssdelivery_renderdelay']) === '') ? 'display:none;' : ''); ?>"><span style="color:red;font-weight:bold;">Warning:</span> A higher Google PageSpeed score may sometimes be achieved using this option but it may not be beneficial to the page rendering experience of your users. Often it is best to seek an alternative solution.</div></td>
																</tr>
															</table>
															<p class="description" style="clear:both;">Optionally, enter a time in milliseconds to delay the rendering of CSS files.</p>

														</td>
													</tr>
													<tr valign="top">
														<th scope="row">Position</th>
														<td>
															<select name="abovethefold[cssdelivery_position]">
																<option value="header"<?php if (isset($options['cssdelivery_position']) && $options['cssdelivery_position'] === 'header') {
    print ' selected';
} ?>>Header</option>
																<option value="footer"<?php if (!isset($options['cssdelivery_position']) || empty($options['cssdelivery_position']) || $options['cssdelivery_position'] === 'footer') {
    print ' selected';
} ?>>Footer</option>
															</select>
															<p class="description">Select the position where the async loading of CSS will start.</p>
														</td>
													</tr>
													<tr valign="top">
														<th scope="row">Ignore List</th>
														<td>
															<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[cssdelivery_ignore]"><?php if (isset($options['cssdelivery_ignore'])) {
    echo $this->CTRL->admin->newline_array_string($options['cssdelivery_ignore']);
} ?></textarea>
															<p class="description">Stylesheets to ignore in CSS delivery optimization. One stylesheet per line. The files will be left untouched in the HTML.</p>
														</td>
													</tr>
													<tr valign="top">
														<th scope="row">Remove List</th>
														<td>
															<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[cssdelivery_remove]"><?php if (isset($options['cssdelivery_remove'])) {
    echo $this->CTRL->admin->newline_array_string($options['cssdelivery_remove']);
} ?></textarea>
															<p class="description">Stylesheets to remove from HTML. One stylesheet per line. This feature enables to include small plugin related CSS files inline.</p>
														</td>
													</tr>
												</table>

											</div>

										</div>

									</td>
								</tr>
	<?php

        /**
         * Get version of local webfont.js
         */
        $webfont_version = $this->CTRL->gwfo->package_version(true);
        if (empty($webfont_version)) {
            $webfont_version = '(unknown)';
        }

    ?>
								<tr valign="top">
									<th scope="row">Optimize Web Fonts</th>
									<td>
										<label><input type="checkbox" name="abovethefold[gwfo]" value="1"<?php if (!isset($options['gwfo']) || intval($options['gwfo']) === 1) {
        print ' checked';
    } ?> onchange="if (jQuery(this).is(':checked')) { jQuery('.gwfooptions').show(); } else { jQuery('.gwfooptions').hide(); }"> Enabled
										</label>
										<p class="description">When enabled, web fonts are optimized using <a href="https://github.com/typekit/webfontloader" target="_blank">Google Web Font Loader</a>.</p>
									</td>
								</tr>
								<tr valign="top" class="gwfooptions" style="<?php if (isset($options['gwfo']) && intval($options['gwfo']) !== 1) {
        print 'display:none;';
    } ?>">
									<td colspan="2" style="padding-top:0px;">

										<div class="abtf-inner-table">

											<h3 class="h"><span>Web Font Optimization</span></h3>

											<div class="inside">
												<table class="form-table">
													<tr valign="top">
														<th scope="row">webfont.js Load Method</th>
														<td>
															<select name="abovethefold[gwfo_loadmethod]" onchange="if (jQuery(this).val() === 'disabled') { jQuery('.gwfloadoptions').hide(); } else { jQuery('.gwfloadoptions').show(); } ">
																<option value="inline"<?php if (!isset($options['gwfo_loadmethod']) || $options['gwfo_loadmethod'] === 'inline') {
        print ' selected';
    } ?>>Inline</option>
																<option value="async"<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'async') {
        print ' selected';
    } ?>>Async</option>
																<option value="async_cdn"<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'async_cdn') {
        print ' selected';
    } ?>>Async from Google CDN (v<?php print $this->CTRL->gwfo->cdn_version; ?>)</option>
																<option value="wordpress"<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'wordpress') {
        print ' selected';
    } ?>>WordPress include</option>
																<option value="disabled"<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'disabled') {
        print ' selected';
    } ?>>Disabled (remove all fonts)</option>
															</select>
															<p class="description">Select the method to load <a href="https://developers.google.com/speed/libraries/?hl=<?php print $lgcode;?>#web-font-loader" target="_blank">webfont.js</a> (v<?php print $webfont_version; ?>).</p>
														</td>
													</tr>
													<tr valign="top" class="gwfloadoptions" style="<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'disabled') {
        print 'display:none;';
    } ?>">
														<th scope="row">Load Position</th>
														<td>
															<select name="abovethefold[gwfo_loadposition]">
																<option value="header"<?php if (!isset($options['gwfo_loadposition']) || $options['gwfo_loadposition'] === 'header') {
        print ' selected';
    } ?>>Header</option>
																<option value="footer"<?php if (isset($options['gwfo_loadposition']) && $options['gwfo_loadposition'] === 'footer') {
        print ' selected';
    } ?>>Footer</option>
															</select>
															<p class="description">Select the position where the loading of web fonts will start.</p>
														</td>
													</tr>
													<tr valign="top" class="gwfloadoptions" style="<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'disabled') {
        print 'display:none;';
    } ?>">
														<th scope="row">WebFontConfig</th>
														<td>
															<?php
                                                                if (isset($options['gwfo_config_valid']) && $options['gwfo_config_valid'] === false) {
                                                                    print '<p style="color:red;margin-bottom:2px;">WebFontConfig variable not recognized.</p>';
                                                                }
                                                            ?>
															<textarea style="width: 100%;height:100px;font-size:11px;<?php if (isset($options['gwfo_config_valid']) && $options['gwfo_config_valid'] === false) {
                                                                print 'border-color:red;';
                                                            } ?>" name="abovethefold[gwfo_config]" placeholder="WebFontConfig = { classes: false, typekit: { id: 'xxxxxx' }, loading: function() {}, google: { families: ['Droid Sans', 'Droid Serif'] } };" onchange="if (jQuery(this).val() ==='') { jQuery('#sha256_warning').hide(); } else {jQuery('#sha256_warning').show();} "><?php if (isset($options['gwfo_config'])) {
                                                                echo htmlentities($options['gwfo_config']);
                                                            } ?></textarea>
															<p class="description">Enter the <code>WebFontConfig</code> variable for Google Web Font Loader. Leave blank for the default configuration. (<a href="https://github.com/typekit/webfontloader#configuration" target="_blank">more information</a>)</p>
														</td>
													</tr>
													<tr valign="top" class="gwfloadoptions">
														<th scope="row">Google Web Fonts</th>
														<td>
															<div class="gwfloadoptions" style="<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'disabled') {
                                                                print 'display:none;';
                                                            } ?>">
																<textarea style="width: 100%;height:<?php if (count($options['gwfo_googlefonts']) > 3) {
                                                                print '100px';
                                                            } else {
                                                                print '50px';
                                                            } ?>;font-size:11px;" name="abovethefold[gwfo_googlefonts]" placeholder="Droid Sans"><?php if (isset($options['gwfo_googlefonts'])) {
                                                                echo $this->CTRL->admin->newline_array_string($options['gwfo_googlefonts']);
                                                            } ?></textarea>
																<p class="description">Enter the <a href="https://developers.google.com/fonts/docs/getting_started?hl=<?php print $lgcode;?>&csw=1" target="_blank">Google Font API</a> definitions of <a href="https://fonts.google.com/?hl=<?php print $lgcode;?>" target="_blank">Google Web Fonts</a> to load. One font per line. (<a href="https://github.com/typekit/webfontloader#google" target="_blank">documentation</a>)</p>
																<br />
																<label><input type="checkbox" name="abovethefold[gwfo_googlefonts_auto]" value="1"<?php if (!isset($options['gwfo_googlefonts_auto']) || intval($options['gwfo_googlefonts_auto']) === 1) {
                                                                print ' checked';
                                                            } ?>> Auto-detect enabled
										</label>
																<p class="description">When enabled, fonts are automatically extracted from the HTML, CSS and existing WebFontConfig.</p>

																<br />
																<h5 class="h">&nbsp;Ignore List</h5>
																<textarea style="width: 100%;height:<?php if (isset($options['gwfo_googlefonts_ignore']) && count($options['gwfo_googlefonts_ignore']) > 3) {
                                                                print '100px';
                                                            } else {
                                                                print '50px';
                                                            } ?>;font-size:11px;" name="abovethefold[gwfo_googlefonts_ignore]"><?php if (isset($options['gwfo_googlefonts_ignore'])) {
                                                                echo $this->CTRL->admin->newline_array_string($options['gwfo_googlefonts_ignore']);
                                                            } ?></textarea>
																<p class="description">Enter (parts of) Google Web Font definitions to ignore, e.g. <code>Open Sans</code>. The fonts in this list will not be optimized or auto-detected.</p>
																<br />
																<h5 class="h">&nbsp;Remove List</h5>
																<textarea style="width: 100%;height:<?php if (isset($options['gwfo_googlefonts_remove']) && count($options['gwfo_googlefonts_remove']) > 3) {
                                                                print '100px';
                                                            } else {
                                                                print '50px';
                                                            } ?>;font-size:11px;" name="abovethefold[gwfo_googlefonts_remove]"><?php if (isset($options['gwfo_googlefonts_remove'])) {
                                                                echo $this->CTRL->admin->newline_array_string($options['gwfo_googlefonts_remove']);
                                                            } ?></textarea>
																<p class="description">Enter (parts of) Google Web Font definitions to remove, e.g. <code>Open Sans</code>. This feature is useful when loading fonts locally. One font per line.</p>
																<br />
															</div>

														</td>
													</tr>
													<tr valign="top">
														<th scope="row">Local Font Loading</th>
														<td>
															<p>Google Fonts are served from <code>fonts.googleapis.com</code> that is causing a render-blocking warning in the Google PageSpeed test. The Google fonts stylesheet cannot be cached by the <a href="<?php echo add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')); ?>">external resource proxy</a> because it serves different content based on the client.</p>
															<p style="margin-top:7px;">To solve the PageSpeed Score issue while also achieving the best font render performance, it is possible to download the Google fonts and load them locally (from the critical CSS). Loading Google fonts locally enables to achieve a Google PageSpeed 100 Score while also preventing a font flicker effect during navigation.</p>

															<br />
															<h1>How to place Google Fonts locally</h1>


															<p>Select the option "<em>Disabled (remove all fonts)</em>" from the webfont.js Load Method menu (above) to remove dynamic and static Google fonts from the HTML and CSS.</p>
															
															<h4 class="h" style="margin-bottom:10px;margin-top:15px;">Step 1: download the font files and CSS</h4>

															
															<p style="margin-top:7px;">Visit <a href="https://google-webfonts-helper.herokuapp.com/fonts?utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank">Google Webfonts Helper</a> and search for the fonts that you want to download. Select the font configuration (weight, charset and style) and download the zip-file.</p>

															<h4 class="h" style="margin-bottom:10px;margin-top:10px;">Step 2: upload the fonts to your theme directory</h4>
															<p style="margin-top:7px;">Extract the zip-file and upload the font files to <code>/fonts/</code> in your theme directory. Optionally, use the file upload to extract the zip-file in your theme directory automatically (requires PHP5).</p>
															<p style="margin-top:7px;"><input type="file" name="googlefontzip"></p>
															<p><button type="submit" name="uploadgooglefontzip" class="button button-primary button-green">Upload &amp; Extract</button></p>

															<h4 class="h" style="margin-bottom:10px;margin-top:10px;">Step 3: create a Conditional Critical Path CSS entry for Google Fonts</h4>
															<p style="margin-top:7px;">Create a Conditional Critical Path CSS entry without conditions and select the <code>@appendToAny</code> option.</p>
															<p>Enter the Google Font CSS into the CSS input field.</p>
															<p>Change the paths of the fonts to the location of the fonts in your theme directory, e.g. <code><?php print htmlentities(str_replace(ABSPATH, '/', trailingslashit(get_stylesheet_directory()) . 'fonts/'), ENT_COMPAT, 'utf-8'); ?></code> and <a href="https://www.google.com/search?q=minify+css+online&amp;hl=<?php print $lgcode;?>" target="_blank" class="button button-secondary button-small">minify</a> the CSS.</p>
														</td>
													</tr>
												</table>
											</div>
										</div>

									</td>
								</tr>
							</table>
							<hr />
							<?php
                                submit_button(__('Save'), 'primary large', 'is_submit', false);
                            ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>
