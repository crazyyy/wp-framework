<?php

if ( ! class_exists( 'ITSEC_Malware_Setup' ) ) {

	class ITSEC_Malware_Setup {

		private
			$defaults;

		public function __construct() {

			global $itsec_setup_action;

			$this->defaults = array(
				'enabled' => false,
				'api_key' => '',
			);

			if ( isset( $itsec_setup_action ) ) {

				switch ( $itsec_setup_action ) {

					case 'activate':
						$this->execute_activate();
						break;
					case 'upgrade':
						$this->execute_upgrade();
						break;
					case 'deactivate':
						$this->execute_deactivate();
						break;
					case 'uninstall':
						$this->execute_uninstall();
						break;

				}

			} else {
				wp_die( 'error' );
			}

		}

		/**
		 * Execute module activation.
		 *
		 * @since 4.0
		 *
		 * @return void
		 */
		public function execute_activate() {

			$options = get_site_option( 'itsec_malware' );

			if ( $options === false ) {

				add_site_option( 'itsec_malware', $this->defaults );

			}

		}

		/**
		 * Execute module deactivation
		 *
		 * @return void
		 */
		public function execute_deactivate() {
		}

		/**
		 * Execute module uninstall
		 *
		 * @return void
		 */
		public function execute_uninstall() {

			$this->execute_deactivate();

			delete_site_option( 'itsec_malware' );

		}

		/**
		 * Execute module upgrade
		 *
		 * @return void
		 */
		public function execute_upgrade() {

		}

	}

}

new ITSEC_Malware_Setup();