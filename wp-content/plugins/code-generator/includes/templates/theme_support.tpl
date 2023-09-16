<?php if ( ! empty ( $data['wpg_content-width'] ) ) { ?>
// Set content width value based on the theme's design
if ( ! isset( $content_width ) )
	$content_width = {{content-width-pixels}};
<?php } ?>
<?php if ( ! empty ( $wpg_child_themes ) ) { ?>

if ( ! function_exists('{{function_name}}') ) {
<?php } ?>

// Register Theme Features
function {{function_name}}()  {
<?php if ( ! empty ( $data['wpg_automatic-feed-links'] ) ) { ?>

	// Add theme support for Automatic Feed Links
	add_theme_support( 'automatic-feed-links' );
<?php } ?>
<?php if ( ! empty ( $data['wpg_post-formats'] ) ) { ?>

	// Add theme support for Post Formats
	add_theme_support( 'post-formats', array( {{formats_status}} ) );
<?php } ?>
<?php if ( ! empty ( $data['wpg_post-thumbnails'] ) ) { ?>

	// Add theme support for Featured Images
	add_theme_support( 'post-thumbnails'<?php
		if ( ! empty ( $data['wpg_thumbnails-types'] ) && 'custom' === $data['wpg_thumbnails-types'] ) {
			?>, array( {{thumbnails-custom-types}}<?php } ?> ) );
<?php } ?>
<?php if ( ! empty ( $data['wpg_post-thumbnails'] ) && ! empty ( $data['wpg_set-thumbnails-dimensions'] ) ) { ?>

	 // Set custom thumbnail dimensions
	set_post_thumbnail_size( {{thumbnails-width}}, {{thumbnails-height}}, true );
<?php } ?>
<?php if ( ! empty ( $data['wpg_custom-background'] ) ) { ?>

	// Add theme support for Custom Background
	$background_args = array(
		'default-color'          => '{{background-default-color}}',
		'default-image'          => '{{background-default-image}}',
		'default-repeat'         => '{{background-default-repeat}}',
		'default-position-x'     => '{{background-default-position-x}}',
		'wp-head-callback'       => '{{background-wp-head-callback}}',
		'admin-head-callback'    => '{{background-admin-head-callback}}',
		'admin-preview-callback' => '{{background-admin-preview-callback}}',
	);
	add_theme_support( 'custom-background', $background_args );
<?php } ?>
<?php if ( ! empty ( $data['wpg_custom-header'] ) ) { ?>

	// Add theme support for Custom Header
	$header_args = array(
		'default-image'          => '{{header-default-image}}',
		'width'                  => {{header-width}},
		'height'                 => {{header-height}},
		'flex-width'             => {{header-flex-width}},
		'flex-height'            => {{header-flex-height}},
		'uploads'                => {{header-uploads}},
		'random-default'         => {{header-random-default}},
		'header-text'            => {{header-header-text}},
		'default-text-color'     => '<?php if ( ! empty ( $data['wpg_header-header-text'] ) && 'true' === $data['wpg_header-header-text'] ) { ?>{{header-default-text-color}}<?php } ?>',
		'wp-head-callback'       => '{{header-wp-head-callback}}',
		'admin-head-callback'    => '{{header-admin-head-callback}}',
		'admin-preview-callback' => '{{header-admin-preview-callback}}',
		'video'                  => {{header-video}},
		'video-active-callback'  => '{{header-video-active-callback}}',
	);
	add_theme_support( 'custom-header', $header_args );
<?php } ?>
<?php if ( ! empty ( $data['wpg_semantic-markup'] ) ) { ?>

	// Add theme support for HTML5 Semantic Markup
	add_theme_support( 'html5', array( {{markup_search}} ) );
<?php } ?>
<?php if ( ! empty ( $data['wpg_title-tag'] ) ) { ?>

	// Add theme support for document Title tag
	add_theme_support( 'title-tag' );
<?php } ?>
<?php if ( ! empty ( $data['wpg_editor-style'] ) ) { ?>

	// Add theme support for custom CSS in the TinyMCE visual editor
	add_editor_style(<?php if ( ! empty ( $data['wpg_editor-style-file'] ) ) { ?> '{{editor-style-file}}' <?php } ?>);
<?php } ?>
<?php if ( ! empty ( $data['wpg_theme-translation'] ) ) { ?>

	// Add theme support for Translation
	load_theme_textdomain( '{{textdomain}}', get_template_directory() . '{{textdomain-path}}' );
<?php } ?>
}
add_action( 'after_setup_theme', '{{function_name}}' );
<?php if ( ! empty ( $wpg_child_themes ) ) { ?>

}
<?php }