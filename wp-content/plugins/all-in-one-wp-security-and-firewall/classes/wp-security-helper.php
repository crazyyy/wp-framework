<?php
if (!defined('ABSPATH') && !defined('AIOWPS_FIREWALL_DIR')) {
	exit; //Exit if accessed directly
}

require_once(__DIR__.'/wp-security-abstract-ids.php');

/**
 * Helper class for firewall as shared library
 * Use core php not wordpress.
 */
class AIOS_Helper {
	
	/**
	 * Get server detected visitor IP Address.
	 *
	 * @return String visitor IP Address.
	 */
	public static function get_server_detected_user_ip_address() {
		global $aiowps_firewall_config;

		// check if user configured custom IP retrieval method
		$ip_method_id = empty($aiowps_firewall_config) ? '' : $aiowps_firewall_config->get_value('aios_ip_retrieve_method');

		$visitor_ip = '';
		$ip_retrieve_methods = AIOS_Abstracted_Ids::get_ip_retrieve_methods();

		if (empty($ip_method_id) || !isset($ip_retrieve_methods[$ip_method_id])) {
			$ip_method_id = 0;
		}

		$visitor_ip = isset($_SERVER[$ip_retrieve_methods[$ip_method_id]]) ? $_SERVER[$ip_retrieve_methods[$ip_method_id]] : '';

		// Check if multiple IPs were given - these will be present as comma-separated list
		if (preg_match('/^([^,]+),/', $visitor_ip, $matches)) $visitor_ip = $matches[1];

		// Now remove port portion if ipv4 address with port
		if (preg_match('/(.+):\d+$/', $visitor_ip, $matches)) $visitor_ip = $matches[1];

		if (!filter_var($visitor_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && !filter_var($visitor_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$visitor_ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];
		}

		return $visitor_ip;
	}
	
	/**
	 * Get user IP Address.
	 *
	 * @return string User IP Address.
	 */
	public static function get_user_ip_address() {
		static $visitor_ip;
		if (isset($visitor_ip)) {
			//already set in the page request
			return $visitor_ip;
		}
		
		$visitor_ip = self::get_server_detected_user_ip_address();

		if (in_array($visitor_ip, array('', '127.0.0.1', '::1'))) {
			$external_ip_address = self::get_external_ip_address();
			if (false != $external_ip_address) {
				$visitor_ip = $external_ip_address;
			}
		}

		return $visitor_ip;
	}
	
	/**
	 * Check user IP Address is with in list.
	 *
	 * @param array $ip_address_list
	 *
	 * @return boolean.
	 */
	public static function is_user_ip_address_within_list($ip_address_list) {
	
		if (!(include_once AIOWPS_FIREWALL_DIR.'/../../vendor/mlocati/ip-lib/ip-lib.php')) {
			throw new \Exception("AIOS_Helper::is_user_ip_address_within_list failed to load ip-lib.php");
		}
		
		$user_ip = self::get_user_ip_address();
		$user_ip_address = \IPLib\Factory::parseAddressString($user_ip);
		if (null != $user_ip_address) {
			$user_ip_address_type = $user_ip_address->getAddressType();
			$user_ipv4_address_parsed = (6 == $user_ip_address_type) ? $user_ip_address->toIPv4() : $user_ip_address;
			// linear search used to compare ips list.
			foreach ($ip_address_list as $ip_address) {
				if (preg_match("/\/|\*/", $ip_address)) {  // checks user ipadress with in range of ip range.
					$range = \IPLib\Factory::parseRangeString($ip_address);
					if (null != $range && $range->contains($user_ip_address)) return true;
				} elseif ($ip_address == $user_ip) {
					return true;
				} elseif (null != $user_ipv4_address_parsed) { // check for ip matches if ipv6 to ipv4 or vice versa
					$ip_address_parsed = \IPLib\Factory::parseAddressString($ip_address);
					if (null != $ip_address_parsed) {
						$ip_address_parsed_type = $ip_address_parsed->getAddressType();
						$ipv4_address_parsed = (6 == $ip_address_parsed_type) ? $ip_address_parsed->toIPv4() : $ip_address_parsed;
						if ((string) $user_ipv4_address_parsed == (string) $ipv4_address_parsed) return true;
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * Get user IP Address using an external service.
	 * This can be used as a fallback for users on localhost where
	 * get_ip_address() will be a local IP and non-geolocatable.
	 *
	 * @return string|boolean external ip address if from one of lookup service gets response otherwise false.
	 */
	public static function get_external_ip_address() {
		$external_ip_address = false;
		$ip_lookup_services = AIOS_Abstracted_Ids::get_ip_lookup_services();
		$ip_lookup_services_keys = array_keys($ip_lookup_services);
		shuffle($ip_lookup_services_keys);

		foreach ($ip_lookup_services_keys as $service_name) {
			$service_endpoint = $ip_lookup_services[$service_name];
			$response = self::request_remote($service_endpoint);
			if (!empty($response) && filter_var($response, FILTER_VALIDATE_IP)) {
				$external_ip_address = $response;
				break;
			}
		}
		return $external_ip_address;
	}
	
	/**
	 * Remote url request.
	 *
	 * @param string $url  url to be requested.
	 * @param array  $args request args array.
	 *
	 * @return string response.
	 */
	public static function request_remote($url, $args = array()) {
		global $aiowps_constants;
		$response = '';
		$root = \AIOWPS\Firewall\Utility::get_root_dir();
		$includes = isset($aiowps_constants->WPINC) ? $aiowps_constants->WPINC : 'wp-includes';
		
		//WP 6.2+ the request library updated to 2.0.5, class and interface files/directory moved and namespaced name used.
		if (!class_exists('WpOrg\Requests\Autoload')) {
			if (file_exists($root . $includes . '/Requests/src/Autoload.php')) {
				require_once($root . $includes . '/Requests/src/Autoload.php');
				WpOrg\Requests\Autoload::register();
				WpOrg\Requests\Requests::set_certificate_path($root . $includes . '/certificates/ca-bundle.crt');
			} elseif (!class_exists('Requests') && file_exists($root . $includes . '/class-requests.php')) {
				require_once($root . $includes . '/class-requests.php');
				Requests::register_autoloader();
				Requests::set_certificate_path($root . $includes . '/certificates/ca-bundle.crt');
			}
		}
		
		try {
			$headers = isset($args['headers']) ? $args['headers'] : array();
			$data = isset($args['body']) ? $args['body'] : array();
			$method = isset($args['method']) ? $args['method'] : 'GET';
			$timeout = isset($aiowps_constants->AIOS_REQUEST_TIMEOUT) ? $aiowps_constants->AIOS_REQUEST_TIMEOUT : 4;
			$options = array('timeout' => $timeout);
			//WP 6.2+ the request library 2.0.5 namespaced name WpOrg\Requests\Requests instead just Requests
			if (class_exists('WpOrg\Requests\Requests')) {
				$request_response = WpOrg\Requests\Requests::request($url, $headers, $data, $method, $options);
			} elseif (class_exists('Requests')) {
				$request_response = Requests::request($url, $headers, $data, $method, $options);
			}
			$response = $request_response->body;
		} catch (\Exception $e) {
			error_log('AIOS_Helper::request_remote exception - ' . $e->getMessage());
		} catch (\Error $e) {
			error_log('AIOS_Helper::request_remote error - ' . $e->getMessage());
		}
		
		if (empty($response) && ini_get('allow_url_fopen')) {
			$response = file_get_contents($url);
		}
		return $response;
	}
}
