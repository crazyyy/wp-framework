<?php
namespace AIOWPS\Firewall;

class Message_Store {

	/**
	 * Makes this class a singleton
	 */
	use Singleton_Trait;

	/**
	 * Internal store of the messages
	 *
	 * @var array
	 */
	private $messages;

	/**
	 * Holds the name of the message store's table
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * A key should only be loaded from the database once per request; this keeps track of them
	 *
	 * @var array
	 */
	private $keys_loaded;

	/**
	 * Constructs our object
	 */
	private function __construct() {
		Event::capture('action_before_exit', array($this, 'dump'));
		$this->messages      = array();
		$this->keys_loaded   = array();
		$this->table_name    = 'aiowps_message_store';
	}

	/**
	 * Sets internal message store
	 *
	 * @param string $key
	 * @param mixed  $value
	 * @return void
	 */
	public function set($key, $value) {
		
		if (!is_string($key)) return;

		if (!isset($this->messages[$key])) {
			$this->messages[$key] = array();
		}

		$this->messages[$key][] = $value;
	}

	/**
	 * Gets the messages associated with a key
	 *
	 * @param string $key
	 * @return array
	 */
	public function get($key) {

		$is_key_loaded  = in_array($key, $this->keys_loaded);
		$can_check_database = isset($GLOBALS['wpdb']) && !$is_key_loaded && class_exists('Updraft_Semaphore_3_0');

		//Load requested messages from the database
		if ($can_check_database) {

			$lock = new \Updraft_Semaphore_3_0('aios_message_store_lock_'.$key, 60);
			$to_delete = array();

			if ($lock->lock()) {

				try {
					global $wpdb;

					$table = $this->get_table();

					// If we can't get the table to check the DB, still check our internal store for the key
					if (empty($table)) return isset($this->messages[$key]) ? $this->messages[$key] : array();

					// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
					$rows = $wpdb->get_results($wpdb->prepare("SELECT id, message_value FROM `{$table}` WHERE message_key = %s", $key));

					if (!empty($rows)) {
					
						foreach ($rows as $row) {
							$values = json_decode($row->message_value, true);

							foreach ($values as $value) $this->set($key, $value);

							$to_delete[] = $row->id;
						}
						
						$this->keys_loaded[] = $key;
					}
				} catch (\Exception $e) {
					// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- PCP warning. Necessary for AIOS error reporting system.
					error_log("AIOS: Error getting database entries for key '{$key}': {$e->getMessage()}");

				} catch (\Error $e) { // phpcs:ignore PHPCompatibility.Classes.NewClasses.errorFound -- this won't run on PHP 5.6 so we still want to catch it on other versions
					// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- PCP warning. Necessary for AIOS error reporting system.
					error_log("AIOS: Error getting database entries for key '{$key}': {$e->getMessage()}");
				} finally {

					//Delete IDs of loaded messages
					if (!empty($to_delete)) {
						$ids = implode(',', $to_delete);
						// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
						$wpdb->query("DELETE FROM `{$table}` WHERE id IN ({$ids})");
					}

					$lock->release();
				}

			}
		}
		
		return isset($this->messages[$key]) ? $this->messages[$key] : array();
	}

	/**
	 * Dumps the message store to the database
	 *
	 * @return void
	 */
	public function dump() {
		//No point saving if there are no messages
		if (empty($this->messages)) return;
		
		if (!Utility::attempt_to_access_wpdb()) throw new Exit_Exception('Unable to save the message store to the database: wpdb is inaccessible.');

		global $wpdb;

		$table = $this->get_table();

		if (empty($table)) throw new Exit_Exception('Unable to save messages store to the database: unable to get the correct table.');

		$statement = "INSERT INTO `{$table}` (message_key, message_value, created) VALUES ";
		$values = array();

		foreach ($this->messages as $key => $value) {
			$statement .= '(%s, %s, %s),';
			$values[] = $table;
			$values[] = $key;
			$values[] = json_encode($value); // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode -- This method runs outside the WordPress environment and therefore cannot use WordPress functions.
			$values[] = time();
		}

		$statement = rtrim($statement, ',');

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery -- PCP error. Prepared above.
		$wpdb->query($wpdb->prepare($statement, $values));
	}

	/**
	 * Returns the table name if it exists
	 *
	 * @return string - Table name on success; blank string otherwise
	 */
	private function get_table() {
		global $wpdb;

		if (!$wpdb) return '';

		$table = $wpdb->get_blog_prefix(0).$this->table_name;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
		if ($table != $wpdb->get_var("SHOW TABLES LIKE '{$table}'")) return '';

		return $table;
	}

	/**
	 * Clears all the messages from the message store table if it contains data.
	 *
	 * @return void
	 */
	public function clear_message_store() {
		global $wpdb;

		$table = $this->get_table();

		// Check if the table exists and is accessible
		if (empty($table)) {
			return;
		}

		//Check if the table has any rows
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- PCP warning. Direct query necessary. No caching necessary.
		$row_exists = $wpdb->get_var(
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- PCP error. Ignore.
			$wpdb->prepare("SELECT EXISTS (SELECT 1 FROM `{$table}` LIMIT 1)")
		);
	
		// If there are no rows, $row_exists will be 0
		if (!$row_exists) {
			return;
		}

		// Clear the table (delete all records)
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
		$wpdb->query($wpdb->prepare("DELETE FROM `{$table}`"));
	}
}
