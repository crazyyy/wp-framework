<?php

if (!defined('WPO_PLUGIN_MAIN_PATH')) die('No direct access allowed');

/**
 * All commands that are intended to be available for calling from any sort of control interface (e.g. wp-admin, UpdraftCentral) go in here. All public methods should either return the data to be returned, or a WP_Error with associated error code, message and error data.
 */
class WP_Optimize_Commands {

	private $optimizer;

	protected $options;

	private $wpo_sites; // used in get_optimizations_info command.

	public function __construct() {
		$this->optimizer = WP_Optimize()->get_optimizer();
		$this->options = WP_Optimize()->get_options();
	}

	public function get_version() {
		return WPO_VERSION;
	}

	public function enable_or_disable_feature($data) {
	
		$type = (string) $data['type'];
		$enable = (boolean) $data['enable'];
	
		$options = array($type => $enable);

		return $this->optimizer->trackback_comment_actions($options);
	}
	
	public function save_manual_run_optimization_options($sent_options) {
		return $this->options->save_sent_manual_run_optimization_options($sent_options);
	}

	public function get_status_box_contents() {
		return WP_Optimize()->include_template('database/status-box-contents.php', true, array('optimize_db' => false));
	}

	/**
	 * Get the database tabs information.
	 *
	 * @return string auto cleanup content.
	 */
	public function get_settings_auto_cleanup_contents() {
		return WP_Optimize()->include_template('database/settings-auto-cleanup.php', true, array('optimize_db' => false, 'show_innodb_option' => WP_Optimize()->template_should_include_data() && $this->optimizer->show_innodb_force_optimize()));
	}

	/**
	 * Get the settings tab information.
	 *
	 * @return string logging settings content.
	 */
	public function get_logging_settings_contents() {
		return WP_Optimize()->include_template('settings/settings-logging.php', true, array('optimize_db' => false));
	}
	
	/**
	 * Get the database tabs information
	 *
	 * @return string database table optimization rendered content
	 */
	public function get_optimizations_table() {
		return WP_Optimize()->include_template('database/optimizations-table.php', true, array('does_server_allows_table_optimization' => WP_Optimize()->does_server_allows_table_optimization()));
	}

	/**
	 * [For UpdraftCentral] Returns the file content containing the list of unused images
	 *
	 * @return array|void
	 */
	public function download_csv() {
		if (!current_user_can(WP_Optimize()->capability_required())) {
			return $this->request_error('insufficient_privilege');
		}
	
		WP_Optimize()->get_optimizer()->get_optimization('images')->output_csv();
	}

	/**
	 * [For UpdraftCentral] Retrieves the tabs and their corresponding contents, assets basing
	 * from the current page or section requested (e.g. database, images, cache, minify or settings)
	 *
	 * @param array $params Parameters needed for the requested action
	 * @return array
	 */
	public function get_section($params) {
		if (!current_user_can(WP_Optimize()->capability_required())) {
			return $this->request_error('insufficient_privilege');
		}

		$section_id = $params['section'];
		$section = $this->get_section_to_tab_name($section_id);
		$tabs = WP_Optimize()->get_admin_instance()->get_tabs($section);

		// We remove the UpdraftCentral management tab when managing WP-Optimize
		// plugin from the UpdraftCentral dashboard if it exists.
		if (isset($tabs['updraftcentral'])) unset($tabs['updraftcentral']);

		$this->load_action_hooks_for_content($section_id);
		return array(
			'tabs' => $tabs,
			'tabs_content' => $this->get_tab_contents($tabs, $section),
			'assets' => $this->get_localized_variables(),
			'wposmush' => $this->get_wposmush(),
			'is_premium' => WP_Optimize::is_premium(),
			'modal_template' => WP_Optimize()->include_template('modal.php', true),
		);
	}

	/**
	 * [For UpdraftCentral] Retrieves the list of items to optimize from the current database
	 *
	 * @return array
	 */
	public function get_database_tabs_info() {
		if (!current_user_can(WP_Optimize()->capability_required())) {
			return $this->request_error('insufficient_privilege');
		}

		return $this->get_database_tabs();
	}

	/**
	 * [For UpdraftCentral] Processes specific Smush commands from ajax requests
	 *
	 * @param array $params Parameters needed for the requested action
	 * @return array
	 */
	public function updraft_smush_ajax($params) {
		if (!current_user_can(WP_Optimize()->capability_required())) {
			return $this->request_error('insufficient_privilege');
		}

		$subaction = $params['subaction'];
		$data = $params['data'];

		$allowed_commands = Updraft_Smush_Manager_Commands::get_allowed_ajax_commands();
		if (in_array($subaction, $allowed_commands)) {
			if (in_array($subaction, array('get_smush_logs', 'process_bulk_smush'))) {
				switch ($subaction) {
					case 'get_smush_logs':
						$results = $this->get_smush_logs();
						break;
					case 'process_bulk_smush':
						$results = $this->process_bulk_smush($data);
						break;
					default:
						break;
				}
			} else {
				if (!empty($data)) {
					$results = call_user_func(array(Updraft_Smush_Manager()->commands, $subaction), $data);
				} else {
					$results = call_user_func(array(Updraft_Smush_Manager()->commands, $subaction));
				}
			}
			
			if (is_wp_error($results)) {
				return $this->request_error($results->get_error_code(), null, array(
					'status' => true,
					'error_message' => $results->get_error_message(),
					'error_data' => $results->get_error_data(),
				));
			} else {
				return $results;
			}
		} else {
			return $this->request_error('command_not_found');
		}
	}

	/**
	 * [For UpdraftCentral] Processes general WP-Optimize commands from ajax requests
	 *
	 * @param array $params Parameters needed for the requested action
	 * @return array
	 */
	public function handle_ajax_requests($params) {
		if (!current_user_can(WP_Optimize()->capability_required())) {
			return $this->request_error('insufficient_privilege');
		}

		$subaction = $params['subaction'];
		$data = $params['data'];

		$response = array();
		if (is_multisite() && !current_user_can('manage_network_options')) {
			$allowed_multisite_commands = apply_filters('wpo_multisite_allowed_commands', array('check_server_status', 'compress_single_image', 'restore_single_image'));

			if (!in_array($subaction, $allowed_multisite_commands)) {
				return $this->request_error('network_admin_only');
			}
		}

		$dismiss_actions = array(
			'dismiss_dash_notice_until',
			'dismiss_season',
			'dismiss_page_notice_until',
			'dismiss_notice',
			'dismiss_review_notice',
		);

		if (in_array($subaction, $dismiss_actions)) {
			$options = WP_Optimize()->get_options();

			// Some commands that are available via AJAX only.
			if (in_array($subaction, array('dismiss_dash_notice_until', 'dismiss_season'))) {
				$options->update_option($subaction, (time() + 366 * 86400));
			} elseif (in_array($subaction, array('dismiss_page_notice_until', 'dismiss_notice'))) {
				$options->update_option($subaction, (time() + 84 * 86400));
			} elseif ('dismiss_review_notice' == $subaction) {
				if (empty($data['dismiss_forever'])) {
					$options->update_option($subaction, time() + 84 * 86400);
				} else {
					$options->update_option($subaction, 100 * (365.25 * 86400));
				}
			}

		} else {
			$commands = new WP_Optimize_Commands();

			$minify_commands = new WP_Optimize_Minify_Commands();
			if (!is_callable(array($commands, $subaction)) && is_callable(array($minify_commands, $subaction))) {
				$commands = $minify_commands;
			}

			if (WP_Optimize::is_premium()) {
				$cache_commands = new WP_Optimize_Cache_Commands_Premium();
			} else {
				$cache_commands = new WP_Optimize_Cache_Commands();
			}

			if (!is_callable(array($commands, $subaction)) && is_callable(array($cache_commands, $subaction))) {
				$commands = $cache_commands;
			}

			// Check if command is valid
			if (!is_callable(array($commands, $subaction))) {
				return $this->request_error('command_not_found');
			} else {
				$response = call_user_func(array($commands, $subaction), $data);
				if (is_wp_error($response)) {
					return $this->request_error($response->get_error_code(), null, array(
						'error_message' => $response->get_error_message(),
						'error_data' => $response->get_error_data(),
					));
				} elseif (empty($response)) {
					$response = array(
						'result' => null
					);
				} else {
					if (isset($response['status_box_contents'])) {
						$response['status_box_contents'] = str_replace(array("\n", "\t"), '', $response['status_box_contents']);
					}
				}
			}
		}

		return $response;
	}

	/**
	 * [For UpdraftCentral] Retrieves a list of posts to purge as options to be displayed under
	 * cache - advanced settings
	 *
	 * @param array $params Parameters needed for the requested action
	 * @return array
	 */
	public function get_posts_list($params) {
		if (!current_user_can(WP_Optimize()->capability_required())) {
			return $this->request_error('insufficient_privilege');
		}

		$response = array();
		if (WP_Optimize::is_premium()) {
			$commands = new WP_Optimize_Cache_Commands_Premium();
			if (is_callable(array($commands, 'get_posts_list'))) {
				$response = $commands->get_posts_list($params);
			}
		}

		return $response;
	}

	/**
	 * [For UpdraftCentral] loads the settings page
	 *
	 * @return void
	 */
	public function output_dashboard_settings_tab() {
		$wpo_admin = WP_Optimize()->get_admin_instance();

		if (WP_Optimize()->can_manage_options()) {
			WP_Optimize()->include_template('settings/settings.php');
		} else {
			$wpo_admin->prevent_manage_options_info();
		}
	}

	/**
	 * [For UpdraftCentral] Retrieves Smush JS variables
	 *
	 * @return array
	 */
	private function get_wposmush() {
		if (!class_exists('Updraft_Smush_Manager')) return array();

		$js_variables = Updraft_Smush_Manager()->smush_js_translations();
		$js_variables['ajaxurl'] = admin_url('admin-ajax.php');
		$js_variables['features'] = Updraft_Smush_Manager()->get_features();

		return $js_variables;
	}

	/**
	 * [For UpdraftCentral] Execute smush process in bulk
	 *
	 * @param array $data Parameters to be pass as argument for the requested action
	 * @return string
	 */
	private function process_bulk_smush($data) {
		ob_start();
		Updraft_Smush_Manager()->commands->process_bulk_smush($data);
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * [For UpdraftCentral] Retrieves the content of a Smush log file
	 *
	 * @return string|WP_Error
	 */
	private function get_smush_logs() {
		$logfile = Updraft_Smush_Manager()->get_logfile_path();
		if (!file_exists($logfile)) {
			 Updraft_Smush_Manager()->write_log_header();
		}

		if (is_file($logfile)) {
			return file_get_contents($logfile);
		} else {
			return $this->request_error('log_file_not_exist');
		}
	}

	/**
	 * [For UpdraftCentral] Loads the WP-Optimize hooks needed to pull the tab contents for
	 * the requested page/section
	 *
	 * @param array $section_id The id of the page or section where the content is to be pulled from
	 * @return void
	 */
	private function load_action_hooks_for_content($section_id) {
		$wpo = WP_Optimize();
		$wpo_admin = $wpo->get_admin_instance();

		// Database
		if ('database' == $section_id) {
			add_action('wp_optimize_admin_page_WP-Optimize_optimize', array($wpo_admin, 'output_database_optimize_tab'), 20);
			add_action('wp_optimize_admin_page_WP-Optimize_tables', array($wpo_admin, 'output_database_tables_tab'), 20);
			add_action('wp_optimize_admin_page_WP-Optimize_settings', array($wpo_admin, 'output_database_settings_tab'), 20);
		}

		// Images
		if ('images' == $section_id) {
			add_action('wp_optimize_admin_page_wpo_images_smush', array($wpo, 'admin_page_wpo_images_smush'));

			if (!WP_Optimize::is_premium()) {
				add_action('wp_optimize_admin_page_wpo_images_unused', array($wpo_admin, 'admin_page_wpo_images_unused'));
				add_action('wp_optimize_admin_page_wpo_images_lazyload', array($wpo_admin, 'admin_page_wpo_images_lazyload'));
			}
		}

		// Cache
		if ('cache' == $section_id) {
			add_action('wp_optimize_admin_page_wpo_cache_cache', array($wpo_admin, 'output_page_cache_tab'), 20);
			add_action('wp_optimize_admin_page_wpo_cache_preload', array($wpo_admin, 'output_page_cache_preload_tab'), 20);
			add_action('wp_optimize_admin_page_wpo_cache_advanced', array($wpo_admin, 'output_page_cache_advanced_tab'), 20);
			add_action('wp_optimize_admin_page_wpo_cache_gzip', array($wpo_admin, 'output_cache_gzip_tab'), 20);
			add_action('wp_optimize_admin_page_wpo_cache_settings', array($wpo_admin, 'output_cache_settings_tab'), 20);
		}

		// Minify
		if ('minify' == $section_id) {
			if (class_exists('WP_Optimize_Minify_Admin')) {
				do_action('wp_optimize_register_admin_content');
			}
		}

		// Settings
		if ('settings' == $section_id) {
			add_action('wp_optimize_admin_page_wpo_settings_settings', array($this, 'output_dashboard_settings_tab'), 20);
		}
	}

	/**
	 * [For UpdraftCentral] Execute the hooks needed to pull the content of the tabs under the requested page/section
	 *
	 * @param array $tabs       The list of tabs available under the current page/section
	 * @param array $section_id The id of the page or section
	 * @return string
	 */
	private function get_tab_contents($tabs, $section_id) {
		$contents = array();

		foreach ($tabs as $tab_id => $tab_description) {
			ob_start();
			// output wrap div for tab with id #wp-optimize-nav-tab-contents-'.$section.'-'.$tab_id
			echo '<div class="wp-optimize-nav-tab-contents" id="wp-optimize-nav-tab-'.esc_attr($section_id).'-'.esc_attr($tab_id).'-contents">';
			
			echo '<div class="postbox wpo-tab-postbox">';

			// call action for generate tab content.
			do_action('wp_optimize_admin_page_'.$section_id.'_'.$tab_id);
			
			// closes postbox.
			echo '</div><!-- END .postbox -->';
			// closes tab wrapper.
			echo '</div><!-- END .wp-optimize-nav-tab-contents -->';
			$tab_content = ob_get_contents();
			ob_end_clean();

			$contents[$tab_id] = $tab_content;
		}

		return $contents;
	}

	/**
	 * [For UpdraftCentral] Replaces the names/id used in UpdraftCentral with the actual name used in WP-Optimize
	 *
	 * @param array $section_id The id of the page or section
	 * @return string
	 */
	private function get_section_to_tab_name($section_id) {
		$tab = '';
		switch ($section_id) {
			case 'database':
				$tab = 'WP-Optimize';
				break;
			default:
				$tab = 'wpo_'.$section_id;
				break;
		}
		return $tab;
	}

	/**
	 * [For UpdraftCentral] Retrieves the localized scripts/variables (e.g. translations, etc.) used by WP-Optimize
	 *
	 * @return array
	 */
	private function get_localized_variables() {
		$wpo = WP_Optimize();
		$js_variables = $wpo->wpo_js_translations();
		$js_variables['loggers_classes_info'] = $wpo->get_loggers_classes_info();
		$js_variables['ajaxurl'] = admin_url('admin-ajax.php');

		$localized_variables = array(
			'wpoptimize' => $js_variables,
			'wp_optimize_send_command_data' => array('nonce' => wp_create_nonce('wp-optimize-ajax-nonce')),
			'wpo_heartbeat_ajax' => array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('heartbeat-nonce'),
				'interval' => WPO_Ajax::HEARTBEAT_INTERVAL
			),
		);

		if (WP_Optimize::is_premium()) {
			$localized_variables = array_merge($localized_variables, array(
				'wp_optimize_minify_premium' => array(
					'home_url' => home_url()
				)
			));
		}

		return array(
			'localize' => $localized_variables,
		);
	}

	/**
	 * [For UpdraftCentral] Returns a WP_Error response for the current request
	 *
	 * @param string $code            The error code
	 * @param string $message_key     The key to use to query any translatable message if applicable
	 * @param array  $additional_data Any additional data to return
	 * @return WP_Error
	 */
	private function request_error($code, $message_key = null, $additional_data = array()) {
		global $updraftcentral_host_plugin;

		$error_message = $updraftcentral_host_plugin->retrieve_show_message($code);
		if (!is_null($message_key) && $code !== $message_key) {
			$error_message = $updraftcentral_host_plugin->retrieve_show_message($message_key);
		}

		$data = array(
			'result' => false,
			'error_code' => $code,
			'error_message' => $error_message,
			'error' => true,
			'code' => $code,
			'message' => $error_message,
		);

		if (!empty($additional_data)) {
			$data = array_merge($data, $additional_data);
		}

		return new WP_Error($code, $error_message, $data);
	}

	/**
	 * Pulls and return the "WP Optimize" template contents. Primarily used for UpdraftCentral
	 * content display through ajax request.
	 *
	 * @return array An array containing the WPO translations and the "WP Optimize" tab's rendered contents
	 */
	public function get_wp_optimize_contents() {
		$content = WP_Optimize()->include_template('database/optimize-table.php', true, array('optimize_db' => false, 'load_data' => WP_Optimize()->template_should_include_data(), 'does_server_allows_table_optimization' => WP_Optimize()->does_server_allows_table_optimization()));
		if (WP_Optimize()->is_updraft_central_request()) {
			$content .= $this->get_status_box_contents();
		}

		return array(
			'content' => $content,
			'translations' => $this->get_js_translation()
		);
	}

	/**
	 * Pulls and return the "Table Information" template contents. Primarily used for UpdraftCentral
	 * content display through ajax request.
	 *
	 * @return array An array containing the WPO translations and the "Table Information" tab's rendered contents
	 */
	public function get_table_information_contents() {
		$content = WP_Optimize()->include_template('database/tables.php', true, array('optimize_db' => false, 'load_data' => WP_Optimize()->template_should_include_data()));

		return array(
			'content' => $content,
			'translations' => $this->get_js_translation()
		);
	}

	/**
	 * Pulls and return the "Settings" template contents. Primarily used for UpdraftCentral
	 * content display through ajax request.
	 *
	 * @return array An array containing the WPO translations and the "Settings" tab's rendered contents
	 */
	public function get_settings_contents() {
		$admin_settings = '<form action="#" method="post" enctype="multipart/form-data" name="settings_form" id="settings_form">';
		$admin_settings .= WP_Optimize()->include_template('database/settings-general.php', true, array('optimize_db' => false));
		$admin_settings .= WP_Optimize()->include_template('database/settings-auto-cleanup.php', true, array('optimize_db' => false, 'show_innodb_option' => WP_Optimize()->template_should_include_data() && $this->optimizer->show_innodb_force_optimize()));
		$admin_settings .= WP_Optimize()->include_template('settings/settings-logging.php', true, array('optimize_db' => false));
		$admin_settings .= '<input id="wp-optimize-settings-save" class="button button-primary" type="submit" name="wp-optimize-settings" value="' . esc_attr__('Save settings', 'wp-optimize') .'" />';
		$admin_settings .= '</form>';
		$admin_settings .= WP_Optimize()->include_template('settings/settings-trackback-and-comments.php', true, array('optimize_db' => false));
		$content = $admin_settings;

		return array(
			'content' => $content,
			'translations' => $this->get_js_translation()
		);
	}

	/**
	 * Returns array of translations used by the WPO plugin. Primarily used for UpdraftCentral
	 * consumption.
	 *
	 * @return array The WPO translations
	 */
	public function get_js_translation() {
		$translations = WP_Optimize()->wpo_js_translations();

		// Make sure that we include the loggers classes info whenever applicable before
		// returning the translations to UpdraftCentral.
		if (is_callable(array(WP_Optimize(), 'get_loggers_classes_info'))) {
			$translations['loggers_classes_info'] = WP_Optimize()->get_loggers_classes_info();
		}

		return $translations;
	}

	/**
	 * Save settings command.
	 *
	 * @param string $data
	 * @return array
	 */
	public function save_settings($data) {
		
		parse_str(stripslashes($data), $posted_settings);

		$saved_settings = $this->options->save_settings($posted_settings);
		// We now have $posted_settings as an array.
		return array(
			'save_results' => $saved_settings,
			'status_box_contents' => $this->get_status_box_contents(),
			'optimizations_table' => $this->get_optimizations_table(),
			'settings_auto_cleanup_contents' => $this->get_settings_auto_cleanup_contents(),
			'logging_settings_contents' => $this->get_logging_settings_contents(),
		);
	}

	/**
	 * Wipe settings command.
	 *
	 * @return bool|false|int
	 */
	public function wipe_settings() {
		return $this->options->wipe_settings();
	}

	/**
	 * Save lazy load settings.
	 *
	 * @param string $data
	 * @return array
	 */
	public function save_lazy_load_settings($data) {
		parse_str(stripslashes($data), $posted_settings);

		return array(
			'save_result' => $this->options->save_lazy_load_settings($posted_settings)
		);
	}

	/**
	 * This sends the selected tick value over to the save function
	 * within class-wp-optimize-options.php
	 *
	 * @param  array $data An array of data that includes true or false for click option.
	 * @return array
	 */
	public function save_auto_backup_option($data) {
		return array('save_auto_backup_option' => $this->options->save_auto_backup_option($data));
	}

	/**
	 * Save option which sites to optimize in multisite mode.
	 *
	 * @param array $data Array of settings.
	 * @return bool
	 */
	public function save_site_settings($data) {
		return $this->options->save_wpo_sites_option($data['wpo-sites']);
	}

	/**
	 * Perform the requested optimization
	 *
	 * @param  array $params Should have keys 'optimization_id' and 'data'.
	 * @return array
	 */
	public function do_optimization($params) {
		
		if (!isset($params['optimization_id'])) {
			$results = array(
				'result' => false,
				'messages' => array(),
				'errors' => array(
					__('No optimization was indicated.', 'wp-optimize')
				)
			);
		} else {
			$optimization_id = $params['optimization_id'];
			$data = isset($params['data']) ? $params['data'] : array();
			$include_ui_elements = isset($data['include_ui_elements']) ? $data['include_ui_elements'] : false;
			
			$optimization = $this->optimizer->get_optimization($optimization_id, $data);
	
			$result = is_a($optimization, 'WP_Optimization') ? $optimization->do_optimization() : null;

			$results = array(
				'result' => $result,
				'messages' => array(),
				'errors' => array(),
			);

			if ($include_ui_elements) {
				$results['status_box_contents'] = $this->get_status_box_contents();
			}
			
			if (is_wp_error($optimization)) {
				$results['errors'][] = $optimization->get_error_message().' ('.$optimization->get_error_code().')';
			}
			
			if ($include_ui_elements && $optimization->get_changes_table_data()) {
				$table_list = $this->get_table_list();
				$results['table_list'] = $table_list['table_list'];
				$results['total_size'] = $table_list['total_size'];
			}
		}
		return $results;
	}

	/**
	 * Preview command, used to show information about data should be optimized in popup tool.
	 *
	 * @param array $params Should have keys 'optimization_id', 'offset' and 'limit'.
	 *
	 * @return array
	 */
	public function preview($params) {
		if (!isset($params['optimization_id'])) {
			$results = array(
				'result' => false,
				'messages' => array(),
				'errors' => array(
					__('No optimization was indicated.', 'wp-optimize')
				)
			);
		} else {
			$optimization_id = $params['optimization_id'];
			$data = isset($params['data']) ? $params['data'] : array();
			$params['offset'] = isset($params['offset']) ? (int) $params['offset'] : 0;
			$params['limit'] = isset($params['limit']) ? (int) $params['limit'] : 50;

			$optimization = $this->optimizer->get_optimization($optimization_id, $data);

			if (is_a($optimization, 'WP_Optimization')) {
				if (isset($params['site_id'])) {
					$optimization->switch_to_blog((int) $params['site_id']);
				}
				$result = $optimization->preview($params);
			} else {
				$result = null;
			}

			$results = array(
				'result' => $result,
				'messages' => array(),
				'errors' => array()
			);
		}

		return $results;
	}

	/**
	 * Get information about requested optimization.
	 *
	 * @param array $params Should have keys 'optimization_id' and 'data'.
	 * @return array
	 */
	public function get_optimization_info($params) {
		if (!isset($params['optimization_id'])) {
			$results = array(
				'result' => false,
				'messages' => array(),
				'errors' => array(
					__('No optimization was indicated.', 'wp-optimize')
				)
			);
		} else {
			$optimization_id = $params['optimization_id'];
			$data = isset($params['data']) ? $params['data'] : array();
			$include_ui_elements = isset($data['include_ui_elements']) ? $data['include_ui_elements'] : false;

			$optimization = $this->optimizer->get_optimization($optimization_id, $data);
			$result = is_a($optimization, 'WP_Optimization') ? $optimization->get_optimization_info() : null;

			$results = array(
				'result' => $result,
				'messages' => array(),
				'errors' => array(),
			);

			if ($include_ui_elements) {
				$results['status_box_contents'] = $this->get_status_box_contents();
			}
		}

		return $results;
	}

	/**
	 * Get the data for the tables tab
	 *
	 * @param array $data
	 * @return array
	 */
	public function get_table_list($data = array()) {
		if (isset($data['refresh_plugin_json']) && filter_var($data['refresh_plugin_json'], FILTER_VALIDATE_BOOLEAN)) WP_Optimize()->get_db_info()->update_plugin_json();

		$size = $this->optimizer->get_current_db_size();
	
		return apply_filters('wpo_get_tables_data', array(
			'table_list' => WP_Optimize()->include_template('database/tables-body.php', true, array('optimize_db' => false)),
			'total_size' => $size[0]
		));
	}

	/**
	 * Get the database tabs information
	 *
	 * @return array
	 */
	public function get_database_tabs() {
		return array_merge(array('optimizations' => $this->get_optimizations_table(), 'does_server_allows_table_optimization' => WP_Optimize()->does_server_allows_table_optimization()), $this->get_table_list());
	}

	/**
	 * Do action wp_optimize_after_optimizations
	 * used in ajax request after all optimizations completed
	 *
	 * @return boolean
	 */
	public function optimizations_done() {

		$this->options->update_option('total-cleaned', 0);
		// Run action after all optimizations completed.
		do_action('wp_optimize_after_optimizations');

		return true;
	}

	/**
	 * Return information about all optimizations.
	 *
	 * @param  array $params
	 * @return array
	 */
	public function get_optimizations_info($params) {
		$this->wpo_sites = isset($params['wpo-sites']) ? $params['wpo-sites'] : 0;

		add_filter('get_optimization_blogs', array($this, 'get_optimization_blogs_filter'));

		$results = array();
		$optimizations = $this->optimizer->get_optimizations();

		foreach ($optimizations as $optimization_id => $optimization) {
			if (false === $optimization->display_in_optimizations_list()) continue;

			$results[$optimization_id] = $optimization->get_settings_html();
		}

		return $results;
	}

	/**
	 * Filter for get_optimizations_blogs function, used in get_optimizations_info command.
	 * Not intended for direct usage as a command (is used internally as a WP filter)
	 *
	 * The class variable $wpo_sites is used for performing the filtering.
	 *
	 * @param array $sites - unfiltered list of sites
	 * @return array - after filtering
	 */
	public function get_optimization_blogs_filter($sites) {
		$sites = array();

		if (!empty($this->wpo_sites)) {
			foreach ($this->wpo_sites as $site) {
				if ('all' !== $site) $sites[] = $site;
			}
		}

		return $sites;
	}

	/**
	 * Checks overdue crons and return message
	 */
	public function check_overdue_crons() {
		$overdue_crons = WP_Optimize()->howmany_overdue_crons();

		if ($overdue_crons >= 4) {
			return array('m' => WP_Optimize()->show_admin_warning_overdue_crons($overdue_crons));
		}
	}

	/**
	 * Enable or disable Gzip compression.
	 *
	 * @param array $params - ['enable' => true|false]
	 * @return array
	 */
	public function enable_gzip_compression($params) {
		return WP_Optimize()->get_gzip_compression()->enable_gzip_command_handler($params);
	}

	/**
	 * Get the current gzip compression status
	 *
	 * @return array
	 */
	public function get_gzip_compression_status() {
		$status = WP_Optimize()->get_gzip_compression()->is_gzip_compression_enabled(true);
		return is_wp_error($status) ? array('error' => __('We could not determine if Gzip compression is enabled.', 'wp-optimize'), 'code' => $status->get_error_code(), 'message' => $status->get_error_message()) : array('status' => $status);
	}

	/**
	 * Import WP-Optimize settings.
	 *
	 * @param array $params array with 'settings' item where 'settings' json-encoded string.
	 *
	 * @return Array - the results of the import operation
	 */
	public function import_settings($params) {
		if (empty($params['settings'])) {
			return array('errors' => array(__('Please upload a valid settings file.', 'wp-optimize')));
		}

		$settings = json_decode($params['settings'], true);

		// check if valid json file posted (requires PHP 5.3+)
		if ((function_exists('json_last_error') && 0 != json_last_error()) || empty($settings)) {
			return array('errors' => array(__('Please upload a valid settings file.', 'wp-optimize')));
		}

		$cache_settings = $settings['cache_settings'];
		$minify_settings = $settings['minify_settings'];
		$smush_settings = $settings['smush_settings'];
		$database_settings = $settings['database_settings'];

		$cache = WP_Optimize()->get_page_cache();
		$cache->create_folders();
		if ($cache_settings['enable_page_caching']) {
			$cache->enable();
		}

		$wpo_browser_cache = WP_Optimize()->get_browser_cache();
		if (isset($cache_settings['enable_browser_cache']) && $cache_settings['enable_browser_cache']) {
			$browser_cache = array(
				'browser_cache_expire_days' => $cache_settings['browser_cache_expire_days'],
				'browser_cache_expire_hours' => $cache_settings['browser_cache_expire_hours']
			);
			$wpo_browser_cache->enable_browser_cache_command_handler($browser_cache);
		}

		$message = '';
		$cache_result = WP_Optimize()->get_page_cache()->config->update($cache_settings);
		$minify_result = WP_Optimize()->get_minify()->minify_commands->save_minify_settings($minify_settings);
		$smush_result = WP_Optimize()->get_task_manager()->commands->update_smush_options($smush_settings);
		$webp_result = WP_Optimize()->get_task_manager()->commands->update_webp_options($smush_settings);
		$this->save_settings($database_settings);

		if (is_wp_error($cache_result)) {
			$message .= $cache_result->get_error_message() . PHP_EOL;
		}

		if (!$minify_result['success']) {
			$message .= isset($minify_result['message']) ? $minify_result['message'] . PHP_EOL : '';
			$message .= isset($minify_result['error']) ? $minify_result['error'] . PHP_EOL : '';
		}

		if (is_wp_error($smush_result)) {
			$message .= $smush_result->get_error_message() . PHP_EOL;
		}

		if (is_wp_error($webp_result)) {
			$message .= $webp_result->get_error_message() . PHP_EOL;
		}

		return array(
			'success' => true,
			'message' => empty($message) ? __('The settings were imported successfully.', 'wp-optimize') : $message
		);
	}

	/**
	 * Dismiss install or updated notice
	 *
	 * @return mixed
	 */
	public function dismiss_install_or_update_notice() {
		if (!is_a(WP_Optimize()->get_install_or_update_notice(), 'WP_Optimize_Install_Or_Update_Notice') || !is_callable(array(WP_Optimize()->get_install_or_update_notice(), 'dismiss'))) {
			return array('errors' => array('The notice could not be dismissed. The method "dismiss" on the object instance "install_or_update_notice" does not seem to exist.'));
		}

		if (!WP_Optimize()->get_install_or_update_notice()->dismiss()) {
			return array('errors' => array('The notice could not be dismissed. The settings could not be updated'));
		}

		return true;
	}

	/**
	 * Run images trash command.
	 */
	public function images_trash_command($params) {
		if (!class_exists('WP_Optimize_Images_Trash_Manager_Commands')) {
			return array(
				'errors' => array('WP_Optimize_Images_Trash_Manager_Commands class not found'),
			);
		}

		// get posted command.
		$trash_command = isset($params['images_trash_command']) ? $params['images_trash_command'] : '';
		// check if command is allowed.
		$allowed_commands = WP_Optimize_Images_Trash_Manager_Commands::get_allowed_ajax_commands();

		if (!in_array($trash_command, $allowed_commands)) {
			return array(
				'errors' => array('No such command found'),
			);
		}

		$results = call_user_func(array(WP_Optimize_Images_Trash_Manager()->commands, $trash_command), $params);

		if (is_wp_error($results)) {
			$results = array(
				'errors' => array($results->get_error_message()),
			);
		}

		return $results;
	}

	/**
	 * Power tweak handling
	 *
	 * @param array $params
	 * @return mixed
	 */
	public function power_tweak($params) {
		global $wp_optimize_premium;
		if (!is_a($wp_optimize_premium, 'WP_Optimize_Premium') || !property_exists($wp_optimize_premium, 'power_tweaks') || !isset($params['sub_action'])) return array(
			'errors' => array(__('No such command found', 'wp-optimize')),
		);
		
		$action = $params['sub_action'];
		$data = $params['data'] ? $params['data'] : array();
		if (!isset($data['tweak'])) return array(
			'errors' => array(__('No tweak provided', 'wp-optimize'))
		);

		$tweak = sanitize_title($data['tweak']);
		$pt = $wp_optimize_premium->power_tweaks;
		switch($action) {
			case 'activate':
				$result = $pt->activate($tweak);
				break;
			case 'deactivate':
				$result = $pt->deactivate($tweak);
				break;
			case 'run':
				$result = $pt->run($tweak);
				break;
		}
		if ($result && !is_wp_error($result)) {
			return is_array($result) ? array_merge(array('success' => true), $result) : array('success' => true, 'message' => $result);
		} else {
			// translators: %s is an action/command
			$error_message = is_wp_error($result) ? $result->get_error_message() : sprintf(__('The command %s failed', 'wp-optimize'), $action);
			return array(
				'success' => false,
				'errors' => array($error_message)
			);
		}
	}
	
	/**
	 * Ignores the table deletion warning for the current user
	 *
	 * @return array
	 */
	public function user_ignores_table_deletion_warning() {
		return array(
			'success' => update_user_meta(get_current_user_id(), 'wpo-ignores-table-deletion-warning', true)
		);
	}

	/**
	 * Ignores the post meta deletion warning for the current user
	 *
	 * @return array
	 */
	public function user_ignores_post_meta_deletion_warning() {
		return array(
			'success' => update_user_meta(get_current_user_id(), 'wpo-ignores-post-meta-deletion-warning', true)
		);
	}

	/**
	 * Ignores the orphaned relationship data deletion warning for the current user
	 *
	 * @return array
	 */
	public function user_ignores_orphaned_relationship_data_deletion_warning() {
		return array(
			'success' => update_user_meta(get_current_user_id(), 'wpo-ignores-orphaned-relationship-data-deletion-warning', true)
		);
	}

	/**
	 * Exports unused images as a CSV file to the `uploads` folder
	 *
	 * @return array
	 */
	public function export_csv() {
		WP_Optimization_images::instance()->output_csv();
		return array(
			'success' => true
		);
	}

	/**
	 * Build the HTML for the status report tab
	 *
	 * @return array
	 */
	public function generate_status_report() {
		$system_status = WP_Optimize_System_Status_Report::get_instance();
		$report_data = $system_status->generate_report();
		
		$html = WP_Optimize()->include_template('status/status-page-ajax.php', true, array(
			'report_data' => $report_data
		));
		
		return array(
			'success' => true,
			'html' => $html,
			'replaceable_md_tags' => $system_status->get_replaceable_md_tags()
		);
	}

	/**
	 * Gz compress text logs using `gzencode` to generate valid gzip files
	 *
	 * @return array
	 */
	public function generate_logs_zip() {
		$wpo_server_information = new WP_Optimize_Server_Information();

		$logs = $wpo_server_information->get_logs();

		$gz_available = function_exists('gzencode');
		$data = array();
		foreach ($logs as $path => $content) {
			if ($gz_available) {
				$log_content = gzencode($content);
				
				if (false === $log_content) {
					$log_content = $content;
					$gz_available = false;
				}
			} else {
				$log_content = $content;
			}
				
			$data[] = array(
				'src' => base64_encode($log_content),
				'name' => basename($path),
				'compressed' => $gz_available
			);
		}

		return array(
			'success' => true,
			'data' => $data
		);
	}
	
	/**
	 * Save images dimensions options
	 *
	 * @param array $settings Settings data
	 * @return array
	 */
	public function save_images_dimension_option($settings) {
		$options = WP_Optimize()->get_options();

		if (!empty($settings["images_dimensions"]) && "true" === $settings["images_dimensions"]) {
			$is_updated = $options->update_option('image_dimensions', 1);
		} else {
			$is_updated = $options->update_option('image_dimensions', 0);
		}

		if ($is_updated || $options->update_option('image_dimensions_ignore_classes', sanitize_text_field($settings['ignore_classes']))) {
			wpo_cache_flush();
		}

		return array(
			'success' => true
		);
	}
}
