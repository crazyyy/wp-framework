<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

/**
 * Handles Comment related hooks.
 */
class AIOWPSecurity_Comment {

	/**
	 * Class constructor. Add action hooks.
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter('pre_comment_user_ip', array($this, 'pre_comment_user_ip'));
	}

	/**
	 * Set comment user IP for local server setup.
	 *
	 * @param string $comment_user_ip comment user IP.
	 * @return string Comment user IP.
	 */
	public function pre_comment_user_ip($comment_user_ip) {
		if (in_array($comment_user_ip, array('', '127.0.0.1', '::1'))) {
			$comment_user_ip = AIOWPSecurity_Utility_IP::get_external_ip_address();
		}
		return $comment_user_ip;
	}
}
