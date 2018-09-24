<?php

    $jsProxy = (isset($options['js_proxy']) && intval($options['js_proxy']) === 1);

    if (isset($options['jsdelivery_idle']) && !empty($options['jsdelivery_idle'])) {
        foreach ($options['jsdelivery_idle'] as $n => $cnf) {
            $options['jsdelivery_idle'][$n] = $cnf[0];
            if (isset($cnf[1])) {
                $options['jsdelivery_idle'][$n] .= ':' . $cnf[1];
            }
        }
    }
?>
<form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_javascript_update'); ?>" class="clearfix">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e('Javascript Optimization', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">

						<div class="info_seagreen" style="margin-bottom:0px;font-size:14px;"><strong>Tip:</strong> More information about javascript optimization can be found in <a href="https://www.igvita.com/?<?php print $utmstring; ?>" target="_blank">this blog</a> by Ilya Grigorik, web performance engineer at Google and author of the O'Reilly book <a href="https://www.amazon.com/High-Performance-Browser-Networking-performance/dp/1449344763/?<?php print $utmstring; ?>" target="_blank">High Performance Browser Networking</a> (<a href="https://hpbn.co/?<?php print $utmstring; ?>" target="_blank">free online</a>).</div>


						<table class="form-table">
							<tr valign="top">
								<th scope="row">Optimize Javascript Loading</th>
								<td>
									<label><input type="checkbox" name="abovethefold[jsdelivery]" value="1"<?php if (isset($options['jsdelivery']) && intval($options['jsdelivery']) === 1) {
    print ' checked';
} ?> onchange="if (jQuery(this).is(':checked')) { jQuery('.jsdeliveryoptions').show(); } else { jQuery('.jsdeliveryoptions').hide(); }"> Enabled</label>
									<p class="description">When enabled, Javascript files are loaded asynchronously using an enhanced version of <a href="https://github.com/walmartlabs/little-loader" target="_blank">little-loader</a> from Walmart Labs (<a href="https://formidable.com/blog/2016/01/07/the-only-correct-script-loader-ever-made/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=Above%20The%20Fold%20Optimization" target="_blank">reference</a>).</p>

								</td>
							</tr>
							<tr valign="top" class="jsdeliveryoptions" style="<?php if (!isset($options['jsdelivery']) || intval($options['jsdelivery']) !== 1) {
    print 'display:none;';
} ?>">
								<td colspan="2" style="padding-top:0px;">

									<div class="abtf-inner-table">

										<h3 class="h"><span>Javascript Load Optimization</span></h3>
										<div class="inside">

											<p style="padding:5px;border-bottom:solid #efefef;margin:0px;"><span style="color:red;font-weight:bold;">Warning:</span> It may require some tweaking of the settings to prevent javascript problems.</p>

											<table class="form-table">
												<tr valign="top">
													<th scope="row">Script Loader</th>
													<td>
														<label><input type="radio" name="abovethefold[jsdelivery_scriptloader]" value="little-loader"<?php if (!isset($options['jsdelivery_scriptloader']) || $options['jsdelivery_scriptloader'] === 'little-loader') {
    print ' checked';
} ?>> <a href="https://github.com/walmartlabs/little-loader" target="_blank">little-loader</a> from Walmart Labs (<a href="https://formidable.com/blog/2016/01/07/the-only-correct-script-loader-ever-made/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=Above%20The%20Fold%20Optimization" target="_blank">reference</a>)</label>
														<p class="description" style="margin-bottom:5px;">A stable async script loader that works in old browsers.</p>
														
														<label><input type="radio" name="abovethefold[jsdelivery_scriptloader]" value="html5"<?php if ($jsProxy && isset($options['jsdelivery_scriptloader']) && $options['jsdelivery_scriptloader'] === 'html5') {
    print ' checked';
} ?> <?php if (!$jsProxy) {
    print ' DISABLED';
} ?>> little-loader + HTML5 Web Worker and Fetch API based script loader with localStorage cache</label>
														<p class="description" style="color:red;<?php if ($jsProxy) {
    print 'display:none;';
} ?>">This script loader requires the <a href="<?php echo add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')); ?>">Javascript proxy</a> to be enabled to bypass <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS" target="_blank">CORS</a>.</p> 
														<p class="description">A state of the art script loader for optimal mobile speed, inspired by <a href="https://addyosmani.com/basket.js/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=Above%20The%20Fold%20Optimization" target="_blank">basket.js</a> (by a Google engineer), a script loading concept in use by Google. With fallback to little-loader for old browsers.</p>
														<div class="info_yellow">
															<p class="description" style="margin-top:0px;">
																<strong>Advantages of the HTML5 script loader</strong>
															</p>
															<p class="description" style="margin-bottom:0px;">
																<ul style="margin:0px;padding:0px;">
																	<li style="padding:0px;margin:0px;">&nbsp;<span style="color: #666;">➤</span> 0 javascript file download during navigation</li>
																	<li style="padding:0px;margin:0px;">&nbsp;<span style="color: #666;">➤</span> 0 javascript file download for returning visitors</li>
																	<li style="padding:0px;margin:0px;">&nbsp;<span style="color: #666;">➤</span> abide WordPress dependencies</li>
																	<li style="padding:0px;margin:0px;">&nbsp;<span style="color: #666;">➤</span> faster script loading than browser cache, especially on mobile</li>
																</ul>
															</p>
														</div>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Position</th>
													<td>
														<select name="abovethefold[jsdelivery_position]">
															<option value="header"<?php if (!isset($options['jsdelivery_position']) || empty($options['jsdelivery_position']) || $options['jsdelivery_position'] === 'header') {
    print ' selected';
} ?>>Header</option>
															<option value="footer"<?php if (isset($options['jsdelivery_position']) && $options['jsdelivery_position'] === 'footer') {
    print ' selected';
} ?>>Footer</option>
														</select>
														<p class="description">Select the position where the async loading of Javascript will start.</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Ignore List</th>
													<td>
														<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[jsdelivery_ignore]"><?php if (isset($options['jsdelivery_ignore'])) {
    echo $this->CTRL->admin->newline_array_string($options['jsdelivery_ignore']);
} ?></textarea>
														<p class="description">Scripts to ignore in Javascript delivery optimization. One script per line. The files will be left untouched in the HTML.</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Remove List</th>
													<td>
														<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[jsdelivery_remove]"><?php if (isset($options['jsdelivery_remove'])) {
    echo $this->CTRL->admin->newline_array_string($options['jsdelivery_remove']);
} ?></textarea>
														<p class="description">Scripts to remove from HTML. One script per line. This feature enables to include small plugin related scripts inline.</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">
														Force Async
													</th>
													<td>
														<label><input type="checkbox" name="abovethefold[jsdelivery_async_all]" value="1"<?php if (!isset($options['jsdelivery_async_all']) || intval($options['jsdelivery_async_all']) === 1) {
    print ' checked';
} ?> onchange="if (!jQuery(this).is(':checked')) { jQuery('.jsdelivery_async_no_options').show(); } else { jQuery('.jsdelivery_async_no_options').hide(); }"> Enabled</label>
														<p class="description">When enabled, all scripts are loaded asynchronously.</p>
													</td>
												</tr>
												<tr valign="top" class="jsdelivery_async_no_options" style="<?php if (!isset($options['jsdelivery_async_all']) || intval($options['jsdelivery_async_all']) === 1) {
    print 'display:none;';
} ?>">
													<th scope="row">Async Force List</th>
													<td>
														<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[jsdelivery_async]"><?php if (isset($options['jsdelivery_async'])) {
    echo $this->CTRL->admin->newline_array_string($options['jsdelivery_async']);
} ?></textarea>
														<p class="description">Enter (parts of) scripts to force to load async. All other scripts are loaded in sequential blocking order if not specifically configured as async in HTML.</p>
														<p class="description">Example:
															<ol style="margin:0px;padding:0px;padding-left:2em;margin-top:10px;">
																<li>Script1: non-async [wait...]</li>
																<li>Script 2,3,4: async, Script 5: non-async [wait...]</li>
																<li>Script 6</li>
															</ol>
														</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Async Disabled List</th>
													<td>
														<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[jsdelivery_async_disabled]"><?php if (isset($options['jsdelivery_async_disabled'])) {
    echo $this->CTRL->admin->newline_array_string($options['jsdelivery_async_disabled']);
} ?></textarea>
														<p class="description">Enter (parts of) scripts to force to load blocking (non-async).</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">requestIdleCallback</th>
													<td><?php if (!($jsProxy && isset($options['jsdelivery_scriptloader']) && $options['jsdelivery_scriptloader'] === 'html5')) {
    ?>
<p style="padding-bottom:5px;color:maroon;">This feature requires the HTML5 script loader.</p>
<?php

} else {
    ?>
<p style="padding-bottom:5px;">This feature only applies to localStorage cached scripts. Our new plugin will enable this option for all scripts.</p>
<?php

}
?>
														<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[jsdelivery_idle]" <?php if (!($jsProxy && isset($options['jsdelivery_scriptloader']) && $options['jsdelivery_scriptloader'] === 'html5')) {
    print ' DISABLED';
} ?>><?php if (isset($options['jsdelivery_idle'])) {
    echo $this->CTRL->admin->newline_array_string($options['jsdelivery_idle']);
} ?></textarea>
														<p class="description">Enter a list with <code>script_string[:timeout_ms]</code> entries (one per line) to execute scripts in CPU idle time within an optional timeout in milliseconds. This feature enables to prioritize script execution. (<a href="https://developers.google.com/web/updates/2015/08/using-requestidlecallback" target="_blank">more information</a>)</p>

														<p class="info_yellow" style="margin-top:7px;">Example: <code>script.js:2000</code> (script.js should execute when CPU is available or within 2 seconds). Timeout is optional.</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">
														Abide Dependencies
													</th>
													<td>
														<label><input type="checkbox" name="abovethefold[jsdelivery_deps]" value="1"<?php if (isset($options['jsdelivery_deps']) && intval($options['jsdelivery_deps']) === 1) {
    print ' checked';
} ?> > Enabled</label>
														<p class="description">When enabled, scripts will be loaded in sequential order abiding the WordPress dependency configuration from <a href="https://developer.wordpress.org/reference/functions/wp_enqueue_script/" target="_blank">wp_enqueue_script()</a>.</p>
													</td>
												</tr>
												<th scope="row">
													jQuery Stub
												</th>
												<td>
													<label><input type="checkbox" name="abovethefold[jsdelivery_jquery]" value="1"<?php if (!isset($options['jsdelivery_jquery']) || intval($options['jsdelivery_jquery']) === 1) {
    print ' checked';
} ?>> Enabled</label>
													<p class="description">When enabled, a queue captures basic jQuery functionality such as <code>jQuery(function($){ ... });</code> and <code>$(document).bind('ready')</code> in inline scripts. This feature enables to load jQuery async.</p>
												</td>
											</table>
										</div>

									</div>

								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Lazy Load Scripts<a name="lazyscripts">&nbsp;</a>
								</th>
								<td>
									<label><input type="checkbox" name="abovethefold[lazyscripts_enabled]" value="1"<?php if (isset($options['lazyscripts_enabled']) && intval($options['lazyscripts_enabled']) === 1) {
    print ' checked';
} ?> onchange="if (jQuery(this).is(':checked')) { jQuery('.lazyscriptsoptions').show(); } else { jQuery('.lazyscriptsoptions').hide(); }"> Enabled</label>
									<p class="description">When enabled, the widget module from <a href="https://github.com/ressio/lazy-load-xt#widgets" target="_blank">jQuery Lazy Load XT</a> is loaded to enable lazy loading of inline scripts such as Facebook like and Twitter follow buttons.</p>
										<p class="description lazyscriptsoptions" style="<?php if (isset($options['lazyscripts_enabled']) && intval($options['lazyscripts_enabled']) === 1) {
} else {
    print 'display:none;';
} ?>">This option is compatible with <a href="<?php print admin_url('plugin-install.php?s=Lazy+Load+XT&tab=search&type=term'); ?>">WordPress lazy load plugins</a> that use Lazy Load XT. Those plugins are <u>not required</u> for this feature.</p>
										<pre style="float:left;width:100%;overflow:auto;<?php if (isset($options['lazyscripts_enabled']) && intval($options['lazyscripts_enabled']) === 1) {
} else {
    print 'display:none;';
} ?>" class="lazyscriptsoptions">
<?php print htmlentities('<div data-lazy-widget><!--
<div id="fblikebutton_1" class="fb-like" data-href="https://pagespeed.pro/" 
data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
<script>
FB.XFBML.parse(document.getElementById(\'fblikebutton_1\').parentNode||null);
</script>
--></div>');?>
										</pre>
								</td>
							</tr>
						</table>
						<hr />
						<?php
                            submit_button(__('Save'), 'primary large', 'is_submit', false);
                        ?>

						</div>
					</div>


	<!-- End of #post_form -->

				</div>
			</div> <!-- End of #post-body -->
		</div> <!-- End of #poststuff -->
	</div> <!-- End of .wrap .nginx-wrapper -->
</form>
