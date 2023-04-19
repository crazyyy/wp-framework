<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_WP_Footer_Content {

	public function __construct() {
		//Add content that need to be outputted in the footer area.

		global $aio_wp_security;
		
		// For WooCommerce forms.
		// Only proceed if WooCommerce installed and active
		if (AIOWPSecurity_Utility::is_woocommerce_plugin_active()) {
			if ($aio_wp_security->configs->get_value('aiowps_enable_woo_login_captcha') == '1' || $aio_wp_security->configs->get_value('aiowps_enable_woo_register_captcha') == '1' || $aio_wp_security->configs->get_value('aiowps_enable_woo_lostpassword_captcha') == '1') {
				$aio_wp_security->captcha_obj->print_captcha_api_woo();
			}
		}
		
		// For custom wp login form
		if ($aio_wp_security->configs->get_value('aiowps_enable_custom_login_captcha') == '1') {
			$aio_wp_security->captcha_obj->print_captcha_api_custom_login();
		}

		// Activate the copy protection feature for non-admin users
		$copy_protection_active = $aio_wp_security->configs->get_value('aiowps_copy_protection') == '1';
		if ($copy_protection_active && !AIOWPSecurity_Utility_Permissions::has_manage_cap()) {
			$this->output_copy_protection_code();
		}
		
		//TODO - add other footer output content here
	}

	public function output_copy_protection_code() {
		?>
		<meta http-equiv="imagetoolbar" content="no"><!-- disable image toolbar (if any) -->
		<style>
			:root {
				-webkit-user-select: none;
				-webkit-touch-callout: none;
				-ms-user-select: none;
				-moz-user-select: none;
				user-select: none;
			}
		</style>
		<script type="text/javascript">
			/*<![CDATA[*/
			document.oncontextmenu = function(event) {
				if (event.target.tagName != 'INPUT' && event.target.tagName != 'TEXTAREA') {
					event.preventDefault();
				}
			};
			document.ondragstart = function() {
				if (event.target.tagName != 'INPUT' && event.target.tagName != 'TEXTAREA') {
					event.preventDefault();
				}
			};
			/*]]>*/
		</script>
		<?php
	}
}//End of class
