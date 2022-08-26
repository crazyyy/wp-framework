<?php

namespace f12_profiler\includes {
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

	/**
	 * Class Template
	 * @package f12_profiler\includes
	 */
	class Template {
		/**
		 * @var $_instance Template
		 */
		private static $_instance = null;

		/**
		 * @return Template
		 */
		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new Template();
			}

			return self::$_instance;
		}

		/**
		 * Returns the relative path to the plugin directory
		 */
		public function getRelPath( $dir = "" ) {
			return '../' . $dir;
		}

		/**
		 * Returns the absolute path to the plugin directory
		 */
		public function getAbsPath( $dir = "" ) {
			return dirname( plugin_dir_path( __FILE__ ) ) . $dir;
		}

		/**
		 * Returns the template
		 *
		 * @param $name
		 * @param $atts
		 *
		 * @return false|string
		 */
		public function getTemplate( $name, $atts = array() ) {
			if ( ! is_file( $this->getAbsPath( '/templates' ) . '/' . $name . '.php' ) ) {
				return 'Template [' . $name . ' (' . $this->getAbsPath( '/templates' ) . '/' . $name . '.php)] not found';
			}

			ob_start();
			require( $this->getAbsPath( '/templates' ) . '/' . $name . ".php" );
			$content = ob_get_contents();
			ob_end_clean();

			return $content;
		}
	}
}