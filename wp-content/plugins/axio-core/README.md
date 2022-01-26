# Axio Core

[![Build Status](https://api.travis-ci.org/generaxion/axio-core.svg?branch=master)](https://travis-ci.org/generaxion/axio-core)

Core plugin for WordPress projects. The plugin contains the features and settings generally deemed to be the most commonly used in all projects. It is meant to be used together with [axio-starter](https://github.com/generaxion/axio-starter) but functions on it's own as well. Use the site specific plugin to configure the specs of this plugin.

This plugin replaces the previous Aucor Core and is backwards compatible with same function and filter names working.

## How to install

1. Download this repository
1. Extract into /plugins/
1. Activate

(When released, will be available on WordPress.org)

## Contents

### Abstract Classes

Directory: root

The models the features are built on

### Features and subfeatures

Directory: `/features/`

Features (containing subfeatures) ranging from security settings to speed optimizations and dashboard cleanup.

- admin
    - front page edit link
    - gallery
    - image-links
    - login
    - admin menu cleanup
    - notifications
    - profile cleanup
    - remove customizer
- classic-editor
    - tinymce
- dashboard
    - cleanup
    - recent widget
    - remove panels
- front-end
    - clean up empty html nodes
    - excerpt
    - html fixes
- localization
    - string translations
- plugins
    - acf
    - cookiebot
    - gravityforms
    - redirection
    - public post preview
    - seo
    - yoast
- polyfills
    - acf
    - polylang
- security
    - disable admin email check
    - disable file edit
    - disable unfiltered html
    - head cleanup
    - hide users
    - remove comment moderation
    - remove commenting
- speed
    - limit revisions
    - move jquery
    - remove emojis
    - remove metabox
- debug
    - style guide
    - wireframe

### Helper functions

Directory: root

Contains functions, like enhanced (internal) debugging, for all features/subfeatures to use

## Configuration (optional)

### "Active" subfeatures
- The *style guide* subfeature overrides the WP function `the_content()` with default markup for testing the most common tag styles, when the GET parameter '?ac-debug=styleguide' is found in the url. You can however replace this markup with a filter:
```
add_filter('axio_core_custom_markup', function($content) {
  $content = 'custom markup';
  return $content;
});
```
- The *wireframe* subfeature adds outlines to all elements on page to help with visual debugging, when the GET parameter '?ac-debug=wireframe' is found in the url. It also appends '?ac-debug=wireframe' to the href value in all anchor tags on the page to keep the feature enabled during navigation.

### Disable feature/subfeature
By default all the features/subfeatures are on but you can disable the ones you don't want with filters from theme or plugin. Here is a minimal code snippet you can use to disable features:

```
<?php
/**
 * Plugin Name: YOUR PLUGIN NAME
 */

// disable a feature in Axio Core
add_filter('feature or subfeature key', '__return_false');
```

Note that if you disable a feature, all underlying subfeatures will be disabled as well.
