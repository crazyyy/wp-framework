<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Comment_Commands_Trait')) return;

trait AIOWPSecurity_Comment_Commands_Trait {

	/**
	 * Perform the saving of comment spam prevention settings
	 *
	 * @param array $data - the request data contains the post data
	 *
	 * @return array
	 */
	public function perform_comment_spam_prevention($data) {
		$response = array();

		// Save settings
		$options = array();
		$info = array();

		$options['aiowps_enable_spambot_detecting'] = isset($data["aiowps_enable_spambot_detecting"]) ? '1' : '';
		$options['aiowps_spambot_detect_usecookies'] = isset($data["aiowps_spambot_detect_usecookies"]) ? '1' : '';
		$options['aiowps_spam_comments_should'] = !empty($data["aiowps_spam_comments_should"]) ? '1' : '0';
		$options['aiowps_enable_trash_spam_comments'] = isset($data['aiowps_enable_trash_spam_comments']) ? '1' : '';
		if (isset($data['aiowps_trash_spam_comments_after_days'])) {
			$aiowps_trash_spam_comments_after_days = sanitize_text_field($data['aiowps_trash_spam_comments_after_days']);
			if (isset($data['aiowps_enable_trash_spam_comments']) && !is_numeric($aiowps_trash_spam_comments_after_days)) {
				$error = __('You entered a non-numeric value for the "move spam comments to trash after number of days" field; it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				//Set it to the default value for this field
				$info[] = $error;
				$aiowps_trash_spam_comments_after_days = 14;
			}
			$aiowps_trash_spam_comments_after_days = absint($aiowps_trash_spam_comments_after_days);
			$options['aiowps_trash_spam_comments_after_days'] = $aiowps_trash_spam_comments_after_days;

			$response['values'] = array(
				'aiowps_trash_spam_comments_after_days' => $aiowps_trash_spam_comments_after_days
			);
		}

		$response['status'] = 'success';
		$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');
		$response['info'] = $info;

		// Commit the config settings
		$this->save_settings($options);
		AIOWPSecurity_Comment::trash_spam_comments();
		$response['badges'] = $this->get_features_id_and_html(array('detect-spambots'));

		return $response;
	}

	/**
	 * Perform the saving of comment auto block spammers ip settings
	 *
	 * @param array $data - the request data contains the post data
	 *
	 * @return array
	 */
	public function perform_auto_block_spam_ip($data) {
		$response = array(
			'status' => 'success',
			'values' => array(),
			'info' => array()
		);

		$enable_auto_block_ip = isset($data["aiowps_enable_autoblock_spam_ip"]) ? '1' : '';

		$spam_ip_min_comments = sanitize_text_field($data['aiowps_spam_ip_min_comments_block']);
		if (!is_numeric($spam_ip_min_comments)) {
			$response['info'][] = __('You entered a non-numeric value for the "minimum number of spam comments" field; it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
			$spam_ip_min_comments = '3';// Set it to the default value for this field
		} elseif ((int) $spam_ip_min_comments <= 0 || empty($spam_ip_min_comments)) {
			$response['info'][] = __('You must enter an integer greater than zero for the "minimum number of spam comments" field; it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
			$spam_ip_min_comments = '3';// Set it to the default value for this field
		}

		// Save all the form values to the options
		$options = array(
			'aiowps_enable_autoblock_spam_ip' => $enable_auto_block_ip,
			'aiowps_spam_ip_min_comments_block' => absint($spam_ip_min_comments),
		);
		
		$this->save_settings($options);
		$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');

		$response['badges'] = $this->get_features_id_and_html(array('auto-block-spam-ips'));
		$response['values']['aiowps_spam_ip_min_comments_block'] = absint($spam_ip_min_comments);

		return $response;
	}

	/**
	 * Perform the ip spam comment search
	 *
	 * @param array $data - the request data contains the post data
	 *
	 * @return array
	 */
	public function perform_ip_spam_search($data) {
		$response = array(
			'status' => 'success',
			'info' => array()
		);

		$min_comments_per_ip = sanitize_text_field($data['aiowps_spam_ip_min_comments']);
		$error = '';

		if (!is_numeric($min_comments_per_ip)) {
			$error = __('You entered a non-numeric value for the minimum spam comments per IP field; it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
			$min_comments_per_ip = '5'; // Set it to the default value for this field
		} elseif ((int) $min_comments_per_ip <= 0 || empty($min_comments_per_ip)) {
			$error = __('You must enter an integer greater than zero for the minimum spam comments per IP field; it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
			$min_comments_per_ip = '5'; // Set it to the default value for this field
		}

		$min_comments_per_ip = absint($min_comments_per_ip);

		// Save all the form values to the options
		$this->save_settings(array(
			'aiowps_spam_ip_min_comments' => $min_comments_per_ip
		));

		if (!empty($error)) {
			$response['message'] = $error;
		}

		$response['values']['aiowps_spam_ip_min_comments'] = $min_comments_per_ip;

		return $response;
	}

	/**
	 * Perform the action of blocking a spam IP address.
	 *
	 * This function takes an IP address as input, checks if it is valid and not the user's own IP,
	 * and then attempts to add it to the block list for spam. It returns the status and message of the operation.
	 *
	 * @param array $data The data containing the IP address to block.
	 *
	 * @return array The result of the block operation, including status, message, and updated blocked comments output.
	 */
	public function perform_block_spam_ip($data) {

		if (empty($data['ip'])) {
			return array('status' => 'error', 'message' => __('Invalid IP address provided.', 'all-in-one-wp-security-and-firewall'));
		}

		$ip = strip_tags($data['ip']);

		if (AIOWPSecurity_Utility_IP::get_user_ip_address() == $ip) {
			return array('status' => 'error', 'message' => __('You cannot block your own IP address:', 'all-in-one-wp-security-and-firewall') . ' ' . $ip);
		}

		$result = AIOWPSecurity_Blocking::add_ip_to_block_list($ip, 'spam');

		if ($result) {
			$status = 'success';
			$message = __('The selected IP address is now permanently blocked.', 'all-in-one-wp-security-and-firewall');
		} else {
			$status = 'error';
			$message = __('The selected IP address could not be blocked due to one of the following reasons:', 'all-in-one-wp-security-and-firewall');
			$message .= ' ' . __('either it has already been blocked, or your user account lacks sufficient permissions to perform IP blocking.', 'all-in-one-wp-security-and-firewall');
		}

		return array(
			'status' => $status,
			'message' => $message,
			'content' => array('aios-blocked-comments-output' => $this->get_blocked_comments_output())
		);
	}

	/**
	 * Retrieves the output for displaying blocked comments due to spam.
	 *
	 * This function queries the database to get IP addresses that are permanently blocked due to spam.
	 * It returns HTML output that displays the count of IPs blocked today and the all-time total count.
	 *
	 * @global object $aio_wp_security The global instance of the aio_wp_security class.
	 * @global object $wpdb The global instance of the WordPress database class.
	 *
	 * @return string HTML output for the blocked comments section.
	 */
	private function get_blocked_comments_output() {
		global $aio_wp_security, $wpdb;

		$block_comments_output = '';
		$min_block_comments = $aio_wp_security->configs->get_value('aiowps_spam_ip_min_comments_block');

		if (!empty($min_block_comments)) {
			$now_date = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d');

			$sql = $wpdb->prepare(
				"SELECT COUNT(*) AS total_count, 
       			SUM(CASE WHEN DATE(FROM_UNIXTIME(created)) = %s THEN 1 ELSE 0 END) AS todays_blocked_count FROM ".AIOWPSEC_TBL_PERM_BLOCK." WHERE block_reason = %s",
				$now_date,
				'spam'
			);
			$result = $wpdb->get_row($sql);

			$block_comments_output = '<div class="aio_yellow_box">';
			if (empty($result) || 0 == $result->total_count) {
				$block_comments_output .= '<p><strong>'.__('You currently have no IP addresses permanently blocked due to spam.', 'all-in-one-wp-security-and-firewall').'</strong></p>';
			} else {
				$todays_blocked_count = $result->todays_blocked_count;
				$total_count = $result->total_count;

				$block_comments_output .= '<p><strong>'.__('Spammer IPs added to permanent block list today:', 'all-in-one-wp-security-and-firewall') . ' ' . $todays_blocked_count . '</strong></p>';
				$block_comments_output .= '<hr><p><strong>'.__('All time total:', 'all-in-one-wp-security-and-firewall'). ' ' . $total_count.'</strong></p>';
				$block_comments_output .= '<p><a class="button" href="admin.php?page='.AIOWPSEC_MAIN_MENU_SLUG.'&tab=permanent-block" target="_blank">'.__('View blocked IPs', 'all-in-one-wp-security-and-firewall').'</a></p>';
			}
			$block_comments_output .= '</div>';
		}

		return $block_comments_output;
	}
}
