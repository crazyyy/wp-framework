<?php #comp-page builds: premium

	/**
	 * Updates for altering the table used to store statistics data.
	 * Adds new columns and renames existing ones in order to add support for the new social buttons.
	 */
	class WGZUpdate010100 extends Wbcr_Factory409_Update {

		public function install()
		{
			global $wpdb;

			/*$request = $wpdb->get_results("SELECT option_id, option_name, option_value FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr-clearfy_%'");
			if( !empty($request) ) {
				foreach($request as $option) {
					$option_new_name = str_replace('wbcr-clearfy', WCL_Plugin::app()
						->getPrefix(), $option->option_name);
					if( !get_option($option_new_name, false) ) {
						$wpdb->query("UPDATE {$wpdb->prefix}options SET option_name='$option_new_name' WHERE option_id='{$option->option_id}'");
					} else {
						delete_option($option->option_name);
					}
				}
			}*/
		}
	}