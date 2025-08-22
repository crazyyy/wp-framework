<?php

class EHSSL_SSL_Utils {

	public static function get_current_domain() {
		return parse_url( home_url(), PHP_URL_HOST );
	}

	/**
	 * Retrieves the SSL info if have any
	 *
	 * @return array|bool The SSL information array.
	 */
	public static function get_ssl_info( $domain ) {
		$cert_info = [];

		$stream_context = stream_context_create( array(
			"ssl" => array(
				"capture_peer_cert" => true,
				// "verify_peer" => false,       // Disable verification for testing
				// "verify_peer_name" => false,  // Disable hostname verification
				// "allow_self_signed" => true,  // Allow self-signed certs
			)
		) );

		$err_str = '';
		$client = @stream_socket_client( "ssl://" . $domain . ":443", $errno, $err_str, 60, STREAM_CLIENT_CONNECT, $stream_context );

		if ( $client ) {
			$cert     = stream_context_get_params( $client );
			$cert_info = openssl_x509_parse( $cert['options']['ssl']['peer_certificate'] );
		}

		if (!empty($err_str)){
			EHSSL_Logger::log( $err_str, 4 );
		}

		return $cert_info;
	}

	public static function get_parsed_ssl_info($domain) {
		$cert_info = self::get_ssl_info( $domain );

		$parsed_cert_info = array();

		if ( !empty($cert_info) ) {
			$valid_from = $cert_info['validFrom_time_t'];
			$valid_to   = $cert_info['validTo_time_t'];

			// Get certificate issuer.
			$issuer_arr = array();
			$issuer_arr[] = isset($cert_info['issuer']['O'])  ? $cert_info['issuer']['O']  : '';
			$issuer_arr[] = isset($cert_info['issuer']['CN']) ? $cert_info['issuer']['CN'] : '';
			$issuer_arr[] = isset($cert_info['issuer']['C'])  ? $cert_info['issuer']['C']  : '';
			$issuer_arr = array_filter($issuer_arr);

			if (empty($issuer_arr)){
				$issuer = 'Unknown';
			} else {
				$issuer = implode(', ', $issuer_arr);
			}

			$subject    = isset($cert_info['subject']['CN']) ? $cert_info['subject']['CN'] : $domain;
			$cert_hash = md5( $issuer . $valid_from . $valid_to );
			$id = substr( $cert_hash, 0, 7 ); // Generate a short ID for Expiry Certificate list table.

			$parsed_cert_info = array(
				'id'         => $id,
				'label'      => $subject,
				'issuer'     => $issuer,
				'issued_on'  => $valid_from,
				'expires_on' => $valid_to,
				'cert_hash'  => $cert_hash,
			);
		}

		return $parsed_cert_info;
	}

	/**
	 * Get the parsed SSL info if any to display in the dashboard.
	 */
	public static function get_parsed_current_ssl_info_for_dashbaord() {
		$domain = self::get_current_domain();

		$info = self::get_ssl_info( $domain );

		if ( empty($info) ) {
			return false;
		}

		$certinfo = array(
			"Issued To"       => array(
				"Common Name (CN)"         => isset( $info['subject']['CN'] ) ? $info['subject']['CN'] : "N/A",
				"Organization (O)"         => isset( $info['subject']['O'] ) ? $info['subject']['O'] : "N/A",
				"Organizational Unit (OU)" => isset( $info['subject']['OU'] ) ? $info['subject']['OU'] : "N/A",
			),
			"Issued By"       => array(
				"Common Name (CN)"         => isset( $info['issuer']['CN'] ) ? $info['issuer']['CN'] : "N/A",
				"Organization (O)"         => isset( $info['issuer']['O'] ) ? $info['issuer']['O'] : "N/A",
				"Organizational Unit (OU)" => isset( $info['issuer']['OU'] ) ? $info['issuer']['OU'] : "N/A",
				"Country (C)" => isset( $info['issuer']['C'] ) ? $info['issuer']['C'] : "N/A",
			),
			"Validity Period" => array(
				"Issued On"  => isset( $info['validFrom_time_t'] ) ? EHSSL_Utils::parse_timestamp( $info['validFrom_time_t'] ) : "N/A",
				"Expires On" => isset( $info['validTo_time_t'] ) ? EHSSL_Utils::parse_timestamp( $info['validTo_time_t'] ) : "N/A",
			),
			// "SHA-256 Fingerprint" => array(
			//     "Certificate" => "",
			//     "Public Key" => "",
			// ),
		);

		return $certinfo;
	}

	public static function get_certificate_status( $expiry_timestamp ) {
		$expiry = (new DateTime())->setTimestamp(intval($expiry_timestamp));
		$now    = new DateTime();
		$diff   = $now->diff( $expiry );

		if ( $expiry < $now ) {
			return 'expired';
		} elseif ( $diff->days <= 7 ) {
			return 'critical';
		} elseif ( $diff->days <= 30 ) {
			return 'warning';
		} else {
			return 'active';
		}
	}

	public static function get_all_saved_certificates_info() {
		$certs_info = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'ehssl_certs_info',
		));

		$data = [];
		foreach ( $certs_info as $cert_info ) {
			$data[] = array(
				'id' => get_post_meta($cert_info->ID, 'id', true ),
				'label' => get_post_meta($cert_info->ID, 'label', true ),
				'issuer' => get_post_meta($cert_info->ID, 'issuer', true ),
				'issued_on' => get_post_meta($cert_info->ID, 'issued_on', true ),
				'expires_on' => get_post_meta($cert_info->ID, 'expires_on', true ),
			);
		}

		return $data;
	}

	public static function check_and_save_current_cert_info() {
		$domain = self::get_current_domain();

		// Check if manual scan button was clicked. else the method ran using a cron event.
		if (isset($_POST['ehssl_scan_for_ssl_submit'])){
			EHSSL_Logger::log( 'Manually Scanning SSL certificate info for domain: ' . $domain);
		}

		$cert = self::get_parsed_ssl_info($domain);
		if (empty($cert)){
			// No ssl certificate found.
			EHSSL_Logger::log( "No SSL certificate info found for your current domain '".$domain."' !", 1 );
			return;
		}

		$cert_hash = isset($cert['cert_hash']) ? $cert['cert_hash'] : '';

		// Save SSL info as cpt if not saved already.
		$posts = get_posts( array(
			'post_type'      => 'ehssl_certs_info',
			'title'          => $cert_hash,
			'posts_per_page' => 1, // We only need one post
			'exact'          => true, // Ensure an exact title match
			'suppress_filters' => true, // Bypass filters for more predictable results
		) );

		if ( empty( $posts ) ) {
			EHSSL_Logger::log( 'Scanning for SSL certificate info...');

			$post_id = wp_insert_post( array(
				'post_title'    => $cert_hash,
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_type'     => 'ehssl_certs_info',
			) );

			if ( is_wp_error( $post_id ) ) {
				EHSSL_Logger::log($post_id->get_error_message(), 4);
				return;
			}

			update_post_meta($post_id, 'id', $cert['id']);
			update_post_meta($post_id, 'label', $cert['label']);
			update_post_meta($post_id, 'issuer', $cert['issuer']);
			update_post_meta($post_id, 'issued_on', $cert['issued_on']);
			update_post_meta($post_id, 'expires_on', $cert['expires_on']);

			EHSSL_Logger::log( 'New certificate info captured. ID: ' . $cert['id']);
		} else {
			EHSSL_Logger::log( 'Current SSL info already saved. No new SSL certificate info found.');
		}
	}

	public static function check_and_send_notification_emails(){
		$settings = get_option( 'httpsrdrctn_options', array());

		$expiry_notification_enabled = isset( $settings['ehssl_enable_expiry_notification'] ) ? sanitize_text_field( $settings['ehssl_enable_expiry_notification'] ) : '';
		$expiry_notification_email_before_days = isset( $settings['ehssl_expiry_notification_email_before_days'] ) ? sanitize_text_field( $settings['ehssl_expiry_notification_email_before_days'] ) : '';

		if (empty($expiry_notification_enabled) || !is_numeric($expiry_notification_email_before_days)){
			return;
		}

		$domain = self::get_current_domain();

		$cert = self::get_parsed_ssl_info($domain);
		if (empty($cert)){
			// No SSL certificate found.
			return;
		}

		EHSSL_Logger::log( 'Checking if certificate expiry notification email need to be sent...');

		$expiry_timestamp = $cert['expires_on'];

		$expiry = (new DateTime())->setTimestamp( $expiry_timestamp );
		$now    = new DateTime();
		$diff   = $now->diff( $expiry );

		if ( $diff->days > intval($expiry_notification_email_before_days) ) {
			// Still many days left for expiry. Nothing to do.
			EHSSL_Logger::log( 'Certificate expiry date is more than ' . $expiry_notification_email_before_days . ' days away. No email will be sent.');
			return;
		}

		$cert_hash = $cert['cert_hash'];
		$posts = get_posts( array(
			'post_type'      => 'ehssl_certs_info',
			'title'          => $cert_hash,
			'posts_per_page' => 1, // We only need one post
			'exact'          => true, // Ensure an exact title match
			'suppress_filters' => true, // Bypass filters for more predictable results
		) );

		$post = !empty($posts) ? $posts[0] : null;

		// Check whether the notification email has already sent or not.
		if (empty($post) || empty(get_post_meta($post->ID, 'expiry_notification_email_sent', true)) ){
			// Notification email hasn't been sent yet. Send email now.
			$is_sent = EHSSL_Email_handler::send_expiry_notification_email($cert);

			update_post_meta($post->ID, 'expiry_notification_email_sent', $is_sent);
		}
	}

	/**
	 * Should be used for debug purpose only.
	 */
	public static function delete_all_certificate_info() {
		global $wpdb;

		$post_type = 'ehssl_certs_info';

		// Query to get all post IDs of the specified custom post type.
		$post_ids = $wpdb->get_col( $wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = %s",
			$post_type
		) );

		if ( $post_ids ) {
			foreach ( $post_ids as $post_id ) {
				/**
				 * wp_delete_post() permanently deletes a post.
				 * The second parameter, 'true', forces deletion bypassing the Trash.
				 */
				wp_delete_post( $post_id, true );
			}

			EHSSL_Logger::log('SSL certificate info was deleted successfully.');

			return true;
		}

		// No saved ssl certificates info found.
		EHSSL_Logger::log('No saved SSL certificate info was detected for deletion.');
		return false;
	}

}