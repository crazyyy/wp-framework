<?php
/**
 * Admin Chat Box Rest Route
 *
 * This class is used to response and all rest route works
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use WPNTS\Inc\nts_fs;
use WPNTS\Inc\Activate;
use WPNTS\Inc\Deactivate;
use WPNTS\Inc\Database\DB;
use WPNTS\Inc\SlackAttachment;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Capcha used to rest route created
 *
 * @since 1.0.0
 */
class Capcha {
	private $active_captcha;
	private $sitekeys;
	private $secretkey;
	private $submitBtnaccess;
	private $turnstiletheme;
	private $customMessage;
	private $wplogin;
	private $wpregister;
	private $wpresetpass;
	private $wpcomment;
	private $woomyaccountlogin;
	private $woolostresetpass;
	private $is_validated;

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$wpnts_db_instance = new DB();
		$is_active = $wpnts_db_instance->is_pro_active();
		$schedules_int = get_option( 'wpnts_captcha_settings');
		$schedules_interval = json_decode($schedules_int);

		$active_captcha = $schedules_interval->active_captcha ?? 'false';
		$this->active_captcha = $active_captcha;

		$sitekeys = $schedules_interval->sitekeys ?? '';
		$this->sitekeys = $sitekeys;

		$secretkey = $schedules_interval->secretkey ?? '';
		$this->secretkey = $secretkey;

		$submitBtnaccess = $schedules_interval->submitBtnaccess ?? 'false';
		$this->submitBtnaccess = $submitBtnaccess;

		$turnstiletheme = $schedules_interval->turnstiletheme ?? 'light';
		$this->turnstiletheme = $turnstiletheme;

		$customMessage = $schedules_interval->customMessage ?? 'false';
		$this->customMessage = $customMessage;

		$wplogin = $schedules_interval->wplogin ?? 'false';
		$this->wplogin = $wplogin;

		$wpregister = $schedules_interval->wpregister ?? 'false';
		$this->wpregister = $wpregister;

		$wpresetpass = $schedules_interval->wpresetpass ?? 'false';
		$this->wpresetpass = $wpresetpass;

		$wpcomment = $schedules_interval->wpcomment ?? 'false';
		$this->wpcomment = $wpcomment;

		$woomyaccountlogin = $schedules_interval->woomyaccountlogin ?? 'false';
		$this->woomyaccountlogin = $woomyaccountlogin;

		$woolostresetpass = $schedules_interval->woolostresetpass ?? 'false';
		$this->woolostresetpass = $woolostresetpass;

		// Action hook for plugin activated.
		if ( true === $active_captcha ) {
			add_action( 'init', [ $this, 'initialize' ] );
		}
	}

	public function initialize() {
		$this->integrate_cloudflare_turnstile();
		$this->enqueue_assets();
	}

	private function enqueue_assets() {
		wp_enqueue_script(
			'notifier-admin-custom',
			WP_NOTIFIER_TO_SLACK_DIR_URL . 'assets/captcha/sf-captcha.js',
			[ 'jquery' ],
			time(),
			true
		);

		wp_localize_script(
			'notifier-admin-custom',
			'NOTIFIER_TURNSTILE_OBJ',
			[ 'CF_SITE_KEY' => $this->sitekeys ]
		);
	}



	/**
	 * Integrate Cloudflare Turnstile into specified WordPress actions.
	 *
	 * @since 1.0.0
	 */
	private function integrate_cloudflare_turnstile() {

		// Add Cloudflare Turnstile to WordPress login if enabled.
		if ( true === wp_validate_boolean($this->wplogin) ) {
			add_action('login_form', [ $this, 'add_cloudflare_turnstile' ]);
		}

		// Add Cloudflare Turnstile to WordPress register if enabled.
		if ( true === wp_validate_boolean($this->wpregister) ) {
			add_action('register_form', [ $this, 'add_cloudflare_turnstile' ]);

		}

		// Add Cloudflare Turnstile to WordPress reset password if enabled.
		if ( true === wp_validate_boolean($this->wpresetpass) ) {
			add_action('lostpassword_form', [ $this, 'add_cloudflare_turnstile' ]);
		}

		// Add Cloudflare Turnstile to WordPress comments if enabled.
		if ( true === wp_validate_boolean($this->wpcomment) ) {
			add_action('comment_form_after_fields', [ $this, 'add_cloudflare_turnstile' ]);
		}

		// Add Cloudflare Turnstile to WooCommerce login if enabled.
		if ( true === wp_validate_boolean($this->woomyaccountlogin) ) {
			add_action('woocommerce_login_form', [ $this, 'add_cloudflare_turnstile' ]);
			add_action('woocommerce_register_form', [ $this, 'add_cloudflare_turnstile' ]);
		}

		// Add Cloudflare Turnstile to WooCommerce lost password if enabled.
		if ( true === wp_validate_boolean($this->woolostresetpass) ) {
			add_action('woocommerce_lostpassword_form', [ $this, 'add_cloudflare_turnstile' ]);
		}
	}


	/**
	 * Placeholder method to add Cloudflare Turnstile to a specific action.
	 *
	 * Replace this method with the actual integration code for Cloudflare Turnstile.
	 *
	 * @since 1.0.0
	 */
	public function add_cloudflare_turnstile() {
		// Get the Cloudflare Turnstile API endpoint
		$challenges_url = 'https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback&render=explicit';

		// Enqueue Cloudflare Turnstile API script
		wp_enqueue_script('notifier-turnstile-api', $challenges_url, [], '0', true);

		// Output the Turnstile container on the frontend
		$this->render_turnstile_container();
	}


	/**
	 * Render the Cloudflare Turnstile container on the frontend.
	 *
	 * @since 1.0.0
	 */

	private function render_turnstile_container() {
		$button_access = wp_validate_boolean($this->submitBtnaccess);

		// Output the Turnstile container
		$html = '<div class="nf-turnstile-container" id="notifier-turnstile-container" data-theme="' .
			esc_attr($this->turnstiletheme) . '" data-submit-button="' .
			esc_attr($button_access) . '" data-action="notifier-turnstile-container" data-size="normal"></div>';

		// Add custom styles to disable form submit buttons
		$html .= '<style>
			.submit input[type="submit"],
			input[name="wc_reset_password"] + button.woocommerce-Button,
			.woocommerce button[type="submit"], .form-submit{
				pointer-events: none;
				opacity: .5;
			}
		</style>';

		// Sanitize and allow certain HTML tags
		$allowed_tags = wp_kses_allowed_html('post');
		$allowed_tags['style'] = $allowed_tags;
		echo wp_kses($html, $allowed_tags);
	}
}
