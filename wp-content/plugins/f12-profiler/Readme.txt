== F12-Profiler ==
Contributors: forge12
Tags: Profiler, Debug, Debugger, Performance, Tools
Requires at least: 4.9
Tested up to: 6.0
Requires PHP: >=7.0
Stable tag: 1.3.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Trace the execution time of plugins, themes and core files to find the bottlenecks
of your system.

=== Description ===
This plugin will track the load time of each plugin, javascript and css file
to help you optimizing the performance of your WordPress site. It will help you
to figure out which plugin / resource causing the slowness of your page.

Track time for:

1. Core
1. Theme 
1. Plugins
1. Resources (JavaScript, CSS)
1. External files

=== Installation ===
1. Upload the plugin to the "/wp-content/plugins/" directory.
1. Activate the plugin through the "Plugins" menu in WordPress.
1. Activate the plugin itself in "Tools" -> "F12 Profiler".

Important: The plugin will not track anything before activated by yourself (see the steps above). This will allow you
to disable the plugin within the options without uninstall and install it all the time if you require it.
Also, it will only be activated for logged in users that are able to manage options of plugins.

If you have any further questions do not hesitate to ask.

== Changelog ==

= 1.1 =
* Added namespaces
* Reorganized folder structure
* Renamed classes

= 1.2 =
* Added Ressources (JS/CSS) View
* Changed CSS Styling (thanks to alx359)
* Changed Sort of Profiler list (thanks to alx359)
* Added compatibility to PHP 7.0
* Update for WP 5.2.1
* Added a simple admin page (Tools) to enable / disable the Profiler

= 1.2.1 =
* Some minor update to optimize the Plugin

= 1.2.2 =
* Updated the localization of the plugin (thanks to alx359)
* Updated the admin page to display hardware information
* Changed CSS Styling Toolbar (thanks to alx359)
* Changed the Resource view to display the data more accurate (thanks to alx359)
* Extended the Resource view by additional information.
* Fixed some issues on windows servers.

= 1.3 =
* Fixed an issue causing an javascript error in the backend
* Updated css/views of the popups
* Merged the resource metric into the profiler popup
* Fixed some issues with PHP

= 1.3.1 =
* Fixed some issues with scripts not recognized.

= 1.3.2 =
* Fixed some CSS issues
* Fixed an error generating an endless loop causing ERR_CONNECTION_RESET
* Added a new wrapping function for filters
* Added a separate function to disable the plugin if the php version changes after the installation.
* Added support for inline functions for wrappers
* Added support for newly generated hooks during processing

= 1.3.3 =
* Hotfix - fixed an issue caused by the early hook of the plugin.

= 1.3.4 =
* Fixed issues to be compatible with WordPress 5.3.2

= 1.3.5 =
* WordPress Version 5.4.1 support

= 1.3.6 =
* WordPress Version 5.5.1 support
* Assets fixed duplicate slashes

= 1.3.7 =
* WordPress Version 5.8.1 support

= 1.3.8 =
* WordPress Version 5.9 support

= 1.3.8 =
* WordPress Version 6.0 support