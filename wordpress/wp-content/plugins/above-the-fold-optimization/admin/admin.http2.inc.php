<?php


    // asset cache policy
    $http2_push_config = (isset($options['http2_push_config']) && is_array($options['http2_push_config'])) ? $options['http2_push_config'] : array();
    if (!is_array($http2_push_config) || empty($http2_push_config)) {
        $http2_push_config = '[]';
    } else {
        $http2_push_config = json_encode($http2_push_config);
    }
?>
<style>
fieldset {
border: 1px solid #efefef;
padding: 5px;
padding-top:0px;
display:inline;
position:relative;
top:-4px;
}
fieldset legend {
padding: 0px;
padding-left:7px;
font-weight: bold;
}
</style>
<form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_http2_update'); ?>" class="clearfix">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e('HTTP/2 Optimization', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">

						<p><a href="https://developers.google.com/web/fundamentals/performance/http2/" target="_blank">HTTP/2</a> is a new version of the internet protocol originally developed by Google (SPDY). This plugin enables to make use of some it's optimization potential.</p>
						<a href="https://tools.keycdn.com/http2-test?url=<?php echo esc_attr(home_url()); ?>" target="_blank" class="button">Test your website for HTTP/2 support</a>

<table class="form-table">
	<tr valign="top">
		<th scope="row">HTTP/2 Server Push</th>
		<td>
			
			<label><input type="checkbox" name="abovethefold[http2_push]" value="1"<?php if (isset($options['http2_push']) && intval($options['http2_push']) === 1) {
    print ' checked';
} ?>> Enable
</label>
			<p class="description" style="margin-bottom:1em;">When enabled, resources such as scripts, stylesheets and images can be pushed to visitors together with the HTML (<a href="https://developers.google.com/web/fundamentals/performance/http2/#server_push" target="_blank">documentation</a>).</p>

			<div id="http2_push"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'pagespeed'); ?></div></div>
			<input type="hidden" name="abovethefold[http2_push_config]" id="http2_push_config_src" value="<?php echo esc_attr($http2_push_config); ?>"  />

        	<div style="clear:both;height:10px;"></div>
        	<fieldset><legend>Insert</legend>
        		<a href="javascript:void(0);" class="button" data-http2-insert='[{"type":"script","match":"all","meta":true},{"type":"script","match":{"pattern":"/url\\/path/","regex":true,"exclude":true},"meta":true}]'>WordPress scripts</a>
        		<a href="javascript:void(0);" class="button" data-http2-insert='[{"type":"style","match":"all","meta":true},{"type":"style","match":{"pattern":"/url\\/path/","regex":true,"exclude":true},"meta":true}]'>WordPress stylesheets</a>
        		<a href="javascript:void(0);" class="button" data-http2-insert='[{"type":"image","match":"all","meta":true},{"type":"image","match":{"pattern":"/gravatar\\.com\\//","regex":true,"exclude":true},"meta":true}]'>HTML images</a>
        		<a href="javascript:void(0);" class="button" data-http2-insert='[{"type":"custom","resources":[{"file":"https://url.to/file.jpg","type":"image"},{"file":"/path/to/font.woff2","type":"font","mime":"font/woff2"}],"meta":true}]'>Custom resource list</a>
        	</fieldset>
			<div style="float:right;"><span class="ref" style="position:relative;top:-5px;">JSON editor</span> <span class="star"><a class="github-button" data-manual="1" href="https://github.com/josdejong/jsoneditor" data-icon="octicon-star" data-show-count="true" aria-label="Star josdejong/jsoneditor on GitHub">Star</a></span></div>

			<p class="info_yellow">
			<strong>Note:</strong> When using the Progressive Web App Service Worker (PWA), the service worker automatically calculates a <strong>Cache Digest</strong> based on previously pushed resources. This feature is based on the hash calculation implementation of <a href="https://gitlab.com/sebdeckers/cache-digest-immutable/#-cache-digest-immutable" target="_blank">Cache-Digest-Immutable</a> and enables the server to only push resources that aren't already available in the client. For more information, see <a href="https://calendar.perfplanet.com/2016/cache-digests-http2-server-push/" target="_blank">this article</a> on PerfPlanet.com.
			<br /><br />
			<img src="<?php print WPABTF_URI; ?>admin/images/Cache_Digest_-_Warm_Cache.png" alt="Cache-Digest" style="width:100%;max-width:600px;" title="Cache-Digest">
			<br /><br />
			It is not possible to push resources that are not used on a page. For more information, see <a href="https://jakearchibald.com/2017/h2-push-tougher-than-i-thought/" target="_blank">this article</a>
			</p>

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
