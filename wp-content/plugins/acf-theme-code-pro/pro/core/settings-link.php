<?php
/**
 * Add link to Settings page in plugin description, on core Plugins page
 */ 

function acftcp_action_links( $links ) {

    $settings_link = array(
        '<a href="' . admin_url('options-general.php?page=theme-code-pro-license') . '">' . __( 'Settings', 'acf-theme-code' ) . '</a>',
    );

    return array_merge( $links, $settings_link );

}
add_filter( 'plugin_action_links_' . ACFTC_PLUGIN_BASENAME, 'acftcp_action_links' );
