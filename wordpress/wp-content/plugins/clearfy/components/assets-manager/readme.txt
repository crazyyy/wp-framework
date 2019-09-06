=== Wordpress Assets manager, dequeue scripts, dequeue styles ===
Tags: dequeue script, dequeue style, pagespeed, speed, unload style, gonzales, assets clean, assets, assets cleanup, page speed optimizer, perfmatters, disable script, disable style, disable jquery, disable jquery-migrate, disable fonts
Contributors: webcraftic
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VDX7JNTQPNPFW
Requires at least: 4.2
Tested up to: 5.0
Requires PHP: 5.2
Stable tag: trunk
License: GPLv2

Increase the speed of the pages by disabling unused scripts (.JS) and styles (.CSS). Make your website REACTIVE!

== Description ==

You should know that, a lot of WordPress plugins developers forget performance when creating plugins. This means that a lot of them load self scripts/styles on every single post and or page of your site. This is not good, because it slows your site down.

That's why we created the WP Asset manager, with it, you can choose which scripts and styles should be loaded on the page, and which ones do not. One example of this would be with the Contact Form 7 plugin. With two clicks you can disable it everywhere except for on your contact page.

THIS PLUGIN’S BENEFITS INCLUDE

Decreases number of HTTP requests loaded (important for faster load)
Reduces the HTML code of the actual page (that’s even better if GZIP compression is enabled)
Makes source code easier to scan in case you’re a developer and want to search for something
Remove possible conflicts between plugins/theme (e.g. 2 JavaScript files that are loading from different plugins and they interfere one with another)
Better performance score if you test your URL on websites such as GTmetrix, PageSpeed Insights, Pingdom Website Speed Test
Google will love your website more as it would be faster and fast page load is nowadays a factor in search ranking
Your server access log files (e.g the Apache ones) will be easier to scan and would take less space on your server

We used some useful functions from plugins <strong>Asset Queue Manager</strong>, <strong>WP Asset CleanUp (Page Speed Optimizer)</strong>, <strong>Clearfy – disable unused features</strong>, <strong>wp disable</strong>, <strong>Disabler</strong>, <strong>Admin Tweaks</strong>

== Translations ==

* English - default, always included
* French - Thank you very much to user (kingteamdunet)
* Russian

If you want to help with the translation, please contact me through this site or through the contacts inside the plugin.

#### Recommended separate modules ####

We invite you to check out a few other related free plugins that our team has also produced that you may find especially useful:

* [Clearfy – WordPress optimization plugin and disable ultimate tweaker](https://wordpress.org/plugins/clearfy/)
* [Disable Comments for Any Post Types (Remove Comments)](https://wordpress.org/plugins/comments-plus/)
* [Cyrlitera – transliteration of links and file names](https://wordpress.org/plugins/cyrlitera/)
* [Cyr-to-lat reloaded – transliteration of links and file names](https://wordpress.org/plugins/cyr-and-lat/ "Cyr-to-lat reloaded")
* [Disable admin notices individually](https://wordpress.org/plugins/disable-admin-notices/ "Disable admin notices individually")
* [Hide login page](https://wordpress.org/plugins/hide-login-page/ "Hide login page")
* [Disable updates, Disable automatic updates, Updates manager](https://wordpress.org/plugins/webcraftic-updates-manager/)

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin settings can be accessed via the 'Settings' menu in the administration area (either your site administration for single-site installs).

== Screenshots ==
1. Control panel
2. Assets manager

== Changelog ==
= 1.0.7 =
* Fixed: Added compatibility with ithemes sync
* Fixed: Minor style fixes

= 1.0.6 =
* Fixed: Fixed a bug when the interface did not open on the frontend.

= 1.0.5 =
Great update:
* We completely changed the interface design. Now it is more convenient for visual inspection of resource files.
* Fixed: All errors that users have reported about
* Added: Multisite support
* Added: New logic disabled scripts and styles
* Added: You can exclude assets from optimizing for Autoptimize and Clearfy plugins.
* Added: You can exclude resource files for which you do not need to remove the query string.
* Added: You can see which plugin the style file belongs to and the js file.
= 1.0.4 =
* Fixed: Update core
* Fixed: Compatibility with others plugin

= 1.0.3 =
* Fixed: Compatibility with Clearfy plugin
* Fixed: The plugin interface did not work and the styles were not loaded due to security settings
* ADDED: Plugin options caching to reduce database queries for 90%. Clearfy became lighter and faster.
* ADDED: Compress and cache the plugin core files, to reduce the load on the admin panel

= 1.0.2 =
* Fixed: Core bugs
* Fixed: Problems with the fonts in the assets manager

= 1.0.0 =
* Plugin release
