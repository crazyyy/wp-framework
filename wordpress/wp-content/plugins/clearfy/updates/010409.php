<?php #comp-page builds: premium

/**
 * Updates for altering the table used to store statistics data.
 * Adds new columns and renames existing ones in order to add support for the new social buttons.
 */
class WCLUpdate010409 extends Wbcr_Factory409_Update {
	
	public function install() {
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/class.storage.php' );
		
		$old_license_storage = WCL_Plugin::app()->getPopulateOption( 'license_storage', false );
		$storage             = new WCL_Licensing_Storage();
		
		if ( $old_license_storage ) {
			if ( isset( $old_license_storage['user'] ) && $old_license_storage['user'] instanceof WCL_FS_User ) {
				$storage->setUser( $old_license_storage['user'] );
			}
			if ( isset( $old_license_storage['site'] ) && $old_license_storage['site'] instanceof WCL_FS_Site ) {
				$storage->setSite( $old_license_storage['site'] );
			}
			if ( isset( $old_license_storage['license'] ) && $old_license_storage['license'] instanceof WCL_FS_Plugin_License ) {
				$storage->setLicense( $old_license_storage['license'] );
			}
			
			$storage->save();
			
			WCL_Plugin::app()->deletePopulateOption( 'license_storage' );
		}
	}
}