<?php

if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * File based page cache drop in
 */
require_once(dirname(__FILE__) . '/file-based-page-cache-functions.php');

if (!defined('WPO_CACHE_DIR')) define('WPO_CACHE_DIR', untrailingslashit(WP_CONTENT_DIR) . '/wpo-cache');

/**
 * Load extensions.
 */
wpo_cache_load_extensions();

/**
 * Action triggered when the cache extensions are all loaded. Allows to execute code depending on an other extension, without knowing the order in which the files are loaded.
 */
do_action('wpo_cache_extensions_loaded');

if (true === wpo_can_serve_from_cache()) {
	wpo_serve_cache();
}
