=== Disable admin notices individually  ===
Tags: hide admin notices, hide updates nags, hide nags, disable notices, disable update nags, disable nags, disable admin notices
Contributors: webcraftic
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VDX7JNTQPNPFW
Requires at least: 4.2
Tested up to: 4.9
Requires PHP: 5.2
Stable tag: trunk
License: GPLv2

Disable admin notices plugin gives you the option to hide updates warnings and inline notices in the admin panel.

== Description ==

Do you know the situation, when some plugin offers you to update to premium, to collect technical data and shows many annoying notices? You are close these notices every now and again but they newly appears and interfere your work with WordPress. Even worse, some plugin’s authors delete “close” button from notices and they shows in your admin panel forever.

Our team was tired of this, and we developed a small plugin that solves problems with annoying notices. With this plugin, you can turn off notices forever individually for themes, plugins and the WordPress itself.

The Hide admin notices plugin adds “Hide notification forever” link for each admin notice. Click this link and plugin will filter this notice and you will never see it. This method will help you to disable only annoying notices from plugins and themes, but important error notifications will continue to work.

In addition, you can disable all notices globally simply change plugin options. In this case, the plugin hides all admin notices, except of updates notices in the list of installed plug-ins.

And still, that you could see which notices are shows, we made the special item in the top admin bar that will collect all notices in one place. It is disabled by default to freeing space in the admin menu but you can enable it in plugin options.

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
