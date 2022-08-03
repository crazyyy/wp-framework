<?php
class ITC_SVG_Upload extends ITC_SVG_Upload_BaseController {
	protected $loader;
	
	public function __construct() {
		parent::__construct();// call parent constructor
		
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_common_hooks();

	}

	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-public.php';

		$this->loader = new ITC_SVG_Upload_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new ITC_SVG_Upload_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_common_hooks() {
		$settings = $this->get_option();
		// for svg
		if(isset($settings['svg']) && $settings['svg'] === 1){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-svg.php';
			$plugin_svg = new ITC_SVG_Upload_Svg();
			$this->loader->add_action( 'admin_init', $plugin_svg, 'add_svg_support' );
			$this->loader->add_action( 'admin_footer', $plugin_svg, 'fix_svg_thumbnail_size' );
			$this->loader->add_filter( 'upload_mimes',  $plugin_svg, 'add_svg_mime' );
			$this->loader->add_filter( 'wp_check_filetype_and_ext',  $plugin_svg, 'wp_check_filetype_and_ext', 100, 4 );
			$this->loader->add_filter( 'wp_generate_attachment_metadata', $plugin_svg, 'wp_generate_attachment_metadata', 10, 2 );
			$this->loader->add_filter( 'fl_module_upload_regex', $plugin_svg, 'fl_module_upload_regex', 10, 4 );

		}
		
		// for webp
		if(isset($settings['webp']) && $settings['webp'] === 1){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-webp.php';
			$plugin_webp = new ITC_SVG_Upload_Webp();
			$this->loader->add_filter( 'wp_check_filetype_and_ext', $plugin_webp, 'webp_file_ext', 10, 4 );
			$this->loader->add_filter( 'upload_mimes', $plugin_webp, 'webp_file_upload' );
			$this->loader->add_filter('file_is_displayable_image', $plugin_webp, 'preview_webp_thumnail', 10, 2);
		}

		// for ico
		if(isset($settings['ico']) && $settings['ico'] === 1){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ico.php';
			$plugin_ico = new ITC_SVG_Upload_Ico();
			$this->loader->add_filter( 'wp_check_filetype_and_ext', $plugin_ico, 'upload_ico_files', 10, 4 );
			$this->loader->add_filter( 'upload_mimes', $plugin_ico, 'ico_files' );
		}
	}

	private function define_admin_hooks() {

		$plugin_admin = new ITC_SVG_Upload_Admin();
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action("admin_menu", $plugin_admin, 'add_options_page');
		$this->loader->add_action("admin_init", $plugin_admin, 'register_setting');
		$this->loader->add_filter("plugin_action_links_".ITC_SVG_UPLOAD_BASENAME , $plugin_admin, 'itc_svg_upload_action_links');
		$this->loader->add_action("wp_ajax_itc_svg_upload_dismissed", $plugin_admin, 'itc_svg_upload_dismissed');
		$this->loader->add_action("wp_ajax_itc_svg_upload_dismissed_alert", $plugin_admin, 'itc_svg_upload_dismissed_alert');
		$this->loader->add_action("admin_notices", $plugin_admin, 'general_admin_notice');

	}

	private function define_public_hooks() {

		$plugin_public = new ITC_SVG_Upload_Public();
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	public function run() {
		$this->loader->run();
	}

	public function get_loader() {
		return $this->loader;
	}
}
