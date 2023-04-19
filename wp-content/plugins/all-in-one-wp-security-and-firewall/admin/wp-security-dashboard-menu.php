<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Dashboard_Menu extends AIOWPSecurity_Admin_Menu {
	
	/**
	 * Dashboard menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_MAIN_MENU_SLUG;

	/**
	 * Constructor adds menu for Dashboard
	 */
	public function __construct() {
		parent::__construct(__('Dashboard', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'dashboard' => array(
				'title' => __('Dashboard', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_dashboard'),
			),
			'locked-ip' => array(
				'title' => __('Locked IP addresses', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_locked_ip'),
			),
			'permanent-block' => array(
				'title' => __('Permanent block list', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_permanent_block'),
			),
			'audit-logs' => array(
				'title' => __('Audit logs', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_audit_logs'),
			),
			'debug-logs' => array(
				'title' => __('Debug logs', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_debug_logs'),
			),
			'premium-upgrade' => array(
				'title' => __('Premium upgrade', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_premium_upgrade_tab'),
				'display_condition_callback' => function() {
					return !AIOWPSecurity_Utility_Permissions::is_premium_installed();
				}
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Renders the submenu's dashboard tab
	 *
	 * @return Void
	 */
	protected function render_dashboard() {
		/** Load WordPress dashboard API */
		require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
		$this->wp_dashboard_setup();

		wp_enqueue_script('dashboard');
		if (wp_is_mobile()) wp_enqueue_script( 'jquery-touch-punch' );
		?>
		<script type='text/javascript' src='https://www.google.com/jsapi'></script>
		<div id="dashboard-widgets-wrap">
		<?php $this->wp_dashboard(); ?>
		</div><!-- dashboard-widgets-wrap -->
		<?php
	}

	/**
	 * Renders the submenu's locked IP addresses tab
	 *
	 * @return Void
	 */
	protected function render_locked_ip() {
		global $aio_wp_security, $wpdb;
		include_once 'wp-security-list-locked-ip.php';
		$locked_ip_list = new AIOWPSecurity_List_Locked_IP();

		if (isset($_REQUEST['action'])) { // Do list table form row action tasks
			if ($_REQUEST['action'] == 'delete_blocked_ip') { // Delete link was clicked for a row in list table
				$locked_ip_list->delete_lockout_records(strip_tags($_REQUEST['lockout_id']));
			}

			if ('unlock_ip' == $_REQUEST['action']) { // Unlock link was clicked for a row in list table
				$locked_ip_list->unlock_ip_range(strip_tags($_REQUEST['lockout_id']));
			}
		}

		$aio_wp_security->include_template('wp-admin/dashboard/locked-ip.php', false, array('locked_ip_list' => $locked_ip_list));
	}

	/**
	 * Renders the submenu's permanent block tab
	 *
	 * @return Void
	 */
	protected function render_permanent_block() {
		global $aio_wp_security, $wpdb;
		include_once 'wp-security-list-permanent-blocked-ip.php'; // For rendering the AIOWPSecurity_List_Table
		$blocked_ip_list = new AIOWPSecurity_List_Blocked_IP(); // For rendering the AIOWPSecurity_List_Table

		if (isset($_REQUEST['action'])) { // Do list table form row action tasks
			if ($_REQUEST['action'] == 'unblock_ip') { // Unblock link was clicked for a row in list table
				$blocked_ip_list->unblock_ip_address(strip_tags($_REQUEST['blocked_id']));
			}
		}

		$aio_wp_security->include_template('wp-admin/dashboard/permanent-block.php', false, array('blocked_ip_list' => $blocked_ip_list));
	}

	/**
	 * Renders the submenu's audit logs tab
	 *
	 * @return void
	 */
	protected function render_audit_logs() {
		global $aio_wp_security;

		// Needed for rendering the audit log table
		include_once 'wp-security-list-audit.php';
		$audit_log_list = new AIOWPSecurity_List_Audit_Log();

		if (isset($_REQUEST['action'])) { // Do list table form row action tasks
			if ('delete_audit_log' == $_REQUEST['action']) { // Delete link was clicked for a row in list table
				$nonce = isset($_REQUEST['aiowps_nonce']) ? $_REQUEST['aiowps_nonce'] : '';
			
				if (!isset($nonce) || !wp_verify_nonce($nonce, 'delete_audit_log')) {
					$aio_wp_security->debug_logger->log_debug("Nonce check failed for delete selected Audit event logs operation.", 4);
					die(__('Nonce check failed for delete selected Audit event logs operation.','all-in-one-wp-security-and-firewall'));
				}
				$audit_log_list->delete_audit_event_records(absint($_REQUEST['id']));
			}
		}

		$aio_wp_security->include_template('wp-admin/dashboard/audit-logs.php', false, array('audit_log_list' => $audit_log_list));
	}

	/**
	 * Renders the submenu's debug logs tab
	 *
	 * @return void
	 */
	protected function render_debug_logs() {
		// Needed for rendering the debug log table
		include_once 'wp-security-list-debug.php'; 
		$debug_log_list = new AIOWPSecurity_List_Debug_Log();

		global $wpdb, $aio_wp_security;

		// Handles clearing the debug logs
		if (isset($_POST['aiowpsec_clear_logs']) && isset($_POST['_wpnonce'])) {

			if (wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec_clear_debug_logs')) {

				$ret = $aio_wp_security->debug_logger->clear_logs();

				if (is_wp_error($ret)) {

				 ?>

					<div class="notice notice-error is-dismissible">
						<p><strong><?php echo htmlspecialchars(__('All In One WP Security & Firewall', 'all-in-one-wp-security-and-firewall')); ?></strong></p>
						<p><?php echo esc_html($ret->get_error_message());  ?></p>
						<p><?php echo esc_html($ret->get_error_data());  ?></p>
					</div>

					<?php

				} else {

					?>
					<div class="notice notice-success is-dismissible">
						<p><strong><?php echo htmlspecialchars(__('All In One WP Security & Firewall', 'all-in-one-wp-security-and-firewall')); ?></strong></p>
						<p><?php _e( 'Debug logs have been cleared.', 'all-in-one-wp-security-and-firewall' ); ?></p>
					</div>
					<?php

				}

			} else {
				?>

					<div class="notice notice-error is-dismissible">
						<p><strong><?php echo htmlspecialchars(__('All In One WP Security & Firewall', 'all-in-one-wp-security-and-firewall')); ?></strong></p>
						<p><?php _e( 'Unable to clear the logs; an invalid nonce was provided', 'all-in-one-wp-security-and-firewall' ); ?></p>
					</div>

				<?php
			}

		}
		$aio_wp_security->include_template('wp-admin/dashboard/debug-logs.php', false, array('debug_log_list' => $debug_log_list));
	}

	/**
	 * Renders the submenu's premium-upgrade tab body.
	 *
	 * @return Void
	 */
	protected function render_premium_upgrade_tab() {
		global $aio_wp_security;
		$enqueue_version = (defined('WP_DEBUG') && WP_DEBUG) ? AIO_WP_SECURITY_VERSION.'.'.time() : AIO_WP_SECURITY_VERSION;
		wp_enqueue_style('aiowpsec-admin-premium-upgrade-css', AIO_WP_SECURITY_URL.'/css/wp-security-premium-upgrade.css', array(), $enqueue_version);

		echo '<div class="postbox wpo-tab-postbox">';

		$aio_wp_security->include_template('wp-admin/dashboard/may-also-like.php');

		echo '</div><!-- END .postbox -->';
	}

	private function wp_dashboard() {
		$screen = get_current_screen();
		$columns = absint( $screen->get_columns() );
		$columns_css = '';
		if ( $columns ) {
			$columns_css = " columns-$columns";
		}

		?>
		<div id="dashboard-widgets" class="metabox-holder<?php echo $columns_css; ?>">
			<div id="postbox-container-1" class="postbox-container">
			<?php do_meta_boxes( $screen->id, 'normal', '' ); ?>
			</div>
			<div id="postbox-container-2" class="postbox-container">
			<?php do_meta_boxes( $screen->id, 'side', '' ); ?>
			</div>
			<div id="postbox-container-3" class="postbox-container">
			<?php do_meta_boxes( $screen->id, 'column3', '' ); ?>
			</div>
			<div id="postbox-container-4" class="postbox-container">
			<?php do_meta_boxes( $screen->id, 'column4', '' ); ?>
			</div>
		</div>

		<?php
		wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
		wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
	}

	private function wp_dashboard_setup() {
		global $aio_wp_security, $wp_registered_widgets, $wp_registered_widget_controls, $wp_dashboard_control_callbacks;
		$wp_dashboard_control_callbacks = array();
		$screen = get_current_screen();

		// Add widgets
		wp_add_dashboard_widget('security_strength_meter', __('Security strength meter', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_security_strength_meter'));
		wp_add_dashboard_widget('security_points_breakdown', __('Security points breakdown', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_security_points_breakdown'));
		wp_add_dashboard_widget('spread_the_word', __('Spread the word', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_spread_the_word'));
		wp_add_dashboard_widget('know_developers', __('Get to know the developers', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_know_developers'));
		wp_add_dashboard_widget('critical_feature_status', __('Critical feature status', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_critical_feature_status'));
		wp_add_dashboard_widget('last_5_logins', __('Last 5 logins', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_last_5_logins'));
		wp_add_dashboard_widget('maintenance_mode_status', __('Maintenance mode status', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_maintenance_mode_status'));
		if ($aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention') == '1' ||
				$aio_wp_security->configs->get_value('aiowps_enable_rename_login_page') == '1') {
			wp_add_dashboard_widget('brute_force', __('Brute force prevention login page'), array($this, 'widget_brute_force'));
		}
		wp_add_dashboard_widget('logged_in_users', __('Logged in users', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_logged_in_users'));
		wp_add_dashboard_widget('locked_ip_addresses', __('Locked IP addresses', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_locked_ip_addresses'));

		do_action( 'aiowps_dashboard_setup' );
		$dashboard_widgets = apply_filters( 'aiowps_dashboard_widgets', array() );

		foreach ( $dashboard_widgets as $widget_id ) {
			$name = empty( $wp_registered_widgets[$widget_id]['all_link'] ) ? $wp_registered_widgets[$widget_id]['name'] : $wp_registered_widgets[$widget_id]['name'] . " <a href='{$wp_registered_widgets[$widget_id]['all_link']}' class='edit-box open-box'>" . __('View all') . '</a>';
			wp_add_dashboard_widget( $widget_id, $name, $wp_registered_widgets[$widget_id]['callback'], $wp_registered_widget_controls[$widget_id]['callback'] );
		}
	}

	public function widget_security_strength_meter() {
		global $aiowps_feature_mgr, $aio_wp_security;
		$total_site_security_points = $aiowps_feature_mgr->get_total_site_points();
		$total_security_points_achievable = $aiowps_feature_mgr->get_total_achievable_points();

		?>
		<script type='text/javascript'>
			google.load('visualization', '1', {packages: ['gauge']});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Label', 'Value'],
					['Strength', <?php echo $total_site_security_points; ?>]
				]);

				var options = {
					width: 320, height: 200, max: <?php echo $total_security_points_achievable; ?>,
					greenColor: '8EFA9B', yellowColor: 'F5EE90', redColor: 'FA7373',
					redFrom: 0, redTo: 10,
					yellowFrom: 10, yellowTo: 50,
					greenFrom: 50, greenTo: <?php echo $total_security_points_achievable; ?>,
					minorTicks: 5
				};

				var chart = new google.visualization.Gauge(document.getElementById('security_strength_chart_div'));
				chart.draw(data, options);
			}
		</script>
		<div id='security_strength_chart_div'></div>
		<div class="aiowps_dashboard_widget_footer">
			<?php
			_e('Total Achievable Points: ', 'all-in-one-wp-security-and-firewall');
			echo '<strong>' . $total_security_points_achievable . '</strong><br />';
			_e('Current Score of Your Site: ', 'all-in-one-wp-security-and-firewall');
			echo '<strong>' . $total_site_security_points . '</strong>';
			?>
		</div>
		<?php
	}

	public function widget_security_points_breakdown() {
		global $aiowps_feature_mgr, $aio_wp_security;
		$feature_mgr = $aiowps_feature_mgr;
		$total_site_security_points = $feature_mgr->get_total_site_points();
		$total_security_points_achievable = $feature_mgr->get_total_achievable_points();
		$feature_items = $feature_mgr->feature_items;
		$pt_src_chart_data = "";
		$pt_src_chart_data .= "['Feature Name', 'Points'],";
		foreach ($feature_items as $item) {
			if ($item->feature_status == $feature_mgr->feature_active) {
				$pt_src_chart_data .= "['" . $item->feature_name . "', " . $item->item_points . "],";
			}
		}
		?>
		<script type="text/javascript">
			google.load("visualization", "1", {packages: ["corechart"]});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					<?php echo $pt_src_chart_data; ?>
				]);

				var options = {
					// height: '250',
					// width: '450',
					backgroundColor: 'F6F6F6',
					pieHole: 0.4,
					chartArea: {
						width: '95%',
						height: '95%',
					}
				};

				var chart = new google.visualization.PieChart(document.getElementById('points_source_breakdown_chart_div'));
				chart.draw(data, options);
			}
		</script>
		<div id='points_source_breakdown_chart_div'></div>
		<?php
	}

	public function widget_spread_the_word() {
		?>
		<p><?php _e('We are working hard to make your WordPress site more secure. Please support us, here is how:', 'all-in-one-wp-security-and-firewall');?></p>
		<p><a href="https://twitter.com/intent/user?screen_name=UpdraftPlus" target="_blank"><?php _e('Follow us on', 'all-in-one-wp-security-and-firewall');?> Twitter</a>
		</p>
		<p>
			<a href="http://twitter.com/intent/tweet?url=https://wordpress.org/plugins/all-in-one-wp-security-and-firewall&text=I love the All In One WP Security and Firewall plugin!"
			target="_blank" class="aio_tweet_link"><?php _e('Post to Twitter', 'all-in-one-wp-security-and-firewall');?></a>
		</p>
		<p>
			<a href="http://wordpress.org/support/view/plugin-reviews/all-in-one-wp-security-and-firewall/"
			target="_blank" class="aio_rate_us_link"><?php _e('Give us a good rating', 'all-in-one-wp-security-and-firewall');?></a>
		</p>
		<?php
	}

	public function widget_know_developers() {
		?>
		<p><?php _e('Wanna know more about the developers behind this plugin?', 'all-in-one-wp-security-and-firewall');?></p>
		<p><a href="https://teamupdraft.com/" target="_blank">Team UpdraftPlus</a></p>
		<?php
	}

	public function widget_critical_feature_status() {
		global $aiowps_feature_mgr, $aio_wp_security;
		$feature_mgr = $aiowps_feature_mgr;

		_e('Below is the current status of the critical features that you should activate on your site to achieve a minimum level of recommended security', 'all-in-one-wp-security-and-firewall');
		$feature_items = $aiowps_feature_mgr->feature_items;
		$username_admin_feature = $aiowps_feature_mgr->get_feature_item_by_id("user-accounts-change-admin-user");
		echo '<div class="aiowps_feature_status_container">';
		echo '<div class="aiowps_feature_status_name">' . __('Admin username', 'all-in-one-wp-security-and-firewall') . '</div>';
		echo '<a href="admin.php?page=' . AIOWPSEC_USER_ACCOUNTS_MENU_SLUG . '">';
		echo '<div class="aiowps_feature_status_bar">';
		if ($username_admin_feature->feature_status == $aiowps_feature_mgr->feature_active) {
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_on">On</div>';
			echo '<div class="aiowps_feature_status_label">Off</div>';
		} else {
			echo '<div class="aiowps_feature_status_label">On</div>';
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_off">Off</div>';
		}
		echo '</div></div></a>';
		echo '<div class="aio_clear_float"></div>';

		$login_lockdown_feature = $aiowps_feature_mgr->get_feature_item_by_id("user-login-login-lockdown");
		echo '<div class="aiowps_feature_status_container">';
		echo '<div class="aiowps_feature_status_name">' . __('Login lockout', 'all-in-one-wp-security-and-firewall') . '</div>';
		echo '<a href="admin.php?page=' . AIOWPSEC_USER_LOGIN_MENU_SLUG . '">';
		echo '<div class="aiowps_feature_status_bar">';
		if ($login_lockdown_feature->feature_status == $aiowps_feature_mgr->feature_active) {
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_on">On</div>';
			echo '<div class="aiowps_feature_status_label">Off</div>';
		} else {
			echo '<div class="aiowps_feature_status_label">On</div>';
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_off">Off</div>';
		}
		echo '</div></div></a>';
		echo '<div class="aio_clear_float"></div>';

		$filesystem_feature = $aiowps_feature_mgr->get_feature_item_by_id("filesystem-file-permissions");
		echo '<div class="aiowps_feature_status_container">';
		echo '<div class="aiowps_feature_status_name">' . __('File permission', 'all-in-one-wp-security-and-firewall') . '</div>';
		echo '<a href="admin.php?page=' . AIOWPSEC_FILESYSTEM_MENU_SLUG . '">';
		echo '<div class="aiowps_feature_status_bar">';
		if ($filesystem_feature->feature_status == $aiowps_feature_mgr->feature_active) {
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_on">On</div>';
			echo '<div class="aiowps_feature_status_label">Off</div>';
		} else {
			echo '<div class="aiowps_feature_status_label">On</div>';
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_off">Off</div>';
		}
		echo '</div></div></a>';
		echo '<div class="aio_clear_float"></div>';

		$basic_firewall_feature = $aiowps_feature_mgr->get_feature_item_by_id("firewall-basic-rules");
		echo '<div class="aiowps_feature_status_container">';
		echo '<div class="aiowps_feature_status_name">' . __('Basic firewall', 'all-in-one-wp-security-and-firewall') . '</div>';
		echo '<a href="admin.php?page=' . AIOWPSEC_FIREWALL_MENU_SLUG . '">';
		echo '<div class="aiowps_feature_status_bar">';
		if ($basic_firewall_feature->feature_status == $aiowps_feature_mgr->feature_active) {
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_on">On</div>';
			echo '<div class="aiowps_feature_status_label">Off</div>';
		} else {
			echo '<div class="aiowps_feature_status_label">On</div>';
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_off">Off</div>';
		}
		echo '</div></div></a>';
		echo '<div class="aio_clear_float"></div>';
	}

	public function widget_last_5_logins() {
		global $wpdb;
		$login_activity_table = AIOWPSEC_TBL_USER_LOGIN_ACTIVITY;

		/* -- Ordering parameters -- */
		//Parameters that are going to be used to order the result
		isset($_GET["orderby"]) ? $orderby = strip_tags($_GET["orderby"]) : $orderby = '';
		isset($_GET["order"]) ? $order = strip_tags($_GET["order"]) : $order = '';

		$orderby = !empty($orderby) ? $orderby : 'login_date';
		$order = !empty($order) ? $order : 'DESC';

		$data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $login_activity_table ORDER BY login_date DESC LIMIT %d", 5), ARRAY_A); //Get the last 5 records

		if (null == $data) {
			echo '<p>' . __('No data found.', 'all-in-one-wp-security-and-firewall') . '</p>';
		} else {
			$login_summary_table = '';
			echo '<p>' . __('Last 5 logins summary:', 'all-in-one-wp-security-and-firewall') . '</p>';
			$login_summary_table .= '<table class="widefat aiowps_dashboard_table">';
			$login_summary_table .= '<thead>';
			$login_summary_table .= '<tr>';
			$login_summary_table .= '<th>' . __('User', 'all-in-one-wp-security-and-firewall') . '</th>';
			$login_summary_table .= '<th>' . __('Date', 'all-in-one-wp-security-and-firewall') . '</th>';
			$login_summary_table .= '<th>' . __('IP', 'all-in-one-wp-security-and-firewall') . '</th>';
			$login_summary_table .= '</tr>';
			$login_summary_table .= '</thead>';
			foreach ($data as $entry) {
				$login_summary_table .= '<tr>';
				$login_summary_table .= '<td>' . $entry['user_login'] . '</td>';
				$login_summary_table .= '<td>' . get_date_from_gmt(mysql2date('Y-m-d H:i:s', $entry['login_date']), get_option('date_format').' '.get_option('time_format')) . '</td>';
				$login_summary_table .= '<td>' . $entry['login_ip'] . '</td>';
				$login_summary_table .= '</tr>';
			}
			$login_summary_table .= '</table>';
			echo $login_summary_table;
		}

		echo '<div class="aio_clear_float"></div>';

	}

	public function widget_maintenance_mode_status() {
		global $aio_wp_security;
		if ($aio_wp_security->configs->get_value('aiowps_site_lockout') == '1') {
			echo '<p>' . __('Maintenance mode is currently enabled. Remember to turn it off when you are done', 'all-in-one-wp-security-and-firewall') . '</p>';
		} else {
			echo '<p>' . __('Maintenance mode is currently off.', 'all-in-one-wp-security-and-firewall') . '</p>';
		}

		echo '<div class="aiowps_feature_status_container">';
		echo '<div class="aiowps_feature_status_name">' . __('Maintenance mode', 'all-in-one-wp-security-and-firewall') . '</div>';
		echo '<a href="admin.php?page=' . AIOWPSEC_MAINTENANCE_MENU_SLUG . '">';
		echo '<div class="aiowps_feature_status_bar">';
		if ($aio_wp_security->configs->get_value('aiowps_site_lockout') == '1') { // Maintenance mode is enabled
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_off">On</div>'; // If enabled show red by usign the "off" class
			echo '<div class="aiowps_feature_status_label">Off</div>';
		} else {
			echo '<div class="aiowps_feature_status_label">On</div>';
			echo '<div class="aiowps_feature_status_label aiowps_feature_status_on">Off</div>';
		}
		echo '</div></div></a>';
		echo '<div class="aio_clear_float"></div>';
	}

	public function widget_brute_force() {
		global $aio_wp_security;
		if ($aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention') == '1') {
			$brute_force_login_feature_link = '<a href="admin.php?page=' . AIOWPSEC_BRUTE_FORCE_MENU_SLUG . '&tab=cookie-based-brute-force-prevention" target="_blank">' . __('Cookie-based brute force', 'all-in-one-wp-security-and-firewall') . '</a>';
			$brute_force_feature_secret_word = $aio_wp_security->configs->get_value('aiowps_brute_force_secret_word');
			echo '<div class="aio_yellow_box">';

			echo '<p>' . sprintf(__('The %s feature is currently active.', 'all-in-one-wp-security-and-firewall'), $brute_force_login_feature_link) . '</p>';
			echo '<p>' . __('Your new WordPress login URL is now:', 'all-in-one-wp-security-and-firewall') . '</p>';
			echo '<p><strong>' . AIOWPSEC_WP_URL . '/?' . $brute_force_feature_secret_word . '=1</strong></p>';
			echo '</div>'; //yellow box div
			echo '<div class="aio_clear_float"></div>';
		}// End if statement for Cookie Based Brute Prevention box

		// Insert Rename Login Page feature box if this feature is active
		if ($aio_wp_security->configs->get_value('aiowps_enable_rename_login_page') == '1') {
			if (get_option('permalink_structure')) {
				 $home_url = trailingslashit(home_url());
			} else {
				$home_url = trailingslashit(home_url()) . '?';
			}

			$rename_login_feature_link = '<a href="admin.php?page=' . AIOWPSEC_BRUTE_FORCE_MENU_SLUG . '&tab=rename-login" target="_blank">' . __('Rename login page', 'all-in-one-wp-security-and-firewall') . '</a>';
			echo '<div class="aio_yellow_box">';

			echo '<p>' . sprintf(__('The %s feature is currently active.', 'all-in-one-wp-security-and-firewall'), $rename_login_feature_link) . '</p>';
			echo '<p>' . __('Your new WordPress login URL is now:', 'all-in-one-wp-security-and-firewall') . '</p>';
			echo '<p><strong>' . $home_url . $aio_wp_security->configs->get_value('aiowps_login_page_slug') . '</strong></p>';
			echo '</div>'; //yellow box div
			echo '<div class="aio_clear_float"></div>';
		} // End if statement for Rename Login box
	}

	public function widget_logged_in_users() {
		$users_online_link = '<a href="admin.php?page=' . AIOWPSEC_USER_LOGIN_MENU_SLUG . '&tab=logged-in-users">'.__('Logged in users', 'all-in-one-wp-security-and-firewall').'</a>';
		// default display messages
		$multiple_users_info_msg = __('Number of users currently logged into your site (including you) is:', 'all-in-one-wp-security-and-firewall');
		$single_user_info_msg = __('There are no other users currently logged in.', 'all-in-one-wp-security-and-firewall');
		if (is_multisite()) {
			$current_blog_id = get_current_blog_id();
			$is_main = is_main_site($current_blog_id);

			if(empty($is_main)) {
				// subsite - only get logged in users for this blog_id
				$logged_in_users = AIOWPSecurity_User_Login::get_subsite_logged_in_users($current_blog_id);
			} else {
				// main site - get sitewide users
				$logged_in_users = get_site_transient('users_online');

				// If viewing AIOS from multisite main network dashboard then display a different message
				$multiple_users_info_msg = __('Number of users currently logged in site-wide (including you) is:', 'all-in-one-wp-security-and-firewall');
				$single_user_info_msg = __('There are no other site-wide users currently logged in.', 'all-in-one-wp-security-and-firewall');
			}
		} else {
			$logged_in_users = get_transient('users_online');
		}

		if (empty($logged_in_users)) {
			$num_users = 0;
		} else {
			$num_users = count($logged_in_users);
		}
		if ($num_users > 1) {
			echo '<div class="aio_red_box"><p>' . $multiple_users_info_msg . ' <strong>' . $num_users . '</strong></p>';
			$info_msg = '<p>' . sprintf(__('Go to the %s menu to see more details', 'all-in-one-wp-security-and-firewall'), $users_online_link) . '</p>';
			echo $info_msg . '</div>';
		} else {
			echo '<div class="aio_green_box"><p>' . $single_user_info_msg . '</p></div>';
		}
	}

	public function widget_locked_ip_addresses() {
		$locked_ips_link = '<a href="admin.php?page=' . AIOWPSEC_MAIN_MENU_SLUG . '&tab=locked-ip">Locked IP Addresses</a>';

		$locked_ips = AIOWPSecurity_Utility::get_locked_ips();
		if (false === $locked_ips) {
			echo '<div class="aio_green_box"><p>' . __('There are no IP addresses currently locked out.', 'all-in-one-wp-security-and-firewall') . '</p></div>';
		} else {
			$num_ips = count($locked_ips);
			echo '<div class="aio_red_box"><p>' . __('Number of temporarily locked out IP addresses: ', 'all-in-one-wp-security-and-firewall') . ' <strong>' . $num_ips . '</strong></p>';
			$info_msg = '<p>' . sprintf(__('Go to the %s menu to see more details', 'all-in-one-wp-security-and-firewall'), $locked_ips_link) . '</p>';
			echo $info_msg . '</div>';
		}
	}

} //end class
