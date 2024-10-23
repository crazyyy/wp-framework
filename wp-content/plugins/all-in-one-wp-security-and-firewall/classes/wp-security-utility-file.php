<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

if (class_exists('AIOWPSecurity_Utility_File')) return;

class AIOWPSecurity_Utility_File {

	/**
	 * This function returns an array of all the files and/or directories we wish to check permissions for
	 *
	 * @return array - array containing files and/or directories
	 */
	public static function get_files_and_dirs_to_check() {
		// NOTE: we can add to this list in future if we wish

		//Get wp-config.php file path
		$wp_config_path = self::get_wp_config_file_path();
		$home_path = self::get_home_path();

		$file_list = array(
			array('name' => 'root directory', 'path' => ABSPATH, 'permissions' => '0755'),
			array('name' => 'wp-includes/', 'path' => ABSPATH."wp-includes", 'permissions' => '0755'),
			array('name' => '.htaccess', 'path' => $home_path.".htaccess", 'permissions' => '0644'),
			array('name' => 'wp-admin/index.php', 'path' => ABSPATH."wp-admin/index.php", 'permissions' => '0644'),
			array('name' => 'wp-admin/js/', 'path' => ABSPATH."wp-admin/js/", 'permissions' => '0755'),
			array('name' => 'wp-content/themes/', 'path' => WP_CONTENT_DIR."/themes", 'permissions' => '0755'),
			array('name' => 'wp-content/plugins/', 'path' => WP_PLUGIN_DIR, 'permissions' => '0755'),
			array('name' => 'wp-admin/', 'path' => ABSPATH."wp-admin", 'permissions' => '0755'),
			array('name' => 'wp-content/', 'path' => WP_CONTENT_DIR, 'permissions' => '0755'),
			array('name' => 'wp-config.php', 'path' => $wp_config_path, 'permissions' => '0640'),
			//Add as many files or dirs as needed by following the convention above
		);

		return apply_filters('aiowpsecurity_file_permission_list', $file_list);
	}

	/**
	 * Returns full path to mu-plugin directory
	 *
	 * @return string
	 */
	public static function get_mu_plugin_dir() {
		return WPMU_PLUGIN_DIR;
	}

	/**
	 * Returns path to wp-config
	 *
	 * @return string
	 */
	public static function get_wp_config_file_path() {
		$wp_config_file = ABSPATH . 'wp-config.php';
		if (file_exists($wp_config_file)) {
			return $wp_config_file;
		} elseif (file_exists(dirname(ABSPATH) . '/wp-config.php')) {
			return dirname(ABSPATH) . '/wp-config.php';
		}
		return $wp_config_file;
	}

	public static function write_content_to_file($file_path, $new_contents) {
		// Get the file permissions so we can revert back to it when we are done
		$permissions = octdec(substr(sprintf('%o', fileperms($file_path)), -4));
		@chmod($file_path, 0777);
		if (is_writeable($file_path)) {
			$handle = fopen($file_path, 'w');
			foreach ($new_contents as $line) {
				fwrite($handle, $line);
			}
			fclose($handle);
			@chmod($file_path, $permissions); //Let's change the file back to it's original permission setting
			return true;
		} else {
				return false;
		}
	}

	public static function backup_and_rename_wp_config($src_file_path, $prefix = 'backup') {
		global $aio_wp_security;

		//Check to see if the main "backups" directory exists - create it otherwise
		$aiowps_backup_dir = WP_CONTENT_DIR.'/'.AIO_WP_SECURITY_BACKUPS_DIR_NAME;
		if (!AIOWPSecurity_Utility_File::create_dir($aiowps_backup_dir)) {
			$aio_wp_security->debug_logger->log_debug("backup_and_rename_wp_config - Creation of backup directory failed!", 4);
			return false;
		}

		$src_parts = pathinfo($src_file_path);
		$backup_file_name = $prefix . '.' . $src_parts['basename'];

		$backup_file_path = $aiowps_backup_dir . '/' . $backup_file_name;
		if (!copy($src_file_path, $backup_file_path)) {
			//Failed to make a backup copy
			return false;
		}
		return true;
	}

	/**
	 * Backs up and renames the .htaccess file.
	 *
	 * This function creates a backup of the specified .htaccess file by copying it
	 * to a designated backup directory with a randomly generated filename.
	 *
	 * @param string $src_file_path The path to the source .htaccess file to be backed up.
	 *
	 * @return string|false The name of the backup file on success, or false on failure.
	 */
	public static function backup_and_rename_htaccess($src_file_path) {
		global $aio_wp_security;

		// Define the backup directory path
		$aiowps_backup_dir = WP_CONTENT_DIR . '/' . AIO_WP_SECURITY_BACKUPS_DIR_NAME;

		// Ensure the backup directory exists or create it
		if (!AIOWPSecurity_Utility_File::create_dir($aiowps_backup_dir)) {
			$aio_wp_security->debug_logger->log_debug("backup_and_rename_htaccess - Creation of backup directory failed!", 4);
			return false;
		}

		// Generate a random prefix for the backup file name
		$random_prefix = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(10);
		$backup_file_name = $random_prefix . '_htaccess_backup';

		// Define the backup file path
		$backup_file_path = $aiowps_backup_dir . '/' . $backup_file_name .'.txt';

		// Copy the source file to the backup location
		if (!copy($src_file_path, $backup_file_path)) {
			// Failed to make a backup copy
			return false;
		}

		// Return the backup file name on success
		return $backup_file_name;
	}

	/**
	 * This function will perform a recursive search for files in the path that match the passed in pattern
	 *
	 * @param string  $pattern - the file pattern to search for
	 * @param integer $flags   - flags to apply on the search
	 * @param string  $path    - the path we want to search
	 *
	 * @return boolean|array - an array of files matching the pattern or false if there was an error (directory traversal in path) or none found
	 */
	public static function recursive_file_search($pattern = '*', $flags = 0, $path = '') {
		$paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
		if (false === $paths) {
			return false;
		}
		$files = glob($path.$pattern, $flags);
		if (false === $files) {
			return false;
		}
		foreach ($paths as $path) {
			$files = array_merge($files, AIOWPSecurity_Utility_File::recursive_file_search($pattern, $flags, $path));
		}
		return $files;
	}

	/**
	 * Useful when wanting to echo file contents to screen with <br /> tags
	 *
	 * @param string $src_file
	 * @return string
	 */
	public static function get_file_contents_with_br($src_file) {
		$file_contents = file_get_contents($src_file);
		return nl2br($file_contents);
	}

	/**
	 * Useful when wanting to echo file contents inside textarea
	 *
	 * @param string $src_file
	 * @return string
	 */
	public static function get_file_contents($src_file) {
		$file_contents = file_get_contents($src_file);
		return $file_contents;
	}

	/**
	 * Returns the file's permission value eg, "0755"
	 *
	 * @param string $filepath
	 * @return string
	 */
	public static function get_file_permission($filepath) {
		if (!function_exists('fileperms')) {
			$perms = '-1';
		} else {
			clearstatcache();
			$perms = substr(sprintf("%o", @fileperms($filepath)), -4);
		}
		return $perms;
	}

	/**
	 * Checks if a write operation is possible for the file in question
	 *
	 * @param string $filepath
	 * @return boolean
	 */
	public static function is_file_writable($filepath) {
		$test_string = ""; //We will attempt to append an empty string at the end of the file for the test
		$write_result = @file_put_contents($filepath, $test_string, FILE_APPEND | LOCK_EX);
		if (false === $write_result) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * This function will compare the current permission value for a file or dir with the recommended value.
	 * It will compare the individual "execute", "write" and "read" bits for the "public", "group" and "owner" permissions.
	 * If the permissions for an actual bit value are greater than the recommended value it returns '0' (=less secure)
	 * Otherwise it returns '1' which means it is secure
	 * Accepts permission value parameters in octal, ie, "0777" or "777"
	 *
	 * @param string $recommended
	 * @param string $actual
	 * @return boolean
	 */
	public static function is_file_permission_secure($recommended, $actual) {
		$result = 1; //initialize return result

		//Check "public" permissions
		$public_value_actual = substr($actual, -1, 1); //get dec value for actual public permission
		$public_value_rec = substr($recommended, -1, 1); //get dec value for recommended public permission

		$pva_bin = sprintf('%04b', $public_value_actual); //Convert value to binary
		$pvr_bin = sprintf('%04b', $public_value_rec); //Convert value to binary
		//Compare the "executable" bit values for the public actual versus the recommended
		if (substr($pva_bin, -1, 1)<=substr($pvr_bin, -1, 1)) {
			//The "execute" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "execute" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Compare the "write" bit values for the public actual versus the recommended
		if (substr($pva_bin, -2, 1)<=substr($pvr_bin, -2, 1)) {
			//The "write" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "write" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Compare the "read" bit values for the public actual versus the recommended
		if (substr($pva_bin, -3, 1)<=substr($pvr_bin, -3, 1)) {
			//The "read" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "read" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Check "group" permissions
		$group_value_actual = substr($actual, -2, 1);
		$group_value_rec = substr($recommended, -2, 1);
		$gva_bin = sprintf('%04b', $group_value_actual); //Convert value to binary
		$gvr_bin = sprintf('%04b', $group_value_rec); //Convert value to binary

		//Compare the "executable" bit values for the group actual versus the recommended
		if (substr($gva_bin, -1, 1)<=substr($gvr_bin, -1, 1)) {
			//The "execute" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "execute" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Compare the "write" bit values for the public actual versus the recommended
		if (substr($gva_bin, -2, 1)<=substr($gvr_bin, -2, 1)) {
			//The "write" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "write" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Compare the "read" bit values for the public actual versus the recommended
		if (substr($gva_bin, -3, 1)<=substr($gvr_bin, -3, 1)) {
			//The "read" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "read" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Check "owner" permissions
		$owner_value_actual = substr($actual, -3, 1);
		$owner_value_rec = substr($recommended, -3, 1);
		$ova_bin = sprintf('%04b', $owner_value_actual); //Convert value to binary
		$ovr_bin = sprintf('%04b', $owner_value_rec); //Convert value to binary

		//Compare the "executable" bit values for the group actual versus the recommended
		if (substr($ova_bin, -1, 1)<=substr($ovr_bin, -1, 1)) {
			//The "execute" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "execute" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Compare the "write" bit values for the public actual versus the recommended
		if (substr($ova_bin, -2, 1)<=substr($ovr_bin, -2, 1)) {
			//The "write" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "write" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		//Compare the "read" bit values for the public actual versus the recommended
		if (substr($ova_bin, -3, 1)<=substr($ovr_bin, -3, 1)) {
			//The "read" bit is the same or less as the recommended value
			$result = 1*$result;
		} else {
			//The "read" bit is switched on for the actual value - meaning it is less secure
			$result = 0*$result;
		}

		return $result;
	}

	/**
	 * Checks if a directory exists and creates one if it does not
	 *
	 * @param string $dirpath
	 * @return boolean
	 */
	public static function create_dir($dirpath = '') {
		$res = true;
		if ('' != $dirpath) {
			//TODO - maybe add some checks to make sure someone is not passing a path with a filename, ie, something which has ".<extension>" at the end
			//$path_parts = pathinfo($dirpath);
			//$dirpath = $path_parts['dirname'] . '/' . $path_parts['basename'];
			if (!file_exists($dirpath)) {
				$res = mkdir($dirpath, 0755);
			}
		}
		return $res;
	}

	/**
	 * Remove a directory from the local filesystem
	 *
	 * @param string  $dir			 - the directory
	 * @param boolean $contents_only - if set to true, then do not remove the directory, but only empty it of contents
	 *
	 * @return boolean - success/failure
	 */
	public static function remove_local_directory($dir, $contents_only = false) {
		
		$handle = opendir($dir);
		if ($handle) {
			while (false !== ($entry = readdir($handle))) {
				if ('.' !== $entry && '..' !== $entry) {
					if (is_dir($dir.'/'.$entry)) {
						self::remove_local_directory($dir.'/'.$entry, false);
					} else {
						@unlink($dir.'/'.$entry);// phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- ignore warning and proceed to try and remove the rest of the files
					}
				}
			}
			if (is_resource($handle)) closedir($handle);
		}

		return $contents_only ? true : rmdir($dir);
	}

	/**
	 * Get home path.
	 *
	 * @return string
	 */
	public static function get_home_path() {
		// Make the scope of $wp_file_descriptions global, so that when wp-admin/includes/file.php assigns to it, it is adjusting the global variable as intended
		global $wp_file_descriptions; // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- We need to make this global see above comment
		if (!function_exists('get_home_path')) require_once(ABSPATH. '/wp-admin/includes/file.php');
		return wp_normalize_path(get_home_path());
	}

	/**
	 * Check if wp config file.
	 *
	 * @param string $file_contents File contents
	 *
	 * @return bool
	 */
	public static function check_if_wp_config_contents($file_contents) {
		return !empty($file_contents) && preg_match("/define\(\s*['\"]DB_NAME['\"]/i", $file_contents);
	}

	/**
	 * Check if valid aios settings text
	 *
	 * @param string $text - Settings text
	 *
	 * @return boolean
	 */
	public static function check_is_aiowps_settings($text) {
		return (false !== strpos($text, 'aiowps_enable_login_lockdown'));
	}

	/**
	 * Checks if valid AIOS settings file contents and returns contents as string
	 *
	 * @param string $file_contents File contents
	 *
	 * @return int|string
	 */
	public static function check_if_valid_aiowps_settings_content($file_contents) {
		// Check a known AIOS config strings to see if it is contained within this file
		return !empty($file_contents) && self::check_is_aiowps_settings($file_contents);
	}

	/**
	 * Scans WP key core files and directory permissions and populates a wp wide_fat table
	 * Displays a red background entry with a "Fix" button for permissions which are "777"
	 * Displays a yellow background entry with a "Fix" button for permissions which are less secure than the recommended
	 * Displays a green entry for permissions which are as secure or better than the recommended
	 *
	 * @param string $name        - file name
	 * @param string $path        - file path
	 * @param string $recommended - file permission
	 *
	 * @return void
	 */
	public static function show_wp_filesystem_permission_status($name, $path, $recommended) {
		$fix = false;
		$configmod = self::get_file_permission($path);
		if (self::is_file_world_writable($configmod)) {
			$trclass = "aio_table_row_red"; // Display a red background if permissions are set as least secure ("777")
			$fix = true;
		} elseif ($configmod != $recommended) {
			// $res = $this->is_file_permission_secure($recommended, $configmod);
			$res = self::is_file_permission_secure($recommended, $configmod);
			if ($res) {
				$trclass = "aio_table_row_green"; //If the current permissions are even tighter than recommended then display a green row
			} else {
				$trclass = "aio_table_row_yellow"; // Display a yellow background if permissions are set to something different than recommended
				$fix = true;
			}
		} else {
			$trclass = "aio_table_row_green";
		}
		echo "<tr class=".$trclass.">";
		echo '<td class="column-primary" data-colname="' . esc_attr(__('Name', 'all-in-one-wp-security-and-firewall')) . '">' . $name . '<button type="button" class="toggle-row"><span class="screen-reader-text">' . __('Show more details', 'all-in-one-wp-security-and-firewall') . '</span></button>' . "</td>";
		echo '<td data-colname="' . esc_attr(__('File/Folder', 'all-in-one-wp-security-and-firewall')) . '">' . $path . "</td>";
		echo '<td data-colname="' . esc_attr(__('Current permissions', 'all-in-one-wp-security-and-firewall')) . '">' . $configmod . '</td>';
		echo '<td data-colname="' . esc_attr(__('Recommended permissions', 'all-in-one-wp-security-and-firewall')) . '">' . $recommended . '</td>';
		if ($fix) {
			echo '<td data-colname="' . esc_attr(__('Recommended action', 'all-in-one-wp-security-and-firewall')) . '">
					<input type="submit" onclick="return set_file_permission_tochange(\'' . esc_js($path) . '\', \'' . esc_js($recommended) . '\')" name="aiowps_fix_permissions" value="' . esc_attr(__('Set recommended permissions', 'all-in-one-wp-security-and-firewall')) . '" class="button-secondary">
					</td>';
		} else {
			echo '<td>'.__('No action required', 'all-in-one-wp-security-and-firewall').'</td>';
		}
		echo "</tr>";
	}

	/**
	 * Checks if the given file permissions indicate that the file is world-writable.
	 *
	 * This function accepts a string representation of file permissions (in octal format)
	 * and checks if the write bit is set for 'others' (world). It ensures the string
	 * is 4 characters long by prepending a '0' if necessary and then extracts and
	 * evaluates the last digit to determine if the file is world-writable.
	 *
	 * @param string $permissions The file permissions in octal format (e.g., "0777", "0755").
	 * @return bool Returns true if the file is world-writable, otherwise false.
	 */
	public static function is_file_world_writable($permissions) {
		if (strlen($permissions) == 3) {
			$permissions = '0' . $permissions;
		}

		// Get the 'others' permissions (last digit)
		$others_permissions = (int) substr($permissions, -1);

		// Check if the write bit (2) is set for 'others'
		return (bool) ($others_permissions & 0x2);
	}
	
	/**
	 * Read the larger file and get last 100 lines etc in an efficient way
	 *
	 * @param string  $filepath - file path
	 * @param integer $offset   - offest to start reading the file from that line
	 * @param integer $num      - number of lines to read
	 * @param boolean $reverse  - return in reverse order
	 *
	 * @return array|boolean - file lines
	 */
	public static function read_file_lines($filepath, $offset = 0, $num = 10, $reverse = false) {
		global $aio_wp_security;
		try {
			$file = new \SplFileObject($filepath, 'r');
			if (-1 == $offset) {
				$file->seek(PHP_INT_MAX); // PHP_INT_MAX to seeek to last line
				$last_line = $file->key();
				$offset = $last_line > $num ? $last_line - $num : 0;
			}
			$lines = new \LimitIterator($file, $offset, $offset + $num);
			$lines_arr = iterator_to_array($lines);
			if ($reverse) $lines_arr = array_reverse($lines_arr);
			return $lines_arr;
		} catch (\Exception $e) {
			$aio_wp_security->debug_logger->log_debug("AIOS - Unable to read file: ". $filepath . " - " .$e->getMessage(), 4);
		}
		return false;
	}
}
