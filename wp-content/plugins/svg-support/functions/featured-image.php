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

	// Check if featured image is set and has extension of .svg or .svgz.
	if ( strpos( get_the_post_thumbnail(), '.svg' ) ) {

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
	if ( ! isset( $_POST['bodhi_svgs_featured_image_nonce'] ) || ! wp_verify_nonce( $_POST['bodhi_svgs_featured_image_nonce'], 'bodhi_svgs_save_featured_image_meta' ) ) {
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

	// Check if the new value is different from the existing value
	$existing_value = get_post_meta( $post_id, 'inline_featured_image', true );
	$new_value = isset( $_POST['inline_featured_image'] ) ? 1 : 0;

	if ( $new_value != $existing_value ) {
		// Update the meta value only if it has changed
		update_post_meta( $post_id, 'inline_featured_image', $new_value );
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