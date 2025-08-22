<?php

class EHSSL_Email_handler {

	public static function send_expiry_notification_email( $cert_data ) {
		$settings = get_option( 'httpsrdrctn_options', array() );

		$content_type = isset( $settings['ehssl_expiry_notification_email_content_type'] ) ? sanitize_text_field( $settings['ehssl_expiry_notification_email_content_type'] ) : '';
		$from         = isset( $settings['ehssl_expiry_notification_email_from'] ) ? sanitize_text_field( $settings['ehssl_expiry_notification_email_from'] ) : '';
		$to           = isset( $settings['ehssl_expiry_notification_email_to'] ) ? sanitize_email( $settings['ehssl_expiry_notification_email_to'] ) : '';

		if ( empty( $to ) ) {
			EHSSL_Logger::log( 'Recipient email address could not be found to send expiry notification email.', 4 );

			return false;
		}

		$subj = isset( $settings['ehssl_expiry_notification_email_subject'] ) ? sanitize_text_field( $settings['ehssl_expiry_notification_email_subject'] ) : '';

		$body = isset( $settings['ehssl_expiry_notification_email_body'] ) ? sanitize_textarea_field( $settings['ehssl_expiry_notification_email_body'] ) : '';
		$body = self::apply_dynamic_tags( $body, $cert_data );

		$headers = array();
		if ( ! empty( $content_type ) && $content_type === 'html' ) {
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$body      = nl2br( $body );
		}
		$headers[] = 'From: ' . $from;

		try {
			wp_mail( $to, $subj, $body, $headers );
			EHSSL_Logger::log( 'SSL certificate expiry notification email sent to : ' . $to . ', From email address used: ' . $from );

			return true;
		} catch ( \Exception $e ) {
			EHSSL_Logger::log( 'SSL certificate expiry notification email couldn\'t be sent to : ' . $to . ', From email address used: ' . $from, 4 );
		}

		return false;
	}

	public static function apply_dynamic_tags( $body, $data ) {
		$tags = array(
			'{label}',
			'{issuer}',
			'{issue_date}',
			'{issue_time}',
			'{issue_datetime}',
			'{expiry_date}',
			'{expiry_time}',
			'{expiry_datetime}',
			'{status}',
		);

		$values = array(
			$data['label'],
			$data['issuer'],
			EHSSL_Utils::parse_date( $data['issued_on'] ),
			EHSSL_Utils::parse_time( $data['issued_on'] ),
			EHSSL_Utils::parse_timestamp( $data['issued_on'] ),
			EHSSL_Utils::parse_date( $data['expires_on'] ),
			EHSSL_Utils::parse_time( $data['expires_on'] ),
			EHSSL_Utils::parse_timestamp( $data['expires_on'] ),
			ucfirst( EHSSL_SSL_Utils::get_certificate_status( $data['expires_on'] ) ),
		);

		return stripslashes( str_replace( $tags, $values, $body ) );
	}

	public static function get_merge_tags_hints() {
		ob_start()
		?>
        <div class="ehssl-settings-field-cat-3">
            <a href="#" class="ehssl-toggle toggled-off"> <?php _e( 'Click here to toggle email merge tag hints', 'https-redirection' ) ?></a>
            <div class="ehssl-tags-table-cont hidden">
                <table class="ehssl-tags-hint widefat striped">
                    <tbody>
                    <tr>
                        <td class="ehssl-tag-name"><b>{label}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The SSL certificate label', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{issuer}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The issuer of SSL certificate', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{issue_date}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The issuing date of SSL certificate.', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{issue_time}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The issuing time of SSL certificate.', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{issue_datetime}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The issuing datetime of SSL certificate.', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{expiry_date}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The expiry date of SSL certificate.', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{expiry_time}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The expiry time of SSL certificate.', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{expiry_datetime}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The expiry datetime of SSL certificate.', 'https-redirection') ?></td>
                    </tr>
                    <tr>
                        <td class="ehssl-tag-name"><b>{status}</b></td>
                        <td class="ehssl-tag-descr"><?php _e('The current status of SSL certificate.', 'https-redirection') ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}
}