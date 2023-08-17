<?php

use Dev4Press\v42\Core\Quick\URL;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-group d4p-dashboard-card d4p-card-double d4p-dashboard-card-dev4press" style="margin-right: 0; border-color: #67AF12;">
    <h3 style="background: #67AF12; color: white;">Upgrade to SweepPress Pro</h3>
    <div class="d4p-group-header">
        <p style="margin: 0 0 .5em">Get more great features with Pro version, with even more coming with future releases.</p>
        <ul>
            <li>
                <i class="d4p-icon d4p-ui-calendar-day" style="font-size: 1.25em; margin-right: .1em;"></i> Scheduled Sweep Jobs
            </li>
            <li>
                <i class="d4p-icon d4p-ui-calendar" style="font-size: 1.25em; margin-right: .1em;"></i> WP CRON Tracking and Control
            </li>
            <li>
                <i class="d4p-icon d4p-ui-clock" style="font-size: 1.25em; margin-right: .1em;"></i> Sweeper Monitor
            </li>
            <li>
                <i class="d4p-icon d4p-ui-database" style="font-size: 1.25em; margin-right: .1em;"></i> Database Tables Control
            </li>
            <li>
                <i class="d4p-icon d4p-ui-list" style="font-size: 1.25em; margin-right: .1em;"></i> GravityForms Support
            </li>
            <li>
                <i class="d4p-icon d4p-file-text" style="font-size: 1.25em; margin-right: .1em;"></i> Sweeper File Log
            </li>
        </ul>
        <div class="d4p-clearfix"></div>
    </div>
    <div class="d4p-group-inner">
        <h4>Discount Coupon</h4>
        <p>Upgrade to SweepPress Pro, and save
            <strong>10%</strong> with the discount coupon <strong>SWEEPLITETOPRO</strong>.</p>
    </div>
    <div class="d4p-group-footer">
        <a href="<?php echo URL::add_campaign_tracking( 'https://plugins.dev4press.com/sweeppress/buy/', 'sweeppress-upgrade-to-pro' ); ?>" target="_blank" class="button-primary">SweepPress Pro</a>
        <a href="<?php echo URL::add_campaign_tracking( 'https://sweep.press/', 'sweeppress-upgrade-to-pro' ); ?>" target="_blank" class="button-secondary">SweepPress Home Page</a>
    </div>
</div>