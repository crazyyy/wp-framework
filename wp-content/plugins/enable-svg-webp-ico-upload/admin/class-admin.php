<?php
if ( ! is_admin() ) {
	return;
}
class ITC_SVG_Upload_Admin extends ITC_SVG_Upload_BaseController{

	public function __construct() {
		parent::__construct();
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'itc-svg-upload-admin-css', plugin_dir_url( __FILE__ ) . 'css/itc-admin.css', array(), $this->get_version(), 'all' );
	}

	
	public function enqueue_scripts() {
		wp_register_script( 'itc-svg-upload-admin-js', plugin_dir_url( __FILE__ ) . 'js/itc-admin.js',array('jquery'),$this->get_version(), false );
        wp_localize_script( 'itc-svg-upload-admin-js', 'ITC_SVG_Upload_Admin', array(
            'ajaxurl' => get_admin_url() . 'admin-ajax.php', 
        ));
		wp_enqueue_script(  'itc-svg-upload-admin-js' );

	}

	public function itc_svg_upload_action_links( $links ) {
		$plugin_slug_name = $this->get_plugin_slug();
		$subpage="";
		$links2 = '<a href="'. menu_page_url( $plugin_slug_name, false ).$subpage .'">Settings</a>';
		array_unshift($links, $links2);
		return $links;
	}

	public function add_options_page(){
		global $admin_page_hooks;
		$plugin_slug_name = $this->get_plugin_slug();
		$plugin_title = $this->get_plugin_title();
		//add_options_page
		if ( empty ( $admin_page_hooks[$plugin_slug_name] ) ){
			add_menu_page( 
				__( $plugin_title, $plugin_slug_name ),
				__( $plugin_title, $plugin_slug_name ),
				'manage_options',
				$plugin_slug_name,
				array( $this, 'itc_svg_upload_option_page' ),
				'dashicons-images-alt2'
			);
		}
	}

	public function itc_svg_upload_option_page() {
		include_once 'partials/admin-display.php';
	}

	public function general_admin_notice(){
		if( $this->get_transient() ){
			$this->remove_transient();
			include_once 'partials/admin-notice.php';
		}
		$alert = $this->get_transient_alert();
		$showAlert = false;
		if( $alert ===false ){ //hasn't inserted so fresh
			$this->set_transient_alert();
			$showAlert = true;
		}else if($alert === "1"){ //alert is set show
			$showAlert = true;
		}
		if($showAlert){
			include_once 'partials/admin-notice-alert.php';
		}
		
	}

	
	public function itc_svg_upload_dismissed(){
		$this->remove_transient();
		die("1");
	}
	
	public function itc_svg_upload_dismissed_alert(){
		$this->remove_transient_alert();
		die("1");
	}

	public function register_setting(){
		$setting_slug = $this->get_settings();
		register_setting( $setting_slug."_option_group",  $setting_slug, 
			array(
				'sanitize_callback'	=> array($this, 'form_submit_sanitize')
			) 
		);
	}

	public function form_submit_sanitize( $settings ) {
		$finalSettings = $this->get_option_default();
		$finalSettings['svg'] = $this->form_submit_sanitize_bool($settings, 'svg');
		$finalSettings['webp'] = $this->form_submit_sanitize_bool($settings, 'webp');
		$finalSettings['ico'] = $this->form_submit_sanitize_bool($settings, 'ico');

		$setting_slug = $this->get_settings();
		add_settings_error(
			$setting_slug."_option_group",
			$setting_slug."_option_name",
			"Setting successfully updated.",
			"updated"
		);

		return $finalSettings;
	}

	private function form_submit_sanitize_bool( $settings, $key) { 
		if(isset($settings[$key]) && $settings[$key]=="1") {
			return 1;
		}
		return 0;
	}	
} 