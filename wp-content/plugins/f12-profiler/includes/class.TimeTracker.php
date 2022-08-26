<?php
/**
 * @package f12_profiler
 */
namespace f12_profiler\includes {

	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

	/**
	 * Class TimeTracker
	 * The TimeTracker will track the time used by each
	 * theme and plugin
	 */
	class TimeTracker {
		/**
		 * All saved tracking informations
		 * @var array $tracking = [
		 *      'plugin_1' => 'seconds',
		 *      'plugin_2' => 'seconds',
		 *      'theme' => 'seconds',
		 *      'unknown' => 'seconds',
		 *      ....
		 * ]
		 */
		private static $tracking = array();

		/**
		 * Use this function to add the exection time to the
		 * given key.
		 *
		 * @param string $key the identifier. could either be the name of the plugin or "theme" or "unknown"
		 * @param float $microseconds the seconds which should be added to the the identified plugin/theme...
		 */
		public static function add( $key, $microseconds ) {
			if ( ! isset( self::$tracking[ $key ] ) ) {
				self::$tracking[ $key ] = 0;
			}
			self::$tracking[ $key ] += $microseconds;
		}

		/**
		 * Use this function to return all tracked information while running the script.
		 * @return array
		 */
		public static function get() {
			return self::$tracking;
		}
	}
}