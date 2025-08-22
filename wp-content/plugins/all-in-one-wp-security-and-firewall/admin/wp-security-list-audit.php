<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_Audit_Log extends AIOWPSecurity_Ajax_Data_Table {

	/**
	 * Constructs the table object and sets up its attributes.
	 *
	 * @param array $data - An array containing additional data for the table. Default is an empty array.
	 * @return void
	 */
	public function __construct($data = array()) {

		// Set parent defaults
		parent::__construct(array(
			'singular' => 'item', // singular name of the listed records
			'plural' => 'items',  // plural name of the listed records
			'ajax' => true,       // does this table support ajax?
			'data' => $data       // Request data
		));

	}

	/**
	 * Returns the default column item
	 *
	 * @param object $item        - item from which column data is returned
	 * @param string $column_name - column name to be fetched from item
	 * @return string
	 */
	public function column_default($item, $column_name) {
		return $item[$column_name];
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
			/* $2%s */ $item['id']               // The value of the checkbox should be the record's id
		);
	}

	/**
	 * Returns created column html to be rendered.
	 *
	 * @param array $item Data for the columns on the current row.
	 *
	 * @return string The html to be rendered.
	 */
	public function column_created($item) {
		$actions = array(
			'delete' => '<a class="aios-delete-audit-log" data-id="' . esc_attr($item['id']) . '" data-message="' . esc_js(__('Are you sure you want to delete this item?', 'all-in-one-wp-security-and-firewall')) . '" href="">' . esc_html__('Delete', 'all-in-one-wp-security-and-firewall') . '</a>'
		);

		return AIOWPSecurity_Utility::convert_timestamp($item['created']) . '<span style="color:silver"></span>' . $this->row_actions($actions);
	}

	/**
	 * Returns ip column html to be rendered.
	 *
	 * @param array $item Data for the columns on the current row.
	 *
	 * @return string The html to be rendered.
	 */
	public function column_ip($item) {
		$ip = $item['ip'];

		$unblacklist_ip_warning_translation = __('Are you sure you want to unblacklist this IP address?', 'all-in-one-wp-security-and-firewall');
		$unlock_ip_warning_translation = __('Are you sure you want to unlock this IP address?', 'all-in-one-wp-security-and-firewall');
		$lock_ip_warning_translation = __('Are you sure you want to temporarily lock this IP address?', 'all-in-one-wp-security-and-firewall');
		$blacklist_ip_warning_translation = __('Are you sure you want to blacklist this IP address?', 'all-in-one-wp-security-and-firewall');

		// Build row actions.
		if (AIOWPSecurity_Utility_Permissions::is_main_site_and_super_admin() && AIOWPSecurity_Utility::check_blacklist_ip($ip)) {
			$actions = array(
				'unblacklist' => '<a class="aios-unblacklist-ip-button" data-ip="' . esc_attr($ip) . '" data-message="' . esc_js($unblacklist_ip_warning_translation) . '" href="">' . esc_html__('Unblacklist', 'all-in-one-wp-security-and-firewall') . '</a>',
			);
		} elseif (AIOWPSecurity_Utility::check_locked_ip($ip, 'audit-log')) {
			$actions = array(
				'unlock' => '<a class="aios-unlock-ip-button" data-ip="' . esc_attr($ip) . '" data-message="' . esc_js($unlock_ip_warning_translation) . '" href="">' . esc_html__('Unlock', 'all-in-one-wp-security-and-firewall') . '</a>',
			);
		} else {
			$actions = array(
				'lock_ip' => '<a class="aios-lock-ip-button" data-ip="' . esc_attr($ip) . '" data-message="' . esc_js($lock_ip_warning_translation) . '" href="">' . esc_html__('Lock IP', 'all-in-one-wp-security-and-firewall') . '</a>',
			);

			if (AIOWPSecurity_Utility_Permissions::is_main_site_and_super_admin()) {
				$actions['blacklist_ip'] = '<a class="aios-blacklist-ip-button" data-ip="' . esc_attr($ip) . '" data-message="' . esc_js($blacklist_ip_warning_translation) . '" href="">' . esc_html__('Blacklist IP', 'all-in-one-wp-security-and-firewall') . '</a>';
			}
		}

		return $ip . '<span style="color:silver"></span>' . $this->row_actions($actions);
	}

	/**
	 * Returns event type column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_event_type($item) {
		if (empty($item['event_type'])) return __('No event type available.', 'all-in-one-wp-security-and-firewall');

		$output = isset(AIOWPSecurity_Audit_Events::$event_types[$item['event_type']]) ? AIOWPSecurity_Audit_Events::$event_types[$item['event_type']] : $item['event_type'];

		return $output;
	}

	/**
	 * Returns details column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_details($item) {
		$details = json_decode($item['details'], true);

		if (!is_array($details)) return $item['details'];

		$key = array_keys($details)[0];

		if (method_exists("AIOWPSecurity_Audit_Text_Handler", "{$key}_to_text")) {
			return call_user_func("AIOWPSecurity_Audit_Text_Handler::{$key}_to_text", $details[$key]);
		}

		return $item['details'];
	}

	/**
	 * Returns stack trace column html to be rendered.
	 *
	 * @param array $item - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_stacktrace($item) {
		if (empty($item['stacktrace'])) return __('No stack trace available.', 'all-in-one-wp-security-and-firewall');

		if (is_serialized($item['stacktrace'])) {
			$stacktrace = AIOWPSecurity_Utility::unserialize($item['stacktrace']);
		} else {
			$stacktrace = $item['stacktrace'];
		}
		ob_start();
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_dump -- Part of error reporting system.
		var_dump($stacktrace);
		$stacktrace_output = ob_get_contents();
		ob_end_clean();

		$output = sprintf('<a href="#TB_inline?&inlineId=trace-%s" title="%s" class="thickbox">%s</a>', $item['id'], esc_html__('Stack trace', 'all-in-one-wp-security-and-firewall'), esc_html__('Show trace', 'all-in-one-wp-security-and-firewall'));
		$output .= sprintf('<div id="trace-%s" style="display: none"><pre>%s</pre></div>', $item['id'], htmlspecialchars($stacktrace_output));

		return $output;
	}

	/**
	 * Sets the columns for the table
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox">', //Render a checkbox
			'created' => __('Date and time', 'all-in-one-wp-security-and-firewall'),
			'level' => __('Level', 'all-in-one-wp-security-and-firewall'),
			'network_id' => __('Network ID', 'all-in-one-wp-security-and-firewall'),
			'site_id' => __('Site ID', 'all-in-one-wp-security-and-firewall'),
			'username' => __('Username', 'all-in-one-wp-security-and-firewall'),
			'ip' => __('IP', 'all-in-one-wp-security-and-firewall'),
			'event_type' => __('Event', 'all-in-one-wp-security-and-firewall'),
			'details' => __('Details', 'all-in-one-wp-security-and-firewall'),
			'stacktrace' => __('Stack trace', 'all-in-one-wp-security-and-firewall')
		);
		$columns = apply_filters('list_auditlogs_get_columns', $columns);
		return $columns;
	}

	/**
	 * Sets which of the columns the table data can be sorted by
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'created' => array('created', false),
			'network_id' => array('network_id', false),
			'site_id' => array('site_id', false),
			'level' => array('level', false),
			'username' => array('username', false),
			'ip' => array('ip', false),
			'event_type' => array('event_type', false),
			'details' => array('details', false),
			'stacktrace' => array('stacktrace', false)
		);
		$sortable_columns = apply_filters('list_auditlogs_get_sortable_columns', $sortable_columns);
		return $sortable_columns;
	}

	/**
	 * This function will display a list of bulk actions for the list table
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'delete_all' => __('Delete all', 'all-in-one-wp-security-and-firewall'),
			'delete_selected' => __('Delete selected', 'all-in-one-wp-security-and-firewall'),
			'delete_filtered' => __('Delete filtered', 'all-in-one-wp-security-and-firewall')
		);
		return $actions;
	}

	/**
	 * This function will process the bulk action request, $search_term and $filters are only used if the user is trying to bulk delete the filtered items
	 *
	 * @param string $search_term - The search term used for filtering records.
	 * @param array  $filters     - An array containing filters applied to the records.
	 * @param string $action      - The bulk action to be performed.
	 * @param array  $items       - An array of record IDs on which the action will be performed. Default is an empty array.
	 *
	 * @return void
	 */
	private function process_bulk_action($search_term, $filters, $action, $items = array()) {
		global $wpdb;

		if ('delete_selected' === $action) { // Process delete bulk actions
			if (!isset($items)) {
				AIOS_Helper::set_message('aios_list_message', __('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'), 'error');
			} else {
				$this->delete_audit_event_records($items);
			}
		} elseif ('delete_filtered' === $action) {
			if (!empty($filters) || '' !== $search_term) {
				$audit_log_tbl = AIOWPSEC_TBL_AUDIT_LOG;
				$where_sql = $this->get_audit_list_where_sql($search_term, $filters);
				// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
				$results = $wpdb->get_results("SELECT id FROM {$audit_log_tbl} {$where_sql}", 'ARRAY_A');
				$items = array_column($results, 'id');
				$this->delete_audit_event_records($items);
			} else {
				AIOS_Helper::set_message('aios_list_message', __('Please select the level or the event type filter or filter by a search term', 'all-in-one-wp-security-and-firewall'), 'error');
			}
		} elseif ('delete_all' === $action) {
			$this->delete_audit_event_records(null, true);
		}
	}

	/**
	 * Outputs extra controls to be displayed between bulk actions and pagination
	 *
	 * @param string $which - where we are outputting content (top or bottom)
	 *
	 * @return void
	 */
	protected function extra_tablenav($which) {
		switch ($which) {
			case 'top':
				?>
					<div class="alignleft actions">
						<select name="level-filter" class="audit-filter-level">
						<?php $selected = !isset($this->_args['data']['level-filter']) ? ' selected = "selected"' : ''; ?>
							<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- No user input to escape. ?>
							<option value="-1" <?php echo $selected; ?>><?php esc_html_e('All levels', 'all-in-one-wp-security-and-firewall'); ?></option>
							<?php
								foreach (AIOWPSecurity_Audit_Events::$log_levels as $level) {
									$selected = isset($this->_args['data']['level-filter']) && $this->_args['data']['level-filter'] == $level ? ' selected = "selected"' : '';
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- No user input to escape.
									echo '<option value="'. esc_attr($level) .'" '. $selected .'>'. esc_html($level) .'</option>';
								}
							?>
						</select>
						<select name="event-filter" class="audit-filter-event">
						<?php $selected = !isset($this->_args['data']['event-filter']) ? ' selected = "selected"' : ''; ?>
							<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- No user input to escape. ?>
							<option value="-1" <?php echo $selected; ?>><?php esc_html_e('All events', 'all-in-one-wp-security-and-firewall'); ?></option>
							<?php
								foreach (AIOWPSecurity_Audit_Events::$event_types as $event_type => $event) {
									$selected = isset($this->_args['data']['event-filter']) && $this->_args['data']['event-filter'] == $event_type ? ' selected = "selected"' : '';
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- No user input to escape.
									echo '<option value="'. esc_attr($event_type) .'" '. $selected .'>'. esc_html($event) .'</option>';
								}
							?>
						</select>
						<?php submit_button(esc_html__('Filter', 'all-in-one-wp-security-and-firewall'), 'action', '', false); ?>
					</div>
				<?php
				break;
			case 'bottom':
				submit_button(esc_html__('Export to CSV', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_export_audit_event_logs_to_csv', false);
				break;
		}
	}

	/**
	 * This function will process the delete request for the audit event records
	 *
	 * @param integer|array $entries    - an ID or array of IDs to be deleted
	 * @param boolean       $delete_all - indicates if all entries should be deleted or not (if true, then $entries will be ignored)
	 *
	 * @return void|string
	 */
	public function delete_audit_event_records($entries, $delete_all = false) {
		global $wpdb, $aio_wp_security;
		
		$audit_log_tbl = AIOWPSEC_TBL_AUDIT_LOG;
		$result = false;

		if ($delete_all) {
			// Delete all records
			$site_id_where_sql = (!is_super_admin()) ? ' WHERE site_id = ' . get_current_blog_id() : '';
			$delete_command = "DELETE FROM " . $audit_log_tbl . $site_id_where_sql;
			// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
			$result = $wpdb->query($delete_command);
		} elseif (is_array($entries)) {
			// Delete multiple records
			$entries = array_map('esc_sql', $entries); // Escape every array element
			$entries = array_filter($entries, 'is_numeric'); // Discard non-numeric ID values
			$chunks = array_chunk($entries, 1000);

			$site_id_where_sql = (!is_super_admin()) ? ' AND site_id = ' . get_current_blog_id() : '';

			// Processing each chunk
			foreach ($chunks as $chunk) {
				$id_list = "(" . implode(",", $chunk) . ")"; // Create comma separate list for DB operation
				$delete_command = "DELETE FROM " . $audit_log_tbl . " WHERE id IN " . $id_list . $site_id_where_sql;
				// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
				$result = $wpdb->query($delete_command);
				if (!$result) {
					$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Audit log table. Database error: '.$wpdb->last_error, 4);
					AIOS_Helper::set_message('aios_list_message', __('The selected record(s) have failed to delete.', 'all-in-one-wp-security-and-firewall'), 'error');
					return;
				}
			}
		} elseif (!empty($entries)) {
			// Delete single record
			$site_id_where_sql = (!is_super_admin()) ? ' AND site_id = ' . get_current_blog_id() : '';
			$delete_command = "DELETE FROM " . $audit_log_tbl . " WHERE id = '" . absint($entries) . "'" . $site_id_where_sql;
			// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
			$result = $wpdb->query($delete_command);
		}

		if ($result || 0 < $result) {
			$aios_list_message = __('The selected record(s) has been deleted successfully.', 'all-in-one-wp-security-and-firewall');
			AIOS_Helper::set_message('aios_list_message', $aios_list_message);
		} else {
			$aios_list_message = __('The selected record(s) have failed to delete.', 'all-in-one-wp-security-and-firewall');
			$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Audit log table. Database error: '.$wpdb->last_error, 4);
			AIOS_Helper::set_message('aios_list_message', $aios_list_message, 'error');
		}

		return $aios_list_message;
	}

	/**
	 * This function will build and return the SQL WHERE statement
	 *
	 * @param string $search_term - the search term applied
	 * @param array  $filters     - the filters applied
	 *
	 * @return string - the SQL WHERE statement
	 */
	private function get_audit_list_where_sql($search_term, $filters) {
		
		$where_sql = '';

		if ('' == $search_term) {
			$where_sql = (!is_super_admin()) ? 'WHERE site_id = '.get_current_blog_id() : '';
			$extra_where = '';
			
			if (!empty($filters)) {
				$where_sql = empty($where_sql) ? 'WHERE ' : $where_sql . ' AND ';
				foreach ($filters as $filter => $value) {
					if (!empty($extra_where)) $extra_where .= ' AND ';
					$extra_where .= "`{$filter}` = '".esc_sql($value)."'";
				}
			}

			$where_sql .= $extra_where;
		} else {
			$where_sql = (!is_super_admin()) ? 'WHERE site_id = '.get_current_blog_id().' AND ' : 'WHERE ';
			$extra_where = '';

			if (!empty($filters)) {
				foreach ($filters as $filter => $value) {
					if (!empty($extra_where)) $extra_where .= ' AND ';
					$extra_where .= "`{$filter}` = '".esc_sql($value)."'";
				}
				$where_sql .= $extra_where . ' AND (';
				$extra_where = '';
			}

			// We don't use FILTER_VALIDATE_IP here as we want to be able to search for partial IP's
			if (preg_match('/^[0-9a-f:\.]+$/i', $search_term)) {
				$extra_where .= "`ip` LIKE '".esc_sql($search_term)."%'";
			}
			
			if (in_array($search_term, AIOWPSecurity_Audit_Events::$log_levels) && !isset($filters['level'])) {
				if (!empty($extra_where)) $extra_where .= ' OR ';
				$extra_where .= "`level` = '".esc_sql($search_term)."'";
			}
			
			if (!empty($extra_where)) $extra_where .= ' OR ';
			if (isset($filters['event_type'])) {
				$extra_where .= "`username` LIKE '".esc_sql($search_term)."%'";
			} else {
				$extra_where .= "(`username` LIKE '".esc_sql($search_term)."%' or `event_type` LIKE '%".esc_sql($search_term)."%')";
			}
			if (!empty($filters)) $extra_where .= ')';
			
			$where_sql .= $extra_where;
		}

		return $where_sql;
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
		$no_action = -1;
		$per_page = defined('AIOWPSEC_AUDIT_LOG_PER_PAGE') ? absint(AIOWPSEC_AUDIT_LOG_PER_PAGE) : 100;
		$per_page = empty($per_page) ? 100 : $per_page;
		$current_page = $this->get_pagenum();
		$offset = (!$ignore_pagination && $per_page > 0) ? ($current_page - 1) * $per_page : 0;
		$columns = $this->get_columns();
		$hidden = array('id'); // we really don't need the IDs of the log entries displayed
		if (!is_multisite()) {
			$hidden[] = 'network_id';
			$hidden[] = 'site_id';
		}
		$sortable = $this->get_sortable_columns();
		$filters = array();
		if (isset($this->_args['data']['level-filter']) && $no_action != $this->_args['data']['level-filter']) $filters['level'] = sanitize_text_field($this->_args['data']['level-filter']);
		if (isset($this->_args['data']['event-filter']) && $no_action != $this->_args['data']['event-filter']) $filters['event_type'] = sanitize_text_field($this->_args['data']['event-filter']);
		$search_term = isset($this->_args['data']['s']) ? sanitize_text_field(stripslashes($this->_args['data']['s'])) : '';
		
		$this->_column_headers = array($columns, $hidden, $sortable);

		$items = array();

		if (isset($this->_args['data']['items'])) {
			if (is_array($this->_args['data']['items'])) {
				foreach ($this->_args['data']['items'] as $item) {
					$sanitized_item = sanitize_text_field($item);
					$items[] = $sanitized_item;
				}
			} else {
				$sanitized_item = sanitize_text_field($this->_args['data']['items']);
				$items[] = $sanitized_item;
			}
		} else {
			$items = null;
		}

		if (isset($this->_args['data']['action'])) $action = sanitize_text_field($this->_args['data']['action']);
		else $action = $no_action;

		if (isset($action) && $no_action !== $action) {
			$this->process_bulk_action($search_term, $filters, $action, $items);
		}

		global $wpdb;

		$audit_log_tbl = AIOWPSEC_TBL_AUDIT_LOG;

		// Parameters that are going to be used to order the result
		isset($this->_args['data']["orderby"]) ? $orderby = wp_strip_all_tags($this->_args['data']["orderby"]) : $orderby = '';
		isset($this->_args['data']["order"]) ? $order = wp_strip_all_tags($this->_args['data']["order"]) : $order = '';
		// By default show the most recent audit log entries.
		$orderby = !empty($orderby) ? esc_sql($orderby) : 'created';
		$order = !empty($order) ? esc_sql($order) : 'DESC';

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		$orderby = sanitize_sql_orderby($orderby);
		$order = sanitize_sql_orderby($order);

		$where_sql = $this->get_audit_list_where_sql($search_term, $filters);

		// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
		$total_items = $wpdb->get_var("SELECT COUNT(*) FROM {$audit_log_tbl} {$where_sql}");
		if ($ignore_pagination) {
			// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
			$data = $wpdb->get_results("SELECT * FROM {$audit_log_tbl} {$where_sql} ORDER BY {$orderby} {$order}", 'ARRAY_A');
		} else {
			// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Ignore.
			$data = $wpdb->get_results("SELECT * FROM {$audit_log_tbl} {$where_sql} ORDER BY {$orderby} {$order} LIMIT {$per_page} OFFSET {$offset}", 'ARRAY_A');
		}
		
		// Filter the 'details' section
		foreach ($data as $key => $entry) {
			$details = json_decode($entry['details'], true);
			$details = is_null($details) ? $entry['details'] : $details; // check if the decode worked, if not pass the json string
			$data[$key]['details'] = wp_json_encode(apply_filters('aios_audit_filter_details', $details, $entry['event_type']));
		}
		
		$this->items = $data;

		if ($ignore_pagination) return;
		
		$this->set_pagination_args(array(
			'total_items' => $total_items,                  // We have to calculate the total number of items
			'per_page' => $per_page,                        // We have to determine how many items to show on a page
			'total_pages' => ceil($total_items / $per_page) // We have to calculate the total number of pages
		));
	}
}
