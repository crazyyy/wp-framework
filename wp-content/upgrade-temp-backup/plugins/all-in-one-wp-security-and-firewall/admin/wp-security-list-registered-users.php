<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_Registered_Users extends AIOWPSecurity_List_Table {

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
	 * Returns ID column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_ID($item) {
		//Build row actions
		$actions = array(
			'view' => '<a href="user-edit.php?user_id='.$item['ID'].'" target="_blank">'.__('View', 'all-in-one-wp-security-and-firewall').'</a>',
			'approve_acct' => '<a class="aios-approve-user-acct" href="" data-id="'.esc_attr($item['ID']).'" data-message="'.esc_js(__('Are you sure you want to approve this account?', 'all-in-one-wp-security-and-firewall')).'">'. __('Approve', 'all-in-one-wp-security-and-firewall') . '</a>',
			'delete_acct' => '<a class="aios-delete-user-acct" href="" data-id="'.esc_attr($item['ID']).'" data-message="'.esc_js(__('Are you sure you want to delete this account?', 'all-in-one-wp-security-and-firewall')).'">'. __('Delete', 'all-in-one-wp-security-and-firewall') . '</a>',
			'block_ip' => '<a class="aios-block-ip" href="" data-ip="'.esc_attr($item['ip_address']).'" data-message="'.esc_js(__('Are you sure you want to block this IP address?', 'all-in-one-wp-security-and-firewall')).'">'. __('Block IP', 'all-in-one-wp-security-and-firewall') . '</a>',
		);
		
		//Return the user_login contents
		return sprintf('%1$s <span style="color:silver"></span>%2$s',
			/*$1%s*/ $item['ID'],
			/*$2%s*/ $this->row_actions($actions)
		);
	}

	/**
	 * Returns IP address column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_ip_address($item) {
		if (AIOWPSecurity_Blocking::is_ip_blocked($item['ip_address'])) {
			return $item['ip_address'].'<br /><span class="aiowps-label aiowps-label-success">'.__('blocked', 'all-in-one-wp-security-and-firewall').'</span>';
		} else {
			return $item['ip_address'];
		}
	}

	public function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label
			/*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
		);
	}


	/**
	 * Returns array of columns to be rendered.
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox">', // Render a checkbox
			'ID' => __('User ID', 'all-in-one-wp-security-and-firewall'),
			'user_login' => __('Login name', 'all-in-one-wp-security-and-firewall'),
			'user_email' => __('Email', 'all-in-one-wp-security-and-firewall'),
			'user_registered' => __('Register date', 'all-in-one-wp-security-and-firewall'),
			'account_status' => __('Account status', 'all-in-one-wp-security-and-firewall'),
			'ip_address' => __('IP address', 'all-in-one-wp-security-and-firewall')
		);
		return $columns;
	}
	
	public function get_sortable_columns() {
		$sortable_columns = array(
			// 'ID' => array('ID',false),
			// 'user_login' => array('user_login',false),
			// 'user_email' => array('user_email',false),
			// 'user_registered' => array('user_registered',false),
			// 'account_status' => array('account_status',false),
		);
		return $sortable_columns;
	}
	
	public function get_bulk_actions() {
		$actions = array(
			'approve' => __('Approve', 'all-in-one-wp-security-and-firewall'),
			'delete' => __('Delete', 'all-in-one-wp-security-and-firewall'),
			'block' => __('Block IP', 'all-in-one-wp-security-and-firewall')
		);
		return $actions;
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

		if ('approve' == $this->current_action()) { //Process approve bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->approve_selected_accounts(($_REQUEST['item']));
			}
		}
		
		if ('delete' == $this->current_action()) { //Process delete bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->delete_selected_accounts(($_REQUEST['item']));
			}
		}

		if ('block' == $this->current_action()) { //Process block bulk actions
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->block_selected_ips(($_REQUEST['item']));
			}
		}

	}

	/**
	 * This function approves selected user accounts
	 *
	 * @param array|int $entries - this is an array of users or user_id to be approved
	 *
	 * @return void|string
	 */
	public function approve_selected_accounts($entries) {
		global $aio_wp_security;
		$meta_key = 'aiowps_account_status';
		$meta_value = 'approved'; // set account status
		$failed_accts = ''; // string to store comma separated accounts which failed to update
		$at_least_one_updated = false;
		if (is_array($entries)) {
			$entries = array_map('esc_sql', $entries); // Escape every array element
			//Let's go through each entry and approve
			foreach ($entries as $user_id) {
				$result = update_user_meta($user_id, $meta_key, $meta_value);
				if (false === $result) {
					$failed_accts .= ' '.$user_id.', ';
					$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_List_Registered_Users::approve_selected_accounts() - could not approve account ID: $user_id", 4);
				} else {
					$at_least_one_updated = true;
					$user = get_user_by('id', $user_id);
					if (false === $user) {
						//don't send mail
					} else {
						$this->send_email_upon_account_activation($user);
					}
				}
			}
			if ($at_least_one_updated) {
				AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected accounts were approved successfully.', 'all-in-one-wp-security-and-firewall'));
			}
			if ('' != $failed_accts) {
				//display any failed account updates
				rtrim($failed_accts);
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('The following accounts failed to update successfully:', 'all-in-one-wp-security-and-firewall') . ' ' . $failed_accts);
			}
		}
	}

	/**
	 * This function sends an email to an approved user
	 *
	 * @param WP_User $user - the object for the approved user
	 *
	 * @return bool
	 */
	public function send_email_upon_account_activation($user) {
		global $aio_wp_security;
		if (!($user instanceof WP_User)) {
			return false;
		}
		
		$to_email_address = $user->user_email;
		$email_msg = '';
		$subject = '['.network_site_url().'] '. __('Your account is now active', 'all-in-one-wp-security-and-firewall');
		$email_msg .= sprintf(__('Your account with username: %s is now active', 'all-in-one-wp-security-and-firewall'), $user->user_login) . "\n";
		$subject = apply_filters('aiowps_register_approval_email_subject', $subject);
		$email_msg = apply_filters('aiowps_register_approval_email_msg', $email_msg, $user); //also pass the WP_User object
		
		$sendMail = wp_mail($to_email_address, $subject, $email_msg);
		if (false === $sendMail) {
			$aio_wp_security->debug_logger->log_debug("Manual account approval notification email failed to send to " . $to_email_address, 4);
		}
		return $sendMail;
	}

	/**
	 * This function deletes selected entries pending approval
	 *
	 * @param array|int $entries - this is an array of users or single user to be deleted
	 *
	 * @return void|string
	 */
	public function delete_selected_accounts($entries) {
		global $aio_wp_security;
		if (is_array($entries)) {
			$entries = array_map('esc_sql', $entries); // Escape every array element
			//Let's go through each entry and delete account
			foreach ($entries as $user_id) {
				$result = wp_delete_user($user_id);
				if (true !== $result) {
					$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_List_Registered_Users::delete_selected_accounts() - could not delete account ID: $user_id", 4);
				}
			}
			AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected accounts were deleted successfully.', 'all-in-one-wp-security-and-firewall'));
		}
	}

	/**
	 * This function blocks selected ip
	 *
	 * @param array|int $entries - this is an array of ips or ip to be blocked
	 *
	 * @return void|string
	 */
	public function block_selected_ips($entries) {
		global $aio_wp_security;
		if (is_array($entries)) {
			$entries = array_filter($entries, function ($entry) {
				return AIOWPSecurity_Utility_IP::get_user_ip_address() != $entry;
			});

			if (empty($entries)) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Only invalid IP addresses were provided: you can not block your own IP address', 'all-in-one-wp-security-and-firewall'));
				return;
			}
			$entries = array_map('esc_sql', $entries); // Escape every array element
			//Let's go through each entry and block IP
			foreach ($entries as $id) {
				$ip_address = get_user_meta($id, 'aiowps_registrant_ip', true);
				$result = AIOWPSecurity_Blocking::add_ip_to_block_list($ip_address, 'registration_spam');
				if (false === $result) {
					$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_List_Registered_Users::block_selected_ips() - could not block IP : $ip_address", 4);
				}
			}

			$msg = __('The selected IP addresses were successfully added to the permanent block list.', 'all-in-one-wp-security-and-firewall');
			$msg .= ' <a href="admin.php?page='.AIOWPSEC_MAIN_MENU_SLUG.'&tab=permanent-block" target="_blank">'.__('View Blocked IPs', 'all-in-one-wp-security-and-firewall').'</a>';
			AIOWPSecurity_Admin_Menu::show_msg_updated_st($msg);
		}
	}

	/**
	 * Grabs the data from database and handles the pagination
	 *
	 * @param boolean $ignore_pagination - whether to not paginate
	 * @return void
	 */
	public function prepare_items($ignore_pagination = false) {
		//First, lets decide how many records per page to show
		$per_page = 100;
		$columns = $this->get_columns();
		$current_page = $this->get_pagenum();
		$offset = ($current_page - 1) * $per_page;
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$search = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';

		$this->_column_headers = array($columns, $hidden, $sortable);
		
		$this->process_bulk_action();
		
		//Get registered users which have the special 'aiowps_account_status' meta key set to 'pending'
		if ($ignore_pagination) {
			$result = $this->get_registered_user_data('pending', $search);
		} else {
			$result = $this->get_registered_user_data('pending', $search, $per_page, $offset);
		}

		$total_items = $result['total'];
		$this->items = $result['data'];

		if ($ignore_pagination) return;

		$this->set_pagination_args(array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		));
	}

	/**
	 * Returns all users who have the special 'aiowps_account_status' meta key
	 *
	 * @param string $status   - the status we want to search for
	 * @param string $search   - the search query
	 * @param null   $per_page - how many results per page
	 * @param int    $offset   - the page offset
	 *
	 * @return array - an array of users that match the search
	 */
	public function get_registered_user_data($status = '', $search = '', $per_page = null, $offset = 0) {
		$user_fields = array( 'ID', 'user_login', 'user_email', 'user_registered');
		$user_query = new WP_User_Query(array('meta_key' => 'aiowps_account_status', 'meta_value' => $status, 'fields' => $user_fields, 'number' => $per_page, 'offset' => $offset));
		$user_results = $user_query->results;
		$user_total = $user_query->get_total();

		$final_data = array();
		foreach ($user_results as $user) {
			$temp_array = get_object_vars($user); //Turn the object into array
			$temp_array['account_status'] = get_user_meta($temp_array['ID'], 'aiowps_account_status', true);
			$ip = get_user_meta($temp_array['ID'], 'aiowps_registrant_ip', true);
			$temp_array['ip_address'] = empty($ip) ? '' : $ip;
			if (empty($search)) {
				$final_data[] = $temp_array;
			} else {
				$input = preg_quote($search, '~'); // don't forget to quote input string!

				$result = preg_grep('~' . $input . '~', $temp_array);
				if (!empty($result)) $final_data[] = $temp_array;
			}
		}

		return array(
			'data' => $final_data,
			'total' => $user_total,
		);
	}
}
