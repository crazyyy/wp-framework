<div id="post-body-content" style="padding-bottom:0px;margin-bottom:0px;margin-left:5px;">
	<div class="authorbox">
		<div class="inside" style="width:auto;margin:0px;float:left;position:relative;margin-right:2em;">
			<p style="z-index:999;">Developed by <strong><a href="https://pagespeed.pro/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=Above%20The%20Fold%20Optimization" target="_blank">PageSpeed.pro</a></strong>
			<br />Contribute via <a href="https://github.com/optimalisatie/above-the-fold-optimization/" target="_blank">Github</a> &dash; <a href="https://github.com/optimalisatie/above-the-fold-optimization/issues" target="_blank">Report a bug</a> &dash; <a href="https://wordpress.org/support/plugin/above-the-fold-optimization/reviews/?rate=5#new-post" target="_blank">Review this plugin</a>
			</p>

		</div>

		<div class="inside" style="margin:0px;float:left;font-style:italic;">
			<img src="<?php print WPABTF_URI; ?>admin/images/websockify-rocket-50.png" title="Websockify" style="float:left;margin-right:5px;margin-top:8px;" width="50" align="absmiddle" />
			<p>PageSpeed.pro has developed a plugin that is able to provide instant (&lt;1ms) page load times, up to 99% HTML data transfer saving and real time HTML (live content). 
			<a href="https://pagespeed.pro/innovation/instant/" class="ws-info" target="_blank">Information</a> / <a href="https://www.fastestwebsite.co/" class="ws-info" target="_blank">Demo (WooCommerce)</a>
			<span id="livehtml" style="display:none;"></span></p>
		</div>
	</div>
</div>
<?php

    if (isset($this->CTRL->options['update_count']) && intval($this->CTRL->options['update_count']) > 0) {

        // get current critical css config
        $criticalcss_files = $this->CTRL->criticalcss->get_theme_criticalcss();

        /**
         * Test if critical CSS has been configured
         */
        $criticalcss_configured = false;
        $css = (isset($criticalcss_files['global.css'])) ? $this->CTRL->criticalcss->get_file_contents($criticalcss_files['global.css']['file']) : '';
        if ($css === '') {
            // empty, try conditional critical CSS
            foreach ($criticalcss_files as $file => $config) {
                if ($file === 'global.css') {
                    continue 1;
                }
                $css = (file_exists($criticalcss_files[$file]['file'])) ? $this->CTRL->criticalcss->get_file_contents($criticalcss_files[$file]['file']) : '';
                if ($css !== '') {
                    $criticalcss_configured = true;
                    break;
                }
            }
        } else {
            $criticalcss_configured = true;
        }
        if (!$criticalcss_configured) {
            print '<div class="error" data-count="'.intval($this->CTRL->options['update_count']).'">
		<p style="font-size:16px;">
			'.__('<strong>Warning:</strong> <a href="' . add_query_arg(array( 'page' => 'pagespeed-criticalcss' ), admin_url('admin.php')) . '">Critical Path CSS</a> is empty. This may cause a <a href="https://en.wikipedia.org/wiki/Flash_of_unstyled_content" target="_blank">Flash of Unstyled Content</a> when CSS optimization is enabled and it may trigger the two Google PageSpeed rules <a href="https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery?hl=<?php print $lgcode;?" target="_blank"><em>Eliminate render-blocking JavaScript and CSS in above-the-fold content</em></a> and <a href="https://developers.google.com/speed/docs/insights/PrioritizeVisibleContent?hl=<?php print $lgcode;?" target="_blank"><em>Prioritize visible content</em></a> that cause a significant penalty in the Google PageSpeed score.', 'abovethefold').'
			</p>
		<p>
			<a class="button" href="https://developers.google.com/speed/pagespeed/insights/?url=' . urlencode(home_url()) . '&amp;hl=' . $lgcode . '" target="_blank">Test Google PageSpeed Score</a>
		</p>
	</div>';
        }
    }
