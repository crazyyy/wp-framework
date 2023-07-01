<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_List_Audit_Log extends AIOWPSecurity_List_Table {

	/**
	 * Sets up some table attributes (i.e: the plurals and whether it's ajax or not)
	 */
	public function __construct() {
		global $status, $page;

		// Set parent defaults
		parent::__construct(array(
			'singular' => 'item', // singular name of the listed records
			'plural' => 'items',  // plural name of the listed records
			'ajax' => false       // does this table support ajax?
		));

	}

	/**
	 * Returns the default column item
	 *
	 * @param object $item
	 * @param string $column_name
	 * @return void
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
	 * @param array - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_created($item) {
		$tab = strip_tags($_REQUEST['tab']);

		$delete_url = sprintf('admin.php?page=%s&tab=%s&action=%s&id=%s', AIOWPSEC_MAIN_MENU_SLUG, $tab, 'delete_audit_log', $item['id']);
		// Add nonce to delete URL
		$delete_url_nonce = wp_nonce_url($delete_url, "delete_audit_log", "aiowps_nonce");

		// Build row actions
		$actions = array(
			'delete' => '<a href="'.$delete_url_nonce.'" onclick="return confirm(\''.esc_js(__('Are you sure you want to delete this item?', 'all-in-one-wp-security-and-firewall')).'\')">'.__('Delete').'</a>',
		);

		// Return the user_login contents
		return sprintf('%1$s <span style="color:silver"></span>%2$s',
			/* $1%s */ date('Y-m-d H:i:s', $item['created']),
			/* $2%s */ $this->row_actions($actions)
		);
	}
	
	/**
	 * Returns event type column html to be rendered.
	 *
	 * @param array - data for the columns on the current row
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
	 * @param array - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_details($item) {
		$details = json_decode($item['details'], true);
		
		if (!is_array($details)) return $item['details'];

		if (array_key_exists('core_updated', $details)) {
			$info = $details['core_updated'];
			return sprintf(__('WordPress updated from version %s to %s', 'all-in-one-wp-security-and-firewall'), $info['old_version'], $info['new_version']);
		} elseif (array_key_exists('plugin', $details)) {
			$info = $details['plugin'];
			return sprintf(__('Plugin', 'all-in-one-wp-security-and-firewall').': %s %s %s (v%s)', $info['name'], $info['network'], $info['action'], $info['version']);
		} elseif (array_key_exists('theme', $details)) {
			$info = $details['theme'];
			if ('activated' == $info['action']) {
				return sprintf(__('Theme', 'all-in-one-wp-security-and-firewall').': %s %s', $info['name'], $info['action']);
			} else {
				return sprintf(__('Theme', 'all-in-one-wp-security-and-firewall').': %s %s %s (v%s)', $info['name'], $info['network'], $info['action'], $info['version']);
			}
		} elseif (array_key_exists('entity_changed', $details)) {
			$info = $details['entity_changed'];
			if ($info['entity']) {
				return sprintf(__('Entity: "%s" has changed, please check the stacktrace for more details', 'all-in-one-wp-security-and-firewall'), $info['entity']);
			} else {
				return __('An unknown entity has changed, please check the stacktrace for more details', 'all-in-one-wp-security-and-firewall');
			}
		} elseif (array_key_exists('translation_updated', $details)) {
			$info = $details['translation_updated'];
			if ('core' == $info['type']) {
				return sprintf(__('Core %s translations updated to version %s', 'all-in-one-wp-security-and-firewall'), $info['language'], $info['version']);
			} elseif ('plugin' == $info['type']) {
				return sprintf(__('Plugin "%s" %s translations updated to version %s', 'all-in-one-wp-security-and-firewall'), $info['slug'], $info['language'], $info['version']);
			} elseif ('theme' == $info['type']) {
				return sprintf(__('Theme "%s" %s translations updated to version %s', 'all-in-one-wp-security-and-firewall'), $info['slug'], $info['language'], $info['version']);
			}
		} elseif (array_key_exists('failed_login', $details)) {
			$info = $details['failed_login'];
			if ($info['imported']) {
				return __('Event imported from the failed logins table', 'all-in-one-wp-security-and-firewall');
			} elseif ($info['known']) {
				return sprintf(__('Failed login attempt with a known username: %s', 'all-in-one-wp-security-and-firewall'), $info['username']);
			} else {
				return sprintf(__('Failed login attempt with a unknown username: %s', 'all-in-one-wp-security-and-firewall'), $info['username']);
			}
		} elseif (array_key_exists('successful_login', $details)) {
			$info = $details['successful_login'];
			return sprintf(__('Successful login with username: %s', 'all-in-one-wp-security-and-firewall'), $info['username']);
		} elseif (array_key_exists('user_registration', $details)) {
			$info = $details['user_registration'];
			if ('admin' == $info['type']) {
				return sprintf(__('Admin %s registered new user: %s', 'all-in-one-wp-security-and-firewall'), $info['admin_username'], $info['registered_username']);
			} elseif ('pending' == $info['type']) {
				return sprintf(__('User %s registered and set to pending', 'all-in-one-wp-security-and-firewall'), $info['registered_username']);
			} elseif ('registered' == $info['type']) {
				return sprintf(__('User %s registered', 'all-in-one-wp-security-and-firewall'), $info['registered_username']);
			}
		} elseif (array_key_exists('table_migration', $details)) {
			$info = $details['table_migration'];
			if ($info['success']) {
				return sprintf(__('Successfully migrated the `%s` table data to the `%s` table', 'all-in-one-wp-security-and-firewall'), $info['from_table'], $info['to_table']);
			} else {
				return sprintf(__('Failed to migrate the `%s` table data to the `%s` table', 'all-in-one-wp-security-and-firewall'), $info['from_table'], $info['to_table']);
			}
		}

		return $item['details'];
	}

	/**
	 * Returns stack trace column html to be rendered.
	 *
	 * @param array - data for the columns on the current row
	 *
	 * @return string - the html to be rendered
	 */
	public function column_stacktrace($item) {
		if (empty($item['stacktrace'])) return __('No stack trace available.', 'all-in-one-wp-security-and-firewall');
		
		$stacktrace = maybe_unserialize($item['stacktrace']);
		ob_start();
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
			'id' => 'ID',
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

		return $sortable_columns;
	}

	/**
	 * This function will display a list of bulk actions for the list table
	 *
	 * @return void
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
	 * @param string $search_term - the search string
	 * @param array  $filters - the filters
	 *
	 * @return void
	 */
	private function process_bulk_action($search_term, $filters) {
		if (empty($_REQUEST['_wpnonce']) || !isset($_REQUEST['_wp_http_referer'])) return;
		$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_REQUEST['_wpnonce'], 'bulk-items');
		if (is_wp_error($result)) return;
		
		global $wpdb;

		$audit_log_tbl = AIOWPSEC_TBL_AUDIT_LOG;
		
		if ('delete_all' === $this->current_action()) { // Process delete bulk actions
			$this->delete_audit_event_records(array(), true);
		} elseif ('delete_selected' === $this->current_action()) {
			if (!isset($_REQUEST['item'])) {
				AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Please select some records using the checkboxes', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->delete_audit_event_records($_REQUEST['item']);
			}
		} elseif ('delete_filtered' === $this->current_action()) {
			$where_sql = $this->get_audit_list_where_sql($search_term, $filters);
			$results = $wpdb->get_results("SELECT id FROM {$audit_log_tbl} {$where_sql}", 'ARRAY_A');
			$items = array_column($results, 'id');
			$this->delete_audit_event_records($items);
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
							<?php $selected = !isset($_POST['level-filter']) ? ' selected = "selected"' : ''; ?>
							<option value="-1" <?php echo $selected; ?>><?php _e('All levels', 'all-in-one-wp-security-and-firewall'); ?></option>
							<?php
								foreach(AIOWPSecurity_Audit_Events::$log_levels as $level) {
									$selected = isset($_POST['level-filter']) && $_POST['level-filter'] == $level ? ' selected = "selected"' : '';
									echo '<option value="'. $level .'" '. $selected .'>'. $level .'</option>';
								}
							?>
						</select>
						<select name="event-filter" class="audit-filter-event">
						<?php $selected = !isset($_POST['event-filter']) ? ' selected = "selected"' : ''; ?>
							<option value="-1" <?php echo $selected; ?>><?php _e('All events', 'all-in-one-wp-security-and-firewall'); ?></option>
							<?php
								foreach(AIOWPSecurity_Audit_Events::$event_types as $event => $description) {
									$selected = isset($_POST['event-filter']) && $_POST['event-filter'] == $event ? ' selected = "selected"' : '';
									echo '<option value="'. $event .'" '. $selected .'>'. $description .'</option>';
								}
							?>
						</select>
						<?php submit_button(__('Filter', 'all-in-one-wp-security-and-firewall'), 'action', '', false); ?>
					</div>
				<?php
				break;
			case 'bottom':
				submit_button(__('Export to CSV', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_export_audit_event_logs_to_csv', false);
				break;
		}
	}

	/**
	 * This function will process the delete request for the audit event records
	 *
	 * @param integer|array $entries    - a ID or array of IDs to be deleted
	 * @param boolean       $delete_all - indicates if all entries should be deleted or not (if true, then $entries will be ignored)
	 *
	 * @return void
	 */
	public function delete_audit_event_records($entries, $delete_all = false) {
		global $wpdb, $aio_wp_security;
		
		$audit_log_tbl = AIOWPSEC_TBL_AUDIT_LOG;
		$result = false;
		
		if ($delete_all) {
			// Delete all records
			$delete_command = "DELETE FROM " . $audit_log_tbl;
			$result = $wpdb->query($delete_command);
		} elseif (is_array($entries)) {
			// Delete multiple records
			$entries = array_map('esc_sql', $entries); // Escape every array element
			$entries = array_filter($entries, 'is_numeric'); // Discard non-numeric ID values
			$chunks = array_chunk($entries, 1000);

			// Processing each chunk
			foreach ($chunks as $chunk) {
				$id_list = "(" . implode(",", $chunk) . ")"; // Create comma separate list for DB operation
				$delete_command = "DELETE FROM " . $audit_log_tbl . " WHERE id IN " . $id_list;
				$result = $wpdb->query($delete_command);
				if (!$result) {
					$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Audit log table. Database error: '.$wpdb->last_error, 4);
					AIOWPSecurity_Admin_Menu::show_msg_record_not_deleted_st();
					return;
				}
			}
		} elseif ($entries != NULL) {
			// Delete single record
			$delete_command = "DELETE FROM " . $audit_log_tbl . " WHERE id = '" . absint($entries) . "'";
			$result = $wpdb->query($delete_command);
		}

		if ($result) {
			AIOWPSecurity_Admin_Menu::show_msg_record_deleted_st();
		} else {
			$aio_wp_security->debug_logger->log_debug('Database error occurred when deleting rows from Audit log table. Database error: '.$wpdb->last_error, 4);
			AIOWPSecurity_Admin_Menu::show_msg_record_not_deleted_st();
		}
	}

	/**
	 * This function will build and return the SQL WHERE statement
	 *
	 * @param string $search_term - the search term applied
	 * @param array  $filters - the filters applied
	 *
	 * @return string - the SQL WHERE statement
	 */
	private function get_audit_list_where_sql($search_term, $filters) {
		
		$where_sql = '';

		if ('' == $search_term) {
			$where_sql = (is_multisite() && !is_main_site()) ? 'WHERE site_id = '.get_current_blog_id() : '';
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
			$where_sql = (is_multisite() && !is_main_site()) ? 'WHERE site_id = '.get_current_blog_id().' AND ' : 'WHERE ';
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
		if (defined('AIOWPSEC_AUDIT_LOG_PER_PAGE')) {
			$per_page = absint(AIOWPSEC_AUDIT_LOG_PER_PAGE);
		}

		$per_page = empty($per_page) ? 100 : $per_page;
		$current_page = $this->get_pagenum();
		$offset = ($current_page - 1) * $per_page;
		$columns = $this->get_columns();
		$hidden = array('id'); // we really don't need the IDs of the log entries displayed
		if (!is_multisite()) {
			$hidden[] = 'network_id';
			$hidden[] = 'site_id';
		}
		$sortable = $this->get_sortable_columns();
		$filters = array();
		if (isset($_REQUEST['level-filter']) && -1 != $_REQUEST['level-filter']) $filters['level'] = sanitize_text_field($_REQUEST['level-filter']);
		if (isset($_REQUEST['event-filter']) && -1 != $_REQUEST['event-filter']) $filters['event_type'] = sanitize_text_field($_REQUEST['event-filter']);
		$search_term = isset($_REQUEST['s']) ? sanitize_text_field(stripslashes($_REQUEST['s'])) : '';

		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action($search_term, $filters);

		global $wpdb;

		$audit_log_tbl = AIOWPSEC_TBL_AUDIT_LOG;

		/* -- Ordering parameters -- */
		// Parameters that are going to be used to order the result
		isset($_GET["orderby"]) ? $orderby = strip_tags($_GET["orderby"]) : $orderby = '';
		isset($_GET["order"]) ? $order = strip_tags($_GET["order"]) : $order = '';

		// By default show the most recent audit log entries.
		$orderby = !empty($orderby) ? esc_sql($orderby) : 'created';
		$order = !empty($order) ? esc_sql($order) : 'DESC';

		$orderby = AIOWPSecurity_Utility::sanitize_value_by_array($orderby, $sortable);
		$order = AIOWPSecurity_Utility::sanitize_value_by_array($order, array('DESC' => '1', 'ASC' => '1'));

		$orderby = sanitize_sql_orderby($orderby);
		$order = sanitize_sql_orderby($order);

		$where_sql = $this->get_audit_list_where_sql($search_term, $filters);

		$total_items = $wpdb->get_var("SELECT COUNT(*) FROM {$audit_log_tbl} {$where_sql}");
		if ($ignore_pagination) {
			$data = $wpdb->get_results("SELECT * FROM {$audit_log_tbl} {$where_sql} ORDER BY {$orderby} {$order}", 'ARRAY_A');
		} else {
			$data = $wpdb->get_results("SELECT * FROM {$audit_log_tbl} {$where_sql} ORDER BY {$orderby} {$order} LIMIT {$per_page} OFFSET {$offset}", 'ARRAY_A');
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
