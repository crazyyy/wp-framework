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
		//Build row actions
		$actions = array(
			'logout' => '<a class="aios-force-logout-user" data-user-id="'.esc_attr($item['user_id']).'" data-message="'.esc_js(__('Are you sure you want to force this user to be logged out of this session?', 'all-in-one-wp-security-and-firewall')).'" href="">'.__('Force logout', 'all-in-one-wp-security-and-firewall').'</a>',
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
			'cb'         => '<input type="checkbox">',
			'user_id'    => __('User ID', 'all-in-one-wp-security-and-firewall'),
			'username'   => __('Login name', 'all-in-one-wp-security-and-firewall'),
			'ip_address' => __('IP address', 'all-in-one-wp-security-and-firewall'),
			'site_id'    => __('Site ID', 'all-in-one-wp-security-and-firewall'),
		);
		return $columns;
	}

	/**
	 * Returns cb column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/* $1%s */ $this->_args['singular'], // Let's simply repurpose the table's singular label
			/* $2%s */ $item['user_id'] // The value of the checkbox should be the record's id and its ip address
		);
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
	
	/**
	 * Adds a bulk action user interface
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		return array(
			'force_logout_all' => __('Logout all', 'all-in-one-wp-security-and-firewall'),
			'force_logout_selected' => __('Logout selected', 'all-in-one-wp-security-and-firewall'),
		);
	}

	/**
	 * Process Bulk action from menu
	 *
	 * @return void
	 */
	private function process_bulk_action() {
		if (empty($_REQUEST['_wpnonce']) || !isset($_REQUEST['_wp_http_referer'])) return;
		$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_REQUEST['_wpnonce'], 'bulk-items');
		if (is_wp_error($result)) return;

		if ('force_logout_all' === $this->current_action()) {
			$this->force_user_logout(array(), true);
		} elseif ('force_logout_selected' === $this->current_action()) {
			if (isset($_REQUEST['item'])) {
				if (is_array($_REQUEST['item'])) $this->force_user_logout($_REQUEST['item']);
			}
		}
	}

	/**
	 * This function will force selected user(s) to be logged out.
	 *
	 * @param int|array $users      - id of selected user or array of user ids to be logged out
	 * @param bool      $logout_all - Boolean to show if all users should be logged out
	 *
	 * @return void|string
	 */
	public function force_user_logout($users, $logout_all = false) {
		global $wpdb, $aio_wp_security;

		$logged_in_users_table = AIOWSPEC_TBL_LOGGED_IN_USERS;

		if ($logout_all) {
			// get all user_id(except for the admin) in the table and make it an array for users
			$users = $wpdb->get_col("SELECT user_id FROM $logged_in_users_table");
		}

		if (is_array($users)) {

			if (empty($users)) {
				AIOWPSecurity_Admin_Menu::show_msg_record_not_deleted_st();
				return;
			}

			$errors = 0;

			// Escape the user IDs for security
			$users = array_map('esc_sql', $users);

			foreach ($users as $user_id) {
				if (is_numeric($user_id) && !is_super_admin($user_id) && AIOWPSecurity_Utility::is_user_member_of_blog($user_id)) {
					if ($aio_wp_security->user_login_obj->delete_logged_in_user($user_id)) {
						$this->logout_user($user_id);
						continue;
					}
				}
				$errors++;
			}

			if ($errors > 0) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__("Some users were not logged out due to the ID being invalid, or them being a super admin or a member of a different subsite on a multisite", 'all-in-one-wp-security-and-firewall'));
				return;
			}

			AIOWPSecurity_Admin_Menu::show_msg_record_deleted_st();
		}
	}


	/**
	 * This function handles logging out a user using user_id
	 *
	 * @param int $user_id - id of user being logged out
	 *
	 * @return void
	 */
	public function logout_user($user_id) {
		$user_id = absint($user_id);
		$manager = WP_Session_Tokens::get_instance($user_id);
		$manager->destroy_all();
	}

	/**
	 * Prepares the items for the logged in users table
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
		
		$this->process_bulk_action(); // Process bulk actions

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
