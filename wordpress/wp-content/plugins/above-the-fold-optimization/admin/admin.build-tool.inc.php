<?php

    $default = get_option('abtf-build-tool-default');
    if (!is_array($default)) {
        $default = array();
    }

    $taskname = (isset($_REQUEST['taskname']) ? trim($_REQUEST['taskname']) : (isset($default['taskname']) ? trim($default['taskname']) : ''));
    $dimensions = (isset($_REQUEST['dimensions']) ? $_REQUEST['dimensions'] : (isset($default['dimensions']) ? $default['dimensions'] : ''));
    $extra = ((isset($_REQUEST['extra']) && $_REQUEST['extra']) ? true : ((isset($default['extra']) && $default['extra']) ? true : false));
    $update = (isset($_REQUEST['update']) ? trim($_REQUEST['update']) : (isset($default['update']) ? $default['update'] : false));

?>
<nav class="subnav">
	<span class="t">Submenu:</span>
	<a href="<?php echo add_query_arg(array('page' => 'pagespeed-criticalcss-test'), admin_url('admin.php')); ?>" class="f">Quality Test (mirror)</a><a href="<?php echo add_query_arg(array('page' => 'pagespeed-build-tool'), admin_url('admin.php')); ?>" class="s">Gulp.js Critical CSS Generator</a>
</nav>
<form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_create_critical_package'); ?>" class="clearfix abtf-bt-builder">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e('Critical Path CSS Creator', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">

							<p>Most advanced optimization software such as critical path CSS creation are easiest to use using a build tool such as <a href="http://gruntjs.com/" target="_blank">Grunt.js</a> and <a href="http://gulpjs.com/" target="_blank">Gulp.js</a>. While those build tools make it easy to use professional software for experienced developers, most average WordPress users will not be able to use them and thus have no access to professional optimization software.</p>
							<p>This WordPress based <em>build tool builder</em> enables professional critical path CSS creation via <a href="https://github.com/addyosmani/critical" target="_blank">critical</a> (by a Google engineer) using the build tool <a href="http://gulpjs.com/" target="_blank">Gulp.js</a>.</p>

							<table class="form-table">
								<tr valign="top">
									<td style="padding:0px;">
										<div class="abtf-inner-table">

											<h3 class="h"><span>Create a Gulp.js Critical CSS Task Package</span></h3>
											<div class="inside">

												<table class="form-table">
													<tr valign="top">
														<th scope="row" style="padding-bottom:0px;">Task Name</th>
														<td style="padding-bottom:0px;">
						                                    <input type="text" name="taskname" size="50" value="<?php if ($taskname) {
    print htmlentities($taskname, ENT_COMPAT, 'utf-8');
} ?>" pattern="^[a-z\d-]*$" placeholder="Enter a Gulp.js task name (no spaces)." />
						                                    <p class="description">The task name is used as task command and as subdirectory (/theme/abovethefold/<strong>task-name</strong>/).</p>
														</td>
													</tr>
													<tr valign="top">
														<th scope="row">Page</th>
														<td>
						                                    <select name="url" class="wp-pageselect"><option value=""></option><option value="<?php print home_url(); ?>">Home Page (index)</option></select>
						                                    <p class="description">Select a page for which to create critical path CSS.</p>
														</td>
													</tr>
													<tr valign="top">
														<th scope="row" style="padding-top:0px;padding-bottom:0px;">Responsive Dimensions</th>
														<td style="padding-top:0px;;padding-bottom:0px;">
						                                    <textarea style="width: 100%;height:50px;font-size:11px;" name="dimensions" placeholder="Leave blank for the default dimension..."><?php if ($dimensions) {
    print $this->CTRL->admin->newline_array_string($dimensions);
} ?></textarea>
															<p class="description">Enter one or more responsive dimensions for which to generate critical path CSS. Format: <code>800x600</code>. One dimension per line. The result is combined and compressed. (<a href="https://github.com/addyosmani/critical#generate-critical-path-css-with-multiple-resolutions" target="_blank">more info</a>).</p>
														</td>
													</tr>
													<tr valign="top">
														<th scope="row">Append extra.css</th>
														<td>
						                                    <label><input type="checkbox" name="extra" value="1"<?php if ($extra) {
    print ' checked';
} ?>> Enabled</label>
						                                    <p class="description">Add a file <code>extra.css</code> to the package to be appended to the critical path CSS. The combined result is minified to prevent overlapping CSS.</p>
														</td>
													</tr>
													<tr valign="top">
														<th scope="row">Update Critical CSS</th>
														<td>

						                                     <select name="update" class="wp-update-select">
						                                     	<option value=""<?php if (!$update) {
    print ' selected="selected"';
} ?>>Do not update (store result in /package/output/)</option>
						                                     	<option value="global.css"<?php if ($update === 'global') {
    print ' selected="selected"';
} ?>>Overwrite global Critical CSS</option>
<?php
    $criticalcss_files = $this->CTRL->criticalcss->get_theme_criticalcss();
    if ($criticalcss_files && count($criticalcss_files) > 1) {
        print '<optgroup label="Conditional Critical CSS">';

        foreach ($criticalcss_files as $file => $config) {
            if ($file === 'global.css') {
                continue 1;
            }
            print '<option value="'.htmlentities($file, ENT_COMPAT, 'utf-8').'"'.(($update === $file) ? ' selected="selected"' : '').'>Overwrite '.htmlentities($file . ' - ' . $config['name'], ENT_COMPAT, 'utf-8').'</option>';
        }

        print '</optgroup>';
    } else {
        print '<option value="" disabled="disabled">Conditional Critical CSS is disabled</option>';
    }
?>
															</select>
						                                    <p class="description">Use this option to automatically update WordPress Critical CSS.</p>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</td>
								</tr>
							</table>

							<p style="padding:10px;border:solid #efefef;background:#f1f1f1;"><span style="color:red;font-weight:bold;">Warning:</span> No build tool support is provided via the WordPress support forum! Bugs, software or build tool conflicts occur often and may be OS, Node-software or dependency (version) related. It often is complex, even for the most experienced developer. Please seek help via the (Github) support forums of relevant software. This build tool builder simply relies on 'the latest version' and does not consider bugs or conflicts in the latest software.</p>

							<button type="submit" name="create" class="button button-large button-primary">Install package</button> <button type="submit" name="download" id="download-package" class="button button-large">Download package (zip)</button>

							<br /><br />
							<h1 style="padding-bottom:0px;">How to use<a name="howtouse">&nbsp;</a></h1>
							<p>This WordPress tool creates <em>Gulp.js Critical Path CSS Cenerator Task Packages</em> that make it easy to create professional quality critical path CSS for individual pages.</p>
					
							<strong>Getting started</strong>
							
							<p><strong>Step 1:</strong> Follow the <a href="#installation">installation instructions</a> </p>
							<p><strong>Step 2:</strong> create a Critical CSS Task Package</p>
							<p><strong>Step 3:</strong> start a command line prompt or SSH shell, navigate to <code>/wp-content/themes/THEME_NAME/abovethefold/</code> and run the task, e.g. <code>gulp <strong class="gulp-task-name">task-name</strong></code>.</p>

							<p>Test the quality of the created critical path CSS using the <a href="<?php print add_query_arg(array( 'page' => 'pagespeed-compare' ), admin_url('admin.php')); ?>">Critical CSS Quality Test</a> and optionally use the file <code>extra.css</code> to fix problems in the generated Critical Path CSS.</p>

							<h1 style="padding-bottom:0px;">Installation<a name="installation">&nbsp;</a></h1>

							<h4 style="margin-bottom:5px;margin-top:0px;">Requirements:<a name="requirements">&nbsp;</a></h4>
							<ul style="list-style:disc;padding-left:2em;margin:0px;">
								<li style="margin-bottom:2px;">A regular PC (Windows, Mac or Linux) with command line.</li>
								<li style="margin-bottom:2px;">The installation of <a href="https://nodejs.org/" target="_blank">Node.js</a> (<a href="https://encrypted.google.com/search?q=how+to+install+node.js&amp;hl=<?php print $lgcode; ?>" target="_blank">click here</a> for a how-to).</li>
								<li style="margin-bottom:2px;">The installation of <a href="https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md" target="_blank">Gulp.js</a> (<code>npm install --global gulp-cli</code>).</li>
							</ul>

							<p>The installation of the <em>WordPress Gulp.js Critical Path CSS Generator</em> is required just once for your theme. NPM (Node.js Package Manager) will read the dependencies from package.json and will install them in the /abovethefold/ directory.</p>
							<p><strong>Step 1:</strong> download <strong>package.json</strong> and <strong>gulpfile.js</strong> and upload the files to <code>/wp-content/themes/THEME_NAME/<strong>abovethefold</strong>/</code>. Alternatively click "<em>Auto install</em>" (this will copy the files to your theme directory).</p>
							<p style="margin-top:1em;">

<?php
    /**
     * Verify if already installed
     */
    if ($this->buildtool->is_installed()) {
        print '<button type="submit" name="install_package" class="button button-small button-green">&#x2713; Installed</button> ';
    } else {
        print '<button type="submit" name="install_package" class="button button-small button-primary">Auto install</button> ';
    }
?>
								<button type="submit" name="download_package" class="button button-small">Download package.json &amp; gulpfile.js</button>
							</p>
							<p><strong>Step 2:</strong> start a command line prompt or SSH shell and navigate to <code>/wp-content/themes/THEME_NAME/abovethefold/</code>.</p>
							<p><strong>Step 3:</strong> run the command <code><strong>npm install</strong></code>.</p>
							
							<p><strong>If there are errors during installation you will not be able to get support via the WordPress support forums.</strong><br />Please seek help in platform or software related support forums, for example Github.</p>

							<h1 style="padding-bottom:0px;">More Optimizations</h1>
							<p>There are many other WordPress optimizations that can be performed via Grunt.js or Gulp.js, for example <a href="https://developers.google.com/speed/webp/?hl=<?php print $lgcode; ?>" target="_blank">Google WebP</a> image optimization, uncss (unused CSS stripping), CSS data-uri (CSS images) and more. <a href="https://encrypted.google.com/search?q=grunt+or+gulp+wordpress+optimization&amp;hl=<?=$lgcode;?>" target="_blank">Search Google</a> for more information.</p>
							<div class="info_yellow"><p style="margin:0px;"><strong>Tip:</strong> optimize images of your /themes/ and /uploads/ directory using Gulp.js or Grunt.js <a href="https://github.com/imagemin/imagemin" target="_blank">imagemin</a> using professional image compression software, including Google WebP, and instead of overwriting the original images like many other solutions, place the images in a subdirectory /wp-content/optimized/ and have Nginx serve the optimized image only when the optimized version is newer. It will result in the best performance, with the best image optimization and instant refresh of images when updated in WordPress. And when you want to apply a new image optimization technique, you will have the original files available. A server cron makes it possible to optimize updated images daily.</p></div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>
