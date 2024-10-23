<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_List_Debug_Log extends AIOWPSecurity_List_Table {

	/**
	 * Sets up some table attributes (i.e: the plurals and whether it's ajax or not)
	 */
	public function __construct() {


		//Set parent defaults
		parent::__construct(array(
			'singular' => 'entry',     //singular name of the listed records
			'plural' => 'entries',    //plural name of the listed records
			'ajax' => false        //does this table support ajax?
		));

	}
	
	/**
	 * Returns logtime column in datetime format as per user setting time zone.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the datetime
	 */
	public function column_logtime($item) {
		return AIOWPSecurity_Utility::convert_timestamp($item['logtime']);
	}

	/**
	 * This function renders a default column item
	 *
	 * @param array  $item        - Item object
	 * @param string $column_name - Column name to be rendered from item object
	 *
	 * @return mixed - data to be rendered for column
	 */
	public function column_default($item, $column_name) {
		return $item[$column_name];
	}

	/**
	 * Sets the columns for the table
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'logtime' => __('Date and time', 'all-in-one-wp-security-and-firewall'),
			'level' => __('Level', 'all-in-one-wp-security-and-firewall'),
			'network_id' => __('Network ID', 'all-in-one-wp-security-and-firewall'),
			'site_id' => __('Site ID', 'all-in-one-wp-security-and-firewall'),
			'message' => __('Message', 'all-in-one-wp-security-and-firewall'),
			'type' => __('Type', 'all-in-one-wp-security-and-firewall')
		);
	}

	/**
	 * Sets which of the columns the table data can be sorted by
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'logtime' => array('logtime', false),
			'level' => array('level', false),
			'network_id' => array('network_id', false),
			'site_id' => array('site_id', false),
			'message'=>array('message', false),
			'type' => array('type', false)
		);
	}

	/**
	 * Grabs the data from database and handles the pagination
	 *
	 * @param boolean $ignore_pagination - whether to not paginate
	 *
	 * @return void
	 */
	public function prepare_items($ignore_pagination = false) {
		/**
		 * First, lets decide how many records per page to show
		 */
		if (defined('AIOWPSEC_DEBUG_LOG_PER_PAGE')) {
			$per_page = absint(AIOWPSEC_DEBUG_LOG_PER_PAGE);
		}

		$per_page = empty($per_page) ? 15 : $per_page;
		$current_page = $this->get_pagenum();
		$offset = ($current_page - 1) * $per_page;
		$columns = $this->get_columns();
		$hidden = array('id'); // we really don't need the IDs of the log entries displayed
		if (!is_multisite()) {
			$hidden[] = 'network_id';
			$hidden[] = 'site_id';
		}
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);

		global $wpdb;

		$debug_log_tbl = AIOWPSEC_TBL_DEBUG_LOG;

		/* -- Ordering parameters -- */

		//Parameters that are going to be used to order the result
		isset($_GET["orderby"]) ? $orderby = strip_tags($_GET["orderby"]) : $orderby = '';
		isset($_GET["order"]) ? $order = strip_tags($_GET["order"]) : $order = '';

		// By default show the most recent debug log entries.
		$orderby = !empty($orderby) ? esc_sql($orderby) : 'logtime';
		$order = !empty($order) ? esc_sql($order) : 'DESC';

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		$orderby = sanitize_sql_orderby($orderby);
		$order = sanitize_sql_orderby($order);

		$where_sql = (!is_super_admin()) ? 'WHERE site_id = '.get_current_blog_id() : '';

		if ($ignore_pagination) {
			$data = $wpdb->get_results("SELECT * FROM {$debug_log_tbl} {$where_sql} ORDER BY {$orderby} {$order}", 'ARRAY_A');
		} else {
			$data = $wpdb->get_results("SELECT * FROM {$debug_log_tbl} {$where_sql} ORDER BY {$orderby} {$order} LIMIT {$per_page} OFFSET {$offset}", 'ARRAY_A');
		}
		$total_items = $wpdb->get_var("SELECT COUNT(*) FROM {$debug_log_tbl} {$where_sql}");
		$this->items = $data;

		if ($ignore_pagination) return;

		$this->set_pagination_args(array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page' => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
		));
	}
}
