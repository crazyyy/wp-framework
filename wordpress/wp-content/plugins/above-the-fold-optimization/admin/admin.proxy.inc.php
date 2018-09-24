<?php

    // CSS Proxy Enabled?
    $cssProxy = (isset($options['css_proxy']) && intval($options['css_proxy']) === 1);
    $cssProxyOptions = ($cssProxy) ? '' : 'display:none;';
    $cssProxyOptionsHide = (!$cssProxy) ? '' : 'display:none;';


    // Javascript Proxy Enabled?
    $jsProxy = (isset($options['js_proxy']) && intval($options['js_proxy']) === 1);
    $jsProxyOptions = ($jsProxy) ? '' : 'display:none;';
    $jsProxyOptionsHide = (!$jsProxy) ? '' : 'display:none;';


    // js preload list
    if (isset($options['js_proxy_preload']) && !empty($options['js_proxy_preload'])) {
        $jsPreload = array();
        foreach ($options['js_proxy_preload'] as $url) {
            $jsPreload[] = (is_string($url)) ? $url : json_encode($url);
        }
        $jsPreload = $this->CTRL->admin->newline_array_string($jsPreload);
    } else {
        $jsPreload = '';
    }

    // css preload list
    if (isset($options['css_proxy_preload']) && !empty($options['css_proxy_preload'])) {
        $cssPreload = array();
        foreach ($options['css_proxy_preload'] as $url) {
            $cssPreload[] = (is_string($url)) ? $url : json_encode($url);
        }
        $cssPreload = $this->CTRL->admin->newline_array_string($cssPreload);
    } else {
        $cssPreload = '';
    }

    // cache stats
    $cache_stats = $this->CTRL->proxy->cache_stats();

?>
<form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_proxy_update'); ?>" class="clearfix">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">

						<h3 class="hndle">
							<span><?php _e('External Resource Proxy', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">
							<div style="float:right;z-index:9000;position:relative;"><img src="<?php print WPABTF_URI; ?>admin/images/browsercache-error.png" alt="Google Bot" width="225" title="Leverage browser caching"></div>


							<p>The external resource proxy loads external resources such as scripts and stylesheets via a caching proxy.</p>

							<p>This feature enables to pass the <a href="https://developers.google.com/speed/docs/insights/LeverageBrowserCaching?hl=<?php print $lgcode;?>" target="_blank">Leverage browser caching</a> rule from Google PageSpeed Insights.</p>

							<table class="form-table">
								
								<tr valign="top">
									<th scope="row">Proxy Scripts</th>
									<td>
			                            <label><input type="checkbox" name="abovethefold[js_proxy]" onchange="if (jQuery(this).is(':checked')) { jQuery('.proxyjsoptions').show(); } else { jQuery('.proxyjsoptions').hide(); }" value="1"<?php if ($jsProxy) {
    print ' checked';
} ?>> Enabled</label>
			                            <p class="description">Capture external scripts and load the scripts through a caching proxy.</p>
									</td>
								</tr>
								<tr valign="top" class="proxyjsoptions" style="<?php print $jsProxyOptions; ?>">
									<th scope="row">&nbsp;</th>
									<td style="padding-top:0px;">
										<h5 class="h">&nbsp;Proxy Include List</h5>
										<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[js_proxy_include]" placeholder="Leave blank to proxy all external scripts..."><?php if (isset($options['js_proxy_include'])) {
    echo $this->CTRL->admin->newline_array_string($options['js_proxy_include']);
} ?></textarea>
										<p class="description">Enter (parts of) external javascript files to proxy, e.g. <code>google-analytics.com/analytics.js</code> or <code>facebook.net/en_US/sdk.js</code>. One script per line. </p>
									</td>
								</tr>
								<tr valign="top" class="proxyjsoptions" style="<?php print $jsProxyOptions; ?>">
									<th scope="row">&nbsp;</th>
									<td style="padding-top:0px;">
										<h5 class="h">&nbsp;Proxy Exclude List</h5>
										<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[js_proxy_exclude]"><?php if (isset($options['js_proxy_exclude'])) {
    echo $this->CTRL->admin->newline_array_string($options['js_proxy_exclude']);
} ?></textarea>
										<p class="description">Enter (parts of) external javascript files to exclude from the proxy. One script per line.</p>
									</td>
								</tr>
								<tr valign="top" class="proxyjsoptions" style="<?php print $jsProxyOptions; ?>">
									<th scope="row">&nbsp;</th>
									<td style="padding-top:0px;">
										<h5 class="h">&nbsp;Proxy Preload List</h5>
										<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[js_proxy_preload]"><?php if ($jsPreload !== '') {
    echo $jsPreload;
} ?></textarea>
										<p class="description">Enter the exact url or JSON config object [<a href="#jsoncnf" title="More information">?</a>] of external scripts to preload for "script injected" async script capture, e.g. <code>https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js</code>. This setting will enable the proxy to load the cache url instead of the WordPress PHP proxy url. One url or JSON object per line.</p>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Proxy Stylesheets</th>
									<td>
								        <label><input type="checkbox" name="abovethefold[css_proxy]" onchange="if (jQuery(this).is(':checked')) { jQuery('.proxycssoptions').show(); jQuery('.proxycssoptionshide').hide(); } else { jQuery('.proxycssoptions').hide(); jQuery('.proxycssoptionshide').show(); }" value="1"<?php if ($cssProxy) {
    print ' checked';
} ?>> Enabled</label>
								        <p class="description">Capture external stylesheets and load the files through a caching proxy. </p>
									</td>
								</tr>
								<tr valign="top" class="proxycssoptions" style="<?php print $cssProxyOptions; ?>">
									<th scope="row">&nbsp;</th>
									<td style="padding-top:0px;">
										<h5 class="h">&nbsp;Proxy Include List</h5>
										<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[css_proxy_include]" placeholder="Leave blank to proxy all external stylesheets..."><?php if (isset($options['css_proxy_include'])) {
    echo $this->CTRL->admin->newline_array_string($options['css_proxy_include']);
} ?></textarea>
										<p class="description">Enter (parts of) external stylesheets to proxy, e.g. <code>googleapis.com/jquery-ui.css</code>. One stylesheet per line. </p>
									</td>
								</tr>
								<tr valign="top" class="proxycssoptions" style="<?php print $cssProxyOptions; ?>">
									<th scope="row">&nbsp;</th>
									<td style="padding-top:0px;">
										<h5 class="h">&nbsp;Proxy Exclude List</h5>
										<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[css_proxy_exclude]"><?php if (isset($options['css_proxy_exclude'])) {
    echo $this->CTRL->admin->newline_array_string($options['css_proxy_exclude']);
} ?></textarea>
										<p class="description">Enter (parts of) external stylesheets to exclude from the proxy. One stylesheet per line.</p>
									</td>
								</tr>
								<tr valign="top" class="proxycssoptions" style="<?php print $cssProxyOptions; ?>">
									<th scope="row">&nbsp;</th>
									<td style="padding-top:0px;">
										<h5 class="h">&nbsp;Proxy Preload List</h5>
										<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[css_proxy_preload]"><?php if ($cssPreload !== '') {
    echo $cssPreload;
} ?></textarea>
										<p class="description">Enter the exact url or JSON config object of external stylesheets to preload for "script injected" async stylesheet capture, e.g. <code>http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css</code>. This setting will enable the proxy to load the cache url instead of the WordPress PHP proxy url. One url or JSON object per line.</p>
										</fieldset>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">&nbsp;</th>
									<td style="padding-top:0px;">
										<a name="jsoncnf">&nbsp;</a>
										<fieldset style="border:solid 1px #efefef;padding:10px;margin:0px;margin-top:7px;background:#f1f1f1;">
											<h4 style="margin:0px;padding:0px;margin-bottom:5px;">JSON Proxy Config Object</h4>
											<p class="description" style="margin-top:0px;">JSON config objects enable advanced file based proxy configuration. JSON objects can be used together with simple file entry and must be placed on one line (no spaces are allowed).</p>
											<p class="description">JSON config objects must contain a target url (the url that will be downloaded by the proxy). Regular expression enables to match a source URL in the HTML, e.g. an URL with a cache busting date string (?time) or an url on a different host. Valid parameters are <code>url</code>, <code>regex</code>, <code>regex-flags</code>, <code>cdn</code> and <code>expire</code> (expire time in seconds).</p>
											<p class="description" style="margin-bottom:0px;margin-top:5px;">Example:
											<br /><code>{"regex": "^https://app\\.analytics\\.com/file\\.js\\?\\d+$", "regex-flags":"i", "url": "https://app.analytics.com/file.js", "expire": "2592000"}</code></p>
										</fieldset>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Proxy CDN</th>
									<td>
			                            <input type="url" name="abovethefold[proxy_cdn]" style="width:100%;" placeholder="Leave blank for the default WordPress (plugin modified) upload directory url..." value="<?php if (isset($options['proxy_cdn'])) {
    echo htmlentities($options['proxy_cdn'], ENT_COMPAT, 'utf-8');
} ?>" />
			                            <p class="description">Enter the default CDN url for cached resources, e.g. <code><strong>https://cdn.domain.com</strong>/wp-content/uploads/abovethefold/proxy/.../resource.js</code>. You can set a custom CDN per individual resource using a JSON config object.</p>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Proxy URL</th>
									<td>
			                            <input type="url" name="abovethefold[proxy_url]" style="width:100%;" placeholder="Leave blank for the default WordPress PHP based proxy url..." value="<?php if (isset($options['proxy_url'])) {
    echo htmlentities($options['proxy_url'], ENT_COMPAT, 'utf-8');
} ?>" />
			                            <p class="description">Enter a custom proxy url to serve captured external resources. There are 2 parameters that can be used in the url: <code>{PROXY:URL}</code> and <code>{PROXY:TYPE}</code>.</p>
			                            <p class="description">E.g.: <code>https://nginx-proxy.mydomain.com/{PROXY:TYPE}/{PROXY:URL}</code>. Type is the string <u>js</u> or <u>css</u>.</p>
									</td>
								</tr>
							</table>
							<hr />
							<?php
                                submit_button(__('Save'), 'primary large', 'is_submit', false);
                            ?>

							<br /><br />

							<h3 style="margin:0px;padding:0px;" id="stats">Cache Stats<a name="stats">&nbsp;</a></h3>
							<table>
								<tbody>
									<tr>
										<td align="right" width="70" style="text-align:right;font-size:14px;">Files:</td>
										<td style="font-size:14px;"><?php echo number_format_i18n($cache_stats['files'], 0); ?></td>
									</tr>
									<tr>
										<td align="right" width="70" style="text-align:right;font-size:14px;">Size:</td>
										<td style="font-size:14px;"><?php echo $this->CTRL->admin->human_filesize($cache_stats['size']); ?></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2" style="padding:0px;margin:0px;font-size:11px;">
											<p style="padding:0px;margin:0px;font-size:11px;">Stats last updated: <?php echo date('r', $cache_stats['date']); ?></p>
											<hr />
											<a href="<?php echo add_query_arg(array( 'page' => 'pagespeed-proxy', 'update_cache_stats' => 1 ), admin_url('admin.php')); ?>" class="button button-small">Refresh Stats</a>
											<a href="<?php echo add_query_arg(array( 'page' => 'pagespeed-proxy', 'empty_cache' => 1 ), admin_url('admin.php')); ?>" onclick="if (!confirm('Are you sure you want to empty the cache directory?',true)) { return false; } " class="button button-small">Empty Cache</a>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
</form>
