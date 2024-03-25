<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_Logged_In_Users extends AIOWPSecurity_List_Table {

	public function __construct() {

		
		//Set parent defaults
		parent::__construct(array(
			'singular'  => 'item',     //singular name of the listed records
			'plural'    => 'items',    //plural name of the listed records
			'ajax'      => false        //does this table support ajax?
		));
		
	}

	public function column_default($item, $column_name) {
		return $item[$column_name];
	}
	
	/**
	 * Returns user id column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_user_id($item) {
		$tab = 'logged-in-users';
		$force_logout_url = sprintf('admin.php?page=%s&tab=%s&action=%s&logged_in_id=%s&ip_address=%s', AIOWPSEC_USER_SECURITY_MENU_SLUG, $tab, 'force_user_logout', $item['user_id'], $item['ip_address']);
		//Add nonce to URL
		$force_logout_nonce = wp_nonce_url($force_logout_url, "force_user_logout", "aiowps_nonce");
		
		//Build row actions
		$actions = array(
			'logout' => '<a href="'.$force_logout_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to force this user to be logged out of this session?', 'all-in-one-wp-security-and-firewall')) . '\')">'. __('Force logout', 'all-in-one-wp-security-and-firewall') . '</a>',
		);
		
		//Return the user_login contents
		return sprintf('%1$s <span style="color:silver"></span>%2$s',
			/*$1%s*/ $item['user_id'],
			/*$2%s*/ $this->row_actions($actions)
		);
	}

	/**
	 * Sets the columns for the table
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'user_id' => __('User ID', 'all-in-one-wp-security-and-firewall'),
			'username' => __('Login name', 'all-in-one-wp-security-and-firewall'),
			'ip_address' => __('IP address', 'all-in-one-wp-security-and-firewall'),
			'site_id' => __('Site ID', 'all-in-one-wp-security-and-firewall'),
		);
		return $columns;
	}

	/**
	 * Sets which of the columns the table data can be sorted by
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'user_id' => array('user_id',false),
			'username' => array('username',false),
			'ip_address' => array('ip_address',false),
			'site_id' => array('site_id',false),
		);
		return $sortable_columns;
	}
	
	public function get_bulk_actions() {
		return array();
	}

	private function process_bulk_action() {
		if (empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'bulk-items')) return;
	}

	/**
	 * This function will force a selected user to be logged out.
	 * The function accepts either an array of IDs or a single ID (TODO - bulk actions not implemented yet!)
	 *
	 * @param int $user_id - ID of user being logged out
	 */
	public function force_user_logout($user_id) {
		global $aio_wp_security;
		if (is_array($user_id)) {
			if (isset($_REQUEST['_wp_http_referer'])) {
				//TODO - implement bulk action in future release!
			}
		} elseif (null != $user_id) {
			$nonce = isset($_GET['aiowps_nonce']) ? $_GET['aiowps_nonce'] : '';
			if (!isset($nonce) || !wp_verify_nonce($nonce, 'force_user_logout')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for force user logout operation.", 4);
				die(__('Nonce check failed for force user logout operation', 'all-in-one-wp-security-and-firewall'));
			}
			// Force single user logout
			$user_id = absint($user_id);
			$manager = WP_Session_Tokens::get_instance($user_id);
			$manager->destroy_all();

			$aio_wp_security->user_login_obj->wp_logout_action_handler($user_id, true);
			$success_msg = '<div id="message" class="updated fade"><p><strong>';
			$success_msg .= __('The selected user was logged out successfully', 'all-in-one-wp-security-and-firewall');
			$success_msg .= '</strong></p></div>';
			_e($success_msg);
		}
	}

	/**
	 * Prepares the items for the logged-in users table
	 *
	 * @param bool $ignore_pagination - this is to check if data should be paginated or not
	 *
	 * @return void
	 */
	public function prepare_items($ignore_pagination = false) {
		global $wpdb;

		//First, lets decide how many records per page to show
		$per_page = 100;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$logged_in_users_table = AIOWSPEC_TBL_LOGGED_IN_USERS;
		$current_page = $this->get_pagenum();
		$offset = ($current_page - 1) * $per_page;

		// Parameters that are going to be used to order the result
		$orderby = isset($_GET["orderby"]) ? strip_tags($_GET["orderby"]) : '';
		$order = isset($_GET["order"]) ? strip_tags($_GET["order"]) : '';

		// By default show the most recent logged in user entries.
		$orderby = empty($orderby) ? 'created' : esc_sql($orderby);
		$order = empty($order) ? 'DESC' : esc_sql($order);

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		$orderby = sanitize_sql_orderby($orderby);
		$order = sanitize_sql_orderby($order);

		$this->_column_headers = array($columns, $hidden, $sortable);

		$where_sql = $this->get_where_sql();
		$total_items = $wpdb->get_var("SELECT COUNT(*) FROM `{$logged_in_users_table}` {$where_sql}");

		if ($ignore_pagination) {
			$data = $wpdb->get_results("SELECT * FROM `{$logged_in_users_table}` {$where_sql} ORDER BY {$orderby} {$order}", 'ARRAY_A');
		} else {
			$data = $wpdb->get_results("SELECT * FROM `{$logged_in_users_table}` {$where_sql} ORDER BY {$orderby} {$order} LIMIT {$per_page} OFFSET {$offset}", 'ARRAY_A');
		}

		$this->items = $data;

		if ($ignore_pagination) return;

		$this->set_pagination_args(array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		));
	}

	/**
	 * This function will build and return the SQL WHERE statement
	 *
	 * @return string - the SQL WHERE statement
	 */
	private function get_where_sql() {
		if (is_main_site() && is_super_admin()) return '';

		return is_multisite() ? sprintf("WHERE site_id = %d", get_current_blog_id()) : '';
	}
}
