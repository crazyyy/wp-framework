=== Cyrlitera – transliteration of links and file names  ===
Tags: translitera, cyrillic, latin, l10n, russian, rustolat, slugs, translations, transliteration, media, georgian, european, diacritics, ukrainian
Contributors: webcraftic
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VDX7JNTQPNPFW
Requires at least: 4.2
Tested up to: 4.9
Requires PHP: 5.2
Stable tag: trunk
License: GPLv2

The plugin converts Cyrillic, Georgian links, filenames into Latin. It is necessary for correct work of WordPress plugins and improve links readability.

== Description ==

Transliteration is the transformation of one character into another, for example Cyrillic characters, into Latin. Usually transliteration is used to improve the readability of permalinks and avoid problems with displaying and reading files, because everything in network based on the Latin alphabet. Many plugins made by English-speaking developers do not optimize under the Cyrillic alphabet and can work unstable.

Cyrlitera transliteration plugin replaces Cyrillic, Georgian characters at posts, pages and tags to create readable permalinks. Also this plugin fixes incorrect file names and removes unnecessary characters, which can cause problems when accessing this file.

**Cyrillic link example:**<br>
_site.dev/%D0%BF%D1%80%D0%B8%D0%B2%D0%B5%D1%82-%D0%BC%D0%B8%D1%80

**Converted into the Latin alphabet:**<br>
_site.dev/privet-mir

In the first case, you can not visually understand the text of encoded link. In the second case, the link transliteration is implemented, everything looks more clear and the link is more shorter.

**An example of incorrect filename transliteration:**<br>
%D0%BC%D0%BE%D0%B5_image_ 290.jpg<br>
A+nice+picture.png

**Images transliteration example:**<br>
moe_image_ 290.jpg<br>
a-nice-picture.png

If you ignore file names creation rules, then you can get 404 errors and broken links.

Therefore, create file names using Latin characters and numbers, avoiding special characters, except dashes and underscores. Alternatively, use this plugin. It will do all this work automatically when uploading a file via the WordPress interface and reduce the number of broken links.

#### FEATURES ####
* Converts permalinks of existing posts, pages, categories and tags when options are enable;

* Keeps the integrity of records' and pages' permalinks;

* Creates a redirect from old posts and pages names to the new ones with converted links;

* Performs transliteration of the attachments file names;

* Converts filenames into lowercase;

* Includes Russian, Belarusian, Ukrainian, Bulgarian, Georgian symbols;

* You can advance a characters base for transliteration;

* You can roll back changes if the plugin converted your URLs incorrectly.


#### THANKS TO THE PLUGINS' AUTHORS ####
We used some plugins functions:
<strong>WP Translitera</strong>, <strong>Rus-To-Lat</strong>, <strong>Cyr to Lat</strong>, <strong>Clearfy — WordPress optimization plugin and disable ultimate tweaker</strong>,translit-it, <strong>Cyr to Lat enhanced</strong>, <strong>Cyr-And-Lat</strong>, <strong>Rus filename translit</strong>, <strong>rus to lat advanced</strong>

#### RECOMMENDED SEPARATE MODULES ####
We invite you to check out a few other related free plugins that our team has also produced that you may find especially useful:

* [Clearfy – WordPress optimization plugin and disable ultimate tweaker](https://wordpress.org/plugins/clearfy/)
* [Disable Comments for Any Post Types (Remove Comments)](https://wordpress.org/plugins/comments-plus/)
* [Disable updates, Disable automatic updates, Updates manager](https://wordpress.org/plugins/webcraftic-updates-manager/)
* [Cyr-to-lat reloaded – transliteration of links and file names](https://wordpress.org/plugins/cyr-and-lat/ "Cyr-to-lat reloaded")
* [Disable admin notices individually](https://wordpress.org/plugins/disable-admin-notices/ "Disable admin notices individually")
* [WordPress Assets manager, dequeue scripts, dequeue styles](https://wordpress.org/plugins/gonzales/  "WordPress Assets manager, dequeue scripts, dequeue styles")
* [Hide login page](https://wordpress.org/plugins/hide-login-page/ "Hide login page")

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to the general settings and click on the "Transliteration" tab, activate the options and save the settings.

== Frequently Asked Questions ==

= Does plugin work with multisite? =
No plugin does not support multisites. This is temporary and we will try to add support for networks in the future.

= Converts characters incorrectly? =
Try to change the problematic symbols in the plugin's settings with the symbol base enlargement field. These characters will replace the default characters.

= How to restore converted URLs? =
There is a "Rollback changes" button in the plugin settings. This option works only for links, which has been transliterated. This will not work for filenames.
== Screenshots ==
1. Setting page
2. Simple for posts
2. Simple for filenames

== Changelog ==
= 1.0.5 =
Fixed: Update core
Fixed: Bug with bodypress
Fixed: Transliteration on the frontend
Fixed: Added option to disable transliteration on frontend

= 1.0.4 =
Fixed: Bug with transliteration of file names
Added: Compatibility with PHP 7.2
Added: Forced transliteration for file names
= 1.0.3 =
* Fixed: Small bugs
= 1.0.2 =
* Added: Function of converting files to lowercase
* Added: Forced transliteration function
* Added: The function of redirecting old records to new ones
* Added: Ability to change the base of symbols of transliteration
* Added: Button for converting old posts, categories, tags
* Added: Button to restore old links
= 1.0.1 =
* Fixed small bugs
= 1.0.0 =
* Plugin release
