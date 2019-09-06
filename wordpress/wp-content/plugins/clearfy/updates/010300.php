<?php #comp-page builds: premium

	/**
	 * Updates for altering the table used to store statistics data.
	 * Adds new columns and renames existing ones in order to add support for the new social buttons.
	 */
	class WCL_Update010300 extends Wbcr_Factory409_Update {

		public function install()
		{
			// Deactivate components for code minification, if alternative plugins are installed
			// -------------

			WCL_Plugin::app()->deactivateComponent('minify_and_combine');
			WCL_Plugin::app()->deactivateComponent('html_minify');


			$this->plugin->deleteOption('html_minify');
			$this->plugin->deleteOption('minify_javascript');
			$this->plugin->deleteOption('minify_html_comments');
			$this->plugin->deleteOption('minify_html_xhtml');
			$this->plugin->deleteOption('minify_html_relative');
			$this->plugin->deleteOption('minify_html_scheme');
			$this->plugin->deleteOption('minify_html_utf8');

			/**
			 * Migration for the component Hide login page
			 */
			$hide_wp_admin = $this->plugin->getPopulateOption('hide_wp_admin');
			$hide_login_path = $this->plugin->getPopulateOption('hide_login_path');
			$login_path = $this->plugin->getPopulateOption('login_path');
			$old_login_path = $this->plugin->getPopulateOption('old_login_path');
			$login_recovery_code = $this->plugin->getPopulateOption('login_recovery_code');

			if( $hide_wp_admin ) {
				update_option('wbcr_hlp_hide_wp_admin', $hide_wp_admin);
			}
			if( $hide_login_path ) {
				update_option('wbcr_hlp_hide_login_path', $hide_login_path);
			}
			if( $login_path ) {
				update_option('wbcr_hlp_login_path', $login_path);
			}
			if( $old_login_path ) {
				update_option('wbcr_hlp_old_login_path', $old_login_path);
			}
			if( $login_recovery_code ) {
				update_option('wbcr_hlp_login_recovery_code', $login_recovery_code);
			}

			$this->plugin->deleteOption('hide_wp_admin');
			$this->plugin->deleteOption('login_path');
			$this->plugin->deleteOption('hide_login_path');
			$this->plugin->deleteOption('old_login_path');
			$this->plugin->deleteOption('login_recovery_code');
			
			if( $this->plugin->getPopulateOption('remove_style_version') ) {
				$this->plugin->updatePopulateOption('disable_remove_style_version_for_auth_users', 1);
			}
			if( $this->plugin->getPopulateOption('set_last_modified_headers') ) {
				$this->plugin->updatePopulateOption('disable_frontpage_last_modified_headers', 1);
			}
		}
	}
