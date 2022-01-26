<?php // Script options
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_cssjs_ver');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_jquery_migrate');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_emoji_release');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_recent_comments_css');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_wlwmanifest');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_wp_json');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_wp_shortlink');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_wp_post_links');
?>
