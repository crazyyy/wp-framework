=== SweepPress ===
Contributors: GDragoN
Donate link: https://sweep.press/
Tags: dev4press, sweep, database cleanup, clean, optimization
Stable tag: 2.3
Requires at least: 5.5
Tested up to: 6.3
Requires PHP: 7.3
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Remove various old, unused, or obsolete data from the database, optimize the database for the best website performance.

== Description ==
SweepPress is an easy-to-use plugin for WordPress, built around 37 different Sweepers for database cleanup (the Pro version has 40), support for WP-CLI, and WP REST API to perform the cleanup operations.

= Modes of sweeping =
* **Auto Sweep**: available on the dashboard, running many (not all) sweepers without user input.
* **Quick Sweep**: available on the dashboard, allowing the sweepers to be selected.
* **Full Sweep**: available on own panel, with detailed information about sweepers and no limit run.

All sweepers use optimized SQL queries to find the data for removal, and the removal is also done using SQL queries. This is the fastest and most efficient way for data removal, allowing for the quick removal of a large amount of data.

= Quick Video Overview =
https://youtu.be/ppbY-uVrudY

= List of Sweepers =
* Posts: Auto Drafts
* Posts: Spam Content
* Posts: Trashed Content
* Posts: Posts Revisions
* Posts: Posts Orphaned Revisions
* Posts: Draft Posts Revisions (v2.1)
* Posts: Postmeta Locks
* Posts: Postmeta Last Edits
* Posts: Postmeta Oembeds
* Posts: Postmeta Old Data (v2.1)
* Posts: Postmeta Orphans
* Comments: Spam Comments
* Comments: Trashed Comments
* Comments: Unapproved Comments
* Comments: Orphaned Comments
* Comments: Comments User Agents
* Comments: Commentmeta Orphans
* Comments: Pingbacks Cleanup
* Comments: Trackbacks Cleanup
* Comments: Akismet Meta Records (v1.1)
* Terms: Terms Orphans
* Terms: Termmeta Orphans
* Users: Usermeta Orphans
* Options: Expired Transients
* Options: RSS Feeds
* Options: All Transients
* Options: CRON Jobs
* Network: Expired Transients
* Network: All Transients
* Network: Inactive Signups (v2.0)
* Database: Optimize Database Tables
* Database: Repair Database Tables (v1.6)
* ActionScheduler: Log Entries (v2.2)
* ActionScheduler: Orphaned Log Entries (v2.2)
* ActionScheduler: Failed Actions (v2.2)
* ActionScheduler: Completed Actions (v2.2)
* ActionScheduler: Canceled Actions (v2.2)

= WP-CLI and WP REST API Support =
The plugin registers new CLI commands for running sweep operations from the command line (WP-CLI is required). And the plugin also registers the REST API endpoint for the same purpose to run remote sweep operations (only for the administrator role!). CLI and REST API support can be enabled through plugin settings.

= Action Scheduler Support =
The plugin can cleanup the ActionScheduler tables. These tables are used by the Action Schedule plugin and components developed for WooCommerce, but used in many other WordPress plugins including WP Rocket and Rank Math. For these sweepers to be visible, at least one plugin using those tables needs to be active.

= Special Notice =
The plugin will show the backup reminder notice by default (and it can be disabled) on every plugin page. It is essential to understand that once the data is deleted by the plugin, it can't be restored. So, if you change your mind later, it is important to make the backup before the data removal. The sweepPress plugin is not responsible for any loss of data - make sure to have backups!

= Plugin Home Page =
* Learn more about the plugin: [SweepPress Home Page](https://sweep.press/)
* Plugin knowledge base: [SweepPress on Dev4Press](https://support.dev4press.com/kb/product/sweeppress/)
* Support for Lite version: [Support Forum on Dev4Press](https://support.dev4press.com/forums/forum/plugins-lite/sweeppress/)

= SweepPress Pro =
SweepPress Lite edition, available on WordPress.org, is a fully functional plugin with no limits to its operations. But, SweepPress Pro contains some additional features not available in the Lite version:

* Create and manage Sweeper Jobs: create custom background sweeper jobs to run at a specific date or as a recurring job.
* Control and track WordPress CRON jobs: list all the WordPress CRON jobs, track and display the source, and more.
* Sweeper Monitor: monitor the website for cleanup daily or weekly, and send notifications when the sweeping limit is reached.
* Database Tables: an overview of all tables in the database with source information and various actions for better control.
* Sweeper File Log: log every sweeper execution into a log file with all sweeper/removal SQL queries executed by each used sweeper.
* GravityForms Support: three additional sweepers to remove all trashed forms, spammed, and trash entries by form.

More exclusive Pro features will be coming with future updates. [Upgrade to SweepPress Pro](https://plugins.dev4press.com/sweeppress/buy/).

== Installation ==
= General Requirements =
* PHP: 7.3 or newer

= PHP Notice =
* Plugin doesn't work with PHP 7.2 or older versions.

= WordPress Requirements =
* WordPress: 5.5 or newer

= WordPress Notice =
* Plugin doesn't work with WordPress 5.4 or older versions.

= Basic Installation =
* Plugin folder in the WordPress plugins should be `sweeppress`.
* Upload `sweeppress` folder to the `/wp-content/plugins/` directory.
* Activate the plugin through the 'Plugins' menu in WordPress.
* Plugin adds new top level menu called 'SweepPress'.
* Check all the plugin settings before using the plugin.

== Frequently Asked Questions ==
= Where can I configure the plugin? =
The plugin adds top level 'SweepPress' panel in WordPress Admin menu.

== Changelog ==
= 2.3 (2023.08.11) =
* New: settings panel for performance related options
* New: estimate options to run estimates with size or without size estimation
* New: cache estimates to avoid running estimates query too often
* New: database dashboard box showing overall statistics for the database
* New: tools panel for purge of the cache estimation results
* Edit: many improvements to the code style and formatting

= 2.2 (2023.05.15) =
* New: sweeper: actionscheduler log entries
* New: sweeper: actionscheduler log orphaned entries
* New: sweeper: actionscheduler failed actions
* New: sweeper: actionscheduler completed actions
* New: sweeper: actionscheduler canceled actions
* New: dashboard shows count of sweepers that are currently disabled
* Edit: improved loading process for the sweepers
* Edit: Dev4Press Library 4.1.1
* Fix: few wrong icons used for the plugin interface

= 2.1.1 (2023.04.01) =
* Edit: few minor updates to used class references
* Edit: Dev4Press Library 4.0.1
* Fix: database optimization sweeper triggers server error
* Fix: missing class reference for `sweeppress_db` function

= 2.1 (2023.03.28) =
* New: sweeper: draft posts revisions
* New: sweeper: postmeta `_wp_old_*` data records
* New: constant and filter to disable DB optimize/repair sweepers
* New: enhanced preparation of quick and auto sweepers on dashboard
* Edit: various tweaks to the sweeping estimations
* Edit: expanded information for the Auto Sweep block
* Edit: expanded information for the Quick Sweep block
* Edit: link knowledge base for some settings groups
* Edit: link knowledge base for some plugin panels
* Edit: changes to some plugin settings default values
* Edit: changes to the availability for some sweepers
* Edit: Dev4Press Library 4.0
* Fix: wrong calculations for the post revisions sweeper

= 2.0 (2023.03.10) =
* New: sweeper: multisite wp_signups table
* Edit: few more improvements in calculating estimates size
* Edit: expanded content displayed in WordPress Help panel
* Edit: CLI subcommands: improved information returned
* Edit: CLI command: now with main description included
* Fix: REST API results: shows HTML tags for size estimate
* Fix: REST API endpoints: additional information for arguments
* Fix: CLI command list: shows HTML tags for size estimate column
* Fix: CLI subcommands: few problems with the help information
* Fix: CLI results: few issues with labels and formatting

= 1.8 (2023.03.03) =
* New: sweepers on sweep panels have new toggle to list affected tables
* Edit: improved data size estimate calculation for NULL values
* Edit: several optimizations to the main JavaScript file
* Edit: Dev4Press Library 3.9.3
* Fix: statistics logging puts Sweep panel results under Quick
* Fix: statistics panel filter is throwing fatal error on load
* Fix: comments by status sweeper not taking comment type into account
* Fix: changelog link from the what's new about panel not working

= 1.7 (2023.02.03) =
* New: tested with WordPress 6.1
* New: tested with PHP 8.1 and 8.2
* Edit: all grid panels improved with new library base class
* Edit: various small styling updates and improvements
* Edit: Dev4Press Library 3.9.1

= 1.6 (2022.10.31) =
* New: sweeper: repair broken database tables
* New: alternative methods for the database tables optimization
* New: run analyze method after the database tables optimization
* New: each sweeper includes plugin version when it was added
* Edit: updated information for some sweepers
* Edit: database status code with better views exclusion process

= 1.5 (2022.06.07) =
* Edit: improved statistics panel collected data display
* Edit: several minor updates to the core objects
* Edit: information about the new Monitor feature in Pro edition
* Fix: potential division by zero issue with the size calculations
* Fix: problem with the uppercase database table names

= 1.4.1 (2022.05.28) =
* Fix: sweepers missing with WordPress 6.0
* Fix: sweepers missing with ClassicPress 1.4

= 1.4 (2022.05.18) =
* Edit: improved layout for the plugin dashboard
* Edit: d4pLib 3.8
* Fix: responsive layout issue with auto sweep box

= 1.3 (2022.04.02) =
* New: panel with list of all sweepers and where they can be used
* Edit: updated information in the Help areas for various panels
* Edit: updated information about screenshots
* Edit: updated several plugin screenshots
* Edit: several updates to the readme file

= 1.2 (2022.03.15) =
* New: show list of affected tables more prominently inside help area
* New: show percentage of the data to be removed compared to affected tables size
* Edit: many improvements to the sweepers core classes
* Edit: improved query for calculation of tables to optimize
* Edit: calculation of tables to optimize takes index into account
* Edit: expanded help information for some sweepers
* Edit: expanded information for some plugin settings
* Edit: several minor styling and layout tweaks and improvements
* Edit: d4pLib 3.7.4
* Removed: few unused and obsolete functions and methods
* Fix: minor issue with database fragmentation calculation

= 1.1 (2022.03.08) =
* New: sweeper: akismet meta records removal
* Fix: minor issue with the translations format

= 1.0 (2022.03.03) =
* First official release

== Upgrade Notice ==
= 2.2 =
Performance updates. Database dashboard overview.

= 2.2 =
New sweepers. Various updates.

= 2.1 =
New sweeper. Various updates.

= 2.0 =
New sweeper. Various updates. WP-CLI and REST API updates and fixes.

== Screenshots ==
* Main plugin dashboard with status
* Quick Sweep Panel available on dashboard
* Part of the main Sweep panel
* Few more sweepers on the Sweep panel
* List of all sweepers with scope and availability
* Settings to enable WP-CLI and REST API support
* List of sweepers via CLI command
