<?php
if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WP_Optimize_Queries_List_Table')) :

class WP_Optimize_Queries_List_Table extends WP_List_Table {

	/**
	 * WP column headers definition
	 *
	 * @var array
	 */
	public $_column_headers;

	/**
	 * WP table property for table items
	 *
	 * @var array
	 */
	public $items;

	/**
	 * {@inheritdoc}
	 */
	public function get_columns() {
		$columns = array(
			'last_used' => __('Last access', 'wp-optimize'),
			'table_name' => __('Table name', 'wp-optimize'),
			'total_queries'	=> __('Total queries', 'wp-optimize'),
			'avg_per_min' => __('Average executions per minute', 'wp-optimize'),
			'avg_time' => __('Average query time', 'wp-optimize'),
			'slow_queries_count' => __('Slow queries', 'wp-optimize'),
			'slow_queries_detail' => __('Details', 'wp-optimize')
		);

		return $columns;
	}

	/**
	 * {@inheritdoc}
	 */
	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		$this->items = array();
	}

	/**
	 * Append a new item to the standard table
	 *
	 * @param array $row The information for each column of the new row
	 *                   Example:
	 *                   [
	 * 	                 "table_name" => string,  # Name of the table
	 *                   "last_used"  => datetime, # string Last execution timestamp
	 *                   "total_queries" => integer, # Total execution count
	 *                   "avg_per_min" => float, # Average total executions per minute for the query group
	 *                   "avg_time" => float, # Average execution time for the query group
	 *                   "slow_queries_count" => integer, # How many slow queries were detected
	 *                   "slow_queries_detail" => string, # Extended information about slow queries
	 *                   ]
	 * @return void
	 */
	public function add_item($row) {
		$this->items[] = $row;
	}

	/**
	 * Parse the column value
	 *
	 * @param array  $item        The row data
	 * @param string $column_name What column are we parsing
	 * @return string|integer
	 */
	public function column_default($item, $column_name) {
		return $item[$column_name];
	}
}

endif;
