<?php
class ITC_SVG_Upload_Deactivator extends ITC_SVG_Upload_BaseController {

	public function __construct() {
		parent::__construct();// call parent constructor
	}

	public function deactivate() {
		$this->unregister_Module($this->get_plugin_name());
		$this->remove_transient();
	}

}
