<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Feature_Item {
	
	public $feature_id; // Example "user-accounts-tab1-change-admin-user"

	public $feature_name;

	public $item_points;

	public $security_level; // 1, 2, 3
	
	public $feature_status; // active, inactive, partial

	public $feature_options; // The database options to check if the feature is enabled or not

	public $callback;

	/**
	 * Constructor sets up the feature item
	 *
	 * @param string  $feature_id      - the id of the feature
	 * @param string  $feature_name    - the name of the feature
	 * @param string  $item_points     - the points this feature is worth
	 * @param string  $security_level  - the level of the feature
	 * @param array   $feature_options - the options the feature uses
	 * @param boolean $callback        - callback to set feature active status
	 */
	public function __construct($feature_id, $feature_name, $item_points, $security_level, $feature_options, $callback) {
		$this->feature_id = $feature_id;
		$this->feature_name = $feature_name;
		$this->item_points = $item_points;
		$this->security_level = $security_level;
		$this->feature_options = $feature_options;
		$this->callback = $callback;
	}
	
	/**
	 * This function will set the status of the feature
	 *
	 * @param string $status - the status of the feature
	 *
	 * @return void
	 */
	public function set_feature_status($status) {
		$this->feature_status = $status;
	}
	
	/**
	 * This function will return the string version of the level
	 *
	 * @return string - the string value of the level
	 */
	public function get_security_level_string() {
		$level_string = "";
		if ("1" == $this->security_level) {
			$level_string = __('Basic', 'all-in-one-wp-security-and-firewall');
		} elseif ("2" == $this->security_level) {
			$level_string = __('Intermediate', 'all-in-one-wp-security-and-firewall');
		} elseif ("3" == $this->security_level) {
			$level_string = __('Advanced', 'all-in-one-wp-security-and-firewall');
		}
		return $level_string;
	}

	/**
	 * This function will return a boolean to indicate if the feature is on or not
	 *
	 * @return boolean - true if the feature is on otherwise false
	 */
	public function is_active() {
		return ('active' == $this->feature_status);
	}

}
