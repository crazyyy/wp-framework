=== Disable Admin Notices individually  ===
Tags: notices, notification, notifications, disable, upgrade, nag
Contributors: webcraftic, alexkovalevv, creativemotion
Donate link: https://clearfy.pro/disable-admin-notices/
Requires at least: 5.2
Tested up to: 6.2
Requires PHP: 7.0
Stable tag: 1.3.3
License: GPLv2

Disable admin notices plugin gives you the option to hide updates warnings and inline notices in the admin panel.

== Description ==

Do you know the situation, when some plugin offers you to update to premium, to collect technical data and shows many annoying notices? You are close these notices every now and again but they newly appears and interfere your work with WordPress. Even worse, some plugin’s authors delete “close” button from notices and they shows in your admin panel forever.

Our team was tired of this, and we developed a small plugin that solves problems with annoying notices. With this plugin, you can turn off notices forever individually for themes, plugins and the WordPress itself.

The Hide admin notices plugin adds “Hide notification forever” link for each admin notice. Click this link and plugin will filter this notice and you will never see it. This method will help you to disable only annoying notices from plugins and themes, but important error notifications will continue to work.

In addition, you can disable all notices globally simply change plugin options. In this case, the plugin hides all admin notices, except of updates notices in the list of installed plug-ins.
<strong>[Premium]</strong> You can hide the notice for other users who have access to the admin panel, while displaying this notice for yourself. (Multisite only)

And still, that you could see which notices are shows, we made the special item in the top admin bar that will collect all notices in one place. It is disabled by default to freeing space in the admin menu but you can enable it in plugin options.
<strong>[Premium]</strong> We have also added a Hidden Notices page so that the site administrator can view the entire list of hidden notes and restore some of them, if necessary.

<strong>[Premium]</strong> Compact panel - Instead of notices in the admin panel (no matter how many) a compact panel is displayed, it takes up little space and will not interfere with you. By clicking on the compact panel, you will see all your notes, click again and all your notes are hidden again. This is an easy way to keep track of notes, you won't miss anything, all notes will be available in one click.
<strong>[Premium]</strong> Block Ad Redirects - This feature will be useful to you to break advertising redirects. Some plugins, when updating or during installation, may redirect you to their page with advertisements or news. If plugins do this too often, it can be a headache for you. Break these redirects with our premium features.
<strong>[Premium]</strong> Hide admin bar items (menu) - This function allows you to disable annoying menu items in the admin bar. Some plugins take up space in the admin bar to insert their ads. Just get rid of this ad with the premium features of our plugin.
<strong>[Premium]</strong> Disable plugins updates nags
<strong>[Premium]</strong> Disable core updates nags

We used some useful functions from plugins <strong>Clearfy – disable unused features</strong>, <strong>WP Hide Plugin Updates and Warnings</strong>, <strong>Hide All Notices</strong>, <strong>WP Nag Hide</strong>, <strong>WP Notification Center</strong>

#### Recommended separate modules ####

We invite you to check out a few other related free plugins that our team has also produced that you may find especially useful:

* [Clearfy – WordPress optimization plugin and disable ultimate tweaker](https://wordpress.org/plugins/clearfy/)
* [Disable updates, Updates manager, Disable automatic updates](https://wordpress.org/plugins/gonzales/)
* [Disable Comments for Any Post Types (Remove Comments)](https://wordpress.org/plugins/comments-plus/)
* [Cyrlitera – transliteration of links and file names](https://wordpress.org/plugins/cyrlitera/)
* [Disable updates, Disable automatic updates, Updates manager](https://wordpress.org/plugins/webcraftic-updates-manager/)
* [Hide login page, Hide wp admin – stop attack on login page](https://wordpress.org/plugins/hide-login-page//)

== Translations ==

* English - default, always included
* Russian

If you want to help with the translation, please contact me through this site or through the contacts inside the plugin.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin settings can be accessed via the 'Settings' menu in the administration area (either your site administration for single-site installs).

== Screenshots ==
1. Shows an example of use
2. Control panel
3. Notifications panel (optional)

== Changelog ==
= 1.3.3 (22.03.2023) =
* Fixed: Freemius framework conflict
* Added: Compatibility with Wordpress 6.2

= 1.3.2 =
* Fix Exception error on PHP8 (1.3.2)

= 1.3.1 (27.05.2022) =
* Some Fixes
* Added: Compatibility with Wordpress 6.1

= 1.3.0 (27.05.2022) =
* Added: Compatibility with Wordpress 6.0

= 1.2.9 (23.03.2022) =
* Added: Compatibility with Wordpress 5.9
* Fixed: Minor bugs

= 1.2.8 (13.01.2022) =
* Fixed: compatibility error with plugin WP Fastest Cache

= 1.2.7 (20.10.2021) =
* Added: Compatibility with Wordpress 5.8
* Fixed: Minor bugs

= 1.2.6 (04.02.2021)=
* ATTENTION! Now the required PHP version is 7.0 or higher.

= 1.2.5 (03.02.2021)=
* Added: Compatibility with Google SiteKit plugin

= 1.2.4 (16.12.2020)=
* Added: Subscribe widget
* Fixed: Minor bugs

= 1.2.3 =
* Fixed: Compatibility with other plugins
* Fixed: Appearance of the list of hidden notifications in the adminbar
* [PRO] Added: Added a page with a list of all hidden notifications with the ability to restore.
* [PRO] Added: Ability to hide notifications for ALL users
* [PRO] Added: Multisite support

= 1.2.2 (09.08.2020) =
* Fixed: It was impossible to hide the notice with an offer to buy a pro version.
* Updated: Improved the accuracy of filters when hiding notifications.

= 1.2.0 (16.07.2020) =
* Fixed: Minor bugs

= 1.2.0 (10.07.2020) =
* Fixed: Fixed some compatibility issues with third-party plugins.
* Added: Premium features

= 1.1.3 (01.07.2020) =
* Removed: Ads notices and dashboard widget
* Fixed: Minor bugs

= 1.1.2 (23.06.2020) =
* Added: Compatibility with Wordpress 5.4
* Fixed: Minor bugs

= 1.1.1 =
* Added: Compatibility with Learndash
* Added: Compatibility with Wordpress 4.2 - 5.x
* Added: Multisite support
* Added: Minor link style (hide notification forever) changes.

= 1.0.6 =
* Fixed: compatibility with some plugins and themes

= 1.0.5 =
* Fixed: Prefix bug

= 1.0.4 =
* Fixed: Compatibility with Clearfy plugin
* ADDED: Plugin options caching to reduce database queries for 90%. Clearfy became lighter and faster.
* ADDED: Compress and cache the plugin core files, to reduce the load on the admin panel

= 1.0.3 =
* Added a new feature: To restore hidden admin notices individually
* Fixed: Core bugs

= 1.0.2 =
* Updated styles for the “Hide notification forever” link
* Compatibility with plugins from webcraftic is updated

= 1.0.0 =
* Plugin release