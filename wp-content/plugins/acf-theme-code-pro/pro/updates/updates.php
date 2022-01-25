<?php

/************************************
* the code below is just a standard
* options page. Substitute with
* your own.
*************************************/

function hookturn_acftcp_license_menu() {

	// add settings page for Theme Code Pro
	add_options_page('Theme Code Pro License', 'Theme Code Pro', 'manage_options', 'theme-code-pro-license', 'hookturn_acftcp_license_page' );

}
add_action('admin_menu', 'hookturn_acftcp_license_menu');

function hookturn_acftcp_license_page() {
	$license 	= get_option( 'hookturn_acftcp_license_key' );
	$status 	= get_option( 'hookturn_acftcp_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('ACF Theme Code Pro'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('hookturn_acftcp_license'); ?>

			<table class="form-table">
				<tbody>
					<?php if( $status != 'valid' ) { ?>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="hookturn_acftcp_license_key" name="hookturn_acftcp_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="hookturn_acftcp_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php } ?>
					
					<?php if( $license != '') { ?>
						<tr valign="top">

								<?php if( $status !== false && $status == 'valid' ) { ?>
									<th scope="row" valign="top">
										<?php _e('License Status'); ?>
									</th>
									<td>
									<span style="color:green; line-height:30px; padding-right:10px"><?php _e('Active'); ?></span>
									<?php wp_nonce_field( 'hookturn_acftcp_nonce', 'hookturn_acftcp_nonce' ); ?>
										<input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
									</td>
								<?php } else {
									wp_nonce_field( 'hookturn_acftcp_nonce', 'hookturn_acftcp_nonce' ); ?>
									<th scope="row" valign="top">
										<?php _e('Activate License'); ?>
									</th>
									<td>
										<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License'); ?>"/>
									</td>
								<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
	<?php
}

function hookturn_acftcp_register_option() {
	// creates our settings in the options table
	register_setting('hookturn_acftcp_license', 'hookturn_acftcp_license_key', 'hookturn_sanitize_license' );
}
add_action('admin_init', 'hookturn_acftcp_register_option');

function hookturn_sanitize_license( $new ) {
	$old = get_option( 'hookturn_acftcp_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'hookturn_acftcp_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}



/************************************
* this illustrates how to activate
* a license key
*************************************/

function hookturn_acftcp_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate'] ) ) {

		// run a quick security check
		 if( ! check_admin_referer( 'hookturn_acftcp_nonce', 'hookturn_acftcp_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'hookturn_acftcp_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( HOOKTURN_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( HOOKTURN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "valid" or "invalid"

		update_option( 'hookturn_acftcp_license_status', $license_data->license );

	}
}
add_action('admin_init', 'hookturn_acftcp_activate_license');


/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function hookturn_acftcp_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {

		// run a quick security check
		 if( ! check_admin_referer( 'hookturn_acftcp_nonce', 'hookturn_acftcp_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'hookturn_acftcp_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( HOOKTURN_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( HOOKTURN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'hookturn_acftcp_license_status' );

	}
}
add_action('admin_init', 'hookturn_acftcp_deactivate_license');


/************************************
* this illustrates how to check if
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

function hookturn_acftcp_check_license() {

	global $wp_version;

	$license = trim( get_option( 'hookturn_acftcp_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( HOOKTURN_ITEM_NAME ),
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_post( HOOKTURN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}
