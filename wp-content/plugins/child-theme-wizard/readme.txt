=== Child Theme Wizard ===
Contributors: versluis
Donate link: https://ko-fi.com/wpguru
Tags: child theme, generator, creator, one click, starter
Requires at least: 3.4
Tested up to: 6.0
Stable tag: 1.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Creates a child theme with one click and lets you customise its options. 

== Description ==

The Child Theme Wizard lets you create a new child theme without the need for additional tools, right from within the WordPress admin interface. Once activated you can find it under Tools - Child Theme Wizard.

Specify a parent theme, customise options such as title and description and click Create Child Theme. Upon success you will find your new theme under Appearance - Themes.

You have the option to include GPL License Terms if you wish. The Wizard will automatically create a thumbnail too. In future versions I may include an image uploader for this feature.

To find out more about Child Themes and why they are important please read https://codex.wordpress.org/Child_Themes

== Installation ==

1. Either: Upload the entire folder `child-theme-wizard` to the `/wp-content/plugins/` directory. 
1. Or: download the ZIP file, then head over to Plugins - Add New - Install, then browse to your file
1. Or: from Plugins - Add New, search for "child theme wizard", to find this plugin and hit "install"
1. Then: Activate the plugin through the 'Plugins' menu in WordPress
1. You can find it under Tools - Child Theme Wizard


== Screenshots ==

1. create a Child Theme with just one click
1. the wizard was successful
1. you also get a nice thumbnail with your new child theme


== Changelog ==

= 1.4 =
* defined the preivously undefined variable $parent_style (thanks, Marcin!)
* updated links to WordPress Dev Docs

= 1.3 =
* tested compatibility with WordPress 5.1
* updated link to Codex
* added version query as suggested in Codex as of 2019

= 1.2 =
* corrected a spelling mistake (thanks, Cory!)

= 1.1 =
* the parent theme is now queued via functions.php

= 1.0 =
* Initial Release
