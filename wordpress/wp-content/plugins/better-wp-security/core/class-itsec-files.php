<?php

/**
 * iThemes file handler.
 *
 * Writes to core files including wp-config.php, htaccess and nginx.conf.
 *
 * @package iThemes_Security
 *
 * @since   4.0.0
 */
final class ITSEC_Files {

	/**
	 * The module's that have registered with the file writer
	 *
	 * @since  4.0.0
	 * @access private
	 * @var array
	 */
	private $file_modules;

	/**
	 * The current rewrite rules
	 *
	 * @since  4.0.0
	 * @access private
	 * @var array
	 */
	private $rewrite_rules;

	/**
	 * The current wp-config.php rules
	 *
	 * @since  4.0.0
	 * @access private
	 * @var array
	 */
	private $wpconfig_rules;

	/**
	 * Whether or not rewrite rules have been modified externally
	 *
	 * @since  4.0.0
	 * @access private
	 * @var bool
	 */
	private $rewrites_changed;

	/**
	 * Whether or not wp-config.php rules have been modified externally
	 *
	 * @since  4.0.0
	 * @access private
	 * @var bool
	 */
	private $config_changed;

	/**
	 * Whether or not the file writer is actually allowed to physically modify files.
	 *
	 * @since  4.0.0
	 * @access private
	 * @var bool
	 */
	private $write_files;

	/**
	 * Create and manage wp_config.php or .htaccess/nginx rewrites.
	 *
	 * Executes primary file actions at plugins_loaded.
	 *
	 * @since  4.0.0
	 *
	 * @return ITSEC_Files
	 */
	public function __construct() {

		$this->rewrites_changed = false;
		$this->config_changed   = false;
		$this->rewrite_rules    = array();
		$this->wpconfig_rules   = array();

		//look for the tweaks module to see if we should reset to 0444
		$tweaks = get_site_option( 'itsec_tweaks' );

		if ( false !== $tweaks && isset( $tweaks['write_permissions'] ) ) {

			$this->write_files = $tweaks['write_permissions'];

		} else {

			$this->write_files = false;

		}

		//Add the metabox
		add_action( 'itsec_add_admin_meta_boxes', array( $this, 'add_admin_meta_boxes' ) );
		add_action( 'plugins_loaded', array( $this, 'file_writer_init' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );

	}

	/**
	 * Add meta boxes to primary options pages.
	 *
	 * Adds the meta boxes containing rewrite rules that appears on the iThemes Security
	 * Dashboard.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	function add_admin_meta_boxes() {

		add_meta_box(
			'itsec_rewrite',
			__( 'Rewrite Rules', 'it-l10n-better-wp-security' ),
			array( $this, 'rewrite_metabox' ),
			'toplevel_page_itsec',
			'bottom',
			'core'
		);

		add_meta_box(
			'itsec_wpconfig',
			__( 'wp-config.php Rules', 'it-l10n-better-wp-security' ),
			array( $this, 'config_metabox' ),
			'toplevel_page_itsec',
			'bottom',
			'core'
		);

	}

	/**
	 * Processes file writing after saving options.
	 *
	 * Looks to see if rewrites_changed is true and starts file writing process as appropriate
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	public function admin_init() {

		global $itsec_globals;

		if ( true === $this->rewrites_changed && isset( $itsec_globals['settings']['write_files'] ) && true === $itsec_globals['settings']['write_files'] ) {

			do_action( 'itsec_pre_save_rewrites' );

			$rewrites = $this->save_rewrites();

			if ( is_array( $rewrites ) ) {

				if ( false === $rewrites['success'] ) {

					$type    = 'error';
					$message = $rewrites['text'];

					add_settings_error( 'itsec', esc_attr( 'settings_updated' ), $message, $type );

				} elseif ( true !== $rewrites['text'] ) {

					$type    = 'updated';
					$message = $rewrites['text'];

					add_settings_error( 'itsec', esc_attr( 'settings_updated' ), __( 'Settings Updated', 'it-l10n-better-wp-security' ) . '<br />' . $message, $type );

				}

			} else {

				add_site_option( 'itsec_manual_update', true );

			}

		} elseif ( true === $this->rewrites_changed ) {

			add_site_option( 'itsec_manual_update', true );

		}

		if ( true === $this->config_changed && isset( $itsec_globals['settings']['write_files'] ) && true === $itsec_globals['settings']['write_files'] ) {

			do_action( 'itsec_pre_save_configs' );

			$configs = $this->save_wpconfig();

			if ( is_array( $configs ) ) {

				if ( false === $configs['success'] ) {

					$type    = 'error';
					$message = $configs['text'];

					add_settings_error( 'itsec', esc_attr( 'settings_updated' ), $message, $type );

				}

				if ( 1 == get_site_option( 'itsec_clear_login' ) ) {

					delete_site_option( 'itsec_clear_login' );

					wp_clear_auth_cookie();

					$redirect_to = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '/wp-login.php?loggedout=true';
					wp_safe_redirect( $redirect_to );
					exit();

				}

			} else {

				add_site_option( 'itsec_manual_update', true );

			}

		} elseif ( true === $this->config_changed ) {

			add_site_option( 'itsec_manual_update', true );

		}

	}

	/**
	 * Builds server appropriate rewrite rules.
	 *
	 * Build the actually rewrite rules that can be written to the server or
	 * echoed to the user.
	 *
	 * @since  4.0.0
	 *
	 * @access private
	 *
	 * @return array|bool The rewrite rules to use or false if there are none
	 */
	private function build_rewrites() {

		$out_values    = array();
		$rewrite_rules = $this->rewrite_rules; //only get the htaccess portion

		uasort( $rewrite_rules, array( $this, 'priority_sort' ) ); //sort by priority

		foreach ( $rewrite_rules as $key => $value ) {

			if ( is_array( $value['rules'] ) && 0 < sizeof( $value['rules'] ) ) {

				$out_values[] = "\t# BEGIN " . $value['name']; //add section header

				foreach ( $value['rules'] as $rule ) {

					$out_values[] = "\t\t" . $rule; //write all the rules

				}

				$out_values[] = "\t# END " . $value['name']; //add section footer

			}

		}

		if ( 0 < sizeof( $out_values ) ) {
			return $out_values;
		} else {
			return false;
		}

	}

	/**
	 * Calls config metabox action.
	 *
	 * Allows a hook to add to the metabox containing the wp-config.php rules.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	public function config_metabox() {

		do_action( 'itsec_wpconfig_metabox' );

	}

	/**
	 * Echos content metabox contents.
	 *
	 * Echos the contents of the wp-config.php metabox
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	public function config_metabox_contents() {

		foreach ( $this->file_modules as $module ) {

			if ( isset( $module['config'] ) ) {

				call_user_func_array( $module['config'], array() );

			}

		}

		$rules_to_write = ''; //String of rules to insert into wp-config

		//build the rules we need to write, replace or delete
		foreach ( $this->wpconfig_rules as $section_rule ) {

			if ( is_array( $section_rule['rules'] ) ) {

				foreach ( $section_rule['rules'] as $rule ) {

					if ( ( isset( $rule['type'] ) && 'add' === $rule['type'] ) && false !== $rule['rule'] ) { //new rule or replacing a rule that doesn't exist

						$rules_to_write .= $rule['rule'] . PHP_EOL;

					}

				}

			}

		}

		if ( strlen( $rules_to_write ) > 1 ) {

			echo '<div class="itsec_rewrite_rules">' . highlight_string( $rules_to_write, true ) . '</div>';

		} else {

			_e( 'There are no rules to write.', 'it-l10n-better-wp-security' );

		}

	}

	/**
	 * Delete htaccess rules when plugin is deactivated.
	 *
	 * Deletes existing rules from .htaccess allowing for a  "clean slate"
	 * for writing the new rules.
	 *
	 * @since  4.0.0
	 *
	 * @access private
	 *
	 * @return bool true on success of false
	 */
	private function delete_rewrites() {

		$rule_open  = array( '# BEGIN iThemes Security', '# BEGIN Better WP Security' );
		$rule_close = array( '# END iThemes Security', '# END Better WP Security' );

		$htaccess_file = ITSEC_Lib::get_htaccess();

		//Make sure we can write to the file
		$perms = substr( sprintf( '%o', @fileperms( $htaccess_file ) ), - 4 );

		if ( '0444' == $perms || true === $this->write_files ) {
			@chmod( $htaccess_file, 0664 );
		}

		//make sure the file exists and create it if it doesn't
		if ( ! file_exists( $htaccess_file ) ) {

			@touch( $htaccess_file );

		}

		$htaccess_contents = @file_get_contents( $htaccess_file ); //get the contents of the htaccess or nginx file

		if ( false === $htaccess_contents ) { //we couldn't get the file contents

			return false;

		} else { //write out what we need to.

			$lines = explode( PHP_EOL, $htaccess_contents ); //create an array to make this easier
			$state = false;

			foreach ( $lines as $line_number => $line ) { //for each line in the file

				if ( false !== in_array( trim( $line ), $rule_open ) ) { //if we're at the beginning of the section
					$state = true;
				}

				if ( true == $state ) { //as long as we're not in the section keep writing

					unset( $lines[$line_number] );

				}

				if ( false !== in_array( trim( $line ), $rule_close ) ) { //see if we're at the end of the section
					$state = false;
				}

			}

			$htaccess_contents = trim( implode( PHP_EOL, $lines ) );

			if ( 1 > strlen( $htaccess_contents ) ) {
				$htaccess_contents = PHP_EOL;
			}

			if ( ! @file_put_contents( $htaccess_file, $htaccess_contents, LOCK_EX ) ) {
				return false;
			}

		}

		//reset file permissions if we changed them
		if ( '0444' == $perms || true === $this->write_files ) {
			@chmod( $htaccess_file, 0444 );
		}

		return true;

	}

	/**
	 * Execute activation functions.
	 *
	 * Writes necessary information to wp-config and .htaccess upon plugin activation.
	 *
	 * @since  4.0.0
	 *
	 * @return void
	 */
	public function do_activate() {

		$this->save_wpconfig();
		$this->save_rewrites();

	}

	/**
	 * Execute deactivation functions.
	 *
	 * Writes necessary information to wp-config and .htaccess upon plugin deactivation.
	 *
	 * @since  4.0.0
	 *
	 * @return void
	 */
	public function do_deactivate() {

		$this->delete_rewrites();
		$this->save_wpconfig();

	}

	/**
	 * Initialize file writer and rules arrays.
	 *
	 * Sets up initial information such as file locations and more to make
	 * calling quicker.
	 *
	 * @since  4.0.0
	 *
	 * @return void
	 */
	public function file_writer_init() {

		$this->file_modules = apply_filters( 'itsec_file_modules', $this->file_modules );

		if ( '1' == get_site_option( 'itsec_config_changed' ) || '1' == get_site_option( 'itsec_rewrites_changed' ) ) {

			$this->rewrites_changed = get_site_option( 'itsec_rewrites_changed' ) == '1' ? true : false;
			$this->config_changed   = get_site_option( 'itsec_config_changed' ) == '1' ? true : false;

			delete_site_option( 'itsec_rewrites_changed' );
			delete_site_option( 'itsec_config_changed' );

		}

	}

	/**
	 * Attempt to get a lock for atomic operations.
	 *
	 * Tries to get a more robust lock on the file in question. Useful in situations where automatic
	 * file locking doesn't work.
	 *
	 * @since  4.0.0
	 *
	 * @param string $lock_file file name of lock
	 * @param int    $exp       seconds until lock expires
	 *
	 * @return bool true if lock was achieved, else false
	 */
	public function get_file_lock( $lock_file, $exp = 180 ) {

		global $itsec_globals;

		clearstatcache();

		if ( isset( $itsec_globals['settings']['lock_file'] ) && true === $itsec_globals['settings']['lock_file'] ) {
			return true;
		}

		//Make sure the iThemes directory is actually there
		if ( ! @is_dir( $itsec_globals['ithemes_dir'] ) ) {

			@mkdir( $itsec_globals['ithemes_dir'] );
			$handle = @fopen( $itsec_globals['ithemes_dir'] . '/.htaccess', 'w+' );
			@fwrite( $handle, 'Deny from all' );
			@fclose( $handle );

		}

		$lock_file = $itsec_globals['ithemes_dir'] . '/' . sanitize_text_field( $lock_file ) . '.lock';
		$dir_age   = @filectime( $lock_file );

		if ( false === @mkdir( $lock_file ) ) {

			if ( false !== $dir_age ) {

				if ( ( time() - $dir_age ) > intval( $exp ) ) { //see if the lock has expired

					@rmdir( $lock_file );
					@mkdir( $lock_file );

				} else { //couldn't get the lock

					return false;

				}

			} else {

				return false;

			}

		}

		return true; //file lock was achieved

	}

	/**
	 * Retrieve config rules
	 *
	 * Get's the wp-config rules that have been saved by various features.
	 *
	 * @since 4.0.0
	 *
	 * @return array rewrite rules
	 */
	public function get_config_rules() {

		return $this->wpconfig_rules;

	}

	/**
	 * Retrieve rewrite rules
	 *
	 * Gets the .htaccess rewrite rules that have been saved by various features.
	 *
	 * @since 4.0.0
	 *
	 * @return array rewrite rules
	 */
	public function get_rewrite_rules() {

		return $this->rewrite_rules;

	}

	/**
	 * Sorts given arrays py priority key
	 *
	 * Allows for sorting of the rules array by a specified priority deeper in the array
	 *
	 * @since  4.0.0
	 *
	 * @access private
	 *
	 * @param  string $a value a
	 * @param  string $b value b
	 *
	 * @return int    -1 if a less than b, 0 if they're equal or 1 if a is greater
	 */
	private function priority_sort( $a, $b ) {

		if ( isset( $a['priority'] ) && isset( $b['priority'] ) ) {

			if ( $a['priority'] == $b['priority'] ) {
				return 0;
			}

			return $a['priority'] > $b['priority'] ? 1 : - 1;

		} else {

			return 1;

		}

	}

	/**
	 * Process quick ban of host.
	 *
	 * Immediately adds the supplied host to the .htaccess file for banning.
	 *
	 * @since 4.0.0
	 *
	 * @param string $host the host to ban
	 *
	 * @return bool true on success or false on failure
	 */
	public static function quick_ban( $host ) {

		$host = trim( $host );

		if ( ITSEC_Lib::validates_ip_address( trim( $host ) ) ) {

			$htaccess_file = ITSEC_Lib::get_htaccess();

			$host_rule = '#Quick ban IP. Will be updated on next formal rules save.' . PHP_EOL;

			if ( 'nginx' === ITSEC_Lib::get_server() ) { //NGINX rules

				$host_rule .= "\tdeny " . $host . ';' . PHP_EOL;

			} else { //rules for all other servers

				$dhost = str_replace( '.', '\\.', trim( $host ) ); //re-define $dhost to match required output for SetEnvIf-RegEX

				$host_rule .= "SetEnvIF REMOTE_ADDR \"^" . $dhost . "$\" DenyAccess" . PHP_EOL; //Ban IP
				$host_rule .= "SetEnvIF X-FORWARDED-FOR \"^" . $dhost . "$\" DenyAccess" . PHP_EOL; //Ban IP from Proxy-User
				$host_rule .= "SetEnvIF X-CLUSTER-CLIENT-IP \"^" . $dhost . "$\" DenyAccess" . PHP_EOL; //Ban IP for Cluster/Cloud-hosted WP-Installs
				$host_rule .= 'order allow,deny' . PHP_EOL;
				$host_rule .= 'deny from env=DenyAccess' . PHP_EOL;
				$host_rule .= 'deny from ' . trim( $host ) . PHP_EOL;
				$host_rule .= 'allow from all' . PHP_EOL;

			}

			//Make sure we can write to the file
			$perms = substr( sprintf( '%o', @fileperms( $htaccess_file ) ), - 4 );

			@chmod( $htaccess_file, 0664 );

			$htaccess_contents = @file_get_contents( $htaccess_file ); //get the contents of the htaccess or nginx file

			if ( false === $htaccess_contents ) {
				return false;
			}

			$htaccess_contents = preg_replace( "/(\\r\\n|\\n|\\r)/", PHP_EOL, $htaccess_contents );

			if ( false !== strpos( $htaccess_contents, '# BEGIN iThemes Security' ) ) {

				$htaccess_contents = str_replace( '# BEGIN iThemes Security' . PHP_EOL, '# BEGIN iThemes Security' . PHP_EOL . $host_rule, $htaccess_contents );

			} else {

				$htaccess_contents = '# BEGIN iThemes Security' . PHP_EOL . $host_rule . '# END iThemes Security' . PHP_EOL . $htaccess_contents;

			}

			@file_put_contents( $htaccess_file, $htaccess_contents, LOCK_EX );

			//look for the tweaks module to see if we should reset to 0444
			$tweaks = get_site_option( 'itsec_tweaks' );

			if ( false !== $tweaks && isset( $tweaks['write_permissions'] ) ) {

				$write_files = $tweaks['write_permissions'];

			} else {

				$write_files = false;

			}

			//reset file permissions if we changed them
			if ( '0444' == $perms || true === $write_files ) {
				@chmod( $htaccess_file, 0444 );
			}

		}

		return true;

	}

	/**
	 * Release the lock.
	 *
	 * Releases a file lock to allow others to use it.
	 *
	 * @since  4.0.0
	 *
	 * @param string $lock_file file name of lock
	 *
	 * @return bool true if released, false otherwise
	 */
	public function release_file_lock( $lock_file ) {

		global $itsec_globals;

		if ( isset( $itsec_globals['settings']['lock_file'] ) && true === $itsec_globals['settings']['lock_file'] ) {
			return true;
		}

		$lock_file = $itsec_globals['ithemes_dir'] . '/' . sanitize_text_field( $lock_file ) . '.lock';

		if ( ! is_dir( $lock_file ) ) {

			return true;

		} else {

			if ( ! @rmdir( $lock_file ) ) {

				@chmod( $itsec_globals['ithemes_dir'], 0775 );

				if ( file_exists( $lock_file . '/Thumbs.db' ) ) {
					unlink( $lock_file . '/Thumbs.db' );
				}

				return @rmdir( $lock_file );

			} else {

				return true;

			}

		}

	}

	/**
	 * Calls rewrite metabox action.
	 *
	 * Executes the action to draw the htaccess rewrite rules metabox
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	public function rewrite_metabox() {

		do_action( 'itsec_rewrite_metabox' );

	}

	/**
	 * Echos rewrite metabox content.
	 *
	 * Echos the rewrite rules in the dashboard.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	public function rewrite_metabox_contents() {

		foreach ( $this->file_modules as $module ) {

			if ( isset( $module['rewrite'] ) ) {

				call_user_func_array( $module['rewrite'], array() );

			}

		}

		$rewrite_rules = $this->build_rewrites();

		if ( is_array( $rewrite_rules ) && 0 < sizeof( $rewrite_rules ) ) {

			echo '<div class="itsec_rewrite_rules" readonly>';
			echo highlight_string( '# BEGIN iThemes Security', true ) . PHP_EOL;

			foreach ( $rewrite_rules as $rule ) {
				echo highlight_string( $rule, true ) . PHP_EOL;
			}

			echo highlight_string( '# END iThemes Security', true ) . PHP_EOL;

			echo '</div>';

		} else {

			_e( 'There are no rules to write.', 'it-l10n-better-wp-security' );

		}

	}

	/**
	 * Saves all rewrite rules to htaccess or similar file.
	 *
	 * Gets a file lock for .htaccess and calls the writing function if successful.
	 *
	 * @since  4.0.0
	 *
	 * @return mixed array or false if writing disabled or error message
	 */
	public function save_rewrites() {

		global $itsec_globals;

		if ( ! is_array( $this->file_modules ) ) {
			return false;
		}

		foreach ( $this->file_modules as $module ) {

			if ( isset( $module['rewrite'] ) ) {

				call_user_func_array( $module['rewrite'], array() );

			}

		}

		if ( 'nginx' == ITSEC_Lib::get_server() || ( isset( $itsec_globals['settings']['write_files'] ) && true === $itsec_globals['settings']['write_files'] ) ) {

			$success = $this->write_rewrites(); //save the return value for success/error flag

			if ( true === $success ) {

				if ( ITSEC_Lib::get_server() == 'nginx' ) {

					return array(
						'success' => true,
						'text'    => sprintf(
							'%s %s. %s',
							__( 'Your rewrite rules have been saved to', 'it-l10n-better-wp-security' ),
							$itsec_globals['settings']['nginx_file'],
							__( 'You must restart your NGINX server for the settings to take effect', 'it-l10n-better-wp-security' )
						),
					);

				} else {

					return array(
						'success' => true,
						'text'    => true,
					);

				}

			} else {

				return array(
					'success' => false,
					'text'    => __( 'Unable to write to your .htaccess or nginx.conf file. If the problem persists contact support.', 'it-l10n-better-wp-security' ),
				);

			}

		} else {

			return false;

		}

	}

	/**
	 * Saves all wpconfig rules to wp-config.php.
	 *
	 * Gets a file lock for wp-config.php and calls the writing function if successful.
	 *
	 * @since  4.0.0
	 *
	 * @return mixed array or false if writing disabled or error message
	 */
	public function save_wpconfig() {

		global $itsec_globals;

		if ( ! is_array( $this->file_modules ) ) {
			return false;
		}

		foreach ( $this->file_modules as $module ) {

			if ( isset( $module['config'] ) ) {

				call_user_func_array( $module['config'], array() );

			}

		}

		if ( isset( $itsec_globals['settings']['write_files'] ) && true === $itsec_globals['settings']['write_files'] ) {

			$success = $this->write_wpconfig(); //save the return value for success/error flag

			if ( true === $success ) {

				return array(
					'success' => true,
					'text'    => true,
				);

			} else {

				return array(
					'success' => false,
					'text'    => __( 'Unable to write to your wp-config.php file. If the problem persists contact support.', 'it-l10n-better-wp-security' ),
				);

			}

		} else {

			return false;

		}

	}

	/**
	 * Set rewrite rules
	 *
	 * Sets the current rewrite rules.
	 *
	 * @since 4.0.0
	 *
	 * @param array $rewrite_rules rewrite rules
	 *
	 * @return void
	 */
	public function set_rewrite_rules( $rewrite_rules ) {

		$this->rewrite_rules = $rewrite_rules;

	}

	/**
	 * Set config rules.
	 *
	 * Sets the currently available wp-config.php rules.
	 *
	 * @since 4.0.0
	 *
	 * @param array $wpconfig_rules rewrite rules
	 *
	 * @return void
	 */
	public function set_config_rules( $wpconfig_rules ) {

		$this->wpconfig_rules = $wpconfig_rules;

	}

	/**
	 * Sets rewrite rules (if updated after initialization).
	 *
	 * Sets the rewrite rules from a provided set.
	 *
	 * @since  4.0.0
	 *
	 * @param array $rules array of rules to add or replace
	 *
	 * @return void
	 */
	public function set_rewrites( $rules ) {

		if ( is_array( $rules ) ) {

			//Loop through each rule we send and have to find duplicates
			foreach ( $rules as $rule ) {

				$found = false;

				if ( is_array( $rule ) ) {

					if ( 0 < sizeof( $this->rewrite_rules ) ) {

						foreach ( $this->rewrite_rules as $key => $rewrite_rule ) {

							if ( $rule['name'] == $rewrite_rule['name'] ) {

								$found                     = true;
								$this->rewrite_rules[$key] = $rule;

							}

							if ( true === $found ) { //don't keep looping if we don't have to
								break;
							}

						}

					}

					if ( false === $found ) {

						$this->rewrite_rules[] = $rule;

					} else {

						break;

					}

				}

			}

		}

	}

	/**
	 * Sets wp-config.php rules (if updated after initialization).
	 *
	 * Sets the current wp-config rules if updated later in the process.
	 *
	 * @since  4.0.0
	 *
	 * @param array $rules array of rules to add or replace
	 */
	public function set_wpconfig( $rules ) {

		if ( is_array( $rules ) ) {

			//Loop through each rule we send and have to find duplicates
			foreach ( $rules as $rule ) {

				$found = false;

				if ( is_array( $rule ) ) {

					if ( 0 < sizeof( $this->wpconfig_rules ) ) {

						foreach ( $this->wpconfig_rules as $key => $wpconfig_rule ) {

							if ( $rule['name'] == $wpconfig_rule['name'] ) {

								$found                      = true;
								$this->wpconfig_rules[$key] = $rule;

							}

							if ( true === $found ) { //don't keep looping if we don't have to
								break;
							}

						}

					}

					if ( false === $found ) {

						$this->wpconfig_rules[] = $rule;

					} else {

						break;

					}

				}

			}

		}

	}

	/**
	 * Writes given rules to htaccess or related file
	 *
	 * Writes the rewrite rules to the appropriate file
	 *
	 * @since  4.0.0
	 *
	 * @access private
	 *
	 * @return bool true on success, false on failure
	 */
	private function write_rewrites() {

		$rules_to_write = $this->build_rewrites(); //String of rules to insert into

		if ( false === $rules_to_write ) { //if there is nothing to write make sure we clean up the file

			return $this->delete_rewrites();

		}

		$rule_open  = array( '# BEGIN iThemes Security', '# BEGIN Better WP Security' );
		$rule_close = array( '# END iThemes Security', '# END Better WP Security' );

		$htaccess_file = ITSEC_Lib::get_htaccess();

		//make sure the file exists and create it if it doesn't
		if ( ! file_exists( $htaccess_file ) ) {

			@touch( $htaccess_file );

		}

		$htaccess_contents = @file_get_contents( $htaccess_file ); //get the contents of the htaccess or nginx file

		$htaccess_contents = preg_replace( "/(\\r\\n|\\n|\\r)/", PHP_EOL, $htaccess_contents );

		if ( false === $htaccess_contents ) { //we couldn't get the file contents

			return false;

		} else { //write out what we need to.

			$lines = explode( PHP_EOL, $htaccess_contents ); //create an array to make this easier
			$state = false;

			foreach ( $lines as $line_number => $line ) { //for each line in the file

				if ( false !== in_array( $line, $rule_open ) ) { //if we're at the beginning of the section
					$state = true;
				}

				if ( true == $state ) { //as long as we're not in the section keep writing

					unset( $lines[$line_number] );

				}

				if ( false !== in_array( $line, $rule_close ) ) { //see if we're at the end of the section
					$state = false;
				}

			}

			if ( 0 < sizeof( $rules_to_write ) ) { //make sure we have something to write

				$htaccess_contents = $rule_open[0] . PHP_EOL . implode( PHP_EOL, $rules_to_write ) . PHP_EOL . $rule_close[0] . PHP_EOL . implode( PHP_EOL, $lines );

			}

			//Actually write the new content to wp-config.
			if ( false !== $htaccess_contents ) {

				//Make sure we can write to the file
				$perms = substr( sprintf( '%o', @fileperms( $htaccess_file ) ), - 4 );

				@chmod( $htaccess_file, 0664 );

				if ( ! @file_put_contents( $htaccess_file, $htaccess_contents, LOCK_EX ) ) {

					//reset file permissions if we changed them
					if ( '0444' == $perms || true === $this->write_files ) {
						@chmod( $htaccess_file, 0444 );
					}

					return false;

				}

				//reset file permissions if we changed them
				if ( '0444' == $perms || true === $this->write_files ) {
					@chmod( $htaccess_file, 0444 );
				}

			}

		}

		return true;

	}

	/**
	 * Writes given rules to wp-config.php.
	 *
	 * Writes available rules to wp-config.php.
	 *
	 * @since  4.0.0
	 *
	 * @access private
	 *
	 * @return bool true on success, false on failure
	 */
	private function write_wpconfig() {

		$config_file = ITSEC_Lib::get_config();

		if ( file_exists( $config_file ) ) { //check wp-config.php exists where we think it should

			$config_contents = @file_get_contents( $config_file ); //get the contents of wp-config.php

			if ( ! $config_contents ) { //we couldn't get wp-config.php contents

				return false;

			} else { //write out what we need to.

				$rules_to_write  = ''; //String of rules to insert into wp-config
				$rule_to_replace = false; //String containing a rule to be replaced
				$rules_to_delete = false; //assume we're not deleting anything to start
				$replace         = false; //assume we're note replacing anything to start with

				//build the rules we need to write, replace or delete
				foreach ( $this->wpconfig_rules as $section_rule ) {

					if ( is_array( $section_rule['rules'] ) ) {

						foreach ( $section_rule['rules'] as $rule ) {

							$found = false;

							if ( 'add' === $rule['type'] && false !== $rule['rule'] ) { //new rule or replacing a rule that doesn't exist

								$rules_to_write .= $rule['rule'] . PHP_EOL;

							} elseif ( 'replace' === $rule['type'] && false !== $rule['rule'] && false !== strpos( $config_contents, $rule['search_text'] ) ) {

								if ( $rule_to_replace === false ) {
									$rule_to_replace = array();
								}

								//Replacing a rule that does exist. Note this will only work on one rule at a time
								$rule_to_replace[$rule['search_text']] = $rule['rule'];
								$found                                 = true;

							}

							if ( true !== $found ) {

								//deleting a rule.
								if ( false === $rules_to_delete ) {
									$rules_to_delete = array();
								}

								$rules_to_delete[] = $rule;

							}

						}

					}

				}

				//deleting a rule.
				if ( false === $rules_to_delete ) {
					$rules_to_delete = array();
				}

				$rules_to_delete[]['search_text'] = "BWPS_FILECHECK";
				$rules_to_delete[]['search_text'] = "BWPS_AWAY_MODE";

				//delete and replace
				if ( false !== $replace || is_array( $rules_to_delete ) ) {

					$config_array = explode( PHP_EOL, $config_contents );

					if ( is_array( $rules_to_delete ) ) {

						$delete_count = 0;
						$delete_total = sizeof( $rules_to_delete );

					} else {

						$delete_total = 0;
						$delete_count = 0;

					}

					foreach ( $config_array as $line_number => $line ) {

						if ( is_array( $rule_to_replace ) ) {

							foreach ( $rule_to_replace as $search_text => $rule ) {

								if ( false !== strpos( $line, $search_text ) ) {
									$config_array[$line_number] = $rule;
								}

							}

						}

						if ( $delete_count < $delete_total ) {

							foreach ( $rules_to_delete as $rule ) {

								if ( false !== strpos( $line, $rule['search_text'] ) ) {

									unset( $config_array[$line_number] );

									//delete the following line(s) if they is blank
									$count = 1;

									while ( isset( $config_array[$line_number + $count] ) && 1 > strlen( trim( $config_array[$line_number + $count] ) ) ) {

										unset( $config_array[$line_number + 1] );

									}

									$delete_count ++;

								}

							}

						}

					}

					$config_contents = implode( PHP_EOL, $config_array );

				}

				//Adding a new rule or replacing rules that don't exist
				if ( 1 < strlen( $rules_to_write ) ) {
					$config_contents = str_replace( '<?php' . PHP_EOL, '<?php' . PHP_EOL . $rules_to_write . PHP_EOL, $config_contents );
				}

			}

		}

		//Actually write the new content to wp-config.
		if ( isset( $config_contents ) && false !== $config_contents ) {

			//Make sure we can write to the file
			$perms = substr( sprintf( '%o', @fileperms( $config_file ) ), - 4 );

			@chmod( $config_file, 0664 );

			if ( ! @file_put_contents( $config_file, $config_contents, LOCK_EX ) ) {

				//reset file permissions if we changed them
				if ( '0444' == $perms || true === $this->write_files ) {
					@chmod( $config_file, 0444 );
				}

				return false;
			}

			//reset file permissions if we changed them
			if ( '0444' == $perms || true === $this->write_files ) {
				@chmod( $config_file, 0444 );
			}

		}

		return true;

	}

}
