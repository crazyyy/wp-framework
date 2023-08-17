<?php

use Dev4Press\v42\Core\Quick\URL;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-content">
    <div class="d4p-cards-wrapper">
        <div class="d4p-group d4p-dashboard-card d4p-card-double d4p-dashboard-card-dev4press">
            <h3>SweepPress Pro Exclusive Features</h3>
            <div class="d4p-group-header" style="display:none;"></div>
            <div class="d4p-group-inner">
                <h4>Sweep Job Scheduling</h4>
                <p>Easily create one or more jobs containing a selection of sweepers (and optionally, specific tasks within each sweeper) and set method for the job activation. This can be scheduled to run once or periodically, or just set a job as inactive. For scheduled jobs you need to pick the schedule and set start date and time.</p>
                <h4>Daily and Weekly Monitor</h4>
                <p>Plugin can monitor the website, and when the predefined thresholds (number of records or size percentage for deletion) are reached, it will send the notification to administrator (or to list of emails defined in settings) with the sweeper status overview.</p>
                <h4>Database Overview and Control</h4>
                <p>Overview of all the tables in the database related to the WordPress installation with detailed information about each table, basic plugin identification, and additional actions to optimize or repair tables. For advanced users, plugin has options to empty or delete tables.</p>
                <h4>WordPress CRON Control</h4>
                <p>WordPress CRON System is essential to provide many of the WordPress and plugins features, but control over it is very problematic. SweepPress Pro gives you control over CRON and is able to track each scheduled CRON job for purpose of identification, you can remove and run jobs from the panel.</p>
                <h4>GravityForms Support</h4>
                <p>Additional Sweepers for cleanup of GravityForms related data. For now, there are three sweepers included: for removal of trashed forms, for removal of Spam entries and for removal or Trash entries. Both include support for sweeping entries related to individual forms.</p>
                <h4>Sweeper File Log</h4>
                <p>Log every sweeper execution into log file (including the sweeper execution mode and simulation status, if enabled), and include all sweeper/removal SQL queries executed by each used sweeper.</p>
            </div>
            <div class="d4p-group-footer">
                <a href="<?php echo URL::add_campaign_tracking( 'https://plugins.dev4press.com/sweeppress/lite-vs-pro/', 'sweeppress-upgrade-to-pro' ); ?>" target="_blank" class="button-primary">Compare Lite vs Pro</a>
            </div>
        </div>

		<?php include( SWEEPPRESS_PATH . 'forms/content-dashboard-pro.php' ); ?>
    </div>
</div>
