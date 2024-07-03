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
use WPCF7_ContactForm; //phpcs:ignore
use WPCF7_Submission; //phpcs:ignore
use WPNTS\Inc\Formflow; //phpcs:ignore

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Update used to rest route created
 *
 * @since 1.0.0
 */
class Integration {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$wpnts_db_instance = new DB();
		$is_active = $wpnts_db_instance->is_pro_active();
		$schedules_int = get_option( 'wpntswebhook_integration_settings');
		$schedules_interval = json_decode($schedules_int);

		$formflow_webhook = $schedules_interval->formflow_webhook ?? '';
		$formflow_active_notice = $schedules_interval->formflow_active_notice ?? 'false';
		$formflow_get_leads_with_notice = $schedules_interval->formflow_get_leads_with_notice ?? 'false';

		$cf7_webhook = $schedules_interval->cf7_webhook ?? '';
		$cf7_active_notice = $schedules_interval->cf7_active_notice ?? 'false';
		$cf7_get_leads_with_notice = $schedules_interval->cf7_get_leads_with_notice ?? 'false';

		if ( true === $cf7_active_notice || true === $cf7_get_leads_with_notice ) {
			add_action('wpcf7_mail_sent', [ $this, 'wpnts_cf7_integration'] );
		}

		if ( true === $formflow_active_notice || true === $formflow_get_leads_with_notice ) {
			add_action('formflow_form_submit', [$this, 'form_submit_action'], 10, 1);
		}

		
	}

	/**
	 * Integration activation
	 */
	public function wpnts_cf7_integration($contact_form) {

		$schedules_int = get_option( 'wpntswebhook_integration_settings');
		$schedules_interval = json_decode($schedules_int);
		$cf7_active_notice = $schedules_interval->cf7_active_notice ?? 'false';
		$cf7_get_leads_with_notice = $schedules_interval->cf7_get_leads_with_notice ?? 'false';
		

		$submission = WPCF7_Submission::get_instance();
		if ($submission) {
			$posted_data = $submission->get_posted_data();
			$contact_forms_id = $contact_form->id();

			$current_time = current_time('Y-m-d H:i:s');

			$formatted_data = '';
			foreach ($posted_data as $key => $value) {
				$formatted_data .= "*$key:* $value\n";
			}
	
			// Send attachments to Slack
			$attachments = [
				[
					'fallback' => 'Form Data',
					'color'    => '#36a64f',
					'text'     => "New Form Submission: Form ID - $contact_forms_id\n*Form Data:*\n$formatted_data",
					'mrkdwn_in' => ['text'],
				]
			];
			
			
			// Send to Slack if cf7_get_leads_with_notice is true
			if ( true === $cf7_get_leads_with_notice) {
				$message = "Contact Form 7 Form (ID: $contact_forms_id) submitted at $current_time\n";
				$message .= "Form ID - $contact_forms_id\n*Form Data:*\n$formatted_data";
				$this->wpnts_notify_slack($message);
			} elseif ( true === $cf7_active_notice) {
				$message = "Contact Form 7 Form (ID: $contact_forms_id) submitted at $current_time";
				$this->wpnts_notify_slack($message);
			}
			
			
		}
	}

	public function form_submit_action ( $contact ){

		$schedules_int = get_option( 'wpntswebhook_integration_settings');
		$schedules_interval = json_decode($schedules_int);
		$formflow_active_notice = $schedules_interval->formflow_active_notice ?? 'false';
		$formflow_get_leads_with_notice = $schedules_interval->formflow_get_leads_with_notice ?? 'false';
		
		$formatted_data = '';
		foreach ( $contact['fields'] as $key => $value ) {
			$formatted_data .= "*$key:* $value\n";
		}

		$current_time = current_time( 'Y-m-d H:i:s' );

		// Send attachments to Slack
		$attachments = [
			[
				'fallback'   => 'Form Data',
				'color'      => '#36a64f',
				'text'       => "New Formflow Submission: Form ID - {$contact['form_id']}\n*Form Data:*\n$formatted_data",
				'mrkdwn_in'  => [ 'text' ],
			]
		];

		// Send to Slack if formflow_get_leads_with_notice is true
		if ( true === $formflow_get_leads_with_notice ) {
			$message = "Formflow Form (ID: {$contact['form_id']}) submitted at $current_time\n";
			$message .= "Form ID - {$contact['form_id']}\n*Form Data:*\n$formatted_data";
			$this->wpnts_formflow_notify_slack( $message );
		} elseif ( true === $formflow_active_notice ) {
			$message = "Formflow Form (ID: {$contact['form_id']}) submitted at $current_time";
			$this->wpnts_formflow_notify_slack( $message );
		}
	}


	/**
	 * Send to Slack
	 */
	private function wpnts_notify_slack($message) {

		$schedules_int = get_option('wpntswebhook_integration_settings');
		$schedules_interval = json_decode($schedules_int);
		$slack_webhook_url = $schedules_interval->cf7_webhook;

		$payload = json_encode(['text' => $message]);
		$args = [
			'body'      => $payload,
			'headers'   => ['Content-Type' => 'application/json'],
			'timeout'   => '5',
			'sslverify' => false,
		];
		$response = wp_remote_post($slack_webhook_url, $args);

	}

	/**
	 * Send formflow leads
	 */
	private function wpnts_formflow_notify_slack($message) {

		$schedules_int = get_option('wpntswebhook_integration_settings');
		$schedules_interval = json_decode($schedules_int);
		$slack_webhook_url = $schedules_interval->formflow_webhook;

		$payload = json_encode(['text' => $message]);
		$args = [
			'body'      => $payload,
			'headers'   => ['Content-Type' => 'application/json'],
			'timeout'   => '5',
			'sslverify' => false,
		];
		$response = wp_remote_post($slack_webhook_url, $args);

	}

}
