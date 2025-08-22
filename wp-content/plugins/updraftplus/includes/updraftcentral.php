<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed.');

if (!class_exists('UpdraftPlus_Login')) require_once('updraftplus-login.php');

class UpdraftPlus_UpdraftCentral_Cloud extends UpdraftPlus_Login {

	/**
	 * Pulls the appropriate message for the given code and translate it before
	 * returning it to the caller
	 *
	 * @internal
	 * @param string $code The code of the message to pull
	 * @return string - The translated message
	 */
	protected function translate_message($code) {
		switch ($code) {
			case 'generic':
			default:
				return __('An error has occurred while processing your request.', 'updraftplus').' '.__('The server might be busy or you have lost your connection to the internet at the time of the request.', 'updraftplus').' '.__('Please try again later.', 'updraftplus');
				break;
		}
	}

	/**
	 * Executes login or registration process. Connects and sends request to the UpdraftCentral Cloud
	 * and returns the response coming from the server
	 *
	 * @internal
	 * @param array   $data     The submitted form data
	 * @param boolean $register Indicates whether the current call is for a registration process or not. Defaults to false.
	 * @return array - The response from the request
	 */
	protected function login_or_register($data, $register = false) {
		global $updraftplus, $updraftcentral_main;

		$action = ($register) ? 'updraftcentral_cloud_register' : 'updraftcentral_cloud_login';
		if (empty($data['site_url'])) $data['site_url'] = trailingslashit(network_site_url());

		$response = $this->send_remote_request($data, $action);
		if (is_wp_error($response)) {
			$response = array('error' => true, 'code' => $response->get_error_code(), 'message' => $response->get_error_message());
		} else {
			if (isset($response['status'])) {
				if (in_array($response['status'], array('authenticated', 'registered'))) {
					$response['redirect_url'] = $updraftplus->get_url('mothership').'/?udm_action=updraftcentral_cloud_redirect';

					if (is_a($updraftcentral_main, 'UpdraftCentral_Main')) {
						$response['keys_table'] = $updraftcentral_main->get_keys_table();
					}

					if (!empty($data['addons_options_connect']) && class_exists('UpdraftPlus_Options')) {
						UpdraftPlus_Options::update_updraft_option('updraftplus_com_and_udc_connection_success', 1, false);
					}

				} else {
					if ('error' === $response['status']) {
						$message = isset($response['message']) ? $response['message'] : $this->translate_message('generic');

						if (isset($response['code']) && 'incorrect_password' === $response['code']) {
							$message = __("Your email is valid, but your password wasn't recognised.", 'updraftplus').'<br>';
							if (time() < strtotime('2026-01-01 00:00:00')) $message .= __('Some users were asked to reset their passwords as part of a recent website migration.', 'updraftplus').'<br>';
							// translators: %s: The reset password link
							$message .= sprintf(__('Try again, or %s before connecting again.', 'updraftplus'), '<a href="'.$updraftplus->get_url('lost-password').'">'.__('reset your password', 'updraftplus').'</a>');
						}

						$response = array(
							'error' => true,
							'code' => isset($response['code']) ? $response['code'] : -1,
							'message' => $message,
							'response' => $response
						);
					}
				}
			} else {
				$response = array('error' => true, 'message' => $this->translate_message('generic'));
			}
		}

		return $response;
	}
}
