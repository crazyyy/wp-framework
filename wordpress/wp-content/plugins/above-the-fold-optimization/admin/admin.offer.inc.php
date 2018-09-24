<?php
    if (isset($_GET['limited-offer'])) {
        $welcome_checked = empty($_GET['limited-offer']) ? 0 : 1;
        update_user_meta(get_current_user_id(), 'abtf_show_offer', $welcome_checked);
    } else {
        $welcome_checked = get_user_meta(get_current_user_id(), 'abtf_show_offer', true);
    }

    $this->google_intlcode = 'en-us';

        // Google uses a different host for the US
    $thinkhost = 'https://testmysite.' . (($this->google_intlcode === 'en-us') ? 'think' : '') . 'withgoogle.com/';
    $thinkurl = $thinkhost . 'intl/'.$this->google_intlcode.'?url=' . urlencode(home_url());

    if (!$welcome_checked) {
        ?>
<div id="welcome-panel" class="welcome-panel">
	<a class="welcome-panel-close" href="<?php echo add_query_arg(array( 'page' => 'pagespeed-settings', 'limited-offer' => 1 ), admin_url('admin.php')); ?>" aria-label="Dismiss the welcome panel">Dismiss</a>
	<div class="welcome-panel-content">
		<h2>New: Full Spectrum <strong>Mobile Performance Test</strong></h2>
		<p class="about-description" style="margin-top:4px;">Google launched a new full spectrum website performance test that appears to be tougher and more important than the PageSpeed score. The test uses both the PageSpeed score and WebPageTest.org <a href="https://sites.google.com/a/webpagetest.org/docs/using-webpagetest/metrics/speed-index" target="_blank">Speed Index</a> and it compares the results with websites in the same search category which would be a stronger ranking factor than a general PageSpeed score. Websites with a PageSpeed 100 score could score <span style="color:#ea4335;font-style:italic;">Poor</span> in this new test. Test your website on <a href="<?php echo esc_url($thinkurl); ?>" target="_blank"><?php echo $thinkhost; ?></a>.</p>
		<div class="welcome-panel-column-container">
			<div class="welcome-panel-column" style="margin-bottom:1em;">
					<a href="<?php echo esc_url($thinkurl); ?>" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Test Your Website</a>
			</div>
		</div>
	</div>
</div>
<?php

    }
?>