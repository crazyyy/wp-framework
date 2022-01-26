=== Plugins Garbage Collector (Database Cleanup) ===
Contributors: shinephp
Donate link: http://www.shinephp.com/donate/
Tags: garbage, collector, database, clear, unused tables, cleaner
Requires at least: 4.0
Tested up to: 5.6
Stable tag: 0.12

Find unused database tables from deactivated or deleted plugins. You can delete unused database tables to reduce database volume and enhance site performance.

== Description ==

Database Cleanup plugin scans the database and shows the tables beyond of core WordPress installation. Some WordPress plugins create and use its own database tables. 
Those tables are left in your database after plugin deactivation and deletion often. 
With the help of this plugin you can check your database and discover if it is clean or not.
Extra columns added to the core WordPress tables could be shown also.
To read more about 'Plugins Garbage Collector' visit this link at <a href="http://www.shinephp.com/plugins-garbage-collector-wordpress-plugin/" rel="nofollow">shinephp.com</a>


== Installation ==

Installation procedure:

1. Deactivate plugin if you have the previous version installed.
2. Extract "plugins-garbage-collector.x.x.x.zip" archive content to the "/wp-content/plugins/plugins-garbage-collector" directory.
3. Activate "Plugins Garbage Collector" plugin via 'Plugins' menu in WordPress admin menu. 
4. Go to the "Tools"-"Plugins Garbage Collector" menu item and scan your WordPress database if it has some forgotten tables from old plugins.

== Frequently Asked Questions ==
Comming soon. Just ask it. I will search the answer.


== Screenshots ==
1. screenshot-1.png Plugins Garbage Collector scan action results.


== Changelog ==

= 0.12 [16.08.2020] =
* Update: Server side "Fatal error: Maximum execution time of NN seconds exceeded" should not take place now. PGC scans plugins with large quantity of files by splitting job to smaller parts per 500 files.
* Update: "foreign key constraint fails" error should not prevent database table deletion. PGC temporally switches off "foreign keys constraints checking".
* Fix: Known database tables with DB prefix 'wp_' inside name (like wp_pro_quiz_question from LearnDash LMS) were not recognized. Code had used str_replace( $db_prefix, '', $table_name ) to exclude DB prefix from the table name and broke the name itself.

= 0.11.1 [23.06.2020] =
* Fix: Checkbox to mark table for deletion was not shown, if table belongs to the known, but unused (uninstalled) plugin.
* Fix: Plugin state translation is made now exactly before output, to use its value in the code logic safely.

= 0.11. [19.06.2020] =
* New: "Tools->Plugins Garbage Collector" menu item was renamed to "Tools->Database Cleanup"
* New: Multisite support was added. It's safe to use PGC at the single sites of the WordPress multisite network.
* New: PGC uses the list of known database tables and list of plugins which do not create own database tables. 
This reduces files scanning time as plugins known for PGC are not scanned for database tables usage. PGC checks these lists updates once a day. There is an intent to extend/update known plugins list on the regular base.
* New: It's possible to hide (temporally exclude from the listing) any found database table. Earlier this feature was available only for the tables belong to the active plugins. You can use this feature to hide the tables which are known for you, but are not recognized by PGC. Thanks for reporting such cases.
* Update: Call to deprecated function mysql_get_server_info() was excluded.
* Update: PGC shows database tables in the original format, without converting them all to lowercase letters.
* Fix: Last item in the installed plugins list ( item C in the list (A, B, C) ) was never scanned for database tables. Db tables created by such plugin were always shown as belong to unknown plugin.


Read changelog.txt for the full list of changes.


== Additional Documentation ==

You can find more information about "Plugins Garbage Collector" plugin at this page
http://www.shinephp.com/plugins-garbage-collector-wordpress-plugin/

I am ready to answer on your questions about this plugin usage. Use ShinePHP forum at
http://shinephp.com/community/forum/plugins-garbage-collector/
or plugin page comments and site contact form for it please.
