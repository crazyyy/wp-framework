<?php
/**
 * This class handles all bot related tasks and protection mechanisms.
 */
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_Fake_Bot_Protection {
	public function __construct() {
		//NOP
	}

	public static function block_fake_googlebots() {
		global $aio_wp_security;

		$user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
		if (preg_match('/Googlebot/i', $user_agent, $matches)) {
			// If user agent says it is googlebot start doing checks
			$ip = AIOWPSecurity_Utility_IP::get_user_ip_address();
			if (empty($ip)) {
				$aio_wp_security->debug_logger->log_debug('block_fake_googlebots(): Empty IP address detected! User Agent = ' . $user_agent, 2);
				return;
			}

			try {
				$name = gethostbyaddr($ip); // let's get the internet hostname using the given IP address
				if ($name == $ip || false === $name) return;
				$host_ip = gethostbyname($name); // Reverse lookup - let's get the IP using the name
			} catch (Exception $e) {
				$log_message = 'block_fake_googlebots(): PHP Fatal Exception error ('.get_class($e).') has occurred during processing gethostbyaddr()/gethostbyname() function. Error Message: '.$e->getMessage().' (Code: '.$e->getCode().', line '.$e->getLine().' in '.$e->getFile().')';
				$aio_wp_security->debug_logger->log_debug($log_message, 4); // $level_code = 4 for failure
				return;
			} catch (Error $e) {
				$log_message = 'block_fake_googlebots(): PHP Fatal error ('.get_class($e).') has occurred during processing gethostbyaddr()/gethostbyname() function. Error Message: '.$e->getMessage().' (Code: '.$e->getCode().', line '.$e->getLine().' in '.$e->getFile().')';
				$aio_wp_security->debug_logger->log_debug($log_message, 4); // $level_code = 4 for failure
				return;
			}
			if (preg_match('/Google/i', $name, $matches)) {
				if ($host_ip == $ip) {
					// Genuine googlebot allow it through....
				} else {
					// fake googlebot - block it!
					$aio_wp_security->debug_logger->log_debug('Fake googlebot detected: IP = '.$ip.' hostname = '.$name.' reverse IP = '. $host_ip, 2);
					exit();
				}
			} else {
				// fake googlebot - block it!
				$aio_wp_security->debug_logger->log_debug('Fake googlebot detected: IP = '.$ip.' hostname = '.$name.' reverse IP = '.$host_ip, 2);
				exit();
			}
		}
	}
}
