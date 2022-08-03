=== Plugins Garbage Collector (Database Cleanup) ===
Contributors: shinephp
Donate link: http://www.shinephp.com/donate/
Tags: garbage, collector, database, clear, unused tables, cleaner
Requires at least: 4.0
Tested up to: 5.9.2
Stable tag: 0.14

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

= 0.14 [03.04.2022] =
* Update: "Known plugins" JSON data files were moved from Amazon Web Services S3 to Yandex Cloud Object Storage.
* Update: "Delete Tables" button label was replaced with "Delete Selected Tables".
* Update: Additional confirmation request was added before database tables deletion. It contains the list of tables selected for deletion.

Read changelog.txt for the full list of changes.


== Additional Documentation ==

You can find more information about "Plugins Garbage Collector" plugin at this page
http://www.shinephp.com/plugins-garbage-collector-wordpress-plugin/

I am ready to answer on your questions about this plugin usage. Use plugin page comments or site contact form for that please.
