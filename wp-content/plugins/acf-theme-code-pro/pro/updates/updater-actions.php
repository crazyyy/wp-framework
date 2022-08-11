<?php
/**
 * Plugin updates
 */

function hookturn_acftcp_plugin_updater() {

	// Get license key from the DB
	$license_key = trim( get_option( 'hookturn_acftcp_license_key' ) );

	$edd_updater = new Hookturn_ACFTCP_Plugin_Updater( HOOKTURN_STORE_URL, ACFTC_PLUGIN_FILE,
		array(
			'version' => ACFTC_PLUGIN_VERSION,
			'license' => $license_key,
			'item_id' => HOOKTURN_ITEM_ID,
			'author'  => 'hookturn',
			'beta'    => false,
		)
	);

}
add_action( 'admin_init', 'hookturn_acftcp_plugin_updater', 0 );



/*
*  Displays an update message for plugin list screens.
*
*  @param	$plugin_data (array)
*  @param	$response (object)
*  @return	$message
*/
function hookturn_modify_plugin_update_message( $plugin_data, $response ) {
	
	if ( empty( $response->package ) ) {
		echo '<br /><br />';
		echo sprintf( 
			/* translators: 1: plugin settings page URL 2: Hookturn plugin URL */
			__('To enable updates, please save and activate your license key on the <a href="%1$s">Theme Code Pro Settings</a> page. If you don\'t have a licence key, please visit <a href="%2$s" target="_blank">Hookturn</a> for details and pricing.', 'acf-theme-code' ),
			admin_url('options-general.php?page=theme-code-pro-license'),
			'https://hookturn.io/downloads/acf-theme-code-pro/'
		);
	}
	
}
add_action('in_plugin_update_message-' . ACFTC_PLUGIN_BASENAME, 'hookturn_modify_plugin_update_message', 10, 2 );



/*
 * Expand the "Download failed. Unauthorized" error message that occurs when a plugin update fails due to 
 * inadequate license key eg. and expired license.
 */
function hookturn_acftcp_upgrader_process_complete( $plugin_upgrader_object, $hook_extra ) {
	
	if ( $hook_extra['action'] == 'update' && $hook_extra['type'] == 'plugin' && $plugin_upgrader_object->result == null ) {

		foreach ( $hook_extra['plugins'] as $plugin ) {
		
			if ( $plugin == ACFTC_PLUGIN_BASENAME ) {
				
				$custom_error = sprintf( 
					/* translators: 1: plugin settings page URL */
					__('please check the status of your license key on the <a href="%s">Theme Code Pro Settings</a> page.', 'acf-theme-code' ),
					admin_url('options-general.php?page=theme-code-pro-license')
				);

				$plugin_upgrader_object->skin->error( $custom_error ) ;
				
			}
		
		}

	}

}
add_action( 'upgrader_process_complete', 'hookturn_acftcp_upgrader_process_complete',10, 2);
