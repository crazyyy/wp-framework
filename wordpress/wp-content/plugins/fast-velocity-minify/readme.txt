=== Fast Velocity Minify ===
Contributors: Alignak
Tags: merge, combine, concatenate, PHP Minify, YUI Compressor, CSS, javascript, JS, minification, minify, optimization, optimize, stylesheet, aggregate, cache, CSS, html, minimize, pagespeed, performance, speed, GTmetrix, pingdom
Requires at least: 4.5
Stable tag: 2.2.1
Tested up to: 4.8.1
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

By default, each line on the ignore list will try to match a substring against all css or js urls, for example: `//yoursite.com/wp-content/plugins/some-plugin/js/` will ignore all files inside that directory. You can also shorten the url like `/some-plugin/js/` and then it will match any css or js url that has `/some-plugin/js/` on the path. Obviously, doing `/js/` would match any files inside any "/js/" directory and in any location, so to avoid unexpected situations please always use the longest, most specific path you can use. 

...

= Why is the ignore list not working? =

The ignore list is working but you need to remove query vars from static urls (ex: ?ver=) and use partial (see wildcard help above) and use relative urls only. 

...


= Why are there several or a lot's of js and css files listed on the status page? =

Those files are created whenever a new set of javascript or css files are found on your front end and it's due to your plugins and themes needing different js and css files per page, post, category, tag, homepage or even custom post types. If you always load the exact same css and javascript in every page on your site, you won't see as many files. Likewise, if you have some dynamic url for css or js that always changes in each pageview, you should add it to the ignore list.

...

= Can I update other plugins and themes? =

Yes, but it's recommended that you purge the cached files (from the plugin status page) in order for the merging and minification cache files to be regenerated. The plugin will try to automatically purge some popular cache plugins. We still recommend, however, that you purge all caches on your cache plugin (whatever you use) "after" purging Fast Velocity Minify cache.

...

= Is it compatible with other caching plugins? =

The plugin will try to automatically purge several popular cache plugins, however we still recommend you to purge all caches (on whatever you use) if you also  manually purge the cache on the plugin settings for some reason.
The automatic purge is active for the following plugins and hosting: W3 Total Cache, WP Supercache, WP Rocket, Wp Fastest Cache, Cachify, Comet Cache, Zen Cache, LiteSpeed Cache, SG Optimizer, Godaddy Managed WordPress Hosting and WP Engine

...

= Is it resource intensive, or will it use too much CPU on my shared hosting plan? =

No it's not. The generation of the minified files is done only once per group of CSS or JS files (and only if needed). All pages that request the same group of CSS or JS files will also make use of that cache file. The cache file will be served from the uploads directory as a static file and there is no PHP involved.

...

= Is it compatible with multisites? =

Yes, it generates a new cache file for every different set of JS and CSS requirements it finds. 

...

= Is it compatible with Adsense and other ad networks? =

The plugin is compatible with any add network but also depends on how you're loading the ads into the site. We only merge and minify css and javascript files enqueued in the header and footer which would exclude any ads. If you're using a plugin that uses JS to insert the ads on the page, there could be issues. Please report on the support forum if you found such case.

...

= After installing, why did my site became slow? =

Please note that the cache regeration happen's once per page or if the requested CSS + JS files change. If you need the same set of CSS and JS files in every page, the cache file will only be generated once and reused for all other pages. If you have a CSS or JS that uses a different name on every pageview, try to add it to the ignore list by using wildcards.

...

= How do I use the precompressed files with gzip_static on Nginx? =

When we merge and minify the css and js files, we also create a `.gz` file to be used with `gzip_static` on Nginx. You need to enable this feature on your Nginx configuration file if you want to make use of it. If you're upgrading from 1.2.3 or earlier, you need to clear the plugin cache.

...

= Where is the YUI Compressor option gone to? =

This functionality depends on wheter you have exec and java available on your system. It will be visible on the basic Settings page under the JavaScript Options section and it only applies to JS files.

...

= After installing, why is my design or layout broken or some images and sliders are not showing? =

First thing to check is, are you doing double minification?
You must disable any features on your theme and other plugins, that perform minification of css, html and js.
You cannot also have other optimization plugins, because you are forcing wordpress to do double work.
I recommend W3 Total Cache (with css, js and html minifcation disabled) + Fast Velocity Minify, for minification of CSS and JS files.
Also, kindly review the "Why are some of the CSS and JS files not being merged or why is my layout broken ?" below for better insights. 

Additionally, the Advanced Otions should only be used by advanced users or developers that understand what the settings mean and do, especially the "defer JS" options. Having said that, this is how you can solve most issues on the settings tab when not using any options on the advanced tab:

* `Disabling CSS processing but keeping JS processing enabled:` This will leave CSS files alone and it's useful to determine if the problem is CSS or JS related. If isabling CSS processing fixed the layout problems, now you know it's related to CSS... 
Likewise, you can keep CSS processing and disable JS processing to find out if the problem is on JS processing. 
If you determine it's a CSS issue, check the log file on the status page for possible css file urls that should not be there (such as Internet Explorer only files) and add them to the ignore list. 
Also kindly report those files on the support forum so they can be blacklisted for future releases. 
Sometimes there are JS files than conflict with each other when merged so they may need to be excluded too.

* `JS Defer:` If you have a theme that heavily relies on javascript and jQuery (usually with sliders, paralax animations, etc) most probably, you cannot `defer JavaScript` for all JS files, but you could try to add the jQuery library as well as the specific JS files that need to be render blocking to the ignore list. 

* `Developers only:` Note that if you defer jQuery, the library will not run until after the html DOM page loads. That means that whatever jQuery code is inlined on the HTML will not work and trigger an "undefined" error on the browser console log. 
On Google Chrome you can look at the console by pressing CTRL + SHIFT + J on your keyboard and refreshing the page. If there are errors you need to track down which JS file is causing trouble and add it to the ignore list. 
If you have no idea which files to add, I recommend checking the log file on the status page, adding them all to the ignore list and then one by one trying to delete each url until you find the one causing trouble. 
Also beware of any cache plugin in use (and cloudflare) when testing, because that cache needs to be off or purged when configuring things around.

...

= Why are some of the CSS and JS files not being merged or why is my layout broken ? =

There are thousands of plugins and themes out there and not every developer follows the standard way of enqueueing their files on WordPress.

For example, some choose to "print" the html tag directly into the header or footer, rather than to use the official method outlined here: https://developer.wordpress.org/themes/basics/including-css-javascript/

Some developers enqueue all files properly but still "print" conditional tags, such as IE only comments around some CSS or JS files , while they should be following the example as explained on the codex: https://developer.wordpress.org/reference/functions/wp_script_add_data/

Because "printing CSS and JS tags on the header and footer" is evil (seriously), we cannot capture those files and merge them together.
There are also files meant to be loaded for IE users only, mobile users, desktop users, printers, so the enqueing of all the files needs to follow the official method of enqueing data and files. 

This can also cause layout issues because some files that should be for IE only can be merged together with other users, thus overwriting the usual layout (please check if any of those got merged together and add it to the ignore list). Also, to avoid some of these, we have implemented an IE only blacklist of "known" file names that are "always" added to the ignore list behind the scenes.

Please feel free to open a support topic if you found some more JS or CSS files on your theme or plugins that "must always" also blacklisted and why.

The default ignore list can be found here: 
https://fastvelocity.com/api/fvm/ignore.txt

The IE only blacklist (mostly IE only files or that cause trouble most of the times when merged with others), can be found here: https://fastvelocity.com/api/fvm/ie_blacklist.txt

These files are downloaded directly by the plugin, once every 24 hours from our cdn provider.

...

= Why is it that even though I have disabled or removed the plugin, the design is still broken? =

While this is rare, it can happen if you have some sort of cache enabled on your site or server. A cache means that the site or server makes a static copy of your page and serves it for a while (until it's deleted or expires) instead of loading wordpress directly to the users. Some hosting providers such as Godaddy (and their derivates) enforce their own cache plugin to be installed and creates a new menu which allows you to purge the cache. 

If you don't see any option anywhere to clear your cache, you can contact your hosting provider or developer to clear the cache for you or ask them how you can do it in the future.

...

= Why is my frontend editor not working ? =

Some plugins and themes need to edit the layout and styles on the frontend. When they need to do that, they enqueue several extra js and css files that are caught by this plugin and get merged together, thus sometimes, it breaks things. If you encounter such issue of your page editor not working on the frontend, kindly enable the "Fix Page Editors" on the Troubleshooting page.

...

= What is the "Fix Page Editors" on the Troubleshooting page ? =

This hides all optimization from editors and administrators, as long as they are logged in. This also means that you will see the site exactly as it was before installing the plugin and it's meant to fix compatibility with frontend page editors, or plugins that edit things in preview mode using the frontend.

...

= Is it compatible with Visual Composer and other editors ? =

Visual composer, adds some style tags into your header and/or footer, however they simply print the code and don't use the wordpress `wp_add_inline_style` hook. 
This means, we cannot easily capture that csa code and therefore it's left out of all the merging by Fast Velocity Minify.
You may have all else merged and minified correctly, however if that generated visual composer css code is important, those styles might be overwritten by the merged file, or that code can also overwrite the rules inside the css generated file.
If you experience some styles missing, this could be the cause... but try the ignore list first.

...

= How should I use the "Preload Images" and what is it for? =

Certain themes and plugins, either load large images or sliders on the homepage. Most of them will also load "above the fold" causing the "Prioritize visible content" or the "Eliminate render-blocking JavaScript and CSS in above-the-fold content" message on pagespeed insights (see the previous faq question above).

How you can use the "Preload Images" is by adding the url of the first relevant images that load above the fold, such as the first background image (and the first image only) of the slider. Any big or large enough image that is above the fold should be added here, however note that the images you add here "must" actually exist on the page, else it will trigger a warning on the browser console such as "The resource [...] was preloaded using link preload but not used within a few seconds from the window's load event. Please make sure it wasn't preloaded for nothing." which is not good practice. 

Don't put too many resources here as those are downloaded in high priority and it will slow down the page load on mobile or slower connections (because the browser won't process the rest until it finishes downloading all of those big "preload" images).

...

= What are the recommended cloudflare settings for this plugin? =

On the "Speed" tab, deselect the Auto Minify for JavaScript, CSS and HTML as well as the Rocket Loader option. There is no benefit of using them with our plugin (we already minify things). Those options sometimes can also break the design due to double minification or the fact that the Rocket Loader is still experimental (you can read about that on the "Help" link under each selected option on cloudflare).

...

= How to undo all changes done by the plugin? =

The plugin itself doesn't do any "changes" to your site and all original files are untouched. It intercepts the enqueued CSS and JS files, processes and hides them, while enqueuing the newly optimized cached version of those files. As with any plugin, simply disable or uninstall the plugin, purge all caches you may have in use (plugins, server, cloudflare, etc) and the site will go back to what it was before installing it. The plugin doesn't delete anything from the database or modify any of your files.

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

= 2.1.6 =
Note: Kindly purge the plugin cache as well as your server /plugin cache after updating.


== Changelog ==

= 2.2.1 [2017.08.21] =
* added unicode support to the alternative html minification option
* improved some options description

= 2.2.0 [2017.08.13] =
* fixed some debug notices
* fixed the alternative html minification option

= 2.1.9 [2017.08.11] =
* fixed a devolopment bug

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
