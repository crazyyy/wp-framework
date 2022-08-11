=== Ukr-To-Lat ===
Contributors: BArS, SergeyBiryukov, karevn, webvitaly
Tags: ukrainian, ukrtolat, ukr2lat, cyr2lat, slugs, translations, transliteration, cyrillic
Requires at least: 4.6
Tested up to: 5.4.2
Stable tag: 1.3.5
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Converts Ukrainian characters in post, page and term slugs to Latin characters.

== Description ==

Converts Ukrainian characters in post, page and term slugs to Latin characters. Useful for creating human-readable URLs.

= Features =
* Automatically converts existing post, page and term slugs on activation
* Saves existing post and page permalinks integrity
* Performs transliteration of attachment file names
* Includes just Ukrainian characters
* Transliteration table can be customized without editing the plugin itself

Transliteration based on http://ukrlit.org/transliteratsiia

Based on the original Rus-To-Lat plugin by Anton Skorobogatov and Cyr-To-Lat by SergeyBiryukov, karevn, webvitaly.

== Installation ==

1. Upload `ukr-to-lat` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

= Translations =

You can [translate Ukr-To-Lat](https://translate.wordpress.org/projects/wp-plugins/ukr-to-lat) on [__translate.wordpress.org__]().

== Frequently Asked Questions ==

= How can I define my own substitutions? =

Add this code to your theme's `functions.php` file:
`
function my_cyr_to_lat_table($ctl_table) {
   $ctl_table['ะช'] = 'U';
   $ctl_table['ั'] = 'u';
   return $ctl_table;
}
add_filter('ctl_table', 'my_cyr_to_lat_table');
`

= How to redirect old link to new? =

To prevent losing you SEO position you can use plugin LCH (https://wordpress.org/plugins/link-changer-htaccess-for-better-seo/) to prepare redirect from old links to new one.

== Upgrade Notice ==

None

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png

== Changelog ==

= 1.3.5 =

* Fixed small + big letter "ь".

= 1.3.4 =

* Tested with WordPress 5.0

= 1.3.2 =

* Fixed small letter "й".

= 1.2 =

* Small fixes in Readme.txt and plugin.

= 1.0 =
* Initial release
