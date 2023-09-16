<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://swit.hr
 * @since      1.0.0
 *
 * @package    Which_Plugin_Slowing_Down
 * @subpackage Which_Plugin_Slowing_Down/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Which_Plugin_Slowing_Down
 * @subpackage Which_Plugin_Slowing_Down/includes
 * @author     SWIT <sandi@swit.hr>
 */
class Which_Plugin_Slowing_Down_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'profiler-what-slowing-down',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
