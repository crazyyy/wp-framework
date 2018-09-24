<?php

    // Google uses a different host for the US
    $thinkhost = 'https://testmysite.' . (($this->google_intlcode === 'en-us') ? 'think' : '') . 'withgoogle.com/';
    $thinkurl = $thinkhost . 'intl/'.$this->google_intlcode.'?url=' . urlencode(home_url());

?>
<div class="wrap abovethefold-wrapper">

    <div class="ok_green" style="padding:8px;padding-left:8px;border-width:1px;font-size:14px;line-height:18px;margin:0px;">
    <h3 style="margin-top:5px;">News</h3>
    <p style="font-size:14px;line-height:18px;border-bottom:solid 1px #079c2d;padding-bottom:1em;">We published a new plugin for international SEO: <a href="<?php echo add_query_arg(array( 's' => 'optimalisatie', 'tab' => 'search', 'type' => 'author' ), admin_url('plugin-install.php')); ?>">Amazon CloudFront Page Cache</a></p>
    
    Our upcoming <strong>Advanced WordPress Optimization</strong> plugin will contain a ton of unique web performance optimization innovations including timed javascript execution, Service Worker based async HTML fragment streaming, responsive CSS rendering and responsive javascript loading. The plugin will enable even the most complex and javascript heavy websites to score Exceptional (2 seconds) in Google's latest Mobile Performance test, without making compromises! Besides a ton of cutting edge innovations, the plugin will also bring professional optimization software to WordPress to be able to achieve the absolute best and most stable performance result possible, on any device, in any environment and for a million independent pages.
    <br /><br />
    The plugin will enable optimization professionals such SEO and CRO specialists to increasingly focus on 'optimization intelligence' without the need to know the exact workings of for example a Service Worker. The optimization configuration will be based on <a href="http://json-schema.org/" target="_blank" rel="noopener">JSON schemas</a>.
    <br /><br />
    The plugin will enable to apply optimization profiles conditional, per page or based on environment conditions (e.g. for a device, browser or the <a href="https://developers.google.com/web/updates/2016/02/save-data" target="_blank">Save-Data</a> header). Optimizations will be able to go beyond the page level and shift focus to individual users. The plugin will make it easy to for example modify a javascript optimization setting specifically for iPhone 5 users. This is a unique innovation that could be a great leap forward for website performance optimization.
    <br /><br />
    The project has recently taken on a professional management team with diverse international experience and our engineers are working very hard to complete the plugin a.s.a.p.

    <p style="font-size:14px;line-height:18px;border-top:solid 1px #079c2d;padding-top:1em;">
    Our <a href="https://www.fastestwebsite.co/" target="_blank" rel="noopener">Instant App plugin technology</a> for instant navigation speed has a new concept to enable efficient browsing of the existing internet on VR and AR devices: <a href="https://telekinetic.ai/" target="_blank" rel="noopener">Telekinetic Navigation</a>. The technology makes it possible to browse 1000s of pages in a few seconds using gesture control. The technology will enable VR and AR to become a better option for internet browsing.<br /><br />
    If you are interested to learn more, please send an email to <a href="mailto:info@pagespeed.pro">info@pagespeed.pro</a>.
    </p>
    </div>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder">
			<div id="post-body-content">
				<div class="postbox">
					
					<h3 class="hndle">
						<span><?php _e('Introduction', 'abovethefold'); ?></span>
					</h3>
					<div class="inside testcontent">

						<p>Take a moment to explore the abilities of this plugin. This plugin is not a simple <code>on/off</code> plugin so do not expect a result by simply activating the plugin.</p>

						<p>This plugin is intended as a toolkit to achieve <u>the best</u> website performance and it is focussed on Google, including the ability to achieve a Google PageSpeed <span class="g100">100</span> score.</p>

						<p>Every website is different and has different requirements to achieve the best performance. This plugin offers many configuration options<!-- and goes a step further than many premium optimization plugins-->.</p>

						<p><strong>This plugin is not intended for easy usage.</strong> Please seek expert help if you do not understand how to use this plugin. <a href="https://encrypted.google.com/search?hl=<?php print $lgcode;?>&amp;q=<?php print urlencode('wordpress pagespeed optimization service'); ?>" target="_blank">Search Google</a> for optimization experts or contact the author of this plugin: <a href="#" target="_blank">info@pagespeed.pro</a>.</p>

						<p>This plugin is offered for free. Do not expect support. If you experience a problem or have an idea for better performance, we are thankful if you <a href="https://wordpress.org/support/plugin/above-the-fold-optimization" target="_blank">report it</a> on the WordPress forums. Please do not expect free help to achieve a Google PageSpeed 100 score.</p>

						<h1 style="margin-bottom:10px;padding-bottom:0px;">Roadmap to achieve a Google PageSpeed <span class="g100">100</span> score</h1>
						
						<h3 style="margin-top:0px;padding-bottom:5px;margin-bottom:0px;border-bottom:solid 1px #efefef;">Step 1 - check the state of your website</h3>
						<p>Before you start using this plugin: test your website for problems and create a priority list with the issues that need to be resolved. This plugin offers access to several tests from the PageSpeed menu in the top admin bar.</p>

						<p>
							<a class="button button-small" href="https://developers.google.com/speed/pagespeed/insights/?url=<?php print urlencode(home_url()); ?>&amp;hl=<?php print $lgcode;?>" target="_blank">Google Full Spectrum Test</a>
							<a class="button button-small" href="https://developers.google.com/speed/pagespeed/insights/?url=<?php print urlencode(home_url()); ?>&amp;hl=<?php print $lgcode;?>" target="_blank">Google PageSpeed Test</a>
							<a class="button button-small" href="https://search.google.com/search-console/mobile-friendly?url=<?php print urlencode(home_url()); ?>&amp;hl=<?php print $lgcode;?>" target="_blank">Google Mobile Test</a>
							<a class="button button-small" href="https://performance.sucuri.net/domain/<?php print urlencode(str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST))); ?>" target="_blank">Securi Server Response Time</a>
							<a href="http://www.webpagetest.org/?url=<?php print urlencode(home_url()); ?>" class="button button-small" target="_blank">WebPageTest.org</a>
							<a href="https://gtmetrix.com/?url=<?php print urlencode(home_url()); ?>" class="button button-small" target="_blank">GTmetrix</a>
							<a href="https://securityheaders.io/?q=<?php print urlencode(home_url()); ?>&amp;hide=on&amp;followRedirects=on" class="button button-small" target="_blank">SecurityHeaders.io</a>
							<a href="https://www.ssllabs.com/ssltest/analyze.html?d=<?php print urlencode(home_url()); ?>" class="button button-small" target="_blank">SSL test</a>
							<a href="http://www.intodns.com/<?php print urlencode(str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST))); ?>" class="button button-small" target="_blank">DNS test</a>
						</p>

						<div class="info_yellow" style="margin-bottom:10px;"><p style="margin:0px;"><strong>Tip:</strong> If you can resolve small issues fast, start with the smaller issues, it may help to resolve the larger issues.</p></div>

						<h3 style="margin-top:0px;padding-bottom:5px;margin-bottom:0px;border-bottom:solid 1px #efefef;">Step 2 - server optimization</h3>
						<p>Start with the fundament of your website: the server. Make sure that the best <a href="https://encrypted.google.com/search?hl=<?php print $lgcode;?>&amp;q=<?php print urlencode('gzip configuration'); ?>" target="_blank">gzip settings</a> and <a href="https://encrypted.google.com/search?hl=<?php print $lgcode;?>&amp;q=<?php print urlencode('http cache headers configuration'); ?>" target="_blank">HTTP cache headers</a> are installed and if the server is slow, find ways to improve the speed of the server by optimizing WordPress plugins or by using a <a href="https://encrypted.google.com/search?hl=<?php print $lgcode;?>&amp;q=<?php print urlencode('best wordpress full page cache ' . date('Y')); ?>" target="_blank">full page cache</a> solution. It may be required to choose a better hosting plan or to move to a different hosting provider. Hosting reliability and performance is a major aspect for achieving a good performance and stability reputation in Google. Once you lose a stable hosting reputation, it may cause a hidden penalty and you may not get your reputation back for years.</p>
						<p>Choose professional server configuration over WordPress plugins to achieve the best performance.</p>
						<p>Google <a href="https://developers.google.com/speed/docs/insights/Server?hl=<?php print $lgcode;?>" target="_blank">officially advises</a> a maximum server response time of 0,2 seconds (200ms). Test your global server response times <a href="https://performance.sucuri.net/domain/<?php print urlencode(str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST))); ?>" target="_blank">here</a>.</p>
						<div class="info_yellow" style="margin-bottom:10px;"><p style="margin:0px;"><strong>Tip:</strong> Find out what exactly you need and write a single detailed request to your hosting provider for professional installation. If the server has a speed issue, simply ask your host to achieve a maximum server speed of 0,2 seconds (200ms) as advised by Google.</p></div>

						<h3 style="margin-top:0px;padding-bottom:5px;margin-bottom:0px;border-bottom:solid 1px #efefef;">Step 3 - Google PageSpeed optimization</h3>
						<p>Test your website at <a href="https://developers.google.com/speed/pagespeed/insights/?url=<?php print urlencode(home_url()); ?>&amp;hl=<?php print $lgcode;?>" target="_blank">Google PageSpeed Insights</a> and start resolving the issues. Google offers detailed documentation for each issue and this plugin offers the tools to resolve most issues.</p>


						<h3 style="margin-top:0px;padding-bottom:5px;margin-bottom:0px;border-bottom:solid 1px #efefef;">Step 4 - setup a website monitor</h3>
						<p>Once the performance and quality of your website has achieved a perfect state, it is required to maintain it to achieve an optimal reliability, quality and performance reputation in Google. Go to the 	<a href="<?php echo add_query_arg(array( 'page' => 'pagespeed-monitor' ), admin_url('admin.php')); ?>">Monitor tab</a> for information about website monitoring tools.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>