=== Cyr to Lat enhanced ===
Contributors: Atrax, SergeyBiryukov, karevn, webvitaly
Tags: cyrillic, latin, l10n, russian, rustolat, slugs, translations, transliteration, media, georgian, european, diacritics, ukrainian
Requires at least: 2.3
Tested up to: 3.8.1
Stable tag: 3.5

Converts Cyrillic, European and Georgian characters in post, page and term slugs to Latin characters.

== Description ==

Converts Cyrillic and Georgian characters in post, page and term slugs to Latin characters. Useful for creating human-readable URLs.


This plugin is a fork of [cyr2lat](http://wordpress.org/plugins/cyr2lat/) plugin.

= Features =
* Automatically converts existing post, page and term slugs on activation
* Saves existing post and page permalinks integrity
* Performs transliteration of attachment file names
* Includes Russian, Belarusian, Ukrainian, Bulgarian and Macedonian characters
* Transliteration table can be customized without editing the plugin itself

Based on the original Rus-To-Lat plugin by Anton Skorobogatov.

== Installation ==

1. Upload `cyr3lat` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure your system has iconv set up right, or iconv is not installed at all. If you have any problems (trimmed slugs, strange characters, question marks) - please ask for support. 
== Frequently Asked Questions ==

= How can I define my own substitutions? =

Add this code to your theme's `functions.php` file:
`
function my_cyr_to_lat_table($ctl_table) {
   $ctl_table['Ъ'] = 'U';
   $ctl_table['ъ'] = 'u';
   return $ctl_table;
}
add_filter('ctl_table', 'my_cyr_to_lat_table');
`

== Changelog ==

= 3.5 =
* Removed quotes from table which added extra dashes

= 3.4 =
* Fixes for Ukrainian characters

= 3.3.3 =
* Bugfix: posts of status "future" were not affected

= 3.3.2 =
* Added support for European diacritics

= 3.3.1 =
* Added Georgian transliteration table
* A problem with some letters causing apostrophes in slugs was resolved

= 3.3 =

= 3.2 =
* Added transliteration when publishing via XML-RPC
* Fixed Invalid Taxonomy error when viewing the most used tags

= 3.1 =
* Fixed transliteration when saving a draft

= 3.0 =
* Added automatic conversion of existing post, page and term slugs
* Added saving of existing post and page permalinks integrity
* Added transliteration of attachment file names
* Adjusted transliteration table in accordance with ISO 9 standard
* Included Russian, Belarusian, Ukrainian, Bulgarian and Macedonian characters
* Added filter for the transliteration table

= 2.1 =
* Optimized filter call

= 2.0 =
* Added check for existing terms

= 1.0.1 =
* Updated description

= 1.0 =
* Initial release
