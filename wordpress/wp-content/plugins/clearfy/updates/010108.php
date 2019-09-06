<?php #comp-page builds: premium

	/**
	 * Updates for altering the table used to store statistics data.
	 * Adds new columns and renames existing ones in order to add support for the new social buttons.
	 */
	class WCLUpdate010108 extends Wbcr_Factory409_Update {

		public function install()
		{
			global $wpdb, $wbcr_clearfy_plugin;

			delete_option($wbcr_clearfy_plugin->pluginName . '_quick_modes');
			delete_option($wbcr_clearfy_plugin->pluginName . '_disable_admin_notices');
		}
	}