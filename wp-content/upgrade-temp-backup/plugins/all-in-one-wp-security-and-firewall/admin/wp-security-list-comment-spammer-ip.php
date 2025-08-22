<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_Comment_Spammer_IP extends AIOWPSecurity_List_Table {

	public function __construct() {

		
		//Set parent defaults
		parent::__construct(array(
			'singular'  => 'item',  // singular name of the listed records
			'plural'    => 'items', // plural name of the listed records
			'ajax'      => false    // does this table support ajax?
		));
		
	}

	public function column_default($item, $column_name) {
		return $item[$column_name];
	}
		
	public function column_comment_author_IP($item) {
		//Build row actions
		if (!is_main_site() || 'blocked' === $item['status']) {
			//Suppress the block link if site is a multi site AND not the main site or the status is blocked
			$actions = array(); //blank array
		} else {
			//Add IP to block URL
			$ip = $item['comment_author_IP'];
			$actions = array(
				'block' => '<a class="aios-block-author-ip" data-ip="'.esc_attr($ip).'" data-message="'.esc_js(__('Are you sure you want to permanently block this IP address?', 'all-in-one-wp-security-and-firewall')).'" href="">'.__('Block', 'all-in-one-wp-security-and-firewall').'</a>',
			);
		}
		
		//Return the user_login contents
		return sprintf('%1$s <span style="color:silver"></span>%2$s',
			/*$1%s*/ $item['comment_author_IP'],
			/*$2%s*/ $this->row_actions($actions)
		);
	}

	
	public function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label
			/*$2%s*/ esc_attr($item['comment_author_IP']) //The value of the checkbox should be the record's id
		);
	}
	
	public function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />', //Render a checkbox
			'comment_author_IP' => __('Spammer IP', 'all-in-one-wp-security-and-firewall'),
			'amount' => __('Number of spam comments from this IP', 'all-in-one-wp-security-and-firewall'),
			'status' => __('Status', 'all-in-one-wp-security-and-firewall'),
		);
		return $columns;
	}
	
	public function get_sortable_columns() {
		$sortable_columns = array(
			'comment_author_IP' => array('comment_author_IP',false),
			'amount' => array('amount',false),
			'status' => array('status',false),
		);
		return $sortable_columns;
	}
	
	public function get_bulk_actions() {
		if (!is_main_site()) {
			//Suppress the block link if site is a multi site AND not the main site
			$actions = array(); //blank array
		} else {
			$actions = array(
				'block' => __('Block', 'all-in-one-wp-security-and-firewall')
			);
		}
		return $actions;
	}

	/**
	 * This function handles bulk actions on the table
	 *
	 * @return void
	 */
	private function process_bulk_action() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This IS the nonce check.
		if (empty($_REQUEST['_wpnonce']) || !isset($_REQUEST['_wp_http_referer'])) return;
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput -- This IS the nonce check.
		$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_REQUEST['_wpnonce'], 'bulk-items');
		if (is_wp_error($result)) return;
		

		if ('block' === $this->current_action()) {
			//Process block bulk actions
			if (!isset($_REQUEST['item'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce already checked above.
				$error_msg = '<div id="message" class="error"><p><strong>';
				$error_msg .= esc_html__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall');
				$error_msg .= '</strong></p></div>';

				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- PCP error. Output already escaped.
				echo $error_msg;
			} else {
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce already checked above.
				$this->block_spammer_ip_records((filter_var(wp_unslash($_REQUEST['item']), FILTER_VALIDATE_IP)));
			}
		}
	}
	
	
	
	/**
	 * This function will add the selected IP addresses to the blacklist.
	 *
	 * @param int|array $entries - either an array of IDs or a single ID of ip to be blocked
	 *
	 * @return void
	 */
	public function block_spammer_ip_records($entries) {
		if (is_array($entries)) {
			$entries = array_map('esc_sql', $entries); // Escape every array element
			//Bulk selection using checkboxes were used
			foreach ($entries as $ip_add) {
				AIOWPSecurity_Blocking::add_ip_to_block_list($ip_add, 'spam');
			}
		}

		AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('The selected IP addresses are now permanently blocked.', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * This function prepare the items rendered on the table
	 *
	 * @return void
	 */
	public function prepare_items() {
		//First, lets decide how many records per page to show
		$per_page = 100;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();

		global $wpdb;
		global $aio_wp_security;
		$minimum_comments_per_ip = $aio_wp_security->configs->get_value('aiowps_spam_ip_min_comments');
		if (empty($minimum_comments_per_ip)) {
			$minimum_comments_per_ip = 5;
		}
		// Ordering parameters
		//Parameters that are going to be used to order the result
		isset($_GET["orderby"]) ? $orderby = wp_strip_all_tags(wp_unslash($_GET["orderby"])) : $orderby = ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		isset($_GET["order"]) ? $order = wp_strip_all_tags(wp_unslash($_GET["order"])) : $order = ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.

		$orderby = !empty($orderby) ? esc_sql($orderby) : 'amount';
		$order = !empty($order) ? esc_sql($order) : 'DESC';

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		// status is not a key in the database so we don't want to sort the database results, but sort the array later
		if ('status' == $orderby) {
			$sql = $wpdb->prepare("SELECT comment_author_IP, COUNT(*) AS amount
				FROM     $wpdb->comments 
				WHERE    comment_approved = 'spam'
				GROUP BY comment_author_IP
				HAVING   amount >= %d
				", $minimum_comments_per_ip);
		} else {
			// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- $orderby cannot be prepared.
			$sql = $wpdb->prepare("SELECT comment_author_IP, COUNT(*) AS amount
				FROM     $wpdb->comments 
				WHERE    comment_approved = 'spam'
				GROUP BY comment_author_IP
				HAVING   amount >= %d
				ORDER BY $orderby $order
				", $minimum_comments_per_ip);
			// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- $orderby cannot be prepared.
		}

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery -- Preparing done in conditional above.
		$data = $wpdb->get_results($sql, ARRAY_A);

		// Get all permanently blocked IP addresses
		$block_list = AIOWPSecurity_Blocking::get_list_blocked_ips();
		
		foreach ($data as $key => $value) {
			if (in_array($value['comment_author_IP'], $block_list)) {
				$data[$key]['status'] = 'blocked';
			} else {
				$data[$key]['status'] = 'not blocked';
			}
		}

		if ('status' == $orderby) {
			$keys = array_column($data, 'status');
			if ('asc' == $order) {
				array_multisort($keys, SORT_ASC, SORT_STRING, $data);
			} else {
				array_multisort($keys, SORT_DESC, SORT_STRING, $data);
			}
		}

		$current_page = $this->get_pagenum();
		$total_items = count($data);
		$data = array_slice($data, (($current_page - 1) * $per_page), $per_page);
		$this->items = $data;
		$this->set_pagination_args(array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page' => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
		));
	}
}
