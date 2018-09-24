=== Page Speed Optimization for SEO ===
Contributors: optimalisatie
Donate link: https://pagespeed.pro/
Tags: optimization, page speed, pagespeed, pwa, seo, performance, css, critical css, web app, javascript, minification, minify, minify css, minify stylesheet, progressive, progressive web app, optimize, speed, stylesheet, google, web font, webfont
Requires at least: 4.0
Requires PHP: 5.3
Tested up to: 4.9.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress optimization toolkit with a focus on SEO. This plugin enables to achieve a Google PageSpeed 100 Score. Supports most optimization, minification and full page cache plugins.

== Description ==

This plugin is a toolkit for WordPress Optimization with a focus on SEO. The plugin enables to achieve a 100 score in the [Google PageSpeed Insights](https://developers.google.com/speed/pagespeed/insights/) test and an Excellent score in Google's latest AI based [Mobile Performance Benchmark test](https://testmysite.thinkwithgoogle.com/). 

This plugin is compatible with most optimization, minification and full page cache plugins and can be made compatible with other plugins by creating a module extension.

Some of the supported plugins include:
* [Autoptimize](https://wordpress.org/plugins/autoptimize/)
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/)
* [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/)
* [WP Fastest Cache](https://wordpress.org/plugins/wp-fastest-cache/)
* [Cache Enabler (KeyCDN.com)](https://wordpress.org/plugins/cache-enabler/)
* [Better WordPress Minify](https://wordpress.org/plugins/bwp-minify/)
* [WP Super Minify](https://wordpress.org/plugins/wp-super-minify/)
* [Click here](https://github.com/optimalisatie/above-the-fold-optimization/tree/master/trunk/modules/plugins/) for a list with supported plugins. 

**Warning:** *This plugin is not a simple 'on/off' plugin. It is a tool for optimization professionals and advanced WordPress users to achieve a Google PageSpeed 100 Score.*

### Critical CSS Tools

The plugin contains tools to manage Critical Path CSS. 

Some of the features:

* Conditional Critical CSS (apply tailored Critical CSS to specific pages based on WordPress conditions and filters)
* Management via text editor and FTP (critical CSS files are stored in the theme directory)
* Full CSS Extraction: selectively export CSS files of a page as a single file or as raw text for use in critical CSS generators.
* Quality Test: test the quality of Critical CSS by comparing it side-by-side with the full CSS display of a page. This tool can be used to detect a flash of unstyled content ([FOUC](https://en.wikipedia.org/wiki/Flash_of_unstyled_content)).
* A [javascript widget](https://github.com/optimalisatie/above-the-fold-optimization/blob/master/admin/js/css-extract-widget.js) to extract simple critical CSS with a click from the WordPress admin bar.
* A live critical CSS editor.

Read more about Critical CSS in the [documentation by Google](https://developers.google.com/speed/docs/insights/PrioritizeVisibleContent). 
[This article](https://github.com/addyosmani/critical-path-css-tools) by a Google engineer provides information about the available methods for creating critical CSS. 

### CSS Load Optimization

The plugin contains tools to optimize the delivery of CSS in the browser.

Some of the features:

* Async loading via [loadCSS](https://github.com/filamentgroup/loadCSS) (enhanced with `requestAnimationFrame` API following the [recommendations by Google](https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery))
* Remove CSS files from the HTML source.
* Capture and proxy (script injected) external stylesheets to load the files locally or via a CDN with optimized cache headers. This feature enables to pass the "[Leverage browser caching](https://developers.google.com/speed/docs/insights/LeverageBrowserCaching)" rule from Google PageSpeed Insights.

**The plugin does not provide CSS code optimization, minification or concatenation.**

### Javascript Load Optimization

The plugin contains tools to optimize the loading of javascript.

Some of the features:

* Robust async script loader based on [little-loader](https://github.com/walmartlabs/little-loader) by Walmart Labs ([reference](https://formidable.com/blog/2016/01/07/the-only-correct-script-loader-ever-made/))
* HTML5 Web Worker and Fetch API based script loader with localStorage cache and fallback to little-loader for old browsers.
* jQuery Stub that enables async loading of jQuery.
* Abiding of WordPress dependency configuration while loading files asynchronously.
* Lazy Loading Javascript (e.g. Facebook or Twitter widgets) based on [jQuery Lazy Load XT](https://github.com/ressio/lazy-load-xt#widgets).
* Capture and proxy (script injected) external javascript files to load the files locally or via a CDN with optimized cache headers. This feature enables to pass the "[Leverage browser caching](https://developers.google.com/speed/docs/insights/LeverageBrowserCaching)" rule from Google PageSpeed Insights.

The HTML5 script loader offers the following advantages when configured correctly:

* 0 javascript file download during navigation
* 0 javascript file download for returning visitors (e.g. from Google search results, leading to a reduced bounce rate)
* faster script loading than browser cache, especially on mobile (according to a [proof of concept](https://addyosmani.com/basket.js/) by a Google engineer)

**The plugin does not provide Javascript code optimization, minification or concatenation.**

### Google PWA Optimization

The plugin contains tools to achieve a 100 / 100 / 100 / 100 score in the [Google Lighthouse Test](https://developers.google.com/web/tools/lighthouse/). Google has been promoting [Progressive Web Apps](https://developers.google.com/web/progressive-web-apps/) (PWA) as the future of the internet: a combination of the flexability and openness of the existing web with the user experience advantages of native mobile apps. In essence: a mobile app that can be indexed by Google and that can be managed by WordPress. 

This plugin provides an advanced [HTML5 Service Worker](https://developers.google.com/web/fundamentals/getting-started/primers/service-workers) based solution to create a PWA with any website.

Some of the features:

* JSON based request and cache policy that includes regular expressions and numeric operator comparison for request and response headers.
* Offline availability management: default offline page, image or resource.
* Prefetch/preload resources in the Service Worker for fast access and/or offline availability.
* Event/click based offline cache (e.g. "click to read this page offline")
* HTTP HEAD based cache updates.
* Option to add `offline` class on `<body>` when the connection is offline.
* [Web App Manifest](https://developers.google.com/web/fundamentals/engage-and-retain/web-app-manifest/) management: add website to home screen on mobile devices, track app launches and more.

### Google Web Font Optimization

The plugin contains tools to optimize [Google Web Fonts](https://fonts.google.com/). 

Some of the features:

* Load Google Web Fonts via [Google Web Font Loader](https://github.com/typekit/webfontloader).
* Auto-discovery of Google Web Fonts using:
	* Parse `<link rel="stylesheet">` in HTML source.
	* Parse `@import` links in minified CSS from minification plugins (e.g. Autoptimize).
	* Parse existing `WebFontConfig` javascript configuration.
* Remove fonts to enable local font loading.
* Upload Google Web Font Packages from [google-webfonts-helper](https://google-webfonts-helper.herokuapp.com/) to the theme directory.

### Gulp.js Critical CSS Creator

The plugin contains a tool to create Critical CSS based on [Gulp.js](https://gulpjs.com/) tasks. The tool is based on [critical](https://github.com/addyosmani/critical) (by a Google engineer).

== Installation ==

### WordPress plugin installation

1. Upload the `above-the-fold-optimization/` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the plugin settings page.
4. Configure Critical CSS and tune the options for a Google PageSpeed 100 Score.

== Screenshots ==

1. HTML Optimization
2. CSS Optimization
3. Google Web Font Optimization
4. Javascript Optimization
5. Critical CSS Optimization
6. Critical CSS Quality Test
7. Critical CSS Editor
8. Google PWA Optimization
9. HTTP/2 Optimization
10. Gulp.js Critical CSS Generator

== Changelog ==

= 2.9.8 = 
* Improved: Synchronized scroll option in Critical CSS Quality Test.

= 2.9.7 = 
* Improved: Critical CSS Quality Test (Split View).
* Added: Critical CSS Live Editor.

= 2.9.6 =
* Added: Simple Critical CSS extraction javascript widget from admin menu bar. (@alexlii)
* Added: Full CSS extraction javascript widget from admin menu bar. (@bhagawadkrishna)
* Added: Search a page by URL (@Emilybkk)

= 2.9.5 =
* Added: option to require preloading of assets to complete in Service Worker installation (before activation).
* Added: Progressive Web App preload filter `abtf_pwa_preload`.
* Added: Service Worker sends identifying HTTP header `X-PAGESPEED-SW` in requests to allow server side modification for SW.

= 2.9.4 =
* Repair of previous incomplete update.

= 2.9.3 =
* Bugfix: PHP 5.3 compatibility (@thowden)
* Bugfix: Older webfont.js version `v1.6.26` on Google CDN. (@jimwalczak)
* Bugfix: Global CDN URL not applied. (@supernovae)
* Bugfix: Service Worker file not removed upon uninstallation.
* Bugfix: Google Lighthouse fails `start_url` audit. (@sirtaptap)
* Added: option to preload navigation requests in Service Worker on mousdown event to prevent 300ms tap delay.

= 2.9.2 =
* Added: HTTP/2 Server Push for Critical CSS.

= 2.9.1 =
* Bugfix: Service Worker JSON config from query parameter not persistent after browser restart.

= 2.9.0 =
* Added: HTTP/2 Server Push optimization.
* Added: [Cache Digest](https://calendar.perfplanet.com/2016/cache-digests-http2-server-push/) hash computation in PWA Service Worker for HTTP/2 pushed resources.
* Added: HTTP/2 test in admin menu.
* Added: PageSpeed admin menu.
* Improved: location of PWA config json file sent to Service Worker as a query parameter. ([@16patsle](https://github.com/optimalisatie/above-the-fold-optimization/issues/66))
* Improved: plugin disabled for REST API requests.
* Improved: Service Worker cache cleanup in idle time.

Older changes have been moved to changelog.txt.

== Upgrade Notice ==

= 2.4 =
The server side critical path CSS generator has been removed.

= 2.0 =
The upgrade requires a new configuration of Critical Path CSS. The configuration from version 1.0 will not be preserved.



