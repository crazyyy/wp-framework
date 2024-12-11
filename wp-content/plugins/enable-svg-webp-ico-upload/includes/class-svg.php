<?php
require_once __DIR__ . '/vendor/autoload.php';

use enshrined\svgSanitize\Sanitizer;

class ITC_SVG_Upload_Svg {

    protected $sanitizer;

    public function __construct() {
        $this->sanitizer = new Sanitizer();
    }

    // Allow SVG uploads
    public function add_svg_support($mime_types) {
        $mime_types['svg'] = 'image/svg+xml';
        return $mime_types;
    }

    // Sanitize SVG during upload
    public function sanitize_svg_upload($upload) {
        if (isset($upload['type']) && $upload['type'] === 'image/svg+xml') {
            if (!isset($upload['name']) || !$this->check_and_sanitize_file($upload['tmp_name'])) {
                $upload['error'] = __('Sorry, the SVG file could not be sanitized.', 'enable-svg-webp-ico-upload');
            }
        }
        return $upload;
    }

    // Check and sanitize the SVG file
    protected function check_and_sanitize_file($file) {
        $unclean = file_get_contents($file);

        if ($unclean === false) {
            return false;
        }

        // Set allowed tags and attributes with filters
        $this->sanitizer->setAllowedTags(new class extends \enshrined\svgSanitize\data\AllowedTags {
            public static function getTags() {
                return apply_filters('esw_svg_allowed_tags', parent::getTags());
            }
        });

        $this->sanitizer->setAllowedAttrs(new class extends \enshrined\svgSanitize\data\AllowedAttributes {
            public static function getAttributes() {
                return apply_filters('esw_svg_allowed_attributes', parent::getAttributes());
            }
        });

        $clean = $this->sanitizer->sanitize($unclean);

        if ($clean === false) {
            return false;
        }

        // Save the sanitized SVG file
        file_put_contents($file, $clean);
        return true;
    }

    // Validate SVG files
    public function validate_svg_file($checked, $file, $filename, $mimes) {
        if (!$checked['type']) {
            $file_info = wp_check_filetype($filename, $mimes);
            if ($file_info['ext'] === 'svg' && $file_info['type'] === 'image/svg+xml') {
                $checked = [
                    'ext' => $file_info['ext'],
                    'type' => $file_info['type'],
                    'proper_filename' => $filename,
                ];
            }
        }
        return $checked;
    }

    // Display SVG files in the WordPress Media Library
    public function display_svg_in_media_library($response, $attachment, $meta) {
        if ($response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement')) {
            $path = get_attached_file($attachment->ID);
            if (@file_exists($path)) {
                try {
                    $svg = new SimpleXMLElement(@file_get_contents($path));
                    $response['image'] = $response['thumb'] = [
                        'src' => $response['url'],
                        'width' => (int)$svg['width'],
                        'height' => (int)$svg['height'],
                    ];
                } catch (Exception $e) {
                    // Handle parsing errors
                }
            }
        }
        return $response;
    }

    // Add custom styles for SVGs in the WordPress admin interface
    public function add_svg_styles() {
        echo "<style>
            /* Media Library SVG styles */
            table.media .column-title .media-icon img[src*='.svg'] {
                width: 100%;
                height: auto;
            }

            /* Gutenberg editor SVG styles */
            .components-responsive-wrapper__content[src*='.svg'] {
                position: relative;
            }
        </style>";
    }
}
