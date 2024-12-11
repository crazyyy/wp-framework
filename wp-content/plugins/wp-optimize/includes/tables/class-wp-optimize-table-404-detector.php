<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!class_exists('WP_Optimize_Table_404_Detector')) :

class WP_Optimize_Table_404_Detector implements WP_Optimize_Table_Interface {

	/**
	 * Name of the table
	 *
	 * @var string
	 */
	private $table_name = '404_detector';

	/**
	 * Complete table name with prefix
	 *
	 * @return string
	 */
	public function get_table_name() {
		global $wpdb;

		return $wpdb->base_prefix . 'wpo_' . $this->table_name;
	}

	/**
	 * Table fields and keys (if any)
	 *
	 * @return array
	 */
	public function describe() {
		return array(
			'fields' => array(
				'url'               => 'TEXT NOT NULL',
				'request_timestamp' => 'BIGINT UNSIGNED NOT NULL',
				'request_count'     => 'BIGINT UNSIGNED NOT NULL',
				'referrer'          => 'TEXT NOT NULL'
			),
			'keys' => array(
				'url_timestamp_referrer' => '(url(75),request_timestamp,referrer(75))',
				'timestamp_count'        => '(request_timestamp,request_count)'
			),
			'unique' => 'url(75),request_timestamp,referrer(75)'
		);
	}

	/**
	 * Returns singleton instance
	 *
	 * @return WP_Optimize_Table_404_Detector
	 */
	public static function get_instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new self();
		}
		return $instance;
	}
}

endif;
