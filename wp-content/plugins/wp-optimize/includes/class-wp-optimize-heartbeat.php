<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WP_Optimize_Heartbeat')) :

class WP_Optimize_Heartbeat {

	/**
	 * Class constructor
	 *
	 * @return void
	 */
	private function __construct() {
		global $pagenow;

		$pages_enabled = array('WP-Optimize', 'wpo_images', 'wpo_cache', 'wpo_minify', 'wpo_settings', 'wpo_support', 'wpo_mayalso', 'upload.php');
		
		// Change heartbeat API frequency to 15 seconds to improve UI experience
		// only for the pages that we enable in `$pages_enabled`
		if (isset($_GET['page'])) {
			$query_page = sanitize_text_field(wp_unslash($_GET['page'])); // phpcs:ignore WordPress.Security.NonceVerification -- not processing form data
		} else {
			$query_page = $pagenow;
		}
		
		if (in_array($query_page, $pages_enabled)) {
			add_filter('heartbeat_settings', array($this, 'set_heartbeat_time_interval'), PHP_INT_MAX);
		}

		// Handle heartbeat events
		add_filter('heartbeat_received', array($this, 'receive_heartbeat'), 10, 2);
	}

	/**
	 * Get WP_Optimize_Heartbeat instance.
	 *
	 * @return WP_Optimize_Heartbeat
	 */
	public static function get_instance() {
		$_instance = null;
		if (null === $_instance) {
			$_instance = new self();
		}

		return $_instance;
	}

	/**
	 * Set custom heartbeat API interval
	 *
	 * @param array $settings Current WP settings
	 * @return array
	 */
	public function set_heartbeat_time_interval($settings) {
		$settings['interval'] = 15;
		return $settings;
	}

	/**
	 * Receive Heartbeat data and respond.
	 *
	 * Processes data received via a Heartbeat request, and returns additional data to pass back to the front end.
	 *
	 * @param array $response Heartbeat response data to pass back to front end.
	 * @param array $data     Data received from the front end (unslashed).
	 *
	 * @return array
	 */
	public function receive_heartbeat($response, $data) {
		$commands = new Updraft_Smush_Manager_Commands(Updraft_Smush_Manager::instance());
		$commands->heartbeat_command = true;

		foreach ($data as $uid => $command) {
			if (!$this->is_wpo_heartbeat($uid)) {
				continue;
			}

			if (is_string($command)) {
				if (apply_filters('wp_optimize_is_heartbeat_valid_ajax_command', $command)) {
					$response['callbacks'][$uid] = apply_filters('wp_optimize_heartbeat_ajax', $command);
				}
			} else {
				$command_name = key($command);
				if ('updraft_smush_ajax' == $command_name) {
					$command_data = current($command);
					
					$command_data_param = null;
					if (isset($command_data['data'])) {
						$command_data_param = $command_data['data'];
					}

					$_REQUEST['subaction'] = $command_data['subaction'];
					$_REQUEST['data'] = $command_data_param;
				
					ob_start();
					
					if (!is_callable(array($commands, $command_data['subaction']))) {
						continue;
					}

					$method = new ReflectionMethod($commands, $command_data['subaction']);
					
					$command_response = $method->invokeArgs($commands, array($command_data_param));

					if (is_array($command_response)) {
						$response['callbacks'][$uid] = $command_response;
						ob_end_clean();
					} else {
						$response['callbacks'][$uid] = ob_get_clean();
					}

					if (is_wp_error($command_response)) {
						$response['callbacks'][$uid] = array(
							'status' => true,
							'result' => false,
							'error_code' => $command_response->get_error_code(),
							'error_message' => $command_response->get_error_message(),
							'error_data' => $command_response->get_error_data(),
						);
					}
				}
			}
		}

		if (true === $commands->background_command) {
			$response['server_time'] = time();
			$response['wp-auth-check'] = true;
			$commands->final_response = $response;
			die();
		} else {
			return $response;
		}
	}

	/**
	 * Check if the received heartbeat action was triggered by WPO's heartbeat.js layer
	 *
	 * @param string $uid The task unique id
	 * @return bool
	 */
	private function is_wpo_heartbeat($uid) {
		return 0 === strpos($uid, 'wpo-heartbeat-');
	}
}

endif;
