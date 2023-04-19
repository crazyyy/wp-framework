<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Database_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Database menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_DB_SEC_MENU_SLUG;
	
	/**
	 * Constructor adds menu for Database security
	 */
	public function __construct() {
		parent::__construct(__('Database security', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * Return installation or activation link of UpdraftPlus plugin
	 *
	 * @return String
	 */
	private function get_install_activate_link_of_updraft_plugin() {
		// If UpdraftPlus is activated, then return empty.
		if (class_exists('UpdraftPlus')) return '';

		// Generally it is 'updraftplus/updraftplus.php',
		// but we can't assume that the user hasn't renamed the plugin folder - with 3 million UDP users and 1 million AIOWPS, there will be some who have.
		$updraftplus_plugin_file_rel_to_plugins_dir = $this->get_updraftplus_plugin_file_rel_to_plugins_dir();

		// If UpdraftPlus is installed but not activated, then return activate link.
		if ($updraftplus_plugin_file_rel_to_plugins_dir) {
			$activate_url = add_query_arg(array(
				'_wpnonce'    => wp_create_nonce('activate-plugin_'.$updraftplus_plugin_file_rel_to_plugins_dir),
				'action'      => 'activate',
				'plugin'      => $updraftplus_plugin_file_rel_to_plugins_dir,
			), network_admin_url('plugins.php'));

			// If is network admin then add to link network activation.
			if (is_network_admin()) {
				$activate_url = add_query_arg(array('networkwide' => 1), $activate_url);
			}
			return sprintf('<a href="%s">%s</a>',
				$activate_url,
				__('UpdraftPlus is installed but currently not active.', 'all-in-one-wp-security-and-firewall') .' '. __('Follow this link to activate UpdraftPlus, to take a backup.', 'all-in-one-wp-security-and-firewall')
			);
		}

		// If UpdraftPlus is not activated or installed, then return the installation link
		return '<a href="'.wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=updraftplus'), 'install-plugin_updraftplus').'">'.__('Follow this link to install UpdraftPlus, to take a database backup.', 'all-in-one-wp-security-and-firewall').'</a>';
	}

	/**
	 * Get path to the UpdraftPlus plugin file relative to the plugins directory.
	 *
	 * @return String|false path to the UpdraftPlus plugin file relative to the plugins directory
	 */
	private function get_updraftplus_plugin_file_rel_to_plugins_dir() {
		if (!function_exists('get_plugins')) {
			include_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$installed_plugins = get_plugins();
		$installed_plugins_keys = array_keys($installed_plugins);
		foreach ($installed_plugins_keys as $plugin_file_rel_to_plugins_dir) {
			$temp_plugin_file_name = substr($plugin_file_rel_to_plugins_dir, strpos($plugin_file_rel_to_plugins_dir, '/') + 1);
			if ('updraftplus.php' == $temp_plugin_file_name) {
				return $plugin_file_rel_to_plugins_dir;
			}
		}
		return false;
	}

	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'database-prefix' => array(
				'title' => __('Database prefix', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_database_prefix'),
				'display_condition_callback' => 'is_main_site',
			),
			'database-backup' => array(
				'title' => __('Database backup', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_database_backup'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's database prefix tab
	 *
	 * @return Void
	 */
	protected function render_database_prefix() {
		global $wpdb, $aio_wp_security, $aiowps_feature_mgr;
		$old_db_prefix = $wpdb->prefix;
		$new_db_prefix = '';
		$perform_db_change = false;
		
		if (isset($_POST['aiowps_db_prefix_change'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-db-prefix-change-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for DB prefix change operation!",4);
				die(__('Nonce check failed for DB prefix change operation!','all-in-one-wp-security-and-firewall'));
			}
			
			// Let's first check if user's system allows writing to wp-config.php file. If plugin cannot write to wp-config we will not do the prefix change.
			$config_file = AIOWPSecurity_Utility_File::get_wp_config_file_path();
			$file_write = AIOWPSecurity_Utility_File::is_file_writable($config_file);
			if (!$file_write) {
				$this->show_msg_error(__('The plugin has detected that it cannot write to the wp-config.php file. This feature can only be used if the plugin can successfully write to the wp-config.php file.', 'all-in-one-wp-security-and-firewall'));
			} else {
				if (isset($_POST['aiowps_enable_random_prefix'])) { // User has elected to generate a random DB prefix
					$string = AIOWPSecurity_Utility::generate_alpha_random_string('5');
					$new_db_prefix = $string . '_';
					$perform_db_change = true;
				} else {
					if (empty($_POST['aiowps_new_manual_db_prefix'])) {
						$this->show_msg_error(__('Please enter a value for the DB prefix.', 'all-in-one-wp-security-and-firewall'));
					} else {
						// User has chosen their own DB prefix value
						$new_db_prefix = wp_strip_all_tags(trim($_POST['aiowps_new_manual_db_prefix']));
						if ($new_db_prefix !== $_POST['aiowps_new_manual_db_prefix']) {
							wp_die("<strong>".__('Error:', 'all-in-one-wp-security-and-firewall')."</strong> ".__('prefix contains HTML tags', 'all-in-one-wp-security-and-firewall'));
						}
						if (preg_match( '|[^a-z0-9_]|i', $new_db_prefix)) {
							wp_die("<strong>".__('Error:', 'all-in-one-wp-security-and-firewall')."</strong> ".__('prefix contains invalid characters, the prefix should only contain alphanumeric and underscore characters.', 'all-in-one-wp-security-and-firewall'));
						}
						$error = $wpdb->set_prefix($new_db_prefix); // validate the user chosen prefix
						if (is_wp_error($error)) {
							wp_die("<strong>".__('Error:', 'all-in-one-wp-security-and-firewall')."</strong> (".$error->get_error_code()."): ".$error->get_error_message());
						}
						$wpdb->set_prefix($old_db_prefix);
						$perform_db_change = true;
					}
				}
			}
		}

		if ($perform_db_change) {
			// Do the DB prefix change operations
			$this->change_db_prefix($old_db_prefix, $new_db_prefix);
		}

		$aio_wp_security->include_template('wp-admin/database-security/database-prefix.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'old_db_prefix' => $old_db_prefix));
	}

	/**
	 * Renders the submenu's database backup tab
	 *
	 * @return Void
	 */
	protected function render_database_backup() {
		global $aio_wp_security;
		
		$updraftplus_admin = !empty($GLOBALS['updraftplus_admin']) ? $GLOBALS['updraftplus_admin'] : null;
		
		if ($updraftplus_admin) {
			$updraftplus_admin->add_backup_scaffolding(__('Take a database backup using UpdraftPlus', 'all-in-one-wp-security-and-firewall'), array($updraftplus_admin, 'backupnow_modal_contents'));
		
		}
		$install_activate_link = $this->get_install_activate_link_of_updraft_plugin();

		$aio_wp_security->include_template('wp-admin/database-security/database-backup.php', false, array('install_activate_link' =>  $install_activate_link));
	}
	
	/*
	 * Changes the DB prefix
	 */
	/**
	 * This function will change the DB prefix
	 *
	 * @param string $table_old_prefix - the old table prefix
	 * @param string $table_new_prefix - the new table prefix
	 *
	 * @return void
	 */
	private function change_db_prefix($table_old_prefix, $table_new_prefix) {
		global $wpdb, $aio_wp_security;
		$old_prefix_length = strlen($table_old_prefix);
		$error = 0;

		// Config file path
		$config_file = AIOWPSecurity_Utility_File::get_wp_config_file_path();

		// Get the table resource
		// $result = mysql_list_tables(DB_NAME);
		$result = $this->get_mysql_tables(DB_NAME); //Fix for deprecated php mysql_list_tables function

		// Count the number of tables
		if (is_array($result) && count($result) > 0) {
			$num_rows = count($result);
		} else {
			echo '<div class="aio_red_box"><p>'.__('Error - Could not get tables or no tables found!', 'all-in-one-wp-security-and-firewall').'</p></div>';
			return;
		}
		$table_count = 0;
		$info_msg_string = '<p class="aio_info_with_icon">'.__('Starting DB prefix change operations.....', 'all-in-one-wp-security-and-firewall').'</p>';
		
		$info_msg_string .= '<p class="aio_info_with_icon">'.sprintf( __('Your WordPress system has a total of %s tables and your new DB prefix will be: %s', 'all-in-one-wp-security-and-firewall'), '<strong>'.$num_rows.'</strong>', '<strong>'.$table_new_prefix.'</strong>').'</p>';
		echo($info_msg_string);

		// Do a back of the config file
		if (!AIOWPSecurity_Utility_File::backup_and_rename_wp_config($config_file)) {
			echo '<div class="aio_red_box"><p>'.__('Failed to make a backup of the wp-config.php file. This operation will not go ahead.', 'all-in-one-wp-security-and-firewall').'</p></div>';
			return;
		} else {
			echo '<p class="aio_success_with_icon">'.__('A backup copy of your wp-config.php file was created successfully!', 'all-in-one-wp-security-and-firewall').'</p>';
		}
		
		// Get multisite blog_ids if applicable
		if (is_multisite()) {
			$blog_ids = AIOWPSecurity_Utility::get_blog_ids();
		}

		// Rename all the table names
		foreach ($result as $db_table) {
			// Get table name with old prefix
			$table_old_name = $db_table;

			if (strpos($table_old_name, $table_old_prefix) === 0) {
				// Get table name with new prefix
				$table_new_name = AIOWPSecurity_Utility::backquote($table_new_prefix . substr($table_old_name, $old_prefix_length));
				$table_old_name = AIOWPSecurity_Utility::backquote($table_old_name);
				
				// Write query to rename tables name
				$sql = "RENAME TABLE ".$table_old_name." TO ".$table_new_name;
				// $sql = "RENAME TABLE %s TO %s";

				// Execute the query
				if (false === $wpdb->query($sql)) {
					$error = 1;
					echo '<p class="aio_error_with_icon">'.sprintf(__('%s table name update failed', 'all-in-one-wp-security-and-firewall'), '<strong>'.$table_old_name.'</strong>').'</p>';
					$aio_wp_security->debug_logger->log_debug("DB Security Feature - Unable to change prefix of table ".$table_old_name, 4);
				} else {
					$table_count++;
				}
			} else {
				continue;
			}
		}
		if ($error == 1) {
			echo '<p class="aio_error_with_icon">'.sprintf(__('Please change the prefix manually for the above tables to: %s', 'all-in-one-wp-security-and-firewall'), '<strong>'.$table_new_prefix.'</strong>').'</p>';
		} else {
			echo '<p class="aio_success_with_icon">'.sprintf(__('%s tables had their prefix updated successfully!', 'all-in-one-wp-security-and-firewall'), '<strong>'.$table_count.'</strong>').'</p>';
		}

		// Let's check for mysql tables of type "view"
		$this->alter_table_views($table_old_prefix, $table_new_prefix);

		// Get wp-config.php file contents and modify it with new info
		$config_contents = file($config_file);
		$prefix_match_string = '$table_prefix='; //this is our search string for the wp-config.php file
		foreach ($config_contents as $line_num => $line) {
			$no_ws_line = preg_replace( '/\s+/', '', $line ); //Strip white spaces
			if (strpos($no_ws_line, $prefix_match_string) !== FALSE) {
				$prefix_parts = explode("=",$config_contents[$line_num]);
				$prefix_parts[1] = str_replace($table_old_prefix, $table_new_prefix, $prefix_parts[1]);
				$config_contents[$line_num] = implode("=",$prefix_parts);
				break;
			}
		}
		// Now let's modify the wp-config.php file
		if (AIOWPSecurity_Utility_File::write_content_to_file($config_file, $config_contents)) {
			echo '<p class="aio_success_with_icon">'. __('wp-config.php file was updated successfully!', 'all-in-one-wp-security-and-firewall').'</p>';
		} else {
			echo '<p class="aio_error_with_icon">'.sprintf(__('The "wp-config.php" file was not able to be modified.', 'all-in-one-wp-security-and-firewall').' '.__('Please modify this file manually using your favourite editor and search for variable "$table_prefix" and assign the following value to that variable: %s', 'all-in-one-wp-security-and-firewall'), '<strong>'.$table_new_prefix.'</strong>').'</p>';
			$aio_wp_security->debug_logger->log_debug("DB Security Feature - Unable to modify wp-config.php",4);
		}
		
		// Now let's update the options table
		$update_option_table_query = $wpdb->prepare("UPDATE " . $table_new_prefix . "options SET option_name = '".$table_new_prefix ."user_roles' WHERE option_name = %s LIMIT 1", $table_old_prefix."user_roles");

		if (false === $wpdb->query($update_option_table_query)) {
			echo '<p class="aio_error_with_icon">'.sprintf( __('Update of table %s failed: unable to change %s to %s', 'all-in-one-wp-security-and-firewall'),$table_new_prefix.'options', $table_old_prefix.'user_roles', $table_new_prefix.'user_roles').'</p>';
			$aio_wp_security->debug_logger->log_debug("DB Security Feature - Error when updating the options table",4);//Log the highly unlikely event of DB error
		} else {
			echo '<p class="aio_success_with_icon">'.sprintf( __('The options table records which had references to the old DB prefix were updated successfully!', 'all-in-one-wp-security-and-firewall')).'</p>';
		}

		// Now let's update the options tables for the multisite subsites if applicable
		if (is_multisite()) {
			if (!empty($blog_ids)) {
				$main_site_id = get_main_site_id();
				foreach ($blog_ids as $blog_id) {
					if ($blog_id == $main_site_id) continue;
					$new_pref_and_site_id = $table_new_prefix.$blog_id.'_';
					$old_pref_and_site_id = $table_old_prefix.$blog_id.'_';
					$update_ms_option_table_query = $wpdb->prepare("UPDATE " . $new_pref_and_site_id . "options SET option_name = '".$new_pref_and_site_id."user_roles' WHERE option_name = %s LIMIT 1", $old_pref_and_site_id."user_roles");
					if (false === $wpdb->query($update_ms_option_table_query)) {
						echo '<p class="aio_error_with_icon">'.sprintf( __('Update of table %s failed: unable to change %s to %s', 'all-in-one-wp-security-and-firewall'),$new_pref_and_site_id.'options', $old_pref_and_site_id.'user_roles', $new_pref_and_site_id.'user_roles').'</p>';
						$aio_wp_security->debug_logger->log_debug("DB change prefix feature - Error when updating the subsite options table: ".$new_pref_and_site_id.'options',4);//Log the highly unlikely event of DB error
					} else {
						echo '<p class="aio_success_with_icon">'.sprintf( __('The %s table records which had references to the old DB prefix were updated successfully!', 'all-in-one-wp-security-and-firewall'),$new_pref_and_site_id.'options').'</p>';
					}
				}
			}
		}
		
		//Now let's update the user meta table
		$custom_sql = "SELECT user_id, meta_key FROM " . $table_new_prefix . "usermeta WHERE meta_key LIKE '" . $table_old_prefix . "%'";
		
		$meta_keys = $wpdb->get_results( $custom_sql );

		$error_update_usermeta = '';

		// Update all meta_key field values which have the old table prefix in user_meta table
		foreach ($meta_keys as $meta_key ) {
			// Create new meta key
			$new_meta_key = $table_new_prefix . substr( $meta_key->meta_key, $old_prefix_length );

			$update_user_meta_sql = $wpdb->prepare("UPDATE " . $table_new_prefix . "usermeta SET meta_key='" . $new_meta_key . "' WHERE meta_key=%s AND user_id=%s", $meta_key->meta_key, $meta_key->user_id);

			if (false === $wpdb->query($update_user_meta_sql)) {
				$error_update_usermeta .= '<p class="aio_error_with_icon">'.sprintf( __('Error updating user_meta table where new meta_key = %s, old meta_key = %s and user_id = %s.', 'all-in-one-wp-security-and-firewall'),$new_meta_key,$meta_key->meta_key,$meta_key->user_id).'</p>';
				echo $error_update_usermeta;
				$aio_wp_security->debug_logger->log_debug("DB Security Feature - Error updating user_meta table where new meta_key = ".$new_meta_key." old meta_key = ".$meta_key->meta_key." and user_id = ".$meta_key->user_id,4);//Log the highly unlikely event of DB error
			}
		}
		echo '<p class="aio_success_with_icon">'.__('The usermeta table records which had references to the old DB prefix were updated successfully!', 'all-in-one-wp-security-and-firewall').'</p>';
		// Display tasks finished message
		$tasks_finished_msg_string = '<p class="aio_info_with_icon">'. __('The database prefix change tasks have been completed.', 'all-in-one-wp-security-and-firewall').'</p>';
		echo ($tasks_finished_msg_string);
	} 
	
	/**
	* This is an alternative to the deprecated "mysql_list_tables"
	* Returns an array of table names
	*/
	public function get_mysql_tables($database='') {
		global $aio_wp_security;
		$tables = array();
		$list_tables_sql = "SHOW TABLES FROM `{$database}`;";
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		if ($mysqli->connect_errno) {
			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Database_Menu->get_mysql_tables() - DB connection error.",4);
			return false;
		}
		
		if ($result = $mysqli->query($list_tables_sql, MYSQLI_USE_RESULT)) {
			//Alternative way to get the tables
			while ($row = $result->fetch_assoc()) {
				foreach( $row  AS $value ) {
					$tables[] = $value;
				}
			}
			$result->close();
		}
		$mysqli->close();
		return $tables;
	}
	
	/**
	 * Will modify existing table view definitions to reflect the new DB prefix change
	 * 
	 * @param type $old_prefix
	 * @param type $new_prefix
	 */
	private function alter_table_views($old_db_prefix, $new_db_prefix) {
		global $wpdb;
		$table_count = 0;
		$db_name = $wpdb->dbname;
		$info_msg_string = '<p class="aio_info_with_icon">'.__('Checking for MySQL tables of type "view".....', 'all-in-one-wp-security-and-firewall').'</p>';
		echo ($info_msg_string);
		
		// get tables which are views
		$query = "SELECT * FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA LIKE '".$db_name."'";
		$res = $wpdb->get_results($query);
		if (empty($res)) return;
		$view_count = 0;
		foreach ($res as $item) {
			$old_def = $item->VIEW_DEFINITION;
			$new_def = AIOWPSecurity_Utility::str_replace_once($old_db_prefix, $new_db_prefix, $old_def);
			$new_def = AIOWPSecurity_Utility::backquote($new_def);

			$view_name = AIOWPSecurity_Utility::backquote($item->TABLE_NAME);
			$chg_view_sql = "ALTER VIEW $view_name AS $new_def";
			$view_res = $wpdb->query($chg_view_sql);
			if ($view_res === false) {
				echo '<p class="aio_error_with_icon">'.sprintf( __('Update of the following MySQL view definition failed: %s', 'all-in-one-wp-security-and-firewall'),$old_def).'</p>';
				$aio_wp_security->debug_logger->log_debug("Update of the following MySQL view definition failed: ".$old_def,4);//Log the highly unlikely event of DB error
			} else {
				$view_count++;
			}
		}
		if ($view_count > 0) {
			echo '<p class="aio_success_with_icon">'.sprintf( __('%s view definitions were updated successfully!', 'all-in-one-wp-security-and-firewall'), '<strong>'.$view_count.'</strong>').'</p>';
		}
		
		return;
	}
} //end class
