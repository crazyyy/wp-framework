<?php
/**
 * Featured image meta checkbox to inline SVG
 *
 * Allow users to select whether featured images should contain the SVG Support class.
 * Check if the featured image is SVG first, then display meta box for SVG only.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add checkbox to the featured image metabox.
 */
function bodhi_svgs_featured_image_meta( $content ) {

	global $post;

	$thumbnail = get_the_post_thumbnail();
	// Check if featured image is set and has extension of .svg or .svgz.
	if ( $thumbnail && strpos( $thumbnail, '.svg' ) !== false ) {

		$text 	= __( 'Render this SVG inline (advanced)', 'svg-support' );
		$id 	= 'inline_featured_image';
		$value 	= esc_attr( get_post_meta( $post->ID, $id, true ) );
		$label 	= '<label for="' . $id . '" class="selectit"><input name="' . $id . '" type="checkbox" id="' . $id . '" value="1" '. checked( $value, 1, false ) .'> ' . $text .'</label>';
		$nonce  = wp_nonce_field( 'bodhi_svgs_save_featured_image_meta', 'bodhi_svgs_featured_image_nonce', true, false );

		return $content .= $label . $nonce;

	} else {

		return $content;

	}

}
if ( bodhi_svgs_advanced_mode() ) {
	add_filter( 'admin_post_thumbnail_html', 'bodhi_svgs_featured_image_meta' );
}

/**
 * Save featured image meta data when saved.
 */
function bodhi_svgs_save_featured_image_meta( $post_id, $post, $update ) {

	// Verify nonce
	if ( ! isset( $_POST['bodhi_svgs_featured_image_nonce'] ) || 
		! wp_verify_nonce( 
			sanitize_text_field( wp_unslash( $_POST['bodhi_svgs_featured_image_nonce'] ) ), 
			'bodhi_svgs_save_featured_image_meta' 
		) 
	) {
		return $post_id;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// If the user does not have permission to edit posts, do nothing.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// If checkbox is checked, add/update meta
	if ( isset( $_POST['inline_featured_image'] ) ) {
		update_post_meta( $post_id, 'inline_featured_image', 1 );
	} else {
		// If unchecked, delete the meta entirely
		delete_post_meta( $post_id, 'inline_featured_image' );
	}
}
add_action( 'save_post', 'bodhi_svgs_save_featured_image_meta', 10, 3 );

/*
 * Save featured image meta for Gutenberg Editor
 */
function bodhi_svgs_register_meta() {

    register_meta( 'post', 'inline_featured_image', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'boolean',
		'auth_callback' => '__return_true'
    ) );

}
add_action( 'init', 'bodhi_svgs_register_meta' );

/**
 * Add class to the featured image output on front end.
 */
function bodhi_svgs_add_class_to_thumbnail( $thumb ) {

	$inline_featured_image = get_post_meta( get_the_ID(), 'inline_featured_image' );

	if ( is_array( $inline_featured_image ) && in_array( 1, $inline_featured_image ) ) {

		global $bodhi_svgs_options;

		$target_class = ! empty( $bodhi_svgs_options['css_target'] ) ? $bodhi_svgs_options['css_target'] : 'style-svg';

		if ( is_singular() ) {

			$thumb = str_replace( 'attachment-', $target_class . ' attachment-', $thumb );

		}

	}

	return $thumb;

}
if ( bodhi_svgs_advanced_mode() ) {
	add_filter( 'post_thumbnail_html', 'bodhi_svgs_add_class_to_thumbnail' );
}

/**
 * Safe update of inline featured image meta
 */
function bodhi_svgs_update_featured_image_meta($post_id, $value) {
    // Delete any existing meta first
    delete_post_meta($post_id, 'inline_featured_image');
    
    // Add the new value
    add_post_meta($post_id, 'inline_featured_image', $value, true);
}

/**
 * Handle the AJAX request for updating featured image inline status
 */
function bodhi_svgs_featured_image_inline_toggle() {
    // Verify nonce and permissions
    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'svg-support-featured')) {
        wp_send_json_error('Invalid nonce');
    }

    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Insufficient permissions');
    }

    // Validate and sanitize input
    if (!isset($_POST['post_id']) || !isset($_POST['checked'])) {
        wp_send_json_error('Missing parameters');
    }

    $post_id = intval($_POST['post_id']);
    $checked = ($_POST['checked'] === 'true');

    // Update the meta safely
    bodhi_svgs_update_featured_image_meta($post_id, $checked);

    wp_send_json_success();
}

// Hook the AJAX actions for both logged-in and non-logged-in users
add_action('wp_ajax_bodhi_svgs_featured_image_inline_toggle', 'bodhi_svgs_featured_image_inline_toggle');
add_action('wp_ajax_nopriv_bodhi_svgs_featured_image_inline_toggle', 'bodhi_svgs_featured_image_inline_toggle');