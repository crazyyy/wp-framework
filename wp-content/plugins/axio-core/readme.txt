=== Axio Core ===
Contributors: Teemu Suoranta
Tags: wordpress, axio, core, axio-starter
Requires at least: 5.0.0
Tested up to: 5.8.3
Requires PHP: 7.0
Stable tag: 1.1.1
License: GPLv2+

Core plugin for WordPress projects.

== Description ==
The plugin contains the features and settings generally deemed to be the most commonly used in all projects. It is meant to be used together with [axio-starter](https://github.com/generaxion/axio-starter) but functions on its own as well. Use the site specific plugin to configure the specs of this plugin.

This plugin replaces the previous Aucor Core and is backwards compatible with same function and filter names working.

== Contents ==

= Abstract Classes =

Directory: root

The models the features are built on

= Features and subfeatures =

Directory: `/features/`

Features (containing subfeatures) ranging from security settings to speed optimizations and dashboard cleanup.

admin:

* front page edit link
* gallery
* image-links
* login
* admin menu cleanup
* notifications
* profile cleanup
* remove customizer

classic-editor:

* tinymce

dashboard:

* cleanup
* recent widget
* remove panels

front-end:

* clean up empty html nodes
* excerpt
* html fixes

localization:

* string translations

plugins:

* acf
* cookiebot
* gravityforms
* redirection
* public post preview
* seo
* yoast

polyfills:

* acf
* polylang

security:

* disable admin email check
* disable file edit
* disable unfiltered html
* head cleanup
* hide users
* remove comment moderation
* remove commenting

speed:

* limit revisions
* move jquery
* remove emojis
* remove metabox

debug:

* style guide
* wireframe

= Helper functions =

Directory: root

Contains functions, like enhanced (internal) debugging, for all features/subfeatures to use

== Configuration (optional) ==

=  "Active" subfeatures =
* The *style guide* subfeature overrides the WP function `the_content()` with default markup for testing the most common tag styles, when the GET parameter '?ac-debug=styleguide' is found in the url. You can however replace this markup with a filter:

`add_filter('axio_core_custom_markup', function($content) {
  $content = 'custom markup';
  return $content;
});`

* The *wireframe* subfeature adds outlines to all elements on page to help with visual debugging, when the GET parameter '?ac-debug=wireframe' is found in the url. It also appends '?ac-debug=wireframe' to the href value in all anchor tags on the page to keep the feature enabled during navigation.

= Disable feature/subfeature =
By default all the features/subfeatures are on, but you can disable the ones you don't want with filters in theme or plugin. Here is a minimal code snippet you can use to disable features:

`<?php
// disable a feature in Axio Core
add_filter('feature or subfeature key', '__return_false');`

Note that if you disable a feature, all underlying subfeatures will be disabled as well.


== Installation ==
Download and activate. That's it.

== Changelog ==

= 1.1.2 =
Added feature to force suffix to attachment page slugs to prevent attachments from reserving nice slugs.

= 1.1.1 =
Enhanced data sanitazing on echoing functions, fix metadata errors, move to local placeholder image on styleguide.

= 1.1.0 =
Add possibility to force ACF block mode, hide Cookiebot admin notice and extend Public Post Preview nonce.

= 1.0.0 =
Initial release.
