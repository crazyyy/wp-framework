<?php


add_filter( 'plugin_action_links_profiler-what-slowing-down/profiler-what-slowing-down.php', 'wpsd_settings_link' );
function wpsd_settings_link( $links ) {
	// Build and escape the URL.
	$url = esc_url( get_admin_url().'tools.php?page=profiler_what_slowing_down' );
	// Create the link.
	$settings_link = "<a style=\"color:green;font-weight:bold;\" href='$url'>" . __( 'Open plugin page' ) . '</a>';
	// Adds the link to the end of the array.
    $links[] = $settings_link;
	return $links;
}


