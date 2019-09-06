<?php #comp-page builds: premium

	/**
	 * Updates for altering the table used to store statistics data.
	 * Adds new columns and renames existing ones in order to add support for the new social buttons.
	 */
	class WCLUpdate010200 extends Wbcr_Factory409_Update {

		public function install()
		{
			WCL_Plugin::app()->deleteOption('enable_wordpres_sanitize');
			WCL_Plugin::app()->deleteOption('remove_dns_prefetch');
		}
	}