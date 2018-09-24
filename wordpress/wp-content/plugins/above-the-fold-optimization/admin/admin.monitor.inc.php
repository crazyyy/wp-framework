<?php
    $home_url = parse_url(home_url());
    $ssl_installed = (strtolower($home_url['scheme']) === 'http') ? false : true;
?>
<form method="post" action="<?php echo admin_url('admin-post.php?action=abovethefold-monitor-update'); ?>" class="clearfix">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						
						<div style="float:right;z-index:9000;position:relative;"><a href="https://www.google.nl/webmasters/?hl=<?php print $lgcode;?>" target="_blank"><img src="<?php print WPABTF_URI; ?>admin/images/googlebot.png" alt="Google Bot" title="Google Webmasters Monitor"></a>
						</div>

						<h3 class="hndle">
							<span><?php _e('Website Monitor', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">

							<p>Google wants to provide its customers (searching users) with an optimal internet experience. Websites with a proven track record of quality and reliability will obtain a preferred position, especially for premium search terms and when Google has to (temporarily) select a website for a higher amount of traffic.</p>
							<p>To ensure uptime and website quality it is required to monitor all aspects of a website that influence the availability, stability and performance so that you will be able to respond instantly when a problem occurs, preventing damage to your reputation in Google. The most important aspects to monitor besides basic uptime are the <a href="https://testmysite.thinkwithgoogle.com/?url=<?php print home_url(); ?>&amp;hl=<?php print $lgcode;?>" target="_blank">Google PageSpeed scores</a>, <a href="https://www.google.com/transparencyreport/safebrowsing/diagnostic/index.html?hl=<?php print $lgcode;?>#url=<?php print urlencode(str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST))); ?>" target="_blank">Google Malware registration</a>, SSL certificate expiration and mobile usability (user experience) on all mobile devices.</p>
							<p>There are many free and paid monitoring services. <a href="https://encrypted.google.com/search?hl=<?php print $lgcode;?>&amp;q=<?php print urlencode('best website monitor '.date('Y').''); ?>" target="_blank">Search Google</a> for the available website monitoring services.</p>
							<div class="info_yellow">
							<strong>You should always register your website for <a href="https://www.google.com/webmasters/?hl=<?php print $lgcode;?>" target="_blank">Google Webmasters</a> to get a free monitor for SEO related problems and tips to improve the quality of your website.</strong> Checking in regularly shows Google that you are genuinely concerned about the quality and findability of your website.
							</div>

							<div style="float:right;"><a href="https://uptimerobot.com/?<?php print $utmstring; ?>" target="_blank"><img src="<?php print WPABTF_URI; ?>admin/images/uptimerobot.png" alt="UptimeRobot.com" title="UptimeRobot.com - Free website monitor"></a></div>
							<h1>UptimeRobot.com - uptime monitor</h1>

<?php

    if (is_plugin_inactive('uptime-robot-monitor/uptime-robot-nh.php')) {
        $action = 'install-plugin';
        $slug = 'uptime-robot-monitor';
        $install = wp_nonce_url(
            add_query_arg(
                array(
                    'action' => $action,
                    'plugin' => $slug
                ),
                admin_url('update.php')
            ),
            $action.'_'.$slug
        ); ?>
	<p>The plugin <strong>Uptime Robot for WordPress</strong> is not installed or deactivated. Activate or install the plugin to display an UptimeRobot.com overview.</p>
	<p><a href="<?php print $install; ?>" class="button">Install plugin</a></p>
<?php
    /// http://abtf.local/wp-admin/plugins.php?action=activate&plugin=uptime-robot-monitor%2Fuptime-robot-nh.php&plugin_status=all&paged=1&s&_wpnonce=a7c53e4c47
    } elseif (is_plugin_active('uptime-robot-monitor/uptime-robot-nh.php')) {
        if (!function_exists('urpro_data') || urpro_data("apikey", "no") === "") {
            ?>
	<p>Configure the UptimeRobot.com API key in <strong>Uptime Robot for WordPress</strong>.</p>
<?php

        } else {
            print '<div class="uptime">';
            print do_shortcode('[uptime-robot days="1-7-14-180"]');
            print do_shortcode('[uptime-robot-response]');
            print '</div>';
        }
    }
?>
							<p>Consider the <a href="https://uptimerobot.com/pricing?<?php print $utmstring; ?>" target="_blank">Pro-plan</a> with SMS notifications.</p>

							<br />

							<div style="float:right;"><a href="https://security.googleblog.com/2016/09/moving-towards-more-secure-web.html?<?php print $utmstring; ?>" target="_blank"><img src="<?php print WPABTF_URI; ?>admin/images/google-security.png" alt="Google Security Blog" title="Google Security Blog"></a></div>
							<h1>CertificateMonitor.org - SSL certificate expiry monitor</h1>

							<div class="<?php if ($ssl_installed) {
    print 'ok_green';
} else {
    print 'warning_red';
} ?>">
								<span style="font-weight:bold;">To secure findability in Google it is required to install a SSL certificate.</span>
								Google officially announced in 2014 that SSL secured websites are ranked higher in the search results and in some countries Google is labeling non-https websites as <code>insecure</code> in the search results, discouraging a visit. In the beginning of 2017 the Google Chrome browser will start showing an insecure warning for non SSL websites (<a href="https://security.googleblog.com/2016/09/moving-towards-more-secure-web.html?<?php print $utmstring; ?>" target="_blank">Google blog</a>).
							</div>

							<p>Register your website for free at <a href="https://certificatemonitor.org/?<?php print $utmstring; ?>" target="_blank">CertificateMonitor.org</a> to receive a notification when a SSL certificate is about the expire. <a href="https://encrypted.google.com/search?hl=<?php print $lgcode;?>&amp;q=<?php print urlencode('ssl certificate monitor '.date('Y').''); ?>" target="_blank">Search Google</a> for other premium SSL monitoring services.</p>

							<h1>Professional &amp; advanced website monitoring</h1>

							<p>Consider using robot solutions that simulate real-user behaviour on your website, from multiple (mobile) devices, to monitor the physical performance and user experience of your website including details such as the functionality of a mobile menu.</p>
							
							<p>One of the many solutions is <a href="https://www.browserstack.com/automate?<?php print $utmstring; ?>" target="_blank">BrowserStack.com Automate Pro</a>. <a href="https://encrypted.google.com/search?hl=<?php print $lgcode;?>&amp;q=<?php print urlencode('selenium website monitor'); ?>" target="_blank">Search Google</a> for more automated UI test tools.</p>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
</form>
