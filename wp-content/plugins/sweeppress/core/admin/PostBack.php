<?php

namespace Dev4Press\Plugin\SweepPress\Admin;

use Dev4Press\v42\Core\Quick\WPR;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostBack extends \Dev4Press\v42\Core\Admin\PostBack {
	protected function process() {
		parent::process();

		if ( $this->p() == $this->get_page_name( 'tools' ) ) {
			$this->check_referer( 'tools' );
		}

		do_action( 'sweeppress_admin_postback_handler', $this->p() );
	}

	protected function remove() {
		$data = isset( $_POST['sweeppress-tools'] ) ? sweeppress_sanitize_keys_based_array( $_POST['sweeppress-tools'] ) : array();

		$remove  = isset( $data['remove'] ) ? (array) $data['remove'] : array();
		$message = 'nothing-removed';

		if ( ! empty( $remove ) ) {
			$groups = array( 'settings', 'sweepers', 'statistics' );

			foreach ( $groups as $group ) {
				if ( isset( $remove[ $group ] ) && $remove[ $group ] == 'on' ) {
					$this->a()->settings()->remove_plugin_settings_by_group( $group );
				}
			}

			if ( isset( $remove['disable'] ) && $remove['disable'] == 'on' ) {
				if ( isset( $remove['settings'] ) && $remove['settings'] == 'on' ) {
					$this->a()->settings()->remove_plugin_settings_by_group( 'core' );
				}

				sweeppress()->deactivate();

				wp_redirect( admin_url( 'plugins.php' ) );
				exit;
			}

			$message = 'removed';
		}

		wp_redirect( $this->a()->current_url() . '&message=' . $message );
		exit;
	}
}