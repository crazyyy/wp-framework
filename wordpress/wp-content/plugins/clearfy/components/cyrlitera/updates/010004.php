<?php #comp-page builds: premium

	/**
	 * Updates for altering the table used to store statistics data.
	 * Adds new columns and renames existing ones in order to add support for the new social buttons.
	 */
	class WCTR_Update010004 extends Wbcr_Factory409_Update {

		public function install()
		{
			WCTR_Plugin::app()->deletePopulateOption('custom_symbols_pack');
		}
	}