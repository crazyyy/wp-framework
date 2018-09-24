<?php

    $sw = $this->CTRL->pwa->get_sw();
    $scope = $this->CTRL->pwa->get_sw_scope();

    // verify service worker
    if (isset($options['pwa']) && intval($options['pwa']) === 1) {
        $this->pwa->install_serviceworker();
    }

    // asset cache policy
    $asset_policy = (isset($options['pwa_cache_assets_policy']) && is_array($options['pwa_cache_assets_policy'])) ? $options['pwa_cache_assets_policy'] : $this->CTRL->pwa->get_sw_default_policy();
?>
<form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_pwa_update'); ?>" class="clearfix">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e('Progressive Web App Optimization', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">

						<div style="text-align:center;"><a href="https://developers.google.com/web/tools/lighthouse/" target="_blank"><img src="<?php print WPABTF_URI; ?>admin/images/google-lighthouse-pwa-validation.jpg" alt="Google Bot" width="100%" style="max-width:1141px;max-height:359px;" title="Google Lighthouse PWA Validation"></a></div>

						<p>Google has been promoting <a href="https://developers.google.com/web/progressive-web-apps/" target="_blank">Progressive Web Apps</a> (PWA) as the future of the internet: a combination of the flexability and openness of the existing web with the user experience advantages of native mobile apps. In essence: a mobile app that can be indexed by Google and that can be managed by WordPress.</p>
						<p>Google provides an extensive test called <a href="https://developers.google.com/web/tools/lighthouse/" target="_blank">Lighthouse</a> that tests for validity against the key qualities of a Progressive Web App: performance, accessibility, and more.</p>
						<p>This tool enables to score 100 / 100 / 100 / 100 in the lighthouse test and validate a website as Progressive Web App for improved mobile user experiences and findability.</p>
						<p>At the core of the features of a Progressive Web App is a <a href="https://developers.google.com/web/fundamentals/getting-started/primers/service-workers" target="_blank">HTML5 Service Worker</a>. It's not supported by Internet Explorer and Opera (<a href="https://jakearchibald.github.io/isserviceworkerready/" target="_blank">browser compatibility</a>).</p>

<table class="form-table">
	<tr valign="top">
		<th scope="row">Enable PWA</th>
		<td>
			<label><input type="checkbox" name="abovethefold[pwa]" value="1"<?php if (isset($options['pwa']) && intval($options['pwa']) === 1) {
    print ' checked';
} ?><?php if (isset($options['pwa'])) {
    print ' onchange="if (jQuery(this).is(\':checked\')) {jQuery(\'#pwa_unreg\').hide();jQuery(\'#pwa_reg\').show();} else {jQuery(\'#pwa_unreg\').show();jQuery(\'#pwa_reg\').hide();}"';
} else {
    print ' onchange="if (jQuery(this).is(\':checked\')) {jQuery(\'#pwa_reg\').show();} else {jQuery(\'#pwa_reg\').hide();}"';
} ?> /> Enabled</label>
			<p class="description">Enable PWA functionality in browsers that support <a href="https://jakearchibald.github.io/isserviceworkerready/" target="_blank">Service Worker</a>.</p>
			<div id="pwa_reg" style="margin-top:0.5em;<?php if (!isset($options['pwa']) || !$options['pwa']) {
    print ' display:none;';
} ?>">
<label><input type="checkbox" name="abovethefold[pwa_register]" value="1"<?php if (!isset($options['pwa']) || !isset($options['pwa_register']) || intval($options['pwa_register']) === 1) {
    print ' checked';
} ?> /> Register Service Worker</label>
			<p class="description">Unchecking this option enables to combine the PWA Service Worker with other service workers, for example for <a href="<?php echo admin_url('plugin-install.php?s=push+notifications&tab=search&type=term'); ?>">Push Notifications</a>. If you want to load the PWA Service Worker using <code>importScripts</code> use the file <a href="<?php echo esc_attr(trailingslashit(site_url()) . $sw['filename']); ?>" target="_blank" download="<?php echo esc_attr($sw['filename']); ?>">/<?php echo esc_html($sw['filename']); ?></a>.</p>
</div>
			<div id="pwa_unreg" style="margin-top:0.5em;<?php if (!isset($options['pwa']) || $options['pwa']) {
    print ' display:none;';
} ?>">
<label><input type="checkbox" name="abovethefold[pwa_unregister]" value="1"<?php if (isset($options['pwa_unregister']) && intval($options['pwa_unregister']) === 1) {
    print ' checked';
} ?> /> Unregister Service Worker</label>
			<p class="description">Unregister the PWA Service Worker for visitors.</p>
</div>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">&nbsp;</th>
		<td style="padding-top:0px;padding-bottom:0px;">
			<h5 class="h">&nbsp;Service Worker Scope</h5>
			<input type="text" size="40" name="abovethefold[pwa_scope]" value="<?php if (isset($options['pwa_scope'])) {
    echo esc_attr($options['pwa_scope']);
} ?>" placeholder="Leave blank for global scope" title="Global scope: <?php echo esc_attr($scope); ?>">
			<p class="description">Enter an optional <a href="https://developers.google.com/web/fundamentals/getting-started/primers/service-workers#register_a_service_worker" target="_blank">scope</a> for the service worker, e.g. <code>/blog/</code>. The scope restricts the PWA functionality to a path.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">&nbsp;</th>
		<td style="padding-bottom:0px;">
			<h5 class="h">&nbsp;Push Notification API</h5>
			<p class="description">The PWA Service Worker supports sending Push Notifications (<a href="https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification" target="_blank">documentation</a>). The API is <code>Abtf.push(title,options)</code> (<a href="javascript:void(0);" onclick="jQuery('#push_example').fadeToggle();">show example</a>)</p>

			<pre style="display:none;padding:10px;border:solid 1px #efefef;" id="push_example">/* You must first obtain <a href="https://developer.mozilla.org/en-US/docs/Web/API/Notification/requestPermission" target="_blank">permissions</a> */
Notification.requestPermission(function(result) {
	if (result === 'granted') {
		Abtf.push('Welcome back!',{
			body: 'Buzz! Buzz!',
			icon: '../images/touch/chrome-touch-icon-192x192.png',
			vibrate: [200, 100, 200, 100, 200, 100, 200],
			tag: 'vibration-sample'
		})
		.then(function(status) {
			console.log('Notification sent', status);
		});
	}
});</pre>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php
submit_button(__('Save'), 'primary large', 'is_submit', false);
?></th>
		<td style="padding-top:0px;">
			<p class="info_yellow" style="margin-top:1em;font-size:14px;" id="edit"><strong>Tip:</strong> For debugging the Service Worker see: <strong>chrome://serviceworker-internals</strong> (copy in the address bar)</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Cache Pages</th>
		<td>
			<label><input type="checkbox" name="abovethefold[pwa_cache_pages]" value="1"<?php if (isset($options['pwa_cache_pages']) && intval($options['pwa_cache_pages']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
			<p class="description">Cache HTML pages in the service worker. This option enables to make a website available offline.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">&nbsp;</th>
		<td style="padding-top:0px;">
			<div>
			<h5 class="h">&nbsp;HTML Cache Strategy</h5>
			<select name="abovethefold[pwa_cache_pages_strategy]" onchange="if (jQuery(this).val() === 'cache') { jQuery('.cache_strategy_options').show(); } else { jQuery('.cache_strategy_options').hide();}">
				<option value="network"<?php if (!isset($options['pwa_cache_pages_strategy']) || $options['pwa_cache_pages_strategy'] === 'network') {
    print ' selected';
} ?>>Network &rarr; Cache</option>
				<option value="cache"<?php if (isset($options['pwa_cache_pages_strategy']) && $options['pwa_cache_pages_strategy'] === 'cache') {
    print ' selected';
} ?>>Cache &rarr; Network</option>
				<option value="event"<?php if (isset($options['pwa_cache_pages_strategy']) && $options['pwa_cache_pages_strategy'] === 'event') {
    print ' selected';
} ?>>On demand (event based)</option>
				</select>
				</div>
			<div class="clearfix" style="clear:both;"></div>
			<p class="description">By default HTML pages are fetched from the network with the cache as fallback when the network fails. Select the Cache First strategy to serve pages from cache with the network as backup. Select the On demand strategy to use a Cache First strategy with a manual (event based) cache storage (e.g. "click to read this page offline"). The API is <code>Abtf.offline(url);</code> which can also be used for precaching. (<a href="javascript:void(0);" onclick="jQuery('#precache_example').fadeToggle();">show example</a>)</p>

			<pre style="display:none;padding:10px;border:solid 1px #efefef;" id="precache_example">Abtf.offline(['/shop/','/shop/product1.html','/wp-content/uploads/.../product-image.jpg'])
.then(function(status) {
	console.log('Resources available offline', status);
});</pre>
		</td>
	</tr>
	<tr valign="top" class="cache_strategy_options"<?php if (!(isset($options['pwa_cache_pages_strategy']) && $options['pwa_cache_pages_strategy'] === 'cache')) {
    print ' style="display:none;"';
} ?>>
		<th scope="row">&nbsp;</th>
		<td style="padding-top:0px;">
			<div>
				<h5 class="h">&nbsp;Cache Update Interval</h5>
				<input type="number" name="abovethefold[pwa_cache_pages_update_interval]" style="width:120px;" value="<?php if (isset($options['pwa_cache_pages_update_interval']) && trim($options['pwa_cache_pages_update_interval']) !== '') {
    print esc_attr($options['pwa_cache_pages_update_interval']);
} ?>" placeholder="Always">
				<p class="description">Enter a time in seconds to update cached pages using the network. Leave blank to update the cache on each request.</p>
			</div>
			<div style="margin-top:1em;">
				<h5 class="h">&nbsp;Cache Max Age</h5>
				<input type="number" name="abovethefold[pwa_cache_pages_max_age]" style="width:120px;" value="<?php if (isset($options['pwa_cache_pages_max_age']) && trim($options['pwa_cache_pages_max_age']) !== '') {
    print esc_attr($options['pwa_cache_pages_max_age']);
} ?>">
				<p class="description">Enter a expire time in seconds. The maximum age does not override HTTP expire headers.</p>
			</div>
			<div style="margin-top:1em;">
				<h5 class="h">&nbsp;HEAD based network update</h5>
				<label><input type="checkbox" name="abovethefold[pwa_cache_pages_head_update]" value="1"<?php if (isset($options['pwa_cache_pages_head_update']) && intval($options['pwa_cache_pages_head_update']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
				<p class="description">Use a HTTP HEAD request and <code>etag</code> and/or <code>last-modified</code> header verification to update the cache. This option saves bandwidth while enabling quick updates of changed content, however, it adds an extra request for content that always changes.</p>
			</div>
			<div style="margin-top:1em;">
				<h5 class="h">&nbsp;Notify client on update</h5>
				<label><input type="checkbox" name="abovethefold[pwa_cache_pages_update_notify]" value="1"<?php if (isset($options['pwa_cache_pages_update_notify']) && intval($options['pwa_cache_pages_update_notify']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
				<p class="description">Send a notification to the client when the cache is updated. The API is <code>jQuery(window).on('sw-update',fn);</code> (<a href="javascript:void(0);" onclick="jQuery('#update_notify_example').fadeToggle();">show example</a>).</p>
				
				<pre style="display:none;padding:10px;border:solid 1px #efefef;" id="update_notify_example">jQuery(window).on('sw-update',function(e){
	if (e.detail.url === '/my/ajax-feed.json') {
		/* the Service Worker detected new content, update view */
		updateFeedView();
	}
});</pre>
			</div>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">&nbsp;</th>
		<td style="padding-top:0px;">

			<h5 class="h">&nbsp;HTML Cache Include List</h5>
			<textarea class="json-array-lines" name="abovethefold[pwa_cache_pages_include]" placeholder="Leave blank to cache all pages"><?php if (isset($options['pwa_cache_pages_include'])) {
    echo $this->CTRL->admin->newline_array_string($options['pwa_cache_pages_include']);
} ?></textarea>
			<p class="description">Enter (parts of) page URL's to cache, e.g. <code>category/</code> to match all pages in a category.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Preload on Mouse Down</th>
		<td>
			<label><input type="checkbox" name="abovethefold[pwa_preload_mousedown]" value="1"<?php if (isset($options['pwa_preload_mousedown']) && intval($options['pwa_preload_mousedown']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
			<p class="description">Start preloading navigation requests in the Service Worker on mouse down. Older mobile devices including iOS8 have a <a href="https://encrypted.google.com/search?q=300ms+tap+delay+mobile" target="_blank" rel="noopener">300ms click delay</a> which is a lot of time wasted for navigation clicks. An average mouse click also has a 200-500ms delay before navigation starts. This feature enables to start preloading a page in the Service Worker on mouse down/touch start to make use of the otherwise wasted delay.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php
submit_button(__('Save'), 'primary large', 'is_submit', false);
?></th>
		<td style="padding-top:0px;">
			<h5 class="h">&nbsp;Offline Page</h5>
			<select id="offline_page" name="abovethefold[pwa_cache_pages_offline]" size="80" placeholder="/path/to/offline.html">
				<?php if (isset($options['pwa_cache_pages_offline']) && trim($options['pwa_cache_pages_offline']) !== '') {

                    // WordPress URL?
    $postid = url_to_postid($options['pwa_cache_pages_offline']);
    if ($postid) {
        $name = $postid . '. ' . str_replace(home_url(), '', get_permalink($postid)) . ' - ' . get_the_title($postid);
    } else {
        $name = $options['pwa_cache_pages_offline'];
    }

    print '<option data-data="'.esc_attr(json_encode(array('name' => $name))).'" value="' . esc_attr($options['pwa_cache_pages_offline']) . '" selected>' . esc_attr($options['pwa_cache_pages_offline']) . '</option>';
} ?>
			</select>
			<p class="description">Enter an URL or absolute path to a HTML page to display when the network is offline and when the requested page is not available in cache.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Cache Assets</th>
		<td>
			<label><input type="checkbox" name="abovethefold[pwa_cache_assets]" value="1"<?php if (isset($options['pwa_cache_assets']) && intval($options['pwa_cache_assets']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
			<p class="description" style="margin-bottom:1em;">Cache assets such as scripts and styles. Use a request and/or response filter to apply a cache strategy and enable or disable caching for specific assets.</p>

			<div id="cache_assets"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'pagespeed'); ?></div></div>
<input type="hidden" name="abovethefold[pwa_cache_assets_policy]" id="cache_assets_src" value="<?php echo esc_attr(json_encode($asset_policy)); ?>"  />
			
        	<div style="clear:both;height:10px;"></div>
			<div style="float:right;"><span class="ref" style="position:relative;top:-5px;">JSON editor</span> <span class="star"><a class="github-button" data-manual="1" href="https://github.com/josdejong/jsoneditor" data-icon="octicon-star" data-show-count="true" aria-label="Star josdejong/jsoneditor on GitHub">Star</a></span></div>
		</td>
	</tr>
		<tr valign="top">
		<td colspan="2" style="padding:0px;">
<?php
submit_button(__('Save'), 'primary large', 'is_submit', false);
?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">CSS online/offline class</th>
		<td>
			<label><input type="checkbox" name="abovethefold[pwa_offline_class]" value="1"<?php if (!isset($options['pwa_offline_class']) || intval($options['pwa_offline_class']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
			<p class="description">Add the class <code>offline</code> to <code>&lt;body&gt;</code> based on <a href="https://developer.mozilla.org/en-US/docs/Online_and_offline_events" target="_blank">HTML5 online/offline events</a>. This feature enables to add a user friendly notice via CSS when the connection is offline.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Cache Size</th>
		<td>
			<input type="number" name="abovethefold[pwa_cache_max_size]" style="width:80px;" value="<?php if (isset($options['pwa_cache_max_size']) && trim($options['pwa_cache_max_size']) !== '') {
    print esc_attr($options['pwa_cache_max_size']);
} ?>" placeholder="1000">
			<p class="description">Maximum cache entries to maintain. The default is 1000.</p>
		
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Cache Version</th>
		<td>
			<input type="text" name="abovethefold[pwa_cache_version]" size="20" value="<?php if (isset($options['pwa_cache_version']) && trim($options['pwa_cache_version']) !== '') {
    print esc_attr($options['pwa_cache_version']);
} ?>">
			<p class="description">Optionally enter a cache version. This feature enables to invalidate existing caches.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Cache Preload</th>
		<td>
			<textarea class="json-array-lines" name="abovethefold[pwa_cache_preload]"><?php if (isset($options['pwa_cache_preload'])) {
    echo $this->CTRL->admin->newline_array_string($options['pwa_cache_preload']);
} ?></textarea>
			<p class="description">Enter URLs or absolute path's to preload for offline availability, e.g. <code>/path/to/page.html</code> or <code>/path/to/image.jpg</code>.</p>

			<p style="margin-top:1em;"><label><input type="checkbox" name="abovethefold[pwa_cache_preload_require]" value="1"<?php if (isset($options['pwa_cache_preload_require']) && intval($options['pwa_cache_preload_require']) === 1) {
    print ' checked';
} ?> /> Require preloading to complete in Service Worker installation. This option will activate the service worker after all assets have been preloaded.</label></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Web App Manifest<a name="manifest">&nbsp;</a></th>
		<td>

			<p style="margin-bottom:1em;">The <a href="https://developers.google.com/web/fundamentals/engage-and-retain/web-app-manifest/" target="_blank">Web App Manifest</a> is a JSON document that enables to control how a website app appears to the user in areas where they would expect to see apps. It is required to validate as Google PWA. (<a href="https://w3c.github.io/manifest/" target="_blank">W3C documentation</a>)</p>

<?php
    $manifestjson = array();
    $manifest = trailingslashit(ABSPATH) . 'manifest.json';
    if (!file_exists($manifest)) {
        print '<div class="warning_red" style="margin-bottom:1em;"><strong>' . trailingslashit(home_url()) . 'manifest.json</strong> not found. Add the file to the root of your WordPress installation and make it writeable.
        	<div style="margin-top:10px;">
        		<button type="submit" name="create_manifest" class="button">Create manifest.json</button>
        	</div>
        </div>';
    } elseif (!is_writeable($manifest)) {
        print '<p class="warning_red" style="margin-bottom:1em;"><strong>' . trailingslashit(home_url()) . 'manifest.json</strong> is not writeable. Please make the file writeale for WordPress (PHP) to enable online editing and automatic <code>serviceworker</code> configuration.</p>';
    } else {
        $json = file_get_contents(trailingslashit(ABSPATH) . 'manifest.json');
        $manifestjson = @json_decode(trim($json), true);
        if (!is_array($manifestjson)) {
            $manifestjson = array();
            print '<div class="warning_red" style="margin-bottom:1em;"><strong>' . trailingslashit(home_url()) . 'manifest.json</strong> does not contain valid JSON. <hr /><textarea style="width:100%;height:70px;">'.esc_html($json).'</textarea></div>';
        } ?>
			<div id="webapp_manifest"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'pagespeed'); ?></div></div>
<input type="hidden" name="abovethefold[manifest_json]" id="webapp_manifest_src" value="<?php echo esc_attr(json_encode($manifestjson)); ?>"  />
<?php
    }
?>
        	<div style="clear:both;height:10px;"></div>
			<div style="float:right;"><span class="ref" style="position:relative;top:-5px;">JSON editor</span> <span class="star"><a class="github-button" data-manual="1" href="https://github.com/josdejong/jsoneditor" data-icon="octicon-star" data-show-count="true" aria-label="Star josdejong/jsoneditor on GitHub">Star</a></span></div>
			<p>There are several online tools that can help with Web App Manifest creation. <a href="https://app-manifest.firebaseapp.com/" target="_blank">https://app-manifest.firebaseapp.com/</a> is a simple one. <a href="https://encrypted.google.com/search?q=<?php print urlencode('webapp manifest creator'); ?>" target="_blank">Search Google</a> for more creators.</p>

			<p style="margin-top:1em;"><label><input type="checkbox" name="abovethefold[manifest_json_update]" value="1"<?php if (!isset($options['manifest_json_update']) || intval($options['manifest_json_update']) === 1) {
    print ' checked';
} ?> /> Update manifest.json</label></p>
			<p class="description">Update manifest.json when saving settings.</p>

			<p style="margin-top:1em;"><label><input type="checkbox" name="abovethefold[pwa_manifest_meta]" value="1"<?php if (!isset($options['pwa_manifest_meta']) || intval($options['pwa_manifest_meta']) === 1) {
    print ' checked';
} ?> /> Link to manifest.json</label></p>
			<p class="description">Add a link to manifest.json in the <code>&lt;head&gt;</code> of the page.</p>

		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Web App Meta</th>
		<td>
			<textarea class="json-array-lines" name="abovethefold[pwa_meta]" style="<?php if (isset($options['pwa_meta']) && $options['pwa_meta']) {
    print 'height:200px;';
} ?>"><?php if (isset($options['pwa_meta'])) {
    echo esc_html($options['pwa_meta']);
} ?></textarea>
			<p class="description">Enter Web App related meta tags to include in the <code>&lt;head&gt;</code> of the page. (<a href="https://developers.google.com/web/ilt/pwa/lab-auditing-with-lighthouse#43_add_tags_for_other_browsers" target="_blank">documentation</a>). There are many <a href="https://encrypted.google.com/search?q=<?php print urlencode('web app icon generators'); ?>" target="_blank">Web App Meta Generators</a> that enable to fine tune the settings for an optimal mobile representation.</p>

			<p class="info_yellow" style="margin-top:1em;"><strong>Tip:</strong> Use the Google Chrome <strong>Application &gt; Manifest</strong> tab to debug the settings and to simulate <em>Add to homescreen</em>.</p> 

		</td>
	</tr>
	<tr valign="top">
		<td colspan="2" style="padding:0px;">
<?php
submit_button(__('Save'), 'primary large', 'is_submit', false);
?>
		</td>
	</tr>
</table>


						</div>
					</div>


	<!-- End of #post_form -->

				</div>
			</div> <!-- End of #post-body -->
		</div> <!-- End of #poststuff -->
	</div> <!-- End of .wrap .nginx-wrapper -->
</form>
