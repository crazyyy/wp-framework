<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if the sanitizer class exists
if ( ! class_exists( '\enshrined\svgSanitize\data\AllowedTags' ) ) {
    // Load the composer autoloader if it exists
    $autoloader = dirname( __FILE__ ) . '/../vendor/autoload.php';
    if ( file_exists( $autoloader ) ) {
        require_once $autoloader;
    }
}

// Only define the class if the parent class exists
if ( class_exists( '\enshrined\svgSanitize\data\AllowedTags' ) ) {
    class bodhi_svg_tags extends \enshrined\svgSanitize\data\AllowedTags {
        /**
         * Returns an array of tags
         *
         * @return array
         */
        public static function getTags() {
            return apply_filters( 'svg_allowed_tags', parent::getTags() );
        }
    }
} else {
    // Add an admin notice if the sanitizer isn't available
    add_action('admin_notices', function() {
        if (current_user_can('manage_options')) {
            echo '<div class="notice notice-warning is-dismissible"><p>' . 
                 esc_html__('SVG Support: SVG Sanitizer library not found. Some features may be limited.', 'svg-support') . 
                 '</p></div>';
        }
    });
    
    // Fallback class if the sanitizer isn't available
    class bodhi_svg_tags {
        /**
         * Returns an array of tags
         *
         * @return array
         */
        public static function getTags() {
            $tags = array(
                'svg',
                'g',
                'path',
                'circle',
                'rect',
                'line',
                'polyline',
                'polygon',
            );
            return apply_filters( 'svg_allowed_tags', $tags );
        }
    }
}