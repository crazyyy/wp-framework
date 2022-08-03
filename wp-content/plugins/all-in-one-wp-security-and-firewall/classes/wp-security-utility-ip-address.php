<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_Utility_IP {
	public function __construct() {
		//NOP
	}

	/**
	 * Get user IP Address.
	 *
	 * @return string User IP Address.
	 */
	public static function get_user_ip_address() {
		$user_ip = '';
		if (isset($_SERVER['HTTP_X_REAL_IP'])) {
			$user_ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_X_REAL_IP']));
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// Proxy servers can send through this header like this: X-Forwarded-For: client1, proxy1, proxy2
			// Make sure we always only send through the first IP in the list which should always be the client IP.
			$user_ip = (string) rest_is_ip_address(trim(current(preg_split('/,/', sanitize_text_field(wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR']))))));
		} elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$user_ip = sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']));
		}

		if (in_array($user_ip, array('', '127.0.0.1', '::1'))) {
			$user_ip = self::get_external_ip_address();
		}

		return $user_ip;
	}

	/**
	 * Get user IP Address using an external service.
	 * This can be used as a fallback for users on localhost where
	 * get_ip_address() will be a local IP and non-geolocatable.
	 *
	 * @return string external ip address.
	 */
	public static function get_external_ip_address() {
		$external_ip_address = '0.0.0.0';
		$ip_lookup_services = array(
			'ipify'             => 'http://api.ipify.org/',
			'ipecho'            => 'http://ipecho.net/plain',
			'ident'             => 'http://ident.me',
			'whatismyipaddress' => 'http://bot.whatismyipaddress.com',
		);
		$ip_lookup_services_keys = array_keys($ip_lookup_services);
		shuffle($ip_lookup_services_keys);

		foreach ($ip_lookup_services_keys as $service_name) {
			$service_endpoint = $ip_lookup_services[$service_name];
			$response         = wp_safe_remote_get($service_endpoint, array( 'timeout' => 2 ));

			if (!is_wp_error($response) && rest_is_ip_address($response['body'])) {
				$external_ip_address = sanitize_text_field($response['body']);
				break;
			}
		}

		return $external_ip_address;
	}
	
	/**
	 * Returns the first three octets of a sanitized IP address so it can used as an IP address range
	 *
	 * @param int $ip
	 * @return int
	 */
	public static function get_sanitized_ip_range($ip) {
		global $aio_wp_security;
		$ip_range = '';
		$valid_ip = filter_var($ip, FILTER_VALIDATE_IP); //Sanitize the IP address
		if ($valid_ip) {
			$ip_type = WP_Http::is_ip_address($ip); //returns 4 or 6 if ipv4 or ipv6 or false if invalid
			if (6 == $ip_type || false === $ip_type) return ''; // for now return empty if ipv6 or invalid IP
			$ip_range = substr($valid_ip, 0, strrpos($valid_ip, ".")); //strip last portion of address to leave an IP range
		} else {
			//Write log if the 'REMOTE_ADDR' contains something which is not an IP
			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility_IP - Invalid IP received ".$ip, 4);
		}
		return $ip_range;
	}

	
	public static function create_ip_list_array_from_string_with_newline($ip_addresses) {
		$ip_list_array = preg_split("/\R/", $ip_addresses);
		return $ip_list_array;
	}
	
	public static function validate_ip_list($ip_list_array, $list_type = '') {
		$errors = '';

		//validate list
		$submitted_ips = $ip_list_array;
		$list = array();

		if (!empty($submitted_ips)) {
			foreach ($submitted_ips as $item) {
				$item = sanitize_text_field($item);
				if (strlen($item) > 0) {
					//ipv6 - for now we will support only whole ipv6 addresses, NOT ranges
					if (strpos($item, ':') !== false) {
						//possible ipv6 addr
						$res = WP_Http::is_ip_address($item);
						if (false === $res) {
							$errors .= "\n".$item.__(' is not a valid ip address format.', 'all-in-one-wp-security-and-firewall');
						} elseif ('6' == $res) {
							$list[] = trim($item);
						}
						continue;
					}

					$ipParts = explode('.', $item);
					$isIP = 0;
					$partcount = 1;
					$goodip = true;
					$foundwild = false;
					
					if (count($ipParts) < 2) {
						$errors .= "\n".$item.__(' is not a valid ip address format.', 'all-in-one-wp-security-and-firewall');
						continue;
					}

					foreach ($ipParts as $part) {
						if (true == $goodip) {
							if ((is_numeric(trim($part)) && trim($part) <= 255 && trim($part) >= 0) || trim($part) == '*') {
								$isIP++;
							}

							switch ($partcount) {
								case 1:
									if (trim($part) == '*') {
										$goodip = false;
										$errors .= "\n".$item.__(' is not a valid ip address format.', 'all-in-one-wp-security-and-firewall');
									}
									break;
								case 2:
									if (trim($part) == '*') {
										$foundwild = true;
									}
									break;
								default:
									if (trim($part) != '*') {
										if (true == $foundwild) {
											$goodip = false;
											$errors .= "\n".$item.__(' is not a valid ip address format.', 'all-in-one-wp-security-and-firewall');
										}
									} else {
										$foundwild = true;
									}
									break;
							}

							$partcount++;
						}
					}
					if (ip2long(trim(str_replace('*', '0', $item))) == false) { //invalid ip
						$errors .= "\n".$item.__(' is not a valid ip address format.', 'all-in-one-wp-security-and-firewall');
					} elseif (strlen($item) > 4 && !in_array($item, $list)) {
						$current_user_ip = AIOWPSecurity_Utility_IP::get_user_ip_address();
						if ($item == $current_user_ip && 'blacklist' == $list_type) {
							//You can't ban your own IP
							$errors .= "\n".__('You cannot ban your own IP address: ', 'all-in-one-wp-security-and-firewall').$item;
						} else {
							$list[] = trim($item);
						}
					}
				}
			}
		} else {
			//This function was called with an empty IP address array list
		}

		if (strlen($errors)> 0) {
			$return_payload = array(-1, array($errors));
			return $return_payload;
		}
		
		if (sizeof($list) >= 1) {
			sort($list);
			$list = array_unique($list, SORT_STRING);
			
			$return_payload = array(1, $list);
			return $return_payload;
		}

		$return_payload = array(1, array());
		return $return_payload;
	}
	
	
	/**
	 * Checks if IP address matches against the specified whitelist of IP addresses or IP ranges
	 *
	 * @param type $ip_address
	 * @param type $whitelisted_ips (newline separated string of IPs)
	 * @return boolean
	 */
	public static function is_ip_whitelisted($ip_address, $whitelisted_ips) {
		if (empty($ip_address) || empty($whitelisted_ips)) return false;
		
		$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($whitelisted_ips);
		
		if (empty($ip_list_array)) return false;
		
		$visitor_ipParts = explode('.', $ip_address);
		foreach ($ip_list_array as $white_ip) {
			$ipParts = explode('.', $white_ip);
			$found = array_search('*', $ipParts);
			if (false !== $found) {
				//Means we have a whitelisted IP range so do some checks
				if (1 == $found) {
					//means last 3 octets are wildcards - check if visitor IP falls inside this range
					if ($visitor_ipParts[0] == $ipParts[0]) {
						return true;
					}
				} elseif (2 == $found) {
					//means last 2 octets are wildcards - check if visitor IP falls inside this range
					if ($visitor_ipParts[0] == $ipParts[0] && $visitor_ipParts[1] == $ipParts[1]) {
						return true;
					}
				} elseif (3 == $found) {
					//means last octet is wildcard - check if visitor IP falls inside this range
					if ($visitor_ipParts[0] == $ipParts[0] && $visitor_ipParts[1] == $ipParts[1] && $visitor_ipParts[2] == $ipParts[2]) {
						return true;
					}
				}
			} elseif ($white_ip == $ip_address) {
				return true;
			}
		}
		return false;
	}

}
