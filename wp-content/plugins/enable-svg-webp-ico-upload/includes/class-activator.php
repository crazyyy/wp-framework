<?php
class ITC_SVG_Upload_Activator extends ITC_SVG_Upload_BaseController{
	public function __construct() {
		parent::__construct();// call parent constructor
	}

	public function activate() {
		//1. register register_Module
		$this->register_Module($this->get_plugin_name(), $this->get_plugin_detail());
		//set the default values here. before save check if value exist?
		$defaultSetting =$this->get_option_default();
		if(get_option($this->get_settings()) === false){
			add_option($this->get_settings(), $defaultSetting);
			$this->set_transient(); //This is for notice to show only once the plugin is activated.
		}
	}
}
