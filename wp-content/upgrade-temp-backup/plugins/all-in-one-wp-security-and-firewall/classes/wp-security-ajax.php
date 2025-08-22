<?php

if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('AIOWPSecurity_Ajax')) :

	class AIOWPSecurity_Ajax {

		private $commands_object;

		private $nonce;

		private $subaction;

		private $data;

		private $results;

		/**
		 * Constructor
		 */
		private function __construct() {
			if (!class_exists('AIOWPSecurity_Commands')) include_once(AIO_WP_SECURITY_PATH.'/classes/wp-security-commands.php');
			$this->commands_object = new AIOWPSecurity_Commands();

			add_action('wp_ajax_aios_ajax', array($this, 'handle_ajax_requests'));
			add_action('wp_ajax_nopriv_get_antibot_keys', array($this->commands_object, 'get_antibot_keys'));
		}

		/**
		 * Return singleton instance
		 *
		 * @return AIOWPSecurity_Ajax Returns AIOWPSecurity_Ajax object
		 */
		public static function get_instance() {
			static $instance = null;
			if (null === $instance) {
				$instance = new self();
			}
			return $instance;
		}

		/**
		 * Handles ajax requests
		 *
		 * @return void
		 */
		public function handle_ajax_requests() {
			$this->set_nonce();
			$this->set_subaction();
			$this->set_data();

			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($this->nonce, 'wp-security-ajax-nonce');
			if (is_wp_error($result)) {
				wp_send_json(array(
					'result' => false,
					'error_code' => $result->get_error_code(),
					'error_message' => $result->get_error_message(),
				));
			}

			if (is_multisite() && !current_user_can('manage_network_options')) {
				if (!$this->is_valid_multisite_command()) {
					$this->send_invalid_multisite_command_error_response();
				}
			}

			if ($this->is_invalid_command()) {
				$this->add_invalid_command_error_log_entry();
				$this->set_invalid_command_error_response();
			} else {
				$this->execute_command();
				$this->set_error_response_on_wp_error();
				$this->maybe_set_results_as_null();
			}

			$this->json_encode_results();

			$json_last_error = json_last_error();
			if ($json_last_error) {
				$this->set_error_response_on_json_encode_error($json_last_error);
			}

			echo $this->results;
			die;
		}

		/**
		 * Sets nonce property value
		 *
		 * @return void
		 */
		private function set_nonce() {
			$this->nonce = empty($_POST['nonce']) ? '' : $_POST['nonce'];
		}

		/**
		 * Sets subaction property value
		 *
		 * @return void
		 */
		private function set_subaction() {
			$this->subaction = empty($_POST['subaction']) ? '' : sanitize_text_field(wp_unslash($_POST['subaction']));
		}

		/**
		 * Sets data property value
		 *
		 * @return void
		 */
		private function set_data() {
			$this->data = isset($_POST['data']) ? wp_unslash($_POST['data']) : null;
		}

		/**
		 * Checks whether it is multisite setup and command is valid multisite command
		 *
		 * @return bool
		 */
		private function is_valid_multisite_command() {
			/**
			 * Filters the commands allowed to the sub site admins. Other commands are only available to network admin. Only used in a multisite context.
			 */
			$allowed_commands = apply_filters('aios_multisite_allowed_commands', array(
				'delete_audit_log',
				'delete_locked_ip_record',
				'clear_debug_logs',
				'unlock_ip',
				'blocked_ip_list_unblock_ip',
				'lock_ip',
				'dismiss_notice',
			));

			return in_array($this->subaction, $allowed_commands);
		}

		/**
		 * Sends the invalid multisite command error response
		 *
		 * @return void
		 */
		private function send_invalid_multisite_command_error_response() {
			wp_send_json(array(
				'result' => false,
				'error_code' => 'update_failed',
				'error_message' => __('Options can only be saved by network admin', 'all-in-one-wp-security-and-firewall')
			));
		}

		/**
		 * Checks if applied ajax command is an invalid command or not
		 *
		 * @return bool Returns true if ajax command is an invalid command, false otherwise
		 */
		private function is_invalid_command() {
			return !is_callable(array($this->commands_object, $this->subaction));
		}

		/**
		 * Log an error message for invalid ajax command
		 *
		 * @return void
		 */
		private function add_invalid_command_error_log_entry() {
			error_log("AIOS: ajax_handler: no such command (" . $this->subaction . ")");
		}

		/**
		 * Set `results` property with error response array for invalid ajax command
		 *
		 * @return void
		 */
		private function set_invalid_command_error_response() {
			$this->results = array(
				'result' => false,
				'error_code' => 'command_not_found',
				'error_message' => sprintf(__('The command "%s" was not found', 'all-in-one-wp-security-and-firewall'), $this->subaction)
			);
		}

		/**
		 * Execute the ajax command
		 *
		 * @return void
		 */
		private function execute_command() {
			$this->results = call_user_func(array($this->commands_object, $this->subaction), $this->data);
		}

		/**
		 * Set `results` property with error message
		 *
		 * @return void
		 */
		private function set_error_response_on_wp_error() {
			if (is_wp_error($this->results)) {
				$this->results = array(
					'result' => false,
					'error_code' => $this->results->get_error_code(),
					'error_message' => $this->results->get_error_message(),
					'error_data' => $this->results->get_error_data(),
				);
			}
		}

		/**
		 * Set `results` property to null, if it is not yet set
		 *
		 * @return void
		 */
		private function maybe_set_results_as_null() {
			// if nothing was returned for some reason, set as result null.
			if (empty($this->results)) {
				$this->results = array(
					'result' => null
				);
			}
		}

		/**
		 * Sets `results` property with json encode error
		 *
		 * @param int $json_last_error
		 *
		 * @return void
		 */
		private function set_error_response_on_json_encode_error($json_last_error) {
			$this->results = array(
				'result' => false,
				'error_code' => $json_last_error,
				'error_message' => 'json_encode error : ' . $json_last_error,
				'error_data' => '',
			);

			$this->results = json_encode($this->results);
		}

		/**
		 * Json encode the `results` property value
		 *
		 * @return void
		 */
		private function json_encode_results() {
			$this->results = json_encode($this->results);
		}
	}

endif;
