<?php
if( ! class_exists( 'ITC_SVG_Upload_BaseController' ) ) {
	class ITC_SVG_Upload_BaseController{
		private $plugin_name_parent = 'ideastocode_module_settings';
		private $plugin_detail;

		function __construct() {

			$this->plugin_detail = array(
				'name'		=>'itc_svg_upload',
				'title'		=>'Enable SVG, WebP &amp; ICO Upload',
				'slug'		=>'itc-svg-upload',
				'version'	=> ( defined( 'ITC_SVG_UPLOAD_VERSION' ) ) ? ITC_SVG_UPLOAD_VERSION: '1.0.0',
				'settings'	=>'itc_svg_upload_settings',
			);
		}

		public function register_Module($plugin_name, $plugin_details){
            $plugins = get_option($this->plugin_name_parent);

            if($plugin_name!== "" &&  isset($plugins[$plugin_name])){
                $finalModuleDetails = array_merge($plugins[$plugin_name], $plugin_details);
            }else{
                $finalModuleDetails = $plugin_details;
            }
            $plugins[$plugin_name] = $finalModuleDetails;
            update_option($this->plugin_name_parent, $plugins);
        }
        
        public function unregister_Module($plugin_name){
            $plugins = get_option($this->plugin_name_parent);
            if($plugin_name!== "" && isset($plugins[$plugin_name])){
                unset($plugins[$plugin_name]);
                update_option($this->plugin_name_parent, $plugins);
            }
        }
        
        public function uninstall_Module($plugin_name){
            $this->unregister_Module($plugin_name);
            //ALSO IF WE WANT TO DEL ANY MODULE SETTINGS ADD HERE.
        }
        
        public function get_Module($plugin_name = ""){
            $plugins = get_option($this->plugin_name_parent);
            if($plugin_name!== "" && isset($plugins[$plugin_name])){
                return $plugins[$plugin_name];
            }
            return [];
        }

		public function get_plugin_detail() {
			return $this->plugin_detail;
		}

		public function get_plugin_name() {
			$detail = $this->get_plugin_detail();
			return $detail['name'];
		}

		public function get_plugin_title() {
			$detail = $this->get_plugin_detail();
			return $detail['title'];
		}
		
		public function get_plugin_slug() {
			$detail = $this->get_plugin_detail();
			return $detail['slug'];
		}

		public function get_version() {
			$detail = $this->get_plugin_detail();
			return $detail['version'];
		}
		
		public function get_settings() {
			$detail = $this->get_plugin_detail();
			return $detail['settings'];
		}


		public function get_option_default($key=""){
			$default = array(
				"svg"=>1,
				"webp"=>1,
				"ico"=>1,
			);
			if($key!=="" && isset($default[$key])){
				$result = ($default[$key] == "1") ? 1 : 0;
				return $result;
			}
			return $default;
		}

		public function get_option($key=""){
			$defaultSettings = $this->get_option_default();
			$settings = get_option($this->get_settings(), $defaultSettings);
			if(isset($settings[$key])){
				return $settings[$key];
			}
			return $settings;
		}
		
		//This is to display msg after plugin activation.
		public function set_transient(){
			$notice_dismiss_index = $this->get_settings()."_notice_dismiss";
			set_transient( $notice_dismiss_index, true, 5 ); //This is for notice to show only once the plugin is activated.
		}
		public function get_transient(){
			$notice_dismiss_index = $this->get_settings()."_notice_dismiss";
			return get_transient( $notice_dismiss_index );
		}
		public function remove_transient(){
			$notice_dismiss_index = $this->get_settings()."_notice_dismiss";
			delete_transient( $notice_dismiss_index );
		}
		
		//This is to display msg after plugin activation.
		public function set_transient_alert(){
			$notice_dismiss_index = $this->get_settings()."_notice_dismiss_alert";
			set_transient( $notice_dismiss_index, 1); //This is for notice to show only once the plugin is activated.
		}
		public function get_transient_alert(){
			$notice_dismiss_index = $this->get_settings()."_notice_dismiss_alert";
			return get_transient( $notice_dismiss_index );
		}
		public function remove_transient_alert(){
			$notice_dismiss_index = $this->get_settings()."_notice_dismiss_alert";
			set_transient( $notice_dismiss_index, 9 ); //This is for notice to show user has intensionally remove alert.
			// delete_transient( $notice_dismiss_index );
		}
	}
}