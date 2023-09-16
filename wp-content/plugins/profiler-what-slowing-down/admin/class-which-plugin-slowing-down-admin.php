<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://swit.hr
 * @since      1.0.0
 *
 * @package    Which_Plugin_Slowing_Down
 * @subpackage Which_Plugin_Slowing_Down/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Which_Plugin_Slowing_Down
 * @subpackage Which_Plugin_Slowing_Down/admin
 * @author     SWIT <sandi@swit.hr>
 */
class Which_Plugin_Slowing_Down_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Which_Plugin_Slowing_Down_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Which_Plugin_Slowing_Down_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/which-plugin-slowing-down-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Which_Plugin_Slowing_Down_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Which_Plugin_Slowing_Down_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/which-plugin-slowing-down-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
	 * Admin Page Display
	 */
	public function admin_page_display_index() {

        include_once WHICH_PLUGIN_SLOWING_DOWN_VERSION_PATH.'views/index.php';

	}

    /**
     * To add Plugin Menu and Settings page
     */
    public function plugin_menu() {

        ob_start();

        add_submenu_page('tools.php', 
                    esc_html__('Profiler What Slowing Down', 'profiler-what-slowing-down'), 
                    esc_html__('Profiler What Slowing Down', 'profiler-what-slowing-down'), 
                    'manage_options', 'profiler_what_slowing_down', 
                    array($this, 'admin_page_display_index'));

	
    }

}

?>