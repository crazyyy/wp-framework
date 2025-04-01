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
		add_action('comment_spam_to_approved', array($this, 'comment_spam_status_change'));
		add_action('comment_spam_to_unapproved', array($this, 'comment_spam_status_change'));
		add_action('aios_perform_update_antibot_keys', array($this, 'update_antibot_keys'));
	}

	/**
	 * Set comment user IP for local server setup.
	 *
	 * @param string $comment_user_ip comment user IP.
	 * @return string Comment user IP.
	 */
	public function pre_comment_user_ip($comment_user_ip) {
		if (in_array($comment_user_ip, array('', '127.0.0.1', '::1'))) {
			$external_ip_address = AIOS_Helper::get_external_ip_address();
			if (false != $external_ip_address) {
				$comment_user_ip = $external_ip_address;
			}
		}
		return $comment_user_ip;
	}

	/**
	 * Move spam comments to trash.
	 */
	public static function trash_spam_comments() {
		global $aio_wp_security;
		if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_trash_spam_comments') && absint($aio_wp_security->configs->get_value('aiowps_trash_spam_comments_after_days'))) {
			$date_before = absint($aio_wp_security->configs->get_value('aiowps_trash_spam_comments_after_days')).' days ago';
			$comment_ids = get_comments(array(
				'fields' => 'ids',
				'status' => 'spam',
				'date_query' => array(
					array(
						'before' => $date_before,
						'inclusive' => true,
					),
				)
			));
			
			if (!empty($comment_ids)) {
				foreach ($comment_ids as $comment_id) {
					wp_trash_comment($comment_id);
				}
			}
		}
	}

	/**
	 * Delete ip from aiowps_permanent_block table once the comment's spam status changed.
	 *
	 * @param object $comment_data comment object.
	 */
	public function comment_spam_status_change($comment_data) {
		global $wpdb, $aio_wp_security;
		$comment_ip = $comment_data->comment_author_IP;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- Direct query necessary. No caching required.
		$total_spam_comment = $wpdb->get_var(
			$wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_author_IP = %s AND comment_approved = 'spam'", $comment_ip)
		);
		$min_comment_before_block = $aio_wp_security->configs->get_value('aiowps_spam_ip_min_comments_block');
		if ($total_spam_comment < $min_comment_before_block) {
			$where = array('blocked_ip' => $comment_ip, 'block_reason' => 'spam');
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- Direct query necessary. No caching required.
			$wpdb->delete(AIOWPSEC_TBL_PERM_BLOCK, $where, array('%s'));
		}
	}
	
	/**
	 * Checks if comment posted by spambot.
	 *
	 * @return boolean.
	 */
	public static function is_comment_spam_detected() {
		$return = false;
		if (!is_user_logged_in()) {
			if (empty($_SERVER['HTTP_REFERER']) || false === stristr(sanitize_url(wp_unslash($_SERVER['HTTP_REFERER'])), wp_parse_url(home_url(), PHP_URL_HOST)) || empty($_SERVER['HTTP_USER_AGENT'])) {
				$return = true;
			} elseif (self::is_bot_detected()) {
				$return = true;
			}
		}
		return apply_filters('aiowps_is_comment_spam_detected', $return);
	}
	
	/**
	 * Check if bot posted comment form based on form posted fields and cookie values
	 *
	 * @return boolean
	 */
	public static function is_bot_detected() {
		global $aio_wp_security;
		$return = false;
		$key_map_arr = self::generate_antibot_keys();
		foreach ($key_map_arr[0] as $key) {
			// phpcs:ignore WordPress.Security.NonceVerification.Missing -- PCP warning. Nonce checked in earlier function.
			if (empty($_POST[$key[0]]) || sanitize_text_field(wp_unslash($_POST[$key[0]])) != $key[1]) {
				$return = true;
				break;
			}
		}
		if (!$return && '1' == $aio_wp_security->configs->get_value('aiowps_spambot_detect_usecookies')) {
			foreach ($key_map_arr[1] as $key) {
				if (AIOWPSecurity_Utility::get_cookie_value($key[0]) != $key[1]) {
					$return = true;
					break;
				}
			}
		}
		return apply_filters('aios_is_bot_detected', $return);
	}
	
	/**
	 * Set cookies in browser for antibot check
	 *
	 * @return void
	 */
	public static function insert_antibot_keys_in_cookie() {
		$key_map_arr = self::generate_antibot_keys();
		$expiry_seconds = AIOS_UPDATE_ANTIBOT_KEYS_AFTER_DAYS * 86400;
		if (!empty($key_map_arr[1])) {
			foreach ($key_map_arr[1] as $key) {
				AIOWPSecurity_Utility::set_cookie_value($key[0], $key[1], $expiry_seconds);
			}
		}
	}
	
	/**
	 * Comment Form to post back hidden fields for antibot check
	 *
	 * @return string
	 */
	public static function insert_antibot_keys_in_comment_form() {
		$html_antibot_hidden_fields = '<p class="comment-form-aios-antibot-keys">%1$s</p>';
		$antibot_hidden_fields = '';
		$key_map_arr = self::generate_antibot_keys();
		foreach ($key_map_arr[0] as $key) {
			$antibot_hidden_fields .='<input type="hidden" name="' . esc_attr($key[0]) . '" value="'.esc_attr($key[1]).'" >';
		}
		if (isset($key_map_arr[2])) {
			$antibot_hidden_fields .='<input type="hidden" name="aios_antibot_keys_expiry" id="aios_antibot_keys_expiry" value="'.esc_attr($key_map_arr[2]).'">';
		}
		wp_register_script('aios-front-js', AIO_WP_SECURITY_URL. '/js/wp-security-front-script.js', array('jquery'), AIO_WP_SECURITY_VERSION, true);
		wp_enqueue_script('aios-front-js');
		wp_localize_script('aios-front-js', 'AIOS_FRONT', array(
			'ajaxurl' => admin_url('admin-ajax.php'), // URL to wp-admin/admin-ajax.php to process the request
			'ajax_nonce' => wp_create_nonce('wp-security-ajax-nonce'),
		));
		$html_antibot_hidden_fields = sprintf($html_antibot_hidden_fields, $antibot_hidden_fields);
		return $html_antibot_hidden_fields;
	}
	
	/**
	 * Get antibot key-value pairs to check on post back
	 *
	 * @param boolean $update generate and save in database
	 *
	 * @return array
	 */
	public static function generate_antibot_keys($update = false) {
		$key_map_arr = get_site_option('aios_antibot_key_map_info');
		if (!$update && is_array($key_map_arr)) {
			return $key_map_arr;
		}
		if ($update && is_array($key_map_arr) && isset($key_map_arr[2]) && $key_map_arr[2] > time()) {
			return $key_map_arr;
		}
		$key_map_arr = array();
		
		// values for to check post back key
		$max = wp_rand(2, 4);
		for ($i = 1; $i <= $max; $i++) {
			$string1 = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(8);
			$string2 = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(12);
			$key_map_arr[0][] = array($string1, $string2);
		}

		// values for to check for cookie back key
		$max = wp_rand(2, 4);
		for ($i = 1; $i <= $max; $i++) {
			$string1 = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(8);
			$string2 = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(12);
			$key_map_arr[1][] = array($string1, $string2);
		}
		// expiration time of keys
		$current_time = time();
		$key_map_arr[2] = (($current_time - ($current_time % 86400)) + AIOS_UPDATE_ANTIBOT_KEYS_AFTER_DAYS * 86400);
		update_site_option('aios_antibot_key_map_info', $key_map_arr);
		return $key_map_arr;
	}
	
	/**
	 * Update antibot key-value pairs to rotate values so it is not valid forever
	 *
	 * @return void
	 */
	public function update_antibot_keys() {
		if ((intval(gmdate('z')) % AIOS_UPDATE_ANTIBOT_KEYS_AFTER_DAYS) == 0) self::generate_antibot_keys(true);
	}
}
