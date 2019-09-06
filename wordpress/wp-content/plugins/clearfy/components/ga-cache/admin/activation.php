<?php

/**
 * Activator for the GA cache
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 09.09.2017, Webcraftic
 * @see Factory409_Activator
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WGA_Activation extends Wbcr_Factory409_Activator {
	
	/**
	 * Runs activation actions.
	 *
	 * @since 1.0.0
	 */
	public function activate() {
		$ga_cache = WGA_Plugin::app()->getPopulateOption( 'ga_cache' );
		
		if ( $ga_cache ) {
			wp_clear_scheduled_hook( 'wbcr/gac/update_analytic_library' );
			
			if ( ! wp_next_scheduled( 'wbcr/gac/update_analytic_library' ) ) {
				wp_schedule_event( time(), 'daily', 'wbcr/gac/update_analytic_library' );
			}
		}
	}
	
	/**
	 * Runs activation actions.
	 *
	 * @since 1.0.0
	 */
	public function deactivate() {
		if ( wp_next_scheduled( 'wbcr/gac/update_analytic_library' ) ) {
			wp_clear_scheduled_hook( 'wbcr/gac/update_analytic_library' );
		}
	}
}
