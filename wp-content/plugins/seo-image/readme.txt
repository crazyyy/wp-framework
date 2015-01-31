=== SEO Friendly Images ===
Contributors: freediver
Donate link: https://www.networkforgood.org/donation/MakeDonation.aspx?ORGID2=920155875
Tags: seo, images, Post, admin, google, attachment, optimize, photo, picture, image, media, photos, pictures
Requires at least: 2.7
Tested up to: 4.1
Stable tag: trunk

SEO Friendly Images automatically adds alt and title attributes to all your images improving traffic from search engines.

== Description ==

SEO Friendly Images is a Wordpress SEO plugin which automatically updates all images with proper ALT and TITLE attributes for SEO purposes. If your images do not have ALT and TITLE already set, SEO Friendly Images will add them according the options you set. Additionally this makes the post W3C/xHTML valid as well.

ALT attribute is important part of search engine optimization. It describes your images to search engine and when a user searches for a certain image this is a key determining factor for a match. 

TITLE attribute play lesser role but is important for visitors as this text will automatically appear in the tooltip when mouse is over the image.

Plugin by [Vladimir Prelovac](http://www.prelovac.com/vladimir/ "Vladimir Prelovac"). 

If you like what I do in WordPress, you will also like the [ManageWP](https://managewp.com "Manage WordPress sites") service.

== Changelog ==

= 3.0.5 =
* Fixed XSS issue (credit to Ryan Satterfield)

= 3.0.4 =
* Fixed default options

= 3.0.3 =
* Fixed warning messages

= 3.0.2 =
* Fixed warning message

= 3.0.1 =
* Made clear the plugin works by modyfying the image during output, and not changing images in the post editor or in media library as some people expected
* Debug notices

= 3.0 =
* Major rewrite and optimization of the plugin
* New tags to use in ALT and TITLE attributes
* All reported bugs fixed
* WordPress 4.1 and up compatible

= 2.7.6 =
* WordPress 3.8 compatibility.

= 2.7.5 =
* XSS and CSRF fixes

= 2.7.4 =
* WordPress 3.5.1 Compatibility

= 2.7.3 =
* Reverted change from 2.7.2 as it broke article view on some installations

= 2.7.2 =
* Fixed incompatiblity with mapping plugin [Leaflet Maps Marker](http://www.mapsmarker.com)

= 2.7.1 =
* Minor issues fixed (thanks Dewey Bushaw)

= 2.7.0 =
* Introduced the <a href="http://www.prelovac.com/products/seo-friendly-images">premium version</a>

= 2.6.3 =
* Display multiple categories (thanks to Charles Blaxland)

= 2.6.1 =
* Added support for overriding image title
* Fixed bug that sometimes prevented overriding the ALT tag
* Added support for %tags, replacing post tags (thanks Gerben Tiemens!)
* Some people had problems updating, this should be resolved now

= 2.4.1 =
* Alt tag replaces dashes and underscore

= 2.4 =
* Regexp Optimization. Fixed bug with single quotes used in images.


== Installation ==

1. Upload the whole plugin folder to your /wp-content/plugins/ folder.
2. Go to the Plugins page and activate the plugin.
3. Use the Options page to modify ALT and TITLE options. Turn on Override ALT tag and TITLe tag if you didnt not add these anywhere.
4. Note that SEO Friendly images works by modifying HTML output on the frontend of you site, and does not modyfiy images in your media gallery or while editing the post See [this link for more](https://wordpress.org/support/topic/it-does-work-you-just-wont-see-it-in-the-backend)

== License ==

This file is part of SEO Friendly Images.

SEO Friendly Images is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

SEO Friendly Images is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with SEO Friendly Images. If not, see <http://www.gnu.org/licenses/>.



== Frequently Asked Questions ==

= How do I correctly use this plugin? =

Just activating hte plugin will do the work. If you want to customize go to Settings, SEO Friendly Images and enter additional settings.

= How does SEO Friendly Images work? =

It replaces your image tags and ads ALT and TITLE tags which are essential for search engine optimization. This will result in more users to your site from the image search results.

= Is there anything else? =

Yes, you should create an account with Google Webmaster Central and enable enhnanced image indexing option for your website.

= Can I suggest an feature for the plugin? =

Of course, visit <a href="http://www.prelovac.com/vladimir/wordpress-plugins/seo-friendly-images#comments">SEO Friendly Images Home Page</a>

= I love your work, are you available for hire? =

Yes I am, visit my <a href="http://www.prelovac.com/vladimir/services">WordPress Services</a> page to find out more.