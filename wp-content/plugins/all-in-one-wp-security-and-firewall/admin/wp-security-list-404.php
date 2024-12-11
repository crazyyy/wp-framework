<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_404 extends AIOWPSecurity_List_Table {

	public function __construct() {

		//Set parent defaults
		parent::__construct(array(
			'singular' => 'item', //singular name of the listed records
			'plural' => 'items', //plural name of the listed records
			'ajax' => false        //does this table support ajax?
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
	
	public function column_default($item, $column_name) {
		return $item[$column_name];
	}

	/**
	 * Returns id column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - html string for column rendered
	 */
	public function column_id($item) {
		$tab = '404-detection';
		$ip = $item['ip_or_host'];

		$blocked_ips_tab = 'locked-ip';
		$blacklist_tab = 'blacklist';
		//Check if this IP address is locked
		$is_locked = AIOWPSecurity_Utility::check_locked_ip($ip, '404');
		$is_blacklist = AIOWPSecurity_Utility::check_blacklist_ip($ip);
		$delete_url = sprintf('admin.php?page=%s&tab=%s&action=%s&id=%s', AIOWPSEC_BRUTE_FORCE_MENU_SLUG, $tab, 'delete_event_log', $item['id']);
		//Add nonce to delete URL
		$delete_url_nonce = wp_nonce_url($delete_url, "404_log_item_action", "aiowps_nonce");
		if ($is_locked) {
			//Build row actions
			$unblock_url_nonce = wp_nonce_url(sprintf('admin.php?page=%s&tab=%s', AIOWPSEC_MAIN_MENU_SLUG, $blocked_ips_tab), "404_log_item_action", "aiowps_nonce");
			$actions = array(
				'unblock' => '<a href="'.$unblock_url_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to unblock this item?', 'all-in-one-wp-security-and-firewall')) . '\')">'.__('Unblock', 'all-in-one-wp-security-and-firewall').'</a>',
				'delete' => '<a href="'.$delete_url_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to delete this item?', 'all-in-one-wp-security-and-firewall')) . '\')">'. __('Delete', 'all-in-one-wp-security-and-firewall') . '</a>',
			);
		} elseif ($is_blacklist) {
			$unblock_url_nonce = wp_nonce_url(sprintf('admin.php?page=%s&tab=%s', AIOWPSEC_FIREWALL_MENU_SLUG, $blacklist_tab), "404_log_item_action", "aiowps_nonce");
			$actions = array(
				'unblock' => '<a href="'.$unblock_url_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to unblock this item?', 'all-in-one-wp-security-and-firewall')) . '\')">'.__('Unblock', 'all-in-one-wp-security-and-firewall').'</a>',
				'delete' => '<a href="'.$delete_url_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to delete this item?', 'all-in-one-wp-security-and-firewall')) . '\')">'. __('Delete', 'all-in-one-wp-security-and-firewall') . '</a>',
			);
		} else {
			//Build row actions
			$temp_block_url_nonce = wp_nonce_url(sprintf('admin.php?page=%s&tab=%s&action=%s&ip_address=%s&username=%s', AIOWPSEC_BRUTE_FORCE_MENU_SLUG, $tab, 'temp_block', $item['ip_or_host'], $item['username']), "404_log_item_action", "aiowps_nonce");
			$blacklist_url_nonce = wp_nonce_url(sprintf('admin.php?page=%s&tab=%s&action=%s&ip_address=%s&username=%s', AIOWPSEC_BRUTE_FORCE_MENU_SLUG, $tab, 'blacklist_ip', $item['ip_or_host'], $item['username']), "404_log_item_action", "aiowps_nonce");
			$actions = array(
				'temp_block' => '<a href="'.$temp_block_url_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to block this IP address?', 'all-in-one-wp-security-and-firewall')) . '\')">'. __('Temp block', 'all-in-one-wp-security-and-firewall') . '</a>',
				'blacklist_ip' => '<a href="'.$blacklist_url_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to permanently block this IP address?', 'all-in-one-wp-security-and-firewall')) . '\')">'. __('Blacklist IP', 'all-in-one-wp-security-and-firewall') . '</a>',
				'delete' => '<a href="'.$delete_url_nonce.'" onclick="return confirm(\'' . esc_js(__('Are you sure you want to delete this item?', 'all-in-one-wp-security-and-firewall')) . '\')">'. __('Delete', 'all-in-one-wp-security-and-firewall') . '</a>',
			);
		}

		//Return the user_login contents
		return sprintf('%1$s <span style="color:silver"></span>%2$s',
			/* $1%s */ $item['id'],
			/* $2%s */ $this->row_actions($actions)
		);
	}

	/**
	 * Returns status column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - html string for column rendered
	 */
	public function column_status($item) {
		global $aio_wp_security;
		$ip = $item['ip_or_host'];
		//Check if this IP address is locked
		$is_locked = AIOWPSecurity_Utility::check_locked_ip($ip, '404');
		$blacklisted_string = $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses');
		$banned = strpos($blacklisted_string, $ip);
		
		if (false !== $banned) {
			return 'blacklisted';
		} elseif ($is_locked) {
			return 'temporarily blocked';
		} else {
			return '';
		}
	}

	/**
	 * Returns checkbox column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - html string for column rendered
	 */
	public function column_cb($item) {
		return sprintf('<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/* $1%s */ $this->_args['singular'], //Let's simply repurpose the table's singular label
			/* $2%s */ $item['id']                //The value of the checkbox should be the record's id
		);
	}

	public function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />', //Render a checkbox
			'id' => 'ID',
			'event_type' => __('Event type', 'all-in-one-wp-security-and-firewall'),
			'ip_or_host' => __('IP address', 'all-in-one-wp-security-and-firewall'),
			'url' => __('Attempted URL', 'all-in-one-wp-security-and-firewall'),
			'referer_info' => __('Referer', 'all-in-one-wp-security-and-firewall'),
			'created' => __('Date and time', 'all-in-one-wp-security-and-firewall'),
			'status' => __('Lock status', 'all-in-one-wp-security-and-firewall'),
		);
		$columns = apply_filters('list_404_get_columns', $columns);
		return $columns;
	}

	public function get_sortable_columns() {
		$sortable_columns = array(
			'id' => array('id', false),
			'event_type' => array('event_type', false),
			'ip_or_host' => array('ip_or_host', false),
			'url' => array('url', false),
			'referer_info' => array('referer_info', false),
			'created' => array('created', false),
		);
		$sortable_columns = apply_filters('list_404_get_sortable_columns', $sortable_columns);
		return $sortable_columns;
	}

	public function get_bulk_actions() {
		$actions = array(
			//'unlock' => 'Unlock',
			'bulk_block_ip' => __('Temp block IP', 'all-in-one-wp-security-and-firewall'),
			'bulk_blacklist_ip' => __('Blacklist IP', 'all-in-one-wp-security-and-firewall'),
			'delete' => __('Delete', 'all-in-one-wp-security-and-firewall')
		);
		return $actions;
	}

	private function process_bulk_action() {
		if (empty($_REQUEST['_wpnonce']) || !isset($_REQUEST['_wp_http_referer'])) return;
		$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_REQUEST['_wpnonce'], 'bulk-items');
		if (is_wp_error($result)) return;
		
		if ('bulk_block_ip' === $this->current_action()) {//Process delete bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->block_ip(($_REQUEST['item']));
			}
		}

		if ('bulk_blacklist_ip' === $this->current_action()) {//Process delete bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->blacklist_ip_address(($_REQUEST['item']));
			}
		}
		if ('delete' === $this->current_action()) {//Process delete bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->delete_404_event_records(($_REQUEST['item']));
			}
		}
	}

	/**
	 * Locks an IP address by adding it to the AIOWPSEC_TBL_LOGIN_LOCKOUT table.
	 *
	 * @param array|string $entries  - ids that correspond to ip addresses in the AIOWPSEC_TBL_EVENTS table or a single ip address
	 * @param string       $username - (optional)username of user being locked
	 *
	 * @return boolean|void
	 */
	public function block_ip($entries, $username = '') {
		global $wpdb;
		if (is_array($entries)) {
			//lock multiple records
			$entries = array_filter($entries, 'is_numeric'); //discard non-numeric ID values
			$id_list = "(" .implode(",", $entries) .")"; //Create comma separate list for DB operation
			$events_table = AIOWPSEC_TBL_EVENTS;
			$query = "SELECT ip_or_host FROM $events_table WHERE ID IN ".$id_list;
			$results = $wpdb->get_col($query);
			if (empty($results)) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Could not process the request because the IP addresses for the selected entries could not be found.', 'all-in-one-wp-security-and-firewall'));
				return false;
			} else {
				foreach ($results as $entry) {
					if (filter_var($entry, FILTER_VALIDATE_IP)) {
						AIOWPSecurity_Utility::lock_IP($entry, '404', $username);
					}
				}
			}
			AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP addresses are now temporarily blocked.', 'all-in-one-wp-security-and-firewall'));
		} elseif (null != $entries) {
			//Block single record
			if (filter_var($entries, FILTER_VALIDATE_IP)) {
				AIOWPSecurity_Utility::lock_IP($entries, '404', $username);
				AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP address is now temporarily blocked.', 'all-in-one-wp-security-and-firewall'));
			} else {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('The selected entry is not a valid IP address.', 'all-in-one-wp-security-and-firewall'));
			}
		}
	}

	/**
	 * Permanently blocks an IP address by adding it to the blacklist and writing rules to the htaccess file.
	 *
	 * @param array|string $entries - ids that correspond to ip addresses in the AIOWPSEC_TBL_EVENTS table or a single ip address
	 *
	 * @return boolean|void
	 */
	public function blacklist_ip_address($entries) {
		global $wpdb, $aio_wp_security;
		$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);
		$bl_ip_addresses = $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses'); //get the currently saved blacklisted IPs
		$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($bl_ip_addresses);
		
		if (is_array($entries)) {
			//Get the selected IP addresses
			$entries = array_filter($entries, 'is_numeric'); //discard non-numeric ID values
			$id_list = "(" .implode(",", $entries) .")"; //Create comma separate list for DB operation
			$events_table = AIOWPSEC_TBL_EVENTS;
			$query = "SELECT ip_or_host FROM $events_table WHERE ID IN ".$id_list;
			$results = $wpdb->get_col($query);
			if (empty($results)) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Could not process the request because the IP addresses for the selected entries could not be found.', 'all-in-one-wp-security-and-firewall'));
				return false;
			} else {
				foreach ($results as $entry) {
					$ip_list_array[] = $entry;
				}
			}
		} elseif (null != $entries) {
			//Blacklist single record
			$ip_list_array[] = $entries;
		}
		$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'blacklist');
		if (is_wp_error($validated_ip_list_array)) {
			AIOWPSecurity_Admin_Menu::show_msg_error_st(nl2br($validated_ip_list_array->get_error_message()));
		} else {
			$banned_ip_data = implode("\n", $validated_ip_list_array);
			$aio_wp_security->configs->set_value('aiowps_enable_blacklisting', '1'); // Force blacklist feature to be enabled.
			$aio_wp_security->configs->set_value('aiowps_banned_ip_addresses', $banned_ip_data);
			$aio_wp_security->configs->save_config();

			$aiowps_firewall_config->set_value('aiowps_blacklist_ips', $validated_ip_list_array);
			AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP addresses have been added to the blacklist and will be permanently blocked.', 'all-in-one-wp-security-and-firewall'));
		}
	}

	/**
	 * Deletes one or more records from the AIOWPSEC_TBL_EVENTS table.
	 *
	 * @param array|string|integer $entries - ids or a single id
	 *
	 * @return void
	 */
	public function delete_404_event_records($entries) {
		global $wpdb, $aio_wp_security;
		$events_table = AIOWPSEC_TBL_EVENTS;
		if (is_array($entries)) {
			//Delete multiple records
			$entries = array_map('esc_sql', $entries); //escape every array element
			$entries = array_filter($entries, 'is_numeric'); //discard non-numeric ID values
			$id_list = "(" . implode(",", $entries) . ")"; //Create comma separate list for DB operation
			$delete_command = "DELETE FROM " . $events_table . " WHERE id IN " . $id_list;
			$result = $wpdb->query($delete_command);
			if ($result) {
				AIOWPSecurity_Admin_Menu::show_msg_record_deleted_st();
			} else {
				// Error on bulk delete
				$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Events table. Database error: '.$wpdb->last_error, 4);
				AIOWPSecurity_Admin_Menu::show_msg_record_not_deleted_st();
			}
		} elseif (null != $entries) {
			//Delete single record
			$delete_command = "DELETE FROM " . $events_table . " WHERE id = '" . absint($entries) . "'";
			//$delete_command = $wpdb->prepare("DELETE FROM $events_table WHERE id = %s", absint($entries));
			$result = $wpdb->query($delete_command);
			if ($result) {
				AIOWPSecurity_Admin_Menu::show_msg_record_deleted_st();
			} elseif (false === $result) {
				// Error on single delete
				$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Events table. Database error: '.$wpdb->last_error, 4);
				AIOWPSecurity_Admin_Menu::show_msg_record_not_deleted_st();
			}
		}
	}

	/**
	 * Retrieves all items from AIOWPSEC_TBL_EVENTS according to a search term inside $_REQUEST['s'] and only '404' events if there is no search term. It then assigns to $this->items.
	 *
	 * @param Boolean $ignore_pagination - whether to not paginate
	 *
	 * @return Void
	 */
	public function prepare_items($ignore_pagination = false) {
		/**
		 * First, lets decide how many records per page to show
		 */
		$per_page = 100;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$search_term = isset($_REQUEST['s']) ? sanitize_text_field(stripslashes($_REQUEST['s'])) : '';

		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();

		global $wpdb;
		$events_table_name = AIOWPSEC_TBL_EVENTS;

		// Ordering parameters
		// Parameters that are going to be used to order the result
		$orderby = isset($_GET['orderby']) ? strip_tags($_GET['orderby']) : '';
		$order = isset($_GET['order']) ? strip_tags($_GET['order']) : '';

		$orderby = !empty($orderby) ? esc_sql($orderby) : 'id';
		$order = !empty($order) ? esc_sql($order) : 'DESC';

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		if (empty($search_term)) {
			$data = $wpdb->get_results("SELECT * FROM $events_table_name WHERE `event_type` = '404' ORDER BY $orderby $order", ARRAY_A);
		} else {
			$data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $events_table_name WHERE `ip_or_host` LIKE '%%%s%%' OR `url` LIKE '%%%s%%' OR `referer_info` LIKE '%%%s%%' ORDER BY $orderby $order", $search_term, $search_term, $search_term), ARRAY_A);
		}

		if (!$ignore_pagination) {
			$current_page = $this->get_pagenum();
			$total_items = count($data);
			$data = array_slice($data, (($current_page - 1) * $per_page), $per_page);
			$this->set_pagination_args(array(
				'total_items' => $total_items, //WE have to calculate the total number of items
				'per_page' => $per_page, //WE have to determine how many items to show on a page
				'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
			));
		}

		foreach ($data as $index => $row) {
			// Insert an empty status column - we will use later
			$data[$index]['status'] = '';
		}

		$this->items = $data;
	}

}
