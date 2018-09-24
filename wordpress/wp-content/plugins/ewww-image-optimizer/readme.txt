=== EWWW Image Optimizer ===
Contributors: nosilver4u
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=MKMQKCBFFG3WW
Tags: image, compress, resize, optimize, optimization, lossless, lossy, seo, webp, wp-cli, scale, tinypng, tinyjpg
Requires at least: 4.6
Tested up to: 4.9
Requires PHP: 5.4
Stable tag: 4.3.2
License: GPLv3

Speed up your website and improve your visitors' experience by automatically compressing and resizing images and PDFs. Boost SEO and improve sales.

== Description ==

The EWWW Image Optimizer will increase your page speeds by way of image optimization. Increased page speeds can result in better search engine rankings, and will also improve conversion rates (increased sales and signups). It will also save you storage space and bandwidth. While EWWW I.O. will automatically optimize new images that you upload, it can also optimize all the images that you have already uploaded, and optionally convert your images to the best file format. You can choose pixel perfect compression or high compression options that are visually lossless.

EWWW I.O. will optimize images uploaded and created by any plugin, and features special integrations with many popular plugins, detailed below.

**Why use EWWW Image Optimizer?**

1. **No Speed Limits** and [unlimited file size](https://ewww.io/unlimited-file-size/). Using automatic Background Optimization and optional Parallel Optimization, get rid of upload delays and get back to doing what you love.
1. **Smooth Handling** with pixel-perfect optimization using industry-leading tools and progressive rendering.
1. **High Torque** as we bring you the best compression/quality ratio available with our lossy options for JPG, PNG, and PDF files.
1. **Adaptive Steering** with intelligent conversion options to get the right image format for the job (JPG, PNG, or GIF).
1. **Free Parking** The core plugin is free and always will be. Additionally, if you choose the API, you never pay for an image we can’t compress, you are never billed for a month you do not use the API, and pre-paid credits never expire. Plus, get WebP image generation at no extra cost: any JPG or PNG can be converted to Google’s next-generation image format.
1. **Comprehensive Coverage:** no image gets left behind, optimize everything on your site, beyond just the WordPress Media Library.
1. **Safety First:** all communications are secured with top SSL encryption.
1. **Roadside Assistance:** top-notch support is in our DNA. While API customers get top priority, we answer [every single support question with care](https://ewww.io/contact-us/).
1. **Pack a Spare:** free image backups store your original images for 30 days.

Images can be optimized using tools on your own server for free (jpegtran, optipng, pngout, pngquant, gifsicle, cwebp), or can be optimized via specialized servers that utilize the best tools available in lossless or lossy mode. Our lossy compression uses unique algorithms to gain maximum compression while remaining visually lossless. Your images can even be converted to the most suitable file format using the appropriate options. Using the EWWW I.O. API will allow the plugin to work on any hosting platform, and can also be desirable if you cannot, or do not want to use the exec() function on your server, or prefer to offload the resource demands of optimization.

If you need a version of this plugin for API use only, see [EWWW Image Optimizer Cloud](https://wordpress.org/plugins/ewww-image-optimizer-cloud/). It is much more compact as it does not contain any binaries or any mention of the exec() function.

= Automatic Resizing =

With ExactDN support, images will be automatically resized to fit the page and device size. ExactDN also enables basic retina support and automatic compression.

= Support =

If you need assistance using the plugin, please visit our [Support Page](https://ewww.io/contact-us/).
The EWWW Image Optimizer is developed at https://github.com/nosilver4u/ewww-image-optimizer

= Bulk Optimize =

Optimize all your images from a single page using the Bulk Scanner. This includes the Media Library, your theme, and a handful of pre-configured folders (see Optimize Everything Else below). Officially supported galleries (GRAND FlaGallery, NextCellent and NextGEN) have their own Bulk Optimize pages.

= Optimize Everything Else =

Configure any folder within your WordPress folder to be optimized. The Bulk Scan under Media->Bulk Optimize will optimize theme images, BuddyPress avatars, BuddyPress Activity Plus images, Meta Slider slides, WP Symposium Pro avatars, GD bbPress attachments, Grand Media Galleries, and any user-specified folders. Additionally, this tool can run on an hourly basis via wp_cron to keep newly uploaded images optimized. Scheduled optimization should not be used for any plugin that uses the built-in Wordpress image functions.

= Skips Previously Optimized Images =

All optimized images are stored in the database so that the plugin does not attempt to re-optimize them unless they are modified. On the Bulk Optimize page you can view a list of already optimized images. You may also remove individual images from the list, or use the Force optimize option to override the default behavior. The re-optimize links on the Media Library page also force the plugin to ignore the previous optimization status of images.

= WP Image Editor =

All images created by the built-in WP_Image_Editor class will be automatically optimized. Current implementations are GD, Imagick, and Gmagick. Images optimized via this class include Animated GIF Resize, BuddyPress Activity Plus (thumbs), Easy Watermark, Hammy, Imsanity, MediaPress, Meta Slider, MyArcadePlugin, OTF Regenerate Thumbnails, Regenerate Thumbnails, Simple Image Sizes, WP Retina 2x, WP RSS Aggregator and probably countless others. If you are not sure if a plugin uses WP_Image_Editor, [just ask](https://ewww.io/contact-us/).

= WebP Images =

One-click WebP with ExactDN and Alternative WebP Rewriting. Otherwise, can generate WebP versions of your images, and enables you to serve even smaller images to supported browsers. Several methods are available for serving WebP images, including Apache-compatible rewrite rules and our Alternative WebP Rewriting option compatible with caches and CDNs. Also works with the WebP option in the Cache Enabler plugin from KeyCDN.

= WP-CLI =

Allows you to run all Bulk Optimization processes from your command line, instead of the web interface. It is much faster, and allows you to do things like run it in 'screen' or via regular cron (instead of wp-cron, which can be unpredictable on low-traffic sites). Install WP-CLI from wp-cli.org, and run 'wp-cli.phar help ewwwio optimize' for more information or see the [Docs](https://docs.ewww.io/article/25-optimizing-with-wp-cli).

= FooGallery =

All images uploaded and cached by FooGallery are automatically optimized. Previous uploads can be optimized by running the Media Library Bulk Optimize. Previously cached images can be optimized by entering the wp-content/uploads/cache/ folder under Folders to Optimize and running a Scan & Optimize from the Bulk Optimize page.

= NextGEN Gallery =

Features optimization on upload capability, re-optimization, and bulk optimizing. The NextGEN Bulk Optimize function is located near the bottom of the NextGEN menu, and will optimize all images in all galleries. It is also possible to optimize groups of images in a gallery, or multiple galleries at once.

= NextCellent Gallery =

Features all the same capability as NextGEN, and is the continuation of legacy (1.9.x) NextGEN support.

= GRAND Flash Album Gallery =

Features optimization on upload capability, re-optimization, and bulk optimizing. The Bulk Optimize function is located near the bottom of the FlAGallery menu, and will optimize all images in all galleries. It is also possible to optimize groups of images in a gallery, or multiple galleries at once.

= Image Store =

Uploads are automatically optimized. Look for Optimize under the Image Store (Galleries) menu to see status of optimization and for re-optimization and bulk-optimization options. Using the Bulk Optimization tool under Media Library automatically includes all Image Store uploads.

= CDN Support =

Uploads to Amazon S3, Azure Storage, Cloudinary, and DreamSpeed CDN are optimized. All pull mode CDNs like Cloudflare, KeyCDN, MaxCDN, and Sucuri CloudProxy are also supported.

= WPML Compatible =

Tested regularly to ensure compatibility with multilingual sites. Learn more at https://wpml.org/plugin/ewww-image-optimizer/

= Translations =

Huge thanks to all our translators! See the full list here: https://translate.wordpress.org/projects/wp-plugins/ewww-image-optimizer/contributors

If you would like to help translate this plugin (new or existing translations), you can do so here: https://translate.wordpress.org/projects/wp-plugins/ewww-image-optimizer
To receive updates when new strings are available for translation, you can signup here: https://ewww.io/register/

== Installation ==

1. Upload the "ewww-image-optimizer" plugin to your /wp-content/plugins/ directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. The plugin will attempt to install jpegtran, optipng, and gifsicle automatically for you. This requires that the wp-content folder is writable by the user running the web server.
1. If the binaries don't run locally, you can sign up for the EWWW IO cloud service to run them via our optimization servers: https://ewww.io/plans/
1. *Recommended* Visit the settings page to enable/disable specific tools and turn on advanced optimization features.
1. Done!

If these steps do not work, additional documentation is available at https://docs.ewww.io/article/6-the-plugin-says-i-m-missing-something. If you need further assistance using the plugin, please visit our [Support Page](https://ewww.io/contact-us/).

= Webhosts =

To find out if your webhost works with the EWWW Image Optimizer, you can check the [official list](https://docs.ewww.io/article/43-supported-web-hosts).

== Frequently Asked Questions ==

= Google Pagespeed says my images need compressing or resizing, but I already optimized all my images. What do I do? =

Try this for starters: https://docs.ewww.io/article/5-pagespeed-says-my-images-need-more-work

= The plugin complains that I'm missing something, what do I do? =

This article will walk you through installing the required tools (and the alternatives if installation does not work): https://docs.ewww.io/article/6-the-plugin-says-i-m-missing-something

= Does the plugin replace existing images? =

Yes, but only if the optimized version is smaller. The plugin should NEVER create a larger image.

= Can I resize my images with this plugin? =

Yes, you can, set it up on the Resize tab.

= Can I lower the compression setting for JPGs to save more space? =

The lossy JPG optimization using the API will determine the ideal quality setting and give you the best results, but you can also adjust the default quality for conversion and resizing. More information: https://docs.ewww.io/article/12-jpq-quality-and-wordpress

= The bulk optimizer doesn't seem to be working, what can I do? =

See https://docs.ewww.io/article/39-bulk-optimizer-failure for full troubleshooting instructions.

= What are the supported operating systems? =

I've tested it on Windows (with Apache), Linux, Mac OSX, FreeBSD 9, and Solaris (v10). The cloud API will work on any OS.

= How are JPGs optimized? =

Lossless optimization is done with the command *jpegtran -copy all -optimize -progressive -outfile optimized-file original-file*. Optionally, the -copy switch gets the 'none' parameter if you choose to strip metadata from your JPGs on the options page.

= How are PNGs optimized? =

There are three parts (and all are optional). First, using the command *pngquant original-file*, then using the commands *pngout-static -s2 original-file* and *optipng -o2 original-file*. You can adjust the optimization levels for both tools using the [Overrides](https://docs.ewww.io/article/40-override-options). Optipng is an automated derivative of pngcrush, which is another widely used png optimization utility.

= How are GIFs optimized? =

Using the command *gifsicle -b -O3 --careful original file*. This is particularly useful for animated GIFs, and can also streamline your color palette. That said, if your GIF is not animated, you should strongly consider converting it to a PNG. PNG files are almost always smaller, they just don't do animations. The following command would do this for you on a Linux system with imagemagick: *convert somefile.gif somefile.png*

= I want to know more about image optimization, and why you chose these options/tools. =

That's not a question, but since I made it up, I'll answer it. See these resources:
https://developers.google.com/speed/docs/insights/OptimizeImages
http://developer.yahoo.com/performance/rules.html#opt_images

== Screenshots ==

1. Plugin settings page.
2. Additional optimize column added to media listing. You can see your savings, manually optimize individual images, and restore originals (converted only).
3. Bulk optimization page. You can optimize all your images at once and resume a previous bulk optimization. This is very useful for existing blogs that have lots of images.

== Changelog ==

* Feature requests can be submitted via https://ewww.io/contact-us/ and commented on here: https://trello.com/b/Fp81dWof/ewww-image-optimizer
* If you would like to help translate this plugin in your language, get started here: https://translate.wordpress.org/projects/wp-plugins/ewww-image-optimizer/

= 4.3.2 =
* changed: prevent dynamic JS/CSS urls within wp-admin/ from being rewritten by ExactDN
* fixed: auto-convert PNG to JPG was running on images with transparency
* fixed: Alt WebP broken on sites that have jquery-migrate disabled

= 4.3.1 =
* fixed: fatal error on older WP versions due to missing privacy policy function

= 4.3.0 =
* added: Alt WebP enables instant conversion with ExactDN, no need for bulk optimize
* added: links within settings and other notices for contextual help
* added: auto-convert large PNG images to JPG during upload, define EWWW_IMAGE_OPTIMIZER_DISABLE_AUTOCONVERT to skip
* added: use file modification time to add query strings on JS/CSS files for cache invalidation on ExactDN
* added: use EXACTDN_EXCLUDE in wp-config.php to bypass ExactDN for JS, CSS, etc.
* added: NextGEN image urls properly rewritten for ExactDN
* added: NextGEN dynamic thumbs included during manual/bulk optimization
* added: auto-installer for Cloud plugin when running EWWW IO on a "banned" webhost
* added: suggested privacy policy text for users of the API and ExactDN
* added: detect wordpress.com sites and disable exec function and binaries
* changed: resizing uses the primary media dimensions unless the "other" dimensions are configured
* changed: Resize Other Images removed from GUI, configure via Overrides tab
* changed: filter NextGEN quality to prevent oversized thumbs
* changed: allow crop via filter even when one dimension is the same as the original
* changed: auto-rotate function disabled with EWWW_IMAGE_OPTIMIZER_DISABLE_AUTOROTATE
* changed: one-click copy for debug info, and debug collapsed by default in media library and bulk results
* changed: bulk operations for batches of NextGEN images now use the bulk optimizer page instead of loading inline
* fixed: thumbs not generated during WP/LR Sync
* fixed: uploading images in the Gutenberg editor uses the wrong resize dimensions
* fixed: unique filename function producing names with a hyphen and no digits
* fixed: encoded ampersands within the path portion of a url prevent ExactDN parsing
* fixed: entering a decimal for bulk delay does nothing
* fixed: if urls on a localized WPML domain are using the default domain, ExactDN ignores them
* fixed: toggle for plugin status and bulk status generate admin-ajax.php 403 errors
* fixed: PNGOUT installer confirmation notice was missing
* deprecated: PHP 5.4 support will be removed in the next major release (version 4.4)

= 4.2.3 =
* added: skip resizing for images with noresize in the filename
* added: notice about plugins that remove query strings when ExactDN is active
* changed: cache busting for ExactDN uses theme directory modified time with fallback to EWWW IO version
* fixed: exactdn test verification attempts to access WP_Error as an array

= 4.2.2 =
* added: view pages with ExactDN or the entire plugin disabled via GET paramaters: ewwwio_disable and exactdn_disable
* changed: moved to v2 quota endpoint for API
* changed: S3 uploads no longer deferred until after optimization by default, define EWWW_IMAGE_OPTIMIZER_DEFER_S3 as true to override
* changed: image editor extensions can be disabled separately from media library optimization via EWWW_IMAGE_OPTIMIZER_DISABLE_EDITOR
* changed: use exactdn url instead of standard API url for verification simulation and fallback
* fixed: async test outputs unescaped html on settings page when debugging enabled
* fixed: debugging uses extra memory when dumping output to file
* fixed: json_encode dies silently when passing non-utf8 data, results in AJAX/bulk errors
* fixed: disabled auto-optimization bypassed for resizes when max dimensions are set
* fixed: NextGEN support disabled for version 3
* fixed: progressbar color does not match admin theme for NextGEN/Nextcellent
* fixed: optimization details overlay styling missing for NextGEN with some locales
* fixed: FlAGallery batch optimization from Manage Galleries/Images broken
* fixed: undefined variable notices for resize detection and forced re-optimization
* updated: PEL library for maintaining metadata during JPG auto-rotation

= 4.2.1 =
* fixed: EXACTDN_LOCAL_DOMAIN does not work with auto-verification
* fixed: uncaught error during upgrade when 'SHOW FULL COLUMNS' fails
* fixed: async simulation gets 403 error

= 4.2.0 =
* added: disable ExactDN attachment ID queries if they take too long
* added: ExactDN compatibility with a3 Lazy Load
* added: ability to re-test async/background mode if it gets disabled
* changed: better compatibility between Autoptimize and ExactDN
* changed: .webp files removed when restoring original from API
* changed: Force re-optimize checkbox persists up to an hour if bulk optimizer is interrupted
* fixed: CSS, JS, and other resources could be skipped by ExactDN in certain circumstances
* fixed: Jupiter theme captcha incompatible with ExactDN
* fixed: prevent calls to php_uname when it is disabled
* fixed: MacOS X installer for PNGOUT
* fixed: prevent notices due to empty output from exec()
* fixed: ExactDN fails to crop when image_downsize() is called with explicit dimensions
* fixed: ExactDN breaks image resizing with Themify themes
* fixed: multi-site settings throws error during submission when ExactDN is active
* fixed: single-site override option displayed when plugin activated per-site
* removed: PHP 5.3 no longer supported

= Earlier versions =
Please refer to the separate changelog.txt file.

== Upgrade Notice ==

= 4.2.0 =
* ExactDN verification rewritten, please report any issues immediately.
* PHP 5.3 support discontinued, see https://docs.ewww.io/article/55-upgrading-php

= 4.1.0 =
* Security update: gifsicle and optipng have been updated to resolve security flaws.
* ExactDN now processes JS/CSS/Fonts for even more speed.

= 4.0.0 =
* Introduced new ExactDN with CDN and automatic image resizing.

= 3.6.0 =
* API functions have been rewritten to use core WP detection for https capability, please report any errors right away.
* Several options have been removed from the user interface, see the changelog for details.

== Contact and Credits ==

Written by [Shane Bishop](https://ewww.io). Based upon CW Image Optimizer, which was written by [Jacob Allred](http://www.jacoballred.com/) at [Corban Works, LLC](http://www.corbanworks.com/). CW Image Optimizer was based on WP Smush.it. Jpegtran is the work of the Independent JPEG Group. PEL is the work of Martin Geisler, Lars Olesen, and Erik Oskam. ExactDN class based upon the Photon module from Jetpack.

= optipng =

Copyright (C) 2001-2017 Cosmin Truta and the Contributing Authors.
For the purpose of copyright and licensing, the list of Contributing
Authors is available in the accompanying AUTHORS file.

This software is provided 'as-is', without any express or implied
warranty.  In no event will the author(s) be held liable for any damages
arising from the use of this software.

= pngquant.c =

   © 1989, 1991 by Jef Poskanzer.

   Permission to use, copy, modify, and distribute this software and its
   documentation for any purpose and without fee is hereby granted, provided
   that the above copyright notice appear in all copies and that both that
   copyright notice and this permission notice appear in supporting
   documentation.  This software is provided "as is" without express or
   implied warranty.

= pngquant.c and rwpng.c/h =

   © 1997-2002 by Greg Roelofs; based on an idea by Stefan Schneider.
   © 2009-2017 by Kornel Lesiński.

   All rights reserved.

   Redistribution and use in source and binary forms, with or without modification,
   are permitted provided that the following conditions are met:

   1. Redistributions of source code must retain the above copyright notice,
      this list of conditions and the following disclaimer.

   2. Redistributions in binary form must reproduce the above copyright notice,
      this list of conditions and the following disclaimer in the documentation
      and/or other materials provided with the distribution.

   THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
   AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
   IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
   DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
   FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
   DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
   SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
   CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
   OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
   OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

= WebP =

Copyright (c) 2010, Google Inc. All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are
met:

  * Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.

  * Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in
    the documentation and/or other materials provided with the
    distribution.

  * Neither the name of Google nor the names of its contributors may
    be used to endorse or promote products derived from this software
    without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
