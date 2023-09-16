<?php

class Error_Notify_Slack_Admin {

	// Define available error levels for reporting

	private $error_levels = array(
		E_ERROR,
		E_WARNING,
		E_PARSE,
		E_NOTICE,
		E_CORE_ERROR,
		E_CORE_WARNING,
		E_COMPILE_ERROR,
		E_COMPILE_WARNING,
		E_USER_ERROR,
		E_USER_WARNING,
		E_USER_NOTICE,
		E_STRICT,
		E_RECOVERABLE_ERROR,
		E_DEPRECATED,
		E_USER_DEPRECATED
	);

	/**
	 * Get things started
	 *
	 * @since 1.0
	 * @return void
	*/

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu') );
		add_action('wp_ajax_test_error', array( $this, 'test_error' ) );
	}

	/**
	 * Register admin settings menu
	 *
	 * @since 1.0
	 * @return void
	*/

	public function admin_menu() {

		$id = add_options_page(
			'Settings',
			'Error Notify Slack',
			'manage_options',
			'error_notify_slack',
			array( $this, 'settings_page' )
		);

		add_action( 'load-' . $id, array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Register CSS files
	 *
	 * @since 1.0
	 * @return void
	*/

	public function enqueue_scripts(){

    	wp_enqueue_style( 'error-notify-slack', ERROR_NOTIFY_SLACK_DIR_URL . 'assets/admin.css' );
    	wp_enqueue_script( 'test_error', ERROR_NOTIFY_SLACK_DIR_URL . "assets/admin.js", array('jquery'), time());
		wp_localize_script( 'test_error', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

	}

	/**
	 * Creates test error button
	 *
	 * @access public
	 * @return void
	*/

	public function test_error() {

		function_that_does_not_exist();

	}

	/**
	 * Renders Settings page
	 *
	 * @access public
	 * @return mixed
	 */

	public function settings_page() {
		// Save settings
		if ( isset( $_POST['ens_settings_nonce'] ) && wp_verify_nonce( $_POST['ens_settings_nonce'], 'ens_settings' ) ) {

			$ens_settings = array(
				'slack_oauth_access_token' => sanitize_text_field($_POST['ens_settings']['slack_oauth_access_token']),
				'slack_channel' => sanitize_text_field($_POST['ens_settings']['slack_channel']),
				'levels' => array_map( 'sanitize_text_field', wp_unslash( $_POST['ens_settings']['levels'] ) )
			);

			update_option( 'zt_ens_settings', $ens_settings );

			echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
		}

		$settings = get_option( 'zt_ens_settings', array() );

		if( empty( $settings ) ) {

			$settings = array(
				'levels'				=> array(),
				'slack_oauth_access_token' => '',
				'slack_channel' => ''
			);

			foreach( $this->error_levels as $level_id ) {

				// Enable plugin by default
				if( $level_id == 1 ) {
					$settings['levels'][$level_id] = true;
				} else {
					$settings['levels'][$level_id] = false;
				}
		
			}

		}
		?>

		<div class="wrap">


			<h2>Error Notification Settings</h2>

			<form id="fen-settings" action="" method="post">
				<?php wp_nonce_field( 'ens_settings', 'ens_settings_nonce' ); ?>
				<input type="hidden" name="action" value="update">

				<table class="form-table">
					<tr valign="top">
						<th scope="row">Slack OAuth Access Token</th>
						<td valign="top">
							<input class="regular-text" type="text" name="ens_settings[slack_oauth_access_token]" value="<?php echo esc_attr( $settings['slack_oauth_access_token'] ); ?>" />
							<p class="description">Enter Slack app OAuth Access Token.</p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">Slack Channel</th>
						<td valign="top">
							<input class="regular-text" type="text" name="ens_settings[slack_channel]" value="<?php echo esc_attr( $settings['slack_channel'] ); ?>" />
							<p class="description">Enter slack channel to where errors should be sent.</p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">Test Crash Notification</th>
						<td>
						<a id="test-button" class="button-primary" href="#">Send Test</a>
						<p class="description">Send a test error to the above Slack channel.</p>
					</tr>

					<tr valign="top">
						<th scope="row">Error Levels To Notify</th>
						<td>
							<fieldset>
								<?php foreach( $this->error_levels as $i => $level_id ) : ?>

									<?php if( ! isset( $settings['levels'][$level_id] ) ) $settings['levels'][$level_id] = false; ?>

									<?php $level_string = error_notify_slack()->map_error_code_to_type( $level_id ); ?>
									<label for="level_<?php echo $level_string ?>">
										<input type="checkbox" name="ens_settings[levels][<?php echo $level_id; ?>]" id="level_<?php echo $level_string ?>" value="1" <?php checked( $settings['levels'][$level_id] ); ?> />
										<?php echo $level_string; ?>
									</label>
									<br />

								<?php endforeach; ?>
							</fieldset>

						</td>

				</table>

	            <p class="submit">
	            	<input name="Submit" type="submit" class="button-primary" value="Save Changes"/>
	            </p>

			</form>

        </div>

		<?php 
	}


}

new Error_Notify_Slack_Admin;