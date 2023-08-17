<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_Blocked_IP extends AIOWPSecurity_List_Table {

	public function __construct() {
		global $status, $page;

		//Set parent defaults
		parent::__construct(array(
			'singular' => 'item',     //singular name of the listed records
			'plural' => 'items',    //plural name of the listed records
			'ajax' => false        //does this table support ajax?
		));

	}

	public function column_default($item, $column_name) {
		return $item[$column_name];
	}

	public function column_id($item) {
		$tab = isset($_REQUEST['tab']) ? strip_tags($_REQUEST['tab']) : '';
		//Add nonce to delete URL
		$unblock_ip_url = sprintf('admin.php?page=%s&tab=%s&action=%s&blocked_id=%s', AIOWPSEC_MAIN_MENU_SLUG, $tab, 'unblock_ip', $item['id']);
		//Add nonce to unlock IP URL
		$unblock_ip_nonce = wp_nonce_url($unblock_ip_url, "unblock_ip", "aiowps_nonce");

		//Build row actions
		$actions = array(
			'unblock' => '<a href="' . $unblock_ip_nonce . '" onclick="return confirm(\'Are you sure you want to unblock this IP address?\')">Unblock</a>',
		);

		//Return the user_login contents
		return sprintf('%1$s <span style="color:silver"></span>%2$s',
			/*$1%s*/
			$item['id'],
			/*$2%s*/
			$this->row_actions($actions)
		);
	}


	public function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/
			$this->_args['singular'],  //Let's simply repurpose the table's singular label
			/*$2%s*/
			$item['id']                //The value of the checkbox should be the record's id
		);
	}

	public function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />', //Render a checkbox
			'id' => 'ID',
			'blocked_ip' => __('Blocked IP', 'all-in-one-wp-security-and-firewall'),
			'block_reason' => __('Reason', 'all-in-one-wp-security-and-firewall'),
			'blocked_date' => __('Date', 'all-in-one-wp-security-and-firewall')
		);
		return $columns;
	}

	public function get_sortable_columns() {
		$sortable_columns = array(
			'id' => array('id', false),
			'blocked_ip' => array('blocked_ip', false),
			'block_reason' => array('block_reason', false),
			'blocked_date' => array('blocked_date', false)
		);
		return $sortable_columns;
	}

	public function get_bulk_actions() {
		$actions = array(
			'unblock' => __('Unblock', 'all-in-one-wp-security-and-firewall')
		);
		return $actions;
	}

	private function process_bulk_action() {
		if (empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'bulk-items')) return;

		if ('unblock' === $this->current_action()) { // Process unlock bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->unblock_ip_address(($_REQUEST['item']));
			}
		}
	}

	/**
	 * Deletes one or more records from the AIOWPSEC_TBL_PERM_BLOCK table.
	 *
	 * @param Array|String|Integer - ids or a single id
	 *
	 * @return Void
	 */
	public function unblock_ip_address($entries) {
		global $wpdb, $aio_wp_security;
		if (is_array($entries)) {
			if (isset($_REQUEST['_wp_http_referer'])) {
				// multiple records
				$tab = strip_tags($_REQUEST['tab']);

				$entries = array_filter($entries, 'is_numeric'); //discard non-numeric ID values
				$id_list = "(" . implode(",", $entries) . ")"; //Create comma separate list for DB operation
				$delete_command = "DELETE FROM " . AIOWPSEC_TBL_PERM_BLOCK . " WHERE id IN " . $id_list;
				$result = $wpdb->query($delete_command);
				if ($result) {
					AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('Successfully unblocked and deleted the selected record(s).', 'all-in-one-wp-security-and-firewall'));
				} else {
					// Error on bulk delete
					$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Perm Block table. Database error: '.$wpdb->last_error, 4);
					AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Failed to unblock and delete the selected record(s).', 'all-in-one-wp-security-and-firewall'));
				}
			}
		} elseif ($entries != NULL) {
			$nonce = isset($_GET['aiowps_nonce']) ? $_GET['aiowps_nonce'] : '';
			if (!isset($nonce) || !wp_verify_nonce($nonce, 'unblock_ip')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for unblock IP operation!", 4);
				die(__('Nonce check failed for unblock IP operation!', 'all-in-one-wp-security-and-firewall'));
			}
			//Delete single record
			$delete_command = "DELETE FROM " . AIOWPSEC_TBL_PERM_BLOCK . " WHERE id = '" . absint($entries) . "'";
			$result = $wpdb->query($delete_command);
			if ($result) {
				AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('Successfully unblocked and deleted the selected record(s).', 'all-in-one-wp-security-and-firewall'));
			} elseif ($result === false) {
				// Error on single delete
				$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Perm Block table. Database error: '.$wpdb->last_error, 4);
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Failed to unblock and delete the selected record(s).', 'all-in-one-wp-security-and-firewall'));
			}
		}
	}

	/**
	 * This function will build and return the SQL WHERE statement
	 *
	 * @param string $search_term - the search term applied
	 * @return string - the SQL WHERE statement
	 */
	private function get_permanent_blocked_ip_list_where_sql($search_term){
		$where = '';
		if (!empty($search_term)) {
			$where = " WHERE";

			// We don't use FILTER_VALIDATE_IP here as we want to be able to search for partial IP's
			if (preg_match('/^[0-9a-f:\.]+$/i', $search_term)) {
				$where .= " `blocked_ip` LIKE '%".esc_sql($search_term)."%' OR";
			}

			$where .= " `block_reason` LIKE '%".esc_sql($search_term)."%'";
			$where .= " OR `country_origin` LIKE '%".esc_sql($search_term)."%'";
		}

		return $where;
	}

	/**
	 * Grabs the data from database and handles the pagination
	 * 
	 * @param boolean $ignore_pagination - whether to not paginate
	 *
	 * @return void
	 *
	 */
	public function prepare_items($ignore_pagination = false) {
		/**
		 * First, lets decide how many records per page to show
		 */
		$per_page = 100;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$search = isset( $_REQUEST['s'] ) ? sanitize_text_field( $_REQUEST['s'] ) : '';

		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();

		global $wpdb;
		$block_table_name = AIOWPSEC_TBL_PERM_BLOCK;

		/* -- Ordering parameters -- */
		//Parameters that are going to be used to order the result
		isset($_GET["orderby"]) ? $orderby = strip_tags($_GET["orderby"]) : $orderby = '';
		isset($_GET["order"]) ? $order = strip_tags($_GET["order"]) : $order = '';

		$orderby = !empty($orderby) ? esc_sql($orderby) : 'id';
		$order = !empty($order) ? esc_sql($order) : 'DESC';

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		$current_page = $this->get_pagenum();
		$offset = ($current_page - 1) * $per_page;


		$search_query = $this->get_permanent_blocked_ip_list_where_sql($search);

		$total_items = $wpdb->get_var("SELECT COUNT(*) FROM {$block_table_name}{$search_query}");

		if ($ignore_pagination) {
			$data = $wpdb->get_results("SELECT * FROM {$block_table_name} {$search_query} ORDER BY {$orderby} {$order}", 'ARRAY_A');
		}else{
			$data = $wpdb->get_results("SELECT * FROM {$block_table_name}{$search_query} ORDER BY {$orderby} {$order} LIMIT {$per_page} OFFSET {$offset}", 'ARRAY_A');
		}

		$this->items = $data;

		if ($ignore_pagination) return;

		$this->set_pagination_args(array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page' => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
		));
	}
}