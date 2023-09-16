=== WP-Developer-Tools ===
Contributors: phkcorp2005
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9674139
Tags: php quick profiler, wordpress developer tools
Requires at least: 2.8.6
Tested up to: 5.5
Stable tag: 1.1.1

A needed plugin to help developers optimize their installation of wordpress. plugins and themes.

== Description ==

A needed plugin to help developers optimize their installation of wordpress. plugins and themes.
This plugin is an ongoing effort to incorporate tools to help the developer. 

The flagship tool to be incorporated first is a much needed PHP Profiler. Based on the open source code of the Quick PHP Profiler, as a nice but functional interface that helps to isolate the bootlenecks in your code. This code has been written to be safe for production deployment and can track issues such as database query time & results,page load time, variables, and a lot more. 
Is you Wordpress installation taking too long to load pages?

Are chasing bugs that you cannot find?

Do you want to satisfy your curiousity of the performance of your wordpress installation?

The WP-Developer-Tools is an ongoing collection of useful tools and components that assist the developer to fine tune and diagnose their wordpress installation. The first tool included is the migration of the PHP Quick Profiler (http://particletree.com/) to a Wordpress plugin.

Using the WP-Developer-Tools PHP Quick Profiler, you will be able to see, in real time session information, load time, the database queries with the query time, the amount of memory used and the number of files loaded per page with their individual sizes.

An added feature, this plugin is designed to be safe for production as the WP-Developer-Tools PHP Quick Profiler is ONLY active when the Administrator is logged in and the session active. Once the Administrator losgs out, the WP-Developer-Tools PHP Quick Profiler will automatically turn off and disable.

The following publication, "Wordpress High Availability: Configuration, Deployment, Maintenance Tips & Techniques" available on
Amazon at (https://www.amazon.com/dp/B00RAIMGAC) shows how to improved performance for high availability environments.

== Installation ==

To instal this plugin, follow these steps:

1. Download the plugin
2. Extract the plugin to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. You are now ready to use the plugin. See the Admin page from Settings|WP Developer Tools.

== Credits ==

We make honorable mention to anyone who helps make this plugin better!

== Contact ==

Support is provided at https://github.com/presspage2018/wp-developer-tools/issues. You will require a free account on github.com

Please contact presspage.entertainment@gmail.com or visit the above forum with questions, comments, or requests.

== Frequently Asked Questions ==

Please do not be afraid of asking questions?<br>

(There are no stupid or dumb questions!)


== Changelog ==
= 1.1.1 =
* Fixes: Methods with the same name as their class will not be constructors
* Remove role_has_cap 

= 1.1 =
* Change to use MySQLi extension
* Change user capability check for activate_plugins
* Updates for WP 4.6

= 1.0.1 =
* Updates for WP 4.3

= 1.0.0 =
* Plugin created with PHP Quick Profiler migrated into the plugin
