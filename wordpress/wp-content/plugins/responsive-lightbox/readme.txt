=== Responsive Lightbox by dFactory ===
Contributors: dfactory
Donate link: http://www.dfactory.eu/
Tags: gallery, images, lightbox, photos, theme, photo, image, picture, slideshow, modal, overlay, video
Requires at least: 4.0
Tested up to: 4.7.5
Stable tag: 1.7.2
License: MIT License
License URI: http://opensource.org/licenses/MIT

Responsive Lightbox allows users to view larger versions of images and galleries in a lightbox (overlay) effect optimized for mobile devices.

== Description ==

[Responsive Lightbox](http://www.dfactory.eu/plugins/responsive-lightbox/) allows users to view larger versions of images and galleries in a lightbox (overlay) effect optimized for mobile devices.

For more information, check out plugin page at [dFactory](http://www.dfactory.eu/) or see the [Live demo](http://www.dfactory.eu/plugins/responsive-lightbox/) on our site.

= Features include: =

* Select from 7 responsive lightbox scripts (SwipeBox, prettyPhoto, FancyBox, Nivo Lightbox, Image Lightbox, Tos "R" Us, Featherlight)
* Automatically add lightbox to WordPress image galleries
* Automatically add lightbox to WordPress image links
* Automatically add lightbox to WordPress video links (YouTube, Vimeo)
* Automatically add lightbox to widgets content
* Automatically add lightbox to WordPress comments content
* WooCommerce product gallery support
* Visual Composer compatibility
* Gallery widget
* Single image widget
* Option to display single post images as a gallery
* Option to modify native WP gallery links image size
* Option to set gallery images title from image title, caption, alt or description
* Option to force lightbox for custom WP gallery replacements like Jetpack tiled galleries
* Option to trigger lightbox on custom jquery events
* Option to conditionally load scripts and styles only on pages that have images or galleries in post content
* Enter a selector for lightbox
* Highly customizable settings for each of the lightbox scripts
* Multisite support
* Filter hook for embeddding different scripts based on any custom conditions (page, post, category, user id, etc.)
* .pot file for translations included

> <strong>Premium Extensions:</strong>
> [Photo & Art bundle](https://www.dfactory.eu/products/photo-art-bundle/)
> [Justified Gallery](https://www.dfactory.eu/products/justified-gallery/)
> [Expander Gallery](https://www.dfactory.eu/products/expander-gallery/)
> [Hidden Gallery](https://www.dfactory.eu/products/hidden-gallery/)
> [Masonry Image Gallery](https://www.dfactory.eu/products/masonry-image-gallery/)
> [Slider Gallery](https://www.dfactory.eu/products/slider-gallery/)
> [Lightcase Lightbox](https://www.dfactory.eu/products/lightcase-lightbox/)
> [PhotoSwipe Lightbox](https://www.dfactory.eu/products/photoswipe-lightbox/)
> [Lightgallery Lightbox](https://www.dfactory.eu/products/lightgallery-lightbox/)
> [Strip Lightbox](https://www.dfactory.eu/products/strip-lightbox/)
> [Fancybox Pro](https://www.dfactory.eu/products/fancybox-pro/)

== Installation ==

1. Install Responsive Lightbox either via the WordPress.org plugin directory, or by uploading the files to your server
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Responsive Lightbox settings and set your desired options.

== Frequently Asked Questions ==

No questions yet.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.jpg

== Changelog ==

= 1.7.2 =
* Fix: Cross-site scripting (XSS) vulnerability
* Tweak: Improved Jetpack gallery compatibility

= 1.7.1 =
* New: Tos "R" Us overlay close option
* Fix: License activation issues
* Tweak: Featherlight script update to 1.7.0
* Tweak: Imagelightbox script update

= 1.7.0 =
* New: Add lightbox to widgets content
* New: Add lightbox to WordPress comments
* New: Gallery widget
* New: Single image widget
* New: Visual Composer compatibility
* New: WooCommerce 3.0 compatibility
* New: [Fancybox Pro](https://www.dfactory.eu/products/fancybox-pro/) premium extension
* New: [Expander Gallery](https://www.dfactory.eu/products/expander-gallery/) premium extension
* New: [Hidden Gallery](https://www.dfactory.eu/products/hidden-gallery/) premium extension
* Tweak: Attachment ID query optimization
* Tweak: Revamped lightbox settings screen
* Tweak: Improved custom galleries compatibility

= 1.6.12 =
* Fix: WooCommerce single product image lightbox

= 1.6.11 =
* Tweak: Added plugin documentation link
* Tweak: Nivo lightbox update to 1.3.1

= 1.6.10 =
* New: Featherlight lightbox script
* New: [Lightgallery Lightbox](https://www.dfactory.eu/products/lightgallery-lightbox/) premium extension
* New: [Slider Gallery](https://www.dfactory.eu/products/slider-gallery/) premium extension

= 1.6.9 =
* New: [PhotoSwipe Lightbox](https://www.dfactory.eu/products/photoswipe-lightbox/) premium extension
* Fix: data-rel attribute missing in multiline links
* Tweak: Removed local translation files in favor of WP repository translations
* Tweak: SwipeBox script updated to 1.4.4

= 1.6.8 =
* Tweak: Tos "R" Us script caption issue when empty link title
* Tweak: Undefined notice on extentions activation.

= 1.6.7 =
* New: WooCommerce product gallery support
* New: [Masonry Image Gallery](https://www.dfactory.eu/products/masonry-image-gallery/) and [Strip Lightbox](https://www.dfactory.eu/products/strip-lightbox/) extensions
* Tweak: Tos"R"Us script updated to 2.4.2
* Tweak: Settings handler improvements.

= 1.6.6 =
* Tweak: Confirmed WordPress 4.4 compatibility

= 1.6.5 =
* Fix: Lightbox activated on non-video youtube links
* Tweak: Added a way to change settings required capability 

= 1.6.4 =
* Tweak: prettyPhoto improvements for mobile devices

= 1.6.3 =
* Fix: Tos"R"Us script initialized multiple times in Ajax
* Fix: Regex issue with replacing rel attribute
* Tweak: Swipebox updated to 1.4.1

= 1.6.2 =
* New: Disable lightbox for single images with data-rel="norl" attribute
* Tweak: Keep rel attribute intact if used in post content links
* Tweak: Vimeo regex improvements

= 1.6.1 =
* Fix: prettyPhoto and Nivo gallery navigation broken
* Tweak: Added another way to close the extensions notification

= 1.6.0 =
* New: Introducing [Justified Gallery](https://www.dfactory.eu/products/justified-gallery/) and [Lightcase Lightbox](https://www.dfactory.eu/products/lightcase-lightbox/) premium extensions.
* New: Option to set single images title from image title, caption, alt or description
* Tweak: Confirmed WP 4.3 compatibility

= 1.5.8 =
* Tweak: Switched to protocol independent URLs in Nivo and Tosrus

= 1.5.7 =
* New: Romanian translation, thanks to [Victor Chiritoiu](http://contacter.ro)
* Fix: Tos "R" Us pagination thumbnails and pause on hover settings not working
* Tweak: Scripts and styles versioning, for better cache handling
* Tweak: French translation updated

= 1.5.6 =
* New: Option to conditionally load scripts and styles only on pages that have images or galleries in post content.

= 1.5.5 =
* Tweak: Multiple backward rel attribute compatibility tweaks
* Fix: Nivo lightbox and Image lightbox js attr errors when no data-rel given
* Fix: Swipebox option to remove top and bottom bars

= 1.5.4 =
* Tweak: Swipebox option to remove top and bottom bars on mobile devices
* Fix: Swipe support for Tos "R" Us lightbox script

= 1.5.3 =
* Fix: Nivo lightbox buttons and styles missing

= 1.5.2 =
* New: Tos "R" Us lightbox script
* Fix: Final fix for video links regex (hopefully)
* Tweak: Switched from rel to data-rel attribute to avoid W3C validation errors
* Tweak: Optimized gallery image size function

= 1.5.1 =
* Tweak: Support for multiple custom galleries per page (via gallery-n) in rel
* Fix: Boolean / subfields bug not saving settings properly
* Fix: Vimeo videos automatic lightbox not working when query parameters were not set

= 1.5.0 =
* New: Revamped User Interface
* New: Option to force lightbox for custom WP gallery replacements like Jetpack tiled galleries 

= 1.4.14 =
* New: Option to set gallery images title from image title, caption, alt or description
* Tweak: Improved regex for Youtube video links

= 1.4.13 =
* Fix: Reverted back the regex change in lightbox selector to gallery links

= 1.4.12 =
* Fix: jQuery prettyPhoto DOM Cross-Site Scripting (XSS) vulnerability
* Tweak: Added regex filetype check before applying lightbox selector to gallery links.
* Tweak: Switched from wp_generate_password() to custom function, without needless DB call.

= 1.4.11 =
* Tweak: Swipebox script updated to 1.3.0.2
* Tweak: prettyPhoto CSS tweaks
* Tweak: fancyBox IE patch

= 1.4.10 =
* Tweak: Image Lightbox updated

= 1.4.9 =
* New: Hungarian translation, thanks to [Zsolt Boda](http://cmfrt.net/)
* Tweak: Remove direct http calls from Javascript to improve https protocol compatibility

= 1.4.8 =
* Tweak: Nivo Lightbox updated to 1.2
* Tweak: Confirmed WP 4.0 compatibility

= 1.4.7 =
* New: Option to modify native WP gallery links image size
* New: Option to donate this plugin :)

= 1.4.6 =
* New: Slovak translation, thanks to [Patrik Zec](http://patwist.com)

= 1.4.5 =
* New: Russian translation, thanks to [Konstantin](http://l-konstantin.ru)

= 1.4.4 =
* Fix: Prevent unintentional scroll to the top when pressing the "enter" key in the opened swipebox, thanks to Arno Welzel

= 1.4.3 =
* New: Estonian translation, thanks to Hugo Amtmann
* Tweak: Swipebox script update, thanks to Arno Welzel

= 1.4.2 =
* Fix: Final fix for IE scroll bug

= 1.4.1 =
* Fix: Swipebox script files inconsistency

= 1.4.0 =
* New: Added Image Lightbox script
* New: Option to load scripts in header or footer
* Tweak: Changed Swipebox script to custom built, thanks to Arno Welzel

= 1.3.6 =
* New: Added rl_lightbox_args filter hook for embeddding different scripts based on any custom conditions (page, post, category, user id, etc.)

= 1.3.5 =
* New: Dutch translation, thanks to [Sebas Blom](http://www.basbva.nl/)

= 1.3.4 =
* Fix: Gallery images displayed as single images

= 1.3.3 =
* New: Triggering lightbox on custom jquery events option
* Tweak: UI improvements for WP 3.8

= 1.3.2 =
* New: German translation, thanks to Andreas Reitberger
* Tweak: Nivo Lightbox script updated

= 1.3.1 =
* New: Spanish translation, thanks to Gaston
* Tweak: Japanese translation updated

= 1.3.0 =
* New: Added Nivo Lightbox script
* New: Option to reset plugin settings to defaults

= 1.2.3 =
* New: Serbo-Croatian translation, thanks to Borisa Djuraskovic

= 1.2.2 =
* New: Option to force PNG icons in case of display problems
* Fix: Bug with video width not working in SwipeBox

= 1.2.1 =
* New: Support for images loaded via AJAX
* Tweak: Updated Japanese translation

= 1.2.0 =
* New: Added FancyBox script
* Tweak: UI enhancements for options
* Tweak: Better YouTube video handling (including https protocol) 

= 1.1.2 =
* New: Japanese translation, thanks to stranger-jp

= 1.1.1 =
* Tweak: UI enhancements for prettyPhoto opacity

= 1.1.0 =
* New: Multisite support
* Fix: Notice during first plugin activation

= 1.0.4 =
* Fix: Changed regex for links to attachment pages, thanks to Darwin

= 1.0.3 =
* New: Added Czech translation, thanks to Vaclav Hnilicka
* Tweak: Small UI enhancements
* Tweak: Changed SwipeBox Top and Bottom bars options description

= 1.0.2 =
* New: Option to display single post images as a gallery
* New: Added French translation by Li-An
* Tweak: Rewritten regex for selector

= 1.0.1 =
* New: Support for video links (YouTube and Vimeo)
* New: Added Polish translation
* New: Added Persian translation by Ali Mirzaei
* Tweak: SwipeBox script updated
* Tweak: Changed method of applying lightbox rel attribute to single images

= 1.0.0 =
Initial release

== Upgrade Notice ==

= 1.7.2 =
* Fix: Cross-site scripting (XSS) vulnerability