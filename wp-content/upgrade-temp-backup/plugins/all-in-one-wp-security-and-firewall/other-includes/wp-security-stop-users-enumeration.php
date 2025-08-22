<?php
/**
 * Merged by Davide Giunchi, from plugin "Stop User Enumeration"
 */

if (!is_admin() && isset($_SERVER['REQUEST_URI'])) {
	if (preg_match('/(wp-comments-post)/', sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']))) === 0 && !empty($_REQUEST['author'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. No nonce available.
		wp_die(esc_html__('Accessing author info via link is forbidden', 'all-in-one-wp-security-and-firewall'), 403);
	}
}
