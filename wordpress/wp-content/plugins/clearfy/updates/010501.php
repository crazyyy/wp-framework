<?php #comp-page builds: premium

/**
 * Updates for altering the table used to store statistics data.
 * Adds new columns and renames existing ones in order to add support for the new social buttons.
 */
class WCLUpdate010501 extends Wbcr_Factory409_Update {
	
	public function install() {
		$plugin_info        = $this->plugin->getPluginPathInfo();
		$path_to_components = $plugin_info->plugin_root . '/components/';
		
		/**
		 * Миграция для аддона Disable admin notices
		 */
		require_once( $path_to_components . '/ga-cache/updates/030002.php' );
		$gac_updates = new WGACUpdate030002( $this->plugin );
		$gac_updates->install();
	}
}