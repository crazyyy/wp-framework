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
			// If the user agent says it's a Googlebot, start doing checks.

			$ip = AIOWPSecurity_Utility_IP::get_user_ip_address();

			if (empty($ip)) {
				$aio_wp_security->debug_logger->log_debug('block_fake_googlebots(): Empty IP address detected. User Agent = ' . $user_agent, 4);
				return;
			}

			try {
				$name = gethostbyaddr($ip); // Let's get the hostname using the IP address.

				if ($name == $ip || false === $name) {
					$aio_wp_security->debug_logger->log_debug('block_fake_googlebots(): gethostbyaddr failed.', 4);
					return;
				}

				$host_ip = gethostbyname($name); // Reverse lookup - let's get the IP address using the hostname.
			} catch (Exception $e) {
				$aio_wp_security->debug_logger->log_debug('block_fake_googlebots(): PHP Fatal Exception error (' . get_class($e) . ') has occurred during processing gethostbyaddr()/gethostbyname() function. Error Message: ' . $e->getMessage() . ' (Code: ' . $e->getCode() . ', line ' . $e->getLine() . ' in ' . $e->getFile() . ')', 4);
				return;
			} catch (Error $e) {
				$aio_wp_security->debug_logger->log_debug('block_fake_googlebots(): PHP Fatal error (' . get_class($e) . ') has occurred during processing gethostbyaddr()/gethostbyname() function. Error Message: ' . $e->getMessage() . ' (Code: ' . $e->getCode() . ', line ' . $e->getLine() . ' in ' . $e->getFile() . ')', 4);
				return;
			}

			if (preg_match('/^(?:.+\.)?googlebot\.com$/i', $name) || preg_match('/^(?:.+\.)?google\.com$/i', $name) || preg_match('/^(?:.+\.)?googleusercontent\.com$/i', $name)) {
				if ($host_ip == $ip) {
					// Genuine Googlebot
					return;
				} else {
					// Fake Googlebot
					$aio_wp_security->debug_logger->log_debug('Fake Googlebot detected: IP = ' . $ip . ' hostname = ' . $name . ' reverse IP = ' . $host_ip, 2);
					exit();
				}
			} else {
				// Fake Googlebot
				$aio_wp_security->debug_logger->log_debug('Fake Googlebot detected: IP = ' . $ip . ' hostname = ' . $name . ' reverse IP = ' . $host_ip, 2);
				exit();
			}
		}
	}
}
