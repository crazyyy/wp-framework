<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Sender_Service {

	/**
	 * Send email with the provided data
	 *
	 * @param string $recipient Email recipient
	 * @param string $subject   Email subject
	 * @param string $message   Email message
	 *
	 * @return bool True on success, false on failure
	 */
	public static function send_email($recipient, $subject, $message) {
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
		);

		$result = wp_mail($recipient, $subject, $message, $headers);

		// Trigger an action after sending the email
		do_action('aiowp_security_after_send_email', $recipient, $subject, $message, $headers, $result);

		return $result;
	}
}
