<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (!class_exists('WP_Optimize_Table_Management')) :

class WP_Optimize_Table_Management {
	
	/**
	 * Utilities
	 *
	 * @var array
	 */
	private $plugin_utils = array();

	/**
	 * Populate `$this->plugin_utils` for later usage.
	 *
	 * @return void
	 */
	private function __construct() {
		$this->plugin_utils[] = new WP_Optimize_Table_404_Detector();
	}
	
	/**
	 * Returns singleton instance of this class
	 *
	 * @return WP_Optimize_Table_Management Singleton Instance
	 */
	public static function get_instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Create all the tables that will be used by this plugin
	 *
	 * @return void
	 */
	public function create_plugin_tables() {
		/* @var $util WP_Optimize_Table_Interface */
		foreach ($this->plugin_utils as $util) {
			$table_name = $util->get_table_name();

			if (!$this->table_exists($table_name)) {
				$table_description = $util->describe();
				$create_table = $this->generate_create_statement($table_name, $table_description);

				require_once ABSPATH.'wp-admin/includes/upgrade.php';

				dbDelta($create_table);
			}
		}
	}

	/**
	 * Remove all tables that were created by this plugin
	 *
	 * @return void
	 */
	public function delete_plugin_tables() {
		global $wpdb;

		foreach ($this->plugin_utils as $util) {
			$wpdb->query(sprintf("DROP TABLE IF EXISTS %s", $util->get_table_name()));
		}
	}

	/**
	 * Check for the existence of a table
	 *
	 * @param string $table_name The name of the table we are searching for
	 * @return bool
	 */
	private function table_exists($table_name) {
		global $wpdb;

		return $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE '%s'", $table_name)) == $table_name;
	}

	/**
	 * Compile the SQL that is going to be sent to WP's dbDelta()
	 *
	 * @param string $table_name        The name of the table to be created
	 * @param array  $table_description Definition of the table to be created
	 * @return string
	 */
	private function generate_create_statement($table_name, $table_description) {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$keys_sql = $this->generate_keys_sql($table_description);

		$fields_sql = $this->generate_fields_sql($table_description);

		return "CREATE TABLE `$table_name` (
			ID int(11) UNSIGNED NOT NULL auto_increment, 
			" . implode(",\n", $fields_sql) . ",
			PRIMARY KEY  (ID)" . implode(",\n", $keys_sql) . "
		) $charset_collate";
	}
	
	/**
	 * Compile the SQL for the keys piece of the creation statement
	 *
	 * @param array $table_description Definition of the table, including keys
	 * @return array
	 */
	private function generate_keys_sql($table_description) {
		$keys_sql = array();
		if (isset($table_description['keys']) && is_array($table_description['keys'])) {
			$keys_sql = array(''); // This will add the first comma after `PRIMARY KEY` block
			foreach ($table_description['keys'] as $key_name => $key_def) {
				$keys_sql[] = 'KEY `' . $key_name . '` ' . $key_def;
			}
		}

		if (isset($table_description['unique']) && is_string($table_description['unique'])) {
			if (empty($keys_sql)) $keys_sql = array('');

			$keys_sql[] = 'UNIQUE (' . $table_description['unique'] . ')';
		}

		return $keys_sql;
	}

	/**
	 * Compile the SQL for the fields piece of the create statement
	 *
	 * @param array $table_description Definition of the table, including keys
	 * @return array
	 */
	private function generate_fields_sql($table_description) {
		$fields_sql = array();
		foreach ($table_description['fields'] as $field_name => $field_def) {
			$fields_sql[] = '`' . $field_name . '` ' . $field_def;
		}

		return $fields_sql;
	}
}

endif;
