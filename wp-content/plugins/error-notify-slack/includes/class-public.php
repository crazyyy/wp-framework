<?php

class Error_Notify_Slack_Public {

	/**
	 * Get things started
	 *
	 * @return void
	*/

	public function __construct() {

		register_shutdown_function( array( $this, 'shutdown' ) );

	}

	/**
	 * Send notifications with HTML formatting
	 *
	 * @return string
	*/

	public function wp_mail_content_type() {
		return "text/html";
	}

	/**
	 * Catch errors and act on them
	 *
	 * @return void
	*/

	private function slack_chat_postMessage($payload) {
		$content = json_encode($payload['content']);
		$slack_oauth_access_token = $payload['slack_oauth_access_token'];
		$url = 'https://slack.com/api/chat.postMessage';

		$args = array(
		    'body' => $content,
		    'timeout' => '10',
		    'redirection' => '5',
		    'httpversion' => '1.0',
		    'blocking' => true,
		    'headers' => array(
				'Authorization' => 'Bearer ' . $slack_oauth_access_token,
				'Content-Type' => 'application/json; charset=utf-8'
			),
		    'cookies' => array()
		);

		$response = wp_remote_post( $url, $args );

		return;
	}

	private function sendSlackMessage($channel = '', $output = '', $slack_oauth_access_token = ''){
		if( $channel !== '' ){
			$payload = [
				"content" => [
			        "channel" => $channel,
			        "text" => $output
			    ],
		        "slack_oauth_access_token" => $slack_oauth_access_token
		    ];

			$this->slack_chat_postMessage($payload);
		}
	}

	public function shutdown() {

		$error = error_get_last();

		if( is_null( $error ) ) {
			return;
		}

		// Allow bypassing
		$ignore = apply_filters( 'ens_ignore_error', false, $error );

		if( $ignore ) {
			return;
		}

		$settings = get_option( 'zt_ens_settings', array() );

		if( empty( $settings ) || empty( $settings['slack_oauth_access_token'] ) || empty( $settings['levels'] ) ) {
			return;
		}

		$output = '';

		foreach( $settings['levels'] as $level_id => $enabled ) {

			if ( $error['type'] == $level_id ) {
				$output .= "*Error Level:* " . error_notify_slack()->map_error_code_to_type( $error["type"] ) . "\n";
				$output .= "*Message:* ```" . nl2br( $error["message"] ) . "```\n";
				$output .= "*File:* `" . $error["file"] . "`\n";
				$output .= "*Line:* `" . $error["line"] . "`\n";
				$output .= "*Request:* `" . $_SERVER["REQUEST_URI"] . "`\n";
				$output .= "*Referrer:* " . $_SERVER["HTTP_REFERER"] . "\n";

				$user_id = get_current_user_id();

				if( ! empty( $user_id ) ) {
					$output .= "*User ID*: `" . $user_id . "`\n";
				}

				$output .= "\n";
			}

		}

		if( !empty( $output ) ) {

			$hash = md5( $error['message'] );
			$transient = get_transient( 'ens_' . $hash );

			if( strpos( $error['message'], 'function_that_does_not_exist' ) !== false ) {
				$bypass = true;
			} else {
				$bypass = false;
			}

			if( ! empty( $transient ) && $bypass == false ){
				return;
			} else {
				set_transient( 'ens_' . $hash, true, HOUR_IN_SECONDS );
			}

			$output = ":warning: *Error notification* for <" . get_home_url() . ">\n" . $output;

			$this->sendSlackMessage($settings['slack_channel'], $output, $settings['slack_oauth_access_token']);
		}

	}


}

new Error_Notify_Slack_Public;