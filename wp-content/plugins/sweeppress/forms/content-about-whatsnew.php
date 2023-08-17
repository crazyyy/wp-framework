<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include( SWEEPPRESS_PATH . 'forms/content-about-minor.php' );

?>

<div class="d4p-about-whatsnew">
    <div class="d4p-whatsnew-section d4p-whatsnew-heading">
        <div class="d4p-layout-grid">
            <div class="d4p-layout-unit whole align-center">
                <h2>Clean your Website</h2>
                <p class="lead-description">
                    And keep it clean with scheduled cleanups
                </p>
                <p>
                    SweepPress is a new plugin that is culmination of over 10 years of work on various methods to clean up WordPress websites, and optimize database as much as possible for best performance of WordPress powered websites.
                </p>
            </div>
        </div>
    </div>

    <div class="d4p-whatsnew-section core-grid">
        <div class="core-row">
            <div class="core-col-sm-12 core-col-md-6">
                <h3>Very easy to use</h3>
                <p>
                    There are few ways to use the plugin to sweep the database, starting with Auto Sweep on the plugin dashboard, Quick Sweep Mode on the plugin dashboard with more control over the sweeping, and the full Sweep panel showing information about each sweeper, and allowing use of every sweeper.
                </p>
                <p>
                    Some of the sweepers are not available in the Auto or Quick Sweep modes to avoid running them too often. For some sweepers you have additional settings to control some sweeping aspects and limit the sweeper impact.
                </p>
            </div>
            <div class="core-col-sm-12 core-col-md-6">
                <img alt="SweepPress: CLI" src="<?php echo esc_attr( SWEEPPRESS_URL ); ?>gfx/sweep.jpg"/>
            </div>
        </div>
        <div class="core-row">
            <div class="core-col-sm-12 core-col-md-6">
                <h3>Support for CLI and REST API</h3>
                <p>
                    And, to make the sweeping even more convenient, plugin has support for WP-CLI and WP REST API. With CLI, there are commands to get list of sweeper jobs and details for each one, commands to run auto sweep or just run some sweepers.
                </p>
                <p>
                    Similar support exists with the WP REST API support, and several endpoints are available to list sweepers, run auto sweeping, or run individual sweepers. REST API has strict capabilities check and only admin accounts are allowed to all endpoints.
                </p>
            </div>
            <div class="core-col-sm-12 core-col-md-6">
                <img alt="SweepPress: CLI" src="<?php echo esc_attr( SWEEPPRESS_URL ); ?>gfx/cli.jpg"/>
            </div>
        </div>
    </div>

    <div class="d4p-whatsnew-section core-grid">
        <div class="core-row">
            <div class="core-col-sm-12 core-col-md-6">
                <h3 style="margin-top: 0;">Pro version</h3>
                <p>
                    Pro version of the plugin has more features and tools, related to the CRON jobs control and tools to schedule sweeping jobs to run periodically.
                </p>
            </div>
            <div class="core-col-sm-12 core-col-md-6">
                <h3 style="margin-top: 0;">And the statistics</h3>
                <p>
                    The plugin also keeps track of the various statistics related to records removed and data saved during sweeping, time spent, and list of used sweepers over time or monthly.
                </p>
            </div>
        </div>
    </div>
</div>
