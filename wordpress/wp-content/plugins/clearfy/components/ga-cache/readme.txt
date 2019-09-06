=== Local Google Analytics for Wordpress - caches external requests ===
Tags: analytics,google analytics,google analytics dashboard,google analytics plugin,google analytics widget,gtag
Contributors: webcraftic, JeromeMeyer62
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VDX7JNTQPNPFW
Requires at least: 4.2
Tested up to: 4.9
Requires PHP: 5.2
Stable tag: trunk
License: GPLv2

Plugs in Google Analytics code to your website pages and caches it, so the website loads faster.

== Description ==

This plugin helps to plug in Google Analytics code to the website pages without affecting the theme code. All you have to do is to enter the tracking code. That’s all. Unlike other plugins, this one cares about your website performance and caches Google Analytics scripts.

#### How does plugin cache Google Analytics scripts and why? ####

When you activate and fill in plugin settings, it downloads remote file named analytics.js and places it to the Cache folder on your hosting (server). This file is updated once a day – it helps to avoid external requests to the Google remote server and speeds up the website pages.
Also if you want to gain 100 performance rating on Google Pagespeed Insights, then you’ll definitely need to cache Google Analytics, otherwise you’ll get a warning.

#### PLUGIN FEATURES ####

* <strong>Helps to place analytics code to the website header or footer.</strong>
* <strong>Monitors bounce rates.</strong> The point is that you set up the event triggered after a user spends a certain amount of time on the landing page, telling Google Analytics not to consider these users as a bounce. The user can visit your website, find all necessary information (for example, phone number), and then – simply close the website without visiting other pages. If the bounce rate hasn’t been adjusted, then this user is considered as a bounce, even though he had a successful experience. By defining time limits as from when the user should be considered as a bounce, you get more accurate performance of the user experience (for example, whether he's been able to find what he was looking for or not).
* <strong>Define the analytics code position.</strong>  Google Analytics code loads prior to other scripts and JavaScript code by default. But if you set up the value 100, for example, then the Google Analytics code will be loaded after all scripts. Adjusting the priority helps to set up the code’s position on the page.
* <strong>Disable all Display Network functions.</strong>  Find more: https://developers.google.com/analytics/devguides/collection/analyticsjs/display-features
* <strong>Use anonymous IP address (required by the law in some countries).</strong>  More details: (https://support.google.com/analytics/answer/2763052)
* <strong>Track administrators.</strong> You can disable tracking for administrators’ activities and get more accurate statistics.
* <strong>Do not update the analytics.js local script.</strong> Plugin creates cron task to update cache of Google Analytics scripts daily. Once this feature is enabled, the plugin won’t update the Google Analytics cache file.

== Translations ==

* English - default, always included
* Russian

If you want to help with the translation, please contact me through this site or through the contacts inside the plugin.

#### BIG THANKS ####
Many thanks to [Jerome Meyer](http://www.arobase62.fr/2011/03/23/simple-google-analytics/), for his great contribution to the development of this plugin.

#### THANKS TO THE PLUGINS' AUTHORS ####
We used some plugins functions:
<strong>GA Google Analytics</strong>, <strong>NK Google Analytics</strong>, <strong>Complete Analytics Optimization Suite (CAOS)</strong>, <strong>Clearfy — WordPress optimization plugin and disable ultimate tweaker</strong>, <strong>Enhanced Ecommerce Google Analytics Plugin for WooCommerce</strong>

#### Recommended separate modules ####

We invite you to check out a few other related free plugins that our team has also produced that you may find especially useful:

* [Clearfy – WordPress optimization plugin and disable ultimate tweaker](https://wordpress.org/plugins/clearfy/)
* [Disable Comments for Any Post Types (Remove Comments)](https://wordpress.org/plugins/comments-plus/)
* [Cyrlitera – transliteration of links and file names](https://wordpress.org/plugins/cyrlitera/)
* [Cyr-to-lat reloaded – transliteration of links and file names](https://wordpress.org/plugins/cyr-and-lat/ "Cyr-to-lat reloaded")
* [Disable admin notices individually](https://wordpress.org/plugins/disable-admin-notices/ "Disable admin notices individually")
* [Hide login page](https://wordpress.org/plugins/hide-login-page/ "Hide login page")
* [Disable updates, Disable automatic updates, Updates manager](https://wordpress.org/plugins/webcraftic-updates-manager/)
* [WordPress Assets manager, dequeue scripts, dequeue styles](https://wordpress.org/plugins/gonzales/  "WordPress Assets manager, dequeue scripts, dequeue styles")

== Installation ==

1. Upload the ‘simple-google-analytics.zip’ file to the /wp-content/plugins/ directory using wget, curl of ftp.

2. ‘unzip’ the ‘simple-google-analytics.zip’ which will create the folder to the directory /wp-content/plugins/simple-google-analytics

3. Activate the plugin through the ‘Plugins’ menu in WordPress

4. Configure the plugin through ‘Local Google Analytics’ submenu in the the ‘Settings’ section of the WordPress admin menu

5. Add your google analytics ID there. An example of Google Analytics ID –> UA-0000000-0.

6. Choose if your blog is on a sub-domain or not. This option is defined in your Google Analytics settings page. Do not change if you don’t know.

7. Enter the domain where your WordPress is.

8. Save it & your done.

== Screenshots ==
1. Control panel

== Frequently Asked Questions ==
= Does plugin work with multisite? =
No plugin does not support multisites. This is temporary and we will try to add support for networks in the future.

== Changelog ==
= version 3.0.1 =
* Fixed small bugs
= version 3.0.0 =
* The Simple Google Analytics plugin has some major changes. Unfortunately, the old version of the plugin (2.2.2) is no longer supported, but you still can download it from the WordPress repository in case if the new release doesn’t work for you.
  We’ve updated the code and fixed the compatibility issue for the latest WordPress and PHP versions. We’ve also added additional feature of the Google Analytics cache – this way your website will load faster. The plugin’s name has been changed to Google Analytics cache, but all features remained the same.
  Please, check plugin settings and its performance on your website. We do care about you and want to avoid any problems with the new version.
= version 2.2.3 =
* Author change
= version 2.2.2 =
* Add a comment when the code isn't loaded while being logged
= version 2.2.1 =
* Corrected the analytics code to prevent non-detection from Google
= version 2.2.0 =
* Add the demographic / interests reports
= version 2.1.0 =
* Corrected a bug with wp_enqueue_script
* Change the JS loading method
* Add the external links / downloads tracking
= version 2.0.5 =
* Added the option to not render when logged in
= version 2.0.4 =
* Corrected a bug where the JS file was loading before jQuery. Thanks to MrZebra for finding that.
= version 2.0.3 =
* Corrected a bug that made all settings link on extension page going to Simple Google Analytics settings page.
= version 2.0.2 =
* Google Code has returned to the original. The optimized code have issues with some users having no stats. All should be fine now.
= version 2.0 =
* Code has been fully rewritten.
* Google Analytics code has been rewritten to load faster.
= version 1.1.6 =
* Code is not showing only when logged as Admin.
* Add option to select where you want to place the code (Header or Footer)
= version 1.1.5 =
* Add settings in the extensions page (Thanks to Vladimir Pavlikov)
* Add Russian Translation (Thanks to Vladimir Pavlikov)
= version 1.1.4 =
* Version 1.1.3 doesn't shows in the repository...
= version 1.1.3 =
* Added a translation for 'Simple Google Analytics Settings'
= version 1.1.2 =
* French Translation Bug
= version 1.1.1 =
* Fixed annoying bug
= version 1.1.0 =
* Added new Site Speed setting from Google
= version 1.0.4 =
* Corriged a bug if you use the Papercite plugin
= version 1.0.3 =
* Clean Readme file and clean code
= version 1.0.2 =
* Added French Translation
= version 1.0 =
* Add multi-subdomain option
