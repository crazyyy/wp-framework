<?php // Misc options
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_wp_version_number');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_yoast_information');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_html_minify');
$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_remove_dns_prefetch');
?>
