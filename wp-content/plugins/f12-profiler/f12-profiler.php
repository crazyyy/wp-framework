<?php

namespace f12_profiler {

	use f12_profiler\includes\AdminPage;
	use WP_Hook;
	/**
	 * @package f12-profiler
	 */
	/*
	Plugin Name: F12 Profiler
	Description: Used to keep track on the execution time of the plugins and themes.
	Version: 1.3.9
	Author: Forge12 Interactive GmbH
	Author URI: https://www.forge12.com
	License: GPLv2 or later
	Text Domain: f12_profiler
	*/
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

	define( 'F12_PROFILER_NAME', 'F12-Profiler' );
	define( 'F12_PROFILER_PACKAGE', 'f12_profiler' );
	define( 'F12_PROFILER_VERSION', '1.3.9' );
	define( 'F12_PROFILER_MINIMUM_WP_VERSION', '4.9' );
	define( 'F12_PROFILER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'F12_PROFILER_MINIMUM_PHP_VERSION', '7.0' );

	if ( version_compare( phpversion(), F12_PROFILER_MINIMUM_PHP_VERSION, '<' ) ) {
		Profiler::disableOnPHPVersionMissmatch();
		//wp_die( 'F12 Profiler requires at least PHP ' . F12_PROFILER_MINIMUM_PHP_VERSION );
	}

	global $wp_version;
	if ( version_compare( $wp_version, F12_PROFILER_MINIMUM_WP_VERSION, '<' ) ) {
		wp_die( 'F12 Profiler requires at least WordPress Version' . F12_PROFILER_MINIMUM_WP_VERSION );
	}

	/**
	 * Class Profiler
	 * @package f12_profiler
	 */
	class Profiler {
		/**
		 * Safe the instance
		 * @var $_instance Profiler
		 */
		private static $_instance = null;

		/**
		 * Count of last numbers of filters
		 */
		private static $number_filters = 0;

		/**
		 * Create a singleton Profiler
		 * @return Profiler
		 */
		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new Profiler();
			}

			return self::$_instance;
		}

		/**
		 * Profiler constructor.
		 */
		private function __construct() {
			AdminPage::getInstance();

			add_action( 'admin_enqueue_scripts', array( $this, 'addAdminStyles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'addAdminScripts' ) );

			if ( Profiler::getOptions()['active'] ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'addStyles' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'addScripts' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'addScripts' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'addStyles' ) );
				add_action( 'admin_bar_menu', array( $this, 'addToolbar' ), 999 );

				/**
				 * Init the hooks
				 */
				Profiler::updateWordpressHooks();
			}
		}

		/**
		 * Add Admin Scripts
		 */
		public function addAdminScripts( $hook ) {
			if ( Profiler::getOptions()['page_metrics'] ) {
				wp_enqueue_script( 'f12p_measure', plugin_dir_url( __FILE__ ) . 'assets/measure.js', array( 'jquery' ) );
				wp_enqueue_script( 'f12p_measure_async', plugin_dir_url( __FILE__ ) . 'assets/measure_async.js', array( 'jquery' ) );
			}

			if ( Profiler::getOptions()['hardware_metrics'] && $hook == 'tools_page_f12p' ) {
				wp_enqueue_script( 'Chart', plugin_dir_url( __FILE__ ) . 'assets/Chart.js', array( 'jquery' ) );
				wp_enqueue_script( 'Hardware', plugin_dir_url( __FILE__ ) . 'assets/hardware.js', array( 'jquery' ) );
			}
		}

		/**
		 * Add CSS
		 */
		public function addAdminStyles() {
			wp_enqueue_style( 'f12p', plugin_dir_url( __FILE__ ) . 'assets/admin.css' );
			if ( Profiler::getOptions()['hardware_metrics'] ) {
				wp_enqueue_style( 'charts', plugin_dir_url( __FILE__ ) . 'assets/Chart.css' );
			}
		}

		/**
		 * Add CSS
		 */
		public function addStyles() {
			wp_enqueue_style( 'f12p_plugins', plugin_dir_url( __FILE__ ) . 'assets/style.css' );
		}

		/**
		 * Updated by alx359 on Version 1.2.2 to ensure the js files for the resources metrics
		 * are only loaded if activated. This optimizes the performance and adds additional options
		 * for the usesr.
		 *
		 * @since v1.2.2
		 */
		public function addScripts() {
			if ( Profiler::getOptions()['page_metrics'] ) {
				wp_enqueue_script( 'f12p_measure', plugin_dir_url( __FILE__ ) . 'assets/measure.js', array( 'jquery' ) );
			}
		}

		/**
		 * Load all options from the database
		 * @return array
		 */
		public static function getOptions( $incData = true ) {
			$options = [
				'active'           => 0,
				'page_metrics'     => 0,
				'hardware_metrics' => 0,
			];

			if ( $incData == false ) {
				return $options;
			}

			$data = get_option( 'f12_profiler_settings' );

			foreach ( $options as $key => $value ) {
				if ( isset( $data[ $key ] ) ) {
					$options[ $key ] = $data[ $key ];
				}
			}

			return $options;
		}

		/**
		 * this function will be called if there is a missmatch of the php version
		 * after installing the plugin before. For example if the user uses php7+ and changes
		 * back to php5.6, we need to ensure the plugin will be disabled to do not
		 * interrupt the website behaviour.
		 */
		public static function disableOnPHPVersionMissmatch() {
			$options = Profiler::getOptions( false );
			update_option( 'f12_profiler_settings', $options );
		}

		/**
		 * This function wraps all actions & filter added to wordpress
		 * with a container that will be used to do the time measuring
		 */
		public static function updateWordpressHooks() {
			global $wp_filter;

			# checking if the filter counter has changed, if yes we update the
			# filters
			if(count($wp_filter) == self::$number_filters){
				return;
			}
			self::$number_filters = count($wp_filter);

			$excluded = array(
				'f12_profiler\f12_profiler'
			);

			foreach ( $wp_filter as $hook_name => $filter /* @var WP_Hook */ ) {

				foreach ( $filter->callbacks as $priority => $callback_container ) {
					foreach ( $callback_container as $callback_name => $callback ) {

						if ( isset( $callback['function'] ) ) {
							$callback_function = $callback['function'];
							/*} else {
								$callback_function = $callback_name;
							}*/
							if(!in_array($callback_function,$excluded)) {
								new \f12_profiler\includes\FilterWrapper( $callback_name, $hook_name, $callback_function, $priority, $callback['accepted_args'] );
							}
						}
					}
				}
			}
		}

		/**
		 * Display the performance information on the admin bar.
		 *
		 * @param $admin_bar
		 */
		public function addToolbar( $admin_bar ) {
			$sum   = 0; // aggregate time
			$count = 0; // number of active plugins
			$data  = \f12_profiler\includes\TimeTracker::get();

			arsort( $data ); //sort resource-intensive plugins on top

			foreach ( $data as $key => $value ) {
				$sum += $value;
				$count ++;

				$value = number_format( $value, 4 );

				if ( $value < 0.0001 ) {
					$value = '0.0001';
				}

				if ( $value > 0.1 ) {
					$value = '<span>Core:</span><span class="f12-res-heavy f12-time" title="Core">' . $value . 's</span>';
				} else if ( $value > 0.05 ) {
					$value = '<span>Core</span><span class="f12-res-medium f12-time" title="Core">' . $value . 's</span>';
				} else {
					$value = '<span>Core:</span><span class="f12-res-light f12-time" title="Core">' . $value . 's</span>';
				}

				$id = '';

				switch ( $key ) {
					case 'WordPress Core':
						$id = 'Wordpress';
						break;
					default:
						$id = $key;
				}

				$title = '<div class="f12-res-container" id="' . $id . '">
							<div class="list-item">
								<span class="f12-res-label">' . $key . '</span> 
								' . $value . '
							</div>
							<div class="list-item list-item-resources">
								<table>
								
								</table>
							</div>
						</div>';

				$admin_bar->add_node( array(
					'id'     => F12_PROFILER_PACKAGE . $key,
					'title'  => $title,
					'parent' => F12_PROFILER_PACKAGE . '_1'
				) );
			}

			// discern short-hands usage to keep toolbar leaner
			$title = Profiler::getOptions()['page_metrics'] ? __( 'F12-Profiler', 'f12_profiler' ) : F12_PROFILER_NAME;

			$admin_bar->add_node( array(
				'id'    => F12_PROFILER_PACKAGE . '_1',
				'title' => $title . ': <span class="f12-times">' . number_format( $sum, 4 ) . 's</span>',
				'meta'  => array( 'title' => __( 'F12 PHP Profiler: Aggregated exec. time (active plugins)', 'f12_profiler' ) )
			) );
		}

	}

	/**
	 * Entrypoint
	 */
	function f12_profiler() {
		if(!function_exists('wp_get_current_user')) {
			include(ABSPATH . "wp-includes/pluggable.php");
		}
		if ( current_user_can( 'manage_options' ) ) {
			require_once( 'includes/class.FilterWrapper.php' );
			require_once( 'includes/class.Helper.php' );
			require_once( 'includes/class.TimeTracker.php' );
			require_once( 'includes/class.Template.php' );
			require_once( 'includes/class.AdminPage.php' );

			/**
			 * Load the Profiler instance
			 */
			Profiler::getInstance();
		}
	}

	add_action( 'registered_taxonomy', 'f12_profiler\f12_profiler' );
}