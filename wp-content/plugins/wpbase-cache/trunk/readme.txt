=== WPBase Cache ===
Contributors: baseapp
Tags: cache,chaching,speed,performance,db cache,optimization,nginx,apc,varnish
Requires at least: 3.5
Tested up to: 3.5
Stable tag: trunk
Donate link:
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A wordpress plugin for using all caches on varnish, nginx, php-fpm stack with php-apc. This plugin includes db-cache-reloaded-fix for dbcache.

== Description ==

Plugin is developed to optimize wordpress deployment on varnish + nginx + php-fpm + php-apc server stack using three type of caches full page cache, db cache and opcode cache. This plugin includes [nginx-compatibility](http://wordpress.org/plugins/nginx-compatibility/), [db-cache-reloaded-fix](http://wordpress.org/plugins/db-cache-reloaded-fix/) for nginx and database cache. This plguin also support varnish cache management with given default.vcl. We have included sample file for nginx and varnish configurations in utils folder. This plugin will automatically invalidate caches upon certain actions from wordpress admin panel.

Thanks to:

- Ivan Kristianto
- Vladimir Kolesnikov

Visit our blog for more information on deployment of wordpress on varnish, nginx and php-fpm stack at [WPOven Blog](http://blog.wpoven.com/2013/08/03/wpbase-cache-plugin-features-and-advantages/).

Please note that generally shared hosting don't have varnish + nginx as server software so this plugin will not work on shared hostings.

== Installation ==

1. copy and paste contents of utils/varnish-default.vcl in your vcl file
2. copy and paste contents of utils/nginx-sample in your nginx vhosts file
3. restart both varnish and nginx
4. Put the plugin folder into [wordpress_dir]/wp-content/plugins/
5. Make folders [wordpress_dir]/wp-content/ and [wordpress_dir]/wp-content/plugins/wpbase-cache/inc/db-cache-reloaded-fix writable, change their permission to 755.
5. Go into the WordPress admin interface and activate the plugin
6. Optional: go to the options page and configure the plugin

Before upgrade DEACTIVATE the plugin and then ACTIVATE and RECONFIGURE!

== Frequently Asked Questions ==

No FAQs avilable yet

== Screenshots ==

No screenshots are available.

== Changelog ==
= 1.0.1 =
Major bug fixes

= 1.0.0 =
First stable version of plugin

== Upgrade Notice ==
No upgrades available yet