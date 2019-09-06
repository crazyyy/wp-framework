<?php #comp-page builds: premium

/**
 * Updates for altering the table used to store statistics data.
 * Adds new columns and renames existing ones in order to add support for the new social buttons.
 */
class WGACUpdate030002 extends Wbcr_Factory409_Update {
	
	public function install() {
		/**
		 * Remove the old cron hook
		 */
		if ( wp_next_scheduled( 'wbcr_clearfy_update_local_ga' ) ) {
			wp_clear_scheduled_hook( 'wbcr_clearfy_update_local_ga' );
		}
		
		/**
		 * Add a new cron hook
		 */
		if ( ! wp_next_scheduled( 'wbcr/gac/update_analytic_library' ) ) {
			wp_schedule_event( time(), 'twicedaily', 'wbcr/gac/update_analytic_library' );
		}
		
		$disable_display_features = $this->plugin->getPopulateOption( 'ga_caos_disable_display_features', false );
		$this->plugin->updatePopulateOption( 'ga_disable_display_features', $disable_display_features );
		
		$this->plugin->deletePopulateOption( 'ga_caos_disable_display_features' );
		$this->plugin->deletePopulateOption( 'ga_caos_remove_wp_cron' );
	}
}