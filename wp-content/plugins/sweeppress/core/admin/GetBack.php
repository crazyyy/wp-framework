<?php

namespace Dev4Press\Plugin\SweepPress\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GetBack extends \Dev4Press\v42\Core\Admin\GetBack {
	protected function process() {
		parent::process();

		if ( ! empty( $this->a()->panel ) ) {
			if ( $this->is_single_action( 'disable-backups-notice', 'action' ) ) {
				$this->disable_backups_notice();
			}
		}

		if ( $this->a()->panel == 'tools' ) {
			if ( $this->is_single_action( 'purge-cache' ) ) {
				$this->tools_purge_cache();
			}
		}

		do_action( 'sweeppress_admin_getback_handler', $this->a()->panel );
	}

	private function tools_purge_cache() {
		check_admin_referer( 'sweeppress-purge-cache' );

		sweeppress_settings()->purge_sweeper_cache();

		wp_redirect( $this->a()->current_url( false ) . '&message=cache-purged' );
		exit;
	}

	private function disable_backups_notice() {
		$nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( $_GET['_wpnonce'] ) : '';

		if ( wp_verify_nonce( $nonce, 'sweeppress-disable-backups-notice' ) ) {
			sweeppress_settings()->set( 'hide_backup_notices', true, 'settings', true );
		}

		wp_redirect( $this->a()->current_url( true ) );
		exit;
	}
}
