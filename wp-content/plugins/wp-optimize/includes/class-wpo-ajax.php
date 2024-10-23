<?php

if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('WPO_Ajax')) :

class WPO_Ajax {

	private $nonce;

	private $subaction;

	private $data;

	private $commands;

	private $results;

	const HEARTBEAT_INTERVAL = 15; // in seconds

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action('wp_ajax_wp_optimize_ajax', array($this, 'handle_ajax_requests'));
		add_filter('wp_optimize_heartbeat_ajax', array($this, 'handle_heartbeat_requests'), 10, 1);
		add_filter('wp_optimize_is_heartbeat_valid_ajax_command', array($this, 'is_heartbeat_command_valid'), 10, 1);
	}

	/**
	 * Check if a command is valid for this class
	 *
	 * @param string $command
	 * @return bool
	 */
	public function is_heartbeat_command_valid($command) {
		$this->set_heartbeat_subaction($command);
		$this->set_commands();
		return !$this->is_invalid_command();
	}

	/**
	 * Return singleton instance
	 *
	 * @return WPO_Ajax Returns WPO_Ajax object
	 */
	public static function get_instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Handles heartbeat requests
	 *
	 * @param string $action The action we want to run
	 * @return mixed
	 */
	public function handle_heartbeat_requests($action) {
		$this->set_heartbeat_subaction($action);

		if (!$this->is_user_capable()) {
			return json_encode($this->send_user_capability_error_response(false));
		}

		if (is_multisite() && !current_user_can('manage_network_options')) {
			if (!$this->is_valid_multisite_command()) {
				return json_encode($this->send_invalid_multisite_command_error_response(false));
			}
		}

		$this->set_commands();
		if ($this->is_invalid_command()) {
			$this->add_invalid_command_error_log_entry();
			$this->set_invalid_command_error_response();
		} else {
			$this->execute_command();
			$this->maybe_fix_status_box_content();
			$this->set_error_response_on_wp_error();
			$this->maybe_set_results_as_null();
		}

		$this->json_encode_results();

		$json_last_error = json_last_error();
		if ($json_last_error) {
			$this->set_error_response_on_json_encode_error($json_last_error);
		}

		return $this->results;
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

		if (!$this->is_valid_request()) {
			$this->send_security_check_failed_error_response();
		}

		if (!$this->is_user_capable()) {
			$this->send_user_capability_error_response();
		}
		
		if (is_multisite() && !current_user_can('manage_network_options')) {
			if (!$this->is_valid_multisite_command()) {
				$this->send_invalid_multisite_command_error_response();
			}
		}

		if ($this->is_subaction_a_dismissed_notice()) {
			$this->handle_notice_dismissals();
		} else {
			$this->set_commands();
			if ($this->is_invalid_command()) {
				$this->add_invalid_command_error_log_entry();
				$this->set_invalid_command_error_response();
			} else {
				$this->execute_command();
				$this->maybe_fix_status_box_content();
				$this->set_error_response_on_wp_error();
				$this->maybe_set_results_as_null();
			}
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
	 */
	private function set_nonce() {
		$this->nonce = empty($_POST['nonce']) ? '' : $_POST['nonce'];
	}

	/**
	 * Sets subaction property value
	 */
	private function set_subaction() {
		$this->subaction = empty($_POST['subaction']) ? '' : stripcslashes($_POST['subaction']);
	}

	/**
	 * Sets heartbeat subaction property value
	 *
	 * @param string $action_name The name of the heartbeat action to run
	 */
	private function set_heartbeat_subaction($action_name) {
		$this->subaction = $action_name;
	}

	/**
	 * Sets data property value
	 */
	private function set_data() {
		$this->data = isset($_POST['data']) ? stripslashes_deep($_POST['data']) : null;
	}

	/**
	 * Checks whether the request is valid or not
	 *
	 * @return bool
	 */
	private function is_valid_request() {
		return wp_verify_nonce($this->nonce, 'wp-optimize-ajax-nonce') && !empty($this->subaction);
	}

	/**
	 * Send security check failed error response to browser and die
	 */
	private function send_security_check_failed_error_response() {
		wp_send_json(array(
			'result' => false,
			'error_code' => 'security_check',
			'error_message' => __('The security check failed; try refreshing the page.', 'wp-optimize')
		));
	}


	/**
	 * Checks whether current user capable of doing this action or not
	 *
	 * @return bool
	 */
	private function is_user_capable() {
		return current_user_can(WP_Optimize()->capability_required());
	}

	/**
	 * Send user capability check failed error response to browser and possibly die
	 *
	 * @param Boolean $send - if true, then the response is output; otherwise, it is returned
	 */
	private function send_user_capability_error_response($send = true) {
		$error = array(
			'result' => false,
			'error_code' => 'security_check',
			'error_message' => __('You are not allowed to run this command.', 'wp-optimize')
		);

		if (true == $send) {
			wp_send_json($error);
		} else {
			return $error;
		}
	}

	/**
	 * Checks whether subaction is a valid multisite command
	 *
	 * @return bool
	 */
	private function is_valid_multisite_command() {
		/**
		 * Filters the commands allowed to the sub site admins. Other commands are only available to network admin. Only used in a multisite context.
		 */
		$allowed_multisite_commands = apply_filters('wpo_multisite_allowed_commands', array('check_server_status', 'compress_single_image', 'restore_single_image'));
		return in_array($this->subaction, $allowed_multisite_commands);
	}

	/**
	 * Send invalid multisite command error response to browser and die
	 */
	private function send_invalid_multisite_command_error_response($send = true) {
		$error = array(
			'result' => false,
			'error_code' => 'update_failed',
			'error_message' => __('Options can only be saved by network admin', 'wp-optimize')
		);

		if (true == $send) {
			wp_send_json($error);
		} else {
			return $error;
		}
	}

	/**
	 * Checks if subaction is a notice dismissal or not
	 *
	 * @return bool True for notice dismiss actions, false otherwise
	 */
	private function is_subaction_a_dismissed_notice() {
		$dismiss_actions = $this->get_dismiss_actions();
		return in_array($this->subaction, $dismiss_actions);
	}

	/**
	 * Returns an array of notice dismiss action names
	 *
	 * @return array An array of notice dismiss actions
	 */
	private function get_dismiss_actions() {
		return array(
			'dismiss_dash_notice_until',
			'dismiss_season',
			'dismiss_page_notice_until',
			'dismiss_notice',
			'dismiss_review_notice',
		);
	}

	/**
	 * Handles notice dismissals
	 */
	private function handle_notice_dismissals() {
		$options = WP_Optimize()->get_options();
		// Some commands that are available via AJAX only.
		if (in_array($this->subaction, array('dismiss_dash_notice_until', 'dismiss_season'))) {
			$options->update_option($this->subaction, (time() + 366 * 86400));
		} elseif (in_array($this->subaction, array('dismiss_page_notice_until', 'dismiss_notice'))) {
			$options->update_option($this->subaction, (time() + 84 * 86400));
		} elseif ('dismiss_review_notice' == $this->subaction) {
			if (empty($this->data['dismiss_forever'])) {
				$options->update_option($this->subaction, time() + 84 * 86400);
			} else {
				$options->update_option($this->subaction, 100 * (365.25 * 86400));
			}
		}
	}

	/**
	 * Sets commands property value
	 */
	private function set_commands() {
		$this->commands = apply_filters('wpo_premium_ajax_commands', new WP_Optimize_Commands());

		$minify_commands = $this->get_minify_commands();
		if ($this->is_subaction_a_minify_command($minify_commands)) {
			$this->commands = $minify_commands;
		}

		$cache_commands = $this->get_cache_commands();
		if ($this->is_subaction_a_cache_command($cache_commands)) {
			$this->commands = $cache_commands;
		}
	}

	/**
	 * Gets minify commands
	 *
	 * @return WP_Optimize_Minify_Commands
	 */
	private function get_minify_commands() {
		return new WP_Optimize_Minify_Commands();
	}

	/**
	 * Gets cache commands
	 *
	 * @return WP_Optimize_Cache_Commands|WP_Optimize_Cache_Commands_Premium
	 */
	private function get_cache_commands() {
		if (WP_Optimize::is_premium()) {
			$cache_commands = new WP_Optimize_Cache_Commands_Premium();
		} else {
			$cache_commands = new WP_Optimize_Cache_Commands();
		}
		return $cache_commands;
	}

	/**
	 * Checks if applied ajax command is a minify command or not
	 *
	 * @param WP_Optimize_Minify_Commands $minify_commands an instance of minify commands class
	 *
	 * @return bool Returns true if ajax command is a minify command, false otherwise
	 */
	private function is_subaction_a_minify_command($minify_commands) {
		return !is_callable(array($this->commands, $this->subaction)) && is_callable(array($minify_commands, $this->subaction));
	}

	/**
	 * Checks if applied ajax command is a cache command or not
	 *
	 * @param WP_Optimize_Cache_Commands|WP_Optimize_Cache_Commands_Premium $cache_commands an instance of cache commands
	 *
	 * @return bool Returns true if ajax command is a cache command, false otherwise
	 */
	private function is_subaction_a_cache_command($cache_commands) {
		return !is_callable(array($this->commands, $this->subaction)) && is_callable(array($cache_commands, $this->subaction));
	}

	/**
	 * Checks if applied ajax command is an invalid command or not
	 *
	 * @return bool Returns true if ajax command is an invalid command, false otherwise
	 */
	private function is_invalid_command() {
		return !is_callable(array($this->commands, $this->subaction));
	}

	/**
	 * Log an error message for invalid ajax command
	 */
	private function add_invalid_command_error_log_entry() {
		error_log("WP-Optimize: ajax_handler: no such command (" . $this->subaction . ")");
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
			'error_message' => sprintf(__('The command "%s" was not found', 'wp-optimize'), $this->subaction)
		);
	}

	/**
	 * Execute the ajax command
	 */
	private function execute_command() {
		$this->results = call_user_func(array($this->commands, $this->subaction), $this->data);
	}

	/**
	 * If status box content is present, fix it.
	 */
	private function maybe_fix_status_box_content() {
		// clean status box content, it broke json sometimes.
		// Git commit wp-optimize/-/commit/c05686b39959b863f4e168af3fa54421c4870470
		if (isset($this->results['status_box_contents'])) {
			$this->results['status_box_contents'] = str_replace(array("\n", "\t"), '', $this->results['status_box_contents']);
		}
	}

	/**
	 * Set `results` property with error message
	 */
	private function set_error_response_on_wp_error() {
		if (is_wp_error($this->results)) {
			$this->results =  array(
				'result' => false,
				'error_code' => $this->results->get_error_code(),
				'error_message' => $this->results->get_error_message(),
				'error_data' => $this->results->get_error_data(),
			);
		}
	}

	/**
	 * Set `results` property to null, if it is not yet set
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
	 */
	private function json_encode_results() {
		$this->results = json_encode($this->results);
	}
}

endif;
