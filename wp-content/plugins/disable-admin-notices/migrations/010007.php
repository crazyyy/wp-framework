<?php #comp-page builds: premium

/**
 * Updates for altering the table used to store statistics data.
 * Adds new columns and renames existing ones in order to add support for the new social buttons.
 */
class WDNUpdate010007 extends Wbcr_Factory466_Update {

	public function install() {
		global $wpdb;

		$hidden_notices = $this->plugin->getPopulateOption( 'hidden_notices' );

		$all_users = $wpdb->get_col( "SELECT ID FROM {$wpdb->users}" );

		if ( ! empty( $all_users ) && ! empty( $hidden_notices ) ) {
			foreach ( $all_users as $user_id ) {
				update_user_meta( $user_id, $this->plugin->getOptionName( 'hidden_notices' ), $hidden_notices );
			}
		}
	}
}