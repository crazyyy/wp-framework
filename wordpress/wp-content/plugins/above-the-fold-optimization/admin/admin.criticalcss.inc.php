
<nav class="subnav">
	<span class="t">Submenu:</span>
	<a href="<?php echo add_query_arg(array('page' => 'pagespeed-criticalcss-test'), admin_url('admin.php')); ?>" class="f">Quality Test (Split View)</a>
	<a href="<?php echo $this->CTRL->view_url('critical-css-editor'); ?>#editor"  target="_blank" rel="noopener">Live Editor</a>
	<a href="<?php echo add_query_arg(array('page' => 'pagespeed-build-tool'), admin_url('admin.php')); ?>">Gulp.js Critical CSS Generator</a>
</nav>

<form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_criticalcss_update'); ?>" data-addccss="<?php echo admin_url('admin-post.php?action=abtf_add_ccss'); ?>" data-delccss="<?php echo admin_url('admin-post.php?action=abtf_delete_ccss'); ?>" id="abtf_settings_form" class="clearfix" style="margin-top:0px;">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">

						<h3 class="hndle">
							<span><?php _e('Critical Path CSS', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">
							<p>Critical Path CSS is the minimum CSS required to render above the fold content. Please read the <a href="https://developers.google.com/speed/docs/insights/PrioritizeVisibleContent?hl=<?php print $lgcode;?>" target="_blank">documentation by Google</a> before you continue.</p>
							<p><a href="https://github.com/addyosmani/critical-path-css-tools" target="_blank">This article</a> by a Google engineer provides information about the available methods for creating critical path CSS. <a href="https://addyosmani.com/blog/detecting-critical-above-the-fold-css-with-paul-kinlan-video/?<?php print $utmstring; ?>" target="_blank">This blog</a> (with video) by two Google engineers provides information about the essence of Critical Path CSS creation.</p>
							
							<div class="info_yellow">
								<p style="margin:0px;"><strong>Tip:</strong> If you notice a <a href="https://en.wikipedia.org/wiki/Flash_of_unstyled_content" target="_blank">Flash of Unstyled Content</a> (FOUC), use the <a href="<?php print add_query_arg(array( 'page' => 'pagespeed-criticalcss-test' ), admin_url('admin.php')); ?>">Quality Test-tab</a> to fine tune the critical path CSS for a perfect above the fold display.</p>
							</div>

							<table class="form-table">
								<tr valign="top">
									<td class="criticalcsstable">

										<h3 style="padding:0px;margin:0px;margin-bottom:10px;">Critical Path CSS</h3>

										<p class="description" style="margin-bottom:1em;"><?php _e('Configure the Critical Path CSS to be inserted inline into the <code>&lt;head&gt;</code> of the page.', 'abovethefold'); ?></p>

										<ul class="menu ui-sortable" style="width:auto!important;margin-top:0px;padding-top:0px;">
											
											<?php
                                                require_once('admin.settings.criticalcss.inc.php');
                                            ?>

											<?php
                                                require_once('admin.settings.conditionalcss.inc.php');
                                            ?>
										</ul>
									</td>
								</tr>
								<tr valign="top">
									<td class="criticalcsstable">
										<br />

										<h3 style="padding:0px;margin:0px;margin-bottom:10px;"><?php _e('Extract Full CSS', 'abovethefold'); ?></h3>

										<p class="description">For the creation of Critical Path CSS you need the full CSS of a page. This tool allows you to extract the full CSS from any url and optionally to select the specific CSS files you want to extract.</p>
										<p class="description" style="margin-bottom:1em;">You can quickly output the full CSS of any url by adding the query string <code><strong>?extract-css=<?php print md5(SECURE_AUTH_KEY . AUTH_KEY); ?>&amp;output=print</strong></code>.</p>

											<select id="fullcsspages" class="wp-pageselect"><option value=""></option><option value="<?php print home_url(); ?>">Home Page (index)</option></select>
											<div style="margin-top:10px;">
											<button type="button" id="fullcsspages_dl" rel="<?php print md5(SECURE_AUTH_KEY . AUTH_KEY); ?>" class="button button-large">Download</button>
											<button type="button" id="fullcsspages_print" rel="<?php print md5(SECURE_AUTH_KEY . AUTH_KEY); ?>" class="button button-large">Print</button>
											</div>
											<br /><br />
									</td>
								</tr>
							</table>

							<h1 id="filter">Custom Critical CSS Condition</h1>
							<p>You can add a custom critical CSS condition using a filter function. For example, if you want to add critical CSS for blog category X, you can use the following filter function.</p>
							<blockquote><pre>
/**
 * Custom Critical Path CSS Condition
 *
 * @plugin Above The Fold Optimization
 * @link https://wordpress.org/plugins/above-the-fold-optimization/
 */
function my_critical_css_condition( $params = array() ) {

	// Category X?
	if (is_category('x')) {
		return true; // match
	}

	return false; // no match
}</pre></blockquote>

							<p>To add the condtion to a critical CSS file, type <code>filter:my_critical_css_condition</code> in the condition search field. You can add a comma separated list with JSON encoded values to be passed to the filter <code>$params</code> by appending <code>:1,2,3,"variable","var"</code>. The filter function should return true or false.</p>
						
							<br />
							
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>