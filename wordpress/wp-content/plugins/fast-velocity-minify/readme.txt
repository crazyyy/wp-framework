=== Fast Velocity Minify ===
Contributors: Alignak
Tags: PHP Minify, YUI Compressor, GTmetrix, Pingdom, Pagespeed, CSS Merging, JS Merging, CSS Minification, JS Minification, Speed Optimization, HTML Minification, Performance
Requires at least: 4.5
Stable tag: 2.2.6
Tested up to: 4.9.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Improve your speed score on GTmetrix, Pingdom Tools and Google PageSpeed Insights by merging and minifying CSS, JavaScript and HTML. 
 

== Description ==

This plugin reduces HTTP requests by merging CSS & Javascript files into groups of files, while attempting to use the least amount of files as possible. It minifies CSS and JS files with PHP Minify (no extra requirements).

Minification is done in real time and done on the frontend only during the first uncached request. Once the first request is processed, any other pages that require the same set of CSS and JavaScript will be served that same static cache file.

This plugin includes options for developers and advanced users, however the default settings should work just fine for most sites.

= Aditional Optimization =

I can offer you aditional `custom made` optimization on top of this plugin. If you would like to hire me, please visit my profile links for further information.


= Features =

*	Merge JS and CSS files into groups to reduce the number of HTTP requests
*	Google Fonts merging and optimization
*	Handles scripts loaded both in the header & footer separately
*	Keeps the order of the scripts even if you exclude some files from minification
*	Supports localized scripts (https://codex.wordpress.org/Function_Reference/wp_localize_script)
*	Minifies CSS and JS with PHP Minify only, no third party software or libraries needed.
*	Option to use YUI Compressor rather than PHP Minify (you you have "exec" and "java" available on your system).
*	Option to defer JavaScript and CSS files.
*	Stores the cache files in the uploads directory.
*	View the status and logs on the WordPress admin page.
*	Option to Minify HTML for further improvements.
*	Ability to turn off minification
*	Ability to turn off CSS or JS optimization seperatly (by disabling either css or js processing)
*	Ability to manually ignore scripts or css
*	Support for conditional scripts and styles
*	Support for multisite installations
*	Support for gzip_static on Nginx
*	Support for the CDN Enabler plugin
*	Auto purging of cache files on W3 Total Cache, WP Supercache, WP Rocket, Wp Fastest Cache, Cachify, Comet Cache, Zen Cache, LiteSpeed Cache, Nginx Cache (by Till Krüss ), SG Optimizer, Godaddy Managed WordPress Hosting and WP Engine (read the FAQs)
*	Support for preconnect and preload headers
*	and some more...


= Notes =
*	The JavaScript minification is by [PHP Minify](https://github.com/matthiasmullie/minify)
*	The alternative JavaScript minification is by [YUI Compressor](http://yui.github.io/yuicompressor/)
*	Compatible with Nginx, HHVM and PHP 7. 
*	Minimum requirements are PHP 5.5 and WP 4.4, from version 1.4.0 onwards


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory or upload the zip within WordPress
2. Activate the plugin through the `Plugins` menu in WordPress
3. Configure the options under: `Settings > Fast Velocity Minify` and that's it.


== Screenshots ==

1. You can view the logs and purge the cache files.
2. The settings page.


== Frequently Asked Questions ==

= How can I exclude certain assets by wildcard? =

Each line on the ignore list will try to match a substring against all CSS or JS files, for example: `//yoursite.com/wp-content/plugins/some-plugin/js/` will ignore all files inside that directory. You can also shorten the url like `/some-plugin/js/` and then it will match any css or js url that has `/some-plugin/js/` on the path. Obviously, doing `/js/` would match any files inside any "/js/" directory and in any location, so to avoid unexpected situations please always use the longest, most specific path you can use. 

...

= Why is the ignore list not working? =

The ignore list may be working, just try to use partial paths (see wildcard help above) and use relative urls only without any query vars. 

...


= Why are there several or lot's of JS and CSS files listed on the status page, or why the cache directory takes so much space? =

Well, some sites and themes have a combined CSS size above 1+ MB, so when you have 200 files, that's 200+ MB. 
Different pages may need different JS and CSS files per page, post, category, tag, homepage or even custom post types, but if the requirements never change and you always load the exact same files on every page, you won't see as many files. Likewise, if you have some dynamic url for CSS or JS that always changes in each pageview (the query var for example), you must add it to the ignore list (else it will generate a new cache file every pageview).

...

= Can I update plugins and themes? =

Yes, but it's recommended that you purge the cache (from the plugin status page) in order for the merging and minification cache files to be regenerated and for you to be sure the updates went smoothly. The plugin will also try to automatically purge some popular cache plugins, however we still recommend that you purge all caches on your cache plugin / server (whatever you use) "after" purging Fast Velocity Minify cache.

...

= Is it compatible with other caching plugins? =

You must disable any features on your theme or cache plugins, that perform minification of css, html and js.
The plugin will try to automatically purge several popular cache plugins, however we still recommend you to purge all caches (on whatever you use) if you also  manually purge the cache on the plugin settings for some reason.
The automatic purge is active for the following plugins and hosting: W3 Total Cache, WP Supercache, WP Rocket, Wp Fastest Cache, Cachify, Comet Cache, Zen Cache, LiteSpeed Cache, SG Optimizer, Godaddy Managed WordPress Hosting and WP Engine

...

= Is it resource intensive, or will it use too much CPU on my shared hosting plan? =

No it's not. On the first run, each single file is minified into an intermediate cache. When a new group of files is found, it reuses those files and merges them into a new static cache file. All pages that request the same group of CSS or JS files will also make use of that file.

...

= Is it compatible with multisites? =

Yes, it generates a new cache file for every different set of JS and CSS requirements it finds. 

...

= Is it compatible with Adsense and other ad networks? =

The plugin is compatible with any add network but also depends on how you're loading the ads into the site. We only merge and minify css and javascript files enqueued in the header and footer that match your own domain name... which would exclude any external ads. If you're using a plugin that uses JS to insert the ads on the page, there could be issues. Please report on the support forum if you found such case.

...

= After installing, why did my site feels slow to load? =

The cache regeration happen's once per url or if the included CSS + JS files change. If you need the same set of CSS and JS files in every page, the cache file will only be generated once and reused for all other pages, however if you have a CSS or JS that is generated dynamically and uses a time based query string, (url changes on every pageview), you must add it to the ignore list by wildcard.

...

= How do I use the precompressed files with gzip_static on Nginx? =

When we merge and minify the css and js files, we also create a `.gz` file to be used with `gzip_static` on Nginx. You need to enable this feature on your Nginx configuration file if you want to make use of it.

...

= Where is the YUI Compressor option gone to? =

This functionality depends on wheter you have exec and java available on your system and PHP can detect it or not. It will be visible on the basic Settings page under the JavaScript Options section and it's available for JS files only.

...

= After installing, why are some images and sliders not working? =

a) You cannot do double minification as it will break things, so make sure you have disabled any features on your theme or other plugins, that perform minification of css, html and js files.

b) Are you trying to use the defer JS or CSS options, without understanding exactly how it works? Be advised that most themes do not work properly with those options on.

c) The plugin relies on PHP Minify to minify javascript and css files, however it's not a perfect library and there are plugins that are already minified and do not output a min.js or min.css name and end up being minified again. Try to disable minification on JS and CSS files and purge the cache.

d) Sometimes a plugin conflicts with another when merged. Try to disable CSS processing first and see if it works. Try to disable JS processing second and see if it works. Try to disable HTML minification last and see if it works. If one of those work, you know there's a conflict.

e) If you have a conflict, try to add each CSS and each JS to the ignore list, one by one until you find the one that causes the conflict. If you have no idea which files to add, check the log file on the status page for a list of files.

...

= Why are some of the CSS and JS files not being merged ? =

The plugin only processes (same domain) JS and CSS files enqueued using the official method outlined here: https://developer.wordpress.org/themes/basics/including-css-javascript/

Some developers enqueue all files properly but may still "print" conditional tags directly in the header, while they should be following the example as explained on the codex: https://developer.wordpress.org/reference/functions/wp_script_add_data/

Because "printing CSS and JS tags on the header and footer is evil" (seriously), we cannot capture those files and merge them together.

There are also specific ways to enqueue files meant to be loaded for IE users only, mobile users, desktop users, printers, etc, else those may be merged together and break things. There is a blacklist and default ignore list on the PRO tab because of this.

...

= How can I load CSS async, get the critical path or why is there a flash of unstyle content when I enable this? =

This is an advanced option for highly skilled developers. Do not try to fiddle with these settings if you are not one, as it will almost certainly break your site layout and functionality. 

Loading CSS async only works properly and consistently, when you have one single CSS file being generated and your critical path is generic enough to be common on all pages.

...

= How to undo all changes done by the plugin? =

The plugin itself doesn't do any "changes" to your site and all original files are untouched. It intercepts the enqueued CSS and JS files, processes and hides them, while enqueuing the newly optimized cached version of those files. As with any plugin, simply disable or uninstall the plugin, purge all caches you may have in use (plugins, server, cloudflare, etc) and the site will go back to what it was before installing it. The plugin doesn't delete anything from the database or modify any of your files.

...

= Why is it that even though I have disabled or deleted the plugin, the design is still broken? =

Some "cheap" or so called "optimized" hosting providers, implement a misconfigured and agressive cache on their servers, and then are also "smart" enough to ignore your multiple cache purge requests if those are too frequent. 

Some providers use a "deploy system", where you upload / replace / delete the files via sftp, but those are not reflected on the live site immediatly. This means that in some cases, you can delete your whole wordpress instalation via sftp, and the site still works perfectly fine even after purging the cache.

You may have deleted the physical files from the disk, but that's either just some random storage they gave you and that they sync to the main server every few hours, or it may be the actual live server but with a file cache layer on top of it (so the old code keeps running even though you have deleted the files).

The only solution is to contact your hosting company and ask them why you have deleted the plugin and purged your cache, but the live site doesn't reflect the changes.

Providers well known to have this issue are hostgator and iPage (please report others if you find them).

...

= Why is my Visual Composer, or Page Editor not working ? =

Some plugins and themes need to edit the layout and styles on the frontend. When they need to do that, they enqueue several extra js and css files that are caught by this plugin and get merged together, when in fact those need to load seperatly. If you encounter such issue of your page editor not working on the frontend, kindly enable the "Fix Page Editors" and purge your caches. 

This option hides all optimization from logged in users, so it's as iff the plugin has been disabled. Not logged in users and search engines, still see the optimized version.

...

= How should I use the "Preload Images" and what is it for? =

Certain themes and plugins, either load large images or sliders on the homepage. Most of them will also load "above the fold" causing the "Prioritize visible content" or the "Eliminate render-blocking JavaScript and CSS in above-the-fold content" message on pagespeed insights.

While this may not work when the images are large, you can use the "Preload Images" for the first relevant images that load above the fold, such as the logo or the first image of a slider. Please note however, this is for images that show up in all pages, not just the homepage. 

Don't put too many images here as those are downloaded in high priority and it will slow down the rest of the page load.

...

= What are the recommended cloudflare settings for this plugin? =

On the "Speed" tab, deselect the Auto Minify for JavaScript, CSS and HTML as well as the Rocket Loader option as there is no benefit of using them with our plugin (we already minify things). 

Those options can also break the design due to double minification or the fact that the Rocket Loader is still experimental (you can read about that on the "Help" link under each selected option on cloudflare).

...

= I have a complaint or I need support right now. Why haven't you replied to my topic on the support forum yet? =

Before getting angry because you have no answer within a few hours (even with paid plugins, sometimes it takes weeks...), please be informed about how wordpress.org and the plugins directory work. 

The plugins directory is an open source, free service where developers and programmers contribute (on their free time) with plugins that can be downloaded and installed by anyone "at their own risk" and are all released under the GPL license.

While all plugins have to be approved and reviewed by the wordpress team before being published ( for dangerous code, spam, etc ) this doesn't change the license or add any warranty. All plugins are provided as they are, free of charge and should be used at your own risk (so you should make backups before installing any plugin or performing updates) and it's your sole responsability if you break your site after installing a plugin from the plugins directory.

Support is provided by plugin authors on their free time and without warranty of a reply, so you can experience different levels of support level from plugin to plugin. As the author of this plugin I strive to provide support on a daily basis and I can take a look and help you with some issues related with my plugin, but please note that this is done out of my goodwill and in no way I have any legal or moral obligation for doing this. I'm also available for hiring if you need custom made speed optimizations (check my profile links).

For a full version of the license, please read: https://wordpress.org/about/gpl/

...

= Where can I get support or report bugs? =

You can get support on the official wordpress plugin page at: https://wordpress.org/support/plugin/fast-velocity-minify 
You can also see my profile and check my links if you wish to hire me for custom speed optimization on wordpress or extra features. 

...

= How can I donate to the plugin author? =

If you would like to donate any amount to the plugin author (thank you in advance), you can do it via Paypal at https://goo.gl/vpLrSV

...


== Upgrade Notice ==

= 2.2.4 =
Note: Kindly re-save all options and purge all caches (the plugin cache as well as your server /plugin cache).


== Changelog ==

= 2.2.6 [2018.01.06] =
* fixed a bug with html minification on some files that should not be minified
* fixed a bug with the defer for pagespeed insights
* updated the default blacklist (delete all entries and save again, to restore)

= 2.2.5 [2017.12.18] =
* fixed a fatal error reported on the support forum

= 2.2.4 [2017.12.17] =
* added custom cache directory and url support
* cleaned up some old unused code
* updated to the latest PHP Minify version
* added better descriptions and labels for some options
* added auto exclusion for js and css files when defer for pagespeed is enabled

= 2.2.3 [2017.12.16] =
* added robots.txt and ajax requests to the exclusion list
* added some cdn fixes
* added a new Pro tab
* added a global critical path css section
* added an option to dequeue all css files
* added an option to load CSS Async with LoadCSS (experimental)
* added an option to merge external resources together
* added the possibility to manage the default ignore list (reported files that cause conflicts when merged) 
* added the possibility to manage the blacklist (files that cannot be merged with normal files)
* added better descriptions and labels for some options

= 2.2.2 [2017.11.12] =
* fixed the current cdn option box
* fixed some other minor bugs and notices
* added option to remove all enqueued google fonts (so you can use your own CSS @fontfaces manually)
* added font hinting for the "Inline Google Fonts CSS" option, so it looks better on Windows

= 2.2.1 [2017.08.21] =
* added unicode support to the alternative html minification option
* improved some options description

= 2.2.0 [2017.08.13] =
* fixed some debug notices
* fixed the alternative html minification option

= 2.1.9 [2017.08.11] =
* fixed a development bug

= 2.1.8 [2017.08.11] =
* fixed the html minification not working
* added support for the cdn enabler plugin (force http or https method)

= 2.1.7 [2017.07.17] =
* improved html minification speed and response time to the first byte
* fixed a random bug with the html minification library on large html pages (white pages)
* added support for the "Nginx Cache" plugin purge, by Till Krüss

= 2.1.6 [2017.07.17] =
* fixed a php notice in debug mode
* children styles (added with wp_add_inline_style) are now kept in order and merged together in place
* added faqs for possible "visual composer" issues

= 2.1.5 [2017.07.17] =
* css bug fixes and performance improvements
* added support for auto purging on WP Engine

= 2.1.4 [2017.07.14] =
* added compatibility with WP Engine.com and other providers that use a CNAME with their own subdomain

= 2.1.3 [2017.07.11] =
* updated PHP Minify for better compatibility
* added an alternative mode for html minification (because PHP Minify sometimes breaks things)
* css bug fixes and performance improvements

= 2.1.2 [2017.06.27] =
* fixed another error notice when debug mode is on

= 2.1.1 [2017.06.24] =
* fixed an error notice

= 2.1.0 [2017.06.21] =
* some performance improvements

= 2.0.9 [2017.06.01] =
* several bug and compatibility fixes

= 2.0.8 [2017.05.28] =
* fixed a notice alert on php for undefined function

= 2.0.7 [2017.05.28] =
* added support for auto purging of LiteSpeed Cache 
* added support for auto purging on Godaddy Managed WordPress Hosting
* added the ie only blacklist, wich doesn't split merged files anymore, like the ignore list does
* added auto updates for the default ignore list and blacklist from our api once every 24 hours
* added cdn rewrite support for generated css and js files only
* removed url protocol rewrites and set default to dynamic "//" protocols
* updated the faqs

= 2.0.6 [2017.05.22] =
* added a "Troubleshooting" option to fix frontend editors for admin and editor level users
* updated the faqs

= 2.0.5 [2017.05.15] =
* fixed preserving the SVG namespace definition "http://www.w3.org/2000/svg" used on Bootstrap 4
* added some exclusions for Thrive and Visual Composer frontend preview and editors

= 2.0.4 [2017.05.15] =
* improved compatibility with Windows operating systems

= 2.0.3 [2017.05.15] =
* fixed an "undefined" notice

= 2.0.2 [2017.05.14] =
* improved compatibility on JS merging and minification

= 2.0.1 [2017.05.11] =
* fixed missing file that caused some errors on new installs 

= 2.0.0 [2017.05.11] =
* moved the css and js merging base code back to 1.4.3 because it was better for compatibility
* removed the font awesome optimization tweaks because people have multiple versions and requirements (but duplicate css and js files are always removed)
* added all usable improvements and features up to 1.5.2, except for the "Defer CSS" and "Critical Path" features (will consider for the future)
* added info to the FAQ's about our internal blacklist for known CSS or JS files that are always ignored by the plugin 
* changed the way CSS and JS files are fetched and merged to make use of the new improvements that were supposed to be on 1.4.4+
* changed the advanced settings tab back to the settings page for quicker selection of options by the advanced users
* changed the cache purging option to also delete our plugin transients via the API, rather than just let them expire
* changed the "Inline all CSS" option into header and footer separately

= 1.0 [2016.06.19] =
* Initial Release
