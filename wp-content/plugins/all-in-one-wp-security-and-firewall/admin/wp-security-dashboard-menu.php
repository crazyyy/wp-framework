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
				'title' => __('Debugging', 'all-in-one-wp-security-and-firewall'),
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
		/**
		 * Load WordPress dashboard API
		 */
		require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
		$this->wp_dashboard_setup();

		wp_enqueue_script('dashboard');
		if (wp_is_mobile()) wp_enqueue_script('jquery-touch-punch');

		?>
		<?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Needed for dashboard widget.  ?>
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
		global $aio_wp_security;
		include_once 'wp-security-list-locked-ip.php';
		$locked_ip_list = new AIOWPSecurity_List_Locked_IP();
		$tab = isset($_REQUEST["tab"]) ? sanitize_text_field(wp_unslash($_REQUEST["tab"])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. No nonce for tabs.
		$page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. No nonce for page.

		$aio_wp_security->include_template('wp-admin/dashboard/locked-ip.php', false, array('locked_ip_list' => $locked_ip_list, 'page' => $page, 'tab' => $tab));
	}

	/**
	 * Renders the submenu's permanent block tab
	 *
	 * @return Void
	 */
	protected function render_permanent_block() {
		global $aio_wp_security;
		include_once 'wp-security-list-permanent-blocked-ip.php'; // For rendering the AIOWPSecurity_List_Table
		$blocked_ip_list = new AIOWPSecurity_List_Blocked_IP(); // For rendering the AIOWPSecurity_List_Table
		$tab = isset($_REQUEST["tab"]) ? sanitize_text_field(wp_unslash($_REQUEST["tab"])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. No nonce for tab.
		$page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. No nonce for page.

		$aio_wp_security->include_template('wp-admin/dashboard/permanent-block.php', false, array('blocked_ip_list' => $blocked_ip_list, 'page' => $page, 'tab' => $tab));
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
		$data = array();
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- PCP warning. Processing form data without nonce verification. No nonce.
		if (isset($_GET['event-filter'])) $data['event-filter'] = sanitize_text_field(wp_unslash($_GET['event-filter'])); // Failed logins and logins only to show as audit log
		$audit_log_list = new AIOWPSecurity_List_Audit_Log($data);
		$tab = isset($_REQUEST["tab"]) ? sanitize_text_field(wp_unslash($_REQUEST["tab"])) : '';
		$page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';
		// phpcs:enable WordPress.Security.NonceVerification.Recommended -- PCP warning. Processing form data without nonce verification. No nonce.

		$aio_wp_security->include_template('wp-admin/dashboard/audit-logs.php', false, array('audit_log_list' => $audit_log_list, 'page' => $page, 'tab' => $tab));
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
		global $aio_wp_security;
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

	/**
	 * Function to customize the layout of the WordPress dashboard.
	 * Organizes meta-boxes into different containers based on screen columns.
	 */
	private function wp_dashboard() {
		$screen = get_current_screen();
		$columns = absint($screen->get_columns());
		$columns_css = '';
		if ($columns) {
			$columns_css = " columns-$columns";
		}

		?>
		<div id="dashboard-widgets" class="metabox-holder<?php echo esc_attr($columns_css); ?>">
			<div id="postbox-container-1" class="postbox-container">
			<?php do_meta_boxes($screen->id, 'normal', ''); ?>
			</div>
			<div id="postbox-container-2" class="postbox-container">
			<?php do_meta_boxes($screen->id, 'side', ''); ?>
			</div>
			<div id="postbox-container-3" class="postbox-container">
			<?php do_meta_boxes($screen->id, 'column3', ''); ?>
			</div>
			<div id="postbox-container-4" class="postbox-container">
			<?php do_meta_boxes($screen->id, 'column4', ''); ?>
			</div>
		</div>

		<?php
		wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
		wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
	}

	private function wp_dashboard_setup() {
		global $aio_wp_security, $wp_registered_widgets, $wp_registered_widget_controls, $wp_dashboard_control_callbacks;
		$wp_dashboard_control_callbacks = array();
		get_current_screen();

		// Add widgets
		wp_add_dashboard_widget('security_strength_meter', __('Security strength meter', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_security_strength_meter'));
		wp_add_dashboard_widget('security_points_breakdown', __('Security points breakdown', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_security_points_breakdown'));
		wp_add_dashboard_widget('spread_the_word', __('Spread the word', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_spread_the_word'));
		wp_add_dashboard_widget('know_developers', __('Get to know the developers', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_know_developers'));
		wp_add_dashboard_widget('critical_feature_status', __('Critical feature status', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_critical_feature_status'));
		wp_add_dashboard_widget('last_5_logins', __('Last 5 login summary', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_last_5_logins'));
		wp_add_dashboard_widget('maintenance_mode_status', __('Maintenance mode status', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_maintenance_mode_status'));
		if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention')
			|| '1' == $aio_wp_security->configs->get_value('aiowps_enable_rename_login_page')
		) {
			wp_add_dashboard_widget('brute_force', __('Brute force prevention login page', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_brute_force'));
		}
		wp_add_dashboard_widget('logged_in_users', __('Logged in users', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_logged_in_users'));
		wp_add_dashboard_widget('locked_ip_addresses', __('Locked IP addresses', 'all-in-one-wp-security-and-firewall'), array($this, 'widget_locked_ip_addresses'));

		do_action('aiowps_dashboard_setup');
		$dashboard_widgets = apply_filters('aiowps_dashboard_widgets', array());

		foreach ($dashboard_widgets as $widget_id) {
			$name = empty($wp_registered_widgets[$widget_id]['all_link']) ? $wp_registered_widgets[$widget_id]['name'] : $wp_registered_widgets[$widget_id]['name'] . " <a href='{$wp_registered_widgets[$widget_id]['all_link']}' class='edit-box open-box'>" . __('View all', 'all-in-one-wp-security-and-firewall') . '</a>';
			wp_add_dashboard_widget($widget_id, $name, $wp_registered_widgets[$widget_id]['callback'], $wp_registered_widget_controls[$widget_id]['callback']);
		}
	}

	public function widget_security_strength_meter() {
		global $aiowps_feature_mgr;
		$total_site_security_points = $aiowps_feature_mgr->get_total_site_points();
		$total_security_points_achievable = $aiowps_feature_mgr->get_total_achievable_points();
		?>
		<script type='text/javascript'>
			var total_security_points_achievable = <?php echo (int) $total_security_points_achievable; ?>;
			var section = total_security_points_achievable / 8;

			var config = {
				type: 'gauge',
				data: {
					datasets: [{
						value: <?php echo esc_js($total_site_security_points); ?>,
						minValue: 0,
						data: [section, section * 2, section * 3, section * 4, section * 5, section * 6, total_security_points_achievable],
						backgroundColor: ['#26ddfd', '#26ddfd', '#00b0ea', '#00b0ea', '#2680ca', '#2680ca', '#563c82'],
						borderWidth: 2.5
					}]
				},
				options: {
					cutoutPercentage: 75,
					layout: {
						padding: {
							bottom: 20
						}
					},
					needle: {
						radiusPercentage: 5,
						widthPercentage: 6,
						lengthPercentage: 80,
						color: '#3e3e3e'
					},
					valueLabel: {
						display: false
					}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('chart').getContext('2d');
				window.myGauge = new Chart(ctx, config);
			};
		</script>

		<div id="canvas-holder">
			<canvas id="chart"></canvas>
		</div>

		<h2 id="website-strength-text"><?php echo esc_html__('Website strength:', 'all-in-one-wp-security-and-firewall') . ' ' . '<strong>' . esc_html($total_site_security_points) . '</strong>'; ?></h2>

		<div id='security_strength_chart_div'></div>
		<div class="aiowps_dashboard_widget_footer">
			<?php
			echo esc_html__('Total Achievable Points:', 'all-in-one-wp-security-and-firewall') . ' ' . '<strong>' . esc_html($total_security_points_achievable) . '</strong><br />';
			echo esc_html__('Current Score of Your Site:', 'all-in-one-wp-security-and-firewall') . ' ' . '<strong>' . esc_html($total_site_security_points) . '</strong>';
			?>
		</div>
		<?php
	}

	public function widget_security_points_breakdown() {
		global $aiowps_feature_mgr;
		$feature_mgr = $aiowps_feature_mgr;
		$feature_items = $feature_mgr->feature_items;
		$pt_src_chart_data = "";
		$pt_src_chart_data .= "['Feature Name', 'Points'],";
		foreach ($feature_items as $item) {
			if ($item->is_active()) {
				$pt_src_chart_data .= "['" . esc_html($item->feature_name) . "', " . esc_html($item->item_points) . "],";
			}
		}

		?>
		<?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- PCP error. Direct enqueue necessary. ?>
		<script type='text/javascript' src='https://www.google.com/jsapi'></script>
		<script type="text/javascript">
			google.load("visualization", "1", {packages: ["corechart"]});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					<?php echo $pt_src_chart_data; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JS array data. Variables escaped earlier. ?>
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
		<p><?php echo esc_html__('We are working hard to make your WordPress site more secure.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Please support us, here is how:', 'all-in-one-wp-security-and-firewall');?></p>
		<p><a href="https://x.com/TeamUpdraftWP" target="_blank"><?php esc_html_e('Follow us on', 'all-in-one-wp-security-and-firewall');?> X</a>
		</p>
		<p>
			<a href="https://x.com/intent/tweet?url=https://wordpress.org/plugins/all-in-one-wp-security-and-firewall&text=I love the All In One WP Security and Firewall plugin!"
			target="_blank" class="aio_tweet_link"><?php esc_html_e('Post to X', 'all-in-one-wp-security-and-firewall');?></a>
		</p>
		<p>
			<a href="http://wordpress.org/support/view/plugin-reviews/all-in-one-wp-security-and-firewall/"
			target="_blank" class="aio_rate_us_link"><?php esc_html_e('Give us a good rating', 'all-in-one-wp-security-and-firewall');?></a>
		</p>
		<?php
	}

	public function widget_know_developers() {
		?>
		<p><?php esc_html_e('Wanna know more about the developers behind this plugin?', 'all-in-one-wp-security-and-firewall');?></p>
		<p><a href="https://teamupdraft.com/" target="_blank">Team UpdraftPlus</a></p>
		<?php
	}

	/**
	 * This outputs the critical feature status widget
	 *
	 * @return void
	 */
	public function widget_critical_feature_status() {
		global $aiowps_feature_mgr;

		$critical_features = array(
			'user-accounts-change-admin-user' => array(
				'name' => __('Admin username', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_USER_SECURITY_MENU_SLUG,
			),
			'user-login-login-lockdown' => array(
				'name' => __('Login lockout', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_USER_SECURITY_MENU_SLUG . '&tab=login-lockout',
			),
			'filesystem-file-permissions' => array(
				'name' => __('File permission', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_FILESYSTEM_MENU_SLUG,
				'feature_callback' => 'is_main_site'
			),
			'firewall-basic-rules' => array(
				'name' => __('Basic firewall', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_FIREWALL_MENU_SLUG . '&tab=htaccess-rules',
				'feature_callback' => array('AIOWPSecurity_Utility', 'allow_to_write_to_htaccess')
			),
			'db-security-db-prefix' => array(
				'name' => __('Database prefix', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_DB_SEC_MENU_SLUG,
				'feature_callback' => 'is_main_site'
			),
			'filesystem-file-editing' => array(
				'name' => __('PHP file editing', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_FILESYSTEM_MENU_SLUG . '&tab=file-protection',
				'feature_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin')
			),
			'bf-rename-login-page' => array(
				'name' => __('Renamed login page', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_BRUTE_FORCE_MENU_SLUG,
			),
			'wp-generator-meta-tag' => array(
				'name' => __('Hidden WP meta info', 'all-in-one-wp-security-and-firewall'),
				'url' => AIOWPSEC_SETTINGS_MENU_SLUG . '&tab=wp-version-info',
			),
		);

		$critical_features = apply_filters('aiowps_filter_critical_features_array', $critical_features);
		$critical_features = array_filter($critical_features, array($this, 'should_add_feature'));

		esc_html_e('Below is the current status of the critical features that you should activate on your site to achieve a minimum level of recommended security', 'all-in-one-wp-security-and-firewall');
		echo '<div class="aiowps_features_grid">';
		foreach ($critical_features as $key => $feature) {
			$feature_item = $aiowps_feature_mgr->get_feature_item_by_id($key);

			if (!$feature_item) continue;

			echo '<a href="admin.php?page=' . esc_attr($feature['url']) . '" class="aiowps_critical_feature_link">';
			echo '<div class="aiowps_critical_feature_status_container">';
			echo '<div class="aiowps_critical_feature_status_name">' . esc_html($feature['name']) . '</div>';
			echo '<div class="aiowps_feature_status_circle">';
			if ($feature_item->is_active()) {
				echo '<div class="aiowps_feature_status_circle_on"></div>';
			} else {
				echo '<div class="aiowps_feature_status_circle_off"></div>';
			}
			echo '</div>';
			echo '</div>';
			echo '</a>';
		}
		echo "</div>";
	}

	/**
	 * This outputs the latest logins dashboard widget
	 *
	 * @return void
	 */
	public function widget_last_5_logins() {
		global $wpdb;
		$audit_log_table = AIOWPSEC_TBL_AUDIT_LOG;
		$where_sql = (is_super_admin()) ? '' : ' and site_id = '.get_current_blog_id().' ';
		
		$last_days = 7;
		$days_before_time = strtotime('-'.$last_days.' days', time());

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- PCP warning. Direct query necessary.
		$login_data_lastx_days = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- pcp Warning. Ignore.
			$wpdb->prepare("SELECT id,created FROM $audit_log_table WHERE event_type = %s $where_sql and created > %s", 'successful_login', $days_before_time),
			ARRAY_A
		); // Get the last x days records
		
		if (!empty($login_data_lastx_days)) {
			$chart_data = array();
			$chart_data['columns'] = array(__('Date', 'all-in-one-wp-security-and-firewall'), __('Logins', 'all-in-one-wp-security-and-firewall'));
			$chart_data['data'] = $login_data_lastx_days;
			$chart_data['last_days'] = $last_days;
			$chart_data['id'] = 'logins_last_'.$last_days.'days';
			$this->dashboard_widget_chart($chart_data, 'bar');
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- PCP Error. Ignore.
		$data = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- PCP error. Ignore.
			$wpdb->prepare("SELECT * FROM $audit_log_table WHERE event_type = %s ORDER BY created DESC LIMIT %d", 'successful_login', 5),
			ARRAY_A
		); //Get the last 5 records

		if (null == $data) {
			echo '<p>' . esc_html__('No data found.', 'all-in-one-wp-security-and-firewall') . '</p>';
		} else {
			$login_summary_table_data = array();
			//$login_summary_table_data['title'] = __('Last 5 login summary:', 'all-in-one-wp-security-and-firewall');
			$login_summary_table_data['columns'] = array(__('User', 'all-in-one-wp-security-and-firewall'), __('Date', 'all-in-one-wp-security-and-firewall'), 'IP');
			foreach ($data as $entry) {
				$login_summary_table_data['data'][] = array($entry['username'], gmdate('Y-m-d H:i:s', $entry['created']), $entry['ip']);
			}
			$login_summary_table_data = apply_filters('aios_last5_logins_summary', $login_summary_table_data, $data);
			$this->dashboard_widget($login_summary_table_data);
			
			// View all login logs
			echo '<p><a class="button" href="' . esc_url('admin.php?page=' . AIOWPSEC_MAIN_MENU_SLUG . '&tab=audit-logs&event-filter=successful_login') . '">' . esc_html__('View all', 'all-in-one-wp-security-and-firewall') . '</a></p>';
		}

		echo '<div class="aio_clear_float"></div>';
	}

	public function widget_maintenance_mode_status() {
		global $aio_wp_security;
		?>
		<p id="aiowpsec-dashboard-maintenance-mode-status-message">
			<?php
			if ('1' == $aio_wp_security->configs->get_value('aiowps_site_lockout')) {
				echo esc_html__('Maintenance mode is currently enabled.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Remember to disable it when you are done.', 'all-in-one-wp-security-and-firewall');
			} else {
				echo esc_html__('Maintenance mode is currently disabled.', 'all-in-one-wp-security-and-firewall');
			}
			?>
		</p>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php esc_html_e('Enable maintenance mode', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div id="aiowpsec-dashboard-maintenance-mode-switch-container" class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox('', 'aiowps_site_lockout', '1' == $aio_wp_security->configs->get_value('aiowps_site_lockout')); ?>
					</div>
				</td>
			</tr>
		</table>
		<?php
		echo '<a href="admin.php?page=' . esc_attr(AIOWPSEC_TOOLS_MENU_SLUG) . '&tab=visitor-lockout">' . esc_html__('Configure', 'all-in-one-wp-security-and-firewall') . '</a>';
	}

	public function widget_brute_force() {
		global $aio_wp_security;
		if ($aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention') == '1') {
			$brute_force_login_feature_link = '<a href="admin.php?page=' . esc_attr(AIOWPSEC_BRUTE_FORCE_MENU_SLUG) . '&tab=cookie-based-brute-force-prevention" target="_blank">' . __('Cookie-based brute force', 'all-in-one-wp-security-and-firewall') . '</a>';
			$brute_force_feature_secret_word = $aio_wp_security->configs->get_value('aiowps_brute_force_secret_word');
			echo '<div class="aio_yellow_box">';
			/* translators: %s: Brute Force Login URL  */
			echo '<p>' . sprintf(esc_html__('The %s feature is currently active.', 'all-in-one-wp-security-and-firewall'), $brute_force_login_feature_link) . '</p>'; // phpcs:ignore 	WordPress.Security.EscapeOutput.OutputNotEscaped -- Output escaped above.
			echo '<p>' . esc_html__('Your new WordPress login URL is now:', 'all-in-one-wp-security-and-firewall') . '</p>';
			echo '<p><strong>' . esc_url(AIOWPSEC_WP_URL) . '/?' . esc_html($brute_force_feature_secret_word) . '=1</strong></p>';
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

			$rename_login_feature_link = '<a href="admin.php?page=' . esc_attr(AIOWPSEC_BRUTE_FORCE_MENU_SLUG) . '&tab=rename-login" target="_blank">' . esc_html__('Rename login page', 'all-in-one-wp-security-and-firewall') . '</a>';
			echo '<div class="aio_yellow_box">';
			/* translators: %s: Rename Login URL  */
			echo '<p>' . sprintf(esc_html__('The %s feature is currently active.', 'all-in-one-wp-security-and-firewall'), $rename_login_feature_link) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output escaped above.
			echo '<p>' . esc_html__('Your new WordPress login URL is now:', 'all-in-one-wp-security-and-firewall') . '</p>';
			echo '<p><strong>' . esc_url($home_url) . esc_html($aio_wp_security->configs->get_value('aiowps_login_page_slug')) . '</strong></p>';
			echo '</div>'; //yellow box div
			echo '<div class="aio_clear_float"></div>';
		} // End if statement for Rename Login box
	}

	/**
	 * This outputs the logged in users dashboard widget
	 *
	 * @return void
	 */
	public function widget_logged_in_users() {
		$users_online_link = '<a href="admin.php?page=' . AIOWPSEC_USER_SECURITY_MENU_SLUG . '&tab=logged-in-users">'.esc_html__('Logged in users', 'all-in-one-wp-security-and-firewall').'</a>';
		// default display messages
		$multiple_users_info_msg = esc_html__('Number of users currently logged into your site (including you) is:', 'all-in-one-wp-security-and-firewall');
		$single_user_info_msg = esc_html__('There are no other users currently logged in.', 'all-in-one-wp-security-and-firewall');

		if (is_multisite()) {
			$current_blog_id = get_current_blog_id();
			$is_main = is_main_site($current_blog_id);

			if (empty($is_main)) {
				// Subsite - only get logged in users for this blog_id
				$logged_in_users = AIOWPSecurity_User_Login::get_logged_in_users(false);
			} else {
				// Main site - get sitewide users
				$logged_in_users = AIOWPSecurity_User_Login::get_logged_in_users();

				// If viewing AIOS from multisite main network dashboard, then display a different message
				$multiple_users_info_msg = __('Number of users currently logged in site-wide (including you) is:', 'all-in-one-wp-security-and-firewall');
				$single_user_info_msg = __('There are no other site-wide users currently logged in.', 'all-in-one-wp-security-and-firewall');
			}
		} else {
			$logged_in_users = AIOWPSecurity_User_Login::get_logged_in_users();
		}

		if (empty($logged_in_users)) {
			$num_users = 0;
		} else {
			$num_users = count($logged_in_users);
		}
		if ($num_users > 1) {
			echo '<div class="aio_red_box"><p>' . esc_html($multiple_users_info_msg) . ' <strong>' . esc_html($num_users) . '</strong></p>';
			/* translators: %s: Users Online URL  */
			$info_msg = '<p>' . sprintf(esc_html__('Go to the %s menu to see more details', 'all-in-one-wp-security-and-firewall'), $users_online_link) . '</p>';
			echo $info_msg . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output escaped above.
		} else {
			echo '<div class="aio_green_box"><p>' . esc_html($single_user_info_msg) . '</p></div>';
		}
	}

	public function widget_locked_ip_addresses() {
		$locked_ips_link = '<a href="admin.php?page=' . esc_attr(AIOWPSEC_MAIN_MENU_SLUG) . '&tab=locked-ip">'. esc_html__('Locked IP addresses', 'all-in-one-wp-security-and-firewall').'</a>';

		$locked_ips = AIOWPSecurity_Utility::get_locked_ips();
		if (false === $locked_ips) {
			echo '<div class="aio_green_box"><p>' . esc_html__('There are no IP addresses currently locked out.', 'all-in-one-wp-security-and-firewall') . '</p></div>';
		} else {
			$num_ips = count($locked_ips);
			echo '<div class="aio_red_box"><p>' . esc_html__('Number of temporarily locked out IP addresses:', 'all-in-one-wp-security-and-firewall') . ' ' . ' <strong>' . esc_html($num_ips) . '</strong></p>';
			/* translators: %s: Number of locked out IPs */
			$info_msg = '<p>' . sprintf(esc_html__('Go to the %s menu to see more details', 'all-in-one-wp-security-and-firewall'), $locked_ips_link) . '</p>';
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output escaped above.
			echo $info_msg . '</div>';
		}
	}

	/**
	 * Determines whether a security feature should be activated based on its callback.
	 *
	 * This method checks if a feature should be added by evaluating its callback function.
	 * If no callback is set, the feature is added by default. If a callback is set,
	 * it must be callable and return a boolean value.
	 *
	 * @param array $feature An array containing feature details with the following keys:
	 *                       'name'             => (string) Name of the feature
	 *                       'feature_callback' => (callable|null) Optional callback to determine if feature should be added
	 *
	 * @return bool True if the feature should be added, false otherwise
	 */
	public static function should_add_feature($feature) {
		if (empty($feature['feature_callback'])) {
			return true;
		} elseif (is_callable($feature['feature_callback'])) {
			return call_user_func($feature['feature_callback']);
		} else {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Part of internal error reporting system.
			error_log("Callback function set but not callable (coding error). Feature: " . $feature['name']);
			return false;
		}
	}
	
	/**
	 * This function creates summary for dashboard widget in table format
	 *
	 * @param array $widget_data title, column names and row data
	 *
	 * @return void
	 */
	private function dashboard_widget($widget_data) {
		global $aio_wp_security;
		$aio_wp_security->include_template('wp-admin/dashboard/widget-summary.php', false, array('widget_data' => $widget_data));
	}
	
	/**
	 * This function creates chart for dashboard widget
	 *
	 * @param array  $chart_data column names, chart data, last_days and id
	 * @param string $type       bar chart
	 *
	 * @return void
	 */
	private function dashboard_widget_chart($chart_data, $type = 'bar') {
		global $aio_wp_security;
		$aio_wp_security->include_template('wp-admin/dashboard/widget-'.$type.'-chart.php', false, array('chart_data' => $chart_data));
	}
}
