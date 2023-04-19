<?php
if (!defined('ABSPATH')) die('No direct access.');

class AIOWPSecurity_Captcha {

	private $cloudflare_verify_turnstile_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

	private $google_verify_recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

	public function __construct() {
		$this->upgrade_captcha_options();
		add_action('login_enqueue_scripts', array($this, 'aiowps_login_enqueue'));
	}

	/**
	 * This function handles upgrading captcha options
	 *
	 * @return void
	 */
	private function upgrade_captcha_options() {
		global $aio_wp_security;

		if (!empty($aio_wp_security->configs->get_value('aiowps_default_captcha'))) return;

		// Upgrade the default captcha option
		if ($aio_wp_security->configs->get_value('aiowps_default_recaptcha')) {
			$aio_wp_security->configs->set_value('aiowps_default_recaptcha', '');
			$aio_wp_security->configs->set_value('aiowps_default_captcha', 'google-recaptcha-v2');
		} elseif ('1' == $aio_wp_security->configs->get_value('aiowps_enable_login_captcha') || '1' == $aio_wp_security->configs->get_value('aiowps_enable_registration_page_captcha')) {
			$aio_wp_security->configs->set_value('aiowps_default_captcha', 'simple-math');
		} else {
			$aio_wp_security->configs->set_value('aiowps_default_captcha', 'none');
		}
	}

	/**
	 * This function will return an array of supported CAPTCHA options
	 *
	 * @return array - an array of supported CAPTCHA options
	 */
	public function get_supported_captchas() {
		return array(
			'none' => 'No CAPTCHA',
			'cloudflare-turnstile' => 'Cloudflare Turnstile',
			'google-recaptcha-v2' => 'Google reCAPTCHA V2',
			'simple-math' => 'Simple math CAPTCHA'
		);
	}
	
	/**
	 * This function will display warning CAPTCHA settings not set.
	 *
	 * @global $aio_wp_security;
	 *
	 * @return void
	 */
	public static function warning_captcha_settings_notset() {
		global $aio_wp_security;
		$aiowps_default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');
		if ('' == $aiowps_default_captcha || 'none' == $aiowps_default_captcha) {
			$captcha_settings_link = '<a href="admin.php?page='.AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=captcha-settings" target="_blank">' . __('CAPTCHA settings', 'all-in-one-wp-security-and-firewall') . '</a>';
			echo '<div class="aio_orange_box"><p>';
			echo sprintf(__('You should set %s before activating this feature.', 'all-in-one-wp-security-and-firewall'), $captcha_settings_link);
			echo '</p></div>';
		}
	}

	/**
	 * Enqueues the CAPTCHA script for the default CAPTCHA on the standard WP login page
	 *
	 * @return void
	 */
	public function aiowps_login_enqueue() {
		global $aio_wp_security;
		
		if ($aio_wp_security->is_login_lockdown_by_const()) return;
		
		if ('1' != $aio_wp_security->configs->get_value('aiowps_enable_login_captcha') && '1' != $aio_wp_security->configs->get_value('aiowps_enable_registration_page_captcha')) return;

		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');

		switch ($default_captcha) {
			case 'cloudflare-turnstile':
			case 'google-recaptcha-v2':
				wp_enqueue_script($default_captcha, $this->get_captcha_script_url($default_captcha), array(), AIO_WP_SECURITY_VERSION);
				// Below is needed to provide some space for the CAPTCHA form (otherwise it appears partially hidden on RHS)
				wp_add_inline_style('login', "#login { width: 340px; }");
				break;
			default:
				break;
		}
	}

	/**
	 * If the user is not on the WooCommerce account page, enqueue the CAPTCHA script in the wp_head for general pages
	 * Caters for scenarios when CAPTCHA is used on wp comments or custom wp login form pages
	 *
	 * @return void
	 */
	public function add_captcha_script() {
		global $aio_wp_security;

		// Do NOT enqueue if this is the main WooCommerce account login page because for WooCommerce page we "explicitly" render the reCAPTCHA widget
		$is_woo = false;

		// We don't want to load for Woo account page because we have a special function for this
		if (function_exists('is_account_page')) $is_woo = is_account_page();

		if (!empty($is_woo)) return;

		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');

		switch ($default_captcha) {
			case 'cloudflare-turnstile':
			case 'google-recaptcha-v2':
				wp_enqueue_script($default_captcha, $this->get_captcha_script_url($default_captcha), array(), AIO_WP_SECURITY_VERSION);
				break;
			default:
				break;
		}
	}

	/**
	 * Renders CAPTCHA on form produced by the wp_login_form() function, ie, custom wp login form
	 *
	 * @param string $cust_html_code
	 *
	 * @return string
	 */
	public function insert_captcha_custom_login($cust_html_code) {
		global $aio_wp_security;
		
		if ($aio_wp_security->is_login_lockdown_by_const()) return '';

		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');
		
		switch ($default_captcha) {
			case 'cloudflare-turnstile':
			case 'google-recaptcha-v2':
				$cust_html_code .= $this->get_captcha_form($default_captcha, 0, true);
				return $cust_html_code;
				break;
			case 'simple-math':
				$cap_form = '<p class="aiowps-captcha"><label>'.__('Please enter an answer in digits:', 'all-in-one-wp-security-and-firewall').'</label>';
				$cap_form .= '<div class="aiowps-captcha-equation"><strong>';
				$maths_question_output = $aio_wp_security->captcha_obj->generate_maths_question();
				$cap_form .= $maths_question_output . '</strong></div></p>';
	
				$cust_html_code .= $cap_form;
				return $cust_html_code;
				break;
			default:
				return '';
				break;
		}
	}

	/**
	 * Explicit render CAPTCHA on WooCommerce my account page forms or if not just render normally
	 *
	 * @return void
	 */
	public function insert_captcha_question_form() {
		global $aio_wp_security;

		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');

		switch ($default_captcha) {
			case 'cloudflare-turnstile':
			case 'google-recaptcha-v2':
				// WooCommerce "my account" page needs special consideration, ie,
				// need to display two CAPTCHA forms on same page (for login and register forms)
				// For this case we use the "explicit" CAPTCHA display
				$calling_hook = current_filter();
				if ('woocommerce_login_form' == $calling_hook || 'woocommerce_lostpassword_form' == $calling_hook) {
					$this->get_captcha_form($default_captcha, 1);
					return;
				}

				if ('woocommerce_register_form' == $calling_hook) {
					$this->get_captcha_form($default_captcha, 2);
					return;
				}

				// For all other forms simply display CAPTCHA as normal
				$this->display_captcha_form($default_captcha);
				break;
			case 'simple-math':
				// Display plain maths CAPTCHA form
				$this->display_captcha_form($default_captcha);
				break;
			default:
				break;
		}
	}

	/**
	 * For WooCommerce my account page - display two separate CAPTCHA forms "explicitly"
	 *
	 * @return void
	 */
	public function print_captcha_api_woo() {
		global $aio_wp_security;

		// We don't want to load for woo account page because we have a special function for this
		if (function_exists('is_account_page') && !is_account_page()) return;

		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');

		if ('cloudflare-turnstile' == $default_captcha) :
		$site_key = esc_html($aio_wp_security->configs->get_value('aiowps_turnstile_site_key'));
		?>
		<script>
				var verifyCallback = function(response) {
					alert(response);
				};
				var onloadCallback = function() {
					if ( jQuery('#woo_recaptcha_1').length ) {
						turnstile.render('#woo_recaptcha_1', {
							sitekey: '<?php echo esc_js($site_key); ?>'
						});
					}
					if ( jQuery('#woo_recaptcha_2').length ) {
						turnstile.render('#woo_recaptcha_2', {
							sitekey: '<?php echo esc_js($site_key); ?>'
						});
					}
				};
		</script>
		<script src='https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadCallback' async defer></script>
		<?php
		elseif ('google-recaptcha-v2' == $default_captcha) :
		$site_key = esc_html($aio_wp_security->configs->get_value('aiowps_recaptcha_site_key'));
		?>
		<script>
				var verifyCallback = function(response) {
					alert(response);
				};
				var onloadCallback = function() {
					if ( jQuery('#woo_recaptcha_1').length ) {
						grecaptcha.render('woo_recaptcha_1', {
						'sitekey' : '<?php echo $site_key; ?>',
						});
					}
					if ( jQuery('#woo_recaptcha_2').length ) {
						grecaptcha.render('woo_recaptcha_2', {
						'sitekey' : '<?php echo $site_key; ?>',
						});
					}
				};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?hl=<?php echo $this->get_google_recaptcha_compatible_site_locale(); ?>&onload=onloadCallback&render=explicit' async defer></script>
		<?php
		endif;
	}

	/**
	 * For cases when a custom wp_login_form() is displayed anywhere on a page, inserts a script element referencing the CAPTCHA API. Only inserts the CAPTCHA script element if the wp login form exists.
	 *
	 * @return void
	 */
	public function print_captcha_api_custom_login() {
		global $aio_wp_security;

		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');

		switch ($default_captcha) {
			case 'cloudflare-turnstile':
			case 'google-recaptcha-v2':
				wp_enqueue_script($default_captcha, $this->get_captcha_script_url($default_captcha), array(), AIO_WP_SECURITY_VERSION);
				break;
			default:
				break;
		}
	}

	/**
	 * Displays CAPTCHA form
	 *
	 * @param string $default_captcha - the default CAPTCHA
	 *
	 * @return void
	 */
	public function display_captcha_form($default_captcha) {
		global $aio_wp_security;

		if ($aio_wp_security->configs->get_value('aiowps_enable_bp_register_captcha') == '1' && defined('BP_VERSION')) {
			//if buddy press feature active add action hook so buddy press can display our errors properly on bp registration form
			do_action('bp_aiowps-captcha-answer_errors');
		}

		switch ($default_captcha) {
			case 'cloudflare-turnstile':
				if ('1' == $aio_wp_security->configs->get_value('aios_cloudflare_turnstile_invalid_configuration')) return;
				$this->get_captcha_form($default_captcha);
				break;
			case 'google-recaptcha-v2':
				if ('1' == $aio_wp_security->configs->get_value('aios_google_recaptcha_invalid_configuration')) return;
				$this->get_captcha_form($default_captcha);
				break;
			case 'simple-math':
				$cap_form = '<p class="aiowps-captcha hide-when-displaying-tfa-input"><label for="aiowps-captcha-answer">'.__('Please enter an answer in digits:', 'all-in-one-wp-security-and-firewall').'</label>';
				$cap_form .= '<div class="aiowps-captcha-equation hide-when-displaying-tfa-input"><strong>';
				$maths_question_output = $this->generate_maths_question();
				$cap_form .= $maths_question_output . '</strong></div></p>';
				echo $cap_form;
				break;
		}
	}

	/**
	 * It generates a random math problem, stores the answer in the database, and returns the math problem
	 *
	 * @return string - contains the HTML for the captcha.
	 */
	private function generate_maths_question() {
		global $aio_wp_security;
		//For now we will only do plus, minus, multiplication
		$equation_string = '';
		$operator_type = array('&#43;', '&#8722;', '&#215;');

		$operand_display = array('word', 'number');

		//let's now generate an equation
		$operator = $operator_type[rand(0, 2)];

		if ('&#215;' === $operator) {
			//Don't make the question too hard if multiplication
			$first_digit = rand(1, 5);
			$second_digit = rand(1, 5);
		} else {
			$first_digit = rand(1, 20);
			$second_digit = rand(1, 20);
		}

		if ('word' == $operand_display[rand(0, 1)]) {
			$first_operand = $this->number_word_mapping($first_digit);
		} else {
			$first_operand = $first_digit;
		}

		if ('word' == $operand_display[rand(0, 1)]) {
			$second_operand = $this->number_word_mapping($second_digit);
		} else {
			$second_operand = $second_digit;
		}

		//Let's caluclate the result and construct the equation string
		if ('&#43;' === $operator) {
			//Addition
			$result = $first_digit+$second_digit;
			$equation_string .= $first_operand . ' ' . $operator . ' ' . $second_operand . ' = ';
		} elseif ('&#8722;' === $operator) {
			//Subtraction
			//If we are going to be negative let's swap operands around
			if ($first_digit < $second_digit) {
				$equation_string .= $second_operand . ' ' . $operator . ' ' . $first_operand . ' = ';
				$result = $second_digit-$first_digit;
			} else {
				$equation_string .= $first_operand . ' ' . $operator . ' ' . $second_operand . ' = ';
				$result = $first_digit-$second_digit;
			}
		} elseif ('&#215;' === $operator) {
			//Multiplication
			$equation_string .= $first_operand . ' ' . $operator . ' ' . $second_operand . ' = ';
			$result = $first_digit*$second_digit;
		}

		//Let's encode correct answer
		$captcha_secret_string = $aio_wp_security->configs->get_value('aiowps_captcha_secret_key');
		$current_time = time();
		$enc_result = base64_encode($current_time.$captcha_secret_string.$result);
		$random_str = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(10);
		if (is_multisite()) {
			update_site_option('aiowps_captcha_string_info_'.$random_str, $enc_result);
			update_site_option('aiowps_captcha_string_info_time_'.$random_str, $current_time);
		} else {
			update_option('aiowps_captcha_string_info_'.$random_str, $enc_result, false);
			update_option('aiowps_captcha_string_info_time_'.$random_str, $current_time, false);
		}
		$equation_string .= '<input type="hidden" name="aiowps-captcha-string-info" id="aiowps-captcha-string-info" value="'.$random_str.'" />';
		$equation_string .= '<input type="hidden" name="aiowps-captcha-temp-string" id="aiowps-captcha-temp-string" value="'.$current_time.'" />';
		$equation_string .= '<input type="text" size="2" id="aiowps-captcha-answer" name="aiowps-captcha-answer" value="" autocomplete="off" />';
		return $equation_string;
	}

	/**
	 * This function takes a number and returns the word that represents that number
	 *
	 * @param integer $num - the number we want to map to a word
	 *
	 * @return string - the mapped word
	 */
	private function number_word_mapping($num) {
		$number_map = array(
			1 => __('one', 'all-in-one-wp-security-and-firewall'),
			2 => __('two', 'all-in-one-wp-security-and-firewall'),
			3 => __('three', 'all-in-one-wp-security-and-firewall'),
			4 => __('four', 'all-in-one-wp-security-and-firewall'),
			5 => __('five', 'all-in-one-wp-security-and-firewall'),
			6 => __('six', 'all-in-one-wp-security-and-firewall'),
			7 => __('seven', 'all-in-one-wp-security-and-firewall'),
			8 => __('eight', 'all-in-one-wp-security-and-firewall'),
			9 => __('nine', 'all-in-one-wp-security-and-firewall'),
			10 => __('ten', 'all-in-one-wp-security-and-firewall'),
			11 => __('eleven', 'all-in-one-wp-security-and-firewall'),
			12 => __('twelve', 'all-in-one-wp-security-and-firewall'),
			13 => __('thirteen', 'all-in-one-wp-security-and-firewall'),
			14 => __('fourteen', 'all-in-one-wp-security-and-firewall'),
			15 => __('fifteen', 'all-in-one-wp-security-and-firewall'),
			16 => __('sixteen', 'all-in-one-wp-security-and-firewall'),
			17 => __('seventeen', 'all-in-one-wp-security-and-firewall'),
			18 => __('eighteen', 'all-in-one-wp-security-and-firewall'),
			19 => __('nineteen', 'all-in-one-wp-security-and-firewall'),
			20 => __('twenty', 'all-in-one-wp-security-and-firewall'),
		);
		return $number_map[$num];
	}

	/**
	 * This function will return the CAPTCHA script URL
	 *
	 * @param string $default_captcha - the default CAPTCHA
	 *
	 * @return string - the CAPTCHA script URL
	 */
	private function get_captcha_script_url($default_captcha) {
		$url = '';
		switch ($default_captcha) {
			case 'cloudflare-turnstile':
				$url = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
				break;
			case 'google-recaptcha-v2':
				$url = 'https://www.google.com/recaptcha/api.js?hl=' . $this->get_google_recaptcha_compatible_site_locale();
				break;
			default:
				break;
		}

		return $url;
	}

	/**
	 * This function will return the CAPTCHA form
	 *
	 * @param string  $default_captcha        - the default CAPTCHA
	 * @param integer $include_wc_id          - the WooCommerce form id to include, if 0 no id is included
	 * @param boolean $return_instead_of_echo - if we should return the form rather than echo it to page
	 *
	 * @return string - can return the CAPTCHA form
	 */
	private function get_captcha_form($default_captcha, $include_wc_id = 0, $return_instead_of_echo = false) {
		global $aio_wp_security;

		$captcha_form = '';
		$wc_form_id = !empty($include_wc_id) ? 'id="woo_recaptcha_'.$include_wc_id.'"' : '';

		switch ($default_captcha) {
			case 'cloudflare-turnstile':
				$site_key = esc_html($aio_wp_security->configs->get_value('aiowps_turnstile_site_key'));
				$captcha_form = '<div class="cf-turnstile-wrap" style="padding:10px 0 10px 0"><div '. $wc_form_id .' class="cf-turnstile" data-sitekey="'.$site_key.'"></div></div>';
				break;
			case 'google-recaptcha-v2':
				$site_key = esc_html($aio_wp_security->configs->get_value('aiowps_recaptcha_site_key'));
				$captcha_form = '<div class="g-recaptcha-wrap" style="padding:10px 0 10px 0"><div '. $wc_form_id .' class="g-recaptcha" data-sitekey="'.$site_key.'"></div></div>';
				break;
			default:
				return '';
				break;
		}

		if ($return_instead_of_echo) return $captcha_form;
		echo $captcha_form;
	}

	/**
	 * Verifies the math or Google reCAPTCHA v2 forms
	 * Returns TRUE if correct answer.
	 * Returns FALSE on wrong CAPTCHA result or missing data.
	 *
	 * @return boolean
	 */
	public function verify_captcha_submit() {
		global $aio_wp_security;
		
		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');

		switch ($default_captcha) {
			case 'cloudflare-turnstile':
				// Cloudflare Turnstile enabled
				if ('1' == $aio_wp_security->configs->get_value('aios_cloudflare_turnstile_invalid_configuration')) return true;

				// Expected CAPTCHA field in $_POST but got none!
				if (!array_key_exists('cf-turnstile-response', $_POST)) return false;
				
				$cf_turnstile_response = isset($_POST['cf-turnstile-response']) ? stripslashes($_POST['cf-turnstile-response']) : '';
				$verify_captcha = $this->verify_turnstile_recaptcha($cf_turnstile_response);
				return $verify_captcha;
				break;
			case 'google-recaptcha-v2':
				// Google reCAPTCHA enabled
				if ('1' == $aio_wp_security->configs->get_value('aios_google_recaptcha_invalid_configuration')) return true;

				// Expected CAPTCHA field in $_POST but got none!
				if (!array_key_exists('g-recaptcha-response', $_POST)) return false;

				$g_recaptcha_response = isset($_POST['g-recaptcha-response']) ? stripslashes($_POST['g-recaptcha-response']) : '';
				$verify_captcha = $this->verify_google_recaptcha($g_recaptcha_response);
				return $verify_captcha;
				break;
			case 'simple-math':
				// Math CAPTCHA is enabled
				if (!array_key_exists('aiowps-captcha-answer', $_POST)) return false;
				$captcha_answer = isset($_POST['aiowps-captcha-answer']) ? stripslashes($_POST['aiowps-captcha-answer']) : '';

				$verify_captcha = $this->verify_math_captcha_answer($captcha_answer);
				return $verify_captcha;
				break;
			default:
				return true;
				break;
		}
	}

	/**
	 * Verifies the math CAPTCHA answer entered by the user
	 *
	 * @param type $captcha_answer
	 *
	 * @return boolean
	 */
	private function verify_math_captcha_answer($captcha_answer = '') {
		global $aio_wp_security;
		$captcha_secret_string = $aio_wp_security->configs->get_value('aiowps_captcha_secret_key');
		$captcha_temp_string = sanitize_text_field($_POST['aiowps-captcha-temp-string']);
		$submitted_encoded_string = base64_encode($captcha_temp_string.$captcha_secret_string.$captcha_answer);
		$trans_handle = sanitize_text_field($_POST['aiowps-captcha-string-info']);
		if (is_multisite()) {
			$captcha_string_info_option = get_site_option('aiowps_captcha_string_info_'.$trans_handle);
			delete_site_option('aiowps_captcha_string_info_'.$trans_handle);
			delete_site_option('aiowps_captcha_string_info_time_'.$trans_handle);
		} else {
			$captcha_string_info_option = get_option('aiowps_captcha_string_info_'.$trans_handle);
			delete_option('aiowps_captcha_string_info_'.$trans_handle);
			delete_option('aiowps_captcha_string_info_time_'.$trans_handle);
		}
		if ($submitted_encoded_string === $captcha_string_info_option) {
			return true;
		} else {
			return false; // wrong answer was entered
		}
	}

	/**
	 * Send a query to Cloudflare API to verify Turnstile submission
	 *
	 * @param string $resp_token
	 *
	 * @return boolean
	 */
	private function verify_turnstile_recaptcha($resp_token = '') {
		global $aio_wp_security;

		$url = $this->cloudflare_verify_turnstile_url;
		$secret = $aio_wp_security->configs->get_value('aiowps_turnstile_secret_key');
		return $this->verify_captcha_response($url, $secret, $resp_token);
	}

	/**
	 * Send a query to Google API to verify reCAPTCHA submission
	 *
	 * @param string $resp_token
	 *
	 * @return boolean
	 */
	private function verify_google_recaptcha($resp_token = '') {
		global $aio_wp_security;

		$url = $this->google_verify_recaptcha_url;
		$secret = $aio_wp_security->configs->get_value('aiowps_recaptcha_secret_key');
		return $this->verify_captcha_response($url, $secret, $resp_token);
	}

	/**
	 * This function sends a remote request to verify the captcha response.
	 *
	 * @param string $url        - The URL to the CAPTCHA API.
	 * @param string $secret     - The secret key you got from the CAPTCHA provider.
	 * @param string $resp_token - The value of the CAPTCHA response form field.
	 *
	 * @return boolean - true if valid otherwise false
	 */
	private function verify_captcha_response($url, $secret, $resp_token) {
		
		$is_humanoid = false;

		if (empty($resp_token)) return $is_humanoid;

		$ip_address = AIOWPSecurity_Utility_IP::get_user_ip_address();
		$response = wp_safe_remote_post($url, array(
			'body' => array(
				'secret' => $secret,
				'response' => $resp_token,
				'remoteip' => $ip_address,
			),
		));

		if (wp_remote_retrieve_response_code($response) != 200) return $is_humanoid;

		$response = wp_remote_retrieve_body($response);
		$response = json_decode($response, true);
		
		if (isset($response['success']) && true == $response['success']) $is_humanoid = true;

		return $is_humanoid;
	}

	/**
	 *  Get site locale code for Google reCaptcha.
	 *
	 * @return string The site locale code.
	 */
	private function get_google_recaptcha_compatible_site_locale() {
		$google_recaptcha_locale_codes = AIOS_Abstracted_Ids::get_google_recaptcha_locale_codes();
		$locale = str_replace('_', '-', determine_locale());

		if (in_array($locale, $google_recaptcha_locale_codes, true)) {
			return $locale;
		}

		// Return 2 letter locale code.
		$locale = explode('-', $locale);
		return $locale[0];
	}

	/**
	 * Verify Google reCAPTCHA configuration.
	 *
	 * @param String $site_key
	 * @param String $secret_key
	 *
	 * @return Boolean
	 */
	public function google_recaptcha_verify_configuration($site_key, $secret_key) {
		$site_key_verify_params = array('k' => $site_key, 'size' => 'checkbox');
		$site_key_verify_url = esc_url(add_query_arg($site_key_verify_params, 'https://www.google.com/recaptcha/api2/anchor'));
		$site_key_verify_response_body = wp_remote_retrieve_body(wp_remote_get($site_key_verify_url));

		$secret_key_verify_params = array('secret' => $secret_key);
		$secret_key_verify_url = esc_url(add_query_arg($secret_key_verify_params, $this->google_verify_recaptcha_url));
		$secret_key_verify_response_body = wp_remote_retrieve_body(wp_remote_get($secret_key_verify_url));
		$secret_key_verify_json = json_decode($secret_key_verify_response_body, true);

		if (false !== strpos($site_key_verify_response_body, 'Invalid site key') || is_null($secret_key_verify_json) || (isset($secret_key_verify_json['error-codes']) && in_array('invalid-input-secret', $secret_key_verify_json['error-codes']))) {
			return false;
		} else {
			return true;
		}
	}

}
