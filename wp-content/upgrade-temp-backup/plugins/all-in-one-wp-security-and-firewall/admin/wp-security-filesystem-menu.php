<?php
if (!defined('ABSPATH')) {
	exit; // Prevent direct access to file
}
class AIOWPSecurity_Filesystem_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Filesystem menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_FILESYSTEM_MENU_SLUG;
	
	/**
	 * Constructor adds menu for Filesystem security
	 */
	public function __construct() {
		parent::__construct(__('File security', 'all-in-one-wp-security-and-firewall'));
		add_action('admin_footer', array($this, 'filesystem_menu_footer_code'));
	}
	
	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'file-permissions' => array(
				'title' => __('File permissions', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_file_permissions'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'file-protection' => array(
				'title' => __('File protection', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_file_protection'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'host-system-logs' => array(
				'title' => __('Host system logs', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_host_system_logs'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'copy-protection' => array(
				'title' => __('Copy protection', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_copy_protection'),
			),
			'frames' => array(
				'title' => __('Frames', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_frames'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's file permissions tab
	 *
	 * @return Void
	 */
	protected function render_file_permissions() {
		// if this is the case there is no need to display a "fix permissions" button
		global $aio_wp_security, $aiowps_feature_mgr;
		
		$files_dirs_to_check = AIOWPSecurity_Utility_File::get_files_and_dirs_to_check();


		$aio_wp_security->include_template('wp-admin/filesystem-security/file-permissions.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'files_dirs_to_check' => $files_dirs_to_check, 'file_utility' => new AIOWPSecurity_Utility_File()));
	}

	/**
	 * Renders the submenu's 'File protection' tab
	 *
	 * @return void
	 */
	protected function render_file_protection() {
		global $aio_wp_security;

		$show_disallow_file_edit_warning = defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT && '1' != $aio_wp_security->configs->get_value('aiowps_disable_file_editing');

		$aio_wp_security->include_template('wp-admin/filesystem-security/file-protection.php', false, array('show_disallow_file_edit_warning' => $show_disallow_file_edit_warning));
	}

	/**
	 * Renders the submenu's copy protection tab
	 *
	 * @return Void
	 */
	protected function render_copy_protection() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/filesystem-security/copy-protection.php', false, array());
	}

	/**
	 * Renders the submenu's render frames tab
	 *
	 * @return Void
	 */
	protected function render_frames() {
		global $aio_wp_security;

		$aio_wp_security->include_template('wp-admin/filesystem-security/frames.php', false, array());
	}

	/**
	 * Renders the submenu's host system logs tab
	 *
	 * @return Void
	 */
	protected function render_host_system_logs() {
		global $aio_wp_security;
		$sys_log_file = basename($aio_wp_security->configs->get_value('aiowps_system_log_file'));
		$aio_wp_security->include_template('wp-admin/filesystem-security/host-system-logs.php', false, array('sys_log_file' => $sys_log_file));
	}
	
	/**
	 * Called via filter admin_footer, this adds the needed javascript to page
	 *
	 * @return void
	 */
	public function filesystem_menu_footer_code() {
		?>
		<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(function($) {
					loading_span = $('.aiowps_loading_1');
					loading_span.hide(); //hide the spinner gif after page has successfully loaded
					$('.search-error-files').on("click",function(){
						loading_span.show();
					});
			});
			
			function set_file_permission_tochange(path, recommended) {
				jQuery('#aiowps_permission_chg_file').val(path);
				jQuery('#aiowps_recommended_permissions').val(recommended);
				return true;
			}
			/* ]]> */
		</script>
		 <?php
	}
}
