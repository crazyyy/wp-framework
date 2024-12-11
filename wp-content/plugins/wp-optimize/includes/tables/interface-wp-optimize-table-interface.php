<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!interface_exists('WP_Optimize_Table_Interface')) :

interface WP_Optimize_Table_Interface {

	/**
	 * Return the table name for this object
	 *
	 * @return string
	 */
	public function get_table_name();

	/**
	 * Return an array with `dbDelta()` field strings (and keys)
	 * [
	 * 	fields => [name => SQL],
	 *  keys   => [name => SQL]
	 * ]
	 *
	 * @return array
	 */
	public function describe();

	/**
	 * Returns singleton instance
	 *
	 * @return WP_Optimize_Table_Interface
	 */
	public static function get_instance();
}

endif;
