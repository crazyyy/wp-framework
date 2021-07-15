=== PB SEO Friendly Images ===
Contributors: pascalbajorat
Donate link: https://www.pascal-bajorat.com/spenden/
Tags: seo, images, Post, admin, google, attachment, optimize, photo, picture, image, media, photos, pictures, alt, title, lazy, load
Requires at least: 5.0
Tested up to: 5.5
Stable tag: 4.0.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin is a full-featured solution for SEO friendly images. Optimize »alt« and »title« attributes for all images and improve SEO traffic.

== Description ==

> Informationen auf deutsch? [PB SEO Friendly Images - Einfach, schnell und automatisch suchmaschinenfreundliche Bilder für WordPress](https://www.pascal-bajorat.com/software/pb-seo-friendly-images/ "PB SEO Friendly Images - Einfach, schnell und automatisch suchmaschinenfreundliche Bilder für WordPress")

PB SEO Friendly Images is a free WordPress plugin that helps you to automatically optimize all »alt« and »title« attributes of images in your posts. »alt« and also »title« attributes are important for a website-ranking in search engines. »alt« attributes are also required to get a W3C valid website.

> #### Features of PB SEO Friendly Images
> - **Sync:** You can sync existing »alt« to »title« and vice versa
> - **Override:** You can override existing »alt« and »title« attributes with a custom scheme
> - **Scheme:** Set up a scheme for your »alt« and »title« to flexible define and optimize your content
> - **For all images:** The plugin works great with images in posts and post thumbnails as well
> - **WooCommerce support:** User WooCommerce product title as image alt / title (pro feature)
> - **SEO Proved:** Default settings of the plugins are proved by a SEO consultant

The idea to this plugin based on a similar WordPress plugin "SEO Friendly Images" by Vladimir Prelovac. This plugin version has more settings, possibilities to configure your »alt« / »title« attributes and it’s actively maintained. There is also a sync function, that automatically use existing »alt« as »title« and vice versa if one of the values exist. This is really important, if you have already optimized some of your images.

> **Need more features and extensive support? Check out our Pro-Version:  [PB SEO Friendly Images Pro](https://goo.gl/0SV2EU "PB SEO Friendly Images Pro")**

If you have any questions or problems, you can ask me: [Pascal Bajorat - Webdesigner and WordPress Developer from Berlin](https://www.pascal-bajorat.com/ "Pascal Bajorat - Webdesigner and WordPress Developer from Berlin")

== Installation ==

1.	Upload the full directory to /wp-content/plugins/
2.	Activate the plugin over "Plugins > Installed Plugins" in your WordPress Backend
3.	Go to "Settings" and "SEO Friendly Images" to configure the plugin

For Theme Developer:
Want to add lazy load to images in your theme? You only need to do some small modifications. Add class "lazy" and modify the "src" like this:

`<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="Echter SRC Pfad" class="pb-seo-lazy" />`

== Screenshots ==

1.	Plugin Settings

== Changelog ==

= 4.0.4 =
* DISABLED: Banner in WP Dashboard
* Bugfix & Optimization

= 4.0.3 =
* Bugfix & Optimization

= 4.0.2 =
* Bugfix & Optimization

= 4.0.1 =
* Bugfix

= 4.0.0 =
* Complete Rewrite of the plugin
* Please make sure to backup your files before you run this update. If you have any problems you can switch to an older version, have a look at the download archive.

= 3.1.0 =
* serveral bugs are fixed and code was optimized
* improved image and figure handling - Thanks to BasTaller (@bastaller)

= 3.0.0 =
* new interface for woocommerce settings
* fixed compability with woocommerce

= 2.6.1 =
* fixed compability with woocommerce

= 2.6.0 =
* fixed some encoding problems
* added settings for a better encoding handling
* optimized translations

= 2.5.0 =
* fixed compability with feeds
* fixed compability with ARForms
* fixed compability with LiveComposer

= 2.4.2 =
* fixed compability with feeds

= 2.4.1 =
* Increased compability to other plugins and themes.
* Improved compability especially for MasterSlider

= 2.4.0 =
* Increased compability to other plugins and themes.

= 2.3.0 =
* Fixed a Firefox bug
* Added Filter to the core functions. You can use "pbsfi-alt", "pbsfi-title", "pbsfi-wc-alt" and "pbsfi-wc-title" as filter to change the attributes of your images in a more custom way. The "wc" filter is specially for the woocommerce attributes of the pro version.

= 2.2.2 =
* Fixed a bug with The Events Calendar plugin
* Fixed a bug with Facebook Instant Articles and RSS Feeds

= 2.2.1 =
* Added "how it works" text
* Added "Changelog" button / link
* Tested up to WordPress 4.8

= 2.2.0 =
* Important for manual integration in themes: The lazy load class is now "pb-seo-lazy" instead of "lazy"
* wrong class in description is fixed now
* Better compatibility
* Code optimization and improvements
* german translation for de_DE_formal

= 2.1.0 =
* Improved support for old PHP versions
* Code optimization and improvements
* Better WooCommerce support

= 2.0.1 =
* CSS Version Bugfix

= 2.0.0 =
* New Design
* Better compatibility
* Better support for Divi Theme by Elegant Themes

= 1.4.0 =
* Better support for Divi Theme by Elegant Themes
* Added more tags for the override / scheme function

= 1.3.3 =
* Bit.ly wrongly blocked the Pro-URL. Now the URL is changed to: [https://goo.gl/0SV2EU](https://goo.gl/0SV2EU "https://goo.gl/0SV2EU")

= 1.3.2 =
* Code optimization and improvements
* Fixed a really bad html bug, please update asap

= 1.3.1 =
* Code optimization and improvements

= 1.3.0 =
* Code optimization and improvements
* Added a new auto title for links function (pro only)

= 1.2.0 =
* Added a pro version of this plugin: [PB SEO Friendly Images Pro](https://goo.gl/0SV2EU "PB SEO Friendly Images Pro")
* Some smaller bugfixes and translation issues fixed

= 1.1.0 =
* Added support for Advanced Custom Fields.

= 1.0 =
* Initial release.

== License ==

GNU General Public License v.3 - http://www.gnu.org/licenses/gpl-3.0.html
