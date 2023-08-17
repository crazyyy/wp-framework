<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-info-block d4p-info-block-changelog">
    <h3><?php esc_html_e( "Version", "sweeppress" ); ?> 2</h3>
    <div class="d4p-group-inner">
        <h4>Version: 2.3 / august 11 2023</h4>
        <ul>
            <li><strong>new</strong> settings panel for performance related options</li>
            <li><strong>new</strong> estimate options to run estimates with size or without size estimation</li>
            <li><strong>new</strong> cache estimates to avoid running estimates query too often</li>
            <li><strong>new</strong> database dashboard box showing overall statistics for the database</li>
            <li><strong>new</strong> tools panel for purge of the cache estimation results</li>
            <li><strong>edit</strong> many improvements to the code style and formatting</li>
            <li><strong>edit</strong> Dev4Press Library 4.2</li>
        </ul>

        <h4>Version: 2.2 / may 15 2023</h4>
        <ul>
            <li><strong>new</strong> sweeper: actionscheduler log entries</li>
            <li><strong>new</strong> sweeper: actionscheduler log orphaned entries</li>
            <li><strong>new</strong> sweeper: actionscheduler failed actions</li>
            <li><strong>new</strong> sweeper: actionscheduler completed actions</li>
            <li><strong>new</strong> sweeper: actionscheduler canceled actions</li>
            <li><strong>new</strong> dashboard shows count of sweepers that are currently disabled</li>
            <li><strong>edit</strong> improved loading process for the sweepers</li>
            <li><strong>edit</strong> Dev4Press Library 4.1.1</li>
            <li><strong>fix</strong> few wrong icons used for the plugin interface</li>
        </ul>

        <h4>Version: 2.1.1 / april 1 2023</h4>
        <ul>
            <li><strong>edit</strong> few minor updates to used class references</li>
            <li><strong>edit</strong> Dev4Press Library 4.0.1</li>
            <li><strong>fix</strong> database optimization sweeper triggers server error</li>
            <li><strong>fix</strong> missing class reference for `sweeppress_db` function</li>
        </ul>

        <h4>Version: 2.1 / march 28 2023</h4>
        <ul>
            <li><strong>new</strong> sweeper: draft posts revisions</li>
            <li><strong>new</strong> sweeper: postmeta `_wp_old_*` data records</li>
            <li><strong>new</strong> constant and filter to disable DB optimize/repair sweepers</li>
            <li><strong>new</strong> enhanced preparation of quick and auto sweepers on dashboard</li>
            <li><strong>edit</strong> various tweaks to the sweeping estimations</li>
            <li><strong>edit</strong> expanded information for the Auto Sweep block</li>
            <li><strong>edit</strong> expanded information for the Quick Sweep block</li>
            <li><strong>edit</strong> link knowledge base for some settings groups</li>
            <li><strong>edit</strong> link knowledge base for some plugin panels</li>
            <li><strong>edit</strong> changes to some plugin settings default values</li>
            <li><strong>edit</strong> changes to the availability for some sweepers</li>
            <li><strong>edit</strong> Dev4Press Library 4.0</li>
            <li><strong>fix</strong> wrong calculations for the post revisions sweeper</li>
        </ul>

        <h4>Version: 2.0 / march 10 2023</h4>
        <ul>
            <li><strong>new</strong> sweeper: multisite wp_signups table</li>
            <li><strong>edit</strong> few more improvements in calculating estimates size</li>
            <li><strong>edit</strong> expanded content displayed in WordPress Help panel</li>
            <li><strong>edit</strong> CLI subcommands: improved information returned</li>
            <li><strong>edit</strong> CLI command: now with main description included</li>
            <li><strong>fix</strong> REST API results: shows HTML tags for size estimate</li>
            <li><strong>fix</strong> REST API endpoints: additional information for arguments</li>
            <li><strong>fix</strong> CLI command list: shows HTML tags for size estimate column</li>
            <li><strong>fix</strong> CLI subcommands: few problems with the help information</li>
            <li><strong>fix</strong> CLI results: few issues with labels and formatting</li>
        </ul>
    </div>
</div>

<div class="d4p-info-block d4p-info-block-changelog">
    <h3><?php esc_html_e( "Version", "sweeppress" ); ?> 1</h3>
    <div class="d4p-group-inner">
        <h4>Version: 1.8 / march 3 2023</h4>
        <ul>
            <li><strong>new</strong> sweepers on sweep panels have new toggle to list affected tables</li>
            <li><strong>edit</strong> improved data size estimate calculation for NULL values</li>
            <li><strong>edit</strong> several optimizations to the main JavaScript file</li>
            <li><strong>edit</strong> Dev4Press Library 3.9.3</li>
            <li><strong>fix</strong> statistics logging puts Sweep panel results under Quick</li>
            <li><strong>fix</strong> statistics panel filter is throwing fatal error on load</li>
            <li><strong>fix</strong> comments by status sweeper not taking comment type into account</li>
            <li><strong>fix</strong> changelog link from the what's new about panel not working</li>
        </ul>

        <h4>Version: 1.7 / february 3 2023</h4>
        <ul>
            <li><strong>new</strong> tested with WordPress 6.1</li>
            <li><strong>new</strong> tested with PHP 8.1 and 8.2</li>
            <li><strong>edit</strong> all grid panels improved with new library base class</li>
            <li><strong>edit</strong> various small styling updates and improvements</li>
            <li><strong>edit</strong> Dev4Press Library 3.9.1</li>
        </ul>

        <h4>Version: 1.6 / october 31 2022</h4>
        <ul>
            <li><strong>new</strong> sweeper: repair broken database tables</li>
            <li><strong>new</strong> alternative methods for the database tables optimization</li>
            <li><strong>new</strong> run analyze method after the database tables optimization</li>
            <li><strong>new</strong> each sweeper includes plugin version when it was added</li>
            <li><strong>edit</strong> updated information for some sweepers</li>
            <li><strong>edit</strong> database status code with better views exclusion process</li>
        </ul>

        <h4>Version: 1.5 / june 7 2022</h4>
        <ul>
            <li><strong>edit</strong> improved statistics panel collected data display</li>
            <li><strong>edit</strong> several minor updates to the core objects</li>
            <li><strong>edit</strong> information about the new Monitor feature in Pro edition</li>
            <li><strong>fix</strong> potential division by zero issue with the size calculations</li>
            <li><strong>fix</strong> problem with the uppercase database table names</li>
        </ul>

        <h4>Version: 1.4.1 / may 28 2022</h4>
        <ul>
            <li><strong>fix</strong> sweepers missing with WordPress 6.0</li>
            <li><strong>fix</strong> sweepers missing with ClassicPress 1.4</li>
        </ul>

        <h4>Version: 1.4 / may 18 2022</h4>
        <ul>
            <li><strong>edit</strong> improved layout for the plugin dashboard</li>
            <li><strong>edit</strong> d4pLib 3.8</li>
            <li><strong>fix</strong> responsive layout issue with auto sweep box</li>
        </ul>

        <h4>Version: 1.3 / april 2 2022</h4>
        <ul>
            <li><strong>new</strong> panel with list of all sweepers and where they can be used</li>
            <li><strong>edit</strong> updated information in the Help areas for various panels</li>
            <li><strong>edit</strong> updated information about screenshots</li>
            <li><strong>edit</strong> updated several plugin screenshots</li>
            <li><strong>edit</strong> several updates to the readme file</li>
        </ul>

        <h4>Version: 1.2 / march 15 2022</h4>
        <ul>
            <li><strong>new</strong> show list of affected tables more prominently inside help area</li>
            <li><strong>new</strong> show percentage of the data to be removed compared to affected tables size</li>
            <li><strong>edit</strong> many improvements to the sweepers core classes</li>
            <li><strong>edit</strong> improved query for calculation of tables to optimize</li>
            <li><strong>edit</strong> calculation of tables to optimize takes index into account</li>
            <li><strong>edit</strong> expanded help information for some sweepers</li>
            <li><strong>edit</strong> expanded information for some plugin settings</li>
            <li><strong>edit</strong> several minor styling and layout tweaks and improvements</li>
            <li><strong>edit</strong> d4pLib 3.7.4</li>
            <li><strong>removed</strong> few unused and obsolete functions and methods</li>
            <li><strong>fix</strong> minor issue with database fragmentation calculation</li>
        </ul>

        <h4>Version: 1.1 / march 8 2022</h4>
        <ul>
            <li><strong>new</strong> sweeper: akismet meta records removal</li>
            <li><strong>fix</strong> minor issue with the translations format</li>
        </ul>

        <h4>Version: 1.0 / march 3 2022</h4>
        <ul>
            <li><strong>new</strong> first official version</li>
        </ul>
    </div>
</div>
