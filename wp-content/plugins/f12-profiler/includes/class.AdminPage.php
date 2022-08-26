<?php

namespace f12_profiler\includes {
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

	use f12_profiler\Profiler;

	require_once( 'class.HardwareController.php' );

	/**
	 * Class AdminPage
	 * @package f12_profiler\includes
	 */
	class AdminPage {
		/**
		 * @var $_instance AdminPage
		 */
		private static $_instance = null;

		/**
		 * @return AdminPage
		 */
		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new AdminPage();
			}

			return self::$_instance;
		}

		/**
		 * AdminPage constructor.
		 */
		private function __construct() {
			add_action( 'admin_menu', array( $this, 'wp_AddPage' ), 10, 0 );

			if ( isset( $_POST['f12_profiler_save'] ) ) {
				$this->saveOptions();
			}
		}

		/**
		 * Save the new settings to the database
		 */
		private function saveOptions() {
			$options = Profiler::getOptions( false );

			foreach ( $options as $key => $value ) {
				if ( isset( $_POST[ $key ] ) ) {
					switch ( $key ) {
						case 'active':
							$options[ $key ] = intval( $_POST[ $key ] );
							break;
						case 'page_metrics':
							$options[ $key ] = intval( $_POST[ $key ] );
							break;
						case 'hardware_metrics':
							$options[ $key ] = intval( $_POST[ $key ] );
							break;
						default:
							$options[ $key ] = esc_attr( $_POST[ $key ] );
							break;
					}
				}
			}

			update_option( 'f12_profiler_settings', $options );
		}

		/**
		 * The Admin Page responsible to manage the plugin
		 */
		public function wp_addPage() {
			add_submenu_page( 'tools.php', __( 'F12-Profiler', 'f12_profiler' ),
				__( 'F12-Profiler', 'f12_profiler' ),
				'manage_options', 'f12p',
				array( $this, 'wp_showPage' ), 99 );
		}

		/**
		 * display the option page
		 */
		public function wp_showPage() {
			$atts = Profiler::getOptions();


			if ( intval( $atts['hardware_metrics'] ) == 1 ) {
				$data = HardwareController::getInstance()->getData();

				$atts['hardware'] = [
					'CPU'            => json_encode( $data['CPU'] ),
					'RAM_PERCENTAGE' => json_encode( $data['RAM_PERCENTAGE'] ),
					'RAM_PHP'        => json_encode( $data['RAM_PHP'] ),
					'RAM_TOTAL'      => $data['RAM_TOTAL'],
					'RAM_USAGE'      => $data['RAM_USAGE'],
					'ACTIVE'         => $data['isLoaded']
				];

				$atts['hardware'] = Template::getInstance()->getTemplate( 'hardware', $atts );
			}

			echo Template::getInstance()->getTemplate( 'admin', $atts );
		}
	}
}