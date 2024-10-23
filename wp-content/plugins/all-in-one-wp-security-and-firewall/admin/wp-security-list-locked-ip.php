<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_Locked_IP extends AIOWPSecurity_List_Table {
	
	public function __construct() {

		
		// Set parent defaults
		parent::__construct(array(
			'singular'  => 'item',     //singular name of the listed records
			'plural'    => 'items',    //plural name of the listed records
			'ajax'      => false        //does this table support ajax?
		));
		
	}
	
	/**
	 * Returns created column in datetime format as per user setting time zone.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the datetime
	 */
	public function column_created($item) {
		return AIOWPSecurity_Utility::convert_timestamp($item['created']);
	}
	
	/**
	 * Returns released column in datetime format as per user setting time zone.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the datetime
	 */
	public function column_released($item) {
		return AIOWPSecurity_Utility::convert_timestamp($item['released']);
	}

	/**
	 * This function renders a column
	 *
	 * @param array  $item        - Item object
	 * @param string $column_name - Column name to be rendered from item object
	 *
	 * @return string - data to be rendered for column_name
	 */
	public function column_default($item, $column_name) {
		return $item[$column_name];
	}

	/**
	 * Function to populate the locked ip actions column in the table
	 *
	 * @param array $item - Contains the current item data
	 *
	 * @return string
	 */
	public function column_failed_login_ip($item) {
		$actions = array(
			'unlock' => '<a href="" data-ip="'.esc_attr($item['failed_login_ip']).'" data-message="'.esc_js(__('Are you sure you want to unlock this address range?', 'all-in-one-wp-security-and-firewall')).'" class="aios-unlock-ip-button">'.esc_html__('Unlock', 'all-in-one-wp-security-and-firewall').'</a>',
			'delete' => '<a href="" data-id="'.esc_attr($item['id']).'" data-message="'.esc_js(__('Are you sure you want to delete this item?', 'all-in-one-wp-security-and-firewall')).'"  class="aios-delete-locked-ip-record">'.esc_html__('Delete', 'all-in-one-wp-security-and-firewall').'</a>',
		);

		//Return the user_login contents
		return sprintf('%1$s <span style="color:silver"></span>%2$s',
			/*$1%s*/ $item['failed_login_ip'],
			/*$2%s*/ $this->row_actions($actions)
		);
	}


	/**
	 * This function renders the checkbox column
	 *
	 * @param array $item - item object
	 *
	 * @return string
	 */
	public function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label
			/*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
		);
	}

	/**
	 * Returns ip_lookup_result column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_ip_lookup_result($item) {
		if (empty($item['ip_lookup_result'])) return __('There is no IP lookup result available.', 'all-in-one-wp-security-and-firewall');
		
		$ip_lookup_result = json_decode($item['ip_lookup_result'], true);

		// check that the json decode worked
		if (null === $ip_lookup_result) return __('There is no IP lookup result available.', 'all-in-one-wp-security-and-firewall');

		foreach ($ip_lookup_result as $key => $value) {
			$ip_lookup_result[$key] = empty($value) ? __('Not Found', 'all-in-one-wp-security-and-firewall') : $value;
		}

		$ip_lookup_result = print_r($ip_lookup_result, true);

		$output = sprintf('<a href="#TB_inline?&inlineId=trace-%s" title="%s" class="thickbox">%s</a>', esc_attr($item['id']), esc_html__('IP lookup result', 'all-in-one-wp-security-and-firewall'), esc_html__('Show result', 'all-in-one-wp-security-and-firewall'));
		$output .= sprintf('<div id="trace-%s" style="display: none"><pre>%s</pre></div>', esc_attr($item['id']), esc_html($ip_lookup_result));

		return $output;
	}

	/**
	 * Sets the columns for the table
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb' => '<input type="checkbox" />', //Render a checkbox
			'failed_login_ip' => __('Locked IP/range', 'all-in-one-wp-security-and-firewall'),
			'user_id' => __('User ID', 'all-in-one-wp-security-and-firewall'),
			'user_login' => __('Username', 'all-in-one-wp-security-and-firewall'),
			'lock_reason' => __('Reason', 'all-in-one-wp-security-and-firewall'),
			'created' => __('Date locked', 'all-in-one-wp-security-and-firewall'),
			'released' => __('Release date', 'all-in-one-wp-security-and-firewall'),
			'ip_lookup_result' => __('IP lookup result', 'all-in-one-wp-security-and-firewall')
		);
	}

	/**
	 * This function returns sortable columns
	 *
	 * @return array[]
	 */
	public function get_sortable_columns() {
		return array(
			'failed_login_ip' => array('failed_login_ip',false),
			'user_id' => array('user_id',false),
			'user_login' => array('user_login',false),
			'lock_reason' => array('lock_reason',false),
			'created' => array('created',false),
			'released' => array('released',false)
		);
	}

	/**
	 * This returns the bulk actions for the table
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		return array(
			'unlock' => __('Unlock', 'all-in-one-wp-security-and-firewall'),
			'delete' => __('Delete', 'all-in-one-wp-security-and-firewall'),
		);
	}

	/**
	 * Process bulk actions.
	 *
	 * @return void
	 */
	private function process_bulk_action() {
		if (empty($_REQUEST['_wpnonce']) || !isset($_REQUEST['_wp_http_referer'])) return;
		$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_REQUEST['_wpnonce'], 'bulk-items');
		if (is_wp_error($result)) return;

		if ('delete' == $this->current_action()) { // Process delete bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->delete_lockout_records($_REQUEST['item']);
			}
		}

		if ('unlock' == $this->current_action()) { //Process unlock bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->unlock_ips(($_REQUEST['item']));
			}
		}
	}

	/**
	 * Unlocks multiple IP addresses by modifying the released column of records in the AIOWPSEC_TBL_LOGIN_LOCKOUT table.
	 *
	 * @param array $entries IDs that correspond to IP addresses in the AIOWPSEC_TBL_LOGIN_LOCKOUT table.
	 *
	 * @return void
	 */
	public function unlock_ips($entries) {
		global $wpdb;

		$lockout_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;

		// Unlock multiple records
		$entries = array_filter($entries, 'is_numeric');  // Discard non-numeric ID values
		$id_list = '(' .implode(',', $entries) .')';  // Create comma separate list for DB operation
		$result = $wpdb->query("UPDATE $lockout_table SET `released` = UNIX_TIMESTAMP() WHERE `id` IN $id_list");

		if (null != $result) {
			AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP entries were unlocked successfully.', 'all-in-one-wp-security-and-firewall'));
		}
	}

	/**
	 * Deletes one or more records from the AIOWPSEC_TBL_LOGIN_LOCKOUT table.
	 *
	 * @param array|string|integer $entries - ids or a single id
	 *
	 * @return void|string
	 */
	public function delete_lockout_records($entries) {
		global $wpdb, $aio_wp_security;
		$lockout_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;
		if (is_array($entries)) {
			// Delete multiple records
			$entries = array_filter($entries, 'is_numeric'); //discard non-numeric ID values
			$id_list = "(" .implode(",", $entries) .")"; //Create comma separate list for DB operation
			$delete_command = "DELETE FROM ".$lockout_table." WHERE id IN ".$id_list;
			$result = $wpdb->query($delete_command);
			if ($result) {
				AIOWPSecurity_Admin_Menu::show_msg_record_deleted_st();
			} else {
				// Error on bulk delete
				$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from login lockout table. Database error: '.$wpdb->last_error, 4);
				AIOWPSecurity_Admin_Menu::show_msg_record_not_deleted_st();
			}
		} elseif (null != $entries) {
			// Delete single record
			$delete_command = "DELETE FROM ".$lockout_table." WHERE id = '".absint($entries)."'";
			$result = $wpdb->query($delete_command);
			if ($result) {
				return AIOWPSecurity_Admin_Menu::show_msg_record_deleted_st(true);
			} elseif (false === $result) {
				// Error on single delete
				$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from login lockout table. Database error: '.$wpdb->last_error, 4);
				return AIOWPSecurity_Admin_Menu::show_msg_record_not_deleted_st(true);
			}
		}
	}

	/**
	 * Retrieves all items from AIOWPSEC_TBL_LOGIN_LOCKOUT. It may paginate and then assigns to $this->items.
	 *
	 * @param Boolean $ignore_pagination - whether to not paginate
	 *
	 * @return Void
	 */
	public function prepare_items($ignore_pagination = false) {
		global $wpdb;

		$lockout_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;

		$this->process_bulk_action();

		// How many records per page to show
		$per_page = 100;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);

		// Parameters that are going to be used to order the result
		$orderby = isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : '';
		$order = isset($_GET['order']) ? sanitize_text_field(wp_unslash($_GET['order'])) : '';

		$orderby = !empty($orderby) ? esc_sql($orderby) : 'created';
		$order = !empty($order) ? esc_sql($order) : 'DESC';

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		$current_page = $this->get_pagenum();
		$offset = ($current_page - 1) * $per_page;

		$total_items = $wpdb->get_var(
			"SELECT COUNT(*) FROM {$lockout_table} WHERE `released` > UNIX_TIMESTAMP()"
		);

		if ($ignore_pagination) {
			$data = $wpdb->get_results(
				"SELECT * FROM {$lockout_table} WHERE `released` > UNIX_TIMESTAMP() ORDER BY {$orderby} {$order}",
				'ARRAY_A'
			);
		} else {
			$data = $wpdb->get_results(
				"SELECT * FROM {$lockout_table} WHERE `released` > UNIX_TIMESTAMP() ORDER BY {$orderby} {$order} LIMIT {$per_page} OFFSET {$offset}",
				'ARRAY_A'
			);
		}

		$this->items = $data;

		if ($ignore_pagination) return;

		$this->set_pagination_args(array(
			'total_items' => $total_items,  // WE have to calculate the total number of items
			'per_page'    => $per_page,  // WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items / $per_page)  // WE have to calculate the total number of pages
		));
	}

}
